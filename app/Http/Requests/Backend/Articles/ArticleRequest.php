<?php

namespace App\Http\Requests\Backend\Articles;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
                    'name'                   => 'required|max:255|unique:articles',
                    'article_category_id'     => 'required',
                    'content'                => 'sometimes|nullable',
                    'pdf_files'               => 'sometimes|nullable',
                    'pdf_files.*'             =>'mimes:doc,pdf,docx,zip',
                    'photo'                  =>'sometimes|nullable|image|mimes:png,jpg,jpeg,gif,bmp,webp,svg',
                    'publish_date'            =>'required',
                    'status'                  =>'required',
                    'youtube_link'             =>'url|sometimes|nullable',
                    'audio_file'               =>'sometimes|nullable|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
                    'video_file'               =>'sometimes|nullable|mimes:mp4,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv',
                    'embed_link'               =>'url|sometimes|nullable',
                    'keywords'                =>'required',
                    'description'             =>'required',



                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'                   => 'required|max:255',
                    'article_category_id'     => 'required',
                    'content'                => 'sometimes|nullable',
                    'pdf_file'               => 'sometimes|nullable',
                    'pdf_file.*'             =>'mimes:doc,pdf,docx,zip',
                    'photo'                   =>'image|mimes:png,jpg,jpeg,gif,bmp,webp,svg',
                    'publish_date'           =>'required',
                    'status'                 =>'required',
                    'youtube_link'           =>'url|sometimes|nullable',
                    'audio_file'             =>'sometimes|nullable|mimes:application/octet-stream,audio/mpeg,mpga,mp3,wav',
                    'video_file'               =>'sometimes|nullable|mimes:mp4,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv',
                    'embed_link'             =>'url|sometimes|nullable',
                    'keywords'               =>'required',
                    'description'            =>'required',
                ];
            }
            default: break;
        }
    }
}