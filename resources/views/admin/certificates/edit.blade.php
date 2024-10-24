@extends('layouts.myapp')

@section('content')
<h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Nông trại /</span> Chỉnh sửa Chứng Chỉ</h4>
<div class="row">
    @include('partials.errors')

    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Chỉnh sửa chứng chỉ</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('certificates.update', $certificate->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="certificate_name" class="form-label">Tên Chứng Chỉ</label>
                        <input type="text" class="form-control" id="certificate_name" name="certificate_name" value="{{ $certificate->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="certificate_file" class="form-label">Tệp Chứng Chỉ (nếu có)</label>
                        <input type="file" class="form-control" id="certificate_file" name="certificate_file">
                    </div>
                    <button type="submit" class="btn btn-primary">Cập Nhật Chứng Chỉ</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
