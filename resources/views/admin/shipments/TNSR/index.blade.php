@extends('layouts.myapp')

@section('content')


   <div class="d-flex gap-2 justify-content-between align-items-center flex-wrap">
        <h4 class="fw-bold my-4">Yêu cầu xuất hàng - {{$companyName}}</h4>

        <div class="">
           <!-- Nút kích hoạt modal -->
<button class="btn btn-info" id="tnsr_export" data-bs-toggle="modal" data-bs-target="#exportModal">
  Thêm lệnh xuất hàng
</button>

<!-- Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exportModalLabel">Thêm Lệnh Xuất Hàng</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Sử dụng Grid Bootstrap -->
        <form id="exportForm" action="{{route('shipments.tnsr')}}"  method="POST" enctype="multipart/form-data">
            @csrf
          <div class="row">
            <!-- Cột 1 -->
            <div class="col-lg-6">
              <div class="mb-3">
                <label for="exportCode" class="form-label">Mã Xuất</label>
                <input type="text" class="form-control" id="exportCode" name="ngay_xuat" required>
              </div>
              <div class="mb-3">
                <label for="itemType" class="form-label">Loại Hàng</label>
                <input type="text" class="form-control" id="itemType" name="loai_hang" required>
              </div>
              <div class="mb-3">
                <label for="quantity" class="form-label">Số Lượng</label>
                <input type="number" class="form-control" id="quantity" name="so_luong" required>
              </div>
              
            </div>

            <!-- Cột 2 -->
            <div class="col-lg-6">
                <div class="mb-3">
                    <label for="exportDate" class="form-label">Ngày Xuất</label>
                    <input type="date" class="form-control" id="exportDate" name="ngay_xuat" required>
                </div>
              <div class="mb-3">
                <label for="receiveDate" class="form-label">Ngày nhận hàng</label>
                <input type="date" class="form-control" id="receiveDate" name="ngay_nhan_hang" required>
              </div>
              
              <div class="mb-3">
                <label for="pdf" class="form-label">Tệp PDF</label>
                <input type="file" class="form-control" id="pdf" name="pdf" accept="application/pdf">
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
        <button type="submit" form="exportForm" class="btn btn-primary">Lưu</button>
      </div>
    </div>
  </div>
</div>

           

        </div>
   </div>

    <table id="dataOrder" class="ui celled table" style="width:100%">
        <thead>
            <tr>
                <th>Ngày</th>
                {{-- <th>Mã lệnh</th> --}}
                <th>Loại hàng</th>
                <th>Khách hàng</th>
                <th>Số lượng</th>
                <th>Mã lô</th>
                <th>Trạng thái</th>
                <th>Tùy chỉnh</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($shipments as $index => $ship)

                <tr id={{$ship->id}}>
                    <td data-sort="{{$ship->ngay_xuat}}">{{\Carbon\Carbon::parse($ship->ngay_xuat)->format('d/m/Y')}}</td>
                    {{-- <td>{{$ship->ma_xuat}}</td> --}}
                    <td>{{$ship->loai_hang}}</td>
                    <td>TNSR</td>
                    <td>{{$ship->so_luong}}</td>
                     <td>
                        @if($ship->lo_hang)
                            @php
                                $batches = json_decode($ship->lo_hang, true);
                            @endphp

                            <div>
                                @foreach($batches as $index => $item)
                                    @if ($index < 3)
                                        {{ $item['batch_id'] }}
                                        @if ($index == 2 && count($batches) > 3)
                                            ...
                                        @elseif ($index < 2)
                                            ,
                                        @endif
                                    @else
                                        @break
                                    @endif
                                @endforeach
                                <i class="fa fa-copy cursor-pointer" onclick="copyToClipboard('{{ implode(', ', array_column($batches, 'batch_id')) }}')"></i>
                            </div>
                            <script>
                                function copyToClipboard(text) {
                                    navigator.clipboard.writeText(text).then(() => {
                                        alert("Đã sao chép!");
                                    }).catch(err => {
                                        console.error("Không thể sao chép:", err);
                                    });
                                }
                            </script>
                        @endif
                        </td>
                    <td>{!!$ship->status == 0 ? '<span class="text-danger">Chưa xuất hàng<span>' : '<span class="text-success">Đã xuất hàng<span>'!!}</td>
                    <td>
                        @if ($ship->status == 0)
                            <a href="{{route('shipmentsTNSR.edit', [$ship->id])}}">
                                <button class="btn btn-warning">Xuất hàng</button>
                            </a>
                        @endif
                    </td> 
                   
                </tr>
            @endforeach
        </tbody>
    </table>
            

@endsection



