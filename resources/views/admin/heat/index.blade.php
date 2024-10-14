@extends('layouts.myapp')

@section('content')
    <h4 class="fw-bold py-3 mb-4">Gia công nhiệt</h4>

    @include('partials.errors')

    <div class="card my-4" id="newOrderCard" style="display:none">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Thêm lệnh</h5>
        </div>
        <div class="card-body">
            
            <form action="{{ route('heat.store') }}" method="POST">
                @csrf
                <div class="row">

                    <div class="mb-3 col-lg-6">
                        <label class="form-label" >Nhiệt độ T1 (độ C)</label>
                        <input type="number" name="temp" min="0" class="form-control" value="103">
                    </div>

                    <div class="mb-3 col-lg-6">
                        <label class="form-label" >Nhiệt độ T2 (độ C)</label>
                        <input type="number" name="temp2" min="0" class="form-control" value="105">
                    </div>

                     <div class="mb-3 col-lg-6">
                        <label class="form-label">Lò sấy</label> <br>
                        <select name="oven" class="form-select w-100" required>
                            <option value="" selected disabled>Chọn lò</option>
                            <option value="1">Lò 1</option>
                            <option value="2">Lò 2</option>
                        </select>
                    </div>

                    <div class="mb-3 col-lg-6">
                        <label class="form-label" >Thời gian sấy (phút)</label>
                        <input type="number" name="time_to_dry" min="0" step="0.1" class="form-control" required>
                    </div>

                    <div class="mb-3 col-lg-6">
                        <label class="form-label" >Giờ bắt đầu</label>
                        <input type="time" name="time_start" id="timeInput" class="form-control">
                    </div>

                    <div class="mb-3 col-lg-6">
                        <label class="form-label" >Vệ sinh thùng</label>
                        <input type="text" name="state" class="form-control" value="Tốt">
                    </div>

                    <div class="mb-3 col-lg-6">
                        <label class="form-label" >Đánh giá</label>
                        <input type="text" name="validation" class="form-control" value="Nhiệt ổn định">
                    </div>

                    <div class="mb-3 col-lg-6">
                        <label class="form-label" >Ngày thực hiện</label>
                        <input type="date" name="date" id="dateInput" class="form-control">
                    </div>

                    <input type="hidden" name="drums" id="selected-drums">
                    
                    <button type="submit" class="btn btn-primary mt-2">Thực hiện</button>
                </div>
            </form>
        </div>
    </div>


    <div class="d-flex justify-content-end gap-2">
        <div class="">
            <button class="btn btn-info fw-bold" id="nhanCaBtn" style="display: none">NHẬN CA</button>
        </div>
        <div class="">
            <button class="btn btn-warning fw-bold" id="doiCaBtn" style="display: none">NHẬN ĐỔi CA</button>
        </div>
    </div>

