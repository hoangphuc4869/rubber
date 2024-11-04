@extends('layouts.myapp')

@section('content')
    <div class="row">
        <h4 class="fw-bold py-3 mb-4">Thêm hợp đồng mớiiiii</h4>

        <div class="card-body">
            @include('partials.errors')
            
            <form action="{{ route('contract.store') }}" method="POST">
                @csrf
                <div class="row">

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Loại hợp đồng</label>
                        <select name="contract_type_id" class="form-select custom-select w-100 drumdate-select" >

                            @foreach ($types as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                            
                        </select>
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Khách hàng</label>
                        <select name="customer_id" class="form-select custom-select w-100 drumdate-select" >

                            @foreach ($customers as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                            
                        </select>
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Số hợp đồng</label>
                        <input type="text" name="contract_number" class="form-control" required>
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Ngày hợp đồng</label>
                        <input type="date" name="contract_date" class="form-control" required>
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Thuộc hợp đồng gốc số</label>
                        <input type="text" name="hd_goc_so" class="form-control" required>
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Tháng giao hàng</label>
                        <input type="text" name="thang_giao_hang" class="form-control" required>
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Sản phẩm/ Lot</label>
                        <input type="text" name="san_pham" class="form-control" required>
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Loại Pallet</label>
                        <input type="text" name="loai_pallet" class="form-control" required>
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Thị trường</label>
                        <input type="text" name="thi_truong" class="form-control" required>
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Đơn vị Sản xuất/ Thương mại</label>
                        <input type="text" name="supplier" class="form-control" required>
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Bán cho bên thứ 3</label>
                        <input type="text" name="ban_cho_ben_thu_3" class="form-control" required>
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Số lượng hợp đồng (tấn)</label>
                        <input type="text" name="count_contract" class="form-control" required>
                    </div>
                    
                    <div class="delivery_dates_container">
                        <div class="delivery_dates row my-4 py-4" id="delivery_dates_0">
                            <div class="delivery_date_template mb-3 col-lg-4">
                                <label class="form-label ">Ngày giao hàng lần 1</label>
                                <input type="date" name="delivery_date[0][date]" class="form-control" required>
                            </div>

                            <div class="delivery_date_template mb-3 col-lg-4">
                                <label class="form-label ">Mã lô hàng lần 1</label>
                                <input type="text" name="delivery_date[0][plots][]" class="form-control" required>
                            </div>

                            <div class="delivery_date_template mb-3 col-lg-4">
                                <label class="form-label ">Số lượng (tấn) lần 1</label>
                                <input type="text" name="delivery_date[0][amount]" class="form-control" required>
                            </div>

                            <div class="delivery_date_template mb-3 col-lg-4">
                                <label class="form-label ">Ngày đóng cont lần 1</label>
                                <input type="date" name="delivery_date[0][container_loading_date]" class="form-control" required>
                            </div>

                            <div class="delivery_date_template mb-3 col-lg-4">
                                <label class="form-label ">Lệnh xuất hàng lần 1</label>
                                <input type="text" name="delivery_date[0][shipping_order]" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="buttons my-3">
                        <button type="button" class="add-more btn btn-dark">Thêm</button>
                    </div>

                    
                    <button type="submit" class="btn btn-primary mt-2">Thực hiện</button>
                </div>
            </form>
        </div>
    </div>

    

   
@endsection