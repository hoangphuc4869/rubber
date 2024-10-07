@extends('layouts.myapp')

@section('content')
    <div class="row">
        <h4 class="fw-bold py-3 mb-4">Thêm hợp đồng mới</h4>

        <div class="card-body">
            @include('partials.errors')
            
            <form action="{{ route('contract.store') }}" method="POST">
                @csrf
                <div class="row">

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Loại hợp đồng</label>
                        <select name="contract_type_id" class="form-select custom-select w-100 drumdate-select" >

                            @foreach ($types as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                            
                        </select>
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Khách hàng</label>
                        <select name="customer_id" class="form-select custom-select w-100 drumdate-select" >

                            @foreach ($customers as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                            
                        </select>
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Số hợp đồng</label>
                        <input type="text" name="contract_number" class="form-control" required>
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Ngày hợp đồng</label>
                        <input type="date" name="contract_date" class="form-control" required>
                    </div>

                    {{-- <div class="mb-3 col-lg-3">
                        <label class="form-label" >Thuộc hợp đồng gốc số</label>
                        <input type="text" name="hd_goc_so" class="form-control" required value="123">
                    </div> --}}

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Tháng giao hàng</label>
                        <select name="thang_giao_hang[]" class="form-select w-100" id="thang_giao_hang" multiple="multiple" >

                           
                                <option value="Cả năm">Cả năm</option>
                                <option value="01">Tháng 1</option>
                                <option value="02">Tháng 2</option>
                                <option value="03">Tháng 3</option>
                                <option value="04">Tháng 4</option>
                                <option value="05">Tháng 5</option>
                                <option value="06">Tháng 6</option>
                                <option value="07">Tháng 7</option>
                                <option value="08">Tháng 8</option>
                                <option value="09">Tháng 9</option>
                                <option value="10">Tháng 10</option>
                                <option value="11">Tháng 11</option>
                                <option value="12">Tháng 12</option>
                            
                            
                        </select>
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Năm giao hàng</label>
                        <input type="number" name="nam_giao_hang" class="form-control" required>
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Sản phẩm/ Lot</label>
                        <input type="text" name="san_pham" class="form-control" required value="CSR10">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Loại Pallet</label>
                        <input type="text" name="loai_pallet" class="form-control" required value="Hàng rời, không pallet">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Thị trường</label>
                        <input type="text" name="thi_truong" class="form-control" required value="Việt Nam">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Đơn vị Sản xuất/ Thương mại</label>
                        <input type="text" name="don_vi_xuat_thuong_mai" class="form-control" required value="C.R.C.R.2 APHIVATHCAOUTCHOUC Co., Ltd">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Bán cho bên thứ 3</label>
                        <input type="text" name="ban_cho_ben_thu_3" class="form-control" required value="Không">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Khối lượng theo hợp đồng (tấn)</label>
                        <input type="number" name="count_contract" class="form-control" required>
                    </div>

                   
                    <button type="submit" class="btn btn-primary mt-2">Thực hiện</button>
                </div>
            </form>


        </div>
    </div>

    

   
@endsection