<?php

namespace App\Exports;

use App\Models\Subscriber;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class SubscriberExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $subscriber =  Subscriber::orderBy('id','desc')->get();
        return $subscriber;
    }

    public function map($subscriber): array
    {
        return [

            $subscriber->email,
            $subscriber->created_at->toDateString()

        ];
    }


    public function headings(): array
    {
        return [
            trans('clients.email'),
            trans('clients.date'),

        ];
    }
}