<!-- Modal form -->
<div class="modal fade" id="nhanCaModal" tabindex="-1" role="dialog" aria-labelledby="nhanCaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nhanCaLabel">Nhận giao ca</h5>
            </div>
            <div class="modal-body">
                <p id="quantityDisplay" class="text-dark fw-bold"></p>
                <form id="nhanCaForm" method="POST" action="{{route('nhan.ca')}}">
                    @csrf
                    <input type="hidden" name="drum_ids" id="drumIds">
                    {{-- <div class="d-flex align-items-center gap-2">
                        <div class="form-group col-6">
                            <label for="gioRaLo">Giờ ra lò:</label>
                            <input type="time" class="form-control" id="gioRaLo" name="gio_ra_lo" required>
                        </div>
                        <div class="form-group mb-2 col-6">
                            <label for="ngayRaLo">Ngày ra lò:</label>
                            <input type="date" class="form-control" id="ngayRaLo" name="ngay_ra_lo">
                        </div>
                    </div> --}}
                    <div class="d-flex gap-2 justify-content-center align-items-center my-2">
                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                        <button type="button" class="btn btn-secondary closenhanca" data-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="doiCaModal" tabindex="-1" role="dialog" aria-labelledby="doiCaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="doiCaLabel">Nhận Đổi Ca</h5>
                <h6 class="modal-title">Số thùng <span id="num3t"></span></h6>
            </div>
            <div class="modal-body">
                <form id="doiCaForm" method="POST" action="{{route('nhan.ca')}}">
                    @csrf
                    <input type="hidden" name="drum_ids" id="drumIdsDoiCa">
                    {{-- <div class="d-flex align-items-center gap-2">
                        <div class="form-group col-6">
                            <label for="gioDoiCa">Giờ ra lò:</label>
                            <input type="time" class="form-control" id="gioDoiCa" name="gio_ra_lo" required>
                        </div>
                        <div class="form-group mb-2 col-6">
                            <label for="ngayDoiCa">Ngày ra lò:</label>
                            <input type="date" class="form-control" id="ngayDoiCa" name="ngay_ra_lo">
                        </div>
                    </div> --}}
                    <div class="d-flex gap-2 justify-content-center align-items-center my-2">
                        <button type="submit" class="btn btn-primary">Xác nhận</button>
                        <button type="button" class="btn btn-secondary closedoica" data-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



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

                        @if (Gate::allows('admin') || Gate::allows('6t'))
                            <option value="6" selected>6 tấn</option>
                        @endif

                        @if (Gate::allows('admin') || Gate::allows('3t'))
                            <option value="3" selected>3 tấn</option>
                        @endif

                    </select>

                </div>
            </div>
        </div>

        <div class="d-none form-delete-items">
            <button class="btn btn-danger" id="heatProcessingBtn" type="submit">Gia công nhiệt</button>
        </div>
       
    </div>
    
    

    <table id="datatable" class="ui celled table hover" style="width:100%">
        <thead>
            <tr>
                <th class="text-center"></th>
                <th>Ngày </th>
                {{-- <th>Mã cán vắt</th> --}}
                {{-- <th>Mã thùng</th> --}}
                <th>Trạng thái</th>
                <th>Tên thùng</th>
                <th>Thời gian bắt đầu sấy</th>

                {{-- <th>Bãi ủ</th> --}}
                <th>Thời gian ra lò</th>
                <th>Dây chuyền</th>
                <th>Lò</th>
                <th>Nhà ủ</th>
                <th>Bề dày tờ mủ</th>
                <th>Trạng thái cốm</th>
                <th>Trưởng ca</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($drums as $index => $drum)
                <tr id="{{ $drum->id }}" data-link="{{ $drum->link }}" class="{{$drum->status == 2 ? 'thunggiaoca' : ''}} {{$drum->status == 3 ? 'thungdoica' : ''}}">
                    <td>
                        @if($drum->status == 0)
                            <input type="checkbox" class="select-row" data-row="{{ $drum->id }}">
                        @else
                            <input type="checkbox" class="select-row" data-row="{{ $drum->id }}" disabled>
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($drum->date)->format('d/m/Y') }}</td>
                    
                    <td>
                        {!! 
                            $drum->status === 0 
                            ? "<span class='text-danger'>Chờ xử lý nhiệt</span>" 
                            : ($drum->status === 2 
                                ? "<span class='text-warning'>Giao ca</span>" 
                                : ($drum->status === 3 
                                    ? "<span class='text-primary'>Đổi ca</span>" 
                                    : "<span class='text-success'>Đã xử lý nhiệt</span>"
                                )
                            )
                        !!}
                    </td>
                    <td>{{ $drum->name }}</td>
                    <td>{{ $drum->heated_start ? \Carbon\Carbon::parse($drum->heated_start)->format('H:i') : '' }}</td>
                    <td>{{ $drum->heated_end }}</td>
                    <td>{{ $drum->link }}</td>
                    <td>{{ $drum->oven }}</td>
                    <td>{{ $drum->curing_house ? $drum->curing_house->code : $drum->curing_area->code }}</td>

                    <td>{{ $drum->thickness }}</td>
                    <td>{{ $drum->trang_thai_com }}</td>
                    <td>{{ $drum->supervisor }}</td>
                   
                </tr>
            @endforeach
        </tbody>
    </table>


    <style>
        span.select2.select2-container.select2-container--default {
            width: 100% !important;
        }
    </style>

    <h4 class="fw-bold py-3 mb-0 mt-3">Thùng đã xử lý nhiệt</h4>



