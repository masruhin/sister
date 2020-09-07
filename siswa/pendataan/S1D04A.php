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
class S1D04Aclass
{
	// -------------------------------------------------- Item --------------------------------------------------
	function S1D04A()
	{   $user	=$_SESSION["Admin"]["nis"];
        $kdekls	=$_SESSION["Admin"]["kdekls"];
		require_once '../fungsi_umum/sysconfig.php';
         // untuk mendapatkan kode kelompok
        $query	="	SELECT 	t_mstssw.*,t_mstkls.kdeklm,t_mstslb.kdeplj,t_mstslb.type,t_mstplj.nmaplj
					FROM 	t_mstssw,t_mstkls,t_mstslb,t_mstplj
					WHERE	t_mstssw.nis	='$user' 		AND
							t_mstssw.kdekls	=t_mstkls.kdekls AND
                            t_mstkls.kdeklm=t_mstslb.kdeklm AND
                            t_mstslb.kdeplj=t_mstplj.kdeplj";
		$result= mysql_query($query)	or die (mysql_error());

        echo"
		<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>SILABUS</B></TD></TR>
				<TR></TR><TR></TR>
				</TABLE>
        <div style='overflow:auto;width:100%;height:430px;padding-left:7px;'>
        <TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='80%'>
        <TR bgcolor='dedede'>
		<TD WIDTH=' 2%' HEIGHT='20'><CENTER>No	</CENTER></TD>
		<TD WIDTH='16%'><CENTER>Pelajaran  	</CENTER></TD>
		</TR>";
        $no=0;
        while($data	=mysql_fetch_array($result))
        {
        $kdeklm = $data['kdeklm'];
        $kdeplj=$data['kdeplj'];
        $nmaplj=$data['nmaplj'];
        $type=$data['type'];
        $no++;
		echo"

        <TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\" class='focus'>
		<TD WIDTH=' 2%' HEIGHT='20'><CENTER>$no</CENTER></TD>
		<TD WIDTH='26%'> <a href='../files/silabus/$kdeplj/$kdeklm$kdeplj.$type' target='silabus'><img src='../images/icon_pdf_e.gif'>$nmaplj</a></TD>
		</TR>
		";
        }
        echo"</TABLE></div><td WIDTH='76%'>
        <iframe name='silabus' src='#' align='top'  frameborder='0' height='450' width='99%'></iframe></td>";
	}
}//akhir class
?>