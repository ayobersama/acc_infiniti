<!DOCTYPE html>
<html>
<head>
    <title>Laporan Rekap Buku Besar</title>
</head>
<body style="font-size:12px">
    <style>
        table {
            border-collapse: collapse;
        }
        table.bordered td {
            border: 1px solid black;
            padding: 4px 6px;
        }
        
        table.bordered th {
            font-weight:bold;
            border: 1px solid black;
            padding: 4px 6px;
            background: #e1e1e1;
        }
        
        table.bordered2{
            border-collapse: collapse;
        }
        
        table.bordered2 td {
            border-top: 0 solid white;
            border-bottom: 0 solid white;
            border-left: 1 solid black;
            border-right: 1 solid black;
        }
        
        table.bordered2 th {
            font-weight:bold;
            border: 1px solid black;
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
            <td align="center"><h3>LAPORAN REKAP BUKU BESAR</h3><br></td>
        </tr>
        <tr valign="top">
            <td><b>Bulan : </b>{{$nama_bln[$bln1-1]}} @if($bln1!=$bln2) sampai {{$nama_bln[$bln2-1]}} @endif {{$thn}}</td>
        </tr>
    </table>
    <table class="bordered" width="100%">
        <tr>
            <th width="50px" rowspan="2">Kode Acc</th>
            <th width="160px" rowspan="2">Nama Account</th>
            <th width="130px" colspan="2">Saldo Awal</th>
            <th width="130px" colspan="2">Mutasi</th>
            <th width="130px" colspan="2">Saldo Akhir</th>
        </tr>
        <tr>
           <th width="65px">Debet</th>
           <th width="65px">Kredit</th>
           <th width="65px">Debet</th>
           <th width="65px">Kredit</th>
           <th width="65px">Debet</th>
           <th width="65px">Kredit</th>
        </tr>
        @foreach($data as $dt)
        <tr>
            <td>@if($dt->header=='Y')<b>{{$dt->kode}}</b> @else &nbsp;&nbsp; {{$dt->kode}} @endif</td>
            <td @if($dt->header=='Y') colspan="7" @endif>@if($dt->header=='Y')<b>{{$dt->nama}}</b> @else {{$dt->nama}} @endif </td>
            @if($dt->header=='N')
            <td align="right">@if($dt->sa>=0) {{FormatAngka($dt->sa)}} @else 0 @endif</td>
            <td align="right">@if($dt->sa<0) {{FormatAngka(abs($dt->sa))}} @else 0 @endif</td>
            <td align="right">@if(!(empty($dt->md))){{FormatAngka($dt->md)}} @else 0 @endif</td>
            <td align="right">@if(!(empty($dt->mk))){{FormatAngka($dt->mk)}} @else 0 @endif</td>
            <td align="right">@if($dt->sa+$dt->md-$dt->mk>=0){{FormatAngka($dt->sa+$dt->md-$dt->mk)}} @else 0 @endif</td>
            <td align="right">@if($dt->sa+$dt->md-$dt->mk<0){{FormatAngka(abs($dt->sa+$dt->md-$dt->mk))}} @else 0 @endif</td>
            @else
            @endif
        </tr>    
        @endforeach
    </table>
</body>
</html>