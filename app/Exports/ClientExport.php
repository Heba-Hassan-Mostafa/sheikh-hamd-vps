<?php

namespace App\Exports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ClientExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $client =  Client::orderBy('id','desc')->get();
        return $client;
    }

    public function map($client): array
    {
        return [

            $client->full_name,
            $client->email,
            $client->phone,
            $client->status(),
            $client->created_at->toDateString()


        ];
    }


    public function headings(): array
    {
        return [
            trans('clients.name'),
            trans('clients.email'),
            trans('clients.phone'),
            trans('clients.status'),
            trans('clients.date'),

        ];
    }
}