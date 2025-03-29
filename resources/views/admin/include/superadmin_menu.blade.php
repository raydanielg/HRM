<li class="nav-item start {{ isset($superadmindashboardActive) ? $superadmindashboardActive : ''}}">
    <a class="nav-link"
       href="javascript: loadView('{{URL::route('superadmin.dashboard.index')}}')">
        <i class="fa fa-home"></i>
        <span class="title">{{__('menu.dashboard')}}</span>
        <span class="selected"></span>
    </a>
</li>
{{---------------------------------------/Super AdminDashboard-------------------------------}}
{{---------------------------------------Companies-------------------------------}}
<li class="nav-item {{ isset($companyActive) ? $companyActive : ''}}">
    <a class="nav-link"
       href="javascript: loadView('{{route('admin.companies.index')}}')">
        <i class="fa fa-th-large"></i>
        <span class="title">Companies</span>
        <span class="selected "></span>
    </a>
</li>


<li class="nav-item {{ isset($contactRequestActive) ? $contactRequestActive : ''}}">
    <a class="nav-link"
       href="javascript: loadView('{{route('admin.contact_requests.index')}}')">
        <i class="fa fa-envelope"></i>
        Contact Requests</a>
</li>


<li class="nav-item {{ isset($licenseTypesActive) ? $licenseTypesActive : ''}}">
    <a class="nav-link"
       href="javascript: loadView('{{route('admin.plans.index')}}')">
        <i class="fa fa-paper-plane"></i>
        Subscription Plans</a>
</li>

<li class="nav-item {{ isset($invoicesActive) ? $invoicesActive : ''}}">
    <a class="nav-link"
       href="javascript: loadView('{{route('admin.invoices.index')}}')">
        <i class="fa fa-file"></i>
        Invoices</a>
</li>

<li class="nav-item {{ isset($superAdminUserActive) ? $superAdminUserActive : ''}}">
    <a class="nav-link"
       href="javascript: loadView('{{route('admin.superadmin_users.index')}}')">
        <i class="fa fa-user"></i>
        SuperAdmins</a>
</li>
<li class="menu-dropdown classic-menu-dropdown {{ isset($faqCategoryActive) ? $faqCategoryActive : '' }}">
    <a href="javascript:;">
        <i class="icon-user"></i> CMS
        <i class="fa fa-angle-down"></i>
    </a>
    <ul class="dropdown-menu pull-left">

        <li class="nav-item {{ isset($faqCategoryActive) ? $faqCategoryActive : ''}}">
            <a class="nav-link"
               href="javascript: loadView('{{route('admin.faq_categories.index')}}')">
                <i class="fa fa-file-text"></i>
                FAQ Category</a>
        </li>

        <li class="nav-item {{ isset($faqActive) ? $faqActive : ''}}">
            <a class="nav-link"
               href="javascript: loadView('{{route('admin.faq.index')}}')">
                <i class="fa fa-support"></i>
                FAQ</a>
        </li>


        <li class="nav-item {{ isset($featureActive) ? $featureActive : ''}}">
            <a class="nav-link"
               href="javascript: loadView('{{route('admin.features.index')}}')">
                <i class="fa fa-briefcase"></i>
                Features</a>
        </li>

    </ul>
</li>

<li class="menu-dropdown classic-menu-dropdown {{ isset($settingActive) ? $settingActive : '' }}">
    <a href="javascript:;">
        <i class="fa fa-cog"></i> Settings
        <i class="fa fa-angle-down"></i>
    </a>
    <ul class="dropdown-menu pull-left">

        <li class="nav-item {{ isset($generalSettingActive) ? $generalSettingActive : ''}}">
            <a class="nav-link"
               href="javascript: loadView('{{route('admin.settings.edit','setting')}}')">
                <i class="fa  fa-cog"></i>
                {{__('menu.generalSetting')}}</a>
        </li>

        <li class="nav-item {{ isset($emailTemplateActive) ? $emailTemplateActive : ''}}">
            <a class="nav-link"
               href="javascript: loadView('{{route('admin.email_templates.index')}}')">
                <i class="icon-envelope"></i>
                {{__('menu.emailTemplate')}}</a>
        </li>

        <li class="nav-item {{ isset($stripeSettingActive) ? $stripeSettingActive : ''}}">
            <a class="nav-link"
               href="javascript: loadView('{{route('admin.stripe_settings')}}')">
                <i class="fa fa-cc-stripe"></i>
                {{__('menu.stripeSetting')}}</a>
        </li>
        @if(env('APP_ENV') !=='demo')
            <li class="nav-item">
                <a class="nav-link"
                   href="{{action('\Barryvdh\TranslationManager\Controller@getIndex')}}">
                    <i class="fa fa-language"></i>
                    {{__('menu.translationManager')}}</a>
            </li>
        @endif
        <li class="nav-item">
            <a class="nav-link"
               href="javascript:;" onclick="loadView('{{route('admin.updateVersion.index')}}')">
                <i class="fa fa-language"></i>
                {{__('menu.updateLog')}}</a>
        </li>

        <li class="nav-item {{ isset($smtpSettingActive) ? $smtpSettingActive : ''}}">
            <a class="nav-link"
               href="javascript: loadView('{{route('admin.smtp_settings')}}')">
                <i class="icon-envelope"></i>
                {{__('menu.smtpSetting')}}</a>
        </li>

        <li class="nav-item {{ isset($gdprSettingActive) ? $gdprSettingActive : ''}}">
            <a class="nav-link"
               href="javascript: loadView('{{route('admin.settings.gdpr')}}')">
                <i class="icon-envelope"></i>
                {{__('menu.gdprSetting')}}</a>
        </li>

    </ul>
</li>
