@extends('layouts.myapp')

@section('content')
<h4 class="fw-bold py-3 mb-4">Cán vắt</h4>

<div class="row">
    <div class="col-lg-6">
        <div class="text-center mb-2 fw-bold">Nguyên liệu mủ đông chén</div>
        <div class="grid-areas">
            @foreach ($curing_areas as $item)
            @if ($item->latex_type == 'Mủ đông chén')
            <div class="area-item rol btn btn-{{$item->containing > 0 ? 'warning containing' : 'dark' }}">
                <div class="code">
                    {{$item->code}}
                </div>
                <span class="number">{{ number_format($item->containing, 0, '.', ',') }}</span> kg
            </div>
            @endif
            @endforeach
        </div>
    </div>

    <div class="col-lg-6">
        <div class="text-center mb-2 fw-bold">Nguyên liệu đã cán vắt</div>
        <div class="grid-areas">
            @foreach ($curing_houses as $item)
            <div class="area-item btn btn-{{$item->containing > 0 ? 'success containing' : 'dark' }}">
                <div class="code">
                    {{$item->code}}
                </div>
                <span class="number">{{ number_format($item->containing, 0, '.', ',') }}</span> kg
            </div>
            @endforeach
        </div>
    </div>




    <!-- {{-- <div class="col-lg-6">
            <div class="text-center mb-2 fw-bold">Nguyên liệu mủ dây</div>
            <div class="grid-areas" style="direction: rtl;">
                @foreach ($curing_areas as $item)
                    @if ($item->latex_type == 'Mủ dây')
                        <div class="area-item rol btn btn-{{$item->containing > 0 ? 'warning containing' : 'dark' }}"
    style="direction: ltr;">
    <div class="code">
        {{$item->code}} <br>
    </div>
    <div class="number">
        {{ number_format($item->containing, 0, '.', ',') }} kg
    </div>
</div>
@endif
@endforeach
</div>
</div> --}} -->
</div>

<div class="d-flex justify-content-end align-items-center">
    <button class="addBtn  btn my-3 btn-dark">Thêm mới</button>
</div>

<div class="card mb-4 form-machine">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Thêm lệnh</h5>
    </div>
    <div class="card-body">
        @include('partials.errors')

        <form action="{{ route('rolling.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="mb-3 col-lg-4">
                    <label class="form-label">Bãi nguyên liệu</label>

                    <select name="curing_area_id" id="areaSelect" class="form-select custom-select w-100">
                        @foreach ($areas as $item)
                        <option value="{{$item->id}}" data-containing="{{$item->containing}}">{{$item->code}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-lg-4">
                    <label class="form-label">Nhà ủ</label>

                    <select name="curing_house_id" id="receivingPlaceSelect" class="form-select custom-select w-100">
                        @foreach ($curing_houses as $item)
                        <option value="{{$item->id}}" data-containing="{{$item->containing}}"
                            data-area={{$item->curing_area->id}}>{{$item->code}}</option>
                        @endforeach
                    </select>
                </div>


                <div class="mb-3 col-lg-4">
                    <label class="form-label">Trọng lượng quy khô (kg)</label>

                    <input type="number" min="1" name="weight_to_roll" class="form-control" id="weight_to_roll"
                        value="{{$areas[0]->containing ?? ''}}">
                </div>

                <div class="mb-3 col-lg-4">
                    <label class="form-label">Ngày tiếp nhận</label>
                    <input type="date" name="date_curing" require class="form-control">
                    {{-- <select name="date_curing" class="form-select custom-select w-100">
                        @foreach ($dates as $item)
                        <option value="{{ \Carbon\Carbon::parse($item->or_time)->format('d/m/Y')}}"
                            data-house="$item->">{{ \Carbon\Carbon::parse($item->or_time)->format('d/m/Y')}}</option>
                        @endforeach
                    </select>  --}}
                </div>

                <div class="mb-3 col-lg-4">
                    <label class="form-label">Ngày cán vắt</label>
                    <input type="date" name="date" id="dateInput" class="form-control">
                </div>

                <div class="mb-3 col-lg-4">
                    <label class="form-label">Giờ</label>
                    <input type="time" name="time" id="timeInput" class="form-control">
                </div>

                <div class="mb-3 col-lg-4">
                    <label class="form-label">Tạp chất loại bỏ</label>
                    <input type="text" name="impurity_removing" class="form-control">
                </div>

                <div class="mb-3 col-lg-4">
                    <label class="form-label">Số lần cán</label>
                    <input type="number" name="timeRoll" required class="form-control" value="2">
                </div>


                <button type="submit" class="btn btn-primary mt-2">Thực hiện</button>
            </div>
        </form>
    </div>
</div>



<h4 class="fw-bold">Nguyên liệu đã cán vắt</h4>

<div class="d-flex justify-content-between">
    <div class="">
        <div class="mb-1"> - Tổng cán vắt BHCK: <span
                class="fw-bold fs-4 text-danger">{{ number_format($cv_bhck, 0, ',', '.') }}
                tấn</span> </div>
        <div class="mb-1"> - Tổng cán vắt CRCK2: <span
                class="fw-bold fs-4 text-success">{{ number_format($cv_crck, 0, ',', '.') }}
                tấn</span> </div>
        <div class="mb-1"> - Tổng cán vắt Thu mua: <span
                class="fw-bold fs-4 text-warning">{{ number_format($cv_tm, 0, ',', '.') }}
                tấn</span> </div>
        <div class="mb-1"> - Tổng cán vắt TNSR: <span class="fw-bold fs-4">{{ number_format($cv_tnsr, 0, ',', '.') }}
                tấn</span> </div>
    </div>
</div>



<div class="filter-date d-flex align-items-end justify-content-end gap-2">
    <!-- <div class="">
            <label for="min" class="form-label mb-0">Lọc ngày</label>
            <input type="text" id="min" name="min" class="form-control" style="width: 200px">
        </div> -->

    <form action="{{ route('rolling-delete-items') }}" class="form-delete-items d-none" method="POST"
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
            <th>Ngày cán vắt</th>
            <th>Mã lệnh</th>
            <th>Trạng thái</th>
            <th>Thời gian</th>
            
            <th>Bãi nguyên liệu</th>
            <th>Nhà ủ</th>
            <th>Khối lượng quy khô (kg)</th>
            <th>Ngày tiếp nhận</th>
            <th>Số lần cán</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($rollings as $index => $rolling)
        <tr id="{{$rolling->id}}">
            <td></td>
            <td data-sort='{{ \Carbon\Carbon::parse($rolling->date)->format('Y-m-d')}}'>{{ \Carbon\Carbon::parse($rolling->date)->format('d/m/Y')}}</td>
            <td>{{ $rolling->code }}</td>

            <td>
                {!! $rolling->status === 0
                ? "<span class='text-danger'>Chờ gia công</span>"
                : ($rolling->status === 1
                ? "<span class='text-success'>Đã gia công</span>"
                : "<span class='text-warning'>Gia công một phần</span>")
                !!}
            </td>

            <td>{{ \Carbon\Carbon::parse($rolling->time)->format('H:i')}}</td>
            <td>{{ $rolling->area ? $rolling->area->code : '' }}</td>
            <td>{{ $rolling->house ? $rolling->house->code : '' }}</td>
            <td>{{  number_format($rolling->weight_to_roll, 0, '.', ',') }}</td>
            <td>{{ \Carbon\Carbon::parse($rolling->date_curing)->format('d/m/Y')}}</td>
            <td>{{ $rolling->timeRoll}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection