<?php

namespace App\Http\Requests\Backend\Galleries;

use Illuminate\Foundation\Http\FormRequest;

class SliderRequest extends FormRequest
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
                    'title'              => 'sometimes|nullable|unique:sliders',
                    'image'              =>'required|image|mimes:png,jpg,jpeg,gif,bmp,webp,svg',
                    'link'               =>'sometimes|nullable|url',
                    'status'             =>'required',


                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title'                   =>'sometimes|nullable|max:255',
                    'link'                    =>'sometimes|nullable|url',
                    'status'                  =>'required',
                    'image'                   =>'required|image|mimes:png,jpg,jpeg,gif,bmp,webp,svg',


                ];
            }
            default: break;
        }
    }
}