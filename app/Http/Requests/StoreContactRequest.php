<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
          'first_name' => ['required', 'string', 'max:255'],
          'last_name' => ['required', 'string', 'max:255'],

          'gender' => ['required', 'integer'],

          'email' => ['required', 'email', 'max:255'],
 
          'tel' => ['required', 'digits_between:10,11',],

          'address' => ['required', 'string', 'max:255'],

          'building' => ['nullable', 'string', 'max:255'],

          'category_id' => ['required', 'exists:categories,id'],

          'tag_ids' => [ 'nullable', 'array'],

          'tag_ids.*' => [ 'exists:tags,id',],

          'detail' => ['required', 'string'],
        ];
    }
}
