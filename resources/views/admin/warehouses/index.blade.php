@extends('layouts.myapp')

@section('content')

{{-- <h4 class="fw-bold py-3 mb-2 mt-2">Tạo kho hàng</h4> --}}
@include('partials.errors')
{{-- <form action="{{ route('warehouse.store') }}" method="POST" class="ware-form">
    @csrf

    <label for="warename">Tên kho:</label>
    <input type="text" id="warename" name="name" required class="cus-input">

    <label for="rows">Số hàng:</label>
    <input type="number" id="rows" name="rows" min="1" required class="cus-input">
    <button type="submit" class="btn btn-dark">Tạo kho</button>
</form>  --}}


<h4 class="fw-bold my-4">Danh sách lô hàng - {{$companyName}}</h4>

{{-- <div class="my-2">
    
    <div class="fw-bold">Tổng Khôi lượng: <span class="text-success fs-4">{{$total_bales * 35}} kg</span>
    <div class="fw-bold">Tổng khối lượng lô CSR10: 
        <span class="text-success fs-4">{{ number_format($csr10_count * 35, 0, ',', '.') }} kg</span>
    </div>
    <div class="fw-bold">Tổng khối lượng lô CSR20: 
        <span class="text-success fs-4">{{ number_format($csr20_count * 35, 0, ',', '.') }} kg</span>
    </div>


</div> --}}
{{-- <input type="hidden" name="drums[]" id="selected-drums"> --}}

<!-- Modal -->

<div class="modal fade  modalWare" id="modalCenter" tabindex="-1" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCenterTitle">Chỉnh sửa lô hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-2">
                    <div class="col-12" id="wareModal">
                        <label for="slot" class="form-label d-block">Nơi lưu trữ</label>
                        <select name="slot" required id="slot" class="form-select custom-select-ware w-100">
                            <option value="">Chọn nơi lưu trữ</option>
                            @foreach ($warehouses as $item)
                            <option value="{{$item->id}}" {{$item->batch_id !== null ? 'disabled' : ''}}>{{$item->code}}
                                {!!$item->batch_id !== null ? '(đang chứa hàng)' : ''!!}</option>`
                            @endforeach
                        </select>
                        <input type="hidden" id="batch_id" value="">

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary updateWare">Cập nhật</button>
            </div>
        </div>
    </div>
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
                <option value="0">Trống</option>
                    @foreach ($wares as $name => $items) 
                    <option value="{{$name}}">{{$name}}</option>
                    @endforeach
                <option value="">Tất cả</option>

            </select>
        </div>

        <div class="">
            <label for="nongtruongFilterList" style="font-size: 14px">Nguồn</label>
            <select name="" id="nongtruongFilterList" class="form-select">

                @if ($companyName == "B.H.C.K")
                    <option value="NLNT4">NT4</option>
                    <option value="NLNT5">NT5</option>
                    <option value="NLNT7">NT7</option>
                    <option value="NLNT8">NT8</option>
                    <option value="MDBH">MDBH</option>
                @endif

                @if ($companyName == "C.R.C.K.2")
                    <option value="NLNT1">NT1</option>
                    <option value="NLNT2">NT2</option>
                    <option value="NLNT3">NT3</option>
                    <option value="NLNT6">NT6</option>
                    <option value="NLTM">TM</option>
                    <option value="MDCR">MDCR</option>
                    <option value="NLTMMD">NLTMMD</option>
                @endif

                @if ($companyName == "TNSI")
                    <option value="NLTNSR">TNSR</option>
                @endif
            </select>
        </div>

        <div class="">
            <label for="checkedFilterKho" style="font-size: 14px">Kiểm nghiệm</label>
            <select name="checked" id="checkedFilterKho" class="form-select">
                <option value="0">Chưa kiểm nghiệm</option>
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


    <div class="sync-data d-flex ">
        <a href="/update-lots">
            <button class="btn btn-success" id="update-checked">
                Cập nhật kiểm nghiệm
            </button>
        </a>
    </div>
</div>




<table id="tableKho" class="ui celled table" style="width:100%">
     <thead>
            <tr>
                <th>Ngày</th>                    <!-- Date -->
                <th>Nơi lưu trữ</th>             <!-- Warehouse -->
                <th>Tùy chỉnh</th>               <!-- Actions (Custom options) -->
                <th>Công ty</th>                 <!-- Company -->
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

<h4 class="fw-bold py-3 mb-2">Kho lưu trữ</h4>

<div class="wares-stock nav-align-top my-3">
    <div class="tab-content">
        <div class="tab-pane fade show active" id="navs-pills-top-class1" role="tabpanel">
            <div class="warehouse-container">
                @foreach ($waresWithCount as $name => $items)
                <div class="my-5">
                    <h3 class="d-flex gap-2">
                        <span class="fw-bold fs-3">{{$name}} - {{$items['count']}} lô - {{ number_format($items['total_bale_count'] * 35) }} tấn</span>
                        {{-- <form action="{{route('warehouse.destroy', [$name])}}" method="POST"
                            onsubmit="return confirmDelete();">
                            @csrf
                            @method('DELETE')
                            <button class="bin-button">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 39 7" class="bin-top">
                                    <line stroke-width="4" stroke="white" y2="5" x2="39" y1="5"></line>
                                    <line stroke-width="3" stroke="white" y2="1.5" x2="26.0357" y1="1.5" x1="12"></line>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 33 39" class="bin-bottom">
                                    <mask fill="white" id="path-1-inside-1_8_19">
                                        <path d="M0 0H33V35C33 37.2091 31.2091 39 29 39H4C1.79086 39 0 37.2091 0 35V0Z">
                                        </path>
                                    </mask>
                                    <path mask="url(#path-1-inside-1_8_19)" fill="white"
                                        d="M0 0H33H0ZM37 35C37 39.4183 33.4183 43 29 43H4C-0.418278 43 -4 39.4183 -4 35H4H29H37ZM4 43C-0.418278 43 -4 39.4183 -4 35V0H4V35V43ZM37 0V35C37 39.4183 33.4183 43 29 43V35V0H37Z">
                                    </path>
                                    <path stroke-width="4" stroke="white" d="M12 6L12 29"></path>
                                    <path stroke-width="4" stroke="white" d="M21 6V29"></path>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 89 80" class="garbage">
                                    <path fill="white"
                                        d="M20.5 10.5L37.5 15.5L42.5 11.5L51.5 12.5L68.75 0L72 11.5L79.5 12.5H88.5L87 22L68.75 31.5L75.5066 25L86 26L87 35.5L77.5 48L70.5 49.5L80 50L77.5 71.5L63.5 58.5L53.5 68.5L65.5 70.5L45.5 73L35.5 79.5L28 67L16 63L12 51.5L0 48L16 25L22.5 17L20.5 10.5Z">
                                    </path>
                                </svg>
                            </button>
                        </form> --}}
                    </h3>
                    <div class="warehouses mb-3">
                        @foreach ($items['items'] as $item)
                        <div draggable="true" class="grid-item {{$item->batch_id !== null ? 'occupied' : ''}}"
                            id="{{$item->id}}" data-code="{{$item->code . '-' . $item->stack}}">
                            <div class="content">
                                {{$item->code}}
                            </div>
                            <div class="data-content">
                                @if ($item->batches)
                                @foreach ($item->batches as $i)
                                @if ($i->exported !== 1)
                                {{$i->batch_code}} <span class="grade_batch fw-bold" style="color: #0008c4">{{$i->bale_count < 144 ? "(" . $i->bale_count . "b)" : ""}}</span>
                                @endif
                                @endforeach
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>





@endsection