@extends('layouts.admin')

@section('content')
    <div class="page-title">
        Edit No Urut Otomatis
    </div>
    <div class="breadcrumbs">      
        <ul class="breadcrumb">
            <li>
                <i class="fa fa-home home-icon"></i>
                <a href="{{ url('admin/home') }}">Home</a>
            </li>
            <li>
                <a href="{{ url('admin/no_urut') }}">No Urut Otomatis</a>
            </li>
            <li class="active">Edit No Urut Otomatis</li>
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
            <form action="{{ route('nourut.update', $nourut->id) }}" method="post">
                <div class="row">
                    <div class="col-md-10">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="nama" class="col-md-2 col-form-label">Jenis Transaksi <span class="label-req">*<span></label>
                            <div class="col-md-3">
                                <div style="background:#e5e8fc;border:1px solid #e2e2e2;padding:7px 10px;font-size:16px;font-weight:600">
                                    @if($nourut->tipe=='KM') Kas Masuk
                                    @elseif($nourut->tipe=='KK') Kas Keluar
                                    @elseif($nourut->tipe=='BM') Bank Masuk
                                    @elseif($nourut->tipe=='BK') Bank Keluar
                                    @elseif($nourut->tipe=='JU') Jurnal Umum
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kode" class="col-md-2 col-form-label">Kode Awal</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="kode" name="kode" maxlength="2" value="{{ $nourut->kode }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kota" class="col-md-2 col-form-label">No Akhir</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="no_akhir" name="no_akhir" value="{{ $nourut->no_akhir }}" required>
                            </div>
                        </div>
                    </div>
                </div>    
                <div class="row text-center mb-2">
                    <div class="col-md-12">
                        <hr>
                        <button type="submit" class="btn btn-success"> Simpan</button> 
                        <a href="{{ route('nourut.index') }}" class="btn btn-danger"> Batal</a>
                    </div>
                </div>              
            </form>      
        </div>
    </div>    
    @include('layouts.footer')      
@endsection
