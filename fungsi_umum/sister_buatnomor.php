<?php
function nomor_btuk($prd)
{
	$query	=mysql_query("	SELECT 		t_btukng.* 
							FROM 		t_btukng 
							WHERE 		substr(t_btukng.nmrbtu,4,4)	='$prd'	
							ORDER BY 	t_btukng.nmrbtu desc");
	$result =mysql_fetch_assoc($query);
	$id_old =$result['nmrbtu'];
	$code	='BTU';

	if(mysql_num_rows($query) == 0)
	{
		$nmrbtu = $code.$prd."00001";
	}
	else
	{
		$code 	=substr($id_old,0,3).$prd;
		$no_auto=(int)substr($id_old,-5);
		if($no_auto==99999)
		{
			$no_auto = 0;
		}
		$no_auto=$no_auto + 1;
		$no_auto=substr("0000".$no_auto,-5);
		$nmrbtu=$code.$no_auto;
	}	
	return $nmrbtu;
}

function nomor_bkuk($prd)
{
	$query	=mysql_query("	SELECT 		t_bkukng.* 
							FROM 		t_bkukng 
							WHERE 		substr(t_bkukng.nmrbku,4,4)	='$prd'	
							ORDER BY 	t_bkukng.nmrbku desc");
	$result =mysql_fetch_assoc($query);
	$id_old =$result['nmrbku'];
	$code	='BKU';

	if(mysql_num_rows($query) == 0)
	{
		$nmrbku = $code.$prd."00001";
	}
	else
	{
		$code 	=substr($id_old,0,3).$prd;
		$no_auto=(int)substr($id_old,-5);
		if($no_auto==99999)
		{
			$no_auto = 0;
		}
		$no_auto=$no_auto + 1;
		$no_auto=substr("0000".$no_auto,-5);
		$nmrbku=$code.$no_auto;
	}	
	return $nmrbku;
}

function nomor_bkbj($prd)
{
	$query	=mysql_query("	SELECT 		t_gnrbkb.* 
							FROM 		t_gnrbkb 
							WHERE 		substr(t_gnrbkb.nmrbkb,4,4)	='$prd'	
							ORDER BY 	t_gnrbkb.nmrbkb desc");
	$result =mysql_fetch_assoc($query);
	$id_old =$result['nmrbkb'];
	$code	='BKB';

	if(mysql_num_rows($query) == 0)
	{
		$nmrbkb = $code.$prd."00001";
	}
	else
	{
		$code 	=substr($id_old,0,3).$prd;
		$no_auto=(int)substr($id_old,-5);
		if($no_auto==99999)
		{
			$no_auto = 0;
		}
		$no_auto=$no_auto + 1;
		$no_auto=substr("0000".$no_auto,-5);
		$nmrbkb=$code.$no_auto;
	}	
	return $nmrbkb;
}

function nomor_bmbj($prd)
{
	$query	=mysql_query("	SELECT 		t_gnrbmb.*
							FROM 		t_gnrbmb
							WHERE 		substr(t_gnrbmb.nmrbmb,4,4)	='$prd'
							ORDER BY 	t_gnrbmb.nmrbmb desc");
	$result =mysql_fetch_assoc($query);
	$id_old =$result['nmrbmb'];
	$code	='BMB';

	if(mysql_num_rows($query) == 0)
	{
		$nmrbmb = $code.$prd."00001";
	}
	else
	{
		$code 	=substr($id_old,0,3).$prd;
		$no_auto=(int)substr($id_old,-5);
		if($no_auto==99999)
		{
			$no_auto = 0;
		}
		$no_auto=$no_auto + 1;
		$no_auto=substr("0000".$no_auto,-5);
		$nmrbmb=$code.$no_auto;
	}
	return $nmrbmb;
}

function nomor_pnj($prd)
{
	$query	=mysql_query("	SELECT 		t_gnrpnj.*
							FROM 		t_gnrpnj
							WHERE 		substr(t_gnrpnj.nmrpnj,4,4)	='$prd'
							ORDER BY 	t_gnrpnj.nmrpnj desc");
	$result =mysql_fetch_assoc($query);
	$id_old =$result['nmrpnj'];
	$code	='PNJ';

	if(mysql_num_rows($query) == 0)
	{
		$nmrpnj = $code.$prd."00001";
	}
	else
	{
		$code 	=substr($id_old,0,3).$prd;
		$no_auto=(int)substr($id_old,-5);
		if($no_auto==99999)
		{
			$no_auto = 0;
		}
		$no_auto=$no_auto + 1;
		$no_auto=substr("0000".$no_auto,-5);
		$nmrpnj=$code.$no_auto;
	}
	return $nmrpnj;
}

function nomor_pjm()
{
	$userid_x	=$_SESSION["Admin"]["userid"];	// buatan d $userid_x
	$query	=mysql_query("	SELECT 		t_gnrpjm.*
							FROM 		t_gnrpjm
							WHERE		t_gnrpjm.nmrpjm LIKE 'PJM".$userid_x."%'
							ORDER BY 	t_gnrpjm.nmrpjm desc"); // WHERE		t_gnrpjm.nmrpjm LIKE 'PJM".$userid_x."%'	tambah buatan
	$result =mysql_fetch_assoc($query);
	$id_old =$result['nmrpjm'];
	$code	='PJM';

	if(mysql_num_rows($query) == 0)
	{
		$nmrpjm = $code."0000001";
	}
	else
	{
		$code 	=substr($id_old,0,3);
		$no_auto=(int)substr($id_old,-7);
		if($no_auto==9999999)
		{
			$no_auto = 0;
		}
		$no_auto=$no_auto + 1;
		$no_auto=substr("000000".$no_auto,-7);
		//$nmrpjm=$code.$no_auto;
		$nmrpjm=$code.$userid_x.$no_auto;	// buatan d $userid_x
	}
	return $nmrpjm;
}

function nomor_soal($kdeplj)
{
    $user	=$_SESSION["Admin"]["kdekry"];
	$query	=mysql_query("	SELECT 		g_gnrsal.*
							FROM 		g_gnrsal
							where 		g_gnrsal.kdeplj='$kdeplj'
							ORDER BY 	g_gnrsal.kdesl desc");
	$result =mysql_fetch_assoc($query);
	$id_old =$result['kdesl'];
	$code	='SL';

	if(mysql_num_rows($query) == 0)
	{
		$kdesl = $code.$kdeplj."00001";
	}
	else
	{
		$code 	=substr($id_old,0,2).$kdeplj;
		$no_auto=(int)substr($id_old,-5);
		if($no_auto==99999)
		{
			$no_auto = 0;
		}
		$no_auto=$no_auto + 1;
		$no_auto=substr("0000".$no_auto,-5);
		$kdesl=$code.$no_auto;
	}
	return $kdesl;
}

function nomor_rcu($kdeplj)
{
	$query	=mysql_query("	SELECT 		g_gnrrcu.*
							FROM 		g_gnrrcu
                            where 		g_gnrrcu.kdeplj='$kdeplj'
							ORDER BY 	g_gnrrcu.kdercu desc");
	$result =mysql_fetch_assoc($query);
	$id_old =$result['kdercu'];
	$code	='RCU';

	if(mysql_num_rows($query) == 0)
	{
		$kdercu = $code.$kdeplj."00001";
	}
	else
	{
		$code 	=substr($id_old,0,3).$kdeplj;
		$no_auto=(int)substr($id_old,-5);
		if($no_auto==99999)
		{
			$no_auto = 0;
		}
		$no_auto=$no_auto + 1;
		$no_auto=substr("0000".$no_auto,-5);
		$kdercu=$code.$no_auto;
	}
	return $kdercu;
}

function nomor_mtr()
{
	$query	=mysql_query("	SELECT 		g_gnrmtr.*
							FROM 		g_gnrmtr
							ORDER BY 	g_gnrmtr.kdemtr desc");
	$result =mysql_fetch_assoc($query);
	$id_old =$result['kdemtr'];
	$code	='MTR';

	if(mysql_num_rows($query) == 0)
	{
		$kdemtr = $code."0000001";
	}
	else
	{
		$code 	=substr($id_old,0,3);
		$no_auto=(int)substr($id_old,-7);
		if($no_auto==9999999)
		{
			$no_auto = 0;
		}
		$no_auto=$no_auto + 1;
		$no_auto=substr("000000".$no_auto,-7);
		$kdemtr=$code.$no_auto;
	}
	return $kdemtr;
}

function nomor_rpp()
{
	$query	=mysql_query("	SELECT 		g_gnrrpp.*
							FROM 		g_gnrrpp
							ORDER BY 	g_gnrrpp.kderpp desc");
	$result =mysql_fetch_assoc($query);
	$id_old =$result['kderpp'];
	$code	='RPP';

	if(mysql_num_rows($query) == 0)
	{
		$kderpp = $code."0000001";
	}
	else
	{
		$code 	=substr($id_old,0,3);
		$no_auto=(int)substr($id_old,-7);
		if($no_auto==9999999)
		{
			$no_auto = 0;
		}
		$no_auto=$no_auto + 1;
		$no_auto=substr("000000".$no_auto,-7);
		$kderpp=$code.$no_auto;
	}
	return $kderpp;
}

function nomor_bsl()
{
	$query	=mysql_query("	SELECT 		g_gnrbsl.*
							FROM 		g_gnrbsl
							ORDER BY 	g_gnrbsl.kdebsl desc");
	$result =mysql_fetch_assoc($query);
	$id_old =$result['kdebsl'];
	$code	='BSL';

	if(mysql_num_rows($query) == 0)
	{
		$kdebsl = $code."0000001";
	}
	else
	{
		$code 	=substr($id_old,0,3);
		$no_auto=(int)substr($id_old,-7);
		if($no_auto==9999999)
		{
			$no_auto = 0;
		}
		$no_auto=$no_auto + 1;
		$no_auto=substr("000000".$no_auto,-7);
		$kdebsl=$code.$no_auto;
	}
	return $kdebsl;
}

function nomor_utq()
{
	$query	=mysql_query("	SELECT 		g_gnrutq.*
							FROM 		g_gnrutq
							ORDER BY 	g_gnrutq.kdeutq desc");
	$result =mysql_fetch_assoc($query);
	$id_old =$result['kdeutq'];
	$code	='UTQ';

	if(mysql_num_rows($query) == 0)
	{
		$kdeutq = $code."0000001";
	}
	else
	{
		$code 	=substr($id_old,0,3);
		$no_auto=(int)substr($id_old,-7);
		if($no_auto==9999999)
		{
			$no_auto = 0;
		}
		$no_auto=$no_auto + 1;
		$no_auto=substr("000000".$no_auto,-7);
		$kdeutq=$code.$no_auto;
	}
	return $kdeutq;
}

function nomor_krk()
{
	$query	=mysql_query("	SELECT 		g_gnrkrk.*
							FROM 		g_gnrkrk
							ORDER BY 	g_gnrkrk.kdekrk desc");
	$result =mysql_fetch_assoc($query);
	$id_old =$result['kdekrk'];
	$code	='KRK';

	if(mysql_num_rows($query) == 0)
	{
		$kdekrk = $code."0000001";
	}
	else
	{
		$code 	=substr($id_old,0,3);
		$no_auto=(int)substr($id_old,-7);
		if($no_auto==9999999)
		{
			$no_auto = 0;
		}
		$no_auto=$no_auto + 1;
		$no_auto=substr("000000".$no_auto,-7);
		$kdekrk=$code.$no_auto;
	}
	return $kdekrk;
}

function nomor_tgs()
{
	$query	=mysql_query("	SELECT 		g_gnrtgs.*
							FROM 		g_gnrtgs
							ORDER BY 	g_gnrtgs.kdetgs desc");
	$result =mysql_fetch_assoc($query);
	$id_old =$result['kdetgs'];
	$code	='TGS';

	if(mysql_num_rows($query) == 0)
	{
		$kdetgs = $code."0000001";
	}
	else
	{
		$code 	=substr($id_old,0,3);
		$no_auto=(int)substr($id_old,-7);
		if($no_auto==9999999)
		{
			$no_auto = 0;
		}
		$no_auto=$no_auto + 1;
		$no_auto=substr("000000".$no_auto,-7);
		$kdetgs=$code.$no_auto;
	}
	return $kdetgs;
}

function nomor_ujian($kdeplj,$kls)
{
    $user	=$_SESSION["Admin"]["nis"];
	$query	=mysql_query("	SELECT 		u_gnroln.*
							FROM 		u_gnroln
							WHERE 		u_gnroln.kdeoln LIKE '%$kdeplj%' AND 
										u_gnroln.kdeoln LIKE '%$kls%'
							ORDER BY 	u_gnroln.kdeoln desc");
	$result =mysql_fetch_assoc($query);
	$id_old =$result['kdeoln'];
	$code	='UO';

	if(mysql_num_rows($query) == 0)
	{
		$kdeoln = $code.$kdeplj."00001";
	}
	else
	{
		$code 	=substr($id_old,0,2).$kdeplj.$kls;
		$no_auto=(int)substr($id_old,-5);
		if($no_auto==99999)
		{
			$no_auto = 0;
		}
		$no_auto=$no_auto + 1;
		$no_auto=substr("0000".$no_auto,-5);
		$kdeoln=$code.$no_auto;
	}
	return $kdeoln;
}

function nomor_nli()
{
	$query	=mysql_query("	SELECT 		g_gnrnli.*
							FROM 		g_gnrnli
							ORDER BY 	g_gnrnli.kdenli desc");
	$result =mysql_fetch_assoc($query);
	$id_old =$result['kdenli'];
	$code	='NLI';

	if(mysql_num_rows($query) == 0)
	{
		$kdenli = $code."0000001";
	}
	else
	{
		$code 	=substr($id_old,0,3);
		$no_auto=(int)substr($id_old,-7);
		if($no_auto==9999999)
		{
			$no_auto = 0;
		}
		$no_auto=$no_auto + 1;
		$no_auto=substr("000000".$no_auto,-7);
		$kdenli=$code.$no_auto;
	}
	return $kdenli;
}
function nomor_krm()
{
	$query	=mysql_query("	SELECT 		g_krmeml.*
							FROM 		g_krmeml
							ORDER BY 	g_krmeml.kdekrm desc");
	$result =mysql_fetch_assoc($query);
	$id_old =$result['kdekrm'];
	$code	='EML';

	if(mysql_num_rows($query) == 0)
	{
		$kdekrm = $code."0000001";
	}
	else
	{
		$code 	=substr($id_old,0,3);
		$no_auto=(int)substr($id_old,-7);
		if($no_auto==9999999)
		{
			$no_auto = 0;
		}
		$no_auto=$no_auto + 1;
		$no_auto=substr("000000".$no_auto,-7);
		$kdekrm=$code.$no_auto;
	}
	return $kdekrm;
}
?>