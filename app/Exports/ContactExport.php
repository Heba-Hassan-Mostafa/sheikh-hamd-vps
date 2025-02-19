<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ContactExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $client =  Contact::orderBy('id','desc')->get();
        return $client;
    }

    public function map($client): array
    {
        return [

            $client->name,
            $client->email,
            $client->phone,
            $client->message,
            $client->created_at->toDateString()


        ];
    }


    public function headings(): array
    {
        return [
            trans('clients.name'),
            trans('clients.email'),
            trans('clients.phone'),
            trans('clients.contact-message'),
            trans('clients.date'),

        ];
    }
}