<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Event;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PastEventExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $event =  Event::where('start', '<' ,Carbon::now())->orderBy('id','desc')->get();
        return $event;
    }

    public function map($event): array
    {
        return [
            $event->title,
            $event->place,
            $event->type,
            $event->start->toDateString(),
            date('g:ia', strtotime($event->start))

        ];
    }


    public function headings(): array
    {
        return [
            trans('events.title'),
            trans('events.place'),
            trans('events.type'),
            trans('events.start'),
            trans('events.time'),

        ];
    }
}