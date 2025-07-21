<?php
   require_once 'konfig.php'; 
   require_once 'fungsi_umum.php';
   
    $sql="delete from mut_saldo";		
	$result = mysqli_query($conn,$sql);  
   
    //saldo awal
    $q = mysqli_query($conn,"select thn,cha,dk,nilai from saldo_awal");
	if (mysqli_num_rows($q)>0) 
	{
		$i=0; 
		while($row = mysqli_fetch_array($q)) {
			extract($row);
			if($dk=='K') $nilai=-$nilai;
			if(AdaData("select cha from mut_saldo where thn=$thn and cha=$cha"))
			{
			   $sql="update mut_saldo set sa=sa+($nilai) where thn=$thn and cha=$cha";		
			   $result = mysqli_query($conn,$sql);  
			} else {
			   $sql="insert into mut_saldo(thn,cha,sa) values($thn,$cha,$nilai)";		
			   $result = mysqli_query($conn,$sql);  	
			}  
		}
    }		

	//transaksi
	$q = mysqli_query($conn,"select bukti,month(tgl) as bln,year(tgl) as thn,kas as cha,'D' as dk,nilai from kasm
	                         union all
							 select bukti,month(tgl) as bln,year(tgl) as thn,kas,'K',nilai from kask
							 union all
							 select bukti,month(tgl) as bln,year(tgl) as thn,bank,'D',nilai from bankm
							 union all
							 select bukti,month(tgl) as bln,year(tgl) as thn,bank,'K',nilai from bankk
							 union all
							 select d.bukti,month(tgl) as bln,year(tgl) as thn,cha,dk,d.nilai from kasmd d 
							 left outer join kasm t on(t.bukti=d.bukti)
							 union all
							 select d.bukti,month(tgl) as bln,year(tgl) as thn,cha,dk,d.nilai from kaskd d 
							 left outer join kask t on(t.bukti=d.bukti)
							 union all
							 select d.bukti,month(tgl) as bln,year(tgl) as thn,cha,dk,d.nilai from bankmd d 
							 left outer join bankm t on(t.bukti=d.bukti)
							 union all
							 select d.bukti,month(tgl) as bln,year(tgl) as thn,cha,dk,d.nilai from bankkd d 
							 left outer join bankk t on(t.bukti=d.bukti)
							 union all
							 select d.bukti,month(tgl) as bln,year(tgl) as thn,cha,dk,d.nilai from jurumd d 
							 left outer join jurum t on(t.bukti=d.bukti)
							 ");
	if (mysqli_num_rows($q)>0) 
	{
		$i=0; 
		while($row = mysqli_fetch_array($q)) {
			extract($row);
			if(($thn!='')&&($cha!='')){
				if(AdaData("select cha from mut_saldo where thn=$thn and cha='$cha'"))
				{
				   if($dk=='D') 
					   $sql="update mut_saldo set d$bln=d$bln+$nilai where thn=$thn and cha='$cha'";		
				   else $sql="update mut_saldo set k$bln=k$bln+$nilai where thn=$thn and cha='$cha'";		
				   echo $sql.";<br>";
				   $result = mysqli_query($conn,$sql);  
				} else {
				   if($dk=='D') 
				       $sql="insert into mut_saldo(thn,cha,d$bln) values($thn,'$cha',$nilai)";
                   else $sql="insert into mut_saldo(thn,cha,k$bln) values($thn,'$cha',$nilai)"; 
				   echo $sql.";<br>";				   
				   $result = mysqli_query($conn,$sql);  	
				}  
			}
		}
    }