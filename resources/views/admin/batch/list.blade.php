@extends('layouts.myapp')

@section('content')
    @include('partials.errors')

    <h4 class="fw-bold mb-5 mt-4">Danh sách lô hàng</h4>


   <div class="filter-date d-flex align-items-end justify-content-between  gap-2">
      
            <div class="filter-section  d-flex align-items-end gap-2 my-2">
                <div class="">
                    <label for="dateFilterList" class="" style="font-size: 14px">Ngày</label>
                    <input type="text" id="dateFilterList" class="form-control" placeholder="Chọn ngày" style="width: 120px" />
                </div>

                <div class="">
                    <label for="nongtruongFilterList" style="font-size: 14px">Nguồn</label>
                    <select name="" id="nongtruongFilterList" class="form-select">
                        <option value="NLNT1">NLNT1</option>
                        <option value="NLNT2">NLNT2</option>
                        <option value="NLNT3">NLNT3</option>
                        <option value="NLNT4">NLNT4</option>
                        <option value="NLNT5">NLNT5</option>
                        <option value="NLNT6">NLNT6</option>
                        <option value="NLNT7">NLNT7</option>
                        <option value="NLNT8">NLNT8</option>
                        <option value="NLTNSR">NLTNSR</option>
                        <option value="NLTM">NLTM</option>
                        <option value="MDBH">MDBH</option>
                        <option value="MDCR">MDCR</option>
                        <option value="NLTMMD">NLTMMD</option>
                    </select>
                </div>

                <div class="">
                    <label for="linkFilterList" style="font-size: 14px">Dây chuyền</label>
                    <select name="" id="linkFilterList" class="form-select" style="width: 100px">
                        @if (Gate::allows('admin')  || Gate::allows('6t'))
                            <option value="6">6 tấn</option>
                        @endif
                        @if (Gate::allows('admin')  || Gate::allows('3t'))
                            <option value="3">3 tấn</option>
                        @endif
                        
                    </select>
                </div>

                <button id="btnListFilter" class="btn btn-primary">Lọc</button>
            </div>

            <div class="my-2 d-none" id="labelBtn">
                <form action="/export-labels">
                    <input type="hidden" name="ids" id="selectedBatch">
                    <button type="submit" class="btn btn-warning">Xuất tem</button>
                </form>
            </div>
       
    </div>


    <div class="button-group mt-3">
        <div class="d-flex align-items-center gap-2">
            <button id="selectAllBtnList" class="btn btn-dark">Tất Cả</button>
        </div>
    </div>



<table id="tableBatchList" class="hover ui celled table" style="width:100%">
    <thead>
        <tr>
            <th>Ngày thực hiện</th>
            <th>nguồn nguyên liệu</th>
            <th>Mã lô</th>
            <th>Thời gian tạo lô</th>
            <th>Số bành</th>
            <th>Hạng dự kiến</th>
            <th>Kiểm tra cắt bành</th>
           
            <th>Dây chuyền</th>
            <th>Kiểm nghiệm</th>
            <th>Trạng thái</th>
        </tr>
    </thead>
    {{-- <tbody>

        @foreach ($batches as $index => $batch)

        <tr id={{$batch->id}} class="{{$batch->exported == 1 ? 'no-select' : ''}}">
            <td>{{ \Carbon\Carbon::parse($batch->date)->format('d/m/Y') }}</td>
            <td>{{$batch->company->code}}</td>
            <td>{{$batch->batch_code}}</td>
            <td>{{$batch->bale_count}}</td>
            <td>{{$batch->expected_grade}}</td>
            <td>{{$batch->sample_cut_number}}</td>
            <td></td>
            <td>{{$batch->link}}</td>
            <td></td>
            <td>{!! $batch->checked == 0 ? "<span class='text-danger'>Chưa</span>" : "<span class='text-success'>Đã kiểm
                    nghiệm</span>"!!}</td>
            <td>{!! $batch->exported == 0 ? "<span class='text-danger'>Chưa xuất kho</span>" : "<span
                    class='text-dark'>Đã xuất kho</span>"!!}</td>
        </tr>
        @endforeach
    </tbody> --}}
</table>

<style>
    td {
        text-align: center!important;
    }
</style>

@endsection


