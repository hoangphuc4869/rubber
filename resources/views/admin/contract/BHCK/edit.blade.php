@extends('layouts.myapp')

@section('content')
    <div class="row">
        <h4 class="fw-bold py-3 mb-2">Chỉnh sửa hợp đồng</h4>

        <div class="d-flex gap-3 justify-content-end align-items-center mb-2">
            <div class="fw-bold" style="color: #f10b0b">
                Trạng thái: 
            </div>
            <div class="form-check">
                <input data-id={{$contract->id}} class="form-check-input change-stat" type="radio" value="Chưa thanh toán" id="check1" name="trang_thai" {{$contract->trang_thai == 'Chưa thanh toán' ? 'checked' : ''}}>
                <label class="form-check-label text-dark fw-bold" for="check1"> Chưa thanh toán </label>
            </div>

            <div class="form-check">
                <input data-id={{$contract->id}} class="form-check-input change-stat" type="radio" value="Một phần" id="check2" name="trang_thai" {{$contract->trang_thai == 'Một phần' ? 'checked' : ''}}>
                <label class="form-check-label text-dark fw-bold" for="check2"> Một phần </label>
            </div>

            <div class="form-check">
                <input data-id={{$contract->id}} class="form-check-input change-stat" type="radio" value="Hoàn tất" id="check3" name="trang_thai" {{$contract->trang_thai == 'Hoàn tất' ? 'checked' : ''}}>
                <label class="form-check-label text-dark fw-bold" for="check3"> Hoàn tất </label>
            </div>
        </div>

        <style>

            .form-check-input:checked, .form-check-input[type=checkbox]:indeterminate {
                background-color: #4b9605;
                border-color: #4b9605;
                box-shadow: 0 2px 4px 0 rgba(105, 108, 255, 0.4);
            }

            .form-check label {
                cursor: pointer;
            }
        </style>

        

        <div class="card-body">
            @include('partials.errors')
            
            <form action="{{ route('contract.update', [$contract->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">
                    
                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Loại hợp đồng</label>
                        <select name="contract_type_id" class="form-select custom-select w-100 drumdate-select" >

                            @foreach ($types as $item)
                                <option value="{{$item->id}}" {{$contract->contract_type_id && $contract->contract_type_id == $item->id ? ' selected' : ''}}>{{$item->name}}</option>
                            @endforeach
                            
                        </select>
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Khách hàng</label>
                        <select name="customer_id" class="form-select custom-select w-100 drumdate-select" >

                            @foreach ($customers as $item)
                                <option value="{{$item->id}}" {{$contract->customer_id && $contract->customer_id == $item->id ? ' selected' : ''}}>{{$item->name}}</option>
                            @endforeach
                            
                        </select>
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Số hợp đồng</label>
                        <input type="text" name="contract_number" class="form-control" required value="{{$contract->contract_number}}">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Ngày hợp đồng</label>
                        <input type="date" name="contract_date" class="form-control" required value="{{$contract->contract_date}}">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Thuộc hợp đồng gốc số</label>
                        <input type="text" name="hd_goc_so" class="form-control" required value="{{$contract->hd_goc_so}}">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Tháng giao hàng</label>
                        <select name="thang_giao_hang" class="form-select w-100" >

                           
                                <option value="01" {{$contract->thang_giao_hang == "01" ? 'selected' : ''}}>Tháng 1</option>
                                <option value="02" {{$contract->thang_giao_hang == "02" ? 'selected' : ''}}>Tháng 2</option>
                                <option value="03" {{$contract->thang_giao_hang == "03" ? 'selected' : ''}}>Tháng 3</option>
                                <option value="04" {{$contract->thang_giao_hang == "04" ? 'selected' : ''}}>Tháng 4</option>
                                <option value="05" {{$contract->thang_giao_hang == "05" ? 'selected' : ''}}>Tháng 5</option>
                                <option value="06" {{$contract->thang_giao_hang == "06" ? 'selected' : ''}}>Tháng 6</option>
                                <option value="07" {{$contract->thang_giao_hang == "07" ? 'selected' : ''}}>Tháng 7</option>
                                <option value="08" {{$contract->thang_giao_hang == "08" ? 'selected' : ''}}>Tháng 8</option>
                                <option value="09" {{$contract->thang_giao_hang == "09" ? 'selected' : ''}}>Tháng 9</option>
                                <option value="10" {{$contract->thang_giao_hang == "10" ? 'selected' : ''}}>Tháng 10</option>
                                <option value="11" {{$contract->thang_giao_hang == "11" ? 'selected' : ''}}>Tháng 11</option>
                                <option value="12" {{$contract->thang_giao_hang == "12" ? 'selected' : ''}}>Tháng 12</option>
                            
                            
                        </select>
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Sản phẩm/ Lot</label>
                        <input type="text" name="san_pham" class="form-control" required value="{{$contract->san_pham}}">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Loại Pallet</label>
                        <input type="text" name="loai_pallet" class="form-control" required value="{{$contract->loai_pallet}}">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Thị trường</label>
                        <input type="text" name="thi_truong" class="form-control" required value="{{$contract->thi_truong}}">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Đơn vị Sản xuất/ Thương mại</label>
                        <input type="text" name="don_vi_xuat_thuong_mai" class="form-control" required value="{{$contract->don_vi_xuat_thuong_mai}}">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Bán cho bên thứ 3</label>
                        <input type="text" name="ban_cho_ben_thu_3" class="form-control" required value="{{$contract->ban_cho_ben_thu_3}}">
                    </div>

                    <div class="mb-3 col-lg-4">
                        <label class="form-label" >Số lượng hợp đồng (tấn)</label>
                        <input type="number" name="count_contract" class="form-control" required value="{{$contract->count_contract}}">
                    </div>


                    {{-- {{$contract->shipments}} --}}

                   

                    @if ($contract->trang_thai !== "Hoàn tất")
                        <div class="buttons my-3">
                            <button type="button" class="add-more btn btn-dark">Yêu cầu xuất hàng</button>
                        </div>
                        
                        <div class="delivery_dates_container">

                        </div>

                        <button type="submit" class="btn btn-primary mt-2">Cập nhật</button>
                    @endif
                </div>
            </form>

             <div class="shipment-info">
                        <div class="shipment-title fw-bold text-dark fs-4 mt-3">
                            Lệnh xuất hàng
                        </div>

                        @if ($contract->shipments->count() == 0)
                            <div class="text-danger">Chưa có dữ liệu.</div>
                        @else
                            @foreach ($contract->shipments as $index => $item)
                                <div class="row shipment my-3">
                                    <div class="col-lg-3 mb-3">
                                        <div class="">
                                            <div class="mb-2 fw-bold text-dark fs-5">Lần {{$index + 1}}</div>
                                            <ul class="mb-0">
                                                <li>Mã lệnh xuất: <span>{{$item->ma_xuat}}</span></li>
                                                <li>Loại hàng: <span>{{$item->loai_hang}}</span></li>
                                                <li>Số lượng: <span>{{$item->so_luong}} tấn</span></li>
                                                <li>Ngày xuất: <span>{{$item->updated_at && $item->status == 1 ? \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') : 'Đang cập nhật' }}</span> </li>
                                                <li>Trạng thái: {!!$item->status == 0 ? '<span class="text-danger">Đang cập nhật</span>' : '<span class="text-success">Đã xuất hàng</span>'!!} </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mb-3">
                                        <div class="">
                                            <div class="mb-2 fw-bold text-dark fs-5">Lô hàng</div>
                                            <div class="batches">
                                                @foreach ($item->batches as $batch)
                                                    <button class="btn btn-dark mb-1">{{$batch->batch_code}}</button>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3 mb-3">
                                        <div>
                                            <div class="fw-bold">Trạng thái:</div>
                                            <select class="form-select w-100" data-id="{{$item->id}}" onchange="saveNote(this)">
                                                <option value="0" {{$item->customer_status == 0 ? 'selected' : ''}}>Khách chưa nhận hàng</option>
                                                <option value="1" {{$item->customer_status == 1 ? 'selected' : ''}}>Khách đã nhận hàng</option>
                                            </select>
                                        </div>
                                        <div class="fw-bold mt-2">Ghi chú:</div>
                                    
                                        <textarea class="note form-control" rows="4" data-id="{{$item->id}}" onblur="saveNote(this)" placeholder="Thêm ghi chú">{{$item->note}}</textarea>
                                    </div>


                                    @if ($item->status == 0)
                                        <div class="d-flex justify-content-end align-items-center">
                                        <form action="/shipment/{{$item->id}}/destroy" class="form-delete-items" method="POST" onsubmit="return confirmDelete();">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" style="font-size: 12px">Xóa</button>
                                        </form>
                                        
                                    </div>
                                    @endif
                                </div>
                            @endforeach
                        @endif

                        <style>
                            .shipment {
                                background: rgb(181, 234, 245);
                                border-radius: 15px;
                                padding: 15px;
                            }

                            .shipment ul li {
                                margin-bottom: 10px;
                            }

                            .shipment ul li span {
                                font-weight: bold;
                            }
                        </style>
                    </div>


        </div>
    </div>


    <script>
        if (document.querySelectorAll(".change-stat")) {
            document.querySelectorAll(".change-stat").forEach((radio) => {
                radio.addEventListener("change", function () {
                    const status = this.value;
                    const contractId = this.dataset.id;

                    fetch("/update-contract-status", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        },
                        body: JSON.stringify({
                            id: contractId,
                            trang_thai: status,
                        }),
                    })
                        .then((response) => {
                            if (!response.ok) {
                                throw new Error("Network response was not ok");
                            }
                            return response.json();
                        })
                        .then((data) => {
                            alert(data.message);
                        })
                        .catch((error) => {
                            console.error(
                                "There was a problem with the fetch operation:",
                                error
                            );
                            alert("Đã xảy ra lỗi, vui lòng thử lại!");
                        });
                });
            });
        }
    </script>

   <script>
    function saveNote(element) {
        const itemId = element.dataset.id;
        const shipmentStatus = document.querySelector(`select[data-id="${itemId}"]`).value;
        const noteValue = document.querySelector(`textarea[data-id="${itemId}"]`).value;

        fetch('/update-shipment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                id: itemId,
                status: shipmentStatus,
                note: noteValue
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            alert(data.message);
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
            alert('Đã xảy ra lỗi, vui lòng thử lại!');
        });
    }
</script>

   
@endsection