@extends('layouts.myapp')

@section('content')

    <h4 class="fw-bold py-3 mb-4 text-warning">Tạo lô</h4>

    <h4 class="fw-bold py-3 mb-4">Theo dõi ra lò, ép bành</h4>

   
    <div class="d-flex gap-2 justify-content-end my-3 align-items-center">
        <span class="fw-bold fs-5">Số lô hiện tại: </span>
        <button class="crck btn btn-info">
                {{ $CRCK_batches?->total_batches > 0 ? $CRCK_batches->total_batches : 0}}
        </button>

        <button class="bhck btn btn-warning">
            {{ $BHCK_batches?->total_batches > 0 ? $BHCK_batches->total_batches : 0}}
        </button>

        <button class="tnsr btn btn-dark">
            {{ $TNSR_batches?->total_batches > 0 ? $TNSR_batches->total_batches : 0}}
        </button>
    </div>

    <style>
        .crck, .bhck, .tnsr{
            width: fit-content;
            min-width: 70px;
            /* height: 50px; */
            font-size: 30px;
            position: relative;
        }

        .crck::before {
            content: 'CRCK2';
            position: absolute;
            top: 0%;
            left: 50%;
            font-size: 10px;
            color: #fff;
            font-weight: bold;
            padding: 3px;
            transform: translate(-50%, -50%);
            background: green;

        }

        .tnsr::before {
            content: 'TNSR';
            position: absolute;
            top: 0%;
            left: 50%;
            font-size: 10px;
            color: #fff;
            font-weight: bold;
            padding: 3px;
            transform: translate(-50%, -50%);
            background: green;

        }

        .bhck::before {
            content: 'BHCK';
            position: absolute;
            top: 0%;
            left: 50%;
            font-size: 10px;
            color: $fff;
            font-weight: bold;
            padding: 3px;
            transform: translate(-50%, -50%);
            background: green;


        }
    </style>

    @include('partials.errors')

    <div class="card mb-4" id="newOrderCard" style="display:none">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Thêm lô mới</h5>
        </div>
        <div class="card-body">            
            <form action="{{ route('batch.store') }}" method="POST">
                @csrf
                <div class="row">
                    
                    
                    <input type="hidden" name="batch_number" value="{{$startIndex + 1}}" >
                   

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Hạng dự kiến (CSR10/20)</label>
                        <input type="text" required class="form-control" name="expected_grade" value="CSR10" >
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Số mẫu cắt</label>
                        <input type="number" min="0" required class="form-control" name="sample_cut_number" value="14" >
                        
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Dạng đóng gói</label>
                        <input type="text" required class="form-control" name="packaging_type" value="pallet sắt" >
                    </div>
                

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Ngày thực hiện</label>
                        <input type="date" name="date" id="dateInput" class="form-control">
                    </div>

                    <div class="mb-3 col-lg-3" style="opacity: 0; position: absolute; pointer-events: none">
                        <label class="form-label" >Giờ</label>
                        <input type="time" name="time" id="timeInput" class="form-control">
                    </div>

                    {{-- <div class="mb-3 col-lg-3">
                        <label class="form-label" >Công ty</label> <br>
                        <select name="company" class="form-select w-100">
                            <option value="2">BHCK</option>
                            <option value="1">CRCK2</option>
                        </select>
                    </div> --}}

                    <input type="hidden" name="drums[]" id="selected-drums">
                    <input type="hidden" name="link" id="link" value="3">
                    <input type="hidden" name="company" id="company" value="CRCK2">
                    
                    <button type="submit" class="btn btn-primary mt-2">Tạo</button>
                </div>
            </form>
        </div>
    </div>

    <div class="filter-date d-flex align-items-end justify-content-between gap-2">
        <div class="d-flex gap-3">
            <div class="">
                <label for="min" class="form-label mb-0">Lọc ngày</label>
                <input type="text" id="min" name="min" class="form-control" style="width: 200px">
            </div>
            <div class="filter-line d-flex align-items-end justify-content-between gap-2">
                <div class="">
                    <label for="lineFilter" class="form-label mb-0">Dây chuyền</label>
                    <select id="lineFilter" class="form-control" style="width: 200px">
                        <option value="3">3 tấn</option>
                        <option value="6">6 tấn</option>
                    </select>
                </div>
            </div>

            <div class="filter-line d-flex align-items-end justify-content-between gap-2">
                <div class="">
                    <label for="comFilter" class="form-label mb-0">Công ty</label>
                    <select id="comFilter" class="form-control" style="width: 200px">
                        <option value="BHCK">BHCK</option>
                        <option value="CRCK2" selected>CRCK2</option>
                        <option value="TNSR">TNSR</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center gap-2">
            <div class="d-none form-delete-items">
                <button class="btn btn-dark" id="heatProcessingBtn" type="submit">Tạo lô</button>
            </div>
            <div class="d-none form-delete-items">
                <button type="button" class="d-none form-delete-items btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Chỉnh sửa
                </button>
            </div>
        </div>
       
    </div>



    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Chỉnh sửa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="mb-3 col-lg-6">
                        <label for="bale_count" class="form-label">Số bành:</label>
                        <input type="number" min="1" id="bale_count" name="bale_count" class="form-control" required>
                    </div>
                    <div class="mb-3 col-lg-6">
                        <label for="sample_cut" class="form-label">Số mẫu cắt:</label>
                        <input type="number" min="1" id="sample_cut" name="sample_cut" class="form-control" required>
                    </div>
                    <div class="mb-3 col-lg-6">
                        <label for="pressing_temp" class="form-label">Nhiệt độ ép:</label>
                        <input type="number" id="pressing_temp" name="pressing_temp" class="form-control" required>
                    </div>
                    <div class="mb-3 col-lg-6">
                        <label for="evaluation" class="form-label">Đánh giá:</label>
                        <textarea id="evaluation" name="evaluation" class="form-control" required></textarea>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="updatebale">Cập nhật</button>
            </div>
            </div>
        </div>
    </div>


        
    
        
    

    <table id="datatable" class="ui celled table" style="width:100%">
        <thead>
            <tr>
                <th class="text-center"></th>
                <th>Ngày thực hiện</th>
                <th>Công ty</th>
                <th>Thùng số</th>
                <th>Mã thùng</th>
                <th>Thời gian ép kiện</th>
                <th>Dây chuyền</th>
                <th>Trạng thái</th>
                <th>Số bành/thùng</th>
                <th>Số bành còn lại</th>
                <th>Nhiệt độ ép bành (độ C)</th>
                <th>Khối lượng bành (kg)</th>
                <th>Kiểm tra cắt bành</th>
                <th>Đánh giá</th>
                {{-- <th>Tùy chỉnh</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($drumsWithoutBatches as $bale)
               
                <tr id={{$bale->id}}>
                        <td></td>
                        <td>{{ \Carbon\Carbon::parse($bale->created_at)->format('d/m/Y') }}</td>
                        <td>{{ $bale->curing_house ? $bale->curing_house->curing_area->farm->company->code : $bale->curing_area->farm->company->code }}</td>
                        <td>{{ $bale->name }}</td>
                        <td>{{ $bale->code }}</td>
                        <td data-sort="{{ \Carbon\Carbon::parse($bale->heated_end)->format('Y-m-d H:i') }}">{{ \Carbon\Carbon::parse($bale->heated_end)->format('H:i') }}</td>
                        <td>{{ $bale->link }}</td>
                        <td><span class="text-success">Đã ép kiện</span></td>
                        <td>{{ $bale->bale?->number_of_bales }}</td>
                        <td>{{ $bale->remaining_bales > 0 ? $bale->remaining_bales : $bale->bale?->number_of_bales }}</td>
                        <td>{{ $bale->bale?->press_temperature }}</td>
                        <td>{{ $bale->bale?->weight }}</td>
                        
                        <td>{{ $bale->bale?->cut_check }}</td>
                        <td>{{ $bale->bale?->evaluation }}</td>
                        {{-- <td>
                            <div class="custom d-flex gap-1">
                                <button class="editBtn editBaleBtn" data-id="{{$bale->id}}">
                                    <svg height="1em" viewBox="0 0 512 512">
                                        <path
                                        d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"
                                        ></path>
                                    </svg>
                                </button>
                                <form action="{{route('producing.destroy', [$bale->id])}}" method="POST" onsubmit="return confirmDelete();">
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
                        </td> --}}
                    </tr>
               
            @endforeach
        </tbody>
    </table>


    <h4 class="fw-bold py-3 mb-4">Thùng đã tạo lô</h4>

    <div class="filter-date d-flex align-items-end justify-content-between gap-2">
        <div class="d-flex gap-3">
            <div class="">
                <label for="min5" class="form-label mb-0">Lọc ngày</label>
                <input type="text" id="min5" name="min5" class="form-control" style="width: 200px">
            </div>
            <div class="filter-line d-flex align-items-end justify-content-between gap-2">
                <div class="">
                    <label for="lineFilter5" class="form-label mb-0">Dây chuyền</label>
                    <select id="lineFilter5" class="form-control" style="width: 200px">
                        <option value="3">3 tấn</option>
                        <option value="6">6 tấn</option>
                    </select>
                </div>
            </div>

            <div class="filter-line d-flex align-items-end justify-content-between gap-2">
                <div class="">
                    <label for="comFilter5" class="form-label mb-0">Công ty</label>
                    <select id="comFilter5" class="form-control" style="width: 200px">
                        <option value="BHCK">BHCK</option>
                        <option value="CRCK2" selected>CRCK2</option>
                        <option value="TNSR">TNSR</option>
                    </select>
                </div>
            </div>
        </div>
       
    </div>


    <div class="container">
        <table id="datatable5" class="ui celled table" style="width:100%">
        <thead>
            <tr>
                <th>Ngày thực hiện</th>
                <th>Công ty</th>
                <th>Thùng số</th>
                <th>Mã thùng</th>
                <th>Mã lô</th>
                <th>Số bành/thùng</th>
                <th>Thời gian tạo lô</th>
                <th>Dây chuyền</th>
                <th>Chủng loại</th>
                <th>Trạng thái</th>
                <th>Nhiệt độ ép bành (độ C)</th>
                <th>Khối lượng bành (kg)</th>
                <th>Kiểm tra cắt bành</th>
                <th>Đánh giá</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($drumsWithBatches as $bale)
               
                <tr id="{{$bale->id}}">
                        <td>{{ \Carbon\Carbon::parse($bale->heated_end)->format('d/m/Y') }}</td>
                        <td>{{ $bale->curing_house ? $bale->curing_house->curing_area->farm->company->code :  $bale->curing_area->farm->company->code  }}</td>
                        <td>{{ $bale->name }}</td>
                        <td>{{ $bale->code }}</td>
                        <td>
                                {{ implode(', ', $bale->batches->pluck('batch_code')->toArray()) }}
                        </td>
                        <td>
                            {{ implode(', ', $bale->batches->map(function ($batch) {
                                return $batch->pivot->bale_count;
                            })->toArray()) }}
                        </td>
                        <td data-sort="{{ \Carbon\Carbon::parse($bale->heated_end)->format('Y-m-d H:i') }}">{{ \Carbon\Carbon::parse($bale->heated_end)->format('H:i') }}</td>
                        <td>{{ $bale->link }}</td>
                        <td>{{ $bale->curing_house ? 'MDC' : 'MD'}}</td>
                        <td><span class="text-info">Đã đóng lô</span></td>
                        
                        <td>{{ $bale->bale->press_temperature }}</td>
                        <td>{{ $bale->bale->weight }}</td>
                        <td>{{ $bale->bale->cut_check }}</td>
                        <td>{{ $bale->bale->evaluation }}</td>
                    </tr>
               
            @endforeach
        </tbody>
    </table>
    </div>

    <script>
        document.getElementById('heatProcessingBtn').addEventListener('click', function() {
            document.getElementById('newOrderCard').style.display = 'block';
        });

        document.addEventListener('click', function(event) {
            if (!newOrderCard.contains(event.target) && !heatProcessingBtn.contains(event.target)) {
                newOrderCard.style.display = 'none';
            }
        });
    </script>

    <style>
        td {
            text-align: center!important;
        }
    </style>



@endsection