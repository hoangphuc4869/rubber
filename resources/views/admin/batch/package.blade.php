@extends('layouts.myapp')

@section('content')

    <h4 class="fw-bold py-3 mb-4 text-warning">Tạo lô</h4>

    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Thêm lô mới</h5>
            <h5 class="mb-0 fw-bold">Số lô hiện tại: <span class="text-success">{{$startIndex}}</span></h5>
        </div>
        <div class="card-body">
            @include('partials.errors')
            
            <form action="{{ route('batch.store') }}" method="POST">
                @csrf
                <div class="row">
                    
                    <div class="mb-3 col-lg-3">
                        <label class="form-label">Số lô</label>
                        <input type="number" required class="form-control" name="batch_number" value="{{$startIndex + 1}}" >
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label">Chọn thùng</label>
                        <select name="drums_to_pack[]" required class="form-select custom-select2" multiple='multiple'>
                            @foreach ($drums_to_pack as $item)
                                <option value="{{ $item->id }}">
                                    Thùng {{ $item->name }} ({{$item->bale->number_of_bales}} bành, {{\Carbon\Carbon::parse($item->date)->format('d/m/Y')}})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Hạng dự kiến (CSR10/20)</label>
                        <input type="text" required class="form-control" name="expected_grade" value="CSR10" >
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Số mẫu cắt</label>
                        <input type="number" min="0" required class="form-control" name="sample_cut_number" value="7" >
                        
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Dạng đóng gói</label>
                        <input type="text" required class="form-control" name="packaging_type" value="P.sắt" >
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Nơi lưu trữ</label>  
                        <input type="hidden" name="warehouse_id" id="id_to_send">
                        <input type="text" required class="form-control" id="warehouse_id" readonly value="" >
                        {{-- <select name="warehouse_id" required class="form-select custom-select">
                            
                            @foreach ($warehouses as $item)
                                <option value="{{$item->id}}" {{$item->batch_id !== null ? 'disabled' : ''}}>{{$item->code.'-'.$item->stack}} {!!$item->batch_id !== null ? '(đã chứa lô)' : ''!!}</option>`
                            @endforeach
                            
                            
                        </select> --}}
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Ngày thực hiện</label>
                        <input type="date" name="date" id="dateInput" class="form-control">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Giờ</label>
                        <input type="time" name="time" id="timeInput" class="form-control">
                    </div>

                    <input type="hidden" name="drums[]" id="selected-drums">
                    
                    <button type="submit" class="btn btn-primary mt-2">Tạo</button>
                </div>
            </form>
        </div>
    </div>

    <h4 class="fw-bold py-3 mb-4">Thành phẩm</h4>

    <div class="toast-group">
        <div class="toaster-success bs-toast toast toast-placement-ex m-2 fade bg-success bottom-0 end-0 hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
            <div class="toast-header">
                <i class="bx bx-bell me-2"></i>
                <div class="me-auto fw-semibold">Thông báo</div>
                <small>1s trước</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">Yêu cầu thành công</div>
        </div>

        <div class="toaster-fail bs-toast toast toast-placement-ex m-2 fade bg-danger bottom-0 end-0 hide" role="alert" aria-live="assertive" aria-atomic="true" data-delay="2000">
            <div class="toast-header">
                <i class="bx bx-bell me-2"></i>
                <div class="me-auto fw-semibold">Thông báo</div>
                <small>1s trước</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">Có lỗi xảy ra. Vui lòng kiểm tra lại</div>
        </div>
   </div>

    <div class="filter-date d-flex align-items-center gap-2">
        <label for="min" class="form-label mb-0">Lọc ngày</label>
       <input type="text" id="min" name="min" class="form-control" style="width: 200px">
    </div>     
    
    <table id="material-heating" class="ui celled table" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Ngày tạo</th>
                <th>Hạng dự kiến (CSR10/20)</th>
                <th>Lô số</th>
                <th>Mã lô</th>
                <th>Trạng thái</th>
                <th>Số mẫu cắt</th>
                <th>Dạng đóng gói</th>
                <th>Nơi lưu trữ</th>
                <th>Tùy chỉnh</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($batches as $index => $batch)
            <tr id={{$batch->id}}>

                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($batch->date)->format('d/m/Y') }}</td>
                <td>{{ $batch->expected_grade }}</td>
                <td>{{ $batch->batch_number }}</td>
                <td>{{ $batch->batch_code }}</td>
                <td>{!! $batch->status == 0 ? "<span class='text-danger'>Chưa xuất kho</span>" : "<span class='text-success'>Đã xuất kho</span>"!!}</td>
                <td>{{ $batch->sample_cut_number }}</td>
                <td>{{ $batch->packaging_type }}</td>
                <td>{{ $batch->warehouse !== null ? $batch->warehouse->code . '-'. $batch->warehouse->stack : "trống"}}</td>
             
                <td>
                    <div class="custom d-flex gap-1">
                        <form action="{{route('batch.destroy', [$batch->id])}}" method="POST" onsubmit="return confirmDelete();">
                            @csrf
                            @method('DELETE')
                                <button class="bin-button">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 39 7"
                                class="bin-top"
                            >
                                <line stroke-width="4" stroke="white" y2="5" x2="39" y1="5"></line>
                                <line
                                stroke-width="3"
                                stroke="white"
                                y2="1.5"
                                x2="26.0357"
                                y1="1.5"
                                x1="12"
                                ></line>
                            </svg>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 33 39"
                                class="bin-bottom"
                            >
                                <mask fill="white" id="path-1-inside-1_8_19">
                                <path
                                    d="M0 0H33V35C33 37.2091 31.2091 39 29 39H4C1.79086 39 0 37.2091 0 35V0Z"
                                ></path>
                                </mask>
                                <path
                                mask="url(#path-1-inside-1_8_19)"
                                fill="white"
                                d="M0 0H33H0ZM37 35C37 39.4183 33.4183 43 29 43H4C-0.418278 43 -4 39.4183 -4 35H4H29H37ZM4 43C-0.418278 43 -4 39.4183 -4 35V0H4V35V43ZM37 0V35C37 39.4183 33.4183 43 29 43V35V0H37Z"
                                ></path>
                                <path stroke-width="4" stroke="white" d="M12 6L12 29"></path>
                                <path stroke-width="4" stroke="white" d="M21 6V29"></path>
                            </svg>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 89 80"
                                class="garbage"
                            >
                                <path
                                fill="white"
                                d="M20.5 10.5L37.5 15.5L42.5 11.5L51.5 12.5L68.75 0L72 11.5L79.5 12.5H88.5L87 22L68.75 31.5L75.5066 25L86 26L87 35.5L77.5 48L70.5 49.5L80 50L77.5 71.5L63.5 58.5L53.5 68.5L65.5 70.5L45.5 73L35.5 79.5L28 67L16 63L12 51.5L0 48L16 25L22.5 17L20.5 10.5Z"
                                ></path>
                            </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


    <div class="stock-wrap shadow-sm">
        <div class="close">
            &times;
        </div>
        <div class="wares-stock nav-align-top" >
            <ul class="nav nav-pills mb-3" role="tablist">
                <li class="nav-item">
                <button type="button" class="nav-link active text-white" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-class1" aria-controls="navs-pills-top-class1" aria-selected="true">
                    Lớp 1
                </button>
                </li>
                <li class="nav-item">
                <button type="button" class="nav-link text-white" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-class2" aria-controls="navs-pills-top-class2" aria-selected="false">
                    Lớp 2
                </button>
                </li>
                <li class="nav-item">
                <button type="button" class="nav-link text-white" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-class3" aria-controls="navs-pills-top-class3" aria-selected="false">
                    Lớp 3
                </button>
                </li>
                <li class="nav-item">
                <button type="button" class="nav-link text-white" role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-class4" aria-controls="navs-pills-top-class4" aria-selected="false">
                    Lớp 4
                </button>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="navs-pills-top-class1" role="tabpanel">
                    <div class="warehouse-container">
                        @foreach ($wares1 as $name => $items)
                            <h3>{{$name}}</h3>
                            <div class="warehouses mb-3">
                            @foreach ($items as $item)
                                <div class="grid-item {{$item->batch_id !== null ? 'occupied' : ''}}" data-message="{{$item->batch_id !== null ? 'Không thể chọn kho đã chứa nguyên liệu' : ''}}" id="{{$item->id}}" data-code="{{$item->code . '-' . $item->stack}}">
                                    <div class="">
                                        {{$item->code}}
                                    </div>
                                    {{$item->batch_id !== null ? $item->batch->batch_code : '' }}
                                </div>
                            @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="navs-pills-top-class2" role="tabpanel">
                    <div class="warehouse-container">
                        @foreach ($wares2 as $name => $items)
                            <h3>{{$name}}</h3>
                            <div class="warehouses mb-3">
                            @foreach ($items as $item)
                                <div class="grid-item {{$item->batch_id !== null ? 'occupied' : ''}}" data-message="{{$item->batch_id !== null ? 'Không thể chọn kho đã chứa nguyên liệu' : ''}}" id="{{$item->id}}" data-code="{{$item->code . '-' . $item->stack}}">
                                    <div class="">
                                        {{$item->code}}
                                    </div>
                                    {{$item->batch_id !== null ? $item->batch->batch_code : '' }}
                                </div>
                            @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="navs-pills-top-class3" role="tabpanel">
                    <div class="warehouse-container">
                        @foreach ($wares3 as $name => $items)
                            <h3>{{$name}}</h3>
                            <div class="warehouses mb-3">
                            @foreach ($items as $item)
                                <div class="grid-item {{$item->batch_id !== null ? 'occupied' : ''}}" data-message="{{$item->batch_id !== null ? 'Không thể chọn kho đã chứa nguyên liệu' : ''}}" id="{{$item->id}}" data-code="{{$item->code . '-' . $item->stack}}">
                                    <div class="">
                                        {{$item->code}}
                                    </div>
                                    {{$item->batch_id !== null ? $item->batch->batch_code : '' }}
                                </div>
                            @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="tab-pane fade" id="navs-pills-top-class4" role="tabpanel">
                    <div class="warehouse-container">
                        @foreach ($wares4 as $name => $items)
                            <h3>{{$name}}</h3>
                            <div class="warehouses mb-3">
                            @foreach ($items as $item)
                                <div class="grid-item {{$item->batch_id !== null ? 'occupied' : ''}}" data-message="{{$item->batch_id !== null ? 'Không thể chọn kho đã chứa nguyên liệu' : ''}}" id="{{$item->id}}" data-code="{{$item->code . '-' . $item->stack}}">
                                    <div class="">
                                        {{$item->code}}
                                    </div>
                                    {{$item->batch_id !== null ? $item->batch->batch_code : '' }}
                                </div>
                            @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
   </div>
@endsection