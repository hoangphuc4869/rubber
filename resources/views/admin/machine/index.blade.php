@extends('layouts.myapp')

@section('content')
    <h4 class="fw-bold py-3 mb-4">Gia công cơ</h4>

    <h5 class="fw-bold">Sơ đồ nhà ủ</h5>
    <div class="grid-areas">
        @foreach ($houses as $item)
            <div class="area-item btn btn-{{$item->containing > 0 ? 'warning' : 'dark' }}">
                {{$item->code}} <br>
                {{ number_format($item->containing, 0, '.', ',') }} kg
            </div>
        @endforeach
    </div>


    <div class="row">
        <div class="">
            <div class="d-flex gap-3 align-items-center justify-content-end">
                <div class="fs-4 fw-bold">
                    Số thùng {{$today}}
                </div>

                <button class="tag3 btn btn-info">
                     {{count($drums_per_day_3tan) > 0 ? $drums_per_day_3tan[0]['total_number'] : 0}}
                </button>

                <button class="tag6 btn btn-warning">
                    {{count($drums_per_day_6tan) > 0 ? $drums_per_day_6tan[0]['total_number'] : 0}}
                </button>

                <style>
                    .tag3, .tag6{
                        width: 70px;
                        /* height: 50px; */
                        font-size: 30px;
                        position: relative;
                    }

                    .tag3::before {
                        content: '3T/H';
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

                    .tag6::before {
                        content: '6T/H';
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


     
            </div>
        </div>
    </div>



    <div class="card my-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Thêm lệnh</h5>
        </div>
        <div class="card-body">
            @include('partials.errors')
            
            <form action="{{ route('machining.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="mb-3 col-lg-4">
                        <label class="form-label">Nhà ủ</label>
                        <select name="curing_house" class="form-select custom-select w-100 rolling-code-select" id="curing_house">
                            @foreach ($houses as $item)
                                <option  value="{{$item->id}}" data-containing="{{$item->containing}}">{{$item->code}}</option>
                            @endforeach
                        </select>    
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label">Khối lượng gia công (kg)</label>

                        <input type="number" min="1" name="weight_to_roll" class="form-control" id="weight_to_roll" value="{{$houses[0]->containing}}" >  
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label">Dây chuyền</label>
                        <select name="link" class="form-select custom-select w-100 rolling-code-select">
                            <option value="3">3T/H</option>
                            <option value="6">6T/H</option>
                        </select>    
                    </div>


                    <div class="mb-3 col-lg-4">
                        <label class="form-label">Số thùng</label>
                        <input type="number" required name="drums" id="" min="1" class="form-control">           
                    </div>


                     <div class="mb-3 col-lg-4">
                        <label class="form-label" >Ngày thực hiện</label>
                        <input type="date" name="date" id="dateInput" class="form-control">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Giờ</label>
                        <input type="time" name="time" id="timeInput" class="form-control">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Tạp chất loại bỏ</label>
                        <input type="text" name="impurity_removing" required class="form-control" value="Cát, lá cây, dăm cạo">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Bề dày tờ mủ (mm)</label>
                        <input type="text" name="thickness" required class="form-control" value="0.8">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Trạng thái cốm</label>
                        <input type="text" required name="trang_thai_com" class="form-control" value="đồng đều">
                    </div>
                   
                    
                    <button type="submit" class="btn btn-primary mt-2">Thực hiện</button>
                </div>
            </form>
        </div>
    </div>



    <div class="filter-date d-flex align-items-end justify-content-between gap-2">
        <div class="">
            <label for="min" class="form-label mb-0">Lọc ngày</label>
            <input type="text" id="min" name="min" class="form-control" style="width: 200px">
        </div>

        <form action="{{ route('machining-delete-items') }}" class="form-delete-items d-none" method="POST" onsubmit="return confirmDelete();">
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
                <th>Ngày </th>
                {{-- <th>Mã cán vắt</th> --}}
                <th>Mã thùng</th>
                <th>Trạng thái</th>
                <th>Tên thùng</th>
                {{-- <th>Bãi ủ</th> --}}
                <th>Nhà ủ</th>
                <th>Dây chuyền</th>
                <th>Bề dày tờ mủ</th>
                <th>Trạng thái cốm</th>
                <th>Giờ</th>
                <th>Trưởng ca</th>
                <th>Tùy chỉnh</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($drums as $index => $drum)
            <tr id="{{$drum->id}}">
                <td></td>
                <td>{{ \Carbon\Carbon::parse($drum->date)->format('d/m/Y')}}</td>
                {{-- <td>{{ $drum->rolling->code }}</td> --}}
                <td>{{ $drum->code }}</td>
                <td>{!! $drum->status !== 0 ? "<span class='text-success'>Đã xử lý nhiệt</span>" : "<span class='text-danger'>Chờ xử lý nhiệt</span>"  !!}</td>
                <td>{{ $drum->name }}</td>
                {{-- <td></td> --}}
                <td>{{ $drum->curing_house->code }}</td>
                <td>{{ $drum->link }}</td>
                <td>{{ $drum->thickness }}</td>
                <td>{{ $drum->trang_thai_com }}</td>
                <td>{{ \Carbon\Carbon::parse($drum->time)->format('H:i')}}</td>
                <td>{{ $drum->supervisor }}</td>
                <td>
                    <div class="custom d-flex gap-1">

                        <form action="{{route('machining.destroy', [$drum->id])}}" method="POST" onsubmit="return confirmDelete();">
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