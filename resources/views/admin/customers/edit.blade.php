@extends('layouts.myapp')

@section('content')
    <div class="row">
        <h4 class="fw-bold py-3 mb-4">Chỉnh sửa khách hàng</h4>

        <div class="card-body">
            @include('partials.errors')
            
            <form action="{{ route('customers.update', [$customer->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Tên công ty</label>
                        <input type="text" name="name" class="form-control" value="{{$customer->name}}" required>
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Mô tả</label>
                        <input type="text" name="description" class="form-control" value="{{$customer->description}}">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Số điện thoại</label>
                        <input type="tel" name="phone" class="form-control" required value="{{$customer->phone}}">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Email</label>
                        <input type="email" name="email" class="form-control" required value="{{$customer->email}}">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Loại khách hàng</label>
                        <select name="type" class="form-select custom-select w-100 drumdate-select" >
                            <option value="KH Dài hạn" {{$customer->type == 'KH Dài hạn' ? 'selected' : ''}}>KH Dài hạn</option>
                            <option value="KH Ngắn hạn" {{$customer->type == 'KH Ngắn hạn' ? 'selected' : ''}}>KH Ngắn hạn</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>

    

   
@endsection