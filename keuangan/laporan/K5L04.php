<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: K5L04.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Fungsi-fungsi LAPORAN TUNGGAKAN
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class K5L04class
{	
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function K5L04()
	{
		echo'<script TYPE="text/javascript" src="../js/DatePicker/WdatePicker.js"></script>';
		
		echo"
		<FORM ACTION='laporan/K5L04_Cetak.php' target=_blank METHOD=post NAME=f1 ENCTYPE=multipart/form-data>
			<TABLE  BORDER='0' CELLSPACING='5' CELLPADDING='5' BORDERCOLOR='#000000' WIDTH=100% >
				<TR><TD COLSPAN=2><B>LAPORAN TUNGGAKAN</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Kelas</TD>
					<TD WIDTH='85%'>:
						<SELECT NAME		='kdekls'
								ID			='kdekls'
								VALUE 		='$kdekls'
								ONKEYUP		='uppercase(this.id)'>";
						$query2="	SELECT 		t_mstkls.*
									FROM 		t_mstkls
									ORDER BY 	t_mstkls.kdeklm,t_mstkls.kdekls";
						$result2=mysql_query($query2);
						echo"
						<OPTION VALUE='' SELECTED>--Semua--</OPTION>";
						while($data2=mysql_fetch_array($result2))
						{
							if ($kdekls==$data2[kdekls])
								echo"<OPTION VALUE='$data2[kdekls]' SELECTED>$data2[kdekls]</OPTION>";
							else
								echo"<OPTION VALUE='$data2[kdekls]'>$data2[kdekls]</OPTION>";
						}
						echo"
						</SELECT>
					</TD>
				</TR>				
				<TR><TD>Jenis Penerimaan</TD>
					<TD>: 
						<SELECT	NAME		='kdejtu'	
								VALUE 		='$kdejtu'
								onkeypress	='return enter(this,event)'>";
						$query	="	SELECT 		t_jtu.* 
									FROM 		t_jtu  
									ORDER BY 	t_jtu.kdejtu";
    					$result		=mysql_query($query);
    					while($data=mysql_fetch_array($result))
    					{
							if ($kdejtu==$data[kdejtu]) 
								echo"<OPTION VALUE='$data[kdejtu]' SELECTED>$data[nmajtu]</OPTION>";
  	  						else 
								echo"<OPTION VALUE='$data[kdejtu]' >$data[nmajtu]</OPTION>";
    					}
       					echo
						"</SELECT>		
					</TD>
				</TR>	
			</TABLE>
			<INPUT TYPE=submit 	VALUE=Cetak>
		</FORM>";
	}
}
?>