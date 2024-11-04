@extends('layouts.myapp')

@section('content')
<h4 class="fw-bold py-3 mb-4">Cán vắt</h4>

<div class="row">
    <div class="col-lg-6">
        <div class="text-center mb-2 fw-bold">Nguyên liệu mủ đông chén</div>
        <div class="grid-areas">
            @foreach ($curing_areas as $item)
            @if ($item->latex_type == 'Mủ đông chén')
            <div class="area-item rol btn btn-{{$item->containing > 0 ? 'warning containing' : 'dark' }}">
                <div class="code">
                    {{$item->code}}
                </div>
                <span class="number">{{ number_format($item->containing, 0, '.', ',') }}</span> kg
            </div>
            @endif
            @endforeach
        </div>
    </div>

    <div class="col-lg-6">
        <div class="text-center mb-2 fw-bold">Nguyên liệu đã cán vắt</div>
        <div class="grid-areas">
            @foreach ($curing_houses as $item)
            <div class="area-item btn btn-{{$item->containing > 0 ? 'success containing' : 'dark' }}">
                <div class="code">
                    {{$item->code}}
                </div>
                <span class="number">{{ number_format($item->containing, 0, '.', ',') }}</span> kg
            </div>
            @endforeach
        </div>
    </div>
</div>

<h4 class="fw-bold">Nguyên liệu đã cán vắt</h4>

<div class="d-flex justify-content-between">
    <div class="">
        <div class="mb-1"> - Tổng cán vắt BHCK: <span
                class="fw-bold fs-4 text-danger">{{ number_format($cv_bhck, 0, ',', '.') }}
                tấn</span> </div>
        <div class="mb-1"> - Tổng cán vắt CRCK2: <span
                class="fw-bold fs-4 text-success">{{ number_format($cv_crck, 0, ',', '.') }}
                tấn</span> </div>
        <div class="mb-1"> - Tổng cán vắt Thu mua: <span
                class="fw-bold fs-4 text-warning">{{ number_format($cv_tm, 0, ',', '.') }}
                tấn</span> </div>
        <div class="mb-1"> - Tổng cán vắt TNSR: <span class="fw-bold fs-4">{{ number_format($cv_tnsr, 0, ',', '.') }}
                tấn</span> </div>
    </div>
</div>

<div class="d-flex justify-content-end align-items-center">
    <button class="addBtn  btn my-3 btn-dark">Thêm mới</button>
</div>

