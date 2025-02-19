<?php

namespace App\Http\Requests\Backend\Galleries;

use Illuminate\Foundation\Http\FormRequest;

class MatwiaatRequest extends FormRequest
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
                    'title'         => 'required|max:255',
                    'status'        => 'required',
                    'image'         =>'sometimes|nullable|image|mimes:png,jpg,jpeg,gif,bmp,webp,svg',
                    'pdf_file'      =>'required|mimes:doc,pdf,docx,zip',

                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'title'         => 'required|max:255',
                    'status'        => 'required',
                    'image'         =>'sometimes|nullable|image|mimes:png,jpg,jpeg,gif,bmp,webp,svg',
                    'pdf_file'      =>'mimes:doc,pdf,docx,zip',

                ];
            }
            default: break;
        }
    }

    }