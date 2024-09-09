@extends('layouts.myapp')

@section('content')
    <div class="row">
        <h4 class="fw-bold py-3 mb-4">Chỉnh sửa khách hàng</h4>

        <div class="card-body">
            @include('partials.errors')
            
            <form action="{{ route('contract-type.update', [$type->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Loại hợp đồng</label>
                        <input type="text" name="type" class="form-control" required value="{{$type->type}}">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Mã hợp đồng</label>
                        <input type="text" name="code" class="form-control" value="{{$type->code}}">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Tên hợp đồng</label>
                        <input type="tel" name="name" class="form-control" required value="{{$type->name}}">
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>

    

   
@endsection