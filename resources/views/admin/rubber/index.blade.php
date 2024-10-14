@extends('layouts.myapp')

@section('content')
    <h4 class="fw-bold py-3 mb-4"> Nguyên liệu</h4>
    <h5 class="fw-bold">Sơ đồ bãi ủ</h5>
    
    <div class="row">
        <div class="col-lg-6">
            <div class="text-center mb-2 fw-bold">Nguyên liệu mủ đông chén</div>
            <div class="grid-areas">
                @foreach ($curing_areas as $item)
                    @if ($item->latex_type == 'Mủ đông chén')
                        <div class="area-item btn btn-{{$item->containing > 0 ? 'warning' : 'dark' }}">
                            {{$item->code}} <br>
                            {{ number_format($item->containing, 0, '.', ',') }} kg
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="col-lg-6">
            <div class="text-center mb-2 fw-bold">Nguyên liệu mủ dây</div>
            <div class="grid-areas" style="direction: rtl;">
                @foreach ($curing_areas as $item)
                    @if ($item->latex_type == 'Mủ dây')
                        <div class="area-item btn btn-{{$item->containing > 0 ? 'warning' : 'dark' }}" style="direction: ltr;">
                            {{$item->code}} <br>
                            {{ number_format($item->containing, 0, '.', ',') }} kg
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    
    <div class="card mb-4 d-none">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Thêm nguyên liệu</h5>
        </div>
        <div class="card-body">            
            <form action="{{ route('rubber.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="mb-3 col-lg-3">
                        <label class="form-label">Biển số xe</label>
                        <select name="truck_id" class="form-select custom-select">
                            @foreach ($trucks as $item)
                                <option  value="{{$item->id}}" >{{$item->code}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Nguồn nguyên liệu</label>
                        <select id="farmSelect" name="farm_id" class="form-select ">
                            @foreach ($farms as $item)
                                <option value="{{$item->id}}" data-company="{{$item->company ? $item->company->code : ''}}">{{$item->code}}</option>
                            @endforeach
                        </select>
                    </div>

                   

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Nơi tiếp nhận</label>
                        <select id="receivingPlaceSelect" name="receiving_place_id" class="form-select">

                            @foreach ($curing_areas as $item)
                                <option  value="{{$item->id}}">{{$item->code}}</option>
                            @endforeach
                        </select> 
                    </div>

                     <div class="mb-3 col-lg-3">
                        <label class="form-label" >Chủng loại mủ</label>
                        <select id="latex_type" name="latex_type" class="form-select">
                            <option value="Mủ đông chén">Mủ đông chén</option>
                            <option value="Mủ dây">Mủ dây</option>
                        </select>
                    </div>  

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                        const farmSelect = document.getElementById('farmSelect');
                        const latexTypeSelect = document.getElementById('latex_type');
                        const receivingPlaceSelect = document.getElementById('receivingPlaceSelect');

                        
                        const mappingMDC = {
                            'NT1': 'NLNT1',
                            'NT2': 'NLNT2',
                            'NT3': 'NLNT3',
                            'NT4': 'NLNT4',
                            'NT5': 'NLNT5',
                            'NT6': 'NLNT6',
                            'NT7': 'NLNT7',
                            'NT8': 'NLNT8',
                            'TNSR': 'NLTNSR',
                            'TM': 'NLTM'
                        };

                        
                        const mappingMD = {
                            'NT4': 'MDBH',
                            'NT5': 'MDBH',
                            'NT7': 'MDBH',
                            'NT8': 'MDBH',
                            'NT1': 'MDCR',
                            'NT2': 'MDCR',
                            'NT3': 'MDCR',
                            'NT6': 'MDCR',
                            'TNSR': 'NLTNSR',
                            'TM': 'NLTMMD',
                        };

                        function updateReceivingPlace() {
                            const selectedFarm = farmSelect.options[farmSelect.selectedIndex].text;
                            const selectedLatexType = latexTypeSelect.value;

                            
                            if (selectedLatexType === "Mủ đông chén" && mappingMDC[selectedFarm]) {
                                const mappedValue = mappingMDC[selectedFarm];

                            
                                for (let i = 0; i < receivingPlaceSelect.options.length; i++) {
                                    if (receivingPlaceSelect.options[i].text === mappedValue) {
                                        receivingPlaceSelect.selectedIndex = i;
                                        break;
                                    }
                                }
                            } 
                            
                            else if (selectedLatexType === "Mủ dây" && mappingMD[selectedFarm]) {
                                const mappedValue = mappingMD[selectedFarm];

                                for (let i = 0; i < receivingPlaceSelect.options.length; i++) {
                                    if (receivingPlaceSelect.options[i].text === mappedValue) {
                                        receivingPlaceSelect.selectedIndex = i;
                                        break;
                                    }
                                }
                            } else {
                                receivingPlaceSelect.selectedIndex = 0;
                            }
                        }

                        farmSelect.addEventListener('change', updateReceivingPlace);
                        latexTypeSelect.addEventListener('change', updateReceivingPlace);
                    });

                    </script>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Công ty</label>
                        <input type="text" required  class="form-control" id="farmCompany" value="{{$farms[0]->company ? $farms[0]->company->code : ""}}" disabled >
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
                        <label class="form-label" >Phân hạng</label>
                        <input type="text" required class="form-control" name="grade" value="CSR10" >
                        
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

    <div class="d-flex justify-content-between">
        <div class="my-3">
            <div class="mb-1"> - Tổng MDC BHCK: <span class="fw-bold fs-4 text-danger">{{$mu_dong_chen_bhck/1000}} tấn</span>  </div>
            <div class="mb-1"> - Tổng MDC CRCK2: <span class="fw-bold fs-4 text-success">{{$mu_dong_chen_crck/1000}} tấn</span>  </div>
            <div class="mb-1"> - Tổng MDC Thu mua: <span class="fw-bold fs-4 text-warning">{{$mu_dong_chen_tm/1000}} tấn</span>  </div>
            <div class="mb-1"> - Tổng MDC TNSR: <span class="fw-bold fs-4">{{$mu_dong_chen_tnsr/1000}} tấn</span>  </div>
        </div>

        <div class="my-3">
            <div class="mb-1"> - Tổng MD BHCK: <span class="fw-bold fs-4 text-danger">{{$mu_day_bhck/1000}} tấn</span>  </div>
            <div class="mb-1"> - Tổng MD CRCK2: <span class="fw-bold fs-4 text-success">{{$mu_day_crck/1000}} tấn</span>  </div>
            <div class="mb-1"> - Tổng MD Thu mua: <span class="fw-bold fs-4 text-warning">{{$mu_day_tm/1000}} tấn</span>  </div>
        </div>
    </div>

    @include('partials.errors')

    <div class="d-flex justify-content-between align-items-center">
        <div class="filter-section  d-flex align-items-end gap-2 my-2">
            <div class="">
                <label for="dateFilterNguyenLieu" class="" style="font-size: 14px">Ngày tiếp nhận</label>
                <input type="text" id="dateFilterNguyenLieu" class="form-control" placeholder="Chọn ngày" style="width: 120px" />
            </div>

            <div class="">
                <label for="statusFilterNguyenLieu" style="font-size: 14px">Trạng thái</label>
                <select name="" id="statusFilterNguyenLieu" class="form-select">
                    <option value="0">Chưa xác nhận</option>
                    <option value="1">Đã xác nhận</option>
                </select>
                
            </div>

            <button id="btnNguyenLieuFilter" class="btn btn-primary">Lọc</button>
        </div>


        <div class="filter-date d-flex align-items-end justify-content-end gap-2">
            <div class=" d-flex gap-1 align-items-center">

                <div class="editDRC d-none">
                    <div class="d-flex align-items-center gap-1">
                        <input type="number" step="0.01" placeholder="Giá trị DRC" name='drc' id="drcInput"  class="form-control" style="width: 150px">
                        <div class="">
                            <button class="btn btn-warning" id="btnDRC">
                                Cập nhật DRC
                            </button>
                        </div>
                    </div>
                    <input type="hidden" name='rubbers' id="rubbersDRC" >
                </div>
            
                <div class="editMat d-none">
                    <a href="/rubber/1/edit" id="editLink">
                        <button class="btn btn-info">
                            Chỉnh sửa
                        </button>
                    </a>
                </div>
                <form action="{{ route('rubber-delete-items') }}" class="form-delete-items d-none" method="POST" onsubmit="return confirmDelete();">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="drums" id="selected-drums">
                    <button class="btn btn-danger" type="submit">Xóa</button>
                </form>
            </div>
        
        </div>

    </div>


    <table id="nguyenlieu" class="ui celled table hover" style="width:100%">
        <thead>
            <tr>              
                <th>Ngày</th>
                <th >Thời gian</th>
                <th >Trạng thái tiếp nhận</th>
                <th>Khối lượng mủ tươi (kg)</th>
                <th>Số xe</th>
                <th>Nguồn nguyên liệu</th>
                <th>Nơi tiếp nhận</th>
                <th>Công ty</th>
                <th>Chủng loại mủ</th>
                <th>Tài xế</th>
                <th>Tuổi nguyên liệu (ngày)</th>
                <th>DRC(%)</th>
                <th>Quy khô (kg)</th>
                <th>Tình trạng nguyên liệu</th>
                <th>Tạp chất</th>
                <th>Phân hạng nguyên liệu</th>
                <th>Ghi chú</th>
            </tr>
        </thead>
        
    </table>

    <style>
        #nguyenlieu th:not(:first-child),
        #nguyenlieu td:not(:first-child) {
            min-width: 100px;
            max-width: unset;
            text-align: center;
        }
    </style>

@endsection