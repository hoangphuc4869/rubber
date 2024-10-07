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
                ->doesntHave('bale') // Kiểm tra không có quan hệ 'bale'
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


                // dd($lastHeatedStart, $heatedEnd);
                $drum->heated_end = $heatedEnd;

                
                $adjustedDate = $heatedEnd->copy()->subMinutes(390);

                
                if ($adjustedDate->isYesterday()) {
                    $adjustedDate->subDay();
                }

                
                $drum->heated_date = $adjustedDate;

               
                $lastHeatedStart = $lastHeatedStart->copy()->addMinutes(+$data['time_to_dry']);
                // dd($lastHeatedStart, $heatedEnd);
                
                $drum->save();

                $this->updateBeforeDrum($drum, $drum->link);

            }
        }

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

        return redirect()->back()->with('success', 'Điều chỉnh thành công');
    }


    private function updateNextDrums($drum, $line)
    {
        $nextDrums = Drum::where('id', '>', $drum->id)
            ->where('link', $line)->where('oven', $drum->oven)
            ->whereNotIn('status', [0, 2, 3])
            ->orderBy('id', 'asc')
            ->get();

        // dd($line);
        

        foreach ($nextDrums as $index => $nextDrum) {
            $nextDrum->heated_start = $index == 0
                ? Carbon::parse($drum->heated_start)->addMinutes(+$drum->time_to_dry)
                : Carbon::parse($nextDrums[$index - 1]->heated_start)->addMinutes(+$nextDrums[$index - 1]->time_to_dry);

            // $nextDrum->heated_end = null;
            // $nextDrum->heated_date = null;
            $nextDrum->save();

            $this->updateBeforeDrum($nextDrum, $line);
        }
    }

    private function updateBeforeDrum($drum, $line)
    {
        if($line == 3) {
            $beforeDrums = Drum::where('link', $drum->link)
                ->where('id', '<', $drum->id)->where('oven', $drum->oven)
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
                ->where('id', '<', $drum->id)->where('oven', $drum->oven)
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



    // public function adjustTime(Request $request)  
    // {  
    //     if ($request->has('multi')) {
    //         $drum = Drum::findOrFail($request->drums);

    //         $adjustDate = Carbon::parse($request->adjust_date);  
    //         $adjustTime = Carbon::parse($request->adjust_time);  
    //         $adjustDateTime = $adjustDate->setTimeFrom($adjustTime);

    //         $drum->heated_date = $adjustDateTime;
            
    //         $drum->time_to_dry = $request->adjust_time_dry;
            
    //         $drum->heated_end = $adjustDateTime->copy(); 
    //         $drum->heated_start = $drum->heated_end->copy()->subHours(5); 

    //         $drum->note = $request->reason;
    //         $drum->save();

    //         $processedDrumIds = [];
    //         $processedDrumIds[] = $drum->id;

    //         $nextDrums = Drum::where('id', '>', $drum->id)  
    //             ->where('link', $request->line)  
    //             ->whereNotIn('status', [0, 2, 3])  
    //             ->orderBy('id', 'asc')  
    //             ->get();  

    //         foreach ($nextDrums as $index => $nextDrum) {
    //             if ($index === 0) { 
    //                 $nextDrum->heated_start = $adjustDateTime->copy()->addMinutes(+$request->adjust_time_dry); 

    //                 $nextDrum->heated_end = $nextDrum->heated_start->copy()->addHours(5);  
    //             } else {
    //                 $prevDrum = $nextDrums[$index - 1];
    //                 $nextDrum->heated_start = $prevDrum->heated_start->copy()->addMinutes(+$request->adjust_time_dry); 
                    
    //                 $nextDrum->heated_end = $nextDrum->heated_start->copy()->addHours(5);
    //             }

    //             $nextDrum->heated_date = $nextDrum->heated_end; 
                
    //             $nextDrum->time_to_dry = $request->adjust_time_dry;
    //             $nextDrum->save();  
    //             $processedDrumIds[] = $nextDrum->id; 
    //         }

    //         $prevDrums = ($request->line == 3) 
    //             ? Drum::where('id', '<', $drum->id)->where('link', 3)->orderBy('id', 'desc')->limit(30)->get()
    //             : Drum::where('id', '<', $drum->id)->where('link', 6)->orderBy('id', 'desc')->limit(32)->get();



    //         $timeToStart = $drum->heated_end;

    //         foreach ($prevDrums as $index => $prevDrum) {

    //                 $prevDrum->heated_end = $timeToStart->copy()->subMinutes(+$request->adjust_time_dry);
    //                 $prevDrum->heated_date = $prevDrum->heated_end;
    //                 $timeToStart = $prevDrum->heated_end;

    //                 $prevDrum->time_to_dry = $request->adjust_time_dry;
    //                 $prevDrum->save(); 
    //                 $processedDrumIds[] = $prevDrum->id; 
                
    //         }

    //         foreach ($processedDrumIds as $value) {
    //             $drum = Drum::findOrFail($value);
    //             $date = Carbon::parse($drum->heated_date)->subMinutes(390);

    //             if ($date->isYesterday()) {
    //                 $date->subDay();  
    //             }

    //             $drum->heated_date = $date; 
    //             $drum->save();
    //         }        
    //     }
    //     else {

    //             $drum = Drum::findOrFail($request->drums);

    //             $adjustDate = Carbon::parse($request->adjust_date);  
    //             $adjustTime = Carbon::parse($request->adjust_time);  
    //             $adjustDateTime = $adjustDate->setTimeFrom($adjustTime);

    //             $drum->heated_date = $adjustDateTime;
                
    //             $drum->time_to_dry = $request->adjust_time_dry;
                
    //             $drum->heated_end = $adjustDateTime->copy(); 
    //             $drum->heated_start = $drum->heated_end->copy()->subHours(5); 

    //             $drum->note = $request->reason;
    //             $drum->save();

    //     }
    //     return redirect()->back()->with('success', 'Thời gian đã được điều chỉnh');
    // }

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
        // $request->validate([
        //     'drum_ids' => 'required|string',
        //     'gio_ra_lo' => 'required|string',
        //     'ngay_ra_lo' => 'required|date',
        // ]);

        $drumIds = explode(',', $request->drum_ids);
        // $previousEndTime = null;

        foreach ($drumIds as $id) {
            $drum = Drum::find($id);
            if ($drum) {
                
                // $currentHeatingTime = Carbon::createFromFormat('H:i', $request->gio_ra_lo);
                
                
                // if ($previousEndTime) {
                //     $currentHeatingTime = $previousEndTime;
                // }
                
                $drum->status = 1;
                $drum->note = 'nhận ca';
                
                // $drum->heated_end = $currentHeatingTime->format('Y-m-d H:i:s'); 
                // $drum->heated_date = $request->ngay_ra_lo; 

                // $currentHeatingTime->addMinutes($drum->time_to_dry);

                $drum->save();

                // $previousEndTime = $currentHeatingTime;
            }
        }

        return redirect()->back()->with('success', 'Nhận ca thành công.');
    }


}