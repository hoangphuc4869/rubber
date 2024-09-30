<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;
use App\Models\CuringHouse;
use App\Models\Rolling;
use App\Models\Drum;
use App\Models\DrumPerDay;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\ResetTime;
use App\Models\Shipment;
use Illuminate\Support\Facades\Gate;
use App\Models\Company;

use App\Models\CuringArea;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $rollings = Rolling::all();
        $houses = CuringHouse::all();
        $reset = ResetTime::first();
        

        
        
        
        $drums_per_day_3tan = Drum::select('date')
        ->selectRaw('COUNT(*) as total_number')
        ->where('link', 3)->where('date', now()->format('Y/m/d'))
        ->groupBy('date') 
        ->orderBy('date', 'desc')
        ->get()
        ->map(function ($item) {
            return [
                'date' => $item->date,
                'total_number' => $item->total_number,
            ];
        });

        $drums_per_day_6tan = Drum::select('date')
        ->selectRaw('COUNT(*) as total_number')
        ->where('link', 6)->where('date', now()->format('Y/m/d'))
        ->groupBy('date') 
        ->orderBy('date', 'desc')
        ->get()
        ->map(function ($item) {
            return [
                'date' => $item->date,
                'total_number' => $item->total_number,
            ];
        });

        $currentTime = Carbon::now();
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        
        if ($currentTime->hour < 6) {
            $date = $yesterday->format('d/m/Y');
            $date_total = $yesterday->format('Y/m/d');
        } else {
            $date = $today->format('d/m/Y');
            $date_total = $today->format('Y/m/d');
        }

        $orders = Shipment::where('status', 0)->count();

        $totalBatches = Batch::whereMonth('date', now()->format('m'))->get()->count();


        $drums = Drum::where('date', $date_total)->get()->count();

        $total_bhck = 0;
        $total_crck2 = 0;

        Company::where('code', 'BHCK')->first()->farms->map(function($farm) use (&$total_bhck) {
            $farm->curing_areas->map(function($area) use (&$total_bhck) {
                $total_bhck += $area->containing;
            });
        });

        Company::where('code', 'CRCK2')->first()->farms->map(function($farm) use (&$total_crck2) {
            $farm->curing_areas->map(function($area) use (&$total_crck2) {
                $total_crck2 += $area->containing;
            });
        });

        
        return view('admin.home', compact('drums_per_day_3tan','drums_per_day_6tan', 'date', 'drums', 'orders', 'totalBatches', 'total_bhck' , 'total_crck2'));
    }

    public function get_data(Request $request){
        
        $ten_nha_u = CuringArea::all()->pluck('code');
        
        $khoi_luong = CuringArea::all()->pluck('containing')->map(function($value){
            return $value/1000;
        });

        $drums_per_day_3tan = Drum::select('date')
        ->selectRaw('COUNT(*) as total_number')
        ->where('link', 3)->where('date', now()->format('Y/m/d'))
        ->groupBy('date') 
        ->orderBy('date', 'desc')
        ->get()
        ->map(function ($item) {
            return [
                'date' => $item->date,
                'total_number' => $item->total_number,
            ];
        });

        $drums_per_day_6tan = Drum::select('date')
        ->selectRaw('COUNT(*) as total_number')
        ->where('link', 6)->where('date', now()->format('Y/m/d'))
        ->groupBy('date') 
        ->orderBy('date', 'desc')
        ->get()
        ->map(function ($item) {
            return [
                'date' => $item->date,
                'total_number' => $item->total_number,
            ];
        });
        
        



        $pie = [
            isset($drums_per_day_3tan[0]['total_number']) && $drums_per_day_3tan[0]['total_number'] > 0 ? $drums_per_day_3tan[0]['total_number'] : 0,
            isset($drums_per_day_6tan[0]['total_number']) && $drums_per_day_6tan[0]['total_number'] > 0 ? $drums_per_day_6tan[0]['total_number'] : 0
        ];

        return response()->json([
            'nha_u' => $ten_nha_u,
            'khoi_luong' => $khoi_luong,
            'thung' => $pie
        ]);
    }
}