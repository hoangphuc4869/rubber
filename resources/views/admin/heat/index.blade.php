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

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Nhiệt độ T1 (độ C)</label>
                        <input type="number" name="temp" min="0" class="form-control" value="103">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Nhiệt độ T2 (độ C)</label>
                        <input type="number" name="temp2" min="0" class="form-control" value="105">
                    </div>

                     <div class="mb-3 col-lg-4">
                        <label class="form-label">Lò sấy</label> <br>
                        <select name="oven" class="form-select w-100" required>
                            <option value="" selected disabled>Chọn lò</option>

                            @if (Gate::allows('admin')  || Gate::allows('6t'))
                               <option value="1">Lò 1</option>
                                <option value="2">Lò 2</option>
                            @endif

                            @if (Gate::allows('admin')  || Gate::allows('3t'))
                                <option value="3">Lò 3 tấn</option>
                            @endif
                            
                        </select>
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Thời gian sấy (phút)</label>
                        <input type="number" name="time_to_dry" min="0" step="0.1" class="form-control" required>
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Giờ bắt đầu</label>
                        <input type="time" name="time_start" id="timeInput" class="form-control">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Vệ sinh thùng</label>
                        <input type="text" name="state" class="form-control" value="Tốt">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Đánh giá</label>
                        <input type="text" name="validation" class="form-control" value="Nhiệt ổn định">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Ngày thực hiện</label>
                        <input type="date" name="date" id="dateInput" class="form-control">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Số thùng rỗng (nếu có)</label>
                        <input type="number" min="1" name="padding_drum"  class="form-control">
                    </div>

                    <input type="hidden" name="drums" id="selected-drums">
                    
                    <button type="submit" class="btn btn-primary mt-2">Thực hiện</button>
                </div>
            </form>
        </div>
    </div>


    {{-- <div class="d-flex justify-content-end gap-2">
        <div class="">
            <button class="btn btn-info fw-bold" id="nhanCaBtn" >NHẬN CA</button>
        </div>
        <div class="">
            <button class="btn btn-warning fw-bold" id="doiCaBtn" >NHẬN ĐỔi CA</button>
        </div>
    </div> --}}

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
                    <input type="hidden" name="drum_ids" id="drumIdsNhanCa">

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

        <div class="d-flex justify-content-between align-items-center">
            <div class="filter-section  d-flex align-items-end gap-2 my-2">
                <div class="">
                    <label for="dateFilterNhiet" class="" style="font-size: 14px">Ngày tạo thùng</label>
                    <input type="text" id="dateFilterNhiet" class="form-control" placeholder="Chọn ngày" style="width: 120px" />
                </div>

                <div class="">
                    <label for="statusFilterNhiet" style="font-size: 14px">Trạng thái</label>
                    <select name="" id="statusFilterNhiet" class="form-select">
                        <option value="cho">Chờ xử lý nhiệt</option>
                        <option value="giao">Chuyển ca</option>
                        {{-- <option value="doi">Đổi ca</option> --}}
                    </select>
                    
                </div>
                

                <div class="">
                    <label for="linkFilterNhiet" style="font-size: 14px">Dây chuyền</label>
                    <select name="" id="linkFilterNhiet" class="form-select" style="width: 100px">
                        @if (Gate::allows('admin')  || Gate::allows('6t'))
                            <option value="6">6 tấn</option>
                        @endif
                        @if (Gate::allows('admin')  || Gate::allows('3t'))
                            <option value="3">3 tấn</option>
                        @endif
                        
                    </select>
                </div>

                <button id="btnNhietFilter" class="btn btn-dark">Lọc</button>
            </div>
        </div>
    </div>


    <div class="heat-wrapper position-relative my-3">

      
        <div class="button-group">
            <div class="d-flex align-items-center gap-2">
                <button id="selectAllBtn" class="btn btn-primary">Tất Cả</button>
                <button id="selectOddBtn" class="btn btn-warning">Chẵn</button>
                <button id="selectEvenBtn" class="btn btn-info">Lẻ</button>
                <div>
                    <span id="selectedCount" class="text-dark fw-bold">Đã chọn: 0</span>
                </div>
                <div class="d-none form-heat-items">
                    <button class="btn btn-danger" id="heatProcessingBtn" type="submit">Gia công nhiệt</button>
                </div>

                {{-- <div class="d-none form-heat-items">
                    <button class="btn btn-success" id="ncaBtn" type="submit">Nhận ca</button>
                </div> --}}
            </div>
        </div>
           
      

        <table id="giacongnhietTable" class="ui celled table" style="width:100%">
            <thead>
                <tr>
                    <th>Ngày </th>
                    <th>Trạng thái</th>
                    <th>Tên thùng</th>
                    <th>Dây chuyền</th>
                    <th>Nhà ủ</th>
                    <th>Bề dày tờ mủ</th>
                    <th>Trạng thái cốm</th>
                    <th>Trưởng ca</th>
                </tr>
            </thead>
        </table>

    </div>

    <style>
        .button-group {
            position: absolute;
            top: 0;
            left: 0;
            z-index: 10;
            width: 80%;
        }

    </style>




<style>

    #giacongnhietTable th,
    #giacongnhietTable td {
        /* min-width: 80px; */
        max-width: unset;
        text-align: center;
    }

