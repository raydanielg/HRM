<?php

namespace App\Models;


class ReferralMember extends \Eloquent
{


    protected $guarded = ['id'];
    protected $table = "referral_member";

    public static $rules_add = [
        'email' => 'required|unique:referral_member,email',
        "password" => 'required',
        'name' => 'required',
        'agreement' => 'mimes:pdf,doc,docx,png,jpg,jpeg|max:4000',
    ];

    public static $rules_edit = [
        'email' => 'required|unique:referral_member,email,:id,id',
        "referral_code" => 'required|unique:referral_member,referral_code,:id,id',
        'name' => 'required',
        'agreement' => 'mimes:pdf,doc,docx,png,jpg,jpeg|max:4000',
    ];

    public static function rules($id = false, $merge = [])
    {
        $rules = self::$rules_edit;
        if ($id) {
            foreach ($rules as &$rule) {
                $rule = str_replace(':id', $id, $rule);
            }
        }

        return array_merge($rules, $merge);
    }
}
