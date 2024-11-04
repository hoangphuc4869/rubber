@extends('layouts.myapp')

@section('content')
<div class="row">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Hợp đồng /</span> Khách hàng</h4>
    @include('partials.errors')
    <div class="sync-data my-3 d-flex justify-content-end align-items-center">
        <a href="{{route('customers.create')}}">
            <button class="btn btn-dark">
                Thêm khách hàng mới
            </button>
        </a>
    </div>   


    <div class="filter-date d-flex align-items-end justify-content-between gap-2 px-0">
        <div class="d-flex justify-content-between align-items-center">
            <div class="filter-section  d-flex align-items-end gap-2 my-2">
                <div class="">
                    <label for="companyFilterCustomer" class="" style="font-size: 14px">Công ty</label>
                     <select name="companyFilterCustomer" id="companyFilterCustomer" class="form-select" style="width: 100px">
                        <option value="">Tất cả</option>
                        @if (Gate::allows('admin')  || Gate::allows('contractBHCK'))
                            <option value="BHCK">BHCK</option>
                        @endif
                        @if (Gate::allows('admin')  || Gate::allows('contractCRCK2'))
                            <option value="CRCK2">CRCK2</option>
                        @endif
                        
                    </select>
                </div>

                <div class="">
                    <label for="typeFilterCustomer" style="font-size: 14px">Loại KH</label>
                    <select name="typeFilterCustomer" id="typeFilterCustomer" class="form-select">
                            <option value="">Không</option>
                            <option value="KH Ngắn hạn">KH ngắn hạn</option>
                            <option value="KH Dài hạn">KH dài hạn</option>       
                    </select>
                </div>

                <button id="btnCustomerFilter" class="btn btn-primary">Lọc</button>
            </div>
        </div>
    </div>

    <table id="customerTable" class="ui celled table" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên công ty</th>
                <th>Mô tả</th>
                <th>SĐT</th>
                <th>Email</th>
                <th>Công ty</th>
                <th>Loại</th>
                <th>Tùy chỉnh</th>
            </tr>
        </thead>
    </table>
</div>


<style>

        #customerTable th,
        #customerTable td {
            min-width: 90px;
            max-width: unset;
            text-align: center;
        },
       

    </style>

@endsection
