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
                        <input type="number" min="1" required class="form-control" name="number_of_bales" value="27" >
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
                        <input type="number" required class="form-control" name="cut_check" value="7" >
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Đánh giá</label>
                        <input type="text" required  class="form-control" name="evaluation" value="Chín đều" >
                        
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Ngày thực hiện</label>
                        <input type="date" name="date" id="dateInput" class="form-control">
                    </div>

                    <div class="mb-3 col-lg-3">
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
                <th>Tùy chỉnh</th>
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
                <td>{{ \Carbon\Carbon::parse($drum->heated_end)->format('H:i') }}</td>
                <td>{{ $drum->validation }}</td>
                <td>{{ $drum->state }}</td>
                <td>{{ $drum->heating_supervisor }}</td>
                <td>
                    <div class="custom d-flex gap-1">

                        <form action="{{route('producing.destroy', [$drum->id])}}" method="POST" onsubmit="return confirmDelete();">
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

   
@endsection