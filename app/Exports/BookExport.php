<?php

namespace App\Exports;

use App\Models\Book;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class BookExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $books =  Book::withCount('comments')->orderBy('id','desc')->get();
        return $books;
    }

    public function map($books): array
    {
        return [
            $books->name,
            $books->category->name,
            $books->status(),
            $books->publish_date->toDateString(),
            $books->comments->count(),
            $books->download_count,
            $books->view_count,

        ];
    }


    public function headings(): array
    {
        return [
            trans('books.article-name'),
            trans('books.category-parent'),
            trans('books.status'),
            trans('books.publish-date'),
            trans('books.comment-count'),
            trans('books.download-count'),
            trans('books.view-count'),
        ];
    }
}