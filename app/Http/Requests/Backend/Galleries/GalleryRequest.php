<?php

namespace App\Http\Requests\Backend\Galleries;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
            {
                return [
                    'title'                   => 'required|max:255|unique:galleries',
                    'gallery_category_id'     => 'required',
                    'status'                  =>'required',


                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title'                   => 'required|max:255',
                    'gallery_category_id'     => 'required',
                    'status'                 =>'required',

                ];
            }
            default: break;
        }
    }
}
