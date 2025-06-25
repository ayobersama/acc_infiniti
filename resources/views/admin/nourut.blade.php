@extends('layouts.admin')

@section('content')
    <div class="page-title">
        No Urut Otomatis
    </div>
    <div class="breadcrumbs">      
        <ul class="breadcrumb">
            <li>
                <i class="fa fa-home home-icon"></i>
                <a href="{{ url('admin/home') }}">Home</a>
            </li>
            <li class="active">No Urut Otomatis</li>
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
                    <table id="grid" class="table table-bordered table-hover table-striped">
                        <thead class="thead-dark">   
                            <tr>
                                <th width="30" class="text-right">No</th>
                                <th width="160">Jenis Transaksi</th>
                                <th width="260">Kode Awal</th>
                                <th width="260">No Akhir</th>
                                <th class="text-center" width="180">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nourut as $data)
                                <tr>
                                    <td class="text-right">{{ $loop->iteration }}</td>
                                    <td>@if($data->tipe=='KM') Kas Masuk
                                        @elseif($data->tipe=='KK') Kas Keluar
                                        @elseif($data->tipe=='BM') Bank Masuk
                                        @elseif($data->tipe=='BK') Bank Keluar
                                        @elseif($data->tipe=='JU') Jurnal Umum
                                        @endif
                                    </td>
                                    <td>{{ $data->kode }}</td>
                                    <td>{{ $data->no_akhir }}</td>
                                    <td>
                                        <form action="{{ route('nourut.destroy', $data->id)}}" method="post">
                                            @if($hak_akses['edit'])
                                                <a href="{{ route('nourut.edit', $data->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Edit</a>
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