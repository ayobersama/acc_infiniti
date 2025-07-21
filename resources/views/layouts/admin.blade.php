<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Accounting</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon1.png')}}">
    <link rel="stylesheet" href="{{ asset('plug-ins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plug-ins/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plug-ins/datepicker/datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plug-ins/DataTables/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plug-ins/FileUpload/bootstrap-fileupload.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=5') }}">    
</head>
<body>
    <!-- header begin-->
    <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('home_admin') }}" style="color:#444 !important;font-size:24px"><img src=" {{ asset('images/logo_header.png') }}" height="35px">  PT. INFINITI JAYA PACIFIC</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>        
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"> 
                    @if (Auth::guard('admin')->user()->foto!='')
                        <img class="user-avatar" src="{{ asset('images/karyawan'.Auth::guard('admin')->user()->foto) }}" alt="foto" height="40px"> {{ Auth::guard('admin')->user()->nama }}
                    @else    
                        <img class="user-avatar" src="{{ asset('images/no_avatar.png') }}" alt="foto" height="40px"> {{ Auth::guard('admin')->user()->nama }}
                    @endif    
                </li>  
           </ul>
        </div>    
    </nav>

    <!-- header end-->
    <main>
        <!-- sidebar begin-->
        <nav class="side-bar">
            <ul> 
                @if ($menu=="dashboard") 
                    <li class="active">
                @else
                   <li>
                @endif
                <a class="nav-link" href="{{ route('home_admin') }}">
                <i class="fa fa-tachometer"></i>  <span class="menu-label">Dashboard</span></a></li>

                @php
                   $terlihat1=app('App\Http\Controllers\Admin\AuthAdminController')->ada_menu('RELASI');
                   $terlihat2=app('App\Http\Controllers\Admin\AuthAdminController')->ada_menu('ACCOUNT');
                   $terlihat3=app('App\Http\Controllers\Admin\AuthAdminController')->ada_menu('NOURUT');
                   $terlihat4=app('App\Http\Controllers\Admin\AuthAdminController')->ada_menu('USER');
                @endphp
                <div id="sidebar-container" class="sidebar-expanded d-none d-md-block">
                    <ul class="list-group">
                        <a href="#submenu1" data-toggle="collapse" aria-expanded="false" style="padding-left:15px"
                            class="sidebar-grup list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-start align-items-center">
                                <span class="fa fa-folder-open-o mr-2"></span>
                                <span class="menu-collapsed">Master</span>
                                <span class="submenu-icon ml-auto"><i class="fa fa-caret-down"></i></span>
                            </div>
                        </a>
                        <!-- Submenu content -->  
                        <div id='submenu1' class="@if(!(($menu=="relasi")||($menu=="account")||($menu=="nourut")||($menu=="user"))) collapse @endif sidebar-submenu" style="font-size:15px">
                            @if($terlihat1)
                                @if ($menu=="relasi") 
                                    <li class="active">
                                @else
                                    <li>
                                @endif
                                <a class="nav-link" href="{{ url('admin/relasi') }}">
                                <i class="fa fa-users"></i> <span class="menu-label">Relasi</span></a></li>
                            @endif

                            @if($terlihat2)
                                @if ($menu=="account") 
                                    <li class="active">
                                @else
                                    <li>
                                @endif
                                <a class="nav-link" href="{{ url('admin/account') }}">
                                <i class="fa fa-empire"></i> <span class="menu-label">Account</span></a></li>
                            @endif

                            @if($terlihat3)
                                @if ($menu=="nourut") 
                                    <li class="active">
                                @else
                                    <li>
                                @endif
                                <a class="nav-link" href="{{ url('admin/nourut') }}">
                                <i class="fa fa-sort-numeric-asc "></i> <span class="menu-label">No Urut</span></a></li>
                            @endif

                            @if($terlihat4)
                                @if ($menu=="user") 
                                    <li class="active">
                                @else
                                    <li>
                                @endif
                                <a class="nav-link" href="{{ url('admin/user') }}">
                                <i class="fa fa-user"></i> <span class="menu-label">User</span></a></li>
                            @endif    
        
                        </div>
                    </ul>
                </div>    

                @php
                    $terlihat=app('App\Http\Controllers\Admin\AuthAdminController')->ada_menu('SAWAL');
                @endphp
                @if($terlihat)
                    @if ($menu=="sawal") 
                        <li class="active">
                    @else
                        <li>
                    @endif
                    <a class="nav-link" href="{{ url('admin/sawal') }}">
                    <i class="fa fa-font-awesome "></i> <span class="menu-label">Saldo Awal</span></a></li>
                @endif

                @php
                  $terlihat=app('App\Http\Controllers\Admin\AuthAdminController')->ada_menu('KASM');
                @endphp
                @if($terlihat)
                    @if ($menu=="kasm") 
                        <li class="active">
                    @else
                        <li>
                    @endif
                    <a class="nav-link" href="{{ url('admin/kasm') }}">
                    <i class="fa fa-arrow-circle-left"></i> <span class="menu-label">Kas Masuk</span></a></li>
                @endif

                @php
                  $terlihat=app('App\Http\Controllers\Admin\AuthAdminController')->ada_menu('KASK');
                @endphp
                @if($terlihat)
                    @if ($menu=="kask") 
                        <li class="active">
                    @else
                        <li>
                    @endif
                    <a class="nav-link" href="{{ url('admin/kask') }}">
                    <i class="fa fa-arrow-circle-right"></i> <span class="menu-label">Kas Keluar</span></a></li>
                @endif

                @php
                    $terlihat=app('App\Http\Controllers\Admin\AuthAdminController')->ada_menu('BANKM');
                @endphp
                @if($terlihat)
                    @if ($menu=="bankm") 
                        <li class="active">
                    @else
                        <li>
                    @endif
                    <a class="nav-link" href="{{ url('admin/bankm') }}">
                    <i class="fa fa-caret-square-o-left"></i> <span class="menu-label">Bank Masuk</span></a></li>
                @endif

                @php
                    $terlihat=app('App\Http\Controllers\Admin\AuthAdminController')->ada_menu('BANKK');
                @endphp
                @if($terlihat)
                    @if ($menu=="bankk") 
                        <li class="active">
                    @else
                        <li>
                    @endif
                    <a class="nav-link" href="{{ url('admin/bankk') }}">
                    <i class="fa fa-caret-square-o-right"></i> <span class="menu-label">Bank Keluar</span></a></li>
                @endif


                @php
                    $terlihat=app('App\Http\Controllers\Admin\AuthAdminController')->ada_menu('JURUM');
                @endphp
                @if($terlihat)
                    @if ($menu=="jurum") 
                        <li class="active">
                    @else
                        <li>
                    @endif
                    <a class="nav-link" href="{{ url('admin/jurum') }}">
                    <i class="fa fa-list-alt"></i> <span class="menu-label">Jurnal Umum</span></a></li>
                @endif
               
                @php
                    $terlihat1=app('App\Http\Controllers\Admin\AuthAdminController')->ada_menu('LKASH');
                    $terlihat2=app('App\Http\Controllers\Admin\AuthAdminController')->ada_menu('LBANKH');
                    $terlihat3=app('App\Http\Controllers\Admin\AuthAdminController')->ada_menu('LBUKUB');
                    $terlihat4=app('App\Http\Controllers\Admin\AuthAdminController')->ada_menu('LRBUKUB');
                    $terlihat5=app('App\Http\Controllers\Admin\AuthAdminController')->ada_menu('LNERACA');
                    $terlihat6=app('App\Http\Controllers\Admin\AuthAdminController')->ada_menu('LLABARUGI');
                @endphp
                <div id="sidebar-container" class="sidebar-expanded d-none d-md-block">
                    <ul class="list-group">
                        <a href="#submenu2" data-toggle="collapse" aria-expanded="false" style="padding-left:15px"
                            class="sidebar-grup list-group-item list-group-item-action flex-column align-items-start">
                            <div class="d-flex w-100 justify-content-start align-items-center">
                                <span class="fa fa-folder-open-o mr-2"></span>
                                <span class="menu-collapsed">Laporan</span>
                                <span class="submenu-icon ml-auto"><i class="fa fa-caret-down"></i></span>
                            </div>
                        </a>
                        <!-- Submenu content -->  
                        <div id='submenu2' class="@if(!(($menu=="lap_kas_harian")||($menu=="lap_bank_harian")||($menu=="lap_buku_besar")||($menu=="lap_rekap_buku_besar")
                                                 ||($menu=="lap_neraca")||($menu=="lap_laba_rugi"))) collapse @endif sidebar-submenu" style="font-size:15px">
                            @if($terlihat1)
                            <li class="@if($menu=='lap_kas_harian') active @endif">
                                <a href="{{ url('admin/lap_kas_harian') }}" class="nav-link" style="font-size:15px">
                                    <span class="fa fa-file-text-o ml-2 mr-2"></span>
                                    <span class="menu-label">Kas Harian</span>
                                </a>
                            </li>
                            @endif

                            @if($terlihat2)
                            <li class="@if($menu=='lap_bank_harian') active @endif">
                                <a href="{{ url('admin/lap_bank_harian') }}" class="nav-link" style="font-size:15px">
                                    <span class="fa fa-file-text-o ml-2 mr-2"></span>
                                    <span class="menu-label">Bank Harian</span>
                                </a>
                            </li>
                            @endif

                            @if($terlihat3)
                            <li class="@if($menu=='lap_buku_besar') active @endif">
                                <a href="{{ url('admin/lap_buku_besar') }}" class="nav-link" style="font-size:15px">
                                    <span class="fa fa-file-text-o ml-2 mr-2"></span>
                                    <span class="menu-label">Buku Besar</span>
                                </a>
                            </li>
                            @endif

                            @if($terlihat4)
                             <li class="@if($menu=='lap_rekap_buku_besar') active @endif">
                                <a href="{{ url('admin/lap_rekap_buku_besar') }}" class="nav-link" style="font-size:15px">
                                    <span class="fa fa-file-text-o ml-2 mr-2"></span>
                                    <span class="menu-label">Rekap Buku besar</span>
                                </a>
                            </li>
                            @endif

                            @if($terlihat5)
                            <li class="@if($menu=='lap_neraca') active @endif">
                                <a href="{{ url('admin/lap_neraca') }}" class="nav-link" style="font-size:15px">
                                    <span class="fa fa-file-text-o ml-2 mr-2"></span>
                                    <span class="menu-label">Neraca</span>
                                </a>
                            </li>
                            @endif

                            @if($terlihat6)
                            <li class="@if($menu=='lap_laba_rugi') active @endif">
                                <a href="{{ url('admin/lap_laba_rugi') }}" class="nav-link" style="font-size:15px">
                                    <span class="fa fa-file-text-o ml-2 mr-2"></span>
                                    <span class="menu-label">Laba Rugi</span>
                                </a>
                            </li>
                            @endif
                        </div>
                    </ul>
                </div>    
                
                <li>
                    <a class="nav-link" href="{{ url('/admin/logout') }}">
                    <i class="fa fa-sign-out"></i> <span class="menu-label">Logout</span></a>
                </li>
              </ul>
        </nav>
        <!-- sidebar end-->
        
        <!-- main content begin-->
        <section class="page-content">
            @yield('content')     
        </section>
        <!-- main content end -->
    </main>

    <!-- java script -->
    <script src=" {{ asset('plug-ins/jquery/jquery-3.5.1.min.js') }} "></script>
    <script src=" {{ asset('plug-ins/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
    <script src=" {{ asset('plug-ins/datepicker/datepicker.min.js') }} "></script>
    <script src=" {{ asset('plug-ins/DataTables/js/jquery.dataTables.min.js') }} "></script>
    <script src=" {{ asset('plug-ins/DataTables/js/dataTables.bootstrap4.min.js') }} "></script>
    <script src=" {{ asset('plug-ins/ckeditor/ckeditor.js') }}"></script>
    <script src=" {{ asset('plug-ins/FileUpload/bootstrap-fileupload.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @stack('js')
</script>
    <script>
        $(document).ready(function() {
            $('.date-picker').datepicker({
                autoclose: true,
                todayHighlight: true
            })
            $('#grid').DataTable();
            $('#grid2').DataTable();
            $('#grid3').DataTable();
        } );
    </script>
</body>
</html>