@extends('layouts.myapp')

@section('content')


    <h4 class="fw-bold my-4">Yêu cầu xuất hàng - {{$companyName}}</h4>

    <table id="dataOrder" class="ui celled table" style="width:100%">
        <thead>
            <tr>
                <th>Ngày</th>
                <th>Mã lệnh</th>
                <th>Loại hàng</th>
                <th>Công ty</th>
                <th>Số lượng</th>
                <th>Mã lô</th>
                <th>Trạng thái</th>
                <th>Tùy chỉnh</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shipments as $index => $ship)

                <tr id={{$ship->id}}>
                    <td>{{$ship->created_at->format('d/m/Y')}}</td>
                    <td>{{$ship->ma_xuat}}</td>
                    <td>{{$ship->loai_hang}}</td>
                    <td>{{$ship->contract->customer->name}}</td>
                    <td>{{$ship->so_luong}}</td>
                    <td>
                        {{ implode(', ', $ship->batches->map(function ($batch) {
                            return $batch->batch_code;
                        })->toArray()) }}
                        </td>
                    <td>{!!$ship->status == 0 ? '<span class="text-danger">Chưa xuất hàng<span>' : '<span class="text-success">Đã xuất hàng<span>'!!}</td>
                    <td>
                        @if ($ship->status == 0)
                            <a href="{{route('shipments.edit', [$ship->id])}}">
                                <button class="btn btn-warning">Xuất hàng</button>
                            </a>
                        @endif
                    </td> 
                   
                </tr>
            @endforeach
        </tbody>
    </table>
            

@endsection


