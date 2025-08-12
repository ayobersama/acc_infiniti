@extends('layouts.admin')
@section('content')
    <script>
        
    </script>
    <div class="page-title">
        Edit Bank Masuk
    </div>
    <div class="breadcrumbs">      
        <ul class="breadcrumb">
            <li>
                <i class="fa fa-home home-icon"></i>
                <a href="{{ url('admin/home') }}">Home</a>
            </li>
            <li>
                <a href="{{ url('admin/bankm') }}">Bank Masuk</a>
            </li>
            <li class="active">Edit Bank Masuk</li>
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
                </div><br/>
            @endif
            <form name="form_trans" id="form_trans" action="" method="post">
            @method('PUT')
             <input type="hidden" id="termasuk_detail" name="termasuk_detail" value="">
             <div class="card">
                <div class="card-body" style="padding:7px 5px;">
                    <div class="row p-2">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="bukti" class="col-md-2 col-form-label">Bukti</label> 
                                <div class="col-md-5">
                                    <div class="input-group">
                                      <input type="text" class="form-control" id="bukti" name="bukti" maxlength="10" value="{{$bankm->bukti}}" readonly>
                                      <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="button" id="button-addon2" onclick="ambil_nourut()"> <a class="fa fa-sort-numeric-asc"></a></button>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bank" class="col-md-2 col-form-label">Bank</label>
                                <div class="col-md-9">
                                    <select class="form-control" id="bank" name="bank">
                                        <option value=""></option>
                                        @foreach($bank_list as $kl)
                                        <option value="{{$kl->id}}"  @if($kl->id==$bankm->bank) selected="selected" @endif>{{$kl->nama}}</option>
                                        @endforeach
                                    </select>    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="relasi" class="col-md-2 col-form-label">Relasi</label>
                                <div class="col-md-9">
                                    <select class="form-control" id="relasi" name="relasi">
                                        <option value=""></option>
                                        @foreach($relasi_list as $rl)
                                        <option value="{{$rl->id}}" @if($rl->id==$bankm->relasi) selected="selected" @endif>{{$rl->nama}}</option>
                                        @endforeach
                                    </select>   
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="alamat" class="col-md-3 col-form-label">Tanggal</label>
                                <div class="col-md-4">
                                    <input type="text" class="form-control date-picker" data-date-format="dd-mm-yyyy" id="tgl" name="tgl" maxlength="12" value="{{FormatTgl($bankm->tgl)}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="status" class="col-md-3 col-form-label">Status</label> 
                                <div class="col-md-4">
                                    <input type="text" id="status" class="form-control" value="Input" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="bukti" class="col-md-3 col-form-label">Keterangan</label> 
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="ket" name="ket" value="{{ $bankm->ket }}" maxlength="255">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>        
            </form>    
            </div>
            <div class="mt-2 mb-1">
                <button type="button" class="btn btn-sm btn-primary" onclick="tambah_detail()"><i class="fa fa-plus"></i> Tambah Jurnal</a> </button>    
            </div>    
            <div id="detail"></div>
            <div class="row text-center mb-2">
                <div class="col-md-12">
                    <hr>
                    <button type="button" class="btn btn-success" onclick="simpan_header();"> Simpan</button> 
                    <a href="{{ route('bankm.index') }}" class="btn btn-danger"> Batal</a>
                </div>
            </div>      
        </div>
    </div>    

    <div id="Modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg" style="top:120px">
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="judul_modal">Tambah Jurnal</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              <form role="form" class="form-horizontal" id="form_detail" action="" method="POST">
                  <input type="hidden" name="bukti" id="bukti2" value="">
                  <input type="hidden" name="jns" id="jns" value="">
                  <input type="hidden" name="id" id="id" value="">
                  <div class="form-group row">
                      <label for="account" class="col-md-2 col-form-label">Account</label>
                      <div class="col-md-9">
                          <select class="form-control" id="account" name="account" style="width:100%" required>
                          <option value="" selected></option>
                          @foreach($acc_list as $al)
                              <option value="{{$al->id}}">{{$al->kode}} - {{$al->nama}}</option>
                          @endforeach
                          </select>
                      </div>	
                  </div>
                  <div class="form-group row">
                    <label for="alamat" class="col-md-2 col-form-label">Uraian</label>
                    <div class="col-md-9">
                        <input type="text" name="uraian" id="uraian" maxlength="100" class="form-control" required>
                    </div>
                  </div>		
                  <div class="form-group row">
                       <label for="nilai" class="col-md-2 col-form-label">Nilai</label>
                       <div class="col-md-3">
                          <input type="text" name="nilai" id="nilai" maxlength="30" class="form-control" onkeyup="format_uang()"  required>
                      </div>
                  </div>	
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="simpan()">Simpan</button>
              <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </form>
        </div>
      </div>	
      </div>
    @include('layouts.footer')      
@endsection

