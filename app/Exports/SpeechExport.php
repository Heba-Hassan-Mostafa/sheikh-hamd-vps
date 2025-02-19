<?php

namespace App\Exports;

use App\Models\Speech;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class SpeechExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $speeches =  Speech::withCount('comments')->orderBy('id','desc')->get();
        return $speeches;
    }

    public function map($speeches): array
    {
        return [
            $speeches->name,
            $speeches->category->name,
            $speeches->status(),
            $speeches->publish_date->toDateString(),
            $speeches->comments->count(),
            $speeches->download_count,
            $speeches->view_count,

        ];
    }


    public function headings(): array
    {
        return [
            trans('speeches.speech-name'),
            trans('speeches.category-parent'),
            trans('speeches.status'),
            trans('speeches.publish-date'),
            trans('speeches.comment-count'),
            trans('speeches.download-count'),
            trans('speeches.view-count'),
        ];
    }
}