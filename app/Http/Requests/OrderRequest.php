<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function rules()
    {
        return [
            "firstname" => "required",
            "lastname" => "required",
            "email" => "required|email",
            "street_name" => "required",
            "city" => "required",
            "phone" => "required|digits:10",
            "total_amount" => "required|numeric",
            "pin" => "required|digits:6",
            "state" => "required",
        ];
    }
}