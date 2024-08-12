@if ($errors->any())
    <div class="alert alert-danger">
        Vui lòng kiểm tra lại
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
