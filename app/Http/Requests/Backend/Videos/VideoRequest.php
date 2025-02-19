<?php

namespace App\Http\Requests\Backend\Videos;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
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
                    'name'                    => 'required|max:255|unique:videos',
                    'video_category_id'       => 'sometimes|nullable',
                    'publish_date'            =>'required',
                    'status'                  =>'required',
                    'video_file'              =>'sometimes|nullable|mimes:mp4,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv',
                    'youtube_link'            =>'url|sometimes|nullable',
                    'keywords'                =>'required',
                    'description'             =>'required',



                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'                   => 'required|max:255',
                    'video_category_id'      => 'sometimes|nullable',
                    'publish_date'           =>'required',
                    'status'                 =>'required',
                    'video_file'             =>'sometimes|nullable|mimes:mp4,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv',
                    'youtube_link'           =>'url|sometimes|nullable',
                    'keywords'               =>'required',
                    'description'            =>'required',
                ];
            }
            default: break;
        }
    }
}