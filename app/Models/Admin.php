<?php

namespace App\Models;

use Dialect\Gdpr\EncryptsAttributes;
use Dialect\Gdpr\Portable;
use Illuminate\Auth\UserTrait;

use Illuminate\Auth\Reminders\RemindableTrait;
//use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
//use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;
use Illuminate\Database\Eloquent\Builder;

class Admin extends \Eloquent implements Authenticatable, CanResetPasswordContract
{
    use  Portable,AuthenticableTrait, CanResetPassword;


    protected $hidden = ['password', 'remember_token'];
    protected $fillable = ['name', 'email', 'password', 'company_id', 'manager', 'last_activity',
        'accepted_gdpr',
        'isAnonymized'];

    public function checkEmailVerified()
    {
        if ($this->email_verified == 'yes') {
            return true;
        }
        return false;

    }


    public function scopeManagers($query, $id)
    {
        return $query->where('company_id', '=', $id)->where('type', 'admin')->where('manager', 1);
    }

    public function scopeDepart($query, $id)
    {
        return $query->join('department_manager', 'department_manager.manager_id', '=', 'admins.id')
            ->where('type', 'admin')->where('manager', 1);
    }

    protected function DepartmentManager()
    {
        return $this->hasMany('App\Models\DepartmentManager', 'manager_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public $preventAttrSet = false;

    public function toPortableArray()
    {
        $array = $this->toArray();

        // Customize array...

        return $array;
    }

    public function getEncrypted()
    {
        return $this->encrypted;
    }

    public function getAttributeValue($key)
    {
        $value = parent::getAttributeValue($key);

        if (in_array($key, $this->encrypted) &&
            !is_null($value)) {
            $gdpr = Setting::first()->gdpr;

            if (!$this->preventAttrSet && $gdpr) {
                $value = decrypt($value);
            }
        }

        return $value;
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string $key
     * @param  mixed $value
     * @return $this
     */
    public function setAttribute(
        $key,
        $value
    )
    {
        if (in_array($key, $this->encrypted) &&
            !is_null($value)) {
            $gdpr = Setting::first()->gdpr;

            if (!$this->preventAttrSet && $gdpr ===1) {
                $value = encrypt($value);
            }
        }

        parent::setAttribute($key, $value);
    }

    /**
     * Return Model in array type, with all datas decrypted.
     * @return array
     */
    public function decryptToArray()
    {
        $model = [];
        foreach ($this->attributes as $attributeKey => $attributeValue) {
            $model[$attributeKey] = $this->$attributeKey;
        }

        return $model;
    }

    /**
     * Return Model in collection type, with all datas decrypted.
     * @return array
     */
    public function decryptToCollection()
    {
        $model = collect();
        foreach ($this->attributes as $attributeKey => $attributeValue) {
            $model->$attributeKey = $this->$attributeKey;
        }

        return $model;
    }

    protected $encrypted = ['name'];
}
