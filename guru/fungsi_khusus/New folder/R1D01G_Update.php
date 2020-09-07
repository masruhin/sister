<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';

        //$kdegru	=$_GET['kdegru'];
  		$stt	=$_GET['stt'];
        $di     ='Disabled';
        $en     ='Enabled';
  		//$nmarpp=$_POST['nmarpp'];
        $id    =$_GET['id'];
        if($stt=='Disabled')
        {
		$set	="	SET		g_dtlrpp.stt	='". mysql_escape_string($en)."'";

    	$query 	="	UPDATE 	g_dtlrpp ".$set.
		         "	WHERE 	g_dtlrpp.id='". mysql_escape_string($id)."'";
		$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
        }

        else
        if($stt=='Enabled')
        {
		$set	="	SET		g_dtlrpp.stt	='". mysql_escape_string($di)."'";

    	$query 	="	UPDATE 	g_dtlrpp ".$set.
		         "	WHERE 	g_dtlrpp.id='". mysql_escape_string($id)."'";
		$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
        }
        echo"$id";
?>