<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: J5L05.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 26/12/2011
//Keterangan	: Fungsi-fungsi LAPORAN PERSEDIAAN
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<H1>Permission Denied</H1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class J5L05class
{	
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function J5L05()
	{
		echo"
		<SCRIPT TYPE='text/javascript'>
			function buatprd()
			{
				document.f1.prd.value = document.f1.tahun.value + document.f1.bln.value;
			}
		</SCRIPT>";

		$klm.="<SELECT NAME=kdeklm id=kop><OPTION VALUE='' SELECTED>--Semua--</OPTION>";
		$query="	SELECT  		kdeklm,nmaklm
					FROM 			t_klmbrn 
					ORDER BY 		kdeklm";
		if(!$q=mysql_query($query)) die ("Pengambilan gagal1 kelas ");
		while($row=mysql_fetch_array($q))
		{
			$klm.="<OPTION VALUE='$row[kdeklm]'>$row[kdeklm]-$row[nmaklm]</OPTION>";
		}
		$klm.='</SELECT>';
		
		echo"
		<FORM ACTION='laporan/J5L05_Cetak.php' target=_blank METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE  BORDER='0' CELLSPACING='5' CELLPADDING='5' BORDERCOLOR='#000000' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>LAPORAN PERSEDIAAN</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Periode</TD>
                    <TD WIDTH='85%'>:  
						<SELECT NAME='bln' id='bln' onchange='buatprd()'>
                            <OPTION VALUE=''>Pilih
							<OPTION VALUE='01'>Januari
							<OPTION VALUE='02'>Februari
							<OPTION VALUE='03'>Maret
							<OPTION VALUE='04'>April
							<OPTION VALUE='05'>Mei
							<OPTION VALUE='06'>Juni
							<OPTION VALUE='07'>Juli
							<OPTION VALUE='08'>Agustus
							<OPTION VALUE='09'>September
							<OPTION VALUE='10'>Oktober
							<OPTION VALUE='11'>November
							<OPTION VALUE='12'>Desember
							</OPTION>
                        </SELECT>
						 
						<SELECT NAME='tahun' id='tahun' onchange='buatprd()'>
							<OPTION VALUE=''>Pilih
                            <OPTION VALUE='11'>2011
                            <OPTION VALUE='12'>2012
                            <OPTION VALUE='13'>2013
                            <OPTION VALUE='14'>2014
                            <OPTION VALUE='15'>2015
                            <OPTION VALUE='16'>2016
                            <OPTION VALUE='17'>2017
                            <OPTION VALUE='18'>2018
                            <OPTION VALUE='19'>2019
                            <OPTION VALUE='20'>2020
                            <OPTION VALUE='21'>2021
                            <OPTION VALUE='22'>2022
						</SELECT>
						<INPUT TYPE='hidden' name='prd' id='prd'>
					</TD>
				</TR>
				<TR><TD>Kelompok Barang</TD>
					<TD>: $klm</TD>
				</TR>
			</TABLE>
			<INPUT TYPE=submit 	VALUE=Cetak>
		</FORM>";
	}
}
?>