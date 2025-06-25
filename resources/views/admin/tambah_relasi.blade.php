@extends('layouts.admin')

@section('content')
    <div class="page-title">
        Tambah Relasi
    </div>
    <div class="breadcrumbs">      
        <ul class="breadcrumb">
            <li>
                <i class="fa fa-home home-icon"></i>
                <a href="{{ url('admin/home') }}">Home</a>
            </li>
            <li>
                <a href="{{ url('admin/relasi') }}">Relasi</a>
            </li>
            <li class="active">Tambah Relasi</li>
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
            <form action="{{ route('relasi.store') }}" method="post">
                <div class="row p-2">
                    <div class="col-md-11">
                        @csrf
                        <div class="form-group row">
                            <label for="nama" class="col-md-3 col-form-label">Nama Relasi <span class="label-req">*<span></label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="nama" name="nama" maxlength="50" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-md-3 col-form-label">Alamat</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="alamat" name="alamat" maxlength="100" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kota" class="col-md-3 col-form-label">Keterangan</label>
                            <div class="col-md-7">
                                <textarea class="form-control" id="ket" name="ket" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="row text-center mb-2">
                    <div class="col-md-12">
                        <hr>
                        <button type="submit" class="btn btn-success"> Simpan</button> 
                        <a href="{{ route('relasi.index') }}" class="btn btn-danger"> Batal</a>
                    </div>
                </div>              
            </form>      
        </div>
    </div>    
    @include('layouts.footer')      
@endsection