@extends('layouts.myapp')

@section('content')

@include('partials.errors')


<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Nông trường /</span> Thêm vùng trồng</h4>

<form action="{{ route('plots.store') }}" method="POST" class="p-4 border rounded shadow bg-white">
    @csrf

    <div class="row mb-3">
        <div class="col-md-3">
            <label for="tenlo" class="form-label fw-bold">Tên lô</label>
            <input type="text" id="tenlo" name="tenlo" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label for="farm_id" class="form-label fw-bold">Nông trường</label>
            <select name="farm_id" id="farm_id" class="form-select w-100" required>
                <option value="1">NT1</option>
                <option value="2">NT2</option>
                <option value="3">NT3</option>
                <option value="4">NT4</option>
                <option value="5">NT5</option>
                <option value="6">NT6</option>
                <option value="7">NT7</option>
                <option value="8">NT8</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="dientich" class="form-label fw-bold">Diện tích</label>
            <input type="text" id="dientich" name="dientich" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label for="giong" class="form-label fw-bold">Giống</label>
            <input type="text" id="giong" name="giong" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <label for="hangdat" class="form-label fw-bold">Hạng đất</label>
            <input type="text" id="hangdat" name="hangdat" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label for="namtrong" class="form-label fw-bold">Năm trồng</label>
            <input type="number" id="namtrong" name="namtrong" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label for="namcao" class="form-label fw-bold">Năm cạo</label>
            <input type="number" id="namcao" name="namcao" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label for="tongcaycao" class="form-label fw-bold">Tổng cây cạo</label>
            <input type="number" id="tongcaycao" name="tongcaycao" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <label for="matdocaycao" class="form-label fw-bold">Mật độ cây cạo</label>
            <input type="text" id="matdocaycao" name="matdocaycao" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label for="tong_kmc" class="form-label fw-bold">Tổng KMC</label>
            <input type="number" id="tong_kmc" name="tong_kmc" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label for="to_nt" class="form-label fw-bold">Tổ cạo</label>
            <input type="text" id="to_nt" name="to_nt" class="form-control" required>
        </div>

        <div class="col-md-3">
            <label for="lat_cao" class="form-label fw-bold">Lát cạo</label>
            <input type="text" id="lat_cao" name="lat_cao" class="form-control" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3">
            <label for="toado" class="form-label fw-bold">Tọa độ</label>
            <input type="text" id="toado" name="toado" class="form-control" required>
        </div>

        @for ($year = 2017; $year <= 2023; $year++)
        <div class="col-md-3">
            <label for="ns{{ $year }}" class="form-label fw-bold">NS{{ $year }}</label>
            <input type="number" id="ns{{ $year }}" name="ns{{ $year }}" class="form-control" required>
        </div>
        @endfor
    </div>

    <div class="mb-3">
        <label for="geojson" class="form-label fw-bold">Geojson</label>
        <textarea id="geojson" name="geojson" rows="3" class="form-control"></textarea>
    </div>

    <button type="submit" class="btn btn-primary w-100">Thêm mới</button>
</form>



    
@endsection