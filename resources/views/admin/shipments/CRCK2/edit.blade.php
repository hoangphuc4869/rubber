@extends('layouts.myapp')

@section('content')


    <h4 class="fw-bold my-4">Xuất hàng mã lệnh <button class="btn btn-dark">{{$order->ma_xuat}}</button></h4>

    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 text-center text-white text-uppercase fw-bold">Thông tin yêu cầu</h5>
                </div>
                <div class="card-body mt-3">
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label fw-bold">Loại hàng:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext text-dark fw-bold">{{ $order->loai_hang }}</p>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label fw-bold">Số lượng:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext text-dark fw-bold">{{ $order->so_luong }} tấn</p>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label fw-bold">Khách hàng:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext text-dark fw-bold">{{ $order->contract->customer->name }}</p>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label fw-bold">Ngày đóng cont:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext text-dark fw-bold">{{ $order->ngay_dong_cont ? \Carbon\Carbon::parse($order->ngay_dong_cont)->format('d-m-Y') : "" }}</p>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label fw-bold">Ngày xuất hàng:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext text-dark fw-bold">{{ $order->ngay_xuat ? \Carbon\Carbon::parse($order->ngay_xuat)->format('d-m-Y') : "" }}</p>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label fw-bold">Ngày nhận hàng:</label>
                        <div class="col-sm-8">
                            <p class="form-control-plaintext text-dark fw-bold">{{ $order->ngay_nhan_hang ? \Carbon\Carbon::parse($order->ngay_nhan_hang)->format('d-m-Y') : "" }}</p>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label fw-bold">Lệnh xuất hàng:</label>
                        <div class="col-sm-8">
                            @if ($order->pdf)
                                <a target="_blank" href="{{ asset('contract_orders/' . $order->pdf) }}" class="btn btn-warning">Xem tệp</a>
                            @else
                                <span class="text-danger">Chưa cung cấp file</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-center text-white text-uppercase fw-bold">Danh sách lô hàng</h5> 
                    <form action="/export-batches" id="exportForm" method="POST">
                        @csrf
                        <input type="hidden" name="batch_and_bale" id="batch_and_bale">
                        <input type="hidden" name="shipment_id" value="{{$order->id}}">
                        <input type="hidden" name="customer_id" value="{{$order->contract->customer->id}}">
                        <input type="hidden" name="com" value="CRCK2">
                        <button type="submit" class="btn btn-info">Xuất hàng</button>
                    </form>
                    <div class="">
                        <div class="fw-bold fs-5">Đã chọn: <span>0</span></div>
                        <div class="fw-bold fs-5">Tổng: <span style="color: aquamarine">0</span> / <span id="maxWeight">{{ $order->so_luong * 1000 }}</span>kg</div> 
                    </div>
                </div>
                <div class="card-body overflow-auto mt-3" style="height: 400px">
                    <div class="box-batch row"></div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.errors')

    <div class="mt-3">
                <div class="d-flex justify-content-between align-items-end">
                    <div class="filter-section d-flex align-items-end gap-2 my-2">
                        <div class="">
                            <label for="dateFilterKho" class="" style="font-size: 14px">Ngày</label>
                            <input type="text" id="dateFilterKho" class="form-control" placeholder="Chọn ngày" style="width: 120px" />
                        </div>

                        <div class="">
                            <label for="FilterKho" style="font-size: 14px">Kho</label>
                            <select name="" id="FilterKho" class="form-select">
                                @foreach ($wares as $name => $items) 
                                    <option value="{{ $name }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <input type="hidden" name="company_id" id="company_id" value="{{ $company->id }}">

                        <button id="btnKhoFilter" class="btn btn-primary">Lọc</button>
                    </div>
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
            </div>

    



<style>
    #tableKho th:not(:first-child),
    #tableKho td:not(:first-child) {
        min-width: 100px;
        max-width: unset;
        text-align: center;
    }
</style>



    
            

@endsection



