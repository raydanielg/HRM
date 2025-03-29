<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Froiden\Envato\Traits\AppBoot;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Artisan;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests,AppBoot;
    public $data = [];

    /**
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data[$name];
    }

    /**
     * @param $name
     * @param $value
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }

    /**
     * BaseController constructor.
     */
    public function __construct()
    {
        $this->showInstall();
        $this->checkMigrateStatus();

        $this->setting = Setting::first();
        $this->middleware(function ($request, $next) {
            if (admin() && admin()->type === 'superadmin') {
                config(['froiden_envato.allow_users_id' => true]);
            }
            return $next($request);
        });
    }


    public static function getIpInfo($ip, $purpose = "location")
    {
        $output = NULL;

        if (filter_var($ip, FILTER_VALIDATE_IP) === FALSE) {
            $ip = $_SERVER["REMOTE_ADDR"];
        }


        if ($ip == "127.0.0.1" || $ip == "::1") {
            // Set to a dummy ip for local debugging
            //            $ip = "117.241.96.133";
            $ip = "117.241.98.90";
        }


        $purpose = str_replace(array("name", "\n", "\t", " ", "-", "_"), NULL, strtolower(trim($purpose)));
        $support = array("country", "countrycode", "state", "region", "city", "location", "timezone");

        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents("http://ip-api.com/json/" . $ip));

            if (@strlen(trim($ipdat->countryCode)) == 2) {
                switch ($purpose) {
                    case "location":
                        $output = array(
                            "city" => @$ipdat->city,
                            "region" => @$ipdat->regionName,
                            "country" => @$ipdat->country,
                            "country_code" => @$ipdat->countryCode,
                            "timezone" => @$ipdat->timezone
                        );
                        break;
                    case "city":
                        $output = @$ipdat->city;
                        break;
                    case "region":
                        $output = @$ipdat->regionName;
                        break;
                    case "country":
                        $output = @$ipdat->country;
                        break;
                    case "countrycode":
                        $output = @$ipdat->countryCode;
                        break;
                }
            }
        }
        return $output;
    }

    public function checkMigrateStatus()
    {
        $status = Artisan::call('migrate:check');
        if ($status) {
            Artisan::call('migrate', array('--force' => true)); //migrate database
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
        }
    }
}
