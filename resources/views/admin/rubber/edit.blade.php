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
            <h5 class="mb-0 text-primary">Chỉnh sửa nguyên liệu ngày {{\Carbon\Carbon::parse($rubber->time_ve)->format('d/m/Y')}}</h5>
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
                        <input type="date" name="date" readonly class="form-control" value="{{ \Carbon\Carbon::parse($rubber->time_ve)->format('Y-m-d') }}">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Giờ</label>
                        <input type="text" name="time" id="timeInput2" readonly class="form-control pe-none" value="{{\Carbon\Carbon::parse($rubber->time_ve)->format('H:i')}}">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Tài xế</label>
                        <input type="text" name="supervisor" class="form-control" readonly value="{{$rubber->tai_xe}}">
                    </div>
                    
                    
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >DRC (%)</label>
                        <input type="number" {{$rubber->input_status == 1 ? 'readonly' : ''}} min="0" step="0.001" id="drc_percentage" required class="form-control" name="drc_percentage" value="{{$rubber->drc_percentage}}" oninput="calculateDryWeight()" >
                        
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Quy khô (kg)</label>
                        <input type="number" {{$rubber->input_status == 1 ? 'readonly' : ''}} min="0" step="0.001" id="dry_weight" required class="form-control" name="dry_weight" value="{{$rubber->dry_weight}}" >
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
                        <input type="text" required {{$rubber->input_status == 1 ? 'readonly' : ''}}  class="form-control" name="material_age" value="{{$rubber->material_age}}" >
                        
                    </div>
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Tình trạng nguyên liệu (1/2/3/4)</label>
                        <select name="material_condition" {{$rubber->input_status == 1 ? 'disabled' : ''}} class="form-select">
                            <option value="1" {{$rubber->material_condition == 1 ? 'selected' : ''}}>1</option>
                            <option value="2" {{$rubber->material_condition == 2 ? 'selected' : ''}}>2</option>
                            <option value="3" {{$rubber->material_condition == 3 ? 'selected' : ''}}>3</option>
                            <option value="4" {{$rubber->material_condition == 4 ? 'selected' : ''}}>4</option>
                        </select>
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Loại tạp chất bị lẫn</label>
                        <input type="text" required {{$rubber->input_status == 1 ? 'readonly' : ''}} class="form-control" name="impurity_type" value="{{$rubber->impurity_type}}" >
                    </div>

                    

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Phân hạng</label>
                        <input type="text" required {{$rubber->input_status == 1 ? 'readonly' : ''}} class="form-control" name="grade" value="{{$rubber->grade}}" >
                        
                    </div>

                    @if ((Gate::allows('admin') || Gate::allows('nguyenlieu')))

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Vị trí</label>
                        <select name="location" {{$rubber->input_status == 1 ? 'disabled' : ''}} class="form-select">
                              <option value="">Chọn vị trí</option>
                                <option value="A" {{$rubber->location == "A" ? 'selected' : ''}}>A-NT1</option>
                                <option value="B" {{$rubber->location == "B" ? 'selected' : ''}}>B-NT2</option>
                                <option value="C" {{$rubber->location == "C" ? 'selected' : ''}}>C-NT3</option>
                                <option value="D" {{$rubber->location == "D" ? 'selected' : ''}}>D-NT6</option>
                                <option value="E" {{$rubber->location == "E" ? 'selected' : ''}}>E-NT4</option>
                                <option value="F" {{$rubber->location == "F" ? 'selected' : ''}}>F-NT5</option>
                                <option value="G" {{$rubber->location == "G" ? 'selected' : ''}}>G-NT7</option>
                                <option value="H" {{$rubber->location == "H" ? 'selected' : ''}}>H-NT8</option>
                                <option value="I" {{$rubber->location == "I" ? 'selected' : ''}}>I-TM</option>
                                <option value="J" {{$rubber->location == "J" ? 'selected' : ''}}>J-TNSR</option>
                                <option value="AD" {{$rubber->location == "AD" ? 'selected' : ''}}>AD-MDCR</option>
                                <option value="EH" {{$rubber->location == "EH" ? 'selected' : ''}}>EH-MDBH</option>
                                <option value="II" {{$rubber->location == "II" ? 'selected' : ''}}>II-MDTM</option>
                            </select>
                    </div>

                    @endif


                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Ghi chú</label>
                        <input type="text" class="form-control" {{$rubber->input_status == 1 ? 'readonly' : ''}} name="note" value="{{$rubber->note}}" >
                    </div>


                    @if (in_array($rubber->farm_id, [1, 2, 3, 4, 5, 6, 7, 8]))
                        <div class="mb-3">
                            {{-- {{$rubber->plots}} --}}
                            <label class="form-label" >Vùng trồng</label>
                            <input type="hidden" name="farm_id_with_plots" id="farm_id_with_plots" value="{{$rubber->farm_id}}">
                            <input type="hidden" name="rubber_id" id="rubber_id" value="{{$rubber->id}}">

                            
              
                            <div id="input-container">
                               @foreach ($groupedPlots as $group)
                                    <div class="d-flex align-items-end gap-2 mb-2 input-section">
                                        <div class="">
                                            <span>Lát cạo</span>
                                            <input type="text" readonly class="form-control" style="width: 100px" value="{{ $group->lat_cao }}" />
                                        </div>

                                        <div class="">
                                            <span>Tổ</span>
                                            <input type="number" readonly class="form-control" style="width: 100px" value="{{ $group->to_nt }}" />

                                        </div>


                                        <div class="result d-flex gap-2 align-items-center">
                                            @foreach (explode(',', $group->plot_ids) as $plotId)
                                            @php
                                                $tenlo = App\Models\Plot::find($plotId)->tenlo;
                                            @endphp
                                                <button class="btn btn-dark text-nowrap" style="font-size: 12px">Lô {{ $tenlo }}</button>
                                            @endforeach
                                            
                                        </div>
                                        
                                        <button type="button" class="btn btn-danger remove-btn" data-ids="{{ $group->plot_ids }}" data-rubber="{{$rubber->id}}">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                @endforeach

                            </div>
                            <button type="button" class="btn btn-success" id="add-btn">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                            {{-- <button type="button" class="btn btn-success" id="submit-btn">Cập nhật</button> --}}
                        </div>
                    @endif

                
                         @if ((Gate::allows('admin') || Gate::allows('DRC')) && $rubber->input_status != 1)
                            <button type="submit" name="save_btn" value="save" class="btn btn-primary" onclick="return confirmActionWeighing()">Trạm cân xác nhận</button>
                        @endif

                        @if ((Gate::allows('admin') || Gate::allows('nguyenlieu')) && $rubber->input_status != 1)
                            <button type="submit" name="confirm_btn" value="confirm" class="btn btn-dark my-2" onclick="return confirmWarehouseKeeper()">Thủ kho xác nhận</button>
                        @endif

                        @if ((Gate::allows('admin') || Gate::allows('nguyenlieu')) && $rubber->input_status != 1)
                            <button type="submit" name="deny_btn" value="deny" class="btn btn-danger" onclick="return confirmDeny()">Thông tin sai</button>
                        @endif
                        
                    
                    {{-- <button type="submit" class="btn btn-primary mt-2">Xác nhận</button> --}}
                </div>
            </form>
        </div>
    </div>

    <script>
        function confirmActionWeighing(){
            confirm('Cập nhật các thông tin trên và chờ thủ kho xác nhận?')
        }
        function confirmWarehouseKeeper(){
            return confirm('Xác nhận các thông tin trên là đúng và cập nhật bãi nguyên liệu? \n Sau khi cập nhật sẽ không thể điều chỉnh.')
        }
        function confirmDeny(){
            return confirm('Xác nhận thông tin không chính xác và yêu cầu cập nhật lại?')
        }
    </script>


    <script>
        document.getElementById('add-btn').addEventListener('click', function () {
            let newInput = `
            <div class="d-flex align-items-center gap-2 mb-2 input-section">
                <input type="text" name="input_name[]" class="form-control" placeholder="Lát cạo" style="width: 100px" />
                <input type="number" name="input_name[]" class="form-control" placeholder="Tổ" style="width: 100px"/>
                <div class="result d-flex gap-2 align-items-center"></div>
                <button type="button" class="btn btn-danger remove-btn">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>`;
            document.getElementById('input-container').insertAdjacentHTML('beforeend', newInput);
        });

        // Use event delegation to handle clicks on the remove button
        document.getElementById('input-container').addEventListener('click', function (event) {
            if (event.target.closest('.remove-btn')) {
                const removeButton = event.target.closest('.remove-btn');
                const plotId = removeButton.dataset.ids; 
                const rubberId = removeButton.dataset.rubber; 

                console.log(rubberId, plotId);
                
                if (confirm('Xác nhận xóa')) {
                    fetch('/remove-plots', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                        },
                        body: JSON.stringify({
                            plot_id: plotId,
                            rubber_id: rubberId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {

                        if (data.success) {
                            removeButton.closest('.input-section').remove(); 
                            // alert('Xóa thành công');
                        } else {
                            removeButton.closest('.input-section').remove(); 

                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            }
        });

       
        document.getElementById('input-container').addEventListener('input', function (event) {
            const inputGroup = event.target.closest('.input-section');
            if (!inputGroup) return;

            const to_ntInput = inputGroup.querySelector('input[placeholder="Tổ"]');
            const lat_caoInput = inputGroup.querySelector('input[placeholder="Lát cạo"]');
            const to_nt = to_ntInput.value;
            const lat_cao = lat_caoInput.value;
            const farm = document.querySelector('#farm_id_with_plots').value;
            const rubber_id = document.querySelector('#rubber_id').value;

            if (to_nt && lat_cao) {
                fetch('/query-plots', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') 
                    },
                    body: JSON.stringify({ to_nt, lat_cao, farm, rubber_id })
                })
                .then(response => response.json())
                .then(data => {
                    const resultDiv = inputGroup.querySelector('.result');
                    resultDiv.innerHTML = ''; 
                    if (data.success) {
                        to_ntInput.readOnly = true; 
                        lat_caoInput.readOnly = true;

                        const plotIds = [];

                        data.plots.forEach(plot => {

                            const plotButton = `<button class="btn btn-dark text-nowrap" style="font-size: 12px" data-ids="${plot.id}" data-rubber="${rubber_id}">Lô ${plot.tenlo}</button>`;
                            resultDiv.innerHTML += plotButton; 

                            plotIds.push(plot.id); 
                        });

                        
                        const removeButton = inputGroup.querySelector('.remove-btn');
                        removeButton.dataset.ids = plotIds.join(','); 
                        removeButton.dataset.rubber = rubber_id;
                    } else {
                        resultDiv.innerHTML = `<span class="text-nowrap">Không tìm thấy</span>`;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        });
    </script>


    {{-- <div class="filter-date d-flex align-items-end justify-content-between gap-2">
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
                <th>Ghi chú</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rubbers as $index => $rubber)
            <tr id="{{$rubber->id}}">

                <td></td>
                <td>{{ \Carbon\Carbon::parse($rubber->time_ve)->format('d/m/Y')}}</td>
                <td>{{ \Carbon\Carbon::parse($rubber->time_ve)->format('H:i')}}</td>
                <td>{!! $rubber->input_status !== 0 ? "<span class='text-success'>Đã xác nhận</span>" : "<span class='text-danger'>Chờ xác nhận</span>"  !!}</td>
                 <td>{!! $rubber->status !== 0 ? "<span class='text-success'>Đã xử lý</span>" : "<span class='text-danger'>Chờ xử lý</span>"  !!}</td>
                <td>{{ $rubber->fresh_weight }}</td>
                <td>{{ $rubber->truck ? $rubber->truck->code: $rubber->truck_name }}</td>
                <td>{{ $rubber->farm_name }}</td>
                <td>{{ $rubber->curing_area?->code }}</td>
                <td>{{ $rubber->farm?->company ? $rubber->farm->company->code : '' }}</td>
                <td>{{ $rubber->latex_type }}</td>
                <td>{{ $rubber->tai_xe }}</td>
                <td>{{ $rubber->material_age }}</td>
                <td>{{ $rubber->drc_percentage }}</td>
                <td>{{ $rubber->dry_weight }}</td>
                <td>{{ $rubber->material_condition }}</td>
                <td>{{ $rubber->impurity_type }}</td>
                <td>{{ $rubber->grade }}</td>
                <td>{{ $rubber->note}}</td>
                
            </tr>
            @endforeach
        </tbody>
        <tfoot>

        </tfoot>
    </table> --}}

 
@endsection