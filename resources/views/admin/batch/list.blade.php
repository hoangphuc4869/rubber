@extends('layouts.myapp')

@section('content')
    @include('partials.errors')

    <h4 class="fw-bold mb-5 mt-4">Danh sách lô hàng</h4>


    <div class="filter-date d-flex align-items-end justify-content-between gap-2">
        <div class="d-flex gap-3 align-items-end">
            <div class="">
                <label for="min5" class="form-label mb-0">Lọc ngày</label>
                <input type="text" id="min5" name="min5" class="form-control" style="width: 200px">
            </div>
            <div class="filter-line d-flex align-items-end justify-content-between gap-2">
                <div class="">
                    <label for="lineFilter5" class="form-label mb-0">Dây chuyền</label>
                    <select id="lineFilter5" class="form-control" style="width: 200px">
                        <option value="3">3 tấn</option>
                        <option value="6">6 tấn</option>
                    </select>
                </div>
            </div>

            <div class="filter-line d-flex align-items-end justify-content-between gap-2">
                <div class="">
                    <label for="comFilter5" class="form-label mb-0">Công ty</label>
                    <select id="comFilter5" class="form-control" style="width: 200px">
                        <option value="BHCK">BHCK</option>
                        <option value="CRCK2" selected>CRCK2</option>
                        <option value="TNSR">TNSR</option>
                    </select>
                </div>
            </div>

            <div class="d-flex align-items-center gap-2">
                <form action="{{ route('batch-delete-items') }}" class="form-delete-items d-none" method="POST"
                    onsubmit="return confirmDelete();">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="drums" id="selected-drums">
                    <button class="btn btn-danger" type="submit">Xóa</button>
                </form>
            </div>
        </div>
    </div>



<table id="datatable5" class="ui celled table" style="width:100%">
    <thead>
        <tr>
            <th>Ngày thực hiện</th>
            <th>Công ty</th>
            <th>Mã lô</th>
            <th>Số bành</th>
            <th>Hạng dự kiến</th>
            <th>Kiểm tra cắt bành</th>
            <th>Thời gian tạo lô</th>
            <th>Dây chuyền</th>
            <th>Nguồn nguyên liệu</th>
            <th>Kiểm nghiệm</th>
            <th>Trạng thái</th>
        </tr>
    </thead>
    <tbody>

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
    </tbody>
</table>

<style>
    td {
        text-align: center!important;
    }
</style>

@endsection