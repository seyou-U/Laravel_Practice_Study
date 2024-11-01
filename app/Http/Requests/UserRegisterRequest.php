<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
{
    /**
     * リクエストに対する権限を設定する
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * バリデーションルールを設定する
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:20',
            'email' => 'required|email|max:255',
        ];
    }
}
