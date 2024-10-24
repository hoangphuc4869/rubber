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
                {{-- <input type="hidden" id="selected-drums"> --}}
            </div>
            </div>
        </div>
    </div>





    <div class="filter-date d-flex align-items-end justify-content-between gap-2">

        <div class="d-flex justify-content-between align-items-center">
            <div class="filter-section  d-flex align-items-end gap-2 my-2">
                <div class="">
                    <label for="dateFilterDongGoi" class="" style="font-size: 14px">Ngày</label>
                    <input type="text" id="dateFilterDongGoi" class="form-control" placeholder="Chọn ngày" style="width: 120px" />
                </div>

                <div class="">
                    <label for="nongtruongFilterDongGoi" style="font-size: 14px">Nông trường</label>
                    <select name="" id="nongtruongFilterDongGoi" class="form-select">
                        <option value="NLNT1">NLNT1</option>
                        <option value="NLNT2">NLNT2</option>
                        <option value="NLNT3">NLNT3</option>
                        <option value="NLNT4">NLNT4</option>
                        <option value="NLNT5">NLNT5</option>
                        <option value="NLNT6">NLNT6</option>
                        <option value="NLNT7">NLNT7</option>
                        <option value="NLNT8">NLNT8</option>
                        <option value="NLTNSR">NLTNSR</option>
                        <option value="NLTM">NLTM</option>
                        <option value="MDBH">MDBH</option>
                        <option value="MDCR">MDCR</option>
                        <option value="NLTMMD">NLTMMD</option>
                    </select>
                    
                </div>

                <div class="">
                    <label for="linkFilterDongGoi" style="font-size: 14px">Dây chuyền</label>
                    <select name="" id="linkFilterDongGoi" class="form-select" style="width: 100px">
                        @if (Gate::allows('admin')  || Gate::allows('3t'))
                            <option value="3">3 tấn</option>
                        @endif
                        @if (Gate::allows('admin')  || Gate::allows('6t'))
                            <option value="6">6 tấn</option>
                        @endif
                        
                        
                    </select>
                </div>

                <button id="btnDongGoiFilter" class="btn btn-primary">Lọc</button>
            </div>
        </div>



            <div class="d-flex align-items-center gap-2 form-heat-items d-none">
                <div class="">
                    <button class="btn btn-dark" id="heatProcessingBtn" type="submit">Tạo lô</button>
                </div>
                <div class="">
                    <button type="button" class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Chỉnh sửa
                    </button>
                </div>
            </div>
        

    </div>


    <style>
        .button-group {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 10;
            width: 80%;
        }

    </style>


    <div class="heat-wrapper position-relative my-3">

        <div class="button-group">
            <div class="d-flex align-items-center gap-2">
                <button id="selectAllBtnDG" class="btn btn-primary">Tất Cả</button>
                <div>
                    <span id="selectedCount" class="text-dark fw-bold">Đã chọn: 0</span>
                </div>
            </div>
        </div>

        <table id="donggoiTable" class="ui celled table" style="width:100%">
            <thead>
                 <tr>
                    <th>Ngày ép kiện</th>
                    <th>Nguồn nguyên liệu</th>
                    <th>Thùng số</th>
                    <th>Thời gian ép kiện</th>
                    <th>Dây chuyền</th>
                    <th>Trạng thái</th>
                    <th>Số bành/thùng</th>
                    <th>Nhiệt độ ép bành (độ C)</th>
                    <th>Khối lượng bành (kg)</th>
                    <th>Kiểm tra cắt bành</th>
                    <th>Đánh giá</th>
                </tr>
            </thead>
        </table>

    </div>


    


    <h4 class="fw-bold py-3 mb-4">Thùng đã tạo lô</h4>

    <div class="filter-date d-flex align-items-end justify-content-between gap-2">
        <div class="d-flex justify-content-between align-items-center">
            <div class="filter-section  d-flex align-items-end gap-2 my-2">
                <div class="">
                    <label for="dateFilterDongGoi2" class="" style="font-size: 14px">Ngày</label>
                    <input type="text" id="dateFilterDongGoi2" class="form-control" placeholder="Chọn ngày" style="width: 120px" />
                </div>

                

                <div class="">
                    <label for="nogtruongFilterDongGoi2" style="font-size: 14px">Nông trường</label>
                    <select name="" id="nogtruongFilterDongGoi2" class="form-select">
                        <option value="NLNT1">NLNT1</option>
                        <option value="NLNT2">NLNT2</option>
                        <option value="NLNT3">NLNT3</option>
                        <option value="NLNT4">NLNT4</option>
                        <option value="NLNT5">NLNT5</option>
                        <option value="NLNT6">NLNT6</option>
                        <option value="NLNT7">NLNT7</option>
                        <option value="NLNT8">NLNT8</option>
                        <option value="NLTNSR">NLTNSR</option>
                        <option value="NLTM">NLTM</option>
                        <option value="MDBH">MDBH</option>
                        <option value="MDCR">MDCR</option>
                        <option value="NLTMMD">NLTMMD</option>
                    </select>
                </div>

                <div class="">
                    <label for="linkFilterDongGoi2" style="font-size: 14px">Dây chuyền</label>
                    <select name="" id="linkFilterDongGoi2" class="form-select" style="width: 100px">
                        @if (Gate::allows('admin')  || Gate::allows('3t'))
                            <option value="3">3 tấn</option>
                        @endif
                        @if (Gate::allows('admin')  || Gate::allows('6t'))
                            <option value="6">6 tấn</option>
                        @endif
                        
                        
                    </select>
                </div>

                <button id="btnDongGoiFilter2" class="btn btn-primary">Lọc</button>
            </div>
        </div>
    </div>


    
        <table id="donggoiTable2" class="hover ui celled table" style="width:100%">
        <thead>
            <tr>
                <th>Ngày thực hiện</th>
                <th>Nguồn nguyên liệu</th>
                <th>Thùng số</th>
                <th>Mã lô</th>
                <th>Số bành/thùng</th>
                <th>Thời gian tạo lô</th>
                <th>Dây chuyền</th>
                {{-- <th>Chủng loại</th> --}}
                <th>Trạng thái</th>
                <th>Nhiệt độ ép bành (độ C)</th>
                <th>Khối lượng bành (kg)</th>
                <th>Kiểm tra cắt bành</th>
                <th>Đánh giá</th>
            </tr>
        </thead>
        {{-- <tbody>
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
        </tbody> --}}
    </table>


    <style>

        #donggoiTable th,
        #donggoiTable td,
        #donggoiTable2 th,
        #donggoiTable2 td  {
            min-width: 90px;
            max-width: unset;
            text-align: center;
        },
       

    </style>


    <script>
        document.getElementById('heatProcessingBtn')?.addEventListener('click', function() {
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