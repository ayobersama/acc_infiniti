@extends('layouts.admin')

@section('content')
    @php
        $nama_bln=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
    @endphp
    <div class="page-title">
        Laporan Buku Besar
    </div>
    <div class="breadcrumbs">      
        <ul class="breadcrumb">
            <li>
                <i class="fa fa-home home-icon"></i>
                <a href="{{ url('admin/home') }}">Home</a>
            </li>
           <li class="active">Laporan Buku Besar</li>
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
            <form action="{{ url('admin/cetak_buku_besar') }}" method="post">
                <div class="row">
                    <div class="col-md-10">
                        @csrf
                        <div class="form-group row">
                            <label for="bln1" class="col-md-2 col-form-label">Dari Bulan <span class="label-req"><span></label>
                            <div class="col-md-3">
                                <select name="bln1" id="bln1" class="form-control">
                                    @for($i=1;$i<=12;$i++)
                                      <option value="{{$i}}">{{$nama_bln[$i-1]}}</option>
                                    @endfor
                                </select>         
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="bln2" class="col-md-2 col-form-label">Sampai Bulan <span class="label-req"><span></label>
                            <div class="col-md-3">
                                <select name="bln2" id="bln2" class="form-control">
                                    @for($i=1;$i<=12;$i++)
                                      <option value="{{$i}}">{{$nama_bln[$i-1]}}</option>
                                    @endfor
                                </select>       
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="thn" class="col-md-2 col-form-label">Tahun <span class="label-req"><span></label>
                            <div class="col-md-2">
                                @php
                                   $thn_akhir=Date('Y');
                                @endphp
                                <select name="bln2" id="bln2" class="form-control">
                                @for($i=2025;$i<=$thn_akhir;$i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="account" class="col-md-2 col-form-label">Account</label>
                            <div class="col-md-7">
                                <select class="form-control" id="account" name="account" style="width:100%" required>
                                    @foreach($acc_list as $al)
                                    <option value="{{$al->id}}">{{$al->kode}} - {{$al->nama}}</option>
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

@push('js')
    <script>    
    $("#bln1").select2({
           placeholder: "Pilih Bulan"
       });	
    $("#bln2").select2({
           placeholder: "Pilih Bulan"
       });
    $("#thn").select2({
           placeholder: "Tahun"
       });   	   
    $("#account").select2({
           placeholder: "Pilih Account"
       });
    </script>   	
@endpush       