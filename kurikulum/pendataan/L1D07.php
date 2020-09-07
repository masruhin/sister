<?php
//----------------------------------------------------------------------------------------------------
//Program		: L1D07.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi BOBOT NILAI
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class L1D07class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function L1D07_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdebbt	=$_GET['kdebbt'];

		$query ="	SELECT 		t_mstbbt.* 
					FROM 		t_mstbbt
					WHERE 		(t_mstbbt.kdebbt LIKE'%".$kdebbt."%' OR '$kdebbt'='')
					ORDER BY 	t_mstbbt.kdebbt";
		$result	=mysql_query($query)	or die (mysql_error());

		echo"
		<FORM ACTION=kurikulum.php METHOD='get'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>BOBOT NILAI</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='15%'>Kode Bobot</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdebbt'
								ID			='kdebbt'
								TYPE		='text' 		
								SIZE		='3' 
								MAXLENGTH	='3'
								onkeyup		='uppercase(this.id)'>								
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='L1D07_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='kurikulum.php?mode=L1D07_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM ACTION='kurikulum.php?mode=L1D07' METHOD='post' >
			<DIV style='overflow:auto;width:100%;height:400px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No			</CENTER></TD>
						<TD WIDTH=' 5%'><CENTER>Kode 		</CENTER></TD>
						<TD WIDTH='74%'><CENTER>Nama Bobot	</CENTER></TD>
						<TD WIDTH=' 9%'><CENTER>Bobot (%)	</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Detil		</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Edit		</CENTER></TD>
					</TR>";

					$no=0;
					while($data =mysql_fetch_array($result))
					{
						$no++;
						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
							<TD><CENTER>$no			</CENTER></TD>
							<TD><center>$data[kdebbt]</center></TD>
							<TD><center>$data[nmabbt]</center></TD>
							<TD><center>$data[bbt]</center></TD>";
						
							// otorisasi akses detil
							if (hakakses("L1D07")==1)
							{
								echo"
								<TD><CENTER><a href='kurikulum.php?mode=L1D07&kdebbt=$data[kdebbt]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
							}
						
							// otorisasi akses edit
							if (hakakses("L1D07")==1)
							{		
								echo"
								<TD><CENTER><a href='kurikulum.php?mode=L1D07&kdebbt=$data[kdebbt]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/edit_d.gif' 	BORDER='0'></a></CENTER></TD>";
							}	
						echo"	
						</TR>";
					}
				echo"	
				</TABLE>
			</DIV>";
		echo"
		</FORM>";
 	}

	// -------------------------------------------------- Detil --------------------------------------------------
	function L1D07()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		echo"
		<SCRIPT TYPE='text/javascript' src='../js/jquery-1.2.3.pack.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' src='../js/jquery.validate.pack.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript'>
			$(document).ready(function()
			{
				$('#validasi').validate()
			});
		</SCRIPT>";

		// inisiasi parameter berdasarkan pilihan tombol
		$pilihan=$_GET['pilihan'];

		if (empty($pilihan))
		{
			$pilihan='detil';
		}

		switch($pilihan)
		{
			case 'detil':
				$isian	='disabled';
				break;
			case 'edit':
				$isian	='enable';
				break;
		}		
		
		if ($pilihan=='detil' OR $pilihan=='edit')
		{
			$kdebbtB=$_GET['kdebbt'];
			$query 	="	SELECT 	t_mstbbt.* 
						FROM 	t_mstbbt
						WHERE 	kdebbt='". mysql_escape_string($kdebbtB)."'";
			$result =mysql_query($query);
			$data 	=mysql_fetch_array($result);
		
			$kdebbt	=$data[kdebbt];
			$nmabbt	=$data[nmabbt];
			$bbt	=$data[bbt];
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='kurikulum.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>BOBOT NILAI</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Kode Bobot</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdebbt'
								TYPE		='text' 	
								SIZE		='3'
								MAXLENGTH	='3'
								VALUE 		='$kdebbt'
								ID			='kdebbt'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								DISABLED>
					</TD>
				</TR>
				<TR><TD>Nama Bobot</TD>
					<TD>:
						<INPUT 	NAME		='nmabbt'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$nmabbt'
								ID			='nmabbt'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required'
								TITLE		='...harus diisi'
								$isian>
					</TD>
				</TR>
				<TR><TD>Bobot</TD>
					<TD>:
						<INPUT 	NAME		='bbt'
								TYPE		='text'
								SIZE		='3'
								MAXLENGTH	='3'
								VALUE 		='$bbt'
								ID		='bbt'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required'
								TITLE		='...harus diisi'
								$isian> %
					</TD>
				</TR>
			</TABLE>";

			// pilihan tombol pilihan
						
			// tombol edit
			if (hakakses('L1D07')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Edit' 	onClick=window.location.href='kurikulum.php?mode=L1D07&kdebbt=$kdebbt&pilihan=edit'>";
			}	
						
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='L1D07_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='kdebbtB'	VALUE='$kdebbtB'>
				<INPUT TYPE='hidden' NAME='kdebbt'	VALUE='$kdebbt'>";
			}
			echo"
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='kurikulum.php?mode=L1D07_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
		</FORM>"; 
 	}

	// -------------------------------------------------- Save --------------------------------------------------
	function L1D07_Save()
	{
  		$kdebbtB=$_POST['kdebbtB'];
  		$kdebbt	=$_POST['kdebbt'];
  		$nmabbt	=$_POST['nmabbt'];
  		$bbt	=$_POST['bbt'];

		$set	="	SET		t_mstbbt.kdebbt	='". mysql_escape_string($kdebbt)."',
                            t_mstbbt.nmabbt	='". mysql_escape_string($nmabbt)."',
                            t_mstbbt.bbt	='". mysql_escape_string($bbt)."'";

   		$query 	="	UPDATE 	t_mstbbt ".$set.
				 "	WHERE 	t_mstbbt.kdebbt	='". mysql_escape_string($kdebbtB)	."'";
		$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));

		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L1D07&kdebbt=$kdebbt\">\n";
 	}
}//akhir class
?>