<div class="card mb-4 form-machine">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Thêm lệnh</h5>
    </div>
    <div class="card-body">

        <form action="{{ route('rolling.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="mb-3 col-lg-4">
                    <label class="form-label">Bãi nguyên liệu</label>

                    <select name="curing_area_id" id="areaSelect" class="form-select custom-select w-100">
                        @foreach ($areas as $item)
                        <option value="{{$item->id}}" data-containing="{{$item->containing}}">{{$item->code}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-lg-4">
                    <label class="form-label">Nhà ủ</label>

                    <select name="curing_house_id" id="receivingPlaceSelect" class="form-select custom-select w-100">
                        @foreach ($curing_houses as $item)
                        <option value="{{$item->id}}" data-containing="{{$item->containing}}"
                            data-area={{$item->curing_area->id}}>{{$item->code}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-lg-4">
                    <label class="form-label">Vị trí</label>
                    <select name="location" id="location" required class="form-select w-100">
                        <option value="A1" data-house="NLCVNT1">A1</option>
                        <option value="A2" data-house="NLCVNT1">A2</option>
                        <option value="A3" data-house="NLCVNT1">A3</option>
                        <option value="A4" data-house="NLCVNT1">A4</option>
                        <option value="A5" data-house="NLCVNT1">A5</option>
                        <option value="A6" data-house="NLCVNT1">A6</option>

                        <option value="B1" data-house="NLCVNT2">B1</option>
                        <option value="B2" data-house="NLCVNT2">B2</option>
                        <option value="B3" data-house="NLCVNT2">B3</option>
                        <option value="B4" data-house="NLCVNT2">B4</option>
                        <option value="B5" data-house="NLCVNT2">B5</option>
                        <option value="B6" data-house="NLCVNT2">B6</option>

                        <option value="C1" data-house="NLCVNT3">C1</option>
                        <option value="C2" data-house="NLCVNT3">C2</option>
                        <option value="C3" data-house="NLCVNT3">C3</option>
                        <option value="C4" data-house="NLCVNT3">C4</option>
                        <option value="C5" data-house="NLCVNT3">C5</option>
                        <option value="C6" data-house="NLCVNT3">C6</option>

                        <option value="D1" data-house="NLCVNT6">D1</option>
                        <option value="D2" data-house="NLCVNT6">D2</option>
                        <option value="D3" data-house="NLCVNT6">D3</option>
                        <option value="D4" data-house="NLCVNT6">D4</option>
                        <option value="D5" data-house="NLCVNT6">D5</option>
                        <option value="D6" data-house="NLCVNT6">D6</option>



                        <option value="E1" data-house="NLCVNT4">E1</option>
                        <option value="E2" data-house="NLCVNT4">E2</option>
                        <option value="E3" data-house="NLCVNT4">E3</option>
                        <option value="E4" data-house="NLCVNT4">E4</option>
                        <option value="E5" data-house="NLCVNT4">E5</option>
                        <option value="E6" data-house="NLCVNT4">E6</option>

                        <option value="F1" data-house="NLCVNT5">F1</option>
                        <option value="F2" data-house="NLCVNT5">F2</option>
                        <option value="F3" data-house="NLCVNT5">F3</option>
                        <option value="F4" data-house="NLCVNT5">F4</option>
                        <option value="F5" data-house="NLCVNT5">F5</option>
                        <option value="F6" data-house="NLCVNT5">F6</option>

                        <option value="G1" data-house="NLCVNT7">G1</option>
                        <option value="G2" data-house="NLCVNT7">G2</option>
                        <option value="G3" data-house="NLCVNT7">G3</option>
                        <option value="G4" data-house="NLCVNT7">G4</option>
                        <option value="G5" data-house="NLCVNT7">G5</option>
                        <option value="G6" data-house="NLCVNT7">G6</option>

                        <option value="H1" data-house="NLCVNT8">H1</option>
                        <option value="H2" data-house="NLCVNT8">H2</option>
                        <option value="H3" data-house="NLCVNT8">H3</option>
                        <option value="H4" data-house="NLCVNT8">H4</option>
                        <option value="H5" data-house="NLCVNT8">H5</option>
                        <option value="H6" data-house="NLCVNT8">H6</option>

                        <option value="I1" data-house="NLCVTM">I1</option>
                        <option value="I2" data-house="NLCVTM">I2</option>
                        <option value="I3" data-house="NLCVTM">I3</option>
                        <option value="I4" data-house="NLCVTM">I4</option>
                        <option value="I5" data-house="NLCVTM">I5</option>
                        <option value="I6" data-house="NLCVTM">I6</option>

                        <option value="J1" data-house="NLCVTNSR">J1</option>
                        <option value="J2" data-house="NLCVTNSR">J2</option>
                        <option value="J3" data-house="NLCVTNSR">J3</option>
                        <option value="J4" data-house="NLCVTNSR">J4</option>
                        <option value="J5" data-house="NLCVTNSR">J5</option>
                        <option value="J6" data-house="NLCVTNSR">J6</option>

                    </select>
                </div>

                <div class="mb-3 col-lg-4">
                    <label class="form-label">Ngày cán vắt</label>
                    <input type="date" name="date" id="dateInput" class="form-control">
                </div>

                <div class="mb-3 col-lg-4">
                    <label class="form-label">Ngày tiếp nhận</label>
                    <input type="date" name="date_curing" require class="form-control">
                    {{-- <select name="date_curing" class="form-select custom-select w-100">
                        @foreach ($dates as $item)
                        <option value="{{ \Carbon\Carbon::parse($item->or_time)->format('d/m/Y')}}"
                            data-house="$item->">{{ \Carbon\Carbon::parse($item->or_time)->format('d/m/Y')}}</option>
                        @endforeach
                    </select>  --}}
                </div>

                <div class="mb-3 col-lg-4">
                    <label class="form-label">Trọng lượng quy khô (kg)</label>

                    <input type="number" min="1" name="weight_to_roll" class="form-control" id="weight_to_roll"
                        value="{{$areas[0]->containing ?? ''}}">
                </div>

                <div class="mb-3 col-lg-4">
                    <label class="form-label">Tạp chất loại bỏ</label>
                    <input type="text" name="impurity_removing" class="form-control">
                </div>

                <div class="mb-3 col-lg-4">
                    <label class="form-label">Số lần cán</label>
                    <input type="number" name="timeRoll" required class="form-control" value="2">
                </div>

                <div class="mb-3 col-lg-4">
                    <label class="form-label">Giờ</label>
                    <input type="text" name="time" id="timeInput" class="form-control">
                </div>


                <button type="submit" class="btn btn-primary mt-2" onclick="confirmAction()">Thực hiện</button>
            </div>
        </form>
    </div>
</div>

<script>
    function confirmAction() {
        return confirm("Xác nhận thực hiện");
    }
</script>

@include('partials.errors')



<div class="d-flex justify-content-between align-items-center">
        <div class="filter-section  d-flex align-items-end gap-2 my-2">
            <div class="">
                <label for="dateFilterCanvat" class="" style="font-size: 14px">Ngày cán vắt</label>
                <input type="text" id="dateFilterCanvat" class="form-control" placeholder="Chọn ngày" style="width: 120px" />
            </div>

            <div class="">
                <label for="statusFilterCanvat" style="font-size: 14px">Trạng thái</label>
                <select name="" id="statusFilterCanvat" class="form-select">
                    <option value="0">Chờ gia công</option>
                    <option value="1">Đã gia công</option>
                    <option value="2">Gia công 1 phần</option>
                </select>
                
            </div>

            <div class="">
                <label for="areaFilterCanvat" style="font-size: 14px">Bãi nguyên liệu</label>
                <select name="" id="areaFilterCanvat" class="form-select">
                    <option value=""></option>
                    <option value="1">NLNT1</option>
                    <option value="2">NLNT2</option>
                    <option value="3">NLNT3</option>
                    <option value="4">NLNT4</option>
                    <option value="5">NLNT5</option>
                    <option value="6">NLNT6</option>
                    <option value="7">NLNT7</option>
                    <option value="8">NLNT8</option>
                    <option value="9">TNSR</option>
                    <option value="10">THU MUA</option>
                    
                </select>
                
            </div>

            <button id="btnCanvatFilter" class="btn btn-primary">Lọc</button>
        </div>

        
<div class="filter-date d-flex align-items-end justify-content-end gap-2">

    <form action="{{ route('rolling-delete-items') }}" class="form-delete-items d-none" method="POST"
        onsubmit="return confirmDelete();">
        @csrf
        @method('DELETE')
        <input type="hidden" name="drums" id="selected-drums">
        <button class="btn btn-danger" type="submit">Xóa</button>
    </form>

</div>

    </div>


<table id="canvatTable" class="ui celled table hover" style="width:100%">
    <thead>
        <tr>              
            <th>Ngày cán vắt</th>
            <th>Mã lệnh</th>
            <th>Trạng thái</th>
            <th>Thời gian</th>
            <th>Bãi nguyên liệu</th>
            <th>Nhà ủ</th>
            <th>Khối lượng quy khô (kg)</th>
            <th>Còn lại</th>
            <th>Ngày tiếp nhận</th>
            <th>Số lần cán</th>
        </tr>
    </thead>
    
</table>

    <style>
        #canvatTable th:not(:first-child),
        #canvatTable td:not(:first-child) {
            min-width: 100px;
            max-width: unset;
            text-align: center;
        }
    </style>

@endsection