<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

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
            'country' => 'required|string',
            'region' => 'required|string',
            'ward' => 'required|string',
            'street' => 'required|string',
            'file_path' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg,pdf,doc,docx,txt|max:2048',
            'code' => 'nullable|string',
            'visibility' => 'nullable|boolean',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        
        $this->merge([
            'code' => $this->code ?? Str::random(10),
            'visibility' => $this->visibility ?? 0,
        ]);
    }
}
