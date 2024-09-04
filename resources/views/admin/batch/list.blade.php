@extends('layouts.myapp')

@section('content')
    @include('partials.errors')

    <h4 class="fw-bold mb-5 mt-4">Lô hàng đã xuất</h4>


    <div class="filter-date d-flex align-items-center gap-2">
        <label for="min" class="form-label mb-0">Lọc ngày</label>
       <input type="text" id="min" name="min" class="form-control" style="width: 200px">
    </div>     
              
            
    
    <table id="datalist" class="ui celled table" style="width:100%">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>Ngày</th>
                <th>Lô số</th>
                <th>Mã lô</th>
                <th>Mã thùng</th>
                <th>Kiểm duyệt</th>
                <th>Trạng thái</th>
                <th>Kho lưu trữ</th>
                <th>Xuất đến</th>
            </tr>
        </thead>
        <tbody>
            
            @foreach ($batches as $index => $batch)
            
            <tr id={{$batch->id}}>
                <td>{{$index + 1}}</td>
                <td>{{ \Carbon\Carbon::parse($batch->created_at)->format('d/m/Y') }}</td>
               
                <td>{{ $batch->batch_number }}</td>
                <td>{{ $batch->batch_code }}</td>
                <td>{{ $batch->batch_code }}</td>
                <td>{!! $batch->status == 0 ? "<span class='text-danger'>Chưa</span>" : "<span class='text-success'>Đã kiểm</span>"!!}</td>
                <td>{!! $batch->exported == 0 ? "<span class='text-danger'>Chưa xuất kho</span>": "<span class='text-success'>Đã xuất kho</span>"!!}</td>
               
                <td>{{ $batch->warehouse !== null ? $batch->warehouse->code . '-'. $batch->warehouse->stack : "trống"}}</td>
                <td>{{ $batch->export_location}}</td>
             
                
            </tr>
            @endforeach
        </tbody>
    </table>

@endsection