</style>
    


    <style>
        span.select2.select2-container.select2-container--default {
            width: 100% !important;
        }
    </style>

    <h4 class="fw-bold py-3 mb-0 mt-3">Thùng đang xử lý nhiệt</h4>


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



    <div class="filter-date d-flex align-items-end justify-content-between gap-2">

        <div class="d-flex justify-content-between align-items-center">
            <div class="filter-section  d-flex align-items-end gap-2 my-2">
                <div class="">
                    <label for="dateFilterNhiet2" class="" style="font-size: 14px">Ngày sấy</label>
                    <input type="text" id="dateFilterNhiet2" class="form-control" placeholder="Chọn ngày" style="width: 120px" />
                </div>

                <div class="">
                    <label for="linkFilterNhiet2" style="font-size: 14px">Dây chuyền</label>
                    <select name="" id="linkFilterNhiet2" class="form-select" style="width: 100px">
                        @if (Gate::allows('admin')  || Gate::allows('6t'))
                            <option value="6">6 tấn</option>
                        @endif
                        @if (Gate::allows('admin')  || Gate::allows('3t'))
                            <option value="3">3 tấn</option>
                        @endif
                    </select>
                </div>

                <button id="btnNhietFilter2" class="btn btn-primary">Lọc</button>
            </div>
        </div>
    </div>



    <div class="heat-wrapper position-relative my-3">

        <div class="button-group d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-2">
                <button id="selectAllBtn2" class="btn btn-primary">Tất Cả</button>
                <button class="btn btn-dark switch_within_day" id="giaoca">Chuyển ca</button>
                {{-- <button class="btn btn-warning switch_another_day" id="doica">Đổi ca</button> --}}
                

                <div class="form-group">
                    <input type="number" id="numberOfDrums" class="form-control" min="1" required placeholder="Nhập số thùng để giao">
                </div>

                <div>
                    <span id="selectedCount2" class="text-dark fw-bold">Đã chọn: 0</span>
                </div>
            </div>

            <div class="d-flex align-items-end  gap-2" style="
            ">
                <form action="{{ route('heat-delete-items') }}" class="form-delete-items2 d-none" method="POST" onsubmit="return handleFormSubmit(event);">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="drums" id="selected-drums2">

                    <input type="hidden" name="link" id="doneLink" >
                    
                    <button class="btn btn-danger" type="submit" name="action" value="delete">Xóa</button>
                    <button type="button" class="btn btn-info" onclick="handleAdjustTimeButtonClick();">Điều chỉnh</button>
                    <button class="btn btn-success" type="submit" name="action" value="done">Hoàn tất xử lý nhiệt</button>
                </form>

            </div>
        </div>
        
    

        <table id="giacongnhietTable2" class="ui celled table" style="width:100%">
            <thead>
                <tr>
                    <th>Ngày sấy </th>
                    <th>Trạng thái</th>
                    <th>Tên thùng</th>
                    <th>Thời gian bắt đầu sấy</th>
                    <th>Thời gian sấy(phút)</th>
                    <th>Thời gian ra lò</th>
                    <th>Ngày ra lò</th>
                    <th>Ghi chú</th>
                    <th>Nhiệt độ T1</th>
                    <th>Nhiệt độ T2</th>
                    <th>Lò</th>
                    <th>Dây chuyền</th>
                    <th>Đánh giá</th>
                    <th>Vệ sinh thùng</th>
                    <th>Trưởng ca</th>
                </tr>
            </thead>
        </table>
    </div>

    <style>
        #giacongnhietTable2 th,
        #giacongnhietTable2 td {
            min-width: 100px;
            max-width: unset;
            text-align: center;
        }

    </style>


    <script>
        countText = document.querySelector('.drums-count span');
        drumvalue = document.querySelector('.drumdate-select option:first-child');
        if(countText){
            countText.innerHTML = drumvalue ? drumvalue.value : 0 ; 
        }


        document.getElementById('heatProcessingBtn').addEventListener('click', function() {
            document.getElementById('newOrderCard').style.display = 'block';
        });

        // document.addEventListener('click', function(event) {
        //     if (!newOrderCard.contains(event.target) && !heatProcessingBtn.contains(event.target)) {
        //         newOrderCard.style.display = 'none';
        //     }
        // });

    </script>

    {{-- <div class="d-flex justify-content-between my-5">
        <div class="">
            <button class="btn btn-info switch_within_day" id="giaoca">GIAO CA</button>
        </div>
        <div class="">
            <button class="btn btn-warning switch_another_day" id="doica">ĐỔI CA</button>
        </div>
    </div> --}}


    {{-- <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Xác nhận</h5>
                </div>
                <div class="modal-body">
                    <label for="numberOfDrums">Nhập số thùng muốn giao:</label>
                    <input type="number" id="numberOfDrums" class="form-control" min="1" required>
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
    </div> --}}




<!-- Modal xác nhận -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Xác nhận</h5>
            </div>
            <div class="modal-body">
                Bạn có muốn giao <span class="so-thung-giao-ca"></span> thùng không?
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
                const rawDate = selectedDrumElement.getAttribute('data-date') || '';  
                const endTime = selectedDrumElement.getAttribute('data-start') || '';  
                const line = selectedDrumElement.getAttribute('data-link') || '';  

                // Function to convert date from DD/MM/YYYY to YYYY-MM-DD
                function convertDateFormat(dateStr) {
                    const [day, month, year] = dateStr.split('/');
                    return `${year}-${month}-${day}`;
                }

                const formattedDate = rawDate ? convertDateFormat(rawDate) : '';

                // Update the form fields
                document.getElementById('adjust-drums').value = selectedDrumId;
                document.getElementById('selected-line').value = line;
                document.getElementById('adjust_time_start').value = dryTime; 
                document.getElementById('adjust-date').value = formattedDate;  
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