@push('js')
    <script>    
    $("#bank").select2({
           placeholder: "Pilih Bank"
       });	
    $("#relasi").select2({
           placeholder: "Pilih Relasi"
       });	
    $("#account").select2({
           placeholder: "Pilih Account"
       });	
    $('#nilai').keypress(function(event) {
        if (((event.which != 46 || (event.which == 46 && $(this).val() == '')) ||
                $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
            }
        }).on('paste', function(event) {
            event.preventDefault();
    });
        
        function format_uang(){
		   var num=$("#nilai").val();
		   var val = num.replaceAll(".", "");
		   var x = val.split(',');
		   var x1 = x[0];
		   var x2 = x.length > 1 ? ',' + x[1] : '';

		   var rgx = /(\d+)(\d{3})/;

			while (rgx.test(x1)) {
				x1 = x1.replace(rgx, '$1' + '.' + '$2');
			}  
		   $("#nilai").val(x1+x2);
	   }
       
        function validasi(){
            var bukti=$('#bukti').val();
            var tgl=$('#tgl').val();
            
            if (bukti==''){
                alert("Bukti tidak boleh kosong");
                $('#bukti').focus();
                return false;
            }
            if (tgl==''){
                alert("Tanggal tidak boleh kosong");
                $('#tgl').focus();
                return false;
            }
            return true;
        }
        
        function validasi_detail(){
            return true;	
        }	

        function ambil_nourut(){
            $.ajax({
                url :"{{ url('admin/ambil_nourut/BM') }}",
                type:"get",
                success:function(data){
                    $("#bukti").val(data);
                },
                error:function(data){
                    alert("Ambil");					
                }
            })
        }    

        function simpan(){
            $('#termasuk_detail').val('Y');
            $('#form_trans').submit();
		}		
            
        $('#form_trans').submit(function(e) {
            e.preventDefault();
            var termasuk_detail=$("#termasuk_detail").val();
            var formData = new FormData(this);
            var token = $("meta[name='csrf-token']").attr("content");
            formData.append('_token', token); 
            $.ajax({
                type:'post',
                url: "{{ route('bankm.update', $bankm->bukti) }}",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                dataType : 'json',
                success: function(response){
                    if(response["success"]){
                        if(termasuk_detail=='Y'){
                            simpan_detail();
                        } else window.location.replace("{{ url('admin/bankm')}}");       
                    } else  alert('Gagal');
                },
                error:function(data){
                    alert('gagal menyimpan header');
                },		     
            });
        }); 
        
        function tambah_detail(){
            var bukti=$("#bukti").val();
            var lolos=validasi();
            if (lolos==true) {
                $("#jns").val('i');
                $("#bukti2").val(bukti);
                $("#account").val("").trigger('change');
                $("#uraian").val("");
                $("#nilai").val("");
                $("#judul_modal").text("Tambah Jurnal");
                $("#Modal").modal('show');
            }
        }

        function edit_detail(id){
            var lolos=validasi();
            var bukti=$("#bukti").val();
            if (lolos==true) {
                $.ajax({
				url :"{{ url('admin/edit_bankmd')}}/"+id,
					type:"get",
					dataType: "json",
					success:function(data){
                        $("#judul_modal").text("Edit Jurnal");
                        $("#jns").val('e');
                        $("#bukti2").val(bukti);
                        $("#id").val(id);
                        $("#account").val(data["cha"]).trigger('change');
						$("#uraian").val(data["uraian"]);
                        var num = Math.round(data["nilai"]);
                        $("#nilai").val(num);
                        format_uang();
						$("#Modal").modal('show');
					},
					error:function(data){
						alert(data);					}
				})
            }
        }

        function simpan_detail(){
			var bukti= $("#bukti").val();
			var lolos=validasi_detail();
			if (lolos==true){
                $('#form_detail').submit();
			}
   	``  }
		
        $('#form_detail').submit(function(e) {
            e.preventDefault();
            var jns= $("#jns").val();
            var id= $("#id").val();
            var link='';
            if(jns=='i') link="{{ url('admin/simpan_bankmd') }}";
            else link="{{ url('admin/update_bankmd') }}/"+id;
            var formData2 = new FormData(this);
            var token = $("meta[name='csrf-token']").attr("content");
            formData2.append('_token', token); 
            $.ajax({
                type:'post',
                url: link,
                data: formData2,
                cache:false,
                contentType: false,
                processData: false,
                dataType : 'json',
                success: function(response){
                    if(response["success"]){
                        $("#Modal").modal('hide');
                        $("#detail").load("{{url('admin/tampilkan_bankmd/'.$bankm->bukti)}}");
                    } else  alert('Gagal Menyimpan detail');
                },
                error:function(data){
                    alert('Gagal Menyimpan detail');
                },		     
            });
        }); 

        function hapus_detail(id){
            if (confirm('Apakah data ini akan dihapus?')){
                var token = $("meta[name='csrf-token']").attr("content");
                $.ajax({
				    url :"{{ url('admin/hapus_bankmd') }}/"+id,
					type:"delete",
                    data: {
                            "_token": token
                          },
					dataType: "json",
					success:function(data){
                        $("#detail").load("{{url('admin/tampilkan_bankmd/'.$bankm->bukti)}}");
					},
					error:function(data){
                        
                    }	
				})        
                return true;
            } else return false;            
        }    


		
		function simpan_header(){
			$("#termasuk_detail").val("N");
            $('#form_trans').submit();
		} 
        
        $(document).ready(function() {
            $("#detail").load("{{url('admin/tampilkan_bankmd/'.$bankm->bukti)}}");
			$('#Modal').on('shown.bs.modal', function () {
				$('#account').focus();
			}) 
		} );
    </script>
@endpush