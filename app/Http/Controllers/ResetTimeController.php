<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ResetTime;
use Illuminate\Support\Facades\Gate;

class ResetTimeController extends Controller
{
    public function update(Request $request)
    {

        if(Gate::denies('admin')) {
            return response()->json(['message' => 'Bạn không có quyền chỉnh sửa']);
        }
        
        $request->validate([
            'time' => 'required|date_format:H:i'
        ]);

        
        $resetTime = ResetTime::first();
        $resetTime->time = $request->time;
        $resetTime->save();

        return response()->json(['message' => 'Cập nhật thành công']);
    }
}