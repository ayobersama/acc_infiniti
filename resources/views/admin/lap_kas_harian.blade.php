@extends('layouts.admin')

@section('content')
    <div class="page-title">
        Laporan Kas Harian
    </div>
    <div class="breadcrumbs">      
        <ul class="breadcrumb">
            <li>
                <i class="fa fa-home home-icon"></i>
                <a href="{{ url('admin/home') }}">Home</a>
            </li>
           <li class="active">Laporan Kas Harian</li>
        </ul><!-- /.breadcrumb -->
    </div>
    
    <div class="main-content">
        <div class="container">
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show warning-area" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)               
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                </div><br />
            @endif
            <form action="{{ url('admin/cetak_lap_kas_harian') }}" method="post">
                <div class="row">
                    <div class="col-md-10">
                        @csrf
                        <div class="form-group row">
                            <label for="tgl1" class="col-md-2 col-form-label">Dari Tanggal <span class="label-req"><span></label>
                            <div class="col-md-3">
                                <input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" id="tgl1" name="tgl1" maxlength="12" value="{{date('d-m-Y')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tgl2" class="col-md-2 col-form-label">Sampai Tanggal <span class="label-req"><span></label>
                            <div class="col-md-3">
                                <input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" id="tgl2" name="tgl2" maxlength="12" value="{{date('d-m-Y')}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kas" class="col-md-2 col-form-label">Kas</label>
                            <div class="col-md-4">
                                <select class="form-control" id="kas" name="kas" data-placeholder="Pilih Kas" style="width:100%" required>
                                    @foreach($kas_list as $al)
                                    <option value="{{$al->id}}">{{$al->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="row text-center mb-2">
                    <div class="col-md-12">
                        <hr>
                        <button type="submit" class="btn btn-success"> Preview</button> 
                    </div>
                </div>              
            </form>      
        </div>
    </div>    
    @include('layouts.footer')      
@endsection
