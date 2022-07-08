<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            "name" => "required",
            "email" => [
                "required",
                "email",
                "unique:users",
            ],
            "password" => "required",
            "password_check" => "same:password"
        ];
    }
    public function messages() {
        return [
            "name.required" => "名前は必須です。",
            "email.required" => "メールアドレスは必須です。",
            "email.email" => "メールアドレス形式で入力してください。",
            "email.unique:users" => "登録済みのメールアドレスです。",
            "password.required" => "パスワードは必須です。",
            "password_check.same" => "パスワードと確認用パスワードが一致しません。"
        ];
    }
}
