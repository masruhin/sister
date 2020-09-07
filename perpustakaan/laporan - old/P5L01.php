<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: P5L01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 07/12/2011
//Keterangan	: Fungsi-fungsi LAPORAN BUKTI TERIMA UANG
//----------------------------------------------------------------------------------------------------
//	PERPUSTAKAAN
//		laporan
//			buku dipinjam
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class P5L01class
{	
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function P5L01()
	{
		echo'<script TYPE="text/javascript" src="../js/DatePicker/WdatePicker.js"></script>';
		
		echo"
		<FORM ACTION='laporan/P5L01_Cetak.php' target=_blank METHOD=post NAME=f1 ENCTYPE=multipart/form-data>
			<TABLE  BORDER='0' CELLSPACING='5' CELLPADDING='5' BORDERCOLOR='#000000' WIDTH=100% >
				<TR><TD COLSPAN=2><B>LAPORAN BUKU DIPINJAM</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD>Kategori</TD>
					<TD>: 
						<SELECT	NAME		='kdektg'	
								VALUE 		='$kdektg'
								onkeypress	='return enter(this,event)'>";
						$query	="	SELECT 		t_ktg.* 
									FROM 		t_ktg  
									ORDER BY 	t_ktg.kdektg";
    					$result		=mysql_query($query);
						echo"
						<OPTION VALUE='' SELECTED>--Semua--</OPTION>";
    					while($data=mysql_fetch_array($result))
    					{
							if ($kdektg==$data[kdektg]) 
								echo 
								"<OPTION VALUE='$data[kdektg]' SELECTED>$data[nmaktg]</OPTION>";
  	  						else 
								echo 
								"<OPTION VALUE='$data[kdektg]' >$data[nmaktg]</OPTION>";
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