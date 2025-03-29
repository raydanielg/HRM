@extends('front.layouts.frontlayout')

@section('head')
    {!! HTML::style("assets/global/css/plugins.css")!!}
    {!! HTML::style("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css")!!}
@stop

@section('mainarea')

    <div class="col-md-9">
        <!--Profile Body-->
        <div class="profile-body">
            <div class="row">
                <!--Profile Post-->
                <div class="col-sm-12">
                    <div id="outer_msg"></div>

                    <div class="panel " id="clock_panel">
                        <div class="panel-heading service-block-u">
                            <h3 class="panel-title"><i class="fa fa-clock-o"></i> Today's {{trans('core.attendance')}}
                            </h3>
                        </div>
                        <div class="panel-body">
                            <p id="alert"></p>
                            @if($set_attendance ==3)
                                <div class="row"><h4 class="text-center">You have been marked Absent for today</h4>
                                </div>
                            @elseif ($set_attendance == 2)
                                <div class="row"><h4 class="text-center">Office time has passed. You cannot mark
                                        attendance for today now.</h4></div>
                            @else
                                <form class="sky-form">
                                    <div id="alert_box"></div>
                                    <fieldset>
                                        <div class="row">
                                            <section class=" col col-4">
                                                <label class="control-label">Current Time</label>
                                                <div class="input">
                                                    <i class="icon-prepend fa fa-clock-o"></i>
                                                    <input type="text" disabled id="current_time">
                                                </div>
                                            </section>
                                            <section class=" col col-4">
                                                <label class="control-label">IP Address</label>
                                                <div class="input">
                                                    <i class="icon-prepend fa fa-desktop"></i>
                                                    <input type="text" disabled value="{{$ip_address}}">
                                                </div>
                                            </section>
                                            <section class="col col-4">
                                                <label class="control-label">Working From</label>
                                                <div class="input">
                                                    <input class="form-control" placeholder="Office, Home, etc."
                                                           id="work_form" name="work_from" value="{{$working_from}}">
                                                </div>
                                            </section>
                                        </div>
                                    </fieldset>
                                    <fieldset>
                                        <section>
                                            <label class="control-label">Notes</label>
                                            <label class="textarea textarea-resizable">
                                                <textarea rows="3" placeholder="Note to your manager" name="notes"
                                                          id="notes">{{$notes}}</textarea>
                                            </label>
                                        </section>
                                    </fieldset>
                                    <fieldset class="no-padding-fieldset">
                                        <div class="row">
                                            <div id="clocks">
                                                @if($set_attendance == 1)
                                                    <section class="col col-6">
                                                        <div class="pull-right" id="clock_set_div">
                                                            @if($clock_set==1)
                                                                <span class="clock-time">
                                                        <strong>Clock In</strong>: {{ $clock_in_time->format("h:i A") }}<br></span>
                                                                <p class="text-center">
                                                                    <small id="setClockInWords">{{ $clock_in_time->diffForHumans() }}</small>
                                                                </p>
                                                            @else
                                                                <button type="button" class="btn-u btn-u-dark"
                                                                        id="clock_in" onclick="setClock()">Clock In
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </section>
                                                    <section class="col col-6">
                                                        <div class="pull-left" id="clock_unset_div">
                                                            <button type="button" class="btn-u btn-u-dark"
                                                                    id="clock_out" onclick="unsetClock()">Clock Out
                                                            </button>
                                                        </div>
                                                    </section>
                                                @endif
                                                @if($set_attendance == 0)
                                                    <section class="col col-6">
                                                        <div class="pull-right">
                                                <span class="clock-time">
                                                    <strong>Clock In</strong>: {{ $clock_in_time->format("h:i A") }}<br></span>
                                                            <p class="text-center">
                                                                <small id="setClockInWords"></small>
                                                            </p>
                                                        </div>
                                                    </section>
                                                    <section class="col col-6">
                                                        <div class="pull-left">
                                                <span class="clock-time">
                                                    <strong>Clock Out</strong>: {{ $clock_out_time->format("h:i A") }}<br></span>
                                                            <p class="text-center">
                                                                <small id="unSetClockInWords"></small>
                                                            </p>
                                                        </div>
                                                    </section>
                                                @endif
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            @endif

                        </div>
                        <!--End Profile Post-->
                    </div><!--/end row-->
                    <hr>

                </div>
                <!--End Profile Body-->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div id="outer_msg"></div>
                    <div class="panel ">
                        <div class="panel-heading service-block-u">
                            <h3 class="panel-title"><i class="fa fa-clock-o"></i>{{trans('core.attendance')}} Summary
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <form class="sky-form">
                                    <fieldset class="no-padding-fieldset">
                                        <div class="row">
                                            <section class="col col-6">
                                                <label class="control-label">From</label>
                                                <div class="input">
                                                    <i class="icon-append fa fa-calendar"></i>
                                                    <input type="text" name="from_date" id="from_date"
                                                           placeholder="{{trans('core.startDate')}}">
                                                </div>
                                            </section>
                                            <section class="col col-6">
                                                <label class="control-label">To</label>
                                                <div class="input">
                                                    <i class="icon-append fa fa-calendar"></i>
                                                    <input type="text" name="to_date" id="to_date"
                                                           placeholder="{{trans('core.endDate')}}">
                                                </div>
                                            </section>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>

                            <table class="table table-striped table-bordered table-hover" id="attendance_table">
                                <thead>
                                <tr>
                                    <th> {{trans('core.serialNo')}} </th>

                                    <th class="all"> {{trans('core.date')}} </th>
                                    <th class="all"> {{trans('core.status')}} </th>
                                    <th class="min-tablet-l"> {{trans('core.progress')}} </th>
                                    <th> Hours</th>

                                </tr>
                                </thead>
                                <tbody>


                                <tr>
                                    <td>{{-- Serial Number --}}</td>
                                    <td>{{-- Month --}}</td>
                                    <td>{{-- Year --}}</td>
                                    <td>{{-- created On --}}</td>
                                    <td>{{-- created On --}}</td>

                                </tr>


                                </tbody>
                            </table>

                        </div>
                        <!--End Profile Post-->
                    </div><!--/end row-->
                    <!--End Profile Body-->
                </div>
            </div>
        </div>
    </div>

