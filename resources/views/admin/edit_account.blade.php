@extends('layouts.admin')

@section('content')
    <div class="page-title">
        Edit Account
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
            <li class="active">Edit Account</li>
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
            <form action="{{ route('account.update', $account->id) }}" method="post">
                <div class="row">
                    <div class="col-md-10">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="kode" class="col-md-3 col-form-label">Kode Account <span class="label-req">*<span></label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="kode" name="kode" maxlength="20" value="{{$account->kode}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-md-3 col-form-label">Nama Account <span class="label-req">*<span></label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="nama" name="nama" maxlength="60" value="{{$account->nama}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="induk" class="col-md-3 col-form-label">Induk <span class="label-req">*<span></label>
                            <div class="col-md-8">
                                <select class="form-control" id="induk" name="induk" data-placeholder="Pilih Induk">
                                    <option value=""></option>
                                    @foreach($induk_list as $dl)
                                    <option value="{{$dl->id}}" @if($account->induk==$dl->id) selected="selected" @endif>{{$dl->kode}} - {{$dl->nama}}</option>
                                    @endforeach
                                </select>    
                            </div>
                        </div>
                        <div class="form-group row"> 
                            <label for="jenis" class="col-md-3 col-form-label">Jenis <span class="label-req">*<span></label>
                            <div class="col-md-2">
                                <select name="jenis" id="jenis" class="form-control">
                                    <option value="A" @if($account->jenis=="A") selected="selected" @endif>Aktiva</option>
                                    <option value="P" @if($account->jenis=="P") selected="selected" @endif>Pasiva</option>
                                    <option value="B" @if($account->jenis=="B") selected="selected" @endif>Biaya</option>
                                    <option value="D" @if($account->jenis=="D") selected="selected" @endif>Pendapatan</option>
                                </select>    
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-md-3 col-form-label">Kas Bank </label>
                            <div class="col-md-2">
                                <select name="kb" id="kb" class="form-control">
                                    <option value="" @if($account->kb=="") selected="selected" @endif></option>
                                    <option value="K" @if($account->kb=="K") selected="selected" @endif>Kas</option>
                                    <option value="B" @if($account->kb=="B") selected="selected" @endif>Bank</option>
                                </select>    
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="header" class="col-md-3 col-form-label">Header</label>
                            <div class="col-md-2">
                                <select name="header" id="header" class="form-control">
                                    <option value="Y" @if($account->header=="Y") selected="selected" @endif>Ya</option>
                                    <option value="N" @if($account->header=="N") selected="selected" @endif>Tidak</option>
                                </select>    
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="aktif" class="col-md-3 col-form-label">Status</label>
                            <div class="col-md-2">
                                <select name="aktif" id="aktif" class="form-control">
                                    <option value="Y" @if($account->aktif=="Y") selected="selected" @endif>Ya</option>
                                    <option value="N" @if($account->aktif=="N") selected="selected" @endif>Tidak</option>
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
