@extends('layouts.myapp')

@section('content')
{{-- @if (session('message'))
<div class="alert alert-warning">
    {{ session('message') }}
</div>
@endif --}}
<div class="d-flex justify-content-center align-items-center min-vh-1 mb-3">
    <div class="d-flex justify-content-center align-items-center min-vh-1 mb-3">
        <div class="card p-3 me-3 shadow-lg" style="width: 100%;">
            <h4 style="font-weight: bold">Xuất File Excel Cân Xe - Quản Lý QL</h4>
            <form action="{{ route('download-excel') }}" method="GET" onsubmit="return confirmDownload()">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <label for="start_date" class="form-label">Ngày Bắt Đầu</label>
                        <input type="date" class="form-control" id="start_date" name="start_date">
                    </div>
                    <div class="col-sm-6">
                        <label for="end_date" class="form-label">Ngày Kết Thúc</label>
                        <input type="date" class="form-control" id="end_date" name="end_date">
                    </div>
                </div>

                <div class="">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-file-excel"></i> Tải xuống Excel
                    </button>
                    <span>(Tải tất cả nếu không chọn ngày.)</span>

                </div>
            </form>
        </div>
    </div>
    <div class="d-flex justify-content-center align-items-center min-vh-1 mb-3">
        <div class="card p-3 me-3 shadow-lg" style="width: 100%;">
            <h4 style="font-weight: bold">Xuất File Excel Tiếp Nhận - Trợ Lý</h4>
            <form action="{{ route('download-tntl') }}" method="GET" onsubmit="return confirmDownload()">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <label for="start_date_tntl" class="form-label">Ngày Bắt Đầu</label>
                        <input type="date" class="form-control" id="start_date_tntl" name="start_date_tntl">
                    </div>
                    <div class="col-sm-6">
                        <label for="end_date_tntl" class="form-label">Ngày Kết Thúc</label>
                        <input type="date" class="form-control" id="end_date_tntl" name="end_date_tntl">
                    </div>
                </div>

                <div class="">
                    <button type="submit" class="btn btn-warning btn-lg">
                        <i class="fas fa-file-excel"></i> Tải xuống Excel
                    </button>
                    <span>(Tải tất cả nếu không chọn ngày.)</span>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center align-items-center min-vh-1 mb-3">
    <div class="d-flex justify-content-center align-items-center min-vh-1 mb-3">
        <div class="card p-3 me-3 shadow-lg" style="width: 100%;">
            <h4 style="font-weight: bold">Xuất File Excel Cán Vắt </h4>
            <form action="{{ route('download-cvtt') }}" method="GET" onsubmit="return confirmDownload()">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <label for="start_date_cvtt" class="form-label">Ngày Bắt Đầu</label>
                        <input type="date" class="form-control" id="start_date_cvtt" name="start_date_cvtt">
                    </div>
                    <div class="col-sm-6">
                        <label for="end_date_cvtt" class="form-label">Ngày Kết Thúc</label>
                        <input type="date" class="form-control" id="end_date_cvtt" name="end_date_cvtt">
                    </div>
                </div>

                <div class="">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-file-excel"></i> Tải xuống Excel
                    </button>
                    <span>(Tải tất cả nếu không chọn ngày.)</span>

                </div>
            </form>
        </div>
    </div>
    <div class="d-flex justify-content-center align-items-center min-vh-1 mb-3">
        <div class="card p-3 me-3 shadow-lg" style="width: 100%;">
            <h4 style="font-weight: bold">Xuất File Excel Gia Công Hạt </h4>
            <form action="{{ route('download-gchtt') }}" method="GET" onsubmit="return confirmDownload()">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <label for="start_date_gchtt" class="form-label">Ngày Bắt Đầu</label>
                        <input type="date" class="form-control" id="start_date_gchtt" name="start_date_gchtt">
                    </div>
                    <div class="col-sm-6">
                        <label for="end_date_gchtt" class="form-label">Ngày Kết Thúc</label>
                        <input type="date" class="form-control" id="end_date_gchtt" name="end_date_gchtt">
                    </div>
                </div>

                <div class="">
                    <button type="submit" class="btn btn-warning btn-lg">
                        <i class="fas fa-file-excel"></i> Tải xuống Excel
                    </button>
                    <span>(Tải tất cả nếu không chọn ngày.)</span>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="d-flex justify-content-center align-items-center min-vh-1 mb-3">
    <div class="d-flex justify-content-center align-items-center min-vh-1 mb-3">
        <div class="card p-3 me-3 shadow-lg" style="width: 100%;">
            <h4 style="font-weight: bold">Xuất File Excel Gia Công Nhiệt </h4>
            <form action="{{ route('download-gcntt') }}" method="GET" onsubmit="return confirmDownload()">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <label for="start_date_gcntt" class="form-label">Ngày Bắt Đầu</label>
                        <input type="date" class="form-control" id="start_date_gcntt" name="start_date_gcntt">
                    </div>
                    <div class="col-sm-6">
                        <label for="end_date_gcntt" class="form-label">Ngày Kết Thúc</label>
                        <input type="date" class="form-control" id="end_date_gcntt" name="end_date_gcntt">
                    </div>
                </div>

                <div class="">
                    <button type="submit" class="btn btn-warning btn-lg">
                        <i class="fas fa-file-excel"></i> Tải xuống Excel
                    </button>
                    <span>(Tải tất cả nếu không chọn ngày.)</span>
                </div>
            </form>
        </div>
    </div>
    <div class="d-flex justify-content-center align-items-center min-vh-1 mb-3">
        <div class="card p-3 me-3 shadow-lg" style="width: 100%;">
            <h4 style="font-weight: bold">Xuất File Excel Ra Lò-EK-BG </h4>
            <form action="{{ route('download-rl') }}" method="GET" onsubmit="return confirmDownload()">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <label for="start_date_rl" class="form-label">Ngày Bắt Đầu</label>
                        <input type="date" class="form-control" id="start_date_rl" name="start_date_rl">
                    </div>
                    <div class="col-sm-6">
                        <label for="end_date_rl" class="form-label">Ngày Kết Thúc</label>
                        <input type="date" class="form-control" id="end_date_rl" name="end_date_rl">
                    </div>
                </div>

                <div class="">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-file-excel"></i> Tải xuống Excel
                    </button>
                    <span>(Tải tất cả nếu không chọn ngày.)</span>

                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function confirmDownload() {
        return confirm('Bạn có chắc chắn muốn tải xuống tệp Excel?');
    }
</script>
@endsection