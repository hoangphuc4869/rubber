@extends('layouts.myapp')

@section('content')

{{-- <h4 class="fw-bold py-3 mb-2 mt-2">Tạo kho hàng</h4> --}}
@include('partials.errors')
<form action="{{ route('warehouse.store') }}" method="POST" class="ware-form">
    @csrf

    <label for="warename">Tên kho:</label>
    <input type="text" id="warename" name="name" required class="cus-input">

    <label for="rows">Số hàng:</label>
    <input type="number" id="rows" name="rows" min="1" required class="cus-input">
    <button type="submit" class="btn btn-dark">Tạo kho</button>
</form> 


<h4 class="fw-bold my-4">Danh sách lô hàng - {{$companyName}}</h4>

<div class="my-2">
    {{-- <div class="fw-bold">Tổng số lô: <span class="text-success fs-4">{{$count}}</span></div> --}}
    <div class="fw-bold">Tổng Khôi lượng: <span class="text-success fs-4">{{$total_bales * 35}} kg</span> {{$total_bales . ", " .  $csr10_count . ", " . $csr20_count}}</div>
    <div class="fw-bold">Tổng khối lượng lô CSR10: 
        <span class="text-success fs-4">{{ number_format($csr10_count * 35, 0, ',', '.') }} kg</span>
    </div>
    <div class="fw-bold">Tổng khối lượng lô CSR20: 
        <span class="text-success fs-4">{{ number_format($csr20_count * 35, 0, ',', '.') }} kg</span>
    </div>


</div>
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

<div class="filter-date d-flex align-items-end justify-content-between gap-2">
    <div class="">
        <label for="min" class="form-label mb-0">Lọc ngày</label>
        <input type="text" id="min" name="min" class="form-control" style="width: 200px">
    </div>

    <div class="d-flex align-items-center gap-2">
        <form action="{{ route('batch-delete-items') }}" class="form-delete-items d-none" method="POST"
            onsubmit="return confirmDelete();">
            @csrf
            @method('DELETE')
            <input type="hidden" name="drums" id="selected-drums">
            <button class="btn btn-danger" type="submit">Xóa tất cả</button>
        </form>

        {{-- <button type="button" class="btn btn-primary storeButton d-none" data-bs-toggle="modal" data-bs-target="#modalExport">
                Lưu kho
            </button> --}}
    </div>


</div>

<div class="sync-data my-3 d-flex ">
    <a href="/update-lots">
        <button class="btn btn-dark">
            Cập nhật kiểm nghiệm
        </button>
    </a>
</div>

<table id="datatable" class="ui celled table" style="width:100%">
    <thead>
        <tr>
            <th class="text-center"></th>
            <th>Ngày</th>
            <th>Nơi lưu trữ</th>
            <th>Tùy chỉnh</th>
            <th>Công ty</th>
            <th>Mã lô</th>
            <th>Số bành</th>
            <th>Kiểm nghiệm</th>
            <th>Trạng thái</th>
            <th>Hạng dự kiến (CSR10/20)</th>
            <th>Số mẫu cắt</th>
            <th>Dạng đóng gói</th>

        </tr>
    </thead>
    <tbody>

        @foreach ($batches as $index => $batch)

        <tr id={{$batch->id}} class="{{$batch->exported == 1 ? 'no-select' : ''}}">
            <td></td>
            <td>{{ \Carbon\Carbon::parse($batch->date)->format('d/m/Y') }}</td>
            <td>{!! $batch->warehouse !== null ? '<span class="fw-bold"
                    style="color: #000a8d ">'.$batch->warehouse->code.'</span>' : "<span
                    class='text-danger'>Trống</span>"!!}</td>
            <td>
                @if ($batch->exported == 0)
                <div class="custom d-flex gap-1">
                    <button type="button" class="editBtn editWare" data-bs-toggle="modal" data-bs-target="#modalCenter"
                        data-id="{{$batch->id}}" data-warehouseId='{{$batch->warehouse_id}}'>
                        <svg height="1em" viewBox="0 0 512 512">
                            <path
                                d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z">
                            </path>
                        </svg>
                    </button>
                    <form action="{{route('batch.destroy', [$batch->id])}}" method="POST"
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
                    </form>
                </div>
                @endif
            </td>
            <td>{{ $batch->company->code }}</td>
            <td>{{ $batch->batch_code }}</td>
            <td>{!! $batch->bale_count == 144 ? "<span class='text-dark'>" . $batch->bale_count . "</span>" : "<span
                    class='text-danger'>" . $batch->bale_count . "</span>"!!}</td>
            <td>{!! $batch->checked == 0 ? "<span class='text-danger'>Chưa</span>" : "<span class='text-success'>Đã kiểm
                    nghiệm</span>"!!}</td>
            <td>{!! $batch->exported == 0 ? "<span class='text-danger'>Chưa xuất kho</span>" : "<span
                    class='text-dark'>Đã xuất kho</span>"!!}</td>
            <td>{{ $batch->expected_grade }}</td>

            <td>{{ $batch->sample_cut_number }}</td>
            <td>{{ $batch->packaging_type }}</td>



        </tr>
        @endforeach
    </tbody>
</table>

<h4 class="fw-bold py-3 mb-2">Kho lưu trữ</h4>

<div class="wares-stock nav-align-top my-3">
    {{-- <ul class="nav nav-pills mb-3" role="tablist">
            <li class="nav-item">
            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-class1" aria-controls="navs-pills-top-class1" aria-selected="true">
                Lớp 1
            </button>
            </li>
            <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-class2" aria-controls="navs-pills-top-class2" aria-selected="false">
                Lớp 2
            </button>
            </li>
            <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-class3" aria-controls="navs-pills-top-class3" aria-selected="false">
                Lớp 3
            </button>
            </li>
            <li class="nav-item">
            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-class4" aria-controls="navs-pills-top-class4" aria-selected="false">
                Lớp 4
            </button>
            </li>
        </ul> --}}
    <div class="tab-content">
        <div class="tab-pane fade show active" id="navs-pills-top-class1" role="tabpanel">
            <div class="warehouse-container">
                @foreach ($wares as $name => $items)
                <h3 class="d-flex gap-2">
                    <span class="fw-bold">{{$name}}</span>
                    <form action="{{route('warehouse.destroy', [$name])}}" method="POST"
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
                    </form>
                </h3>
                <div class="warehouses mb-3">
                    @foreach ($items as $item)
                    <div draggable="true" class="grid-item {{$item->batch_id !== null ? 'occupied' : ''}}"
                        id="{{$item->id}}" data-code="{{$item->code . '-' . $item->stack}}">
                        <div class="content">
                            {{$item->code}}
                        </div>
                        <div class="data-content">
                            @if ($item->batches)
                            @foreach ($item->batches as $i)
                            @if ($i->exported !== 1)
                            {{$i->batch_code}}
                            @endif
                            @endforeach
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>





@endsection