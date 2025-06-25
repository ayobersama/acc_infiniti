@extends('layouts.admin')

@section('content')
    <div class="breadcrumbs">      
        <ul class="breadcrumb">
            <li>
                <i class="fa fa-home home-icon"></i>
                <a href="{{ url('admin/home') }}">Home</a>
            </li>
            <li class="active">User</li>
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
                            <a href="{{ route('user.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</a>
                        @endif        
                    </div>    
                    <table id="grid" class="table table-bordered table-hover table-striped">
                        <thead class="thead-dark">   
                            <tr>
                                <th width="30" class="text-right">No</th>
                                <th width="200">Username</th>
                                <th>Nama</th>
                                <th class="text-center" width="80px">Aktif</th>
                                <th class="text-center" width="200px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user as $data)
                                <tr>
                                    <td class="text-right">{{ $loop->iteration }}</td>
                                    <td>{{ $data->username }}</td>
                                    <td>{{ $data->nama }}</td>
                                    <td class="text-center">
                                        @if($data->aktif=='Y')<i class='fa fa-check'></i>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('user.destroy', $data->id)}}" method="post">
                                            @if($hak_akses['edit'])
                                                <a href="{{ route('user.edit', $data->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Edit</a> 
                                            @endif
                                            @if($hak_akses['hapus'])
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Apakah data ini akan dihapus?')"><i class="fa fa-trash"></i> Hapus</button>
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