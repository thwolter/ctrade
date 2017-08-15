<?php

namespace App\Http\Requests;

use App\Entities\User;
use Illuminate\Foundation\Http\FormRequest;

class ChangePassword extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'oldpassword' => 'required_with:password',
            'password' => 'required|confirmed|min:6',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {

            $hasher = app('hash');

            if (! $hasher->check($this->oldpassword, User::find($this->id)->password)) {
                $validator->errors()->add('oldpassword', trans('profile.password'));
            }
        });
    }

}
