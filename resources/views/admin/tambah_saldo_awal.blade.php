@extends('layouts.admin')

@section('content')
    <div class="page-title">
        Tambah Saldo Awal
    </div>
    <div class="breadcrumbs">      
        <ul class="breadcrumb">
            <li>
                <i class="fa fa-home home-icon"></i>
                <a href="{{ url('admin/home') }}">Home</a>
            </li>
            <li>
                <a href="{{ url('admin/saldo_awal') }}">Saldo Awal</a>
            </li>
            <li class="active">Tambah Saldo Awal</li>
        </ul><!-- /.breadcrumb -->
    </div>
    
    <div class="main-content">
        <div class="container">
            @if ($errors->any())
                <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                </div><br />
            @endif
            <form action="{{ route('sawal.store') }}" method="post">
                <div class="row p-2">
                    <div class="col-md-11">
                        @csrf
                        <div class="form-group row">
                            <label for="account" class="col-md-2 col-form-label">Account <span class="label-req">*<span></label>
                            <div class="col-md-7">
                                <select class="form-control" id="account" name="account" data-placeholder="Pilih Account" style="width:100%" required>
                                    @foreach($acc_list as $al)
                                    <option value="{{$al->id}}">{{$al->kode}} - {{$al->nama}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="dk" class="col-md-2 col-form-label">Debet / Kredit</label>
                            <div class="col-md-2">
                                <select class="form-control" id="dk" name="dk" data-placeholder="Pilih D/K" style="width:100%" required>
                                    <option value="D">Debet</option>
                                    <option value="K">Kredit</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nilai" class="col-md-2 col-form-label">Nilai</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="nilai" name="nilai" maxlength="100" value="">
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="row text-center mb-2">
                    <div class="col-md-12">
                        <hr>
                        <button type="submit" class="btn btn-success"> Simpan</button> 
                        <a href="{{ route('sawal.index') }}" class="btn btn-danger"> Batal</a>
                    </div>
                </div>              
            </form>      
        </div>
    </div>    
    @include('layouts.footer')      
@endsection