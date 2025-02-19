<?php

namespace App\Exports;

use App\Models\Benefit;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class BenefitExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $benefits =  Benefit::withCount('comments')->orderBy('id','desc')->get();
        return $benefits;
    }

    public function map($benefits): array
    {
        return [
            $benefits->name,
            $benefits->category->name,
            $benefits->status(),
            $benefits->publish_date->toDateString(),
            $benefits->comments->count(),
            $benefits->view_count,

        ];
    }


    public function headings(): array
    {
        return [
            trans('benefits.benefit-name'),
            trans('benefits.category-parent'),
            trans('benefits.status'),
            trans('benefits.publish-date'),
            trans('benefits.comment-count'),
            trans('benefits.view-count'),
        ];
    }
}