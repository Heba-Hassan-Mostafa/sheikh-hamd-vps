<?php

namespace App\Exports;

use App\Models\Lesson;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class LessonExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $lessons =  Lesson::withCount('comments')->orderBy('id','desc')->get();
        return $lessons;
    }

    public function map($lessons): array
    {
        return [
            $lessons->name,
            $lessons->category->name,
            $lessons->status(),
            $lessons->publish_date->toDateString(),
            $lessons->comments->count(),
            $lessons->download_count,
            $lessons->view_count,

        ];
    }


    public function headings(): array
    {
        return [
            trans('lessons.lesson-name'),
            trans('lessons.category-parent'),
            trans('lessons.status'),
            trans('lessons.publish-date'),
            trans('lessons.comment-count'),
            trans('lessons.download-count'),
            trans('lessons.view-count'),
        ];
    }
}