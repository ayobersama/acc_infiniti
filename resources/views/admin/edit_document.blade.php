@extends('layouts.admin')

@section('content')
    <div class="page-title">
        Edit Document
    </div>
    <div class="breadcrumbs">      
        <ul class="breadcrumb">
            <li>
                <i class="fa fa-home home-icon"></i>
                <a href="{{ url('admin/home') }}">Home</a>
            </li>
            <li>
                <a href="{{ url('admin/document') }}">Document</a>
            </li>
            <li class="active">Edit Document</li>
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
            @foreach($booking as $book)
            <form action="{{ route('document.update', $book->id) }}" method="post">
                <div class="row p-2">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="nama" class="col-md-4 col-form-label">HAWB</label> 
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="hawb" name="hawb" maxlength="30" value="{{$book->hawb}}">
                            </div>
                        </div>
                    </div>     
                </div>    
                <div class="row p-2">
                    <div class="col-md-6">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="alamat" class="col-md-4 col-form-label">Shipper</label>
                            <div class="col-md-8">
                                <div style="border:1px solid #bbb;padding:5px;border-radius:5px;background:#eee">{{$book->nama_shipper}} <br>{{$book->alamat_shipper}}
                                </div> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-md-4 col-form-label">Tax ID</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="tax_id" name="tax_id" maxlength="20" value="{{$book->tax_id}}">
                            </div>
                        </div>        
                        <div class="form-group row">
                            <label for="consignee" class="col-md-4 col-form-label">Consignee</label>
                            <div class="col-md-8">
                                <div style="border:1px solid #bbb;padding:5px;border-radius:5px;background:#eee">{{$book->nama_consignee}}<br>{{$book->alamat_consignee}}
                                </div> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="consignee_note" class="col-md-4 col-form-label">Consignee Note</label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="consignee_note" name="consignee_note">{{$book->consignee_note}}</textarea>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label for="alamat" class="col-md-4 col-form-label">Agent ATA Code</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="agen_code" name="agen_code" maxlength="20" value="{{$book->agen_code}}">
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label for="consignee" class="col-md-4 col-form-label">Depature Airport</label>
                            <div class="col-md-8">
                                <div style="border:1px solid #bbb;padding:5px;border-radius:5px;background:#eee">{{$book->nama_po}}
                                </div> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="alamat" class="col-md-4 col-form-label">Rooting Destination</label>
                            <div class="col-md-2">
                                <div style="border:1px solid #bbb;padding:5px;border-radius:5px;background:#eee">{{$book->kode_po}}
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <div style="border:1px solid #bbb;padding:5px;border-radius:5px;background:#eee">{{$book->flight_no}}
                                </div> 
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label for="consignee" class="col-md-4 col-form-label">Airport Destinaton</label>
                            <div class="col-md-8">
                                <div style="border:1px solid #bbb;padding:5px;border-radius:5px;background:#eee">{{$book->nama_pd}} , {{$book->kode_pd}} 
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="consignee" class="col-md-4 col-form-label">Freight Status</label>
                            <div class="col-md-8">
                                <div style="border:1px solid #bbb;padding:5px;border-radius:5px;background:#eee">
                                    @if($book->freight_status=='1') Freight Cash
                                    @elseif($book->freight_status=='2') Freight Prepaid
                                    @elseif($book->freight_status=='3') Freight Collect
                                    @endif
                                </div> 
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="consignee_note" class="col-md-4 col-form-label">Accounting Information</label>
                            <div class="col-md-8">
                                <textarea class="form-control" id="consignee_note" name="acc_info">{{$book->acc_info}}</textarea>
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label for="consignee_note" class="col-md-4 col-form-label">Currency</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="val" name="val" maxlength="10" value="{{$book->val}}">
                            </div>
                        </div> 
                        <div class="form-group row">
                            <label for="consignee_note" class="col-md-4 col-form-label">Chgs Code</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="ch_code" name="ch_code" maxlength="10" value="{{$book->ch_code}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="consignee_note" class="col-md-4 col-form-label">WT / VAL : PPD</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="wt_ppd" name="wt_ppd" maxlength="10" value="{{$book->wt_ppd}}">
                            </div>
                            <label for="" class="col-md-1 col-form-label">COLL</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="wt_coll" name="wt_coll" maxlength="10" value="{{$book->wt_coll}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="consignee_note" class="col-md-4 col-form-label">OTHER  : PPD</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="other_ppd" name="other_ppd" maxlength="10" value="{{$book->other_ppd}}">
                            </div>
                            <label for="" class="col-md-1 col-form-label">COLL</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="other_coll" name="other_coll" maxlength="10" value="{{$book->other_coll}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="consignee_note" class="col-md-4 col-form-label">Value for Cariage</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="value_cariage" name="value_cariage" maxlength="10" value="{{$book->value_cariage}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="consignee_note" class="col-md-4 col-form-label">Value for Customs</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="value_customs" name="value_customs" maxlength="10" value="{{$book->value_customs}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="consignee_note" class="col-md-4 col-form-label">Amount of Insurance</label>
                            <div class="col-md-3">
                                <input type="text" class="form-control" id="amount_insurance" name="amount_insurance" maxlength="10" value="{{$book->amount_insurance}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row p-2">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="alamat" class="col-md-2 col-form-label">Handling Information</label>
                            <div class="col-md-10">
                                <textarea class="form-control" id="handling_info" name="handling_info">{{$book->handling_info}}</textarea>
                            </div>
                        </div>        
                    </div>
                </div>        
                <hr style="margin:5px">
                <div class="row p-2">
                    <div class="col-md-12">
                        <table class="table table-bordered"> 
                            <thead class="thead-dark">
                                <tr>
                                    <th width="100">No of Pieces (RCP)</th>
                                    <th width="100">Gross Wight</th>
                                    <th width="500">Nature of QTY of Goods</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{FormatAngka($book->no_pkgs)}}</td>
                                    <td>{{FormatAngka($book->gross_weight)}}</td>
                                    <td>{{$book->description}}
                                        <textarea class="form-control" id="description2" name="description2">{{$book->description2}}</textarea>
                                    </td>
                                </tr>
                            </tbody>                            
                        </table>
                    </div>
                </div> 
                <hr style="margin:5px">
                <div class="row text-center mb-2">
                    <div class="col-md-12">
                        <button type="submit"  class="btn btn-success"> Simpan</button> 
                        <a href="{{ route('document.index') }}" class="btn btn-danger"> Batal</a>
                    </div>
                </div>        
                </form>      
            @endforeach
        </div>
    </div>    
    @include('layouts.footer')      
