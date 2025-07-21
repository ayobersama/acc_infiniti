<!DOCTYPE html>
<html>
<head>
    <title>Laporan Neraca</title>
</head>
<body style="font-size:14px">
    <style>
        table {
            border-collapse: collapse;
        }
        table.bordered td {
            padding: 4px 6px;
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
        }
        
        table.detail th {
            font-weight:bold;
        }
        
        table.noborder{
            border-collapse: collapse;
        }
        
        table.noborder td {
        }
        
        table.noborder th {
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
            <td align="center"><h4 style="font-size:18px">LAPORAN LABA RUGI</h4><br></td>
        </tr>
        <tr valign="top">
            <td><b>Bulan : </b>{{$nama_bln[$bln-1]}} {{$thn}}</td>
        </tr>
    </table>
    <hr>
    <table width="700px" class="bordered">
        <tr  valign="top">
            <td>
                <div><b>PENDAPATAN</b></div>
                <table width="330px"  class="detail">
                    @php
                      $total=0;
                    @endphp
                    @foreach($pendapatan as $dt)
                    @php
                      if($dt->header!='Y') $total=$total+$dt->saldo;
                    @endphp
                    <tr>
                        <td width="400px">@if($dt->header=='Y')<b>{{$dt->nama}}</b> @else &nbsp;&nbsp; {{$dt->nama}} @endif</td>
                        <td align="right" width="180px">@if($dt->header!='Y') @if(!(empty($dt->saldo))) {{FormatAngka($dt->saldo)}} @else 0 @endif @endif</td>
                    </tr>    
                    @endforeach
                    <tr>
                        <td style="border-top:1px solid #111;padding-top:5px" ><b>Total Pendapatan</b></td>
                        <td align="right" style="border-top:1px solid #111;padding-top:5px">{{$total}}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td >
                <div><b>BIAYA</b></div>
                <table width="580px"  class="detail">
                    @php
                      $total=0;
                    @endphp
                    @foreach($biaya as $dt)
                    @php
                      if($dt->header!='Y') $total=$total+$dt->saldo;
                    @endphp
                    <tr>
                        <td width="400px">@if($dt->header=='Y')<b>{{$dt->nama}}</b> @else &nbsp;&nbsp; {{$dt->nama}} @endif</td>
                        <td align="right" width="180px">@if($dt->header!='Y') @if(!(empty($dt->saldo))) {{FormatAngka($dt->saldo)}} @else 0 @endif @endif</td>
                    </tr>    
                    @endforeach
                    <tr>
                        <td style="border-top:1px solid #111;padding-top:5px"><b>Total Biaya</b></td>
                        <td align="right" style="border-top:1px solid #111;padding-top:5px">{{$total}}</td>
                    </tr>
                </table>
                <table width="580px" class="detail" style="padding-top:10px">
                    <tr>
                        <td width="400px" style="border-top:1px solid #111;padding-top:5px"><b>Laba Rugi</b></td>
                        <td align="right" width="180px" style="border-top:1px solid #111;padding-top:5px">{{$total}}</td>
                    </tr>
                </table>    
            </td>
        </tr>
    </table>
</body>
</html>