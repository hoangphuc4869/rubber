@extends('layouts.myapp')

@section('content')
<div class="container">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Phân quyền /</span> Quản lý người dùng</h4>

    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Thêm người dùng</h5>
                </div>
                <div class="card-body">
                    @include('partials.errors')
                    
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ tên</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Mật khẩu</label>
                            </div>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password" aria-describedby="password">
                                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="roles" class="form-label">Vai trò</label>
                            <div class="row">
                                @foreach ($roles as $index => $role)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="role-{{$index}}" name="roles[]" value="{{ $role->id }}">
                                            <label class="form-check-label" for="role-{{$index}}"> {{$role->name}} </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- <div class="mb-3">
                            <label class="form-label" for="basic-default-fullname">Mã nhà ủ</label>
                            <input type="text" id="code" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" placeholder="Nx NUx">
                            @error('code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="basic-default-company">Tên nhà ủ</label>
                            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Nhà ủ 1">
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div> --}}
                        
                        <button type="submit" class="btn btn-primary mt-3">Thêm</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            @if (session('delete_success'))
                <div class="alert alert-success">
                    {{ session('delete_success') }}
                </div>
            @endif
            <table id="datalist" class="ui celled table" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên người dùng</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Tùy chỉnh</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            {{ implode(', ', $user->roles->pluck('name')->toArray()) }}
                        </td>
                        <td>
                        <div class="custom d-flex gap-1">
                            <a href="{{route('users.edit', [$user->id])}}">
                                <button class="editBtn">
                                    <svg height="1em" viewBox="0 0 512 512">
                                        <path
                                        d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z"
                                        ></path>
                                    </svg>
                                </button>
                            </a>

                            <form action="{{route('users.destroy', [$user->id])}}" method="POST" onsubmit="return confirmDelete();">
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

                            
                            

                            </a>
                        </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>
    </div>
</div>
@endsection
