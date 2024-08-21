@extends('layouts.myapp')

@section('content')
    <h4 class="fw-bold py-3 mb-4">Gia công nhiệt</h4>

    

    <div class="card my-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Thêm lệnh</h5>
        </div>
        <div class="card-body">
            @include('partials.errors')
            
            <form action="{{ route('heat.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="mb-3 col-12">
                        <label class="form-label">Chọn ngày</label>
                        
                        <select name="drum_date" class="form-select custom-select w-100 drumdate-select" >
                            @foreach ($drums_per_day as $item)
                                <option value="{{$item['date']}}" data-number="{{$item['total_number']}}">{{\Carbon\Carbon::parse($item['date'])->format('d/m/Y')}} (Số thùng chưa xủ lý: {{$item['total_number']}})</option>
                            @endforeach
                        </select>     
                    </div>

                     <div class="mb-3 col-lg-6">
                        <label class="form-label" >Ngày thực hiện</label>
                        <input type="date" name="date" id="dateInput" class="form-control">
                    </div>

                    <div class="mb-3 col-lg-6">
                        <label class="form-label" >Giờ</label>
                        <input type="time" name="time" id="timeInput" class="form-control">
                    </div>
                   
                    
                    <button type="submit" class="btn btn-primary mt-2">Thực hiện</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        countText = document.querySelector('.drums-count span');
        drumvalue = document.querySelector('.drumdate-select option:first-child');
        if(countText){
            countText.innerHTML = drumvalue ? drumvalue.value : 0 ;
        }
    </script>

    <table id="material" class="ui celled table" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                {{-- <th>Mã cán vắt</th> --}}
                <th>Mã thùng</th>
                <th>Trạng thái</th>
                <th>Tên thùng</th>
                <th>Bãi ủ</th>
                <th>Nhà ủ</th>
                <th>Ngày</th>
                <th>Giờ</th>
                <th>Ngày xử lý</th>
                <th>Giờ xử lý</th>
                <th>Tùy chỉnh</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($drums as $index => $drum)
            <tr id={{$drum->id}}>
                <td>{{ $index + 1 }}</td>
                {{-- <td>{{ $drum->rolling->code }}</td> --}}
                <td>{{ $drum->code }}</td>
                <td>{!! $drum->status !== 0 ? "<span class='text-success'>Đã xử lý nhiệt</span>" : "<span class='text-danger'>Chưa xử lý nhiệt</span>"  !!}</td>
                <td>{{ $drum->name }}</td>
                <td>{{ $drum->rolling->curing_area }}</td>
                <td>{{ $drum->rolling->curing_house }}</td>
                <td>{{ \Carbon\Carbon::parse($drum->date)->format('d/m/Y')}}</td>
                <td>{{ \Carbon\Carbon::parse($drum->time)->format('H:i')}}</td>
                <td>{{ \Carbon\Carbon::parse($drum->heated_date)->format('d/m/Y')}}</td>
                <td>{{ \Carbon\Carbon::parse($drum->heated_time)->format('H:i')}}</td>
                <td>
                    <div class="custom d-flex gap-1">

                        <form action="{{route('heat.destroy', [$drum->id])}}" method="POST" onsubmit="return confirmDelete();">
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