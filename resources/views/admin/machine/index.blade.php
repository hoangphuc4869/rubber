@extends('layouts.myapp')

@section('content')
<h4 class="fw-bold py-3 mb-4">Gia công cơ</h4>

<h5 class="fw-bold">Sơ đồ nhà ủ</h5>
<div class="row">
    <div class="col-lg-6">
        <div class="grid-areas">
            @foreach ($houses as $item)
            <div class="area-item mac btn btn-{{$item->containing > 0 ? 'warning containing' : 'dark' }}">
                <div class="code">
                    {{$item->code}}
                </div>
                <span class="number">{{ number_format($item->containing, 0, '.', ',') }}</span> kg
            </div>
            @endforeach
        </div>
    </div>
    <div class="col-lg-6">

        <div class="grid-areas" style="direction: rtl;">
            @foreach ($areas as $item)

            <div class="area-item btn btn-{{$item->containing > 0 ? 'success' : 'dark' }}" style="direction: ltr;">
                {{$item->code}} <br>
                {{ number_format($item->containing, 0, '.', ',') }} kg
            </div>

            @endforeach
        </div>

    </div>
</div>


<div class="row">
    <div class="">
        <div class="d-flex gap-3 align-items-center justify-content-end">
            <div class="fs-4 fw-bold">
                Kết quả SX {{$date}}
                <div style="font-size: 14px">Reset lúc

                    @if(Gate::allows('admin'))
                    <input type="time" name="time" value="{{$reset->time}}" id="resetTime" class="form-control"
                        style="width: fit-content; display:inline-block">
                    @else
                    <input type="time" value="{{$reset->time}}" id="resetTime" class="form-control"
                        style="width: fit-content; display:inline-block" disabled>
                    @endif
                    mỗi ngày
                </div>

            </div>

            <script>
            document.getElementById('resetTime').addEventListener('change', function() {
                let selectedTime = this.value;

                fetch('/update-reset-time', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            time: selectedTime
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
            </script>

            <button class="tag3 btn btn-info">
                {{count($drums_per_day_3tan) > 0 ? $drums_per_day_3tan[0]['total_number'] : 0}}
            </button>

            <button class="tag6 btn btn-warning">
                {{count($drums_per_day_6tan) > 0 ? $drums_per_day_6tan[0]['total_number'] : 0}}
            </button>

            <style>
            .tag3,
            .tag6 {
                width: fit-content;
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
                color: #fff;
                font-weight: bold;
                padding: 3px;
                transform: translate(-50%, -50%);
                background: green;


            }
            </style>



        </div>
    </div>
</div>


<div class="d-flex justify-content-end align-items-center mt-3">
    <button class="addBtn  btn my-3 btn-dark">Thêm thùng</button>
</div>

@include('partials.errors')


<div class="card mb-4 form-machine">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Thêm lệnh</h5>
    </div>
    <div class="card-body">

        <form action="{{ route('machining.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="mb-3 col-lg-4">
                    <label class="form-label">Nhà ủ</label>
                    @php
                    $combinedAreas = $houses_containing->merge($areas);
                    @endphp

                    <select name="curing_house" class="form-select custom-select w-100 rolling-code-select"
                        id="curing_house" required>
                        <option value="">Chọn nhà ủ</option>
                        @foreach ($combinedAreas as $item)
                        <option value="{{$item->id}}" data-containing="{{$item->containing}}">{{$item->code}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-lg-4">
                    <label class="form-label">Ngày cán vắt</label>
                    <select name="rolling_code" class="form-select w-100">
                        <option value="">Chọn ngày</option>
                        @foreach ($rollings as $item)
                        <option value="{{$item->id}}" data-house="{{$item->house->code}}">
                            {{\Carbon\Carbon::parse($item->date)->format('d/m/Y')}}
                            ({{\Carbon\Carbon::parse($item->time)->format('H:i') .' '.$item->area->code}})</option>
                        @endforeach
                    </select>
                </div>



                <div class="mb-3 col-lg-4">
                    <label class="form-label">Dây chuyền</label>
                    <select name="link" class="form-select custom-select w-100 rolling-code-select">
                        @if (Gate::allows('admin')  || Gate::allows('3t'))
                            <option value="3">3T/H</option>
                        @endif

                        @if (Gate::allows('admin')  || Gate::allows('6t'))
                            <option value="6">6T/H</option>
                        @endif
                    </select>
                </div>


                <div class="mb-3 col-lg-4">
                    <label class="form-label">Số thùng</label>
                    <input type="number" required name="drums" id="" min="1" class="form-control">
                </div>




                {{-- <div class="mb-3 col-lg-4">
                        <label class="form-label" >Giờ</label>
                        <input type="time" name="time" id="timeInput" class="form-control">
                    </div> --}}

                <div class="mb-3 col-lg-4">
                    <label class="form-label" >Ngày thực hiện</label>
                    <input type="date" name="date" id="dateInput" class="form-control">
                </div>

                <div class="mb-3 col-lg-4">
                    <label class="form-label">Tạp chất loại bỏ</label>
                    <input type="text" name="impurity_removing" required class="form-control"
                        value="Cát, lá cây, dăm cạo">
                </div>

                <div class="mb-3 col-lg-4">
                    <label class="form-label">Bề dày tờ mủ (mm)</label>
                    <input type="text" name="thickness" required class="form-control" value="0.8">
                </div>

                <div class="mb-3 col-lg-4">
                    <label class="form-label">Trạng thái cốm</label>
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

    <div class="d-flex align-items-center gap-2">
        <form action="{{ route('machining-delete-items') }}" class="form-delete-items d-none" method="POST"
            onsubmit="return confirmDelete();">
            @csrf
            @method('DELETE')
            <input type="hidden" name="drums" id="selected-drums">
            <button class="btn btn-danger" type="submit">Xóa</button>
        </form>
        <button class="btn btn-warning form-delete-items d-none editDrumBtn" type="submit">Chỉnh sửa</button>
    </div>

</div>

<table id="datatable" class="ui celled table" style="width:100%">
    <thead>
        <tr>
            <th class="text-center"></th>
            <th>Ngày </th>
            <th>Trạng thái</th>
            <th>Tên thùng</th>
            <th>Giờ gia công hạt</th>
            <th>Ngày cán vắt</th>
            <th>Nhà ủ</th>
            <th>Dây chuyền</th>
            <th>Bề dày tờ mủ</th>
            <th>Trạng thái cốm</th>
            <th>Tạp chất loại bỏ</th>
            <th>Trưởng ca</th>
        </tr>

    </thead>
    <tbody>
        @foreach ($drums as $drum)
        <tr id="{{$drum->id}}">
            <td>
                <input type="checkbox" class="select-row" data-row="{{ $drum->name }}">
            </td>
            <td data-sort="{{ \Carbon\Carbon::parse($drum->date)->format("Y-m-d") }}">{{ \Carbon\Carbon::parse($drum->date)->format("d/m/Y") }}</td>
            <td>
                {!!
                $drum->status === 0
                ? "<span class='text-danger'>Chờ xử lý nhiệt</span>"
                : (
                $drum->status === 2
                ? "<span class='text-warning'>Giao ca</span>"
                : (
                $drum->status === 3
                ? "<span class='text-primary'>Đổi ca</span>"
                : (
                $drum->status === 5
                ? (
                $drum->bale
                ? (
                count($drum->batches) > 0
                ? "<span class='text-info'>Đã đóng lô</span>"
                : "<span class='text-success'>Đã ép kiện</span>"
                )
                : "<span class='text-success'>Đã xử lý nhiệt</span>"
                )
                : "<span class='text-success'>Đang xử lý nhiệt</span>"
                )
                )
                )
                !!}
            </td>

            <td>{{ $drum->name }}</td>
            <td>{{ $drum->heated_start ? \Carbon\Carbon::parse($drum->heated_start)->format("H:i") : ''}}</td>
            <td>{{ $drum->rolling ? \Carbon\Carbon::parse($drum->rolling->date)->format("d/m/Y") : '' }}</td>
            <td>{{ $drum->curing_house ? $drum->curing_house->code : $drum->curing_area->code }}</td>
            <td>{{ $drum->link }}</td>
            <td>{{ $drum->thickness }}</td>
            <td>{{ $drum->trang_thai_com }}</td>
            <td>{{ $drum->impurity_removing }}</td>
            <td>{{$drum->supervisor}}</td>
           
        </tr>
        @endforeach
    </tbody>



</table>


<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark p-2">
                <h5 class="modal-title" id="editModalLabel" style="color: #fff">Chỉnh sửa</h5>
            </div>
            <div class="modal-body">
                <form id="editForm" action="/update-drum-details" method="POST">
                    @csrf
                    <input type="hidden" name="drumsEdit" id="drumsEdit">
                    <div class="row g-3">
                        <div class="col-md-6 col-lg-4 mb-2">
                            <label class="form-label">Nhà ủ</label><br>

                             @php
                                $combinedAreas = $houses_containing->merge($areas);
                            @endphp
            
                            <select name="curing_house" class="form-select w-100"
                                id="curing_house" >
                                <option value="">Chọn nhà ủ</option>
                                @foreach ($houses as $item)
                                    <option value="{{$item->id}}" data-containing="{{$item->containing}}">{{$item->code}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-2">
                            <label class="form-label">Dây chuyền</label>
                            <select name="link" class="form-control" id="editLink">
                                <option value="3">3T/H</option>
                                <option value="6">6T/H</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-lg-4 mb-2">
                            <label class="form-label">Tạp chất loại bỏ</label>
                            <input type="text" name="impurity_removing" id="editImpurity"  class="form-control"
                                placeholder="Nhập tạp chất loại bỏ">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 col-lg-4 mb-2">
                            <label class="form-label">Bề dày tờ mủ (mm)</label>
                            <input type="text" name="thickness" id="editThickness"  class="form-control"
                                placeholder="Nhập bề dày tờ mủ">
                        </div>
                        <div class="col-md-6 col-lg-4 mb-2">
                            <label class="form-label">Trạng thái cốm</label>
                            <input type="text"  name="trang_thai_com" id="editTrangThaiCom" class="form-control"
                                placeholder="Nhập trạng thái cốm">
                        </div>
                        
                    </div>
                    <input type="hidden" id="drumId" name="drum_id">
                    <div class="modal-footer p-0">
                        <button type="submit" class="btn btn-success" id="saveChangesBtn" form="editForm">Lưu thay
                            đổi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.select-row');

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            const currentRow = parseInt(this.getAttribute('data-row'));

            if (this.checked) {
                for (let i = 0; i < checkboxes.length; i++) {
                    const checkboxRow = parseInt(checkboxes[i].getAttribute('data-row'));
                    if (checkboxRow <= currentRow) {
                        checkboxes[i].checked = true;
                    }
                }
            } else {

            }
        });
    });
});
</script>

@endsection