<?php

namespace App\Exports;

use App\Models\Article;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ArticleExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $articles =  Article::withCount('comments')->orderBy('id','desc')->get();
        return $articles;
    }

    public function map($articles): array
    {
        return [
            $articles->name,
            $articles->category->name,
            $articles->status(),
            $articles->publish_date->toDateString(),
            $articles->comments->count(),
            $articles->download_count,
            $articles->view_count,

        ];
    }


    public function headings(): array
    {
        return [
            trans('articles.article-name'),
            trans('articles.category-parent'),
            trans('articles.status'),
            trans('articles.publish-date'),
            trans('articles.comment-count'),
            trans('articles.download-count'),
            trans('articles.view-count'),
        ];
    }
}