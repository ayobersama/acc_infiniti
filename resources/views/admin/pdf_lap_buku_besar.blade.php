<!DOCTYPE html>
<html>
<head>
    <title>Laporan Buku Besar</title>
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
            <td><!--<img src="{{ asset('images/logo_login.png')}}" height="50px"> --></td>
        </tr>
        <tr valign="top">
            <td align="center"><h3>LAPORAN BUKU BESAR</h3><br></td>
        </tr>
        <tr valign="top">
            <td><b>Bulan : </b>{{$nama_bln[$bln1-1]}} @if($bln1!=$bln2) sampai {{$nama_bln[$bln2-1]}} @endif {{$thn}} </td>
        </tr>
        <tr valign="top">
            <td><b>Account : </b>{{$nacc}}</td>
        </tr>
        <tr valign="top">
            <td><b>Saldo Awal : </b>{{ FormatAngka($sawal)}}</td>
        </tr>
    </table>
    <table class="bordered" width="100%">
        <tr>
            <th width="57px">Tanggal</th>
            <th width="68px">Bukti</th>
            <th width="180px">Uraian</th>
            <th width="60px">Debet</th>
            <th width="60px">Kredit</th>
            <th width="60px">Saldo</th>
        </tr>
        @php
          $saldo=$sawal;     
          $tdebet=0;     
          $tkredit=0;     
        @endphp
        @foreach($data as $dt)
          @php
             if($dt->debet>0) $tdebet=$tdebet+$dt->debet;
             if($dt->kredit>0) $tkredit=$tkredit+$dt->kredit;
             $saldo=$saldo+$dt->debet-$dt->kredit;
          @endphp
        <tr>
            <td>{{FormatTgl($dt->tgl)}}</td>
            <td>{{$dt->bukti}}</td>
            <td>{{$dt->uraian}}</td>
            <td align="right">{{FormatAngka($dt->debet)}}</td>
            <td align="right">{{FormatAngka($dt->kredit)}}</td>
            <td align="right">{{FormatAngka($saldo)}}</td>
        </tr>    
        @endforeach
        <tr>
            <th align="left" colspan="3">TOTAL</th>
            <th align="right">{{FormatAngka($tdebet)}}</th>
            <th align="right">{{FormatAngka($tkredit)}}</th>
            <td></td>
        </tr>
    </table>
</body>
</html>