<?php

namespace App\Models;
class Setting extends \Eloquent
{

    // Add your validation rules here
    public static $rules = [
        'main_name' => 'required',
        'email' => 'required|email',
        'name' => 'required',
        'logo' => 'image|mimes:jpeg,jpg,png,bmp,gif,svg|max:1000'

    ];

    protected $guarded = ['id'];
    protected $appends = ['logo_image_url','set_smtp_message'];

    public function getLangName()
    {
        return $this->belongsTo('App\Models\Language', 'locale', 'locale');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id');
    }

    public function getLogoImageUrlAttribute($size = 150, $d = 'mm')
    {
        if (is_null($this->logo)) {
            return $url = asset('assets/admin/layout/img/hrm-logo-full.png');
        }

        if (strpos($this->logo, 'https://') !== false) {
            return $image = str_replace('type=normal', 'type=large', $this->logo);
        }

        return asset_url('setting/logo/' . $this->logo);
    }


    public function verifySmtp()
    {
        if($this->mail_driver =='smtp'){
            try {
                $transport = new \Swift_SmtpTransport($this->mail_host, $this->mail_port, $this->mail_encryption);
                $transport->setUsername($this->mail_username);
                $transport->setPassword($this->mail_password);

                $mailer = new \Swift_Mailer($transport);
                $mailer->getTransport()->start();

                if($this->verified == 0){
                    $this->verified = 1;
                    $this->save();
                }

                return [
                    'success' => true,
                    'message' => __('messages.smtpSuccess')
                ];


            } catch (\Swift_TransportException $e) {
                $this->verified = 0;
                $this->save();
                return [
                    'success' => false,
                    'message' => $e->getMessage()
                ];

            } catch (\Exception $e) {
                $this->verified = 0;
                $this->save();
                return [
                    'success' => false,
                    'message' => $e->getMessage()
                ];
            }
        }
    }

    public function getSetSmtpMessageAttribute(){
        if ($this->verified === 0 && $this->mail_driver == 'smtp') {
            return ' <div class="alert alert-danger">
                    '.__('messages.smtpNotSet').'
                    <a href="'.route('admin.smtp_settings').'" class="btn btn-info btn-small">Visit SMTP Settings <i
                                class="fa fa-arrow-right"></i></a>
                </div>';
        }
        return null;
    }
}
