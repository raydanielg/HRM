<?php

namespace App\Http\Controllers\Admin;

use App\Classes\Reply;
use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\Admin\Holiday\DeleteRequest;
use App\Http\Requests\Admin\Holiday\UpdateRequest;
use App\Models\Holiday;
use App\Models\HolidaysList;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;


class HolidaysController extends AdminBaseController
{


    public function __construct()
    {
        parent::__construct();
        $this->holidayOpen = 'active';
        $this->hrMenuActive = 'active';
        $this->pageTitle = trans("pages.holidays.indexTitle");

        $year = ((Input::get('year'))) ? Input::get('year') : Carbon::now()->year;


        $month = [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
            "August",
            "September",
            "October",
            "November",
            "December"
        ];

        $this->year = $year;
        $this->months = $month;
        $this->currentMonth = Carbon::now()->format("F");
    }

    public function index($year = null)
    {
        $year = (isset($year)) ? $year : date("Y");

        $this->current_year = $year;
        Session::put('year', $year);

        $this->holidays = Holiday::whereRaw('YEAR(date) = ?', array($year))->orderBy('date', 'ASC')->get();
        $this->holidays_list = HolidaysList::whereRaw('YEAR(date) = ?', array($year))
            ->where("country", admin()->company->country)
            ->orderBy('date', 'ASC')
            ->get();

        $this->holidayActive = 'active';
        $hol = [];


        $dateArr = $this->getDateForSpecificDayBetweenDates($year . '-01-01', $year . '-12-31', 0);
        $dateSatArr = $this->getDateForSpecificDayBetweenDates($year . '-01-01', $year . '-12-31', 6);
        $dateFriArr = $this->getDateForSpecificDayBetweenDates($year . '-01-01', $year . '-12-31', 5);

        $sat_sun = Holiday::selectRaw('SUM(IF(WEEKDAY(date) = 6,1,0)) as sun,
									SUM(IF(WEEKDAY(date) = 5, 1, 0)) as sat,
									SUM(IF(WEEKDAY(date) = 4, 1, 0)) as fri
									')->whereRaw('YEAR(date) = ?', array($year))->first();

        $this->number_of_sundays = count($dateArr);
        $this->number_of_saturdays = count($dateSatArr);
        $this->number_of_fridays = count($dateSatArr);
        $this->number_of_sat_db = $sat_sun['sat'];
        $this->number_of_sun_db = $sat_sun['sun'];
        $this->number_of_fri_db = $sat_sun['fri'];
        $this->holidays_in_db = count($this->holidays);

        // Send holidays list
        $this->data["all_sundays"] = $dateArr;
        $this->data["all_saturdays"] = $dateSatArr;
        $this->data["all_fridays"] = $dateFriArr;


        foreach ($this->holidays as $holiday) {
            $hol[date('F', strtotime($holiday->date))]['id'][] = $holiday->id;
            $hol[date('F', strtotime($holiday->date))]['date'][] = date('d F Y', strtotime($holiday->date));
            $hol[date('F', strtotime($holiday->date))]['ocassion'][] = $holiday->occassion;
            $hol[date('F', strtotime($holiday->date))]['day'][] = date('D', strtotime($holiday->date));
        }

        $this->holidaysArray = $hol;

        return View::make('admin.holidays.index', $this->data);
    }

    /**
     * Show the form for creating a new holiday
     *
     * @return Response
     */
    public function create()
    {
        return View::make('admin.holidays.create');
    }

    /**
     * Store a newly created holiday in storage.
     *
     * @return Response
     */
    public function store(UpdateRequest $request)
    {
        Cache::forget('holiday_cache');
        $input = Input::all();

        $year = \Session::get("year");

        $holiday = array_combine($input['date'], $input['occasion']);

        \DB::beginTransaction();

        // Add custom holidays
        foreach ($holiday as $index => $value) {
            if ($index == '') {
                continue;
            }

            $add = Holiday::firstOrCreate(['date' => date('Y-m-d', strtotime($index)),
                'company_id' => $this->company_id

            ]);

            $holi = Holiday::find($add->id);
            $holi->occassion = $value;
            $holi->save();
        }

        if (isset($input["holidays_list"])) {
            $holidays_list = $input["holidays_list"];

            // Add selected holidays
            foreach ($holidays_list as $holiday_item) {
                $item = explode("|", $holiday_item);

                $holi = Holiday::firstOrCreate(['date' => $item[0],
                    'company_id' => $this->company_id

                ]);

                $holi->occassion = $item[1];
                $holi->save();
            }
        }

        if (isset($input["removedHolidays"])) {

            // Remove holidays
            $removedHolidays = explode("~", $input["removedHolidays"]);

            foreach ($removedHolidays as $removedHoliday) {
                $item = explode("|", $removedHoliday);

                $holi = Holiday::where("date", $item[0])->where("company_id", $this->company_id)->first();

                if ($holi) {
                    $holi->delete();
                }
            }
        }

        \DB::commit();

        return Reply::redirect(route('admin.holidays.index'), 'messages.holidayAddMessage');

    }

    /**
     * Display the specified holiday.
     */
    public function show($id)
    {
        $holiday = Holiday::findOrFail($id);

        return View::make('admin.holidays.show', compact('holiday'));
    }

    /**
     * Show the form for editing the specified holiday.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $holiday = Holiday::find($id);

        return View::make('admin.holidays.edit', compact('holiday'));
    }

    /**
     * Update the specified holiday in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update(UpdateRequest $request, $id)
    {
        Cache::forget('holiday_cache');
        $holiday = Holiday::findOrFail($id);

        $data = Input::all();

        $holiday->update($data);

        return Redirect::route('admin.holidays.index');
    }

    /**
     * Remove the specified holiday from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy(DeleteRequest $request, $id)
    {

        Holiday::destroy($id);
        $output['success'] = 'deleted';

        Cache::forget('holiday_cache');

        return Reply::success('Successfully deleted');
    }

    public function Sunday()
    {
        Cache::forget('holiday_cache');

        $year = session('year');
        $dateArr = $this->getDateForSpecificDayBetweenDates($year . '-01-01', $year . '-12-31', 0);

        \DB::beginTransaction();
        foreach ($dateArr as $date) {
            $holi = Holiday::firstOrCreate(['date' => $date,
                'company_id' => $this->company_id]);
            $update = Holiday::find($holi->id);
            $update->occassion = trans('core.officeOff');
            $update->save();
        }
        \DB::commit();

        return Redirect::route('admin.holidays.change_year', [$year])
            ->with('success', trans("messages.holidayDayMessage", ["day" => trans("core.sunday")]));
    }

    public function Saturday()
    {
        Cache::forget('holiday_cache');

        $year = session('year');
        $dateArr = $this->getDateForSpecificDayBetweenDates($year . '-01-01', $year . '-12-31', 6);

        \DB::beginTransaction();
        foreach ($dateArr as $date) {
            $holi = Holiday::firstOrCreate(['date' => $date,
                'company_id' => $this->company_id]);
            $update = Holiday::find($holi->id);
            $update->occassion = trans('core.officeOff');
            $update->save();
        }
        \DB::commit();

        return Redirect::route('admin.holidays.change_year', [$year])
            ->with('success', trans("messages.holidayDayMessage", ["day" => trans("core.saturday")]));
    }

    public function Friday()
    {
        Cache::forget('holiday_cache');

        $year = session('year');
        $dateArr = $this->getDateForSpecificDayBetweenDates($year . '-01-01', $year . '-12-31', 5);

        \DB::beginTransaction();
        foreach ($dateArr as $date) {
            $holi = Holiday::firstOrCreate(['date' => $date,
                'company_id' => $this->company_id]);
            $update = Holiday::find($holi->id);
            $update->occassion = trans('core.officeOff');
            $update->save();
        }
        \DB::commit();

        return Redirect::route('admin.holidays.change_year', [$year])
            ->with('success', trans("messages.holidayDayMessage", ["day" => trans("core.friday")]));
    }


    public function getDateForSpecificDayBetweenDates($startDate, $endDate, $weekdayNumber)
    {
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);

        $dateArr = [];

        do {
            if (date("w", $startDate) != $weekdayNumber) {
                $startDate += (24 * 3600); // add 1 day
            }
        } while (date("w", $startDate) != $weekdayNumber);


        while ($startDate <= $endDate) {
            $dateArr[] = date('Y-m-d', $startDate);
            $startDate += (7 * 24 * 3600); // add 7 days
        }

        return ($dateArr);
    }

    public function change_year($year)
    {
        Session::put('year', $year);
        $this->holidays = Holiday::whereRaw('YEAR(date) = ?', array($year))->orderBy('date', 'ASC')->get();;
        $this->holidayActive = 'active';
        $hol = [];

        //$year       = date("Y");
        $dateArr = $this->getDateForSpecificDayBetweenDates($year . '-01-01', $year . '-12-31', 0);
        $dateSatArr = $this->getDateForSpecificDayBetweenDates($year . '-01-01', $year . '-12-31', 6);

        $sat_sun = Holiday::selectRaw('SUM(IF(WEEKDAY(date) = 6,1,0)) as sun,
									SUM(IF(WEEKDAY(date) = 5, 1, 0)) as sat,
									SUM(IF(WEEKDAY(date) = 4, 1, 0)) as fri
									')->whereRaw('YEAR(date) = ?', array($year))->first();


        $this->number_of_sundays = count($dateArr);
        $this->number_of_saturdays = count($dateSatArr);
        $this->number_of_fridays = count($dateSatArr);
        $this->number_of_sat_db = $sat_sun['sat'];
        $this->number_of_sun_db = $sat_sun['sun'];
        $this->number_of_fri_db = $sat_sun['fri'];
        $this->holidays_in_db = count($this->holidays);

        foreach ($this->holidays as $holiday) {
            $hol[date('F', strtotime($holiday->date))]['id'][] = $holiday->id;
            $hol[date('F', strtotime($holiday->date))]['date'][] = date('d F Y', strtotime($holiday->date));
            $hol[date('F', strtotime($holiday->date))]['ocassion'][] = $holiday->occassion;
            $hol[date('F', strtotime($holiday->date))]['day'][] = date('D', strtotime($holiday->date));
        }

        $this->holidaysArray = $hol;

        return View::make('admin.holidays.index', $this->data);
    }

    public function removeAllWeekendHolidays()
    {
        $year = session('year');
        $sunDateArr = $this->getDateForSpecificDayBetweenDates($year . '-01-01', $year . '-12-31', 0);
        $satDateArr = $this->getDateForSpecificDayBetweenDates($year . '-01-01', $year . '-12-31', 6);
        $friDateArr = $this->getDateForSpecificDayBetweenDates($year . '-01-01', $year . '-12-31', 5);

        foreach ($sunDateArr as $sun_date) {
            $del_sun_date = Holiday::where('date', '=', $sun_date)->first();
            if (sizeof($del_sun_date)) {
                $del_sun_date->delete();
            }
        }
        foreach ($satDateArr as $sat_date) {
            $del_sat_date = Holiday::where('date', '=', $sat_date)->first();
            if (sizeof($del_sat_date)) {
                $del_sat_date->delete();
            }
        }
        foreach ($friDateArr as $date) {
            $del_date = Holiday::where('date', '=', $date)->first();
            if (sizeof($del_date)) {
                $del_date->delete();
            }
        }
        return Redirect::route('admin.holidays.change_year', [$year])
            ->with('success', trans("messages.holidayDayMessage", ["day" => trans("core.removeAllFriSatSun")]));
    }


}
