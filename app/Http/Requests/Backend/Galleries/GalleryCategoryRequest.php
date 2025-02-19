<?php

namespace App\Http\Requests\Backend\Galleries;

use Illuminate\Foundation\Http\FormRequest;

class GalleryCategoryRequest extends FormRequest
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
                    'name'          => 'required|max:255|unique:gallery_categories',
                    'status'        => 'required',
                    'image'         =>'sometimes|nullable|image|mimes:png,jpg,jpeg,gif,bmp,webp,svg',

                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'          => 'required|max:255',
                    'status'        => 'required',
                    'image'         =>'sometimes|nullable|image|mimes:png,jpg,jpeg,gif,bmp,webp,svg',

                ];
            }
            default: break;
        }
    }

    }
