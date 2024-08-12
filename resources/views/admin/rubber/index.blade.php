@extends('layouts.myapp')

@section('content')
    <h4 class="fw-bold py-3 mb-4"> Nguyên liệu</h4>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Thêm nguyên liệu</h5>
        </div>
        <div class="card-body">
            @include('partials.errors')
            
            <form action="{{ route('rubber.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="mb-3 col-lg-3">
                        <label class="form-label">Biển số xe</label>
                        <select name="truck_id" class="form-select custom-select">
                            @foreach ($trucks as $item)
                                <option  value="{{$item->id}}">{{$item->code}}</option>
                            @endforeach
                        </select>                
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Nguồn nguyên liệu</label>
                        <select name="farm_id" class="form-select custom-select">
                            @foreach ($farms as $item)
                                <option  value="{{$item->id}}">{{$item->code}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Chủng loại mũ</label>
                        <input type="text" required class="form-control" name="latex_type" value="đông chén" >
        
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Tuổi nguyên liệu (ngày)</label>
                        <input type="text" required  class="form-control" name="material_age" value="Bốc chồng nhiều nhất" >
                        
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Khối lượng mũ tươi (kg)</label>
                        <input type="number" min="0" step="0.001" required class="form-control" name="fresh_weight" value="12.210" >
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >DRC (%)</label>
                        <input type="number" min="0" step="0.01" required class="form-control" name="drc_percentage" value="51.24" >
                        
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Quy khô (kg)</label>
                        <input type="number" min="0" step="0.001" required class="form-control" name="dry_weight" value="6.190" >
                        
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Tình trạng nguyên liệu (1/2/3/4)</label>
                        <select name="material_condition" class="form-select">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4" selected>4</option>
                        </select>
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Loại tạp chất bị lẫn</label>
                        <input type="text" required class="form-control" name="impurity_type" value="lá cây, cát" >
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Nơi tiếp nhận</label>
                        <select name="receiving_place_id" class="form-select custom-select">
                            @foreach ($curing_areas as $item)
                                <option  value="{{$item->id}}">{{$item->code}}</option>
                            @endforeach
                        </select>
                        
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Phân hạng</label>
                        <input type="text" required class="form-control" name="grade" value="CSR10" >
                        
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="1">Đã xử lý</option>
                            <option value="0" selected>Chưa xử lý</option>
                            
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mt-2">Tạo</button>
                </div>
            </form>
        </div>
    </div>

    @foreach ($rubbers as $item)
        {{$item->curing_area->code}}
    @endforeach
 
@endsection