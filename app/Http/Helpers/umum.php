<?php 
if (! function_exists('FormatTglDB')) {
    function FormatTglDB($tgl){
        $pisah = explode('-',$tgl);
        $urutan = array($pisah[2],$pisah[1],$pisah[0]);
        $satukan = implode('-',$urutan);
        return $satukan;
    }
}
if (! function_exists('FormatTgl')) {
    function FormatTgl($tgl,$fmt="A"){
        // Format 
        //   A= 21-04-2021
        //   L= 21 April 2021
        //   HL= Kamis, 21 April 2021
        //   S= 21 Apr 2021
        //   HS= Kam, 21 Apr 2021
        //   H= Kamis
        //   J= 10:35
        //   JA= 10:35 AM
        
        if (($fmt=='H')or($fmt=='HL')or($fmt=='L'))
        {
            $hr=array('Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu');
            $bln=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
        }  else {
            $hr=array('Mgu','Sen','Sel','Rab','Kam','Jum','Sab');
            $bln=array('Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des');
        } 
        $d=getdate(strtotime($tgl));
        $wd=$d['wday'];
        $hari=$hr[$wd];
        $m=$d['mon'];
        $bulan=$bln[$m-1];
        if ($d['mday']<10) $tgls='0'.$d['mday']; else $tgls=$d['mday'];
        if ($d['mon']<10) $bls='0'.$d['mon']; else $bls=$d['mon'];
        if ($d['hours']<10) $hours='0'.$d['hours']; else $hours=$d['hours'];
        if ($d['minutes']<10) $minutes='0'.$d['minutes']; else $minutes=$d['minutes'];
        if ($d['hours']<12) $tanda="AM"; else $tanda="PM";

        if ($fmt=='A') 
            $hasil=$tgls.'-'.$bls.'-'.$d['year'];
        else  if (($fmt=='S')||($fmt=='L')) 
            $hasil=$d['mday'] .'  '.$bulan.'  '.$d['year'];
        else  if ($fmt=='H') $hasil=$hari;    
        else  if (($fmt=='HS')||($fmt=='HL')) 
            $hasil=$hari.',  '.$d['mday'] .'  '.$bulan.'  '.$d['year'];    
        else  if ($fmt=='J') $hasil=$hours.':'.$minutes;
        else  if ($fmt=='JA') $hasil=$hours.':'.$minutes.' '.$tanda;
        return $hasil;
    }    
}

if (! function_exists('FormatAngka')) {
    function FormatAngka($nilai)
    {
    if (!(is_null($nilai))){
            if ($nilai-floor($nilai)>0) {
                $hasil=number_format($nilai, 2, ',', '.');
                if (substr($hasil, -1)=='0') $hasil=substr($hasil,0,strlen($hasil)-1);
            } else $hasil=number_format($nilai, 0, ',', '.');
        } else $hasil=$nilai;
        return $hasil;
    }
}

if (! function_exists('UnformatAngka')) {
    function UnformatAngka($nilai)
    {
      $pembatas_decimal=",";
      if ($pembatas_decimal==","){
            $hasil=str_replace('.','',$nilai);
            $hasil=str_replace(',','.',$hasil);
        } else {
            $hasil=str_replace(',','',$nilai);
        }	
        return $hasil;
    }    
}