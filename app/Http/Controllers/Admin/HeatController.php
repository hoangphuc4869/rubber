<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rolling;
use App\Models\Drum;
use App\Models\ResetTime;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use Yajra\DataTables\Facades\DataTables; 

class HeatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rollings = Rolling::all();
        // 2 giao ca, 3 doi ca
        $drums = Drum::whereIn('status', [0, 2, 3])->get();
        $drums_handled = Drum::where('status', 1)
                ->doesntHave('bale')
                ->orderBy('date', 'desc')
                ->get();

        
        $drums_per_day = Drum::where('status', 0)->select('date')
        ->selectRaw('COUNT(*) as total_number')
        ->groupBy('date') 
        ->orderBy('date', 'desc')
        ->get()
        ->map(function ($item) {
            return [
                'date' => $item->date,
                'total_number' => $item->total_number,
            ];
        });
        // dd($drums_handled);

        if (Gate::allows('6t') || Gate::allows('admin')  || Gate::allows('3t')) {
            return view('admin.heat.index' , compact('rollings', 'drums', 'drums_per_day', 'drums_handled'));

        } else {
            abort(403, 'Bạn không có quyền truy cập.');
        }

        
    }


    public function getDataNhiet(Request $request)
    {
        $gchat = Drum::with(['bale', 'batches', 'rolling', 'curing_house']) 
            ->whereIn('status', [0, 2, 3])
            ->select([
                'id',
                'name',               
                'date',               
                'status',             
                'heated_start',            
                'heated_date',            
                'heated_end',               
                'temp',               
                'temp2',               
                'link',          
                'oven',
                'curing_house_id',        
                'curing_area_id',        
                'supervisor',     
                'thickness',     
                'trang_thai_com',     
                
            ]);

        if ($request->has('date') && $request->date) {
            $date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
            $gchat->where('date', $date);
        }

        if ($request->has('status') && $request->status) {
            switch ($request->status) {
                case 'cho':
                    // Trạng thái Chờ xử lý nhiệt
                    $gchat->where('status', 0);
                    break;
                case 'da':
                    // Trạng thái Đã xử lý nhiệt
                    $gchat->where('status', 5)->whereDoesntHave('bale');
                    break;
                case 'dang':
                    // Trạng thái Đang xử lý nhiệt
                    $gchat->where('status', 1);
                    break;
                case 'giao':
                    // Trạng thái Giao ca
                    $gchat->where('status', 2);
                    break;
                case 'doi':
                    // Trạng thái Đổi ca
                    $gchat->where('status', 3);
                    break;
                case 'ep':
                    // Trạng thái Đã ép kiện
                    $gchat->where('status', 5)->whereHas('bale')->whereDoesntHave('batches');
                    break;
                case 'lo':
                    // Trạng thái Đã đóng lô
                    $gchat->where('status', 5)->whereHas('bale')->whereHas('batches');
                    break;
                default:
                    break;
            }
        }

        if ($request->has('link') && $request->link) {
            $gchat->where('link', $request->link);
        }

        // dd($gchat->rolling);

        return DataTables::of($gchat)
            // ->addColumn('rolling_date', function ($gchat) {
            //     return $gchat->rolling ? \Carbon\Carbon::parse($gchat->rolling->date)->format('d-m-Y') : '';
            // })
            ->addColumn('house_code', function ($gchat) {
                return $gchat->curing_house ? $gchat->curing_house->code : '';
            })
            // ->editColumn('date', function ($gchat) {
            //     return \Carbon\Carbon::parse($gchat->date)->format('d-m-Y'); 
            // })
            ->editColumn('heated_start', function ($gchat) {
                return \Carbon\Carbon::parse($gchat->heated_start)->format('H:i'); 
            })
            ->editColumn('heated_end', function ($gchat) {
                return \Carbon\Carbon::parse($gchat->heated_end)->format('H:i'); 
            })
            ->editColumn('heated_date', function ($gchat) {
                return \Carbon\Carbon::parse($gchat->heated_date)->format('d-m-Y'); 
            })
            ->editColumn('date', function ($gchat) {
                return \Carbon\Carbon::parse($gchat->date)->format('d-m-Y');
            })
            ->make(true);
    }

    public function getDataNhiet2(Request $request)
    {
        $gchat = Drum::with(['bale', 'batches', 'rolling', 'curing_house'])
            ->whereIn('status', [1])
            ->doesntHave('bale')
            ->select([
                'id',
                'name',               
                'date',               
                'status',             
                'heated_start',            
                'heated_date',            
                'heated_end',               
                'temp',               
                'temp2',               
                'time_to_dry',             
                'link',          
                'note',          
                'state',          
                'validation',          
                'oven',
                'curing_house_id',        
                'curing_area_id',        
                'supervisor',     
                'thickness',     
                'trang_thai_com',     
                
            ]);

        if ($request->has('date') && $request->date) {
            $date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->date)->format('Y-m-d');
            $gchat->where('date', $date);
        }

        if ($request->has('link') && $request->link) {
            $gchat->where('link', $request->link);
        }

        // dd($gchat->rolling);

        return DataTables::of($gchat)
            ->addColumn('house_code', function ($gchat) {
                return $gchat->curing_house ? $gchat->curing_house->code : '';
            })
        
            ->editColumn('heated_start', function ($gchat) {
                return $gchat->heated_start ? \Carbon\Carbon::parse($gchat->heated_start)->format('H:i') : ""; 
            })
            ->editColumn('heated_end', function ($gchat) {
                return $gchat->heated_end ? \Carbon\Carbon::parse($gchat->heated_end)->format('H:i') : ""; 
            })
            ->editColumn('heated_date', function ($gchat) {
                return $gchat->heated_date ? \Carbon\Carbon::parse($gchat->heated_date)->format('d/m/Y') : ""; 
            })
            ->editColumn('date', function ($gchat) {
                return \Carbon\Carbon::parse($gchat->date)->format('d-m-Y');
            })
            ->make(true);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     */
    
    public function store(Request $request)
    {
        $data = $request->all();
        // dd($request->all());
        $ids = explode(',', $data['drums']);

        
        $lastHeatedStart = Carbon::createFromFormat('H:i Y-m-d', $request->time_start . ' ' . $request->date);

        foreach ($ids as $id) {
            $drum = Drum::findOrFail($id);
            
            if ($drum->status == 0) {
                
                $drum->status = 1;
                $drum->temp = $data['temp'];
                $drum->temp2 = $data['temp2'];
                $drum->oven = $data['oven'];
                $drum->state = $data['state'];
                $drum->validation = $data['validation'];
                $drum->time_to_dry = $data['time_to_dry'];

                $drum->heated_start = $lastHeatedStart;

                
                if($drum->link == 3){
                    $heatedEnd = $lastHeatedStart->copy()->addMinutes($data['time_to_dry'] * 30);
                }
                else {
                    $heatedEnd = $lastHeatedStart->copy()->addMinutes($data['time_to_dry'] * 32);
                }

                $drum->heated_end = $heatedEnd;

                
                $drum->heated_date = $drum->heated_end->copy();


                $drum->save();

               
                $lastHeatedStart = $lastHeatedStart->copy()->addMinutes(+$data['time_to_dry']);
                // dd($lastHeatedStart, $heatedEnd);

                // $this->updateBeforeDrum($drum, $drum->link);

            }
        }

        
            foreach ($ids as $id) {
                
                $drum = Drum::findOrFail($id);

                $heatedEnd = Carbon::parse($drum->heated_end)->copy();

                $time = $heatedEnd->copy()->subMinutes(390);
            
                $originalDate = $heatedEnd->copy()->startOfDay();

                if ($time->startOfDay()->lt($originalDate)) {

                    $drum->heated_date = $heatedEnd->copy()->subDay()->format('Y-m-d H:i:s');
                    
                } 

        
                $drum->save();

            }
           
            // dd($drum->heated_end, $drum->heated_date);


        


        return redirect()->back()->with('success', 'Thành công');
    }







    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Drum::findOrFail($id);

        if($item) {
            $item->heated_date = null;
            $item->temp = null;
            $item->temp2 = null;
            $item->state = null;
            $item->validation = null;
            $item->time_to_dry = null;
            $item->oven = null;
            $item->heated_end = null;
            $item->time = null;
            $item->heated_start = null;
            $item->heating_supervisor = null;
            $item->note = null;

            $item->status = 0;
            $item->save();
        }
        return redirect()->route('heat.index')->with('delete_success', 'Xóa thành công' );
    }

    public function delete_items(Request $request)
    {
        // dd($request->all()); // Debugging output

        $items = explode(',', $request->drums);
        $action = $request->action; 

        foreach ($items as $item) {
            $drum = Drum::findOrFail($item); 

            if ($drum) {
                if ($action === 'delete') {
                    // Logic for delete action
                    $drum->heated_date = null;
                    $drum->temp = null;
                    $drum->temp2 = null;
                    $drum->state = null;
                    $drum->validation = null;
                    $drum->time_to_dry = null;
                    $drum->oven = null;
                    $drum->heated_end = null;
                    $drum->heated_start = null;
                    $drum->time = null;
                    $drum->note = null;
                    $drum->heating_supervisor = null;
                    $drum->status = 0; 
                } elseif ($action === 'done') {
                    $drum->status = 5; 
                }

                
                $drum->save();
            }
        }

        if ($action === 'delete') {
            return redirect()->back()->with('delete_success', 'Xóa thành công');
        } elseif ($action === 'done') {
            return redirect()->back()->with('done_success', 'Xử lý nhiệt hoàn tất');
        }
    }


    public function adjustTime(Request $request)
    {
        if ($request->has('multi')) {
            $drum = Drum::findOrFail($request->drums);

            if ($request->has('adjust_time')) {

                $adjustDateTime = Carbon::parse($request->adjust_date)
                                    ->setTimeFrom(Carbon::parse($request->adjust_time));

                $drum->heated_start = $adjustDateTime;
                $this->updateNextDrums($drum, $request->line);
                $this->updateBeforeDrum($drum, $request->line);
            }

            if ($request->has('adjust_time_dry')) {
                $drum->time_to_dry = $request->adjust_time_dry;
                $drum->save();
                // dd($drum);

                // $this->updateBeforeDrum($drum, $request->line);
                $this->updateNextDrums($drum, $request->line);
            }

            $drum->note = $request->reason;
            $drum->save();
        }

        $drums = Drum::all();
        foreach ($drums as $drum) {
                
            $heatedEnd = Carbon::parse($drum->heated_end)->copy();

            $time = $heatedEnd->copy()->subMinutes(390);
        
            $originalDate = $heatedEnd->copy()->startOfDay();

            
            if ($time->startOfDay()->lt($originalDate)) {
                
                $drum->heated_date = $heatedEnd->copy()->subDay()->format('Y-m-d H:i:s');
            } 

            $drum->save();
        }

        return redirect()->back()->with('success', 'Điều chỉnh thành công');
    }


    private function updateNextDrums($drum, $line)
    {
        $nextDrums = Drum::where('id', '>', $drum->id)
            ->where('link', $line)
            ->whereNotIn('status', [0, 2, 3])
            ->orderBy('id', 'asc')
            ->get();

        foreach ($nextDrums as $index => $nextDrum) {
            $nextDrum->heated_start = $index == 0
                ? Carbon::parse($drum->heated_start)->addMinutes(+$drum->time_to_dry)
                : Carbon::parse($nextDrums[$index - 1]->heated_start)->addMinutes(+$nextDrums[$index - 1]->time_to_dry);

            $nextDrum->save();

            $this->updateBeforeDrum($nextDrum, $line);
        }
    }

    private function updateBeforeDrum($drum, $line)
    {
        if($line == 3) {
            $beforeDrums = Drum::where('link', $drum->link)
                ->where('id', '<', $drum->id) 
                ->whereNotIn('status', [0, 2, 3])   
                ->orderBy('id', 'desc')         
                ->take(30) 
                ->get()
                ->reverse();

            if ($beforeDrums->first() != null && $beforeDrums->count() == 30) {
                
                $beforeDrums->first()->heated_end = $drum->heated_start;
            
                $date = Carbon::parse($drum->heated_end)->copy()->subMinutes(390);

                if ($date->isYesterday()) {
                    $date = Carbon::parse($drum->heated_end)->copy()->subDay();
                }

                $beforeDrums->first()->heated_date = $date;
                $beforeDrums->first()->save();
            }
        }
        else {
            $beforeDrums = Drum::where('link', $drum->link)
                ->where('id', '<', $drum->id) 
                ->whereNotIn('status', [0, 2, 3])   
                ->orderBy('id', 'desc')         
                ->take(32) 
                ->get()
                ->reverse();

            if ($beforeDrums->first() != null && $beforeDrums->count() == 32) {
                $beforeDrums->first()->heated_end = $drum->heated_start;
                $date = Carbon::parse($drum->heated_end)->copy()->subMinutes(390);

                if ($date->isYesterday()) {
                     $date = Carbon::parse($drum->heated_end)->copy()->subDay();
                }

                $beforeDrums->first()->heated_date = $date;
                $beforeDrums->first()->save();
            }
        }

        
    }


    public function adjustDryTime(Request $request)
    {  
        
        return redirect()->back()->with('success', 'Thời gian đã được điều chỉnh');
    }

    public function giaoCa(Request $request)
    {
       
        $drumIds = explode(',' , $request->input('drums')[0]);

        // dd($drumIds);

        if (empty($drumIds)) {
            return redirect()->back()->with('error', 'Không có thùng nào được chọn.');
        }

        foreach ($drumIds as $drumId) {
            $drum = Drum::find($drumId);
            if ($drum) {
                $drum->status = $request->type == "giaoca" ? 2 : 3;
                $drum->heated_end = null;
                $drum->heated_date = null;
                $drum->save();
            }
        }

        return redirect()->back()->with('success', 'Đã giao ca thành công.');
    }


    public function nhanCa(Request $request)
    {
        
        $drumIds = explode(',', $request->drum_ids);
       

        foreach ($drumIds as $id) {
            $drum = Drum::find($id);
            if ($drum) {
            
                
                if($drum->status == 2 || $drum->status == 3){
                    
                    $drum->status = 1;
                    $drum->note = 'nhận ca';
                    
                    $drum->heated_end = null; 
                    $drum->heated_date = null; 

                    $drum->save();
                }
                else {
                    return redirect()->back()->with('roll_fail', 'Không nhận các thùng này');
                }

            }
        }

        return redirect()->back()->with('success', 'Nhận ca thành công.');
    }


}