<?php

namespace App\Http\Requests\Backend\Books;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
                    'name'                    => 'required|max:255|unique:books',
                    'book_category_id'        => 'required',
                    'content'                 => 'sometimes|nullable',
                    'pdf_files'               =>'required',
                    'pdf_files.*'             =>'required|mimes:doc,pdf,docx,zip',
                    'photo'                   =>'sometimes|nullable|image|mimes:png,jpg,jpeg,gif,bmp,webp,svg',
                    'publish_date'            =>'required',
                    'status'                  =>'required',
                    'keywords'                =>'required',
                    'description'             =>'required',



                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'                   => 'required|max:255',
                    'book_category_id'       => 'required',
                    'content'                => 'sometimes|nullable',
                    'pdf_file'               =>'sometimes|nullable',
                    'pdf_file.*'             =>'mimes:doc,pdf,docx,zip',
                    'photo'                  =>'image|mimes:png,jpg,jpeg,gif,bmp,webp,svg',
                    'publish_date'           =>'required',
                    'status'                 =>'required',
                    'keywords'               =>'required',
                    'description'            =>'required',
                ];
            }
            default: break;
        }
    }
}