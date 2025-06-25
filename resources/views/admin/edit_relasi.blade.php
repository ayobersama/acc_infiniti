@extends('layouts.admin')

@section('content')
    <div class="page-title">
        Edit Relasi
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
            <li class="active">Edit Relasi</li>
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
            <form action="{{ route('relasi.update', $relasi->id) }}" method="post">
                <div class="row">
                    <div class="col-md-10">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="nama" class="col-md-3 col-form-label">Nama Relasi <span class="label-req">*<span></label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="nama" name="nama" maxlength="50" value="{{ $relasi->nama }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-md-3 col-form-label">Alamat</label>
                            <div class="col-md-7">
                                <input type="text" class="form-control" id="alamat" name="alamat" maxlength="100" value="{{ $relasi->alamat }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kota" class="col-md-3 col-form-label">Keterangan</label>
                            <div class="col-md-7">
                                <textarea class="form-control" id="ket" name="ket" rows="3">{{$relasi->ket}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="aktif" class="col-md-3 col-form-label">Status</label>
                            <div class="col-md-2">
                                <select name="aktif" id="aktif" class="form-control">
                                    <option value="Y" @if($relasi->aktif=="Y") selected="selected" @endif>Ya</option>
                                    <option value="N" @if($relasi->aktif=="N") selected="selected" @endif>Tidak</option>
                                </select>    
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
