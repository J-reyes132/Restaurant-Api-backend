<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
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
            'document' => 'required|max:20000|mimes:pdf,docx,doc',
            'description' => 'required|string|',
            'category_id' => 'required|integer',
            'institution_id' => 'required|integer'
        ];
    }
}
