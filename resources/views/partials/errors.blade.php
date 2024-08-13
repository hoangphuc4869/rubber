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

@if (session('delete_success'))
    <div class="alert alert-success">
        {{ session('delete_success') }}
    </div>
@endif
