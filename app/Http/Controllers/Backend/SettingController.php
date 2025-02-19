<?php

namespace App\Http\Controllers\Backend;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Traits\AttachFilesTrait;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    use AttachFilesTrait;

    public function index(Setting $setting)
    {
        if ($setting->all()->count() > 0) {

            $setting = Setting::find(1);
        }


        return view('backend.settings.index', compact('setting'));
    }


    public function update(Request $request)
    {
        $data = $this->validate(
            $request,
            [

                'logo'                  => 'nullable|image|mimes:png,jpg,jpeg,gif,bmp,svg,webp',
                'icon'                  => 'nullable|image|mimes:png,jpg,jpeg,gif,bmp,svg,webp',
                'slider_image'          => 'nullable|image|mimes:png,jpg,jpeg,gif,bmp,svg,webp',
                'lesson_banner'          => 'nullable|image|mimes:png,jpg,jpeg,gif,bmp,svg,webp',
                'lecture_banner'         => 'nullable|image|mimes:png,jpg,jpeg,gif,bmp,svg,webp',
                'book_banner'            => 'nullable|image|mimes:png,jpg,jpeg,gif,bmp,svg,webp',
                'speech_banner'          => 'nullable|image|mimes:png,jpg,jpeg,gif,bmp,svg,webp',
                'video_banner'           => 'nullable|image|mimes:png,jpg,jpeg,gif,bmp,svg,webp',
                'audio_banner'           => 'nullable|image|mimes:png,jpg,jpeg,gif,bmp,svg,webp',
                'gallery_banner'           => 'nullable|image|mimes:png,jpg,jpeg,gif,bmp,svg,webp',
                'article_banner'           => 'nullable|image|mimes:png,jpg,jpeg,gif,bmp,svg,webp',
                'benefit_banner'           => 'nullable|image|mimes:png,jpg,jpeg,gif,bmp,svg,webp',
                'matwiaat_banner'           => 'nullable|image|mimes:png,jpg,jpeg,gif,bmp,svg,webp',

                'email'                 => 'nullable|email',
                'phone'                 => 'nullable',
                'women_phone'           => 'nullable',
                'instagram'             => 'url|nullable',
                'facebook'              => 'url|nullable',
                'youtube'               => 'url|nullable',
                'twitter'               => 'url|nullable',
                'telegram'               => 'url|nullable',
                'about_sheikh'          => 'nullable',
                'site_name'              => 'nullable',
                'keywords'              => 'nullable',
                'description'           => 'nullable',
                'status'                => '',
                'message_maintenance'   => 'nullable',
                'site_right'             => 'nullable',

            ]
        );

        if ($request->hasFile('logo')) {

            //delete old image
            if ($data['logo'] != '') {
                if (File::exists('Files/settings/' . setting()->logo)) {
                    unlink('Files/settings/' . setting()->logo);
                }
            }
            if ($image = $request->file('logo')) {
                $img = $image->getClientOriginalName();
                $image->storeAs('settings/', $img, 'upload_attachments');
            }

            $data['logo'] = $img;
        }


        if ($request->hasFile('icon')) {
            //delete old image
            if ($data['icon'] != '') {
                if (File::exists('Files/settings/' . setting()->icon)) {
                    unlink('Files/settings/' . setting()->icon);
                }
            }

            if ($icon = $request->file('icon')) {
                $img_icon = $icon->getClientOriginalName();
                $icon->storeAs('settings/', $img_icon, 'upload_attachments');
            }

            $data['icon'] = $img_icon;
        }

        if ($request->hasFile('slider_image')) {
            //delete old image
            if ($data['slider_image'] != '') {
                if (File::exists('Files/settings/' . setting()->slider_image)) {
                    unlink('Files/settings/' . setting()->slider_image);
                }
            }

            if ($slider_image = $request->file('slider_image')) {
                $img_slider = $slider_image->getClientOriginalName();
                $slider_image->storeAs('settings/', $img_slider, 'upload_attachments');
            }

            $data['slider_image'] = $img_slider;
        }

        if ($request->hasFile('lesson_banner')) {
            //delete old image
            if ($data['lesson_banner'] != '') {
                if (File::exists('Files/settings/' . setting()->lesson_banner)) {
                    unlink('Files/settings/' . setting()->lesson_banner);
                }
            }

            if ($lesson_banner = $request->file('lesson_banner')) {
                $img_lesson = $lesson_banner->getClientOriginalName();
                $lesson_banner->storeAs('settings/', $img_lesson, 'upload_attachments');
            }

            $data['lesson_banner'] = $img_lesson;
        }

        if ($request->hasFile('gallery_banner')) {
            //delete old image
            if ($data['gallery_banner'] != '') {
                if (File::exists('Files/settings/' . setting()->gallery_banner)) {
                    unlink('Files/settings/' . setting()->gallery_banner);
                }
            }

            if ($gallery_banner = $request->file('gallery_banner')) {
                $img_gallery = $gallery_banner->getClientOriginalName();
                $gallery_banner->storeAs('settings/', $img_gallery, 'upload_attachments');
            }

            $data['gallery_banner'] = $img_gallery;
        }

        if ($request->hasFile('matwiaat_banner')) {
            //delete old image
            if (!empty($data['matwiaat_banner'])) {
                if (File::exists('Files/settings/'.setting()->matwiaat_banner)) {
                    unlink('Files/settings/'.setting()->matwiaat_banner);
                }
            }

            if ($matwiaat_banner = $request->file('matwiaat_banner')) {
                $img_matwiaat = $matwiaat_banner->getClientOriginalName();
                $matwiaat_banner->storeAs('settings/', $img_matwiaat, 'upload_attachments');
            }

            $data['matwiaat_banner'] = $img_matwiaat;
        }


        if ($request->hasFile('video_banner')) {
            //delete old image
            if ($data['video_banner'] != '') {
                if (File::exists('Files/settings/' . setting()->video_banner)) {
                    unlink('Files/settings/' . setting()->video_banner);
                }
            }

            if ($video_banner = $request->file('video_banner')) {
                $img_video = $video_banner->getClientOriginalName();
                $video_banner->storeAs('settings/', $img_video, 'upload_attachments');
            }

            $data['video_banner'] = $img_video;
        }

        if ($request->hasFile('audio_banner')) {
            //delete old image
            if ($data['audio_banner'] != '') {
                if (File::exists('Files/settings/' . setting()->audio_banner)) {
                    unlink('Files/settings/' . setting()->audio_banner);
                }
            }

            if ($audio_banner = $request->file('audio_banner')) {
                $img_audio = $audio_banner->getClientOriginalName();
                $audio_banner->storeAs('settings/', $img_audio, 'upload_attachments');
            }

            $data['audio_banner'] = $img_audio;
        }
        if ($request->hasFile('lecture_banner')) {
            //delete old image
            if ($data['lecture_banner'] != '') {
                if (File::exists('Files/settings/' . setting()->lecture_banner)) {
                    unlink('Files/settings/' . setting()->lecture_banner);
                }
            }

            if ($lecture_banner = $request->file('lecture_banner')) {
                $img_lecture = $lecture_banner->getClientOriginalName();
                $lecture_banner->storeAs('settings/', $img_lecture, 'upload_attachments');
            }

            $data['lecture_banner'] = $img_lecture;
        }



        if ($request->hasFile('article_banner')) {
            //delete old image
            if ($data['article_banner'] != '') {
                if (File::exists('Files/settings/' . setting()->article_banner)) {
                    unlink('Files/settings/' . setting()->article_banner);
                }
            }

            if ($article_banner = $request->file('article_banner')) {
                $img_article = $article_banner->getClientOriginalName();
                $article_banner->storeAs('settings/', $img_article, 'upload_attachments');
            }

            $data['article_banner'] = $img_article;
        }

        if ($request->hasFile('book_banner')) {
            //delete old image
            if ($data['book_banner'] != '') {
                if (File::exists('Files/settings/' . setting()->book_banner)) {
                    unlink('Files/settings/' . setting()->book_banner);
                }
            }

            if ($book_banner = $request->file('book_banner')) {
                $img_book = $book_banner->getClientOriginalName();
                $book_banner->storeAs('settings/', $img_book, 'upload_attachments');
            }

            $data['book_banner'] = $img_book;
        }

        if ($request->hasFile('speech_banner')) {
            //delete old image
            if ($data['speech_banner'] != '') {
                if (File::exists('Files/settings/' . setting()->speech_banner)) {
                    unlink('Files/settings/' . setting()->speech_banner);
                }
            }

            if ($speech_banner = $request->file('speech_banner')) {
                $img_speech = $speech_banner->getClientOriginalName();
                $speech_banner->storeAs('settings/', $img_speech, 'upload_attachments');
            }

            $data['speech_banner'] = $img_speech;
        }

        if ($request->hasFile('benefit_banner')) {
            //delete old image
            if ($data['benefit_banner'] != '') {
                if (File::exists('Files/settings/' . setting()->benefit_banner)) {
                    unlink('Files/settings/' . setting()->benefit_banner);
                }
            }

            if ($benefit_banner = $request->file('benefit_banner')) {
                $img_benefit = $benefit_banner->getClientOriginalName();
                $benefit_banner->storeAs('settings/', $img_benefit, 'upload_attachments');
            }

            $data['benefit_banner'] = $img_benefit;
        }

        if (Setting::all()->count() > 0) {

            Setting::orderBy('id', 'desc')->update($data);
        } else {
            Setting::create($request->all());
        }

        $success = [
            'message' => trans('btns.updated-successfully'),
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($success);
    }


    public function report()
    {
        return view('backend.settings.report');
    }


    public function remove_lesson_banner(Request $request)
    {
        $lesson_banner = Setting::findOrFail($request->id);

        if (File::exists('Files/settings/' . setting()->lesson_banner)) {
            unlink('Files/settings/' . setting()->lesson_banner);
        }
        if (!$lesson_banner)
            return redirect()->back()->with(['error' => 'image not exist']);

        $lesson_banner->update(['lesson_banner' => null]);

        return response()->json([
            'status' => true,
            'msg' => trans('btns.deleted-successfully'),
            'id' =>  $request->id
        ]);
    }

    public function remove_lecture_banner(Request $request)
    {
        $lecture_banner = Setting::findOrFail($request->id);

        if (File::exists('Files/settings/' . setting()->lecture_banner)) {
            unlink('Files/settings/' . setting()->lecture_banner);
        }
        if (!$lecture_banner)
            return redirect()->back()->with(['error' => 'image not exist']);

        $lecture_banner->update(['lecture_banner' => null]);

        return response()->json([
            'status' => true,
            'msg' => trans('btns.deleted-successfully'),
            'id' =>  $request->id
        ]);
    }

    public function remove_book_banner(Request $request)
    {
        $book_banner = Setting::findOrFail($request->id);

        if (File::exists('Files/settings/' . setting()->book_banner)) {
            unlink('Files/settings/' . setting()->book_banner);
        }
        if (!$book_banner)
            return redirect()->back()->with(['error' => 'image not exist']);

        $book_banner->update(['book_banner' => null]);

        return response()->json([
            'status' => true,
            'msg' => trans('btns.deleted-successfully'),
            'id' =>  $request->id
        ]);
    }
    public function remove_speech_banner(Request $request)
    {
        $speech_banner = Setting::findOrFail($request->id);

        if (File::exists('Files/settings/' . setting()->speech_banner)) {
            unlink('Files/settings/' . setting()->speech_banner);
        }
        if (!$speech_banner)
            return redirect()->back()->with(['error' => 'image not exist']);

        $speech_banner->update(['speech_banner' => null]);

        return response()->json([
            'status' => true,
            'msg' => trans('btns.deleted-successfully'),
            'id' =>  $request->id
        ]);
    }

    public function remove_benefit_banner(Request $request)
    {
        $benefit_banner = Setting::findOrFail($request->id);

        if (File::exists('Files/settings/' . setting()->benefit_banner)) {
            unlink('Files/settings/' . setting()->benefit_banner);
        }
        if (!$benefit_banner)
            return redirect()->back()->with(['error' => 'image not exist']);

        $benefit_banner->update(['benefit_banner' => null]);

        return response()->json([
            'status' => true,
            'msg' => trans('btns.deleted-successfully'),
            'id' =>  $request->id
        ]);
    }
    public function remove_article_banner(Request $request)
    {
        $article_banner = Setting::findOrFail($request->id);

        if (File::exists('Files/settings/' . setting()->article_banner)) {
            unlink('Files/settings/' . setting()->article_banner);
        }
        if (!$article_banner)
            return redirect()->back()->with(['error' => 'image not exist']);

        $article_banner->update(['article_banner' => null]);

        return response()->json([
            'status' => true,
            'msg' => trans('btns.deleted-successfully'),
            'id' =>  $request->id
        ]);
    }

    public function remove_gallery_banner(Request $request)
    {
        $gallery_banner = Setting::findOrFail($request->id);

        if (File::exists('Files/settings/' . setting()->gallery_banner)) {
            unlink('Files/settings/' . setting()->gallery_banner);
        }
        if (!$gallery_banner)
            return redirect()->back()->with(['error' => 'image not exist']);

        $gallery_banner->update(['gallery_banner' => null]);

        return response()->json([
            'status' => true,
            'msg' => trans('btns.deleted-successfully'),
            'id' =>  $request->id
        ]);
    }

    public function remove_matwiaat_banner(Request $request)
    {
        $matwiaat_banner = Setting::findOrFail($request->id);

        if (File::exists('Files/settings/' . setting()->matwiaat_banner)) {
            unlink('Files/settings/' . setting()->matwiaat_banner);
        }
        if (!$matwiaat_banner)
            return redirect()->back()->with(['error' => 'image not exist']);

        $matwiaat_banner->update(['matwiaat_banner' => null]);

        return response()->json([
            'status' => true,
            'msg' => trans('btns.deleted-successfully'),
            'id' =>  $request->id
        ]);
    }

    public function remove_video_banner(Request $request)
    {
        $video_banner = Setting::findOrFail($request->id);

        if (File::exists('Files/settings/' . setting()->video_banner)) {
            unlink('Files/settings/' . setting()->video_banner);
        }
        if (!$video_banner)
            return redirect()->back()->with(['error' => 'image not exist']);

        $video_banner->update(['video_banner' => null]);

        return response()->json([
            'status' => true,
            'msg' => trans('btns.deleted-successfully'),
            'id' =>  $request->id
        ]);
    }

    public function remove_audio_banner(Request $request)
    {
        $audio_banner = Setting::findOrFail($request->id);

        if (File::exists('Files/settings/' . setting()->audio_banner)) {
            unlink('Files/settings/' . setting()->audio_banner);
        }
        if (!$audio_banner)
            return redirect()->back()->with(['error' => 'image not exist']);

        $audio_banner->update(['audio_banner' => null]);

        return response()->json([
            'status' => true,
            'msg' => trans('btns.deleted-successfully'),
            'id' =>  $request->id
        ]);
    }
}