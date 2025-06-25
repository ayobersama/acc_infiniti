@extends('layouts.admin')

@section('content')
    <div class="page-title">
        Tambah Account
    </div>
    <div class="breadcrumbs">      
        <ul class="breadcrumb">
            <li>
                <i class="fa fa-home home-icon"></i>
                <a href="{{ url('admin/home') }}">Home</a>
            </li>
            <li>
                <a href="{{ url('admin/account') }}">Account</a>
            </li>
            <li class="active">Tambah Account</li>
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
            <form action="{{ route('account.store') }}" method="post">
                <div class="row p-2">
                    <div class="col-md-11">
                        @csrf
                        <div class="form-group row">
                            <label for="kode" class="col-md-3 col-form-label">Kode Account <span class="label-req">*<span></label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="kode" name="kode" maxlength="20" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-md-3 col-form-label">Nama Account <span class="label-req">*<span></label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="nama" name="nama" maxlength="60" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="induk" class="col-md-3 col-form-label">Induk <span class="label-req">*<span></label>
                            <div class="col-md-7">
                                <select class="form-control" id="induk" name="induk" data-placeholder="Pilih Induk">
                                    <option value=""></option>
                                    @foreach($induk_list as $dl)
                                    <option value="{{$dl->id}}">{{$dl->kode}} - {{$dl->nama}}</option>
                                    @endforeach
                                </select>    
                            </div>
                        </div>
                        <div class="form-group row"> 
                            <label for="jenis" class="col-md-3 col-form-label">Jenis <span class="label-req">*<span></label>
                            <div class="col-md-2">
                                <select name="header" id="header" class="form-control">
                                    <option value="A">Aktiva</option>
                                    <option value="P">Pasiva</option>
                                    <option value="B">Biaya</option>
                                    <option value="D">Pendapatan</option>
                                </select>    
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-md-3 col-form-label">Kas Bank</label>
                            <div class="col-md-2">
                                <select name="header" id="header" class="form-control">
                                    <option value=""></option>
                                    <option value="K">Kas</option>
                                    <option value="B">Bank</option>
                                </select>    
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="header" class="col-md-3 col-form-label">Header</label>
                            <div class="col-md-2">
                                <select name="header" id="header" class="form-control">
                                    <option value="Y">Ya</option>
                                    <option value="N" selected>Tidak</option>
                                </select>    
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="row text-center mb-2">
                    <div class="col-md-12">
                        <hr>
                        <button type="submit" class="btn btn-success"> Simpan</button> 
                        <a href="{{ route('account.index') }}" class="btn btn-danger"> Batal</a>
                    </div>
                </div>              
            </form>      
        </div>
    </div>    
    @include('layouts.footer')      
@endsection
@push('js')
    <script>    
       $("#induk").select2();	
    </script>
@endpush    