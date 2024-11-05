@extends('layouts.myapp')

@section('content')


@include('partials.errors')
{{-- <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file">
    <button type="submit">Import</button>
</form> --}}

<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Nông trường /</span> Vùng trồng</h4>

<div class="d-flex justify-content-end align-items-center">
    <a href="{{route('plots.create')}}">
        <button class="btn btn-info">Thêm mới</button>
    </a>
</div>
<div class="row">
        <table id="datalist" class="ui celled table" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tên lô</th>
                    <th>Nông trường</th>                   
                    <th>Diện tích</th>
                    <th>Giống</th>
                    <th>Hạng đất</th>
                    <th>Năm trồng</th>
                    <th>Năm cạo</th>
                    <th>Tổng cây cạo</th>
                    <th>Mật độ cây cạo</th>
                    <th>Tổng KMC</th>
                    <th>Tổ cạo</th>
                    <th>Lát cạo</th>
                  
                    <th>NS2017</th>
                    <th>NS2018</th>
                    <th>NS2019</th>
                    <th>NS2020</th>
                    <th>NS2021</th>
                    <th>NS2022</th>
                    <th>NS2023</th>
                      <th>Tọa độ</th>
                    <th>Geojson</th>
                    <th>Tùy chỉnh</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($plots as $index => $plot)
                <tr>
                    <td>{{$index + 1}}</td>
                    <td>{{$plot->tenlo}}</td>
                    <td>{{$plot->farm->code}}</td>
                    <td>{{$plot->dientich}}</td>
                    <td>{{$plot->giong}}</td>
                    <td>{{$plot->hangdat}}</td>

                    <td>{{$plot->namtrong}}</td>
                    <td>{{$plot->namcao}}</td>
                    
                    <td>{{$plot->tongcaycao}}</td>
                    <td>{{$plot->matdocaycao}}</td>
                    <td>{{$plot->tong_kmc}}</td>
                    <td>{{$plot->to_nt}}</td>
                    <td>{{$plot->lat_cao}}</td>
                    
                    <td>{{$plot->ns2017}}</td>
                    <td>{{$plot->ns2018}}</td>
                    <td>{{$plot->ns2019}}</td>
                    <td>{{$plot->ns2020}}</td>
                    <td>{{$plot->ns2021}}</td>
                    <td>{{$plot->ns2022}}</td>
                    <td>{{$plot->ns2023}}</td>

                    <td>{{$plot->x . ", " . $plot->y}}</td>
                    <td>
                        <button onclick="copyGeojson()" title="Copy" style="background: none; border: none; cursor: pointer;">
                            <i class="fa-solid fa-copy fs-3" style="color: #9c9ca7" ></i>
                        </button>
                    </td>

                    
                    <td>
                       <div class="custom d-flex gap-1">
                         <a href="{{route('plots.edit', [$plot->id])}}">
                            <button class="editBtn">
                                <svg height="1em" viewBox="0 0 512 512">
                                    <path
                                    d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"
                                    ></path>
                                </svg>
                            </button>
                        </a>

                        <form action="{{route('plots.destroy', [$plot->id])}}" method="POST" onsubmit="return confirmDelete();">
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
        </table>

    
    <script>
        function copyGeojson() {
    const geojsonText = `{{$plot->geojson}}`;
    navigator.clipboard.writeText(geojsonText).then(() => {
        alert("Copied to clipboard!");
    }).catch(err => {
        console.error("Failed to copy: ", err);
    });
}
    </script>

</div>
@endsection
