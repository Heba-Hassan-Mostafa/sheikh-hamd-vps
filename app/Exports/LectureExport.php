<?php

namespace App\Exports;

use App\Models\Lecture;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class LectureExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $lectures =  Lecture::withCount('comments')->orderBy('id','desc')->get();
        return $lectures;
    }

    public function map($lectures): array
    {
        return [
            $lectures->name,
            $lectures->category->name,
            $lectures->status(),
            $lectures->publish_date->toDateString(),
            $lectures->comments->count(),
            $lectures->download_count,
            $lectures->view_count,

        ];
    }


    public function headings(): array
    {
        return [
            trans('lectures.lecture-name'),
            trans('lectures.category-parent'),
            trans('lectures.status'),
            trans('lectures.publish-date'),
            trans('lectures.comment-count'),
            trans('lectures.download-count'),
            trans('lectures.view-count'),
        ];
    }
}