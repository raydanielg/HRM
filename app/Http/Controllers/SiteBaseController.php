<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Routing\Controller;

class SiteBaseController extends Controller
{

    /**
     * @var array
     */
    public $data = [];

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
     * @return mixed
     */
    public function __get($name)
    {
        return $this->data[$name];
    }

    /**
     * @param $name
     * @return bool
     */
    public function __isset($name)
    {
        return isset($this->data[$name]);
    }


    public function __construct()
    {


        try {
            \DB::connection()->getPdo();
            $this->setting = Setting::first();
            $this->setting->currency = is_null($this->setting->currency) ? 'USD' : $this->setting->currency;
            $this->setting->currency_symbol = is_null($this->setting->currency_symbol) ? '$' : $this->setting->currency_symbol;
        } catch (\Exception $e) {

        }


    }


}