@stop

@section('footerjs')
    {!!  HTML::script("assets/global/plugins/datatables/datatables.min.js")!!}
    {!!  HTML::script("assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js")!!}
    {!!  HTML::script("assets/global/plugins/datatables/plugins/responsive/dataTables.responsive.min.js")!!}
    {!!  HTML::script("assets/js/moment-timezone.js")!!}

    <script>
        $('#clock_out').prop('disabled', true);
                @if(isset($clock_in_time))
        var clock_in_word = moment('{{$clock_in_time->format("Y-m-d H:i:s")}}');
                @else
        var clock_in_word = null;
                @endif

                @if(isset($clock_out_time))
        var clock_out_word = moment('{{$clock_out_time->format("Y-m-d H:i:s")}}');
                @else
        var clock_out_word = null;
                @endif
        var url = "{{ URL::route("front.attendance.ajax_attendance")}}";
        var clock_flag = '{{$clock_set ?? ''}}';

        var momentTime = moment();


        @php
            $timezones = [
                "Pacific/Pago_Pago" => "-11:00",
                "Pacific/Midway" => "-11:00",
                "Pacific/Niue" => "-11:00",
                "Pacific/Honolulu" => "-10:00",
                "Pacific/Tahiti" => "-10:00",
                "Pacific/Rarotonga" => "-10:00",
                "Pacific/Marquesas" => "-09:30",
                "America/Adak" => "-09:00",
                "Pacific/Gambier" => "-09:00",
                "America/Anchorage" => "-08:00",
                "America/Nome" => "-08:00",
                "America/Sitka" => "-08:00",
                "America/Yakutat" => "-08:00",
                "America/Metlakatla" => "-08:00",
                "America/Juneau" => "-08:00",
                "Pacific/Pitcairn" => "-08:00",
                "America/Phoenix" => "-07:00",
                "America/Creston" => "-07:00",
                "America/Dawson" => "-07:00",
                "America/Los_Angeles" => "-07:00",
                "America/Dawson_Creek" => "-07:00",
                "America/Whitehorse" => "-07:00",
                "America/Hermosillo" => "-07:00",
                "America/Fort_Nelson" => "-07:00",
                "America/Tijuana" => "-07:00",
                "America/Vancouver" => "-07:00",
                "America/Chihuahua" => "-06:00",
                "America/Cambridge_Bay" => "-06:00",
                "America/Boise" => "-06:00",
                "America/Denver" => "-06:00",
                "America/El_Salvador" => "-06:00",
                "America/Costa_Rica" => "-06:00",
                "America/Mazatlan" => "-06:00",
                "America/Ojinaga" => "-06:00",
                "America/Guatemala" => "-06:00",
                "America/Edmonton" => "-06:00",
                "America/Inuvik" => "-06:00",
                "America/Belize" => "-06:00",
                "America/Managua" => "-06:00",
                "America/Swift_Current" => "-06:00",
                "America/Regina" => "-06:00",
                "Pacific/Galapagos" => "-06:00",
                "America/Yellowknife" => "-06:00",
                "America/Tegucigalpa" => "-06:00",
                "America/Monterrey" => "-05:00",
                "America/Menominee" => "-05:00",
                "America/Bahia_Banderas" => "-05:00",
                "America/Bogota" => "-05:00",
                "America/Cancun" => "-05:00",
                "America/Merida" => "-05:00",
                "America/Chicago" => "-05:00",
                "America/Winnipeg" => "-05:00",
                "America/Eirunepe" => "-05:00",
                "America/Atikokan" => "-05:00",
                "America/Matamoros" => "-05:00",
                "Pacific/Easter" => "-05:00",
                "America/Guayaquil" => "-05:00",
                "America/Indiana/Knox" => "-05:00",
                "America/Indiana/Tell_City" => "-05:00",
                "America/Jamaica" => "-05:00",
                "America/Lima" => "-05:00",
                "America/Mexico_City" => "-05:00",
                "America/Cayman" => "-05:00",
                "America/Rainy_River" => "-05:00",
                "America/Rankin_Inlet" => "-05:00",
                "America/Rio_Branco" => "-05:00",
                "America/North_Dakota/Center" => "-05:00",
                "America/Panama" => "-05:00",
                "America/Resolute" => "-05:00",
                "America/North_Dakota/New_Salem" => "-05:00",
                "America/North_Dakota/Beulah" => "-05:00",
                "America/New_York" => "-04:00",
                "America/Puerto_Rico" => "-04:00",
                "America/Porto_Velho" => "-04:00",
                "America/Grand_Turk" => "-04:00",
                "America/Guadeloupe" => "-04:00",
                "America/Grenada" => "-04:00",
                "America/Marigot" => "-04:00",
                "America/Martinique" => "-04:00",
                "America/Port_of_Spain" => "-04:00",
                "America/Port-au-Prince" => "-04:00",
                "America/Guyana" => "-04:00",
                "America/Indiana/Indianapolis" => "-04:00",
                "America/Manaus" => "-04:00",
                "America/Havana" => "-04:00",
                "America/Tortola" => "-04:00",
                "America/Indiana/Marengo" => "-04:00",
                "America/Indiana/Petersburg" => "-04:00",
                "America/Indiana/Vevay" => "-04:00",
                "America/Indiana/Vincennes" => "-04:00",
                "America/Indiana/Winamac" => "-04:00",
                "America/Iqaluit" => "-04:00",
                "America/Kentucky/Louisville" => "-04:00",
                "America/Kentucky/Monticello" => "-04:00",
                "America/Kralendijk" => "-04:00",
                "America/La_Paz" => "-04:00",
                "America/Pangnirtung" => "-04:00",
                "America/Dominica" => "-04:00",
                "America/Nassau" => "-04:00",
                "America/Campo_Grande" => "-04:00",
                "America/Montserrat" => "-04:00",
                "America/Lower_Princes" => "-04:00",
                "America/Aruba" => "-04:00",
                "America/Asuncion" => "-04:00",
                "America/Nipigon" => "-04:00",
                "America/Barbados" => "-04:00",
                "America/St_Barthelemy" => "-04:00",
                "America/St_Kitts" => "-04:00",
                "America/Blanc-Sablon" => "-04:00",
                "America/Boa_Vista" => "-04:00",
                "America/Detroit" => "-04:00",
                "America/St_Thomas" => "-04:00",
                "America/St_Lucia" => "-04:00",
                "America/Caracas" => "-04:00",
                "America/Toronto" => "-04:00",
                "America/Antigua" => "-04:00",
                "America/St_Vincent" => "-04:00",
                "America/Anguilla" => "-04:00",
                "America/Cuiaba" => "-04:00",
                "America/Curacao" => "-04:00",
                "America/Santo_Domingo" => "-04:00",
                "America/Thunder_Bay" => "-04:00",
                "Atlantic/Stanley" => "-03:00",
                "America/Montevideo" => "-03:00",
                "America/Paramaribo" => "-03:00",
                "America/Moncton" => "-03:00",
                "America/Sao_Paulo" => "-03:00",
                "America/Thule" => "-03:00",
                "America/Santarem" => "-03:00",
                "Antarctica/Rothera" => "-03:00",
                "America/Santiago" => "-03:00",
                "America/Punta_Arenas" => "-03:00",
                "Antarctica/Palmer" => "-03:00",
                "America/Recife" => "-03:00",
                "Atlantic/Bermuda" => "-03:00",
                "America/Maceio" => "-03:00",
                "America/Argentina/Tucuman" => "-03:00",
                "America/Araguaina" => "-03:00",
                "America/Argentina/Buenos_Aires" => "-03:00",
                "America/Argentina/Catamarca" => "-03:00",
                "America/Argentina/Cordoba" => "-03:00",
                "America/Argentina/Jujuy" => "-03:00",
                "America/Argentina/Mendoza" => "-03:00",
                "America/Argentina/Rio_Gallegos" => "-03:00",
                "America/Argentina/Salta" => "-03:00",
                "America/Argentina/San_Juan" => "-03:00",
                "America/Argentina/San_Luis" => "-03:00",
                "America/Argentina/La_Rioja" => "-03:00",
                "America/Argentina/Ushuaia" => "-03:00",
                "America/Fortaleza" => "-03:00",
                "America/Halifax" => "-03:00",
                "America/Goose_Bay" => "-03:00",
                "America/Glace_Bay" => "-03:00",
                "America/Belem" => "-03:00",
                "America/Cayenne" => "-03:00",
                "America/Bahia" => "-03:00",
                "America/St_Johns" => "-02:30",
                "America/Noronha" => "-02:00",
                "America/Godthab" => "-02:00",
                "America/Miquelon" => "-02:00",
                "Atlantic/South_Georgia" => "-02:00",
                "Atlantic/Cape_Verde" => "-01:00",
                "Africa/Bissau" => "+00:00",
                "Africa/Freetown" => "+00:00",
                "Africa/Dakar" => "+00:00",
                "Africa/Conakry" => "+00:00",
                "Atlantic/Reykjavik" => "+00:00",
                "Africa/Banjul" => "+00:00",
                "Atlantic/Azores" => "+00:00",
                "Africa/Bamako" => "+00:00",
                "Africa/Accra" => "+00:00",
                "Atlantic/St_Helena" => "+00:00",
                "Africa/Lome" => "+00:00",
                "America/Scoresbysund" => "+00:00",
                "Africa/Abidjan" => "+00:00",
                "Africa/Nouakchott" => "+00:00",
                "Africa/Monrovia" => "+00:00",
                "America/Danmarkshavn" => "+00:00",
                "Africa/Ouagadougou" => "+00:00",
                "Africa/Sao_Tome" => "+00:00",
                "Europe/Dublin" => "+01:00",
                "Europe/Isle_of_Man" => "+01:00",
                "Europe/Jersey" => "+01:00",
                "Africa/Porto-Novo" => "+01:00",
                "Africa/Bangui" => "+01:00",
                "Europe/Lisbon" => "+01:00",
                "Europe/London" => "+01:00",
                "Africa/Niamey" => "+01:00",
                "Africa/Brazzaville" => "+01:00",
                "Africa/Casablanca" => "+01:00",
                "Africa/Ndjamena" => "+01:00",
                "Africa/Douala" => "+01:00",
                "Africa/El_Aaiun" => "+01:00",
                "Africa/Luanda" => "+01:00",
                "Africa/Malabo" => "+01:00",
                "Atlantic/Canary" => "+01:00",
                "Africa/Libreville" => "+01:00",
                "Africa/Lagos" => "+01:00",
                "Africa/Kinshasa" => "+01:00",
                "Atlantic/Faroe" => "+01:00",
                "Atlantic/Madeira" => "+01:00",
                "Africa/Tunis" => "+01:00",
                "Africa/Algiers" => "+01:00",
                "Europe/Guernsey" => "+01:00",
                "Europe/Paris" => "+02:00",
                "Europe/Ljubljana" => "+02:00",
                "Europe/Luxembourg" => "+02:00",
                "Europe/Madrid" => "+02:00",
                "Europe/Malta" => "+02:00",
                "Europe/Kaliningrad" => "+02:00",
                "Europe/Oslo" => "+02:00",
                "Europe/Monaco" => "+02:00",
                "Africa/Lusaka" => "+02:00",
                "Europe/Gibraltar" => "+02:00",
                "Europe/Copenhagen" => "+02:00",
                "Europe/Busingen" => "+02:00",
                "Europe/Budapest" => "+02:00",
                "Europe/Brussels" => "+02:00",
                "Europe/Bratislava" => "+02:00",
                "Europe/Prague" => "+02:00",
                "Europe/Berlin" => "+02:00",
                "Europe/Belgrade" => "+02:00",
                "Europe/Andorra" => "+02:00",
                "Europe/Amsterdam" => "+02:00",
                "Africa/Tripoli" => "+02:00",
                "Africa/Windhoek" => "+02:00",
                "Europe/Podgorica" => "+02:00",
                "Europe/Sarajevo" => "+02:00",
                "Europe/Warsaw" => "+02:00",
                "Africa/Gaborone" => "+02:00",
                "Antarctica/Troll" => "+02:00",
                "Africa/Blantyre" => "+02:00",
                "Europe/Zagreb" => "+02:00",
                "Europe/Rome" => "+02:00",
                "Africa/Bujumbura" => "+02:00",
                "Europe/Vienna" => "+02:00",
                "Africa/Cairo" => "+02:00",
                "Europe/Vatican" => "+02:00",
                "Europe/Vaduz" => "+02:00",
                "Africa/Ceuta" => "+02:00",
                "Africa/Mbabane" => "+02:00",
                "Europe/Tirane" => "+02:00",
                "Africa/Harare" => "+02:00",
                "Europe/Stockholm" => "+02:00",
                "Africa/Johannesburg" => "+02:00",
                "Europe/Skopje" => "+02:00",
                "Africa/Khartoum" => "+02:00",
                "Africa/Kigali" => "+02:00",
                "Africa/Maseru" => "+02:00",
                "Africa/Maputo" => "+02:00",
                "Africa/Lubumbashi" => "+02:00",
                "Europe/San_Marino" => "+02:00",
                "Europe/Zurich" => "+02:00",
                "Indian/Comoro" => "+03:00",
                "Europe/Athens" => "+03:00",
                "Indian/Mayotte" => "+03:00",
                "Europe/Riga" => "+03:00",
                "Europe/Bucharest" => "+03:00",
                "Europe/Chisinau" => "+03:00",
                "Europe/Zaporozhye" => "+03:00",
                "Europe/Vilnius" => "+03:00",
                "Europe/Helsinki" => "+03:00",
                "Europe/Istanbul" => "+03:00",
                "Europe/Kiev" => "+03:00",
                "Europe/Kirov" => "+03:00",
                "Europe/Uzhgorod" => "+03:00",
                "Europe/Tallinn" => "+03:00",
                "Europe/Sofia" => "+03:00",
                "Europe/Mariehamn" => "+03:00",
                "Europe/Minsk" => "+03:00",
                "Europe/Simferopol" => "+03:00",
                "Europe/Moscow" => "+03:00",
                "Indian/Antananarivo" => "+03:00",
                "Asia/Amman" => "+03:00",
                "Asia/Aden" => "+03:00",
                "Africa/Mogadishu" => "+03:00",
                "Asia/Kuwait" => "+03:00",
                "Asia/Nicosia" => "+03:00",
                "Asia/Baghdad" => "+03:00",
                "Antarctica/Syowa" => "+03:00",
                "Asia/Jerusalem" => "+03:00",
                "Asia/Bahrain" => "+03:00",
                "Asia/Gaza" => "+03:00",
                "Asia/Qatar" => "+03:00",
                "Asia/Famagusta" => "+03:00",
                "Asia/Riyadh" => "+03:00",
                "Africa/Nairobi" => "+03:00",
                "Asia/Hebron" => "+03:00",
                "Africa/Kampala" => "+03:00",
                "Asia/Damascus" => "+03:00",
                "Asia/Beirut" => "+03:00",
                "Africa/Dar_es_Salaam" => "+03:00",
                "Africa/Djibouti" => "+03:00",
                "Africa/Asmara" => "+03:00",
                "Africa/Addis_Ababa" => "+03:00",
                "Africa/Juba" => "+03:00",
                "Indian/Mauritius" => "+04:00",
                "Asia/Tbilisi" => "+04:00",
                "Europe/Saratov" => "+04:00",
                "Asia/Dubai" => "+04:00",
                "Europe/Astrakhan" => "+04:00",
                "Indian/Mahe" => "+04:00",
                "Europe/Ulyanovsk" => "+04:00",
                "Asia/Baku" => "+04:00",
                "Indian/Reunion" => "+04:00",
                "Europe/Samara" => "+04:00",
                "Asia/Muscat" => "+04:00",
                "Asia/Yerevan" => "+04:00",
                "Europe/Volgograd" => "+04:00",
                "Asia/Kabul" => "+04:30",
                "Asia/Tehran" => "+04:30",
                "Asia/Aqtobe" => "+05:00",
                "Asia/Aqtau" => "+05:00",
                "Asia/Karachi" => "+05:00",
                "Antarctica/Mawson" => "+05:00",
                "Asia/Oral" => "+05:00",
                "Asia/Tashkent" => "+05:00",
                "Indian/Kerguelen" => "+05:00",
                "Indian/Maldives" => "+05:00",
                "Asia/Atyrau" => "+05:00",
                "Asia/Qyzylorda" => "+05:00",
                "Asia/Dushanbe" => "+05:00",
                "Asia/Samarkand" => "+05:00",
                "Asia/Yekaterinburg" => "+05:00",
                "Asia/Ashgabat" => "+05:00",
                "Asia/Colombo" => "+05:30",
                "Asia/Kolkata" => "+05:30",
                "Asia/Kathmandu" => "+05:45",
                "Asia/Dhaka" => "+06:00",
                "Asia/Bishkek" => "+06:00",
                "Asia/Thimphu" => "+06:00",
                "Asia/Omsk" => "+06:00",
                "Antarctica/Vostok" => "+06:00",
                "Indian/Chagos" => "+06:00",
                "Asia/Urumqi" => "+06:00",
                "Asia/Almaty" => "+06:00",
                "Asia/Qostanay" => "+06:00",
                "Indian/Cocos" => "+06:30",
                "Asia/Yangon" => "+06:30",
                "Antarctica/Davis" => "+07:00",
                "Asia/Tomsk" => "+07:00",
                "Asia/Vientiane" => "+07:00",
                "Asia/Barnaul" => "+07:00",
                "Asia/Krasnoyarsk" => "+07:00",
                "Asia/Pontianak" => "+07:00",
                "Asia/Ho_Chi_Minh" => "+07:00",
                "Asia/Hovd" => "+07:00",
                "Asia/Phnom_Penh" => "+07:00",
                "Asia/Jakarta" => "+07:00",
                "Indian/Christmas" => "+07:00",
                "Asia/Novosibirsk" => "+07:00",
                "Asia/Novokuznetsk" => "+07:00",
                "Asia/Bangkok" => "+07:00",
                "Antarctica/Casey" => "+08:00",
                "Asia/Shanghai" => "+08:00",
                "Asia/Brunei" => "+08:00",
                "Asia/Kuala_Lumpur" => "+08:00",
                "Australia/Perth" => "+08:00",
                "Asia/Manila" => "+08:00",
                "Asia/Ulaanbaatar" => "+08:00",
                "Asia/Macau" => "+08:00",
                "Asia/Kuching" => "+08:00",
                "Asia/Makassar" => "+08:00",
                "Asia/Taipei" => "+08:00",
                "Asia/Choibalsan" => "+08:00",
                "Asia/Irkutsk" => "+08:00",
                "Asia/Hong_Kong" => "+08:00",
                "Asia/Singapore" => "+08:00",
                "Australia/Eucla" => "+08:45",
                "Asia/Chita" => "+09:00",
                "Asia/Tokyo" => "+09:00",
                "Pacific/Palau" => "+09:00",
                "Asia/Khandyga" => "+09:00",
                "Asia/Yakutsk" => "+09:00",
                "Asia/Seoul" => "+09:00",
                "Asia/Dili" => "+09:00",
                "Asia/Jayapura" => "+09:00",
                "Asia/Pyongyang" => "+09:00",
                "Australia/Adelaide" => "+09:30",
                "Australia/Darwin" => "+09:30",
                "Australia/Broken_Hill" => "+09:30",
                "Pacific/Guam" => "+10:00",
                "Pacific/Port_Moresby" => "+10:00",
                "Antarctica/DumontDUrville" => "+10:00",
                "Pacific/Chuuk" => "+10:00",
                "Australia/Currie" => "+10:00",
                "Pacific/Saipan" => "+10:00",
                "Australia/Hobart" => "+10:00",
                "Australia/Sydney" => "+10:00",
                "Australia/Lindeman" => "+10:00",
                "Australia/Melbourne" => "+10:00",
                "Asia/Ust-Nera" => "+10:00",
                "Asia/Vladivostok" => "+10:00",
                "Australia/Brisbane" => "+10:00",
                "Australia/Lord_Howe" => "+10:30",
                "Pacific/Pohnpei" => "+11:00",
                "Asia/Srednekolymsk" => "+11:00",
                "Antarctica/Macquarie" => "+11:00",
                "Asia/Sakhalin" => "+11:00",
                "Pacific/Efate" => "+11:00",
                "Pacific/Bougainville" => "+11:00",
                "Asia/Magadan" => "+11:00",
                "Pacific/Kosrae" => "+11:00",
                "Pacific/Noumea" => "+11:00",
                "Pacific/Norfolk" => "+11:00",
                "Pacific/Guadalcanal" => "+11:00",
                "Pacific/Tarawa" => "+12:00",
                "Pacific/Wake" => "+12:00",
                "Pacific/Wallis" => "+12:00",
                "Pacific/Nauru" => "+12:00",
                "Pacific/Majuro" => "+12:00",
                "Pacific/Kwajalein" => "+12:00",
                "Pacific/Funafuti" => "+12:00",
                "Pacific/Fiji" => "+12:00",
                "Pacific/Auckland" => "+12:00",
                "Antarctica/McMurdo" => "+12:00",
                "Asia/Anadyr" => "+12:00",
                "Asia/Kamchatka" => "+12:00",
                "Pacific/Chatham" => "+12:45",
                "Pacific/Fakaofo" => "+13:00",
                "Pacific/Enderbury" => "+13:00",
                "Pacific/Apia" => "+13:00",
                "Pacific/Tongatapu" => "+13:00",
                "Pacific/Kiritimati" => "+14:00",
                ];
            $data = array_flip($timezones);
        @endphp

        {{--var today = moment().tz('{{$timezones[$setting->timezone]}}');--}}
        function startTime() {
            $('#current_time').val(moment().tz('{{$data[$setting->timezone]}}').format('hh:mm:ss A'));
            if (clock_flag == '1') {
                $('#clock_out').prop('disabled', false);
            }
            setTimeout(startTime, 1000);
        }

        function checkTime(i) {
            if (i < 10) {
                i = "0", + i
            }
            // add zero in front of numbers < 10
            return i;
        }

        $("#work_form").blur(function () {
            var work_from = $(this).val();

            $.ajax({
                type: "POST",
                url: "{!! route('front.attendance.work_from') !!}",
                data: {'work_from': work_from}
            }).done(function (response) {
                return true;
            });
        });

        $("#notes").blur(function () {
            var notes = $(this).val();
            $.ajax({
                type: "POST",
                url: "{!! route('front.attendance.notes') !!}",
                data: {'notes': notes}
            }).done(function (response) {
                return true;
            });
        });

        $('#from_date').on('change', function () {
            date_change();
        });
        $('#to_date').on('change', function () {
            date_change();
        });

        function setClock() {
            $.easyAjax({
                type: "POST",
                url: "{!! route('front.attendance.clockIn') !!}",
                data: $('.sky-form').serialize(),
                messagePosition: 'inline',
                container: "#clock_panel",
                success: function (response) {

                    if (response.status === "success") {
                        clock_flag = 1;
                        clock_in_word = moment(response.time_date);
                        table.fnDraw();
                        $('#clock_set_div').html('<span class="clock-time"><strong>Clock In</strong>: ' + response.time + '<br></span><p class="text-center"><small id="setClockInWords">' + response.timeDiff + '</small></p>');
                        setTimeout(function () {
                            $('#alert').html('');
                        }, 5000);
                    }
                }
            });
            return false;
        }

        var table = $('#attendance_table').dataTable({
            processing: true,
            serverSide: true,
            "ajax": url ,
            "aaSorting": [[0, "asc"]],
            columns: [
                {data: 's_id', name: 's_id'},
                {data: 'date', name: 'date'},
                {data: 'status', name: 'status'},

                {data: 'clock_out', name: 'clock_out'},

                {data: 'Hours', name: 'Hours'},
            ],
            "sPaginationType": "full_numbers",
            "language": {
                "lengthMenu": "Display _MENU_ records per page",
                "info": "Showing page _PAGE_ of _PAGES_",
                "emptyTable": "{{trans('messages.noDataTable')}}",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "{{trans('core.search')}}:"
            },
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
                var oSettings = this.fnSettings();
                $("td:first", nRow).html(oSettings._iDisplayStart + iDisplayIndex + 1);
                return nRow;
            }
        });



        function unsetClock() {
            $.easyAjax({
                type: "POST",
                url: "{!! route('front.attendance.clockOut') !!}",
                messagePosition: 'inline',
                container: "#clock_panel",
                success: function (response) {

                    if (response.status == 'success') {
                        table.fnDraw();
                        clock_out_word = moment(response.unset_time);

                        $('#clock_unset_div').html('<span class="clock-time"><strong>Clock Out</strong>: ' + response.unset_time + '<br></span><p class="text-center"><small id="unSetClockInWords">' + response.unset_time_diff + '</small></p>');
                        setTimeout(function () {
                            $('#alert').html('');
                        }, 5000);
                    } else {
                        setTimeout(function () {
                            $('#alert').html('');
                        }, 5000);
                    }
                }
            });
            return false;
        }

        function date_change() {

            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            url = "{{ URL::route('front.attendance.ajax_attendance') }}?from_date=" + from_date + "&to_date=" + to_date;
            table.fnDraw();
        }

        function timeInWords(clock_in, clock_out) {
            if (clock_in != null) {
                $('#setClockInWords').html(clock_in.fromNow());
            } else {
                $('#setClockInWords').html('');
            }

            if (clock_out != null) {
                $('#unSetClockInWords').html(clock_out.fromNow());
            } else {
                $('#unSetClockInWords').html('');
            }
            setTimeout(timeInWords, 1000, clock_in_word, clock_out_word);
        }

        jQuery(document).ready(function () {
            startTime();
            timeInWords(clock_in_word, clock_out_word);
            table.fnDraw();
            $('#from_date').datepicker({
                dateFormat: 'dd-mm-yy',
                prevText: '<i class="fa fa-angle-left"></i>',
                nextText: '<i class="fa fa-angle-right"></i>'
            });
            $('#to_date').datepicker({
                dateFormat: 'dd-mm-yy',
                prevText: '<i class="fa fa-angle-left"></i>',
                nextText: '<i class="fa fa-angle-right"></i>'
            });
        });

    </script>
@stop
