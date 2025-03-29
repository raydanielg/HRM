@extends("site.app")
@section("title")
    System Requirements - {{ $setting->main_name }}
@endsection

@section("content")
    <section id="features">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="container">
                <h2>System Requirements for {{ $setting->main_name }}</h2>

                <div class="row">
                    <div class="col-md-12">
                        <p>Below is the list of requirements that the server, on which you host HRM version, should meet. <strong>Please make sure your server meets these requirements
                            before you purchase HRM. We provide limited support if these requirements are not met.</strong></p>
                        <p>&nbsp;</p>
                        <p><strong>1. Operating System: </strong> Ubuntu 12.04 or later, CentOS 6 or later, Windows 7 or later, Mac OS X 10.9 or later</p>
                        <p><strong>2. CPU, Memory, Hard Disc: </strong> Recommended 2.0GHz dual core processor, 4GB RAM, 10GB free disc space. <em>These are not
                            requirements but recommendations for smooth running of HRM. It can run on lower spec systems too.</em></p>
                        <p><strong>3. Web Server: </strong> Apache v2.2 or later</p>
                        <p><strong>4. PHP: </strong> PHP v5.5 or later</p>
                        <p><strong>5. MySQL: </strong> MySQL v5.5 or later</p>
                        <p><strong>6. Apache Modules: </strong> Rewrite</p>
                        <p><strong>7. PHP Modules: </strong> Curl, Mcrypt, Fileinfo</p>

                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
    </section>
@endsection
