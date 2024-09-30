@extends('layouts.myapp')

@section('content')


    <h4 class="fw-bold my-4">Xuất hàng theo lệnh {{$order->ma_xuat}}</h4>

    <h5>Thông tin yêu cầu</h5>

    <ul>
        <li>Loại hàng: <span>{{$order->loai_hang}}</span></li>
        <li>Số lượng: <span>{{$order->so_luong}} tấn</span></li>
        <li>Khách hàng: <span>{{$order->contract->customer->name}}</span></li>
    </ul>

    @include('partials.errors')

    <h4 class="fw-bold my-4">Danh sách lô có thể xuất</h4>

    <div class="filter-date d-flex align-items-end justify-content-between gap-2">
        <div class="">
            <label for="min" class="form-label mb-0">Lọc ngày</label>
            <input type="text" id="min" name="min" class="form-control" style="width: 200px">
        </div>

        <form action="{{ route('shipmentsTNSR.store') }}" class="form-delete-items d-none" method="POST" onsubmit="return confirmExport();">
            @csrf
            <input type="hidden" name="batches" id="selected-drums">
            <input type="hidden" name="shipment_id" value="{{$order->id}}">
            <button class="btn btn-dark" type="submit">Xác nhận xuất</button>
        </form>
       
    </div>

    <table id="datatable" class="ui celled table" style="width:100%">
        <thead>
            <tr>
                <th class="text-center"></th>
                <th>Ngày</th>
                <th>Công ty</th>
                <th>Mã lô</th>
                <th>Kiểm duyệt</th>
                <th>Trạng thái</th>
                <th>Hạng dự kiến (CSR10/20)</th>
                <th>Số mẫu cắt</th>
                <th>Dạng đóng gói</th>
               
            </tr>
        </thead>
        <tbody>
            
            @foreach ($batches as $index => $batch)
                @if ($batch->exported == 0 && $batch->warehouse_id !== null)
                    <tr id={{$batch->id}}>
                        <td></td>
                        <td>{{ \Carbon\Carbon::parse($batch->date)->format('d/m/Y') }}</td>
                        <td>{{ $batch->company->code }}</td>
                        <td>{{ $batch->batch_code }}</td>
                        <td>{!! $batch->checked == 0 ? "<span class='text-danger'>Chưa</span>" : "<span class='text-success'>Đã kiểm</span>"!!}</td>
                        <td>{!! $batch->exported == 0 ? "<span class='text-danger'>Chưa xuất kho</span>" : "<span class='text-dark'>Đã xuất kho</span>"!!}</td>
                        <td>{{ $batch->expected_grade }}</td>
                        <td>{{ $batch->sample_cut_number }}</td>
                        <td>{{ $batch->packaging_type }}</td>    
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>



    
            

@endsection



