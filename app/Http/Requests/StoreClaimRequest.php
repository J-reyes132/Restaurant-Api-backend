<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreClaimRequest extends FormRequest
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
            'names' => 'required|string',
            'lastnames' => 'required|string',
            'identification_document' => 'required|string',
            'gender' => 'required|string',
            'sector' => 'required|string',
            'street' => 'required|string',
            'house_number' => 'required|string',
            'reference_phone_number' => 'required|string|regex:/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im',
            'phone_number' => 'required|string|regex:/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im',
            'email' => 'required|string|email:rfc,dns',
            
            'service' => 'required|integer',
            'claim_type' => 'required|integer',
            'claim_provision_service' => 'required|integer',
            'claim_receive_reply' => 'required|integer',

            'evidence' => 'nullable|mimes:png,jpg,jgpeg|max:5000',
            'claim_date' => 'required|date',
            'claim_description' => 'required|string'
        ];

        
    }
}
