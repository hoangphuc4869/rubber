<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="/sneat-1.0.0/assets/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />
    <meta name="csrf-token" content="{{ csrf_token() }}">  

    <title>Quản lý cao su</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/images/favicon-32x32.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">


    {{-- datatable css --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.css">
   
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.semanticui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/2.0.5/css/select.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/datetime/1.5.3/css/dataTables.dateTime.min.css">

    <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/5.0.1/css/fixedColumns.dataTables.css">

    {{-- select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    
    <link rel="stylesheet" href="/sneat-1.0.0/assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="/FontAwesome6.4Pro/css/all.css">

    <!-- Core CSS -->
    <link rel="stylesheet" href="/sneat-1.0.0/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="/sneat-1.0.0/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="/sneat-1.0.0/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="/sneat-1.0.0/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="/sneat-1.0.0/assets/vendor/libs/apex-charts/apex-charts.css" />

    <link rel="stylesheet" href="/assets/style.css">

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="/sneat-1.0.0/assets/vendor/js/helpers.js"></script>

    <link rel="stylesheet" href="https://js.arcgis.com/4.30/esri/themes/light/main.css" />


    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/sneat-1.0.0/assets/js/config.js"></script>
    
    <script src="/assets/js_modules/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>


    <link rel="stylesheet" href="https://js.arcgis.com/4.30/esri/themes/light/main.css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">



  </head>

  <body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <!-- Menu -->

        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
          <div class="app-brand demo">
            <a href="/" class="app-brand-link d-block mx-auto">
              <div class="">
                <img src="/assets/images/1590726485_logo-VRG.png" alt="" class="w-100 object-fit-cover" style="height: 90px">
                {{-- <div class="app-brand-text demo menu-text fw-bolder ms-2">Sneat</div> --}}
              </div>
            </a>

            <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
              <i class="bx bx-chevron-left bx-sm align-middle"></i>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>

          <ul class="menu-inner py-1">
            <!-- Dashboard -->
            <li class="menu-item {{Route::is('home') ? "active" : ""}}">
              <a href="/" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
              </a>
            </li>
          

            <!-- Components -->
            <li class="menu-header small text-uppercase"><span class="menu-header-text">Quản lý cao su</span></li>


            @if (Gate::allows('nguyenlieu') || Gate::allows('admin') || Gate::allows('DRC'))
                
            <li class="menu-item {{Route::is('farms.*') || Route::is('trucks.*') || Route::is('curing_areas.*') || Route::is('curing_houses.*') || Route::is('companies.*') ? "active open" : ""}}" style="">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons fa-solid fa-tractor"></i>
                <div data-i18n="Layouts">Nông trường</div>
              </a>

              <ul class="menu-sub">
                <li class="menu-item {{Route::is('farms.*') ? "active" : ""}}">
                  <a href="{{route('farms.index')}}" class="menu-link">
                    <div data-i18n="Without navbar">Nông trường</div>
                  </a>
                </li>
                <li class="menu-item {{Route::is('plots.*') ? "active" : ""}}">
                  <a href="{{route('plots.index')}}" class="menu-link">
                    <div data-i18n="Without navbar">Vùng trồng</div>
                  </a>
                </li>
                <li class="menu-item {{Route::is('trucks.*') ? "active" : ""}}">
                  <a href="{{route('trucks.index')}}" class="menu-link">
                    <div data-i18n="Without menu">Xe</div>
                  </a>
                </li>
                <li class="menu-item {{Route::is('curing_areas.*') ? "active" : ""}}">
                  <a href="{{route('curing_areas.index')}}" class="menu-link">
                    <div data-i18n="Container">Bãi ủ</div>
                  </a>
                </li>
                <li class="menu-item {{Route::is('curing_houses.*') ? "active" : ""}}">
                  <a href="{{route('curing_houses.index')}}" class="menu-link">
                    <div data-i18n="Fluid">Nhà ủ</div>
                  </a>
                </li>

                <li class="menu-item {{Route::is('companies.*') ? "active" : ""}}">
                  <a href="{{route('companies.index')}}" class="menu-link">
                    <div data-i18n="Fluid">Công ty</div>
                  </a>
                </li>
        
              </ul>
            </li>
            <li class="menu-item {{Route::is('rubber.*') ? "active" : ""}}">
              <a href="{{route('rubber.index')}}" class="menu-link">
                <i class="menu-icon tf-icons fa-solid fa-book"></i>
                <div data-i18n="Basic">Tiếp nhận NVL</div>
              </a>
            </li>

            @endif


            @if (Gate::allows('canvat') || Gate::allows('admin') || Gate::allows('6t') || Gate::allows('3t') )
            <li class="menu-item {{Route::is('list') || Route::is('rolling.*') || Route::is('machining.*') || Route::is('heat.*') || Route::is('producing.*') || Route::is('batch.*') ? "active open" : ""}}" style="">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons fa-solid fa-gears"></i>
                <div data-i18n="Layouts">Chế biến</div>
              </a>

              <ul class="menu-sub" style="list-style:none">
                @if (Gate::allows('canvat') || Gate::allows('admin'))
                <li class="menu-item  {{Route::is('rolling.*') ? "active" : ""}}">
                  <a href="{{route('rolling.index')}}" class="menu-link">
                    {{-- <i class="menu-icon tf-icons fa-regular fa-paint-roller"></i> --}}
                    <div data-i18n="Basic">Cán vắt</div>
                  </a>
                </li>
                @endif

               @if (Gate::allows('6t') || Gate::allows('admin') || Gate::allows('3t'))
                <li class="menu-item  {{Route::is('machining.*') ? "active" : ""}}">
                  <a href="{{route('machining.index')}}" class="menu-link">
                    {{-- <i class="menu-icon tf-icons fa-regular fa-hammer"></i> --}}
                    <div data-i18n="Basic">Gia công hạt</div>
                  </a>
                </li>
                

               
                <li class="menu-item  {{Route::is('heat.*') ? "active" : ""}}">
                  <a href="{{route('heat.index')}}" class="menu-link">
                    {{-- <i class="menu-icon tf-icons fa-solid fa-fire-flame-curved"></i> --}}
                    <div data-i18n="Basic">Gia công nhiệt</div>
                  </a>
                </li>
                
                

                
                <li class="menu-item  {{Route::is('producing.index') ? "active" : ""}}">
                  <a href="{{route('producing.index')}}" class="menu-link">
                    {{-- <i class="menu-icon tf-icons fa-regular fa-screwdriver-wrench"></i> --}}
                    <div data-i18n="Basic">Ra lò, ép kiện</div>
                  </a>
                </li>
                

                
                <li class="menu-item  {{Route::is('batch.index') ? "active" : ""}}">
                  <a href="{{route('batch.index')}}" class="menu-link">
                    {{-- <i class="menu-icon tf-icons fa-regular fa-cube"></i> --}}
                    <div data-i18n="Basic">Đóng gói</div>
                  </a>
                </li>

                <li class="menu-item  {{Route::is('list') ? "active" : ""}}">
                  <a href="{{route('list')}}" class="menu-link">
                    {{-- <i class="menu-icon tf-icons fa-regular fa-cube"></i> --}}
                    <div data-i18n="Basic">Danh sách lô hàng</div>
                  </a>
                </li>
                @endif
        
              </ul>
            </li>
            @endif
  
            
            {{-- <li class="menu-item
            {{Route::is('warehouse.create') ? "active" : ""}} {{Auth::user()->roles->contains('name', 'Admin') || Auth::user()->roles->contains('name', 'Kho')}} ">
            
              <a href="{{route('warehouse.create')}}" class="menu-link">
                <i class="menu-icon tf-icons fa-solid fa-warehouse"></i>
                <div data-i18n="Basic">Kho hàng</div>
              </a>
            </li> --}}

            @if (Gate::allows('khoBHCK') || Gate::allows('admin'))
            <li class="menu-item {{Route::is('warehouseBHCK') || Route::is('shipments.*')  ? "active open" : ""}}" style="">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons fa-solid fa-warehouse"></i>
                <div data-i18n="Layouts">Kho hàng BHCK</div>
              </a>

              <ul class="menu-sub" style="list-style:none">
                <li class="menu-item {{Route::is('warehouseBHCK') ? "active" : ""}}">
                  <a href="{{route('warehouseBHCK')}}" class="menu-link">
                    {{-- <i class="menu-icon tf-icons fa-regular fa-paint-roller"></i> --}}
                    <div data-i18n="Basic">Nhập kho</div>
                  </a>
                </li>
                <li class="menu-item {{Route::is('shipments.*') ? "active" : ""}}">
                  <a href="{{route('shipments.index')}}" class="menu-link">
                    {{-- <i class="menu-icon tf-icons fa-regular fa-hammer"></i> --}}
                    <div data-i18n="Basic">Xuất kho</div>
                  </a>
                </li>
              </ul>
            </li>
            @endif

            
            


            @if (Gate::allows('khoCRCK2') || Gate::allows('admin'))
            <li class="menu-item {{Route::is('warehouseCRCK2') || Route::is('shipmentsCRCK2.*') ? "active open" : ""}}" style="">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons fa-solid fa-warehouse"></i>
                <div data-i18n="Layouts">Kho hàng CRCK2</div>
              </a>

              <ul class="menu-sub" style="list-style:none">
                <li class="menu-item {{Route::is('warehouseCRCK2') ? "active" : ""}}">
                  <a href="{{route('warehouseCRCK2')}}" class="menu-link">
                    
                    <div data-i18n="Basic">Nhập kho</div>
                  </a>
                </li>
                <li class="menu-item {{ Route::is('shipmentsCRCK2.*') ? "active" : ""}}" >
                  <a href="{{route('shipmentsCRCK2.index')}}" class="menu-link">
                    <div data-i18n="Basic">Xuất kho</div>
                  </a>
                </li>
              </ul>
            </li>
            

            
            <li class="menu-item {{Route::is('warehouseTN') || Route::is('shipmentsTNSR.*')  ? "active open" : ""}}" style="">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons fa-solid fa-warehouse"></i>
                <div data-i18n="Layouts">Kho hàng 6T-TN</div>
              </a>

              <ul class="menu-sub" style="list-style:none">
                <li class="menu-item {{Route::is('warehouseTN') ? "active" : ""}}">
                  <a href="{{route('warehouseTN')}}" class="menu-link">
                    {{-- <i class="menu-icon tf-icons fa-regular fa-paint-roller"></i> --}}
                    <div data-i18n="Basic">Nhập kho</div>
                  </a>
                </li>
                <li class="menu-item {{Route::is('shipmentsTNSR.*') ? "active" : ""}}">
                  <a href="{{route('shipmentsTNSR.index')}}" class="menu-link">
                    {{-- <i class="menu-icon tf-icons fa-regular fa-hammer"></i> --}}
                    <div data-i18n="Basic">Xuất kho</div>
                  </a>
                </li>
              </ul>
            </li>
            @endif


            {{-- <li class="menu-item {{ Route::is('exported-list') ? 'active' : '' }}">
                <a href="{{ route('exported-list') }}" class="menu-link">
                    <i class="menu-icon tf-icons fa-solid fa-list"></i>
                    <div data-i18n="Basic">Danh sách lô đã xuất</div>
                </a>
            </li> --}}

            @if (Gate::allows('contractBHCK') || Gate::allows('admin') || Gate::allows('contractCRCK2') )
            
            <li class="menu-item {{Route::is('customers.*') || Route::is('contract.*') || Route::is('contract-type.*') || Route::is('contractCRCK2.*') ? "active open" : ""}}" style="">
              <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons fa-solid fa-file-contract"></i>
                <div data-i18n="Layouts">Hợp đồng</div>
              </a>

              <ul class="menu-sub" style="list-style:none">
                <li class="menu-item {{Route::is('customers.*') ? "active" : ""}}">
                  <a href="{{route('customers.index')}}" class="menu-link">
                    
                    <div data-i18n="Basic">Khách hàng</div>
                  </a>
                </li>
                <li class="menu-item {{Route::is('contract-type.*') ? "active" : ""}}">
                  <a href="{{route('contract-type.index')}}" class="menu-link">
                    
                    <div data-i18n="Basic">Loại hợp đồng</div>
                  </a>
                </li>
                @if (Gate::allows('contractBHCK') || Gate::allows('admin'))
                <li class="menu-item {{Route::is('contract.*') ? "active" : ""}}">
                  <a href="{{route('contract.index')}}" class="menu-link">
                    
                    <div data-i18n="Basic">Hợp đồng BHCK</div>
                  </a>
                </li>
                 @endif

                @if (Gate::allows('contractCRCK2') || Gate::allows('admin'))
                <li class="menu-item {{Route::is('contractCRCK2.*') ? "active" : ""}}">
                  <a href="{{route('contractCRCK2.index')}}" class="menu-link">
                    <div data-i18n="Basic">Hợp đồng CRCK2</div>
                  </a>
                </li>
                @endif
              </ul>
            </li>

            @endif

            @if (Gate::allows('admin'))
            <li class="menu-item {{Route::is('users.*') ? "active" : ""}}">
              <a href="{{route('users.index')}}" class="menu-link">
                <i class="menu-icon tf-icons fa-solid fa-user"></i>
                <div data-i18n="Basic">Phân quyền</div>
              </a>
            </li>
            @endif

            <li class="menu-item">
              <a href="{{route('export-excel')}}" class="menu-link">
                <i class="menu-icon tf-icons fa-solid fa-file"></i>
                <div data-i18n="Basic">Báo cáo</div>
              </a>
            </li>

            <li class="menu-item">
              <a href="/fill-excel" class="menu-link">
                <i class="menu-icon tf-icons fa-solid fa-file"></i>
                <div data-i18n="Basic">Báo cáo thông kê</div>
              </a>
            </li>

            <li class="menu-item">
              <a href="/find" class="menu-link">
                <i class="menu-icon tf-icons fa-solid fa-file"></i>
                <div data-i18n="Basic">Truy xuất nguồn gốc</div>
              </a>
            </li>


          </ul>
        </aside>
        <!-- / Menu -->

        <!-- Layout container -->
        <div class="layout-page">
          <!-- Navbar -->
          <nav
            class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
            id="layout-navbar"
          >
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
              <!-- Search -->
              <div class="navbar-nav d-block">
                Xin chào, <span class="text-dark fs-4 fw-bold">{{Auth::user()->name}}</span>
              </div>
              <!-- /Search -->
              
              <ul class="navbar-nav flex-row align-items-center ms-auto">
               
                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                      <img src="/assets/images/User-avatar.svg.png" alt class="w-px-40 h-auto rounded-circle" />
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                              <img src="/assets/images/User-avatar.svg.png" alt class="w-px-40 h-auto rounded-circle" />
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <span class="fw-semibold d-block">{{Auth::user()->name}}</span>
                            <small class="text-muted">{{implode(', ', Auth::user()->roles->pluck('name')->toArray())}}</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bx bx-power-off me-2"></i>
                            <span class="align-middle">Log Out</span>
                        </a>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
          </nav>

          <!-- / Navbar -->

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <div class="container my-4 position-relative">
                @yield('content')
            </div>
            <div class="content-backdrop fade"></div>
          </div>
          <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->


    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="/sneat-1.0.0/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="/sneat-1.0.0/assets/vendor/libs/popper/popper.js"></script>
    <script src="/sneat-1.0.0/assets/vendor/js/bootstrap.js"></script>
    <script src="/sneat-1.0.0/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>



    {{-- <script src="https://js.arcgis.com/4.30/"></script> --}}


    {{-- datatable --}}
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.4/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.semanticui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fomantic-ui/2.9.2/semantic.min.js"></script>

    <script src="https://cdn.datatables.net/select/2.0.5/js/dataTables.select.js"></script>
    <script src="https://cdn.datatables.net/select/2.0.5/js/select.dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.1/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.5.3/js/dataTables.dateTime.min.js"></script>

    <script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/dataTables.fixedColumns.js"></script>

    <script src="https://cdn.datatables.net/fixedcolumns/5.0.1/js/fixedColumns.dataTables.js"></script>



    {{-- select2 --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script src="/sneat-1.0.0/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="/sneat-1.0.0/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="/sneat-1.0.0/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="/sneat-1.0.0/assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    

  <script>
    
  </script>
    <script src="/assets/app.js"></script>
    <script src="/assets/js_modules/js/nguyenlieu.js"></script>
    <script src="/assets/js_modules/js/canvat.js"></script>
    <script src="/assets/js_modules/js/giaconghat.js"></script>
    <script src="/assets/js_modules/js/nhiet.js"></script>
    <script src="/assets/js_modules/js/kho.js"></script>
    <script src="/assets/js_modules/js/donggoi.js"></script>
    <script src="/assets/js_modules/js/batch_list.js"></script>


    <script src="https://js.arcgis.com/4.30/"></script>

    <script src="/assets/js_modules/js/map.js"></script>
    
  </body>
</html>
