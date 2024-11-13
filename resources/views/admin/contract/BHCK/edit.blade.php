@extends('layouts.myapp')

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
            .sub_contract {
                padding: 15px;
                border-radius: 10px;
                background: antiquewhite;
            }
        </style>

        <div class="card-body">
            @include('partials.errors')
            
            <form action="{{ route('contract.update', [$contract->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    
                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Loại hợp đồng</label>
                        <select name="contract_type_id" class="form-select custom-select w-100 drumdate-select" >

                            @foreach ($types as $item)
                                <option value="{{$item->id}}" {{$contract->contract_type_id && $contract->contract_type_id == $item->id ? ' selected' : ''}}>{{$item->name}}</option>
                            @endforeach
                            
                        </select>
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Khách hàng</label>
                        <select name="customer_id" class="form-select custom-select w-100 drumdate-select" >

                            @foreach ($customers as $item)
                                <option value="{{$item->id}}" {{$contract->customer_id && $contract->customer_id == $item->id ? ' selected' : ''}}>{{$item->name}}</option>
                            @endforeach
                            
                        </select>
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Số hợp đồng</label>
                        <input type="text" name="contract_number" class="form-control" required value="{{$contract->contract_number}}">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Ngày hợp đồng</label>
                        <input type="date" name="contract_date" class="form-control" required value="{{$contract->contract_date}}">
                    </div>

                    {{-- <div class="mb-3 col-lg-3">
                        <label class="form-label" >Tháng giao hàng</label>
                        @php
                            $selectedMonths = explode(',', $contract->thang_giao_hang);
                        @endphp

                        <select name="thang_giao_hang[]" class="form-select w-100" id="thang_giao_hang" multiple="multiple">
                            <option value="Cả năm" {{ in_array('Cả năm', $selectedMonths) ? 'selected' : '' }}>Cả năm</option>
                            <option value="01" {{ in_array('01', $selectedMonths) ? 'selected' : '' }}>Tháng 1</option>
                            <option value="02" {{ in_array('02', $selectedMonths) ? 'selected' : '' }}>Tháng 2</option>
                            <option value="03" {{ in_array('03', $selectedMonths) ? 'selected' : '' }}>Tháng 3</option>
                            <option value="04" {{ in_array('04', $selectedMonths) ? 'selected' : '' }}>Tháng 4</option>
                            <option value="05" {{ in_array('05', $selectedMonths) ? 'selected' : '' }}>Tháng 5</option>
                            <option value="06" {{ in_array('06', $selectedMonths) ? 'selected' : '' }}>Tháng 6</option>
                            <option value="07" {{ in_array('07', $selectedMonths) ? 'selected' : '' }}>Tháng 7</option>
                            <option value="08" {{ in_array('08', $selectedMonths) ? 'selected' : '' }}>Tháng 8</option>
                            <option value="09" {{ in_array('09', $selectedMonths) ? 'selected' : '' }}>Tháng 9</option>
                            <option value="10" {{ in_array('10', $selectedMonths) ? 'selected' : '' }}>Tháng 10</option>
                            <option value="11" {{ in_array('11', $selectedMonths) ? 'selected' : '' }}>Tháng 11</option>
                            <option value="12" {{ in_array('12', $selectedMonths) ? 'selected' : '' }}>Tháng 12</option>
                        </select>
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Năm giao hàng</label>
                        <input type="text" name="san_pham" class="form-control" required value="{{$contract->nam_giao_hang}}">
                    </div> --}}

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Sản phẩm/ Lot</label>
                        <input type="text" name="san_pham" class="form-control" required value="{{$contract->san_pham}}">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Loại Pallet</label>
                        <input type="text" name="loai_pallet" class="form-control" required value="{{$contract->loai_pallet}}">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Thị trường</label>
                        <input type="text" name="thi_truong" class="form-control" required value="{{$contract->thi_truong}}">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Đơn vị Sản xuất/ Thương mại</label>
                        <input type="text" name="don_vi_xuat_thuong_mai" class="form-control" required value="{{$contract->don_vi_xuat_thuong_mai}}">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Bán cho bên thứ 3</label>
                        <input type="text" name="ban_cho_ben_thu_3" class="form-control" required value="{{$contract->ban_cho_ben_thu_3}}">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label" >Số lượng tấn</label>
                        <input type="number" name="count_contract" class="form-control" required value="{{$contract->count_contract}}">
                    </div>

                    <div class="mb-3 col-lg-3">
                        <label class="form-label">File hợp đồng đính kèm</label>
                      
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <input type="file" name="file_scan_pdf" class="form-control hidden" >

                            @if($contract->file_scan_pdf)
                                <a href="{{ asset($contract->file_scan_pdf) }}" target="blank">
                                    <div class="btn btn-primary  text-nowrap">Xem file</div>
                                </a>
                            @else
                                <div class="text-danger fw-bold  text-nowrap">
                                    Chưa có file đính kèm
                                </div>
                            @endif
                        </div>
                    </div>


                    {{-- {{$contract->shipments}} --}}

                    <div class="buttons my-3">
                        <button type="button" class="add-more btn btn-dark" data-id="{{$contract->id}}">Yêu cầu xuất hàng</button>
                    </div>
                    
                    <div class="delivery_dates_container">

                    </div>

                    <button type="submit" class="btn btn-success mt-2">Cập nhật</button>
                </div>
            </form>
        </div>

        <hr>

        <h2>Danh sách phụ lục</h2>
        <table id="" class="ui celled table" style="width:100%">
            <thead>
                <tr>
                    <th>Loại hợp đồng</th>
                    <th>Khách hàng</th>
                    <th>Ngày hợp đồng</th>
                    <th>Số hợp đồng</th>
                    {{-- <th>Tháng giao hàng</th> --}}
                    <th>Sản phẩm</th>
                    <th>Loại Pallet</th>
                    <th>Thị trường</th>
                    <th>Đơn vị Sản xuất</th>
                    <th>Bán cho bên thứ 3</th>
                    <th>Số lượng hợp đồng (tấn)</th>
                    <th>File đính kèm</th>
                    <th>Tùy chỉnh</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subContracts as $subContract)
                <tr>
                    <td style="text-align: center; vertical-align: middle;">{{ $subContract->contract_type->name ?? 'N/A' }}</td>
                    <td style="text-align: center; vertical-align: middle;">{{ $subContract->customer->name ?? 'N/A' }}</td>
                    <td style="text-align: center; vertical-align: middle;">{{ \Carbon\Carbon::parse($subContract->contract_date)->format('d/m/Y') }}</td>
                    <td style="text-align: center; vertical-align: middle;">{{ $subContract->contract_number }}</td>
                    {{-- <td style="text-align: center; vertical-align: middle;">{{ $subContract->thang_giao_hang }}</td> --}}
                    <td style="text-align: center; vertical-align: middle;">{{ $subContract->san_pham }}</td>
                    <td style="text-align: center; vertical-align: middle;">{{ $subContract->loai_pallet }}</td>
                    <td style="text-align: center; vertical-align: middle;">{{ $subContract->thi_truong }}</td>
                    <td style="text-align: center; vertical-align: middle;">{{ $subContract->don_vi_xuat_thuong_mai }}</td>
                    <td style="text-align: center; vertical-align: middle;">{{ $subContract->ban_cho_ben_thu_3 }}</td>
                    <td style="text-align: center; vertical-align: middle;">{{ $subContract->count_contract }}</td>
                    <td style="text-align: center; vertical-align: middle;">
                        @if($subContract->file_scan_pdf)
                            <a href="{{ asset($subContract->file_scan_pdf) }}" target="_blank">Xem file</a>
                        @else
                            Không có file
                        @endif
                    </td>
                    <td style="text-align: center; vertical-align: middle;">
                        <div class="d-flex align-items-center gap-2">
                            <button class="editBtn" id="editPhuLuc" data-id="{{$subContract->id}}" data-toggle="modal" data-target="#subContractModal2">
                                <svg height="1em" viewBox="0 0 512 512">
                                    <path
                                    d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"
                                    ></path>
                                </svg>
                            </button>
                            <form action="{{route('contract.destroy', [$subContract->id])}}" method="POST" onsubmit="return confirmDelete();" class="mb-0">
                                @csrf
                                @method('DELETE')
                                <button class="bin-button">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 39 7"
                                        class="bin-top"
                                    >
                                        <line stroke-width="4" stroke="white" y2="5" x2="39" y1="5"></line>
                                        <line
                                        stroke-width="3"
                                        stroke="white"
                                        y2="1.5"
                                        x2="26.0357"
                                        y1="1.5"
                                        x1="12"
                                        ></line>
                                    </svg>
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 33 39"
                                        class="bin-bottom"
                                    >
                                        <mask fill="white" id="path-1-inside-1_8_19">
                                        <path
                                            d="M0 0H33V35C33 37.2091 31.2091 39 29 39H4C1.79086 39 0 37.2091 0 35V0Z"
                                        ></path>
                                        </mask>
                                        <path
                                        mask="url(#path-1-inside-1_8_19)"
                                        fill="white"
                                        d="M0 0H33H0ZM37 35C37 39.4183 33.4183 43 29 43H4C-0.418278 43 -4 39.4183 -4 35H4H29H37ZM4 43C-0.418278 43 -4 39.4183 -4 35V0H4V35V43ZM37 0V35C37 39.4183 33.4183 43 29 43V35V0H37Z"
                                        ></path>
                                        <path stroke-width="4" stroke="white" d="M12 6L12 29"></path>
                                        <path stroke-width="4" stroke="white" d="M21 6V29"></path>
                                    </svg>
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 89 80"
                                        class="garbage"
                                    >
                                        <path
                                        fill="white"
                                        d="M20.5 10.5L37.5 15.5L42.5 11.5L51.5 12.5L68.75 0L72 11.5L79.5 12.5H88.5L87 22L68.75 31.5L75.5066 25L86 26L87 35.5L77.5 48L70.5 49.5L80 50L77.5 71.5L63.5 58.5L53.5 68.5L65.5 70.5L45.5 73L35.5 79.5L28 67L16 63L12 51.5L0 48L16 25L22.5 17L20.5 10.5Z"
                                        ></path>
                                    </svg>
                                </button>
                            </form>
                            
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <script>
            document.querySelectorAll('.editBtn').forEach(button => {
                button.addEventListener('click', function() {
                    const subContractId = this.getAttribute('data-id');
                    fetch(`/get-contract-info/${subContractId}`)
                        .then(response => response.json())
                        .then(data => {
                          
                            document.querySelector('.form_sub input[name="contract_number"]').value = data.contract_number;
                            document.querySelector('.form_sub input[name="contract_date"]').value = data.contract_date;
                            document.querySelector('.form_sub input[name="san_pham"]').value = data.san_pham;
                            document.querySelector('.form_sub input[name="loai_pallet"]').value = data.loai_pallet;
                            document.querySelector('.form_sub input[name="thi_truong"]').value = data.thi_truong;
                            document.querySelector('.form_sub input[name="don_vi_xuat_thuong_mai"]').value = data.don_vi_xuat_thuong_mai;
                            document.querySelector('.form_sub input[name="ban_cho_ben_thu_3"]').value = data.ban_cho_ben_thu_3;
                            document.querySelector('.form_sub input[name="count_contract"]').value = data.count_contract;
                            document.querySelector('.form_sub select[name="contract_type_id"]').value = data.contract_type_id;
                            document.querySelector('.form_sub select[name="customer_id"]').value = data.customer_id;

                          
                            document.querySelector('.form_sub').action = `/sub-con/${subContractId}`;
                            document.querySelector('input[name="_method"]').value = 'PUT';

                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });
        </script>


        <div class="buttons my-3">
            <button type="button" class="add-sub btn btn-warning" data-toggle="modal" data-target="#subContractModal">
                Thêm phụ lục
            </button>
        </div>

        <hr>

        <!-- Modal -->
        <div class="modal fade" id="subContractModal" tabindex="-1" aria-labelledby="subContractModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="subContractModalLabel">Cập nhật phụ lục</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                    <div class="modal-body">
                        <form action="{{ route('sub-con.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="hd_goc_so" value="{{$contract->contract_number}}">
                                <div class="mb-3 col-lg-6">

                                    <label class="form-label">Loại hợp đồng</label>

                                    <select name="contract_type_id" class="form-select w-100">
                                        @foreach ($types as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">Khách hàng</label>
                                    <select name="customer_id" class="form-select w-100">
                                        @foreach ($customers as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">Số hợp đồng</label>
                                    <input type="text" name="contract_number" class="form-control" required>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">Ngày hợp đồng</label>
                                    <input type="date" name="contract_date" class="form-control" required>
                                </div>

                                {{-- <div class="mb-3 col-lg-6">
                                    <label class="form-label">Tháng giao hàng</label>
                                    <select name="thang_giao_hang" class="form-select w-100">
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

                                <div class="mb-3 col-lg-6">
                                    <label class="form-label" >Năm giao hàng</label>
                                    <input type="text" name="san_pham" class="form-control" required value="{{$contract->nam_giao_hang}}">
                                </div> --}}

                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">Sản phẩm/ Lot</label>
                                    <input type="text" name="san_pham" class="form-control" required >
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">Loại Pallet</label>
                                    <input type="text" name="loai_pallet" class="form-control" required >
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">Thị trường</label>
                                    <input type="text" name="thi_truong" class="form-control" required >
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">Đơn vị Sản xuất/ Thương mại</label>
                                    <input type="text" name="don_vi_xuat_thuong_mai" class="form-control" required >
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">Bán cho bên thứ 3</label>
                                    <input type="text" name="ban_cho_ben_thu_3" class="form-control" required >
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">Số lượng hợp đồng (tấn)</label>
                                    <input type="number" name="count_contract" class="form-control" required >
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">File hợp đồng đính kèm</label>
                                    <input type="file" name="file_scan_pdf" class="form-control" >
                                </div>

                                <input type="hidden" name="contract_id" class="form-control" value="{{ $contract->id }}">
                            </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>


        <!-- Modal EDIT -->
        <div class="modal fade" id="subContractModal2" tabindex="-1" aria-labelledby="subContractModalLabel2" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Cập nhật phụ lục</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                    <div class="modal-body">
                        <form action="" method="POST" enctype="multipart/form-data" class="form_sub">
                            @csrf
                             @method('PUT')
                            <div class="row">
                                <input type="hidden" name="hd_goc_so" value="{{$contract->contract_number}}">
                                <div class="mb-3 col-lg-6">

                                    <label class="form-label">Loại hợp đồng</label>

                                    <select name="contract_type_id" class="form-select w-100">
                                        @foreach ($types as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">Khách hàng</label>
                                    <select name="customer_id" class="form-select w-100">
                                        @foreach ($customers as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">Số hợp đồng</label>
                                    <input type="text" name="contract_number" class="form-control" required>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">Ngày hợp đồng</label>
                                    <input type="date" name="contract_date" class="form-control" required>
                                </div>

                                {{-- <div class="mb-3 col-lg-6">
                                    <label class="form-label">Tháng giao hàng</label>
                                    <select name="thang_giao_hang" class="form-select w-100">
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

                                <div class="mb-3 col-lg-6">
                                    <label class="form-label" >Năm giao hàng</label>
                                    <input type="text" name="san_pham" class="form-control" required value="{{$contract->nam_giao_hang}}">
                                </div> --}}

                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">Sản phẩm/ Lot</label>
                                    <input type="text" name="san_pham" class="form-control" required >
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">Loại Pallet</label>
                                    <input type="text" name="loai_pallet" class="form-control" required >
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">Thị trường</label>
                                    <input type="text" name="thi_truong" class="form-control" required >
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">Đơn vị Sản xuất/ Thương mại</label>
                                    <input type="text" name="don_vi_xuat_thuong_mai" class="form-control" required >
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">Bán cho bên thứ 3</label>
                                    <input type="text" name="ban_cho_ben_thu_3" class="form-control" required>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">Số lượng hợp đồng (tấn)</label>
                                    <input type="number" name="count_contract" class="form-control" required >
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label class="form-label">File hợp đồng đính kèm</label>
                                    <input type="file" name="file_scan_pdf" class="form-control" >
                                </div>

                                <input type="hidden" name="contract_id" class="form-control" value="{{ $contract->id }}">
                            </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>


             <div class="shipment-info">
                <div class="shipment-title fw-bold text-dark fs-4 mt-3">
                    Lệnh xuất hàng
                </div>

                @if ($contract->shipments->count() == 0)
                    <div class="text-danger">Chưa có dữ liệu.</div>
                @else

                    {{-- {{$contract->shipments}} --}}
                    @foreach ($contract->shipments as $index => $item)
                        <div class="row shipment my-3">
                            <div class="col-lg-3 mb-3">
                                <div class="">
                                    <div class="mb-2 fw-bold text-dark fs-5">Lần {{$index + 1}}</div>
                                    <ul class="mb-0 p-0" style="list-style: none">
                                        <li>
                                            Số hợp đồng
                                            <input type="text" class="form-control" data-id="{{$item->id}}" readonly data-field="so_hop_dong" value="{{$item->contract->contract_number}}" onchange="updateShipmentFields(this)">
                                        </li>

                                        <div class="row">
                                            <div class="col-lg-6">
                                                 <li>
                                                    Số tấn
                                                    <input type="number" class="form-control" readonly data-id="{{$item->id}}" data-field="so_luong" value="{{$item->so_luong}}" onchange="updateShipmentFields(this)">
                                                </li>
                                            </div>
                                            <div class="col-lg-6">
                                                <li>
                                                    Ngày đóng cont: 
                                                    <input type="date" class="form-control" data-id="{{$item->id}}" data-field="ngay_dong_cont" value="{{$item->ngay_dong_cont}}" onchange="updateShipmentFields(this)">
                                                </li>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <li>
                                                    Ngày xuất hàng: 
                                                    <input type="date" class="form-control" data-id="{{$item->id}}" data-field="ngay_xuat" value="{{$item->ngay_xuat}}" onchange="updateShipmentFields(this)">
                                                </li>
                                            </div>
                                            <div class="col-lg-6">
                                                 <li>
                                                    Ngày nhận hàng: 
                                                    <input type="date" class="form-control" data-id="{{$item->id}}" data-field="ngay_nhan_hang" value="{{$item->ngay_nhan_hang}}" onchange="updateShipmentFields(this)">
                                                </li>
                                            </div>
                                           
                                        </div>

                                        <li>
                                            Lệnh xuất hàng: 
                                            <input type="text" class="form-control" data-id="{{$item->id}}" data-field="ma_xuat" value="{{$item->ma_xuat}}" onchange="updateShipmentFields(this)">
                                        </li>

                                        <li>
                                            File đính kèm: 
                                            <input type="file" class="form-control shipment-file" accept="application/pdf" data-id="{{$item->id}}" onchange="updateShipmentFields(this)">
                                            @if ($item->pdf)
                                                <a href="/contract_orders/{{$item->pdf}}" target="_blank" class="btn btn-success my-2">Xem file đính kèm</a>
                                            @else
                                                <span class="text-danger">Chưa có file</span>
                                            @endif
                                        </li>
                                    </ul>

                                     <div>
                                        <div class="fw-bold">Trạng thái:</div>
                                        <select class="form-select w-100" data-id="{{$item->id}}" onchange="saveNote(this)">
                                            <option value="0" {{$item->customer_status == 0 ? 'selected' : ''}}>Chưa xuất kho</option>
                                            <option value="1" {{$item->customer_status == 1 ? 'selected' : ''}}>Đã xuất kho</option>
                                            <option value="2" {{$item->customer_status == 2 ? 'selected' : ''}}>Đã thông quan</option>
                                            <option value="3" {{$item->customer_status == 3 ? 'selected' : ''}}>Đến kho khách hàng</option>
                                            <option value="4" {{$item->customer_status == 4 ? 'selected' : ''}}>Hoàn thành</option>
                                        </select>
                                    </div>
                                <div class="fw-bold mt-2">Ghi chú:</div>
                                <textarea class="note form-control" rows="4" data-id="{{$item->id}}" onblur="saveNote(this)" placeholder="Thêm ghi chú">{{$item->note}}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-9 mb-3">
                                <div class="">
                                    <div class="mb-2 fw-bold text-dark fs-5">Lô hàng</div>
                                    <div class="batches">
                                        @if($item->lo_hang)
                                            @foreach (array_column(json_decode($item->lo_hang, true), 'batch_id') as $batch)
                                                <button class="btn btn-dark mb-2" style="font-size:13px">{{ $batch }}</button>
                                               
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 mb-3">
                               
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

                    .shipment input:read-only{
                        background: white !important;
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