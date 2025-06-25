@extends('layouts.admin')

@section('content')
    <div class="breadcrumbs">      
        <ul class="breadcrumb">
            <li style="padding-top:5px">
               <i class="fa fa-dashboard home-icon"></i> Dashboard
            </li>
        </ul><!-- /.breadcrumb -->
    </div>
    
    <div class="main-content">
            <div class="container">
            <div class="row">
                <div class="col-md-12">
                    Selamat Datang Admin
                </div>
            </div>
        </div>
    </div>    
    @include('layouts.footer')      
@endsection