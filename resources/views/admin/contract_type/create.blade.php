@extends('layouts.myapp')

@section('content')
    <div class="row">
        <h4 class="fw-bold py-3 mb-4">Thêm loại hợp đồng</h4>

        <div class="card-body">
            @include('partials.errors')
            
            <form action="{{ route('contract-type.store') }}" method="POST">
                @csrf
                <div class="row">

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Loại hợp đồng</label>
                        <input type="text" name="type" class="form-control" required>
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Mã hợp đồng</label>
                        <input type="text" name="code" class="form-control">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Tên hợp đồng</label>
                        <input type="tel" name="name" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-2">Thực hiện</button>
                </div>
            </form>
        </div>
    </div>

    

   
@endsection