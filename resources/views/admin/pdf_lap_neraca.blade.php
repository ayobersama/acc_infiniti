<!DOCTYPE html>
<html>
<head>
    <title>Laporan Neraca</title>
</head>
<body style="font-size:13px">
    <style>
        table {
            border-collapse: collapse;
        }
        table.bordered td {
            padding: 10px 16px;
        }
        
        table.bordered th {
            font-weight:bold;
            border: 1px solid black;
            padding: 4px 6px;
            background: #e1e1e1;
        }
        
        table.detail{
            border-collapse: collapse;
        }
        
        table.detail td {
            padding:3px;
        }
        
        table.detail th {
            font-weight:bold;
        }
        
        table.detail{
            border-collapse: collapse;
        }
        
        table.detail td {
        }
        
        table.detail th {
            font-weight:bold;
        }
    </style>
   @php
        $nama_bln=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
   @endphp

    <table width="680px">
        <tr valign="top">
            <td><img src="{{ asset('images/logo_login.png')}}" height="50px"></td>
        </tr>
        <tr valign="top">
            <td align="center"><h3>LAPORAN NERACA</h3><br></td>
        </tr>
        <tr valign="top">
            <td><b>Bulan : </b>{{$nama_bln[$bln-1]}} {{$thn}}</td>
        </tr>
    </table>
    <hr>
    <table width="700px" class="bordered">
        <tr  valign="top">
            <td style="border-right:1px solid #111">
                <div><b>AKTIVA</b></div>
                <table width="330px"  class="detail">
                    @php
                      $total=0;
                    @endphp
                    @foreach($aktiva as $dt)
                    @php
                      if($dt->header!='Y') $total=$total+$dt->saldo;
                    @endphp
                    <tr>
                        <td width="250px">@if($dt->header=='Y')<b>{{$dt->nama}}</b> @else &nbsp;&nbsp; {{$dt->nama}} @endif</td>
                        <td align="right" width="70px">@if($dt->header!='Y') @if(!(empty($dt->saldo))) {{FormatAngka($dt->saldo)}} @else 0 @endif @endif</td>
                    </tr>    
                    @endforeach
                    <tr>
                        <td style="border-top:1px solid #111;padding-top:5px" ><b>Total Aktiva</b></td>
                        <td align="right" style="border-top:1px solid #111;padding-top:5px">{{FormatAngka($total)}}</td>
                    </tr>
                </table>
            </td>
            <td >
                <div><b>PASIVA</b></div>
                <table width="330px"  class="detail">
                    @php
                      $total=0;
                    @endphp
                    @foreach($pasiva as $dt)
                    @php
                      if($dt->header!='Y') $total=$total+$dt->saldo;
                    @endphp
                    <tr>
                        <td width="250px">@if($dt->header=='Y')<b>{{$dt->nama}}</b> @else &nbsp;&nbsp; {{$dt->nama}} @endif</td>
                        <td align="right" width="70px">@if($dt->header!='Y') @if(!(empty($dt->saldo))) {{FormatAngka($dt->saldo)}} @else 0 @endif @endif</td>
                    </tr>    
                    @endforeach
                    <tr>
                        <td style="border-top:1px solid #111;padding-top:5px"><b>Total Pasiva</b></td>
                        <td align="right" style="border-top:1px solid #111;padding-top:5px">{{FormatAngka($total)}}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
</body>
</html>