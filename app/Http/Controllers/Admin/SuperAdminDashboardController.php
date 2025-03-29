<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use App\Models\Company;

use GuzzleHttp\Client;
use App\Models\Invoice;
use App\Models\License;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class SuperAdminDashboardController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->superadmindashboardActive = 'active';
        $this->pageTitle = 'Super Admin Dashboard';

        $this->middleware(function ($request, $next) {
            if (admin()->type != 'superadmin') {
                echo View::make('admin.errors.noaccess', $this->data);
                exit;
            }
            return $next($request);
        });


    }

    // Dashboard view page   controller
    public function index()
    {

        admin()->company_count = Company::where('status', 'active')->count();
        $this->inactive_company_count = Company::where('status', 'inactive')->count();
        $company_list = Company::select('companies.id', 'logo', 'company_name', 'country', 'companies.created_at', 'companies.active', 'companies.status', 'last_login', 'active as ab')
            ->leftjoin('admins', 'admins.company_id', '=', 'companies.id')
            ->groupBy('companies.id')
            ->orderBy('last_login', 'desc')
            ->whereDate('companies.created_at', '<', 'last_login')
            ->whereRaw("last_login>=DATE(NOW()) - INTERVAL 7 DAY")->get();

        if ($company_list) {
            foreach ($company_list as $data) {
                $data['last_in_words'] = Carbon::createFromFormat('Y-m-d H:i:s', $data->last_login->format('Y-m-d H:i:s'))->diffForHumans();
            }
        }

        $this->company_lists = $company_list;


        $date = carbon::now();
        $this->monthName = date("F", mktime(0, 0, 0, $date->month, 10));
        $firstDate = Carbon::createFromDate($date->year, $date->month, 1);
        $this->data['days'] = [];
        $this->data['graph_data'][0] = 0;
        while ($firstDate->month === $date->month) {
            array_push($this->data['days'], $firstDate->format('Y-m-d'));
            array_push($this->data['graph_data'], 0);
            $firstDate->addDay(1);
        }

        $company_count = Company::select(DB::raw('Date(companies.created_at) as date , Count(companies.created_at) as count'))->whereIn(DB::raw('DATE(companies.created_at)'), $this->data['days'])->groupBy(DB::raw('DATE(companies.created_at)'))->get()->toArray();
        foreach ($company_count as $co) {
            $key = array_search($co["date"], $this->data['days']);
            if ($key != false) {
                $this->data['graph_data'][$key + 1] = $co["count"];
            }
        }
        if (max($this->data['graph_data']) == 0) {
            foreach ($this->data['graph_data'] as $key => $graph_data) {
                $this->data['graph_data'][$key] = '';
            }
        }

        // this week results
        $fromDate = Carbon::now()->subDay()->startOfWeek()->toDateString(); // or ->format(..)
        $tillDate = Carbon::now()->subDay()->toDateString();

        $this->license_expire = License::select(DB::raw('count("employees.id") as count'), 'companies.company_name', 'companies.logo', 'licenses.expires_on', 'companies.id', 'employees.created_at as cr')
            ->rightJoin('companies', 'licenses.company_id', '=', 'companies.id')
            ->rightJoin('employees', 'employees.company_id', '=', 'companies.id')
            ->rightJoin('admins', 'admins.company_id', '=', 'companies.id')
            ->groupBy('companies.id')
            ->having('count', '>', $this->freeUsers)
            ->whereBetween(DB::raw('date(admins.last_login)'), [$fromDate, $tillDate])
            ->get()->toArray();

        $license = $this->license_expire;
        foreach ($this->license_expire as $key => $licence) {
            $x = Carbon::parse($licence['expires_on']);
            $license[$key]['expires_on'] = $x->format('d M Y');
        }
        $this->license_expire = $license;
        $total = Transaction::selectRaw('SUM(amount) as sum,currency_code')
            ->groupBy('currency_code')
            ->where('currency_code', '<>', '')
            ->join('licenses', 'licenses.license_number', '=', 'transactions.license_number')
            ->join('license_types', 'license_types.id', '=', 'licenses.license_type_id')
            ->whereIn('payment_status', ['approved', 'authorized', 'success'])
            ->get()->toArray();
        $sum = 0;
        foreach ($total as $tot) {
            $sum += Transaction::convertAmount($tot['sum'], $tot['currency_code']);
        }

        $this->total_earning = $sum;

        $total = Transaction::selectRaw('SUM(amount) as sum,currency_code')
            ->groupBy('currency_code')
            ->where('currency_code', '<>', '')
            ->where('license_types.type', '=', 'Cloud')
            ->join('licenses', 'licenses.license_number', '=', 'transactions.license_number')
            ->join('license_types', 'license_types.id', '=', 'licenses.license_type_id')
            ->whereIn('payment_status', ['approved', 'authorized', 'success'])
            ->get()->toArray();
        $sum = 0;
        foreach ($total as $tot) {
            $sum += Transaction::convertAmount($tot['sum'], $tot['currency_code']);
        }
        $this->cloud = $sum;

        $total = Transaction::selectRaw('SUM(amount) as sum,currency_code')
            ->groupBy('currency_code')
            ->where('currency_code', '<>', '')
            ->where('license_types.type', '=', 'Multi-Company')
            ->join('licenses', 'licenses.license_number', '=', 'transactions.license_number')
            ->join('license_types', 'license_types.id', '=', 'licenses.license_type_id')
            ->whereIn('payment_status', ['approved', 'authorized', 'success'])
            ->get()->toArray();
        $sum = 0;
        foreach ($total as $tot) {
            $sum += Transaction::convertAmount($tot['sum'], $tot['currency_code']);
        }
        $this->multi = $sum;


        $total = Transaction::selectRaw('SUM(amount) as sum,currency_code')
            ->groupBy('currency_code')
            ->where('currency_code', '<>', '')
            ->where('license_types.type', '=', 'On-Premise')
            ->join('licenses', 'licenses.license_number', '=', 'transactions.license_number')
            ->join('license_types', 'license_types.id', '=', 'licenses.license_type_id')
            ->whereIn('payment_status', ['approved', 'authorized', 'success'])
            ->get()->toArray();
        $sum = 0;
        foreach ($total as $tot) {
            $sum += Transaction::convertAmount($tot['sum'], $tot['currency_code']);
        }
        $this->onpremise = $sum;

        $earning = $this->createEarningReport(date("Y"));

        $this->earning = $earning['earningReport'];

        $years = Invoice::select(DB::raw("YEAR(invoice_date) as year"))->groupBy('year')->get();

        $filter[date("Y")] = date("Y");
        foreach ($years as $year) {
            $filter[$year->year] = $year->year;
        }
        krsort($filter);

        $this->earningYearFilter = $filter;

        $this->currency = is_null($this->setting->currency) ? 'USD' : $this->setting->currency;
        $this->currency_symbol = is_null($this->setting->currency_symbol) ? '$' : $this->setting->currency_symbol;

        return View::make('admin/dashboard/dashboard_superadmin', $this->data);
    }

    /**
     * Create A yearly report for Earning
     * @param $year
     */
    public function createEarningReport($year)
    {
//        dd($year);
        //Current USD Values in INR
        $currentUsdValueInINR = 65;

        //Select records form invoices where status equal to paid
        $earnings = DB::select(DB::raw("SELECT sum(CASE WHEN currency = 'INR' THEN amount/$currentUsdValueInINR ELSE amount END) as sum, m.months,u.status
        FROM `invoices` u
        RIGHT JOIN (
                  SELECT 1 AS `months`
                  UNION SELECT 2 AS `months`
                  UNION SELECT 3 AS `months`
                  UNION SELECT 4 AS `months`
                  UNION SELECT 5 AS `months`
                  UNION SELECT 6 AS `months`
                  UNION SELECT 7 AS `months`
                  UNION SELECT 8 AS `months`
                  UNION SELECT 9 AS `months`
                  UNION SELECT 10 AS `months`
                  UNION SELECT 11 AS `months`
                  UNION SELECT 12 AS `months`
                 ) AS m
        ON m.months = MONTH(u.invoice_date)
        WHERE u.status = 'paid' and YEAR(u.invoice_date) = $year
        GROUP BY m.months
        ORDER BY m.months;"));

        $earningVal = [1 => "''", "''", "''", "''", "''", "''", "''", "''", "''", "''", "''", "''"];
        foreach ($earnings as $earning) {
            $earningVal[$earning->months] = isset($earning->sum) ? $earning->sum : "''";
        }
        ksort($earningVal);

        $earningReport = implode(',', $earningVal);

        return ['success' => 'success', 'earningReport' => $earningReport];

    }

}
