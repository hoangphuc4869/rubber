@extends('layouts.myapp')

@section('content')

@include('partials.errors')


<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Nông trường /</span> Chỉnh sủa vùng trồng</h4>

<form action="{{ route('plots.update', $plot->id) }}" method="POST" class="p-4 border rounded shadow bg-white">
    @csrf
    @method('PUT')

    <div class="row mb-3">
        <div class="col-md-3">
            <label for="tenlo" class="form-label fw-bold">Tên lô</label>
            <input type="text" id="tenlo" name="tenlo" class="form-control" value="{{ $plot->tenlo }}" required>
        </div>

        <div class="col-md-3">
            <label for="farm_id" class="form-label fw-bold">Nông trường</label>
            <select name="farm_id" id="farm_id"  class="form-select w-100">
                <option value="1" {{$plot->farm_id == 1 ? 'selected' : ''}}>NT1</option>
                <option value="2" {{$plot->farm_id == 2 ? 'selected' : ''}}>NT2</option>
                <option value="3" {{$plot->farm_id == 3 ? 'selected' : ''}}>NT3</option>
                <option value="4" {{$plot->farm_id == 4 ? 'selected' : ''}}>NT4</option>
                <option value="5" {{$plot->farm_id == 5 ? 'selected' : ''}}>NT5</option>
                <option value="6" {{$plot->farm_id == 6 ? 'selected' : ''}}>NT6</option>
                <option value="7" {{$plot->farm_id == 7 ? 'selected' : ''}}>NT7</option>
                <option value="8" {{$plot->farm_id == 8 ? 'selected' : ''}}>NT8</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="dientich" class="form-label fw-bold">Diện tích</label>
            <input type="text" id="dientich" name="dientich" class="form-control" value="{{ $plot->dientich }}" required>
        </div>

        <div class="col-md-3">
            <label for="giong" class="form-label fw-bold">Giống</label>
            <input type="text" id="giong" name="giong" class="form-control" value="{{ $plot->giong }}" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <label for="hangdat" class="form-label fw-bold">Hạng đất</label>
            <input type="text" id="hangdat" name="hangdat" class="form-control" value="{{ $plot->hangdat }}" required>
        </div>

        <div class="col-md-3">
            <label for="namtrong" class="form-label fw-bold">Năm trồng</label>
            <input type="number" id="namtrong" name="namtrong" class="form-control" value="{{ $plot->namtrong }}" required>
        </div>

        <div class="col-md-3">
            <label for="namcao" class="form-label fw-bold">Năm cạo</label>
            <input type="number" id="namcao" name="namcao" class="form-control" value="{{ $plot->namcao }}" required>
        </div>

        <div class="col-md-3">
            <label for="tongcaycao" class="form-label fw-bold">Tổng cây cạo</label>
            <input type="number" id="tongcaycao" name="tongcaycao" class="form-control" value="{{ $plot->tongcaycao }}" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <label for="matdocaycao" class="form-label fw-bold">Mật độ cây cạo</label>
            <input type="text" id="matdocaycao" name="matdocaycao" class="form-control" value="{{ $plot->matdocaycao }}" required>
        </div>

        <div class="col-md-3">
            <label for="tong_kmc" class="form-label fw-bold">Tổng KMC</label>
            <input type="number" id="tong_kmc" name="tong_kmc" class="form-control" value="{{ $plot->tong_kmc }}" required>
        </div>

        <div class="col-md-3">
            <label for="to_nt" class="form-label fw-bold">Tổ cạo</label>
            <input type="text" id="to_nt" name="to_nt" class="form-control" value="{{ $plot->to_nt }}" required>
        </div>

        <div class="col-md-3">
            <label for="lat_cao" class="form-label fw-bold">Lát cạo</label>
            <input type="text" id="lat_cao" name="lat_cao" class="form-control" value="{{ $plot->lat_cao }}" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <label for="toado" class="form-label fw-bold">Tọa độ</label>
            <input type="text" id="toado" name="toado" class="form-control" value="{{ $plot->x . ', ' . $plot->y }}" required>
        </div>

        @for ($year = 2017; $year <= 2023; $year++)
        <div class="col-md-3">
            <label for="ns{{ $year }}" class="form-label fw-bold">NS{{ $year }}</label>
            <input type="number" id="ns{{ $year }}" name="ns{{ $year }}" class="form-control" value="{{ $plot->{'ns' . $year} }}" required>
        </div>
        @endfor
    </div>

    <div class="mb-3">
        <label for="geojson" class="form-label fw-bold">Geojson</label>
        <textarea id="geojson" name="geojson" rows="3" class="form-control">{{ $plot->geojson }}</textarea>
    </div>

    <button type="submit" class="btn btn-primary w-100">Cập nhật</button>
</form>


    
@endsection