@extends('layouts.admin')

@section('content')
    <div class="breadcrumbs">      
        <ul class="breadcrumb">
            <li>
                <i class="fa fa-home home-icon"></i>
                <a href="{{ url('admin/home') }}">Home</a>
            </li>
            <li>
                <a href="{{ url('admin/user') }}">User</a>
            </li>
            <li class="active">Tambah User</li>
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
            <form action="{{ route('user.store') }}" method="post" enctype='multipart/form-data'>
                <div class="row">
                    <div class="col-md-10">
                        @csrf
                        <div class="form-group row">
                            <label for="nama" class="col-md-3 col-form-label">Username <span class="label-req">*<span></label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="username" name="username" maxlength="20" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-md-3 col-form-label">Nama <span class="label-req">*<span></label>
                            <div class="col-md-5">
                                <input type="text" class="form-control" id="nama" name="nama" maxlength="50" value="" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label">Password <span class="label-req">*<span></label>
                            <div class="col-md-5">
                                <input type="password" class="form-control" id="password" name="password" value="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label">Konfirmasi Password <span class="label-req">*<span></label>
                            <div class="col-md-5">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" value="">
                            </div>
                        </div>
                        <!--<div class="form-group row">
                            <label for="gambar1" class="col-md-3 col-form-label"></label>
                            <div class="col-md-8">
                                <img id='img-upload' src="" width="200px"/>
                            </div>
                        </div>  
                        <div class="form-group row">
                            <label for="gambar" class="col-md-3 col-form-label">Foto</label>
                            <div class="col-md-8">
                                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                            </div>
                        </div>-->
                    </div>
                </div>    
                <div class="row text-center mb-2">
                    <div class="col-md-12">
                        <hr>
                        <button type="submit" class="btn btn-success"> Simpan</button> 
                        <a href="{{ route('user.index') }}" class="btn btn-danger"> Batal</a>
                    </div>
                </div>              
            </form>      
        </div>
    </div>    
    @include('layouts.footer')      
@endsection

@push('js')
    <script>    
   $(document).ready( function() {
        $("#id_provinsi").select2(); 
        $("#id_kota").select2(); 
        $("#id_kecamatan").select2(); 
        $("#id_kelurahan").select2(); 
    	$(document).on('change', '.btn-file :file', function() {
		var input = $(this),
			label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		input.trigger('fileselect', [label]);
		});

		$('.btn-file :file').on('fileselect', function(event, label) {
		    
		    var input = $(this).parents('.input-group').find(':text'),
		        log = label;
		    
		    if( input.length ) {
		        input.val(log);
		    } else {
		        if( log ) alert(log);
		    }
	    
		});
		
		function readURL(input) {
		    if (input.files && input.files[0]) {
		        var reader = new FileReader();
		        
		        reader.onload = function (e) {
		            $('#img-upload').attr('src', e.target.result);
		        }
		        
		        reader.readAsDataURL(input.files[0]);
		    }
		}
		
		$("#gambar").change(function(){
		    readURL(this);
		}); 
		//get cities
        $("#id_provinsi").on('change', function () {
            $.ajax({
                url: "/admin/get-city",
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: { code: $(this).val() },
                success: function (response) {
                    $("#id_kota").empty()
                    $("#id_kota").append('<option value=""></option>')
                    $.each(response, function (key, value) {
                        $("#id_kota").append('<option value="'+ value.code +'">'+ value.name +'</option>')
                    })
                }
            })
        });

        //get districts
        $("#id_kota").on('change', function () {
            $.ajax({
                url: "/admin/get-district",
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: { code: $(this).val() },
                success: function (response) {
                    $("#id_kecamatan").empty()
                    $("#id_kecamatan").append('<option value=""></option>')
                    $.each(response, function (key, value) {
                        $("#id_kecamatan").append('<option value="'+ value.code +'">'+ value.name +'</option>')
                    })
                }
            })
        });

        //get districts
        $("#id_kecamatan").on('change', function () {
            $.ajax({
                url: "/admin/get-village",
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: { code: $(this).val() },
                success: function (response) {
                    $("#id_kelurahan").empty()
                    $("#id_kelurahan").append('<option value=""></option>')
                    $.each(response, function (key, value) {
                        $("#id_kelurahan").append('<option value="'+ value.code +'">'+ value.name +'</option>')
                    })
                }
            })
        });
		
	});
 </script>   
@endpush