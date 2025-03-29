@extends('admin.adminlayouts.adminlayout')

@section('head')

    <!-- BEGIN PAGE LEVEL STYLES -->
    {!! HTML::style("assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css") !!}
    {!! HTML::style("assets/global/plugins/select2/css/select2.css")!!}
    {!! HTML::style("assets/global/plugins/select2/css/select2-bootstrap.min.css")!!}
    {!! HTML::style("assets/global/plugins/jquery-multi-select/css/multi-select.css") !!}

    <!-- BEGIN THEME STYLES -->
@stop


@section('mainarea')


    <!-- BEGIN PAGE HEADER-->
    <div class="page-head">
        <div class="page-title"><h1>
                @if($loggedAdmin->type=='superadmin')
                    {{ $company->company_name }} @lang("core.settings")
                @else
                    @lang("core.generalSettings")
                @endif
            </h1></div>
    </div>
    <div class="page-bar">
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a onclick="loadView('{{ route('admin.dashboard.index') }}')">{{ trans('core.dashboard') }}</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="#">@lang("core.settings")</a>
                <i class="fa fa-circle"></i>
            </li>

            <li>
                <span class="active">@lang("core.generalSettings")</span>
            </li>
        </ul>

    </div>
    <!-- END PAGE HEADER-->
    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->

            <div id="load">

                {{--INLCUDE ERROR MESSAGE BOX--}}

                {{--END ERROR MESSAGE BOX--}}


            </div>
            <div class="portlet light bordered">
                {{--<div class="portlet-title">--}}
                {{--<div class="caption font-dark">--}}
                {{--<i class="fa fa-desktop font-dark"></i>{{trans('core.edit')}} {{$pageTitle}}--}}
                {{--</div>--}}
                {{--<div class="tools">--}}
                {{--</div>--}}
                {{--</div>--}}

                <div class="portlet-body form">

                    <!------------------------ BEGIN FORM---------------------->
                    {!!  Form::open(['method' => 'PUT','files' => true, 'class'=>'form-horizontal ajax_form'])  !!}

                    <div class="form-body">

                        <div class="form-group">
                            <label class="control-label col-md-2">{{trans('core.companyLogo')}}</label>
                            <div class="col-md-6">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">

                                        {!! HTML::image($company->logo_image_url)!!}

                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"
                                         style="max-width: 200px; max-height: 150px;">
                                    </div>
                                    <div>
                                                       <span class="btn default btn-file">
                                                       <span class="fileinput-new">
                                                       {{trans('core.changeImage')}} </span>
                                                       <span class="fileinput-exists">
                                                       {{trans('core.change')}} </span>
                                                       <input type="file" name="logo">
                                                       </span>
                                        <a href="#" class="btn red fileinput-exists" data-dismiss="fileinput">
                                            {{trans('core.remove')}} </a>
                                    </div>
                                </div>
                                <div class="clearfix margin-top-10">
                                                        <span class="label label-danger">
                                                        NOTE!</span> Image Size must be height 40px

                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.companyName')}}: <span class="required">
                                        * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="company_name" placeholder="Comany Name"
                                       value="{{ $company->company_name }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.companyAddress')}}:
                            </label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="address"
                                          placeholder="Company Address">{{$company->address}}</textarea>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-2 control-label">Billing Address: {!! help_text("billingAddress") !!}
                            </label>
                            <div class="col-md-6">
                                <textarea class="form-control" name="billing_address"
                                          placeholder="Billing Address">{{$company->billing_address}}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">Country</label>
                            <div class="col-md-6">
                                <select class="select2me form-control" data-show-subtext="true" name="country">
                                    @foreach($countrieslist as $country)
                                        <option value="{{$country->name}}"
                                                @if($company->country==$country->name) selected @endif>{{$country->name}}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label">{{trans('core.phone')}}:
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="contact" value="{{ $company->contact }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">@lang("core.companyEmail"): <span class="required">
                                            * </span>
                            </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="email" value="{{ $company->email}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-2 control-label">@lang("core.contactPersonName"): <span
                                        class="required">  * </span></label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" placeholder="Name"
                                       value="{{ $company->name}}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-md-2">@lang("core.currency")</label>
                            <div class="col-md-6">
                                <select class="select2me form-control" data-show-subtext="true" name="currency">
                                    @foreach($countries as $country)
                                        <option value="{{$country->currency_symbol}}:{{$country->currency_code}}"
                                                @if($company->currency==$country->currency_code) selected @endif>{{$country->currency_code}} {{$country->currency_symbol}} </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="abc">
                            <label class="col-md-2 control-label">@lang("core.language"): </label>
                            <div class="col-md-6">

                                <select class="select2me form-control" name="locale" id="select_lang">
                                    @foreach($languages as $lang)
                                        <option value="{{$lang->locale}}"
                                                @if($lang->locale == $company->locale) selected="selected" @endif>{{$lang->language}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group" id="timezone_container">
                            <input type="hidden" name="timezoneIndex" id="timezoneIndex"
                                   value="{{ $company->timezone_index }}">
                            <label class="col-md-2 control-label">@lang("core.timezone"): </label>
                            <div class="col-md-6">
                                <select class="select2me form-control select2-hidden-accessible" name="timezone"
                                        id="timezone" tabindex="-1" aria-hidden="true">
                                    <option value="+00:00">UTC</option>
                                    <optgroup label="Africa">
                                        <option value="+00:00">Africa/Abidjan</option>
                                        <option value="+00:00">Africa/Accra</option>
                                        <option value="+03:00">Africa/Addis_Ababa</option>
                                        <option value="+01:00">Africa/Algiers</option>
                                        <option value="+03:00">Africa/Asmara</option>
                                        <option value="+00:00">Africa/Bamako</option>
                                        <option value="+01:00">Africa/Bangui</option>
                                        <option value="+00:00">Africa/Banjul</option>
                                        <option value="+00:00">Africa/Bissau</option>
                                        <option value="+02:00">Africa/Blantyre</option>
                                        <option value="+01:00">Africa/Brazzaville</option>
                                        <option value="+02:00">Africa/Bujumbura</option>
                                        <option value="+02:00">Africa/Cairo</option>
                                        <option value="+00:00">Africa/Casablanca</option>
                                        <option value="+01:00">Africa/Ceuta</option>
                                        <option value="+00:00">Africa/Conakry</option>
                                        <option value="+00:00">Africa/Dakar</option>
                                        <option value="+03:00">Africa/Dar_es_Salaam</option>
                                        <option value="+03:00">Africa/Djibouti</option>
                                        <option value="+01:00">Africa/Douala</option>
                                        <option value="+00:00">Africa/El_Aaiun</option>
                                        <option value="+00:00">Africa/Freetown</option>
                                        <option value="+02:00">Africa/Gaborone</option>
                                        <option value="+02:00">Africa/Harare</option>
                                        <option value="+02:00">Africa/Johannesburg</option>
                                        <option value="+03:00">Africa/Juba</option>
                                        <option value="+03:00">Africa/Kampala</option>
                                        <option value="+03:00">Africa/Khartoum</option>
                                        <option value="+02:00">Africa/Kigali</option>
                                        <option value="+01:00">Africa/Kinshasa</option>
                                        <option value="+01:00">Africa/Lagos</option>
                                        <option value="+01:00">Africa/Libreville</option>
                                        <option value="+00:00">Africa/Lome</option>
                                        <option value="+01:00">Africa/Luanda</option>
                                        <option value="+02:00">Africa/Lubumbashi</option>
                                        <option value="+02:00">Africa/Lusaka</option>
                                        <option value="+01:00">Africa/Malabo</option>
                                        <option value="+02:00">Africa/Maputo</option>
                                        <option value="+02:00">Africa/Maseru</option>
                                        <option value="+02:00">Africa/Mbabane</option>
                                        <option value="+03:00">Africa/Mogadishu</option>
                                        <option value="+00:00">Africa/Monrovia</option>
                                        <option value="+03:00">Africa/Nairobi</option>
                                        <option value="+01:00">Africa/Ndjamena</option>
                                        <option value="+01:00">Africa/Niamey</option>
                                        <option value="+00:00">Africa/Nouakchott</option>
                                        <option value="+00:00">Africa/Ouagadougou</option>
                                        <option value="+01:00">Africa/Porto-Novo</option>
                                        <option value="+00:00">Africa/Sao_Tome</option>
                                        <option value="+02:00">Africa/Tripoli</option>
                                        <option value="+01:00">Africa/Tunis</option>
                                        <option value="+02:00">Africa/Windhoek</option>
                                    </optgroup>
                                    <optgroup label="America">
                                        <option value="-10:00">America/Adak</option>
                                        <option value="-09:00">America/Anchorage</option>
                                        <option value="-04:00">America/Anguilla</option>
                                        <option value="-04:00">America/Antigua</option>
                                        <option value="-03:00">America/Araguaina</option>
                                        <option value="-03:00">America/Argentina/Buenos_Aires</option>
                                        <option value="-03:00">America/Argentina/Catamarca</option>
                                        <option value="-03:00">America/Argentina/Cordoba</option>
                                        <option value="-03:00">America/Argentina/Jujuy</option>
                                        <option value="-03:00">America/Argentina/La_Rioja</option>
                                        <option value="-03:00">America/Argentina/Mendoza</option>
                                        <option value="-03:00">America/Argentina/Rio_Gallegos</option>
                                        <option value="-03:00">America/Argentina/Salta</option>
                                        <option value="-03:00">America/Argentina/San_Juan</option>
                                        <option value="-03:00">America/Argentina/San_Luis</option>
                                        <option value="-03:00">America/Argentina/Tucuman</option>
                                        <option value="-03:00">America/Argentina/Ushuaia</option>
                                        <option value="-04:00">America/Aruba</option>
                                        <option value="-03:00">America/Asuncion</option>
                                        <option value="-05:00">America/Atikokan</option>
                                        <option value="-03:00">America/Bahia</option>
                                        <option value="-06:00">America/Bahia_Banderas</option>
                                        <option value="-04:00">America/Barbados</option>
                                        <option value="-03:00">America/Belem</option>
                                        <option value="-06:00">America/Belize</option>
                                        <option value="-04:00">America/Blanc-Sablon</option>
                                        <option value="-04:00">America/Boa_Vista</option>
                                        <option value="-05:00">America/Bogota</option>
                                        <option value="-07:00">America/Boise</option>
                                        <option value="-07:00">America/Cambridge_Bay</option>
                                        <option value="-04:00">America/Campo_Grande</option>
                                        <option value="-05:00">America/Cancun</option>
                                        <option value="-04:30">America/Caracas</option>
                                        <option value="-03:00">America/Cayenne</option>
                                        <option value="-05:00">America/Cayman</option>
                                        <option value="-06:00">America/Chicago</option>
                                        <option value="-07:00">America/Chihuahua</option>
                                        <option value="-06:00">America/Costa_Rica</option>
                                        <option value="-07:00">America/Creston</option>
                                        <option value="-04:00">America/Cuiaba</option>
                                        <option value="-04:00">America/Curacao</option>
                                        <option value="+00:00">America/Danmarkshavn</option>
                                        <option value="-08:00">America/Dawson</option>
                                        <option value="-07:00">America/Dawson_Creek</option>
                                        <option value="-07:00">America/Denver</option>
                                        <option value="-05:00">America/Detroit</option>
                                        <option value="-04:00">America/Dominica</option>
                                        <option value="-07:00">America/Edmonton</option>
                                        <option value="-05:00">America/Eirunepe</option>
                                        <option value="-06:00">America/El_Salvador</option>
                                        <option value="-07:00">America/Fort_Nelson</option>
                                        <option value="-03:00">America/Fortaleza</option>
                                        <option value="-04:00">America/Glace_Bay</option>
                                        <option value="-03:00">America/Godthab</option>
                                        <option value="-04:00">America/Goose_Bay</option>
                                        <option value="-04:00">America/Grand_Turk</option>
                                        <option value="-04:00">America/Grenada</option>
                                        <option value="-04:00">America/Guadeloupe</option>
                                        <option value="-06:00">America/Guatemala</option>
                                        <option value="-05:00">America/Guayaquil</option>
                                        <option value="-04:00">America/Guyana</option>
                                        <option value="-04:00">America/Halifax</option>
                                        <option value="-05:00">America/Havana</option>
                                        <option value="-07:00">America/Hermosillo</option>
                                        <option value="-05:00">America/Indiana/Indianapolis</option>
                                        <option value="-06:00">America/Indiana/Knox</option>
                                        <option value="-05:00">America/Indiana/Marengo</option>
                                        <option value="-05:00">America/Indiana/Petersburg</option>
                                        <option value="-06:00">America/Indiana/Tell_City</option>
                                        <option value="-05:00">America/Indiana/Vevay</option>
                                        <option value="-05:00">America/Indiana/Vincennes</option>
                                        <option value="-05:00">America/Indiana/Winamac</option>
                                        <option value="-07:00">America/Inuvik</option>
                                        <option value="-05:00">America/Iqaluit</option>
                                        <option value="-05:00">America/Jamaica</option>
                                        <option value="-09:00">America/Juneau</option>
                                        <option value="-05:00">America/Kentucky/Louisville</option>
                                        <option value="-05:00">America/Kentucky/Monticello</option>
                                        <option value="-04:00">America/Kralendijk</option>
                                        <option value="-04:00">America/La_Paz</option>
                                        <option value="-05:00">America/Lima</option>
                                        <option value="-08:00">America/Los_Angeles</option>
                                        <option value="-04:00">America/Lower_Princes</option>
                                        <option value="-03:00">America/Maceio</option>
                                        <option value="-06:00">America/Managua</option>
                                        <option value="-04:00">America/Manaus</option>
                                        <option value="-04:00">America/Marigot</option>
                                        <option value="-04:00">America/Martinique</option>
                                        <option value="-06:00">America/Matamoros</option>
                                        <option value="-07:00">America/Mazatlan</option>
                                        <option value="-06:00">America/Menominee</option>
                                        <option value="-06:00">America/Merida</option>
                                        <option value="-08:00">America/Metlakatla</option>
                                        <option value="-06:00">America/Mexico_City</option>
                                        <option value="-03:00">America/Miquelon</option>
                                        <option value="-04:00">America/Moncton</option>
                                        <option value="-06:00">America/Monterrey</option>
                                        <option value="-03:00">America/Montevideo</option>
                                        <option value="-04:00">America/Montserrat</option>
                                        <option value="-05:00">America/Nassau</option>
                                        <option value="-05:00">America/New_York</option>
                                        <option value="-05:00">America/Nipigon</option>
                                        <option value="-09:00">America/Nome</option>
                                        <option value="-02:00">America/Noronha</option>
                                        <option value="-06:00">America/North_Dakota/Beulah</option>
                                        <option value="-06:00">America/North_Dakota/Center</option>
                                        <option value="-06:00">America/North_Dakota/New_Salem</option>
                                        <option value="-07:00">America/Ojinaga</option>
                                        <option value="-05:00">America/Panama</option>
                                        <option value="-05:00">America/Pangnirtung</option>
                                        <option value="-03:00">America/Paramaribo</option>
                                        <option value="-07:00">America/Phoenix</option>
                                        <option value="-05:00">America/Port-au-Prince</option>
                                        <option value="-04:00">America/Port_of_Spain</option>
                                        <option value="-04:00">America/Porto_Velho</option>
                                        <option value="-04:00">America/Puerto_Rico</option>
                                        <option value="-06:00">America/Rainy_River</option>
                                        <option value="-06:00">America/Rankin_Inlet</option>
                                        <option value="-03:00">America/Recife</option>
                                        <option value="-06:00">America/Regina</option>
                                        <option value="-06:00">America/Resolute</option>
                                        <option value="-05:00">America/Rio_Branco</option>
                                        <option value="-08:00">America/Santa_Isabel</option>
                                        <option value="-03:00">America/Santarem</option>
                                        <option value="-03:00">America/Santiago</option>
                                        <option value="-04:00">America/Santo_Domingo</option>
                                        <option value="-03:00">America/Sao_Paulo</option>
                                        <option value="-01:00">America/Scoresbysund</option>
                                        <option value="-09:00">America/Sitka</option>
                                        <option value="-04:00">America/St_Barthelemy</option>
                                        <option value="-03:30">America/St_Johns</option>
                                        <option value="-04:00">America/St_Kitts</option>
                                        <option value="-04:00">America/St_Lucia</option>
                                        <option value="-04:00">America/St_Thomas</option>
                                        <option value="-04:00">America/St_Vincent</option>
                                        <option value="-06:00">America/Swift_Current</option>
                                        <option value="-06:00">America/Tegucigalpa</option>
                                        <option value="-04:00">America/Thule</option>
                                        <option value="-05:00">America/Thunder_Bay</option>
                                        <option value="-08:00">America/Tijuana</option>
                                        <option value="-05:00">America/Toronto</option>
                                        <option value="-04:00">America/Tortola</option>
                                        <option value="-08:00">America/Vancouver</option>
                                        <option value="-08:00">America/Whitehorse</option>
                                        <option value="-06:00">America/Winnipeg</option>
                                        <option value="-09:00">America/Yakutat</option>
                                        <option value="-07:00">America/Yellowknife</option>
                                    </optgroup>
                                    <optgroup label="Antarctica">
                                        <option value="+08:00">Antarctica/Casey</option>
                                        <option value="+07:00">Antarctica/Davis</option>
                                        <option value="+10:00">Antarctica/DumontDUrville</option>
                                        <option value="+11:00">Antarctica/Macquarie</option>
                                        <option value="+05:00">Antarctica/Mawson</option>
                                        <option value="+13:00">Antarctica/McMurdo</option>
                                        <option value="-03:00">Antarctica/Palmer</option>
                                        <option value="-03:00">Antarctica/Rothera</option>
                                        <option value="+03:00">Antarctica/Syowa</option>
                                        <option value="+00:00">Antarctica/Troll</option>
                                        <option value="+06:00">Antarctica/Vostok</option>
                                    </optgroup>
                                    <optgroup label="Arctic">
                                        <option value="+01:00">Arctic/Longyearbyen</option>
                                    </optgroup>
                                    <optgroup label="Asia">
                                        <option value="+03:00">Asia/Aden</option>
                                        <option value="+06:00">Asia/Almaty</option>
                                        <option value="+02:00">Asia/Amman</option>
                                        <option value="+12:00">Asia/Anadyr</option>
                                        <option value="+05:00">Asia/Aqtau</option>
                                        <option value="+05:00">Asia/Aqtobe</option>
                                        <option value="+05:00">Asia/Ashgabat</option>
                                        <option value="+03:00">Asia/Baghdad</option>
                                        <option value="+03:00">Asia/Bahrain</option>
                                        <option value="+04:00">Asia/Baku</option>
                                        <option value="+07:00">Asia/Bangkok</option>
                                        <option value="+02:00">Asia/Beirut</option>
                                        <option value="+06:00">Asia/Bishkek</option>
                                        <option value="+08:00">Asia/Brunei</option>
                                        <option value="+08:00">Asia/Chita</option>
                                        <option value="+08:00">Asia/Choibalsan</option>
                                        <option value="+05:30">Asia/Colombo</option>
                                        <option value="+02:00">Asia/Damascus</option>
                                        <option value="+06:00">Asia/Dhaka</option>
                                        <option value="+09:00">Asia/Dili</option>
                                        <option value="+04:00">Asia/Dubai</option>
                                        <option value="+05:00">Asia/Dushanbe</option>
                                        <option value="+02:00">Asia/Gaza</option>
                                        <option value="+02:00">Asia/Hebron</option>
                                        <option value="+07:00">Asia/Ho_Chi_Minh</option>
                                        <option value="+08:00">Asia/Hong_Kong</option>
                                        <option value="+07:00">Asia/Hovd</option>
                                        <option value="+08:00">Asia/Irkutsk</option>
                                        <option value="+07:00">Asia/Jakarta</option>
                                        <option value="+09:00">Asia/Jayapura</option>
                                        <option value="+02:00">Asia/Jerusalem</option>
                                        <option value="+04:30">Asia/Kabul</option>
                                        <option value="+12:00">Asia/Kamchatka</option>
                                        <option value="+05:00">Asia/Karachi</option>
                                        <option value="+05:45">Asia/Kathmandu</option>
                                        <option value="+09:00">Asia/Khandyga</option>
                                        <option value="+05:30">Asia/Kolkata</option>
                                        <option value="+07:00">Asia/Krasnoyarsk</option>
                                        <option value="+08:00">Asia/Kuala_Lumpur</option>
                                        <option value="+08:00">Asia/Kuching</option>
                                        <option value="+03:00">Asia/Kuwait</option>
                                        <option value="+08:00">Asia/Macau</option>
                                        <option value="+10:00">Asia/Magadan</option>
                                        <option value="+08:00">Asia/Makassar</option>
                                        <option value="+08:00">Asia/Manila</option>
                                        <option value="+04:00">Asia/Muscat</option>
                                        <option value="+02:00">Asia/Nicosia</option>
                                        <option value="+07:00">Asia/Novokuznetsk</option>
                                        <option value="+06:00">Asia/Novosibirsk</option>
                                        <option value="+06:00">Asia/Omsk</option>
                                        <option value="+05:00">Asia/Oral</option>
                                        <option value="+07:00">Asia/Phnom_Penh</option>
                                        <option value="+07:00">Asia/Pontianak</option>
                                        <option value="+08:30">Asia/Pyongyang</option>
                                        <option value="+03:00">Asia/Qatar</option>
                                        <option value="+06:00">Asia/Qyzylorda</option>
                                        <option value="+06:30">Asia/Rangoon</option>
                                        <option value="+03:00">Asia/Riyadh</option>
                                        <option value="+10:00">Asia/Sakhalin</option>
                                        <option value="+05:00">Asia/Samarkand</option>
                                        <option value="+09:00">Asia/Seoul</option>
                                        <option value="+08:00">Asia/Shanghai</option>
                                        <option value="+08:00">Asia/Singapore</option>
                                        <option value="+11:00">Asia/Srednekolymsk</option>
                                        <option value="+08:00">Asia/Taipei</option>
                                        <option value="+05:00">Asia/Tashkent</option>
                                        <option value="+04:00">Asia/Tbilisi</option>
                                        <option value="+03:30">Asia/Tehran</option>
                                        <option value="+06:00">Asia/Thimphu</option>
                                        <option value="+09:00">Asia/Tokyo</option>
                                        <option value="+08:00">Asia/Ulaanbaatar</option>
                                        <option value="+06:00">Asia/Urumqi</option>
                                        <option value="+10:00">Asia/Ust-Nera</option>
                                        <option value="+07:00">Asia/Vientiane</option>
                                        <option value="+10:00">Asia/Vladivostok</option>
                                        <option value="+09:00">Asia/Yakutsk</option>
                                        <option value="+05:00">Asia/Yekaterinburg</option>
                                        <option value="+04:00">Asia/Yerevan</option>
                                    </optgroup>
                                    <optgroup label="Atlantic">
                                        <option value="-01:00">Atlantic/Azores</option>
                                        <option value="-04:00">Atlantic/Bermuda</option>
                                        <option value="+00:00">Atlantic/Canary</option>
                                        <option value="-01:00">Atlantic/Cape_Verde</option>
                                        <option value="+00:00">Atlantic/Faroe</option>
                                        <option value="+00:00">Atlantic/Madeira</option>
                                        <option value="+00:00">Atlantic/Reykjavik</option>
                                        <option value="-02:00">Atlantic/South_Georgia</option>
                                        <option value="+00:00">Atlantic/St_Helena</option>
                                        <option value="-03:00">Atlantic/Stanley</option>
                                    </optgroup>
                                    <optgroup label="Australia">
                                        <option value="+10:30">Australia/Adelaide</option>
                                        <option value="+10:00">Australia/Brisbane</option>
                                        <option value="+10:30">Australia/Broken_Hill</option>
                                        <option value="+11:00">Australia/Currie</option>
                                        <option value="+09:30">Australia/Darwin</option>
                                        <option value="+08:45">Australia/Eucla</option>
                                        <option value="+11:00">Australia/Hobart</option>
                                        <option value="+10:00">Australia/Lindeman</option>
                                        <option value="+11:00">Australia/Lord_Howe</option>
                                        <option value="+11:00">Australia/Melbourne</option>
                                        <option value="+08:00">Australia/Perth</option>
                                        <option value="+11:00">Australia/Sydney</option>
                                    </optgroup>
                                    <optgroup label="Europe">
                                        <option value="+01:00">Europe/Amsterdam</option>
                                        <option value="+01:00">Europe/Andorra</option>
                                        <option value="+02:00">Europe/Athens</option>
                                        <option value="+01:00">Europe/Belgrade</option>
                                        <option value="+01:00">Europe/Berlin</option>
                                        <option value="+01:00">Europe/Bratislava</option>
                                        <option value="+01:00">Europe/Brussels</option>
                                        <option value="+02:00">Europe/Bucharest</option>
                                        <option value="+01:00">Europe/Budapest</option>
                                        <option value="+01:00">Europe/Busingen</option>
                                        <option value="+02:00">Europe/Chisinau</option>
                                        <option value="+01:00">Europe/Copenhagen</option>
                                        <option value="+00:00">Europe/Dublin</option>
                                        <option value="+01:00">Europe/Gibraltar</option>
                                        <option value="+00:00">Europe/Guernsey</option>
                                        <option value="+02:00">Europe/Helsinki</option>
                                        <option value="+00:00">Europe/Isle_of_Man</option>
                                        <option value="+02:00">Europe/Istanbul</option>
                                        <option value="+00:00">Europe/Jersey</option>
                                        <option value="+02:00">Europe/Kaliningrad</option>
                                        <option value="+02:00">Europe/Kiev</option>
                                        <option value="+00:00">Europe/Lisbon</option>
                                        <option value="+01:00">Europe/Ljubljana</option>
                                        <option value="+00:00">Europe/London</option>
                                        <option value="+01:00">Europe/Luxembourg</option>
                                        <option value="+01:00">Europe/Madrid</option>
                                        <option value="+01:00">Europe/Malta</option>
                                        <option value="+02:00">Europe/Mariehamn</option>
                                        <option value="+03:00">Europe/Minsk</option>
                                        <option value="+01:00">Europe/Monaco</option>
                                        <option value="+03:00">Europe/Moscow</option>
                                        <option value="+01:00">Europe/Oslo</option>
                                        <option value="+01:00">Europe/Paris</option>
                                        <option value="+01:00">Europe/Podgorica</option>
                                        <option value="+01:00">Europe/Prague</option>
                                        <option value="+02:00">Europe/Riga</option>
                                        <option value="+01:00">Europe/Rome</option>
                                        <option value="+04:00">Europe/Samara</option>
                                        <option value="+01:00">Europe/San_Marino</option>
                                        <option value="+01:00">Europe/Sarajevo</option>
                                        <option value="+03:00">Europe/Simferopol</option>
                                        <option value="+01:00">Europe/Skopje</option>
                                        <option value="+02:00">Europe/Sofia</option>
                                        <option value="+01:00">Europe/Stockholm</option>
                                        <option value="+02:00">Europe/Tallinn</option>
                                        <option value="+01:00">Europe/Tirane</option>
                                        <option value="+02:00">Europe/Uzhgorod</option>
                                        <option value="+01:00">Europe/Vaduz</option>
                                        <option value="+01:00">Europe/Vatican</option>
                                        <option value="+01:00">Europe/Vienna</option>
                                        <option value="+02:00">Europe/Vilnius</option>
                                        <option value="+03:00">Europe/Volgograd</option>
                                        <option value="+01:00">Europe/Warsaw</option>
                                        <option value="+01:00">Europe/Zagreb</option>
                                        <option value="+02:00">Europe/Zaporozhye</option>
                                        <option value="+01:00">Europe/Zurich</option>
                                    </optgroup>
                                    <optgroup label="Indian">
                                        <option value="+03:00">Indian/Antananarivo</option>
                                        <option value="+06:00">Indian/Chagos</option>
                                        <option value="+07:00">Indian/Christmas</option>
                                        <option value="+06:30">Indian/Cocos</option>
                                        <option value="+03:00">Indian/Comoro</option>
                                        <option value="+05:00">Indian/Kerguelen</option>
                                        <option value="+04:00">Indian/Mahe</option>
                                        <option value="+05:00">Indian/Maldives</option>
                                        <option value="+04:00">Indian/Mauritius</option>
                                        <option value="+03:00">Indian/Mayotte</option>
                                        <option value="+04:00">Indian/Reunion</option>
                                    </optgroup>
                                    <optgroup label="Pacific">
                                        <option value="+14:00">Pacific/Apia</option>
                                        <option value="+13:00">Pacific/Auckland</option>
                                        <option value="+11:00">Pacific/Bougainville</option>
                                        <option value="+13:45">Pacific/Chatham</option>
                                        <option value="+10:00">Pacific/Chuuk</option>
                                        <option value="-05:00">Pacific/Easter</option>
                                        <option value="+11:00">Pacific/Efate</option>
                                        <option value="+13:00">Pacific/Enderbury</option>
                                        <option value="+13:00">Pacific/Fakaofo</option>
                                        <option value="+12:00">Pacific/Fiji</option>
                                        <option value="+12:00">Pacific/Funafuti</option>
                                        <option value="-06:00">Pacific/Galapagos</option>
                                        <option value="-09:00">Pacific/Gambier</option>
                                        <option value="+11:00">Pacific/Guadalcanal</option>
                                        <option value="+10:00">Pacific/Guam</option>
                                        <option value="-10:00">Pacific/Honolulu</option>
                                        <option value="-10:00">Pacific/Johnston</option>
                                        <option value="+14:00">Pacific/Kiritimati</option>
                                        <option value="+11:00">Pacific/Kosrae</option>
                                        <option value="+12:00">Pacific/Kwajalein</option>
                                        <option value="+12:00">Pacific/Majuro</option>
                                        <option value="-09:30">Pacific/Marquesas</option>
                                        <option value="-11:00">Pacific/Midway</option>
                                        <option value="+12:00">Pacific/Nauru</option>
                                        <option value="-11:00">Pacific/Niue</option>
                                        <option value="+11:00">Pacific/Norfolk</option>
                                        <option value="+11:00">Pacific/Noumea</option>
                                        <option value="-11:00">Pacific/Pago_Pago</option>
                                        <option value="+09:00">Pacific/Palau</option>
                                        <option value="-08:00">Pacific/Pitcairn</option>
                                        <option value="+11:00">Pacific/Pohnpei</option>
                                        <option value="+10:00">Pacific/Port_Moresby</option>
                                        <option value="-10:00">Pacific/Rarotonga</option>
                                        <option value="+10:00">Pacific/Saipan</option>
                                        <option value="-10:00">Pacific/Tahiti</option>
                                        <option value="+12:00">Pacific/Tarawa</option>
                                        <option value="+13:00">Pacific/Tongatapu</option>
                                        <option value="+12:00">Pacific/Wake</option>
                                        <option value="+12:00">Pacific/Wallis</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <!------------------------- END FORM ----------------------->

                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-2 col-md-9">
                                <button type="button" onclick="updateSetting({{ $company->id }})"
                                        data-loading-text="{{trans('core.btnUpdating')}}..."
                                        class="btn green">{{trans('core.btnUpdate')}}</button>

                            </div>
                        </div>
                    </div>
                    {!!  Form::close()  !!}
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->

            </div>
        </div>
    </div>
    <!-- END PAGE CONTENT-->



@stop

@section('footerjs')

    <!-- BEGIN PAGE LEVEL PLUGINS -->
    {!! HTML::script("assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js") !!}
    {!! HTML::script('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') !!}
    {!! HTML::script('assets/global/plugins/select2/js/select2.min.js') !!}
    {!! HTML::script('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js') !!}
    {!! HTML::script('assets/admin/pages/scripts/components-dropdowns.js') !!}



    <script>
        jQuery(document).ready(function () {
            $.fn.select2.defaults.set("theme", "bootstrap");
            $('.select2me').select2({
                placeholder: "Select",
                width: '100%',
                allowClear: false
            });

            function formatState(state) {
                if (!state.id) {
                    return state.text;
                }
                var $state = $(
                    '<span><img src="{{ asset('assets/global/img/flags') }}/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
                );
                return $state;
            };

            $("#select_lang").select2({
                placeholder: "Select a Language",
                templateResult: formatState,
                templateSelection: formatState
            });

            $("#timezone option:eq('{{ $company->timezone_index }}')").prop('selected', true).change();

            $('#timezone').change(function () {
                var newSelectedIndex = $("#timezone")[0].selectedIndex;
                $('#timezoneIndex').val(newSelectedIndex);
            });

        });

        function updateSetting(id) {
            var url = "{{ route('admin.companies.update',':id') }}";
            url = url.replace(':id', id);
            $.easyAjax({
                type: 'POST',
                url: url,
                container: '.ajax_form',
                file: true,
            });
        }
    </script>
    <!-- END PAGE LEVEL PLUGINS -->
@stop
