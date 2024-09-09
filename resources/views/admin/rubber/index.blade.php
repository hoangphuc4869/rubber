@extends('layouts.myapp')

@section('content')
    <h4 class="fw-bold py-3 mb-4"> Nguyên liệu</h4>
    <h5 class="fw-bold">Sơ đồ bãi ủ</h5>
    <div class="grid-areas">
        @foreach ($curing_areas as $item)
            <div class="area-item btn btn-{{$item->containing > 0 ? 'warning' : 'dark' }}">
                {{$item->code}} <br>
                {{ number_format($item->containing, 0, '.', ',') }} kg
            </div>
        @endforeach
    </div>
    
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
                        <select id="farmSelect" name="farm_id" class="form-select custom-select">
                            @foreach ($farms as $item)
                                <option value="{{$item->id}}" data-company="{{$item->company ? $item->company->code : ''}}">{{$item->code}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Công ty</label>
                        <input type="text" required  class="form-control" id="farmCompany" value="{{$farms[0]->company ? $farms[0]->company->code : ""}}" disabled >
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Chủng loại mủ</label>
                        <select id="latex_type" name="latex_type" class="form-select custom-select">
                            <option value="Mủ đông chén">Mủ đông chén</option>
                            <option value="Mủ dây">Mủ dây</option>
                        </select>
        
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Tuổi nguyên liệu (ngày)</label>
                        <input type="text" required  class="form-control" name="material_age" value="Bốc chồng nhiều nhất" >
                        
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Khối lượng mủ tươi (kg)</label>
                        <input type="number" min="0" step="0.001" required class="form-control" name="fresh_weight" value="12210" >
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
                        <select id="receivingPlaceSelect" name="receiving_place_id" class="form-select custom-select">
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

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Ngày</label>
                        <input type="date" name="date" id="dateInput" class="form-control">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Giờ</label>
                        <input type="time" name="time" id="timeInput" class="form-control">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Truy xuất</label>
                        <input type="text" name="supervisor" class="form-control">
                    </div>
                    
                    <button type="submit" class="btn btn-primary mt-2">Tạo</button>
                </div>
            </form>
        </div>
    </div>


    <div class="filter-date d-flex align-items-end justify-content-between gap-2">
        <div class="">
            <label for="min" class="form-label mb-0">Lọc ngày</label>
            <input type="text" id="min" name="min" class="form-control" style="width: 200px">
        </div>

        <form action="{{ route('rubber-delete-items') }}" class="form-delete-items d-none" method="POST" onsubmit="return confirmDelete();">
            @csrf
            @method('DELETE')
            <input type="hidden" name="drums" id="selected-drums">
            <button class="btn btn-danger" type="submit">Xóa</button>
        </form>
       
    </div>


    <table id="datatable" class="ui celled table" style="width:100%">
        <thead>
            <tr>
                <th class="text-center"></th>
              
                <th>Ngày</th>
                <th >Thời gian</th>
                <th >Trạng thái</th>
                <th>Số xe</th>
                <th>Nguồn nguyên liệu</th>
                <th>Nơi tiếp nhận</th>
                <th>Công ty</th>
                <th>Chủng loại mủ</th>
                <th>Tuổi nguyên liệu (ngày)</th>
                <th>Khối lượng mủ tươi (kg)</th>
                <th>DRC(%)</th>
                <th>Quy khô (kg)</th>
                <th>Tình trạng nguyên liệu</th>
                <th>Tạp chất</th>
                <th>Phân hạng nguyên liệu</th>
                <th>Giám sát viên</th>
                <th>Tùy chỉnh</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rubbers as $index => $rubber)
            <tr id="{{$rubber->id}}">

                <td></td>
                <td>{{ \Carbon\Carbon::parse($rubber->date)->format('d/m/Y')}}</td>
                <td>{{ \Carbon\Carbon::parse($rubber->time)->format('H:i')}}</td>
                <td>{!! $rubber->status !== 0 ? "<span class='text-success'>Đã xử lý</span>" : "<span class='text-danger'>Chờ xử lý</span>"  !!}</td>
                <td>{{ $rubber->truck->code }}</td>
                <td>{{ $rubber->farm->code }}</td>
                <td>{{ $rubber->curing_area->code }}</td>
                <td>{{ $rubber->farm->company ? $rubber->farm->company->code : '' }}</td>
                <td>{{ $rubber->latex_type }}</td>
                <td>{{ $rubber->material_age }}</td>
                <td>{{ $rubber->fresh_weight }}</td>
                <td>{{ $rubber->drc_percentage }}</td>
                <td>{{ $rubber->dry_weight }}</td>
                <td>{{ $rubber->material_condition }}</td>
                <td>{{ $rubber->impurity_type }}</td>
                <td>{{ $rubber->grade }}</td>
                <td>{{ $rubber->supervisor }}</td>
                <td>
                    <div class="custom d-flex gap-1">
                        <a href="{{route('rubber.edit', [$rubber->id])}}">
                        <button class="editBtn">
                            <svg height="1em" viewBox="0 0 512 512">
                                <path
                                d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"
                                ></path>
                            </svg>
                        </button>
                    </a>

                    <form action="{{route('rubber.destroy', [$rubber->id])}}" method="POST" onsubmit="return confirmDelete();">
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

                    
                        

                    </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>

        </tfoot>
    </table>

 
@endsection