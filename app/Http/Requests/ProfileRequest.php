<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        // return [
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => [
        //         'required',
        //         'string',
        //         'lowercase',
        //         'email',
        //         'max:255',
        //         Rule::unique(User::class)->ignore($this->user()->id),
        //     ],
        //     'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:1024',
        // ];
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'password' => ['required', 'confirmed'],
            'password_confirmation' => ['required'],
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:1024',
        ];
    }
}