@endsection

@push('js')
    <script>    
    $("#shipper").select2();
    $("#vendor").select2();	
    $("#port_loading").select2();	
    $("#port_discharge").select2();	
    $("#ts_port").select2();	
    $("#port_delivery").select2();	
    $("#consignee").select2();
    $('#final_weight').keypress(function(event) {
        if (((event.which != 46 || (event.which == 46 && $(this).val() == '')) ||
                $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
            }
        }).on('paste', function(event) {
            event.preventDefault();
        });
    $('#net_weight').keypress(function(event) {
            if (((event.which != 46 || (event.which == 46 && $(this).val() == '')) ||
                    $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        }).on('paste', function(event) {
            event.preventDefault();
        });
    $('#gross_weight').keypress(function(event) {
            if (((event.which != 46 || (event.which == 46 && $(this).val() == '')) ||
                    $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        }).on('paste', function(event) {
            event.preventDefault();
        });    
    $('#measurement').keypress(function(event) {
            if (((event.which != 46 || (event.which == 46 && $(this).val() == '')) ||
                    $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        }).on('paste', function(event) {
            event.preventDefault();
        });      
    $('#final_measure').keypress(function(event) {
            if (((event.which != 46 || (event.which == 46 && $(this).val() == '')) ||
                    $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
                event.preventDefault();
            }
        }).on('paste', function(event) {
            event.preventDefault();
        });      
    </script>
@endpush