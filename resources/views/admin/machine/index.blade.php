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
                    <select name="rolling_code" class="form-select w-100" id="rollingSelect">
                        <option value="">Chọn ngày</option>
                        @foreach ($rollings as $item)
                            @if ($item->status == 0)
                                <option value="{{$item->id}}" data-maxval="{{$item->remaining ? $item->remaining : $item->weight_to_roll}}" data-house="{{$item->house->code}}">
                                    {{\Carbon\Carbon::parse($item->date)->format('d/m/Y')}}
                                    ( còn lại {{$item->remaining ? $item->remaining : $item->weight_to_roll}}kg {{$item->area->code}})
                                </option>
                            @endif
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




                <div class="mb-3 col-lg-4">
                    <label class="form-label" >Khối lượng cán</label>
                    <input type="number" min="0" name="weight" id="weight" class="form-control">
                </div>

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


<div class="d-flex justify-content-between align-items-center">
    <div class="filter-section  d-flex align-items-end gap-2 my-2">
        <div class="">
            <label for="dateFilterGiaconghat" class="" style="font-size: 14px">Ngày tạo thùng</label>
            <input type="text" id="dateFilterGiaconghat" class="form-control" placeholder="Chọn ngày" style="width: 120px" />
        </div>

        <div class="">
            <label for="statusFilterGiaconghat" style="font-size: 14px">Trạng thái</label>
            <select name="" id="statusFilterGiaconghat" class="form-select">
                <option value="cho">Chờ xử lý nhiệt</option>
                <option value="dang">Đang xử lý nhiệt</option>
                <option value="da">Đã xử lý nhiệt</option>
                <option value="ep">Đã ép kiện</option>
                <option value="lo">Đã đóng lô</option>
                <option value="giao">Chuyển ca</option>
                {{-- <option value="doi">Đổi ca</option> --}}
            </select>
            
        </div>

        <div class="">
            <label for="linkFilterGiaconghat" style="font-size: 14px">Dây chuyền</label>
            <select name="" id="linkFilterGiaconghat" class="form-select" style="width: 100px">
                @if (Gate::allows('admin')  || Gate::allows('3t'))
                    <option value="3">3 tấn</option>
                @endif
                @if (Gate::allows('admin')  || Gate::allows('6t'))
                    <option value="6">6 tấn</option>
                @endif
            </select>
        </div>

        <div class="">
            <label for="areaFilterGiaconghat" style="font-size: 14px">Nhà ủ</label>
            <select name="" id="areaFilterGiaconghat" class="form-select">
                <option value=""></option>
                <option value="1">NLCVNT1</option>
                <option value="2">NLCVNT2</option>
                <option value="3">NLCVNT3</option>
                <option value="4">NLCVNT4</option>
                <option value="5">NLCVNT5</option>
                <option value="6">NLCVNT6</option>
                <option value="7">NLCVNT7</option>
                <option value="8">NLCVNT8</option>
                <option value="9">TNSR</option>
                <option value="10">THU MUA</option>

            </select>

        </div>



        <button id="btnGiaconghatFilter" class="btn btn-primary">Lọc</button>
    </div>
</div>



<table id="giaconghatTable" class="ui celled table" style="width:100%">
    <thead>
        <tr>
            {{-- <th><input type="checkbox" id="selectAllCheckbox"></th> --}}
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
</table>

<style>
    #giaconghatTable th:not(:first-child),
    #giaconghatTable td:not(:first-child) {
        min-width: 100px;
        max-width: unset;
        text-align: center;
    }

</style>


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