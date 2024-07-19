<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnonIssueRequest extends FormRequest
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
			'title' => 'required|string',
			'description' => 'required|string',
			'status' => 'required|string',
			'country_id' => 'required',
			'region_id' => 'required',
			'district_id' => 'required',
			'ward_id' => 'required',
			'street_id' => 'required',
			'file_path' => 'string',
			'code' => 'required|string',
			'visibility' => 'required',
        ];
    }
}
