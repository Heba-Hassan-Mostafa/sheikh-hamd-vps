<?php

namespace App\Exports;

use App\Models\Fatwa;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class FatwaExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $fatwa =  Fatwa::orderBy('id','desc')->get();
        return $fatwa;
    }

    public function map($fatwa): array
    {
        return [
            $fatwa->name,
            $fatwa->email,
            $fatwa->phone,
            $fatwa->message,
            $fatwa->status(),
            $fatwa->created_at->toDateString()

        ];
    }


    public function headings(): array
    {
        return [
            trans('clients.name'),
            trans('clients.email'),
            trans('clients.phone'),
            trans('clients.message'),
            trans('clients.status'),
            trans('clients.date'),

        ];
    }
}