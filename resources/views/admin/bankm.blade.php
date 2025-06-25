@extends('layouts.admin')

@section('content')
    <div class="page-title">
        Bank Masuk
    </div>
    <div class="breadcrumbs">      
        <ul class="breadcrumb">
            <li>
                <i class="fa fa-home home-icon"></i>
                <a href="{{ url('admin/home') }}">Home</a>
            </li>
            <li class="active"> Bank Masuk</li>
        </ul><!-- /.breadcrumb -->
    </div>
    <div class="main-content">
            <div class="container">
            <div class="row">
                @if(session()->get('success'))
                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissible fade show warning-area" role="alert">
                            {{ session()->get('success') }}  
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <div class="mb-2">
                        @if($hak_akses['tambah'])
                            <a href="{{ route('bankm.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>    
                        @endif
                    </div>    
                    <table id="grid" class="table table-bordered table-hover table-striped">
                        <thead class="thead-dark">   
                            <tr>
                                <th width="160">Bukti</th>
                                <th width="100">Tanggal</th>
                                <th width="150">Bank</th>
                                <th width="350">Relasi</th>
                                <th width="100" class="text-right">Nilai</th>
                                <th class="text-center" width="60">Status</th>
                                <th class="text-center" width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bankm as $data)
                                <tr>
                                    <td>{{ $data->bukti }}</td>
                                    <td>{{ FormatTgl($data->tgl) }}</td>
                                    <td>{{ $data->nbank }}</td>
                                    <td>{{ $data->nrelasi }}</td>
                                    <td class="text-right">{{ FormatAngka($data->nilai)}}</td>
                                    <td class="text-center" width="65">
                                        @if($data->status=='0') Input
                                        @elseif($data->status=='1') Slip
                                        @elseif($data->status=='2') Proses
                                        @elseif($data->status=='3') Batal
                                     @endif
                                    </td>
                                    <td width="120">
                                        <form action="{{ route('bankm.destroy', $data->bukti)}}" method="post">
                                            @if($hak_akses['edit'])
                                                <a href="{{ route('bankm.edit', $data->bukti)}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Edit</a>
                                            @endif 
                                            @if($hak_akses['hapus'])
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Apakah data ini akan dihapus?')" title="Hapus"><i class="fa fa-trash"></i> Hapus</button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>        
                        <tfoot>
                        </tfoot>    
                    </table>   
                    <br> 
                </div>
            </div>
        </div>
    </div>    

    @include('layouts.footer')      
@endsection