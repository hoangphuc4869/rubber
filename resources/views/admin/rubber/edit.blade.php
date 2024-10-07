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
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-primary">Chỉnh sửa nguyên liệu ngày {{\Carbon\Carbon::parse($rubber->date)->format('d/m/Y')}}</h5>
        </div>
        <div class="card-body">
            @include('partials.errors')
            <style>
                .select2-container--default
                    .select2-selection--single
                    .select2-selection__rendered {
                    color: #d38a19;
                } 

                .form-control, .form-select {
                    color: #d38a19
                }
            </style>

            
            

            
            <form action="{{ route('rubber.update', [$rubber->id]) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="mb-3 col-lg-3">
                        <label class="form-label">Biển số xe</label>
                        <input type="text" class="form-control user-select-none" name="truck_name"  readonly value="{{$rubber->truck_name}}" >                
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Công ty</label>
                        <input type="text" required readonly class="form-control" id="farmCompany" value="{{$rubber->farm->company->code}}" disabled >
                    </div>


                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Nguồn nguyên liệu</label>
                        <input type="hidden" name="farm_id" value="{{$rubber->farm_id}}">
                        <input type="text" class="form-control user-select-none"  readonly value="{{$rubber->farm->code}}">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Nơi tiếp nhận</label>
                        <input type="text" class="form-control user-select-none" readonly value="{{$rubber->curing_area->code}}">
                        <input type="hidden" name="receiving_place_id" value="{{$rubber->receiving_place_id}}">
                    </div>

                    

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Chủng loại mủ</label>
                        <input type="text" class="form-control user-select-none" name="latex_type"  readonly value="{{$rubber->latex_type}}">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Khối lượng mủ tươi (kg)</label>
                        <input type="number" readonly min="0" step="0.001" id="fresh_weight" required class="form-control" name="fresh_weight" value="{{$rubber->fresh_weight}}" >
                    </div>

                     <div class="mb-3 col-lg-3">
                        <label class="form-label" >Ngày</label>
                        <input type="date" name="date" readonly class="form-control" value="{{ \Carbon\Carbon::parse($rubber->or_time)->format('Y-m-d') }}">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Giờ</label>
                        <input type="time" name="time" id="" readonly class="form-control" value="{{\Carbon\Carbon::parse($rubber->or_time)->format('H:i')}}">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Tài xế</label>
                        <input type="text" name="supervisor" class="form-control" readonly value="{{$rubber->tai_xe}}">
                    </div>
                    
                    
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >DRC (%)</label>
                        <input type="number" min="0" step="0.001" id="drc_percentage" required class="form-control" name="drc_percentage" value="{{$rubber->drc_percentage}}" oninput="calculateDryWeight()" >
                        
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Quy khô (kg)</label>
                        <input type="number" min="0" step="0.001" id="dry_weight" required class="form-control" name="dry_weight" value="{{$rubber->dry_weight}}" >
                    </div>

                    <script>
                        function calculateDryWeight() {
                            var freshWeight = parseFloat(document.getElementById('fresh_weight').value) || 0;
                            var drcPercentage = parseFloat(document.getElementById('drc_percentage').value) || 0;

                            var dryWeight = (freshWeight * drcPercentage) / 100;


                            document.getElementById('dry_weight').value = dryWeight.toFixed(2);
                        }

                    </script>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Tuổi nguyên liệu (ngày)</label>
                        <input type="text" required  class="form-control" name="material_age" value="{{$rubber->material_age}}" >
                        
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Tình trạng nguyên liệu (1/2/3/4)</label>
                        <select name="material_condition" class="form-select">
                            <option value="1" {{$rubber->material_condition == 1 ? 'selected' : ''}}>1</option>
                            <option value="2" {{$rubber->material_condition == 2 ? 'selected' : ''}}>2</option>
                            <option value="3" {{$rubber->material_condition == 3 ? 'selected' : ''}}>3</option>
                            <option value="4" {{$rubber->material_condition == 4 ? 'selected' : ''}}>4</option>
                        </select>
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Loại tạp chất bị lẫn</label>
                        <input type="text" required class="form-control" name="impurity_type" value="{{$rubber->impurity_type}}" >
                    </div>

                    

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Phân hạng</label>
                        <input type="text" required class="form-control" name="grade" value="{{$rubber->grade}}" >
                        
                    </div>

                    {{-- <div class="mb-3 col-lg-3">
                        <label class="form-label" >Trạng thái</label>
                        <select name="status" class="form-select">
                            <option value="1">Đã xử lý</option>
                            <option value="0" selected>Chưa xử lý</option>
                            
                        </select>
                    </div> --}}

                   
                    
                        @if (Gate::allows('admin') || Gate::allows('DRC'))
                            <button type="submit" name="save_btn" value="save" class="btn btn-primary my-2">Lưu</button>
                        @endif

                        @if (Gate::allows('admin') || Gate::allows('nguyenlieu'))
                            <button type="submit" name="confirm_btn" value="confirm" class="btn btn-secondary">Xác nhận</button>
                        @endif
                        
                    
                    {{-- <button type="submit" class="btn btn-primary mt-2">Xác nhận</button> --}}
                </div>
            </form>
        </div>
    </div>

    <div class="filter-date d-flex align-items-end justify-content-between gap-2">
        <div class="">
            <label for="min" class="form-label mb-0">Lọc ngày</label>
            <input type="text" id="min" name="min" class="form-control" style="width: 200px">
        </div>


        <div class=" d-flex gap-1 align-items-center">
            

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

    <table id="datatable" class="ui celled table" style="width:100%">
        <thead>
            <tr>
                <th class="text-center"></th>
              
                <th>Ngày</th>
                <th >Thời gian</th>
                <th >Trạng thái tiếp nhận</th>
                <th >Trạng thái xử lý</th>
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
            </tr>
        </thead>
        <tbody>
            @foreach ($rubbers as $index => $rubber)
            <tr id="{{$rubber->id}}">

                <td></td>
                <td>{{ \Carbon\Carbon::parse($rubber->or_time)->format('d/m/Y')}}</td>
                <td>{{ \Carbon\Carbon::parse($rubber->or_time)->format('H:i')}}</td>
                <td>{!! $rubber->input_status !== 0 ? "<span class='text-success'>Đã xác nhận</span>" : "<span class='text-danger'>Chờ xác nhận</span>"  !!}</td>
                 <td>{!! $rubber->status !== 0 ? "<span class='text-success'>Đã xử lý</span>" : "<span class='text-danger'>Chờ xử lý</span>"  !!}</td>
                <td>{{ $rubber->fresh_weight }}</td>
                <td>{{ $rubber->truck ? $rubber->truck->code: $rubber->truck_name }}</td>
                <td>{{ $rubber->farm_name }}</td>
                <td>{{ $rubber->curing_area?->code }}</td>
                <td>{{ $rubber->farm?->company ? $rubber->farm->company->id : '' }}</td>
                <td>{{ $rubber->latex_type }}</td>
                <td>{{ $rubber->tai_xe }}</td>
                <td>{{ $rubber->material_age }}</td>
                <td>{{ $rubber->drc_percentage }}</td>
                <td>{{ $rubber->dry_weight }}</td>
                <td>{{ $rubber->material_condition }}</td>
                <td>{{ $rubber->impurity_type }}</td>
                <td>{{ $rubber->grade }}</td>
                
            </tr>
            @endforeach
        </tbody>
        <tfoot>

        </tfoot>
    </table>

 
@endsection