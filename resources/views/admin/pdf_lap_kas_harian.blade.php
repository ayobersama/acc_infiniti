<!DOCTYPE html>
<html>
<head>
    <title>Laporan Kas Harian</title>
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

    <table width="680px">
        <tr valign="top">
            <td><img src="{{ asset('images/logo_login.png')}}" height="50px"></td>
        </tr>
        <tr valign="top">
            <td align="center"><h3>LAPORAN KAS HARIAN</h3><br></td>
        </tr>
        <tr valign="top">
            <td><b>Tanggal : </b>{{$tgl1}} @if($tgl1!=$tgl2) sampai {{$tgl2}} @endif</td>
        </tr>
        <tr valign="top">
            <td><b>Kas : </b>{{$nkas}}</td>
        </tr>
        <tr valign="top">
            <td><b>Saldo Awal : </b>{{ FormatAngka($sawal)}}</td>
        </tr>
    </table>
    <table class="bordered" width="100%">
        <tr>
            <th width="57px">Tanggal</th>
            <th width="68px">Bukti</th>
            <th width="110px">Relasi</th>
            <th width="150px">Keterangan</th>
            <th width="60px">Debet</th>
            <th width="60px">Kredit</th>
            <th width="60px">Saldo</th>
        </tr>
        @php
          $saldo=$sawal;     
        @endphp
        @foreach($data as $dt)
          @php
             $saldo=$saldo+$dt->debet-$dt->kredit;
          @endphp
        <tr>
            <td>{{FormatTgl($dt->tgl)}}</td>
            <td>{{$dt->bukti}}</td>
            <td>{{$dt->nrelasi}}</td>
            <td>{{$dt->ket}}</td>
            <td align="right">{{FormatAngka($dt->debet)}}</td>
            <td align="right">{{FormatAngka($dt->kredit)}}</td>
            <td align="right">{{FormatAngka($saldo)}}</td>
        </tr>    
        @endforeach
    </table>
</body>
</html>