<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Collection;
use Analytics;
use Spatie\Analytics\Period;




class BackendController extends Controller
{
    public function index()
    {
        //  $analyticsData = Analytics::fetchVisitorsAndPageViews(Period::days(7));
        // dd($analyticsData);
        return view('backend.index');
    }


    public function activity_log()
    {
        $activities = Activity::orderBy('id','desc')->get();

        return view('backend.activity.logs', [
          'activities' => $activities,

        ]);
    }

}