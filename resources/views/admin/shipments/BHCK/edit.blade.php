@extends('layouts.myapp')

@section('content')


    <h4 class="fw-bold my-4">Xuất hàng theo lệnh {{$order->ma_xuat}}</h4>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0 text-center text-white text-uppercase fw-bold">Thông tin yêu cầu</h5>
        </div>
        <div class="card-body mt-3">
            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label fw-bold">Loại hàng:</label>
                <div class="col-sm-8">
                    <p class="form-control-plaintext text-dark fw-bold">{{$order->loai_hang}}</p>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label fw-bold">Số lượng:</label>
                <div class="col-sm-8">
                    <p class="form-control-plaintext text-dark fw-bold">{{$order->so_luong}} tấn</p>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label fw-bold">Khách hàng:</label>
                <div class="col-sm-8">
                    <p class="form-control-plaintext text-dark fw-bold" >{{$order->contract->customer->name}}</p>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label fw-bold">Ngày đóng cont:</label>
                <div class="col-sm-8">
                    <p class="form-control-plaintext text-dark fw-bold">{{\Carbon\Carbon::parse($order->ngay_xuat)->format('d-m-Y')}}</p>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label fw-bold">Ngày nhận hàng:</label>
                <div class="col-sm-8">
                    <p class="form-control-plaintext text-dark fw-bold">{{\Carbon\Carbon::parse($order->ngay_nhan_hang)->format('d-m-Y')}}</p>
                </div>
            </div>

            <div class="mb-3 row">
                <label class="col-sm-4 col-form-label fw-bold">Lệnh xuất hàng:</label>
                <div class="col-sm-8">
                    @if($order->pdf)
                        <a target="_blank" href="{{ asset('contract_orders/' . $order->pdf) }}" class="btn btn-warning">Xem tệp</a>
                    @else
                        <span class="text-danger">Chưa cung cấp file</span>
                    @endif
                </div>
            </div>
        </div>
    </div>


    @include('partials.errors')

    <h4 class="fw-bold my-4">Danh sách lô có thể xuất</h4>

    <div class="filter-date d-flex align-items-end justify-content-between gap-2">
        {{-- <div class="">
            <label for="min" class="form-label mb-0">Lọc ngày</label>
            <input type="text" id="min" name="min" class="form-control" style="width: 200px">
        </div> --}}

        <form action="{{ route('shipments.store') }}" class="form-delete-items d-none" method="POST" onsubmit="return confirmExport();">
            @csrf
            <input type="hidden" name="batches" id="selected-drums">
            <input type="hidden" name="shipment_id" value="{{$order->id}}">
            <button class="btn btn-dark" type="submit">Xác nhận xuất</button>
        </form>
       
    </div>

    
<div class="d-flex justify-content-between align-items-end">
    <div class="filter-section  d-flex align-items-end gap-2 my-2">
        <div class="">
            <label for="dateFilterKho" class="" style="font-size: 14px">Ngày</label>
            <input type="text" id="dateFilterKho" class="form-control" placeholder="Chọn ngày" style="width: 120px" />
        </div>

        <div class="">
            <label for="FilterKho" style="font-size: 14px">Kho</label>
            <select name="" id="FilterKho" class="form-select">
                <option value="">Không</option>
                <option value="0">Trống</option>
                @foreach ($wares as $name => $items) 
                <option value="{{$name}}">{{$name}}</option>
                @endforeach
            </select>
        </div>

        <div class="">
            <label for="checkedFilterKho" style="font-size: 14px">Kiểm nghiệm</label>
            <select name="checked" id="checkedFilterKho" class="form-select">
                {{-- <option value="0">Chưa kiểm nghiệm</option> --}}
                <option value="1">Đã kiểm nghiệm</option>
            </select>
        </div>

        <input type="hidden" name="company_id" id="company_id" value="{{$company->id}}">


        {{-- <div class="">
            <label for="gradeFilterKho" style="font-size: 14px">Hạng</label>
            <select name="grade" id="gradeFilterKho" class="form-select">
                <option value="CSR10">CSR10</option>
                <option value="CSR20">CSR20</option>
            </select>
        </div> --}}

        <button id="btnKhoFilter" class="btn btn-primary">Lọc</button>
    </div>


    {{-- <div class="sync-data d-flex ">
        <a href="/update-lots">
            <button class="btn btn-success" id="update-checked">
                Cập nhật kiểm nghiệm
            </button>
        </a>
    </div> --}}
</div>




<table id="tableKho" class="ui celled table" style="width:100%">
     <thead>
            <tr>
                <th>Ngày</th>                    <!-- Date -->
                <th>Nơi lưu trữ</th>             <!-- Warehouse -->
                <th>Mã lô</th>                   <!-- Batch Code -->
                <th>Số bành</th>                 <!-- Bale Count -->
                <th>Kiểm nghiệm</th>             <!-- Checked -->
                <th>Trạng thái xuất kho</th>     <!-- Exported Status -->
                <th>Hạng dự kiến (CSR10/20)</th> <!-- Expected Grade -->
                <th>Số mẫu cắt</th>              <!-- Sample Cut Number -->
                <th>Dạng đóng gói</th>           <!-- Packaging Type -->
            </tr>
        </thead>
</table>

<style>
    #tableKho th:not(:first-child),
    #tableKho td:not(:first-child) {
        min-width: 100px;
        max-width: unset;
        text-align: center;
    }

    
</style>



    
            

@endsection



