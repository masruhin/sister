<?php
//----------------------------------------------------------------------------------------------------
//Program		: S1D04A.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi MATERI PELAJARAN
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class S1D04Bclass
{
	// -------------------------------------------------- Item --------------------------------------------------
	function S1D04B()
	{   $user	=$_SESSION["Admin"]["nis"];
        $kdekls	=$_SESSION["Admin"]["kdekls"];
		require_once '../fungsi_umum/sysconfig.php';
         // untuk mendapatkan kode kelompok
        $query	="	SELECT 	t_mstssw.*,t_jdwplj.type
					FROM 	t_mstssw,t_jdwplj
					WHERE	t_mstssw.nis	='$user' 		AND
							t_mstssw.kdekls	=t_jdwplj.kdekls ";
		$result= mysql_query($query)	or die (mysql_error());
        $data	=mysql_fetch_array($result);
        $kdekls = $data['kdekls'];
        $kdeplj=$data['kdeplj'];
        $type=$data['type'];
        $jdwplj='../files/jadwal/'.$kdekls.'/'.$kdekls.'.'.$type;

        if(file_exists($jdwplj))
        {
		echo"
        <center>
        <iframe src='../files/jadwal/$kdekls/$kdekls.$type' width='99%' height='460' scrolling='no'>
        </iframe></center>
		";
        }
        else
        {
          echo"<center>
        <iframe src='#' width='99%' height='460' scrolling='no' frameborder='0'>
        </iframe></center>";
        }

	}
}//akhir class
?>