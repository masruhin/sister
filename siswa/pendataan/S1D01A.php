<?php
//----------------------------------------------------------------------------------------------------
//Program		: S1D01A.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi MATERI PELAJARAN
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class S1D01Aclass
{
	// -------------------------------------------------- Item --------------------------------------------------
	function S1D01A()
	{
		require_once '../fungsi_umum/sysconfig.php';

		// deklarasi java
		echo"
		<LINK 	href='../css/val.css' 		rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 		src='../js/jquery-validate.js'></SCRIPT>";
		
		echo"<SCRIPT TYPE='text/javascript' 		src='../siswa/js/S1D01A.js'></SCRIPT>";
		
		$nis	=$_SESSION["Admin"]["nis"];
        $kdekls	=$_SESSION["Admin"]["kdekls"];

         // untuk mendapatkan kode guru
        $query	="	SELECT 	t_mstssw.*,t_mstpng.kdegru,t_mstkls.kdeklm
					FROM 	t_mstssw,t_mstpng,t_mstkls
					WHERE	t_mstssw.nis	='$nis' 		AND
							t_mstssw.kdekls	=t_mstpng.kdekls AND
                            t_mstpng.kdekls=t_mstkls.kdekls";
		$result= mysql_query($query)	or die (mysql_error());
        $data	=mysql_fetch_array($result);
        $kdegru	=$data['kdegru'];
        $kdeklm = $data['kdeklm'];

		// akhir inisiasi parameter
		$query ="	SELECT 		g_dtlmtr.*
					FROM  		g_dtlmtr
					WHERE 		g_dtlmtr.kdemtr='". mysql_escape_string($kdemtr)."'
					ORDER BY	g_dtlmtr.id";
		$result= mysql_query($query)	or die (mysql_error());

		echo"
		<FORM METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>MATERI PELAJARAN</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Pelajaran</TD>
					<TD WIDTH='85%'>:
						<INPUT TYPE='hidden' NAME='kdegru'  id='kdegru'	VALUE='$kdegru'>
						<INPUT TYPE='hidden' NAME='kdeklm'  id='kdeklm'	VALUE='$kdeklm'>
						<SELECT NAME	='kdeplj'
								ID		='kdeplj'
								class	='kdeplj'
								value='$kdeplj'
								$isian1>
						<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
						$query="	SELECT 		DISTINCT t_mstplj.kdeplj,t_mstplj.nmaplj
									FROM 		t_mstssw,t_mstpng,t_mstplj
									WHERE		t_mstssw.nis	='$nis' 			AND
												t_mstssw.kdekls	=t_mstpng.kdekls 	AND
												t_mstpng.kdeplj	=t_mstplj.kdeplj";
						$result= mysql_query($query)	or die (mysql_error());
							
						while($data=mysql_fetch_array($result))
						{
							if($kdeplj==$data[kdeplj])
								echo"<OPTION VALUE='$data[kdeplj]' SELECTED>$data[nmaplj]</OPTION>";
							else
								echo"<OPTION VALUE='$data[kdeplj]'>$data[nmaplj]</OPTION>";
						}
						echo"
						</SELECT>
					</TD>
				</TR>
			</TABLE>	

			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR>
					<TD WIDTH='100%'>
						<div style='overflow:auto;width:100%;height:380px;padding-right:-2px;'>                
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' >
								<TR bgcolor='dedede'>
									<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
									<TD WIDTH='96%'><CENTER>Judul Materi  	</CENTER></TD>
								</TR>
								<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%' id='modul'>
								</TABLE>
							</TABLE>
						</DIV>
					</TD>
				</TR>
			</TABLE>
		</FORM>";
	}
}//akhir class
?>