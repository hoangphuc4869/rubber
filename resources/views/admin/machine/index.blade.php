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

<div class="card mb-4 form-machine">
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
                    <select name="rolling_code" class="form-select w-100" required>
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

    <form action="{{ route('machining-delete-items') }}" class="form-delete-items d-none" method="POST"
        onsubmit="return confirmDelete();">
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
            <th>Trạng thái</th>
            <th>Tên thùng</th>
            <th>Giờ gia công hạt</th>
            <th>Ngày cán vắt</th>
            <th>Nhà ủ</th>
            <th>Dây chuyền</th>
            <th>Bề dày tờ mủ</th>
            <th>Trạng thái cốm</th>
            <th>Trưởng ca</th>
            <th>Tùy chỉnh</th>
        </tr>

    </thead>
    <tbody>
        @foreach ($drums as $drum)
        <tr id="{{$drum->id}}">
            <td>
                <input type="checkbox" class="select-row" data-row="{{ $drum->name }}">
            </td>
            <td>{{ \Carbon\Carbon::parse($drum->date)->format("d/m/Y") }}</td>
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
            <td>{{ $drum->curing_house->code }}</td>
            <td>{{ $drum->link }}</td>
            <td>{{ $drum->thickness }}</td>
            <td>{{ $drum->trang_thai_com }}</td>
            <td>{{$drum->supervisor}}</td>
            <td>

                <button class="editDrumBtn editBtn" data-id="{{$drum->id}}">
                    <svg height="1em" viewBox="0 0 512 512">
                        <path
                            d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z">
                        </path>
                    </svg>
                </button>

            </td>
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
                    <div class="row g-3">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Dây chuyền</label>
                            <select name="link" class="form-control" id="editLink">
                                <option value="3">3T/H</option>
                                <option value="6">6T/H</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Tạp chất loại bỏ</label>
                            <input type="text" name="impurity_removing" id="editImpurity" required class="form-control"
                                placeholder="Nhập tạp chất loại bỏ">
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Bề dày tờ mủ (mm)</label>
                            <input type="text" name="thickness" id="editThickness" required class="form-control"
                                placeholder="Nhập bề dày tờ mủ">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label class="form-label">Trạng thái cốm</label>
                            <input type="text" required name="trang_thai_com" id="editTrangThaiCom" class="form-control"
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