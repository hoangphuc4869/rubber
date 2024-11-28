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
use App\Models\Rubber;

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

        Company::where('code', 'B.H.C.K')->first()->farms->map(function($farm) use (&$total_bhck) {
            $farm->curing_areas->map(function($area) use (&$total_bhck) {
                $total_bhck += $area->containing;
            });
        });

        Company::where('code', 'C.R.C.K.2')->first()->farms->map(function($farm) use (&$total_crck2) {
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

       
        $allFarmIds = Rubber::distinct()->pluck('farm_id');

        $freshweights_cup = Rubber::select('farm_id', DB::raw('SUM(fresh_weight) as total_freshweight'))
            ->where('date', today())
            ->whereIn('latex_type', ['Rubber cup lump', 'THU MUA MĐC']) 
            ->groupBy('farm_id')
            ->pluck('total_freshweight', 'farm_id');

        $freshweights_string = Rubber::select('farm_id', DB::raw('SUM(fresh_weight) as total_freshweight'))
            ->where('date', today())
             ->whereIn('latex_type', ['Rubber in string shape', 'THU MUA MD']) 
            ->groupBy('farm_id')
            ->pluck('total_freshweight', 'farm_id');


        $result_cup = $allFarmIds->mapWithKeys(function ($farmId) use ($freshweights_cup) {
            return [$farmId => $freshweights_cup[$farmId] ?? 0];
        });

        $result_string = $allFarmIds->mapWithKeys(function ($farmId) use ($freshweights_string) {
            return [$farmId => $freshweights_string[$farmId] ?? 0];
        });

        $result_cup = $result_cup->toArray();
        $result_string = $result_string->toArray();

        $mapping = [
            1 => "Farm 1",
            2 => "Farm 2",
            3 => "Farm 3",
            4 => "Farm 4",
            5 => "Farm 5",
            6 => "Farm 6",
            7 => "Farm 7",
            8 => "Farm 8",
            9 => "OTHER",
            10 => "TNSR",
        ];

       
        $result_cup_mapped = [];
        $result_string_mapped = [];


        foreach ($mapping as $farmId => $farmName) {

            $result_cup_mapped[$farmName] = $result_cup[$farmId] ?? 0;
            

            $result_string_mapped[$farmName] = $result_string[$farmId] ?? 0;
        }

        $data_cup = array_values($result_cup_mapped); 
        $data_string = array_values($result_string_mapped);


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
            'thung' => $pie,
            'fresh_weight_cup' => $result_cup_mapped,
            'fresh_weight_string' => $result_string_mapped,
        ]);
    }
}