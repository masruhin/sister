<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';

$prd 	=periode("PENJUALAN");
$id 	=$_GET['id'];
$bny 	=$_GET['bny'];

$query1 	=mysql_query("	SELECT 	t_dtlbmb.*
						FROM 	t_dtlbmb
						WHERE 	t_dtlbmb.id	='". mysql_escape_string($id)."'");
$result2 =mysql_fetch_array($query1);

$kdebrn 	=$result2['kdebrn'];

$query 	="	DELETE 
			FROM 	{$prefix}t_dtlbmb 
			where 	id ='$id'";
mysql_query($query);


$query 	=mysql_query("	SELECT 	t_sldbrn.*
						FROM 	t_sldbrn
						WHERE 	t_sldbrn.prd	='". mysql_escape_string($prd)."'	AND
								t_sldbrn.kdebrn	='". mysql_escape_string($kdebrn)."'");
$result =mysql_fetch_assoc($query);
$msk 	=$result['msk']-$bny;
		
$query 	="	UPDATE 	t_sldbrn
			SET		t_sldbrn.msk	='". mysql_escape_string($msk)."'
			WHERE 	t_sldbrn.prd	='". mysql_escape_string($prd)."'	AND
					t_sldbrn.kdebrn	='". mysql_escape_string($kdebrn)."'";
$result	=mysql_query ($query);
?>