<div class="d-flex align-items-end  gap-2" 
style="
    position: sticky;
    top: 25px;
    z-index: 1000;
">
    <form action="{{ route('heat-delete-items') }}" class="form-delete-items2 d-none" method="POST" onsubmit="return handleFormSubmit(event);">
        @csrf
        @method('DELETE')
        <input type="hidden" name="drums" id="selected-drums2">
        
        <button class="btn btn-danger" type="submit" name="action" value="delete">Xóa</button>
        <button type="button" class="btn btn-info" onclick="handleAdjustTimeButtonClick();">Điều chỉnh</button>
        <button class="btn btn-success" type="submit" name="action" value="done">Hoàn tất xử lý nhiệt</button>
    </form>

</div>


<div class="modal fade" id="adjustTimeModal" tabindex="-1" aria-labelledby="adjustTimeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adjustTimeModalLabel">Điều chỉnh thời gian</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('adjust-time') }}" method="POST" onsubmit="return handleAdjustTimeSubmit(event);" id="adjust-time-form">
                    @csrf
                    <input type="hidden" name="drums" id="adjust-drums">
                    <input type="hidden" name="line" id="selected-line" value="3">

                    <div class="mb-3 d-flex gap-2">

                        {{-- <div class="flex-grow-1">
                            <label for="adjust_time_start" class="form-label">Giờ sấy:</label>
                            <input type="time" name="adjust_time_start" id="adjust_time_start" class="form-control">
                        </div> --}}

                        <div class="flex-grow-1" style="width: 100px">
                            <label for="adjust_time_start" class="form-label">Thời gian sấy:</label>
                            <input type="number" min="1" step="0.1" name="adjust_time_dry" id="adjust_time_start" class="form-control" >
                        </div>


                        <div class="flex-grow-1">
                            <label for="adjust-time" class="form-label" style="font-size: 12px">Thời gian bắt đầu sấy:</label>
                            <input type="time" name="adjust_time" id="adjust-time" class="form-control">
                        </div>


                        <div class="flex-grow-1 me-2">
                            <label for="adjust-date" class="form-label">Ngày:</label>
                            <input type="date" name="adjust_date" id="adjust-date" class="form-control">
                        </div>
                        
                    </div>

                    <div class="mb-3">
                        <label for="reason" class="form-label">Nguyên nhân:</label>
                        <textarea name="reason" id="reason" class="form-control" rows="3" placeholder="Nhập lý do điều chỉnh"></textarea>
                    </div>

                    {{-- <div class="form-check mb-3">
                        <input type="checkbox" name="change_shift" id="change_shift" class="form-check-input">
                        <label for="change_shift" class="form-check-label">Đổi ca</label>
                    </div> --}}

                    <div class="mb-3 d-flex align-items-center gap-1" style="opacity: 0">
                        <input type="checkbox" checked name="multi" id="multi" onclick="toggleAdjustTimeStart()">
                        <label for="multi" class="form-label mb-0" >Điều chỉnh nhiều thùng</label>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Xác nhận điều chỉnh</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    </div>
                </form>

                <script>
                    function toggleAdjustTimeStart() {
                        const adjustTimeStartInput = document.getElementById('adjust_time_start');
                        const isChecked = document.getElementById('multi').checked;

                        adjustTimeStartInput.disabled = isChecked;

                        if (isChecked) {
                            adjustTimeStartInput.classList.add('disabled-input');
                        } else {
                            adjustTimeStartInput.classList.remove('disabled-input');
                        }
                    }
                </script>

                <style>
                    .form-control:disabled, .form-control[readonly] {
                        background-color: #e3e3e3 !important;
                        cursor: pointer;
                    }
                </style>
            </div>
        </div>
    </div>
</div>


{{-- tg sấy --}}
{{-- <div class="modal fade" id="adjustDryTimeModal" tabindex="-1" aria-labelledby="adjustDryTimeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adjustDryTimeModalLabel">Điều chỉnh thời gian sấy</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('adjust-dry-time') }}" method="POST" onsubmit="return handleAdjustDryTimeSubmit(event);" id="adjust-dry-time-form">
                    @csrf
                    <input type="hidden" name="drums" id="adjust-drums-dry">
                    <input type="hidden" name="line" id="selected-line-dry" value="3">

                    <div class="mb-3 d-flex gap-2">
                        <div class="flex-grow-1" style="width: 100px">
                            <label for="adjust_time_dry" class="form-label">Thời gian sấy (giờ):</label>
                            <input type="number" min="1" name="adjust_time_dry" id="adjust_time_dry" class="form-control" placeholder="Nhập giờ sấy">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">Xác nhận điều chỉnh</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> --}}


    <div class="filter-date d-flex align-items-end justify-content-between gap-2">
        <div class="d-flex gap-3">
            <div class="filter-line d-flex align-items-end justify-content-between gap-2">
                <div class="">
                    <label for="lineFilter2" class="form-label mb-0">Dây chuyền</label>
                    <select id="lineFilter2" class="form-control" style="width: 200px">

                        @if (Gate::allows('admin') || Gate::allows('6t'))
                            <option value="6" selected>6 tấn</option>
                        @endif

                        @if (Gate::allows('admin') || Gate::allows('3t'))
                            <option value="3" selected>3 tấn</option>
                        @endif

                    </select>

                </div>
            </div>
        </div>
    </div>




    <table id="datatable2" class="ui celled table hover" style="width:100%">
        <thead>
            <tr>
                <th class="text-center"></th>
                <th>Ngày sấy </th>
                <th>Trạng thái</th>
                <th>Tên thùng</th>
                <th>Thời gian bắt đầu sấy</th>
                <th>Thời gian sấy(phút)</th>
                <th>Thời gian ra lò</th>
                <th>Ghi chú</th>
                <th>Ngày ra lò</th>
                <th>Nhiệt độ T1</th>
                <th>Nhiệt độ T2</th>
                <th>Lò</th>
                <th>Dây chuyền</th>
                <th>Đánh giá</th>
                <th>Vệ sinh thùng</th>
                <th>Trưởng ca</th>
               
            </tr>
        </thead>
        <tbody>
            @foreach ($drums_handled as $index => $drum)
            <tr id="{{$drum->id}}" data-status="{{$drum->status}}" data-oven="{{$drum->oven}}" data-link="{{$drum->link}}" data-start="{{\Carbon\Carbon::parse($drum->heated_start)->format('H:i')}}" data-date="{{\Carbon\Carbon::parse($drum->heated_date)->format('Y-m-d')}}" data-dry="{{$drum->time_to_dry}}">
                <td></td>
                <td>{{ \Carbon\Carbon::parse($drum->date)->format('d/m/Y')}}</td>
                <td>{!! $drum->status !== 0 ? "<span class='text-success'>Đang xử lý nhiệt</span>" : "<span class='text-danger'>Chờ xử lý nhiệt</span>"  !!}</td>
                <td>{{ $drum->name }}</td>
                <td>{{ \Carbon\Carbon::parse($drum->heated_start)->format('H:i') }}</td>
                <td>{{ $drum->time_to_dry }}</td>
                <td data-sort="{{ $drum->heated_end ? \Carbon\Carbon::parse($drum->heated_end)->format('Y-m-d H:i') : '' }}">{{ $drum->heated_end ? \Carbon\Carbon::parse($drum->heated_end)->format('H:i') : '' }}</td>
                <td><span class="text-danger">{{$drum->note}}</span></td>
                <td>{{ $drum->heated_date ? \Carbon\Carbon::parse($drum->heated_date)->format('d/m/Y') : '' }}</td>
                
                <td>{{ $drum->temp }}</td>
                <td>{{ $drum->temp2 }}</td>
                <td>Lò {{ $drum->oven }}</td>
                
                <td>{{ $drum->link }}</td>
                <td>{{ $drum->validation }}</td>
                <td>{{ $drum->state }}</td>
                <td>{{ $drum->supervisor }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        countText = document.querySelector('.drums-count span');
        drumvalue = document.querySelector('.drumdate-select option:first-child');
        if(countText){
            countText.innerHTML = drumvalue ? drumvalue.value : 0 ; 
        }


        document.getElementById('heatProcessingBtn').addEventListener('click', function() {
            document.getElementById('newOrderCard').style.display = 'block';
        });

        document.addEventListener('click', function(event) {
            if (!newOrderCard.contains(event.target) && !heatProcessingBtn.contains(event.target)) {
                newOrderCard.style.display = 'none';
            }
        });

    </script>

    <div class="d-flex justify-content-between my-5">
        <div class="">
            <button class="btn btn-info switch_within_day" id="giaoca">GIAO CA</button>
        </div>
        <div class="">
            <button class="btn btn-warning switch_another_day" id="doica">ĐỔI CA</button>
        </div>
    </div>


    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Xác nhận</h5>
                </div>
                <div class="modal-body">
                    Bạn muốn giao <span class="so-thung-giao-ca"></span> thùng cuối cho lần sau?
                </div>
                <div class="modal-footer">
                    <form action="{{route('giao-ca')}}" method="POST">
                        @csrf
                        <input type="hidden" name="drums[]" id="drumsInput">
                        <input type="hidden" name="type" id="typeInput">
                        <button type="submit" class="btn btn-info">ĐỒNG Ý</button>
                    </form>
                    <button type="button" class="btn btn-danger close-modal">HỦY</button>
                </div>
            </div>
        </div>
    </div>


<script>
    function handleFormSubmit(event) {
        event.preventDefault(); 

        const form = event.target;
        const selectedDrums = document.getElementById('selected-drums2').value.split(',');

        const action = event.submitter.value;

        
        const actionInput = document.createElement('input');
        actionInput.type = 'hidden';
        actionInput.name = 'action'; 
        actionInput.value = action;

        form.appendChild(actionInput); 

        if (action === 'delete') {
            if (confirm('Bạn có chắc chắn muốn xóa không?')) {
                form.submit(); 
            }
        } else {
            if (confirm('Hoàn tất xử lý nhiệt các thùng này?')) {
                form.submit(); 
            }
        }
    }


    function handleAdjustTimeButtonClick(event) {  
        const selectedDrums = document.getElementById('selected-drums2').value.split(',');  
        
        

        if (selectedDrums.length !== 1) {  
            alert('Vui lòng chỉ chọn một thùng để điều chỉnh thời gian.');  
        } else {  
            const selectedDrumId = selectedDrums[0];  
            const selectedDrumElement = document.querySelector(`tr[id="${selectedDrumId}"]`);

            console.log(selectedDrumElement);
            

            if (selectedDrumElement) {  
 
                const dryTime = selectedDrumElement.getAttribute('data-dry') || '';  
                const date = selectedDrumElement.getAttribute('data-date') || '';  
                const endTime = selectedDrumElement.getAttribute('data-start') || '';  
                const line = selectedDrumElement.getAttribute('data-link') || '';  

                 
                document.getElementById('adjust-drums').value = selectedDrumId;  
                document.getElementById('selected-line').value = line;  
                document.getElementById('adjust_time_start').value = dryTime; 
                document.getElementById('adjust-date').value = date; 
                document.getElementById('adjust-time').value = endTime;   

                
                const adjustTimeModal = new bootstrap.Modal(document.getElementById('adjustTimeModal'));  
                adjustTimeModal.show();  
            } else {  
                alert('Không tìm thấy thùng tương ứng.');  
            }  
        }  
    }

    function handleAdjustTimeSubmit(event) {
        return true; 
    }
</script>

    
@endsection