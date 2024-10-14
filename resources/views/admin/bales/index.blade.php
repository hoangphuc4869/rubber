@extends('layouts.myapp')

@section('content')

     <h4 class="fw-bold py-3 mb-4">Ép bành</h4>
    @include('partials.errors')

     <h5 class="fw-bold py-3 text-warning mb-0">Chọn thùng để ép từ danh sách phía dưới</h5>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Thêm bành</h5>
        </div>
        <div class="card-body">
            
            
            <form action="{{ route('producing.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="mb-3 col-lg-3">
                        <label class="form-label">Số bành/thùng</label>
                        <input type="number" min="1" required class="form-control" name="number_of_bales" value="13" >
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label">Nhiệt độ ép bành (độ C)</label>
                        <input type="number" required class="form-control" name="press_temperature" value="38" >
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Khối lượng bành (kg)</label>
                        <input type="number" required class="form-control" name="weight" value="35" >
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Kiểm tra cắt bành</label>
                        <input type="number" required class="form-control" name="cut_check" value="2" >
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Đánh giá</label>
                        <input type="text" required  class="form-control" name="evaluation" value="Chín đều" >
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Ngày thực hiện</label>
                        <input type="date" name="date" id="dateInput" class="form-control">
                    </div>

                    <div class="mb-3 col-lg-3" style="opacity: 0; pointer-events: none">
                        <label class="form-label" >Giờ</label>
                        <input type="time" name="time" id="timeInput" class="form-control">
                    </div>

                    <input type="hidden" name="drums" id="selected-drums2">
                    
                    <button type="submit" class="btn btn-primary mt-2">Tạo</button>
                </div>
            </form>
        </div>
    </div>


    <div class="filter-date d-flex align-items-end justify-content-between gap-2">

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
                            <option value="">Tất cả</option>
                            <option value="3">3 tấn</option>
                            <option value="6">6 tấn</option>
                        </select>
                    </div>
                </div>
            </div>


        </div>

        {{-- <div class="d-flex align-items-center gap-2">
            <form action="{{ route('reset.drum') }}" class="form-delete-items d-none" method="POST"
                onsubmit="return confirmDelete();">
                @csrf
                @method('DELETE')
                <input type="hidden" name="drums" id="selected-drums">
                <button class="btn btn-danger" type="submit">Xóa</button>
            </form>
        </div> --}}

        
       
    </div>
    
    <table id="datatable" class="ui celled table" style="width:100%">
        <thead>
            <tr>
                <th class="text-center"></th>
                <th>Ngày sấy </th>
                <th>Mã thùng</th>
                <th>Trạng thái</th>
                <th>Tên thùng</th>
                <th>Lò</th>
                <th>Dây chuyền</th>
                <th>Nhiệt độ T1</th>
                <th>Nhiệt độ T2</th>
                <th>Thời gian sấy(phút)</th>
                <th>Thời gian bắt đầu</th>
                <th>Thời gian ra lò</th>
                <th>Đánh giá</th>
                <th>Vệ sinh thùng</th>
                <th>Trưởng ca</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($drums as $index => $drum)
            <tr id="{{$drum->id}}">
                <td></td>
                <td>{{ \Carbon\Carbon::parse($drum->date)->format('d/m/Y')}}</td>
                <td>{{ $drum->code }}</td>
                <td><span class='text-success'>Đã xử lý nhiệt</span></td>
                <td>{{ $drum->name }}</td>
                <td>Lò {{ $drum->oven }}</td>
                <td>{{ $drum->link }}</td>
                <td>{{ $drum->temp }}</td>
                <td>{{ $drum->temp2 }}</td>
                <td>{{ $drum->time_to_dry }}</td>
                <td>{{ \Carbon\Carbon::parse($drum->heated_start)->format('H:i') }}</td>
                <td data-sort="{{ \Carbon\Carbon::parse($drum->heated_end)->format('Y-m-d H:i') }}">{{ \Carbon\Carbon::parse($drum->heated_end)->format('H:i') }}</td>
                <td>{{ $drum->validation }}</td>
                <td>{{ $drum->state }}</td>
                <td>{{ $drum->supervisor }}</td>
                
            </tr>
            @endforeach
        </tbody>
    </table>

   
@endsection