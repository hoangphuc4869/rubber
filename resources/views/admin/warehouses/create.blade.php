@extends('layouts.myapp')

@section('content')

     <h4 class="fw-bold py-3 mb-4">Tạo kho hàng</h4>
    @include('partials.errors')
     <form action="{{ route('warehouse.store') }}" method="POST">
        @csrf
        
        <label for="rows">Tên kho:</label>
        <input type="text" id="rows" name="name" required>

        <label for="rows">Số hàng:</label>
        <input type="number" id="rows" name="rows" min="1" required>

        
        <button type="submit">Tạo Grid</button>
    </form>


    <div class="warehouses mt-5">
        @foreach ($wares as $item)
            <div class="grid-item {{$item->status == 1 ? 'occupied' : ''}}" id="{{$item->id}}">
                {{$item->code}} <br>
                <span>{{$item->batch_code}}</span>
            </div>
        @endforeach
        
    </div>

   

@endsection