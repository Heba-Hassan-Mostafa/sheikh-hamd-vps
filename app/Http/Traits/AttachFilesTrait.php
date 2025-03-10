<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;

trait AttachFilesTrait
{
    public function uploadFile($request,$name,$folder)
    {
        $file_name = $request->file($name)->getClientOriginalName();
        $request->file($name)->storeAs('Files/',$folder.'/'.$file_name,'upload_attachments');

    }

    public function deleteFile($folder,$name)
    {
        $exists = Storage::disk('upload_attachments')->exists('Files/'.$folder.'/'.$name);

        if($exists)
        {
            Storage::disk('upload_attachments')->delete('Files/'.$folder.'/'.$name);
        }
    }
}