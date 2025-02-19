<?php

namespace App\Http\Controllers\Backend\Api;

use App\Models\Fatwa;
use App\Models\Visitor;
use App\Models\Subscriber;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function subscriber_chart()
    {
        $visitors = Visitor::orderBy('visitor_count', 'desc')->take(1)->pluck('visitor_count', 'visitor_count');


    $chart['labels'] = $visitors->keys()->toArray();
    $chart['datasets']['name'] = trans('main_sidebar.top_visitors');
    $chart['datasets']['values'] = $visitors->values()->toArray();


    return response()->json($chart);


    }

    public function question_chart()
    {
        $questions = Fatwa::select(DB::raw('COUNT(*) as count'), DB::raw('Month(created_at) as month'))
        ->whereYear('created_at', date('Y'))
        ->groupBy(DB::raw('Month(created_at)'))
        ->pluck('count', 'month');

        $clients = Subscriber::select(DB::raw('COUNT(*) as count'), DB::raw('Month(created_at) as month'))
        ->whereYear('created_at', date('Y'))
        ->groupBy(DB::raw('Month(created_at)'))
        ->pluck('count', 'month');

        foreach ($questions->keys() as $month_number) {
            $labels[] = date('F', mktime(0, 0, 0, $month_number, 1));
        }

        $chart['labels'] = $labels;
        $chart['datasets'][0]['name'] = trans('main_sidebar.top_fatwa');
        $chart['datasets'][0]['values'] = $questions->values()->toArray();
        $chart['datasets'][1]['name'] = trans('main_sidebar.top_subs');
        $chart['datasets'][1]['values'] = $clients->values()->toArray();

        return response()->json($chart);

    }
}