<?php

namespace App\Http\Requests\Backend\Audioes;

use Illuminate\Foundation\Http\FormRequest;

class AudioRequest extends FormRequest
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
                    'name'                    => 'required|max:255|unique:audioes',
                    'audio_category_id'       => 'sometimes|nullable',
                    'publish_date'            =>'required',
                    'status'                  =>'required',
                    'audio_file'              =>'sometimes|nullable|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
                    'embed_link'              =>'url|sometimes|nullable',
                    'keywords'                =>'required',
                    'description'             =>'required',



                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'                   => 'required|max:255',
                    'audio_category_id'      => 'sometimes|nullable',
                    'publish_date'           =>'required',
                    'status'                 =>'required',
                    'audio_file'             =>'sometimes|nullable|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
                    'embed_link'             =>'url|sometimes|nullable',
                    'keywords'               =>'required',
                    'description'            =>'required',
                ];
            }
            default: break;
        }
    }
}