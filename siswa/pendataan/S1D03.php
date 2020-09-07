<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi KEHADIRAN
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class S1D03class
{
	// -------------------------------------------------- Item --------------------------------------------------
	function S1D03()
	{
		require_once '../fungsi_umum/sysconfig.php';

		// deklarasi java
		echo"
		<LINK 	href='../css/val.css' 		rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 		src='../js/jquery-validate.js'></SCRIPT>";

		echo"<SCRIPT TYPE='text/javascript' 		src='../siswa/js/S1D03.js'></SCRIPT>";
		
		$user	=$_SESSION["Admin"]["nis"];
        $kelas	=$_SESSION["Admin"]["kdekls"];
		
         // untuk mendapatkan kode guru
        $query	="	SELECT 	t_mstssw.*,t_mstpng.kdegru
					FROM 	t_mstssw,t_mstpng
					WHERE	t_mstssw.nis='$user' AND
							t_mstssw.kdekls=t_mstpng.kdekls";
		$result= mysql_query($query)	or die (mysql_error());
        $data	=mysql_fetch_array($result);
        $kdegru	=$data['kdegru'];

		// akhir inisiasi parameter
		$query ="	SELECT 		g_dtlmtr.*
					FROM  		g_dtlmtr
					WHERE 		g_dtlmtr.kdemtr='". mysql_escape_string($kdemtr)."'
					ORDER BY	g_dtlmtr.id";
		$result= mysql_query($query)	or die (mysql_error());

		echo"
		<FORM METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>KEHADIRAN</B></TD></TR>
				<TR></TR><TR></TR>
				<TR>
					<TD WIDTH='90%'>
						<INPUT TYPE='hidden' NAME='nis'  	id='nis'	VALUE='$user'>
						<INPUT TYPE='hidden' NAME='blnabs'  id='blnabs'	VALUE=''>
						<INPUT TYPE='hidden' NAME='kdekls'  id='kdekls'	VALUE='$kelas'>
						Bulan : 
						<SELECT NAME	='blnab'
								ID		='blnab'
								class	='blnab'
								$isian1>
						<OPTION VALUE='' SELECTED>--Pilih--</OPTION>
						<OPTION VALUE='01'> Januari </option>
						<OPTION VALUE='02'> Februari </option>
						<OPTION VALUE='03'> Maret </option>
						<OPTION VALUE='04'> April </option>
						<OPTION VALUE='05'> Mei </option>
						<OPTION VALUE='06'> Juni </option>
						<OPTION VALUE='07'> Juli </option>
						<OPTION VALUE='08'> Agustus </option>
						<OPTION VALUE='09'> September </option>
						<OPTION VALUE='10'> Oktober </option>
						<OPTION VALUE='11'> November </option>
						<OPTION VALUE='12'> Desember </option>
						</SELECT>
						Tahun : 
						<SELECT NAME	='thnabs'
								ID		='thnabs'
								class	='thnabs'
								disabled>
						<OPTION VALUE='' SELECTED>--Pilih--</OPTION>
						<OPTION VALUE='2012'> 2012 </option>
						<OPTION VALUE='2013'> 2013 </option>
						<OPTION VALUE='2014'> 2014 </option>
						<OPTION VALUE='2015'> 2015 </option>
						<OPTION VALUE='2016'> 2016 </option>
						<OPTION VALUE='2017'> 2017 </option>
						<OPTION VALUE='2018'> 2018 </option>
						<OPTION VALUE='2019'> 2019 </option>
						<OPTION VALUE='2020'> 2020 </option>
						</SELECT>
						<input type='button' id='ulang' value='Ulang'>
					</TD>
                </TR>
			</TABLE>	

			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR>
					<TD WIDTH='100%'>
						<div style='overflow:auto;width:100%;height:380px;padding-right:-2px;'>                
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' >
								<TR bgcolor='dedede'>
									<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No</CENTER></TD>
									<TD WIDTH='10%'><CENTER>Tanggal		</CENTER></TD>
									<TD WIDTH='10%'><CENTER>Absen		</CENTER>  </TD>
									<TD WIDTH='76%'><CENTER>Keterangan	</CENTER> </TD>
								</TR>
								<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='4' WIDTH='100%' id='hadir'>
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