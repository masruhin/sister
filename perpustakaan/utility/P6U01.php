<?php
//----------------------------------------------------------------------------------------------------
//Program		: P6U01.php
//Sumber		: sister
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi SET PERPUSTAKAAN
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class P6U01class
{
	// -------------------------------------------------- Set Perpustakaan --------------------------------------------------
	function P6U01()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	

		echo"
		<SCRIPT TYPE='text/javascript' src='../js/jquery-1.2.3.pack.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' src='../js/jquery.validate.pack.js'></SCRIPT>";
		
		// inisiasi parameter berdasarkan pilihan tombol
		$pilihan=$_GET['pilihan'];
		
		if($pilihan=='')
			$pilihan='detil';

		switch($pilihan)
		{
			case 'detil':
				$isian	='disabled';
				break;
			case 'edit':
				$isian	='enable';
				break;
		}		
		
		$setB=$_GET['set'];

		$query 	="	SELECT 		t_setprp.* 
					FROM 		t_setprp";
		$result =mysql_query($query);

		$i=0;
		while($data = mysql_fetch_array($result))
		{
			$cell[$i][0] 	=$data[set];
			$cell[$i][1] 	=number_format($data['nli']);
			$i++;
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='perpustakaan.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>SET PERPUSTAKAAN</B></TD></TR>
				<TR></TR><TR></TR>";
					$j=0;
					while($j<2)
					{
						$set	='set'.$j;
						$setv	=$cell[$j][0];
						$nli	='nli'.$j;
						$nliv	=$cell[$j][1];
						echo"
						<TR>
							<TD WIDTH='20%'>$setv</TD>
							<TD>: 
								<INPUT 	NAME		='$nli'
										TYPE		='text'
										SIZE		='16%'
										MAXLENGTH	='25'
										VALUE 		='$nliv'
										ID			='$nli'
										onkeyup		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										$isian>
							</TD>
						</TR>";
						$j++;
					}	
				echo"	
			</TABLE>";	
						
			// pilihan tombol pilihan
			// tombol edit
			if (hakakses('P6U01')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button'	VALUE='Edit' 	onClick=window.location.href='perpustakaan.php?mode=P6U01&set=$set&pilihan=edit'>";
			}	
						
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='P6U01_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='set'		VALUE=$set>";
			}
		echo"
		</FORM>"; 
 	}	

	// -------------------------------------------------- Save --------------------------------------------------
	function P6U01_Save()
	{
		$setjdl[0]='Batas waktu peminjaman (hari)';
		$setjdl[1]='Denda per hari (Rp.)';
		$j=0;
		while($j<2)
		{
			$setB	=$setjdl["$j"]; 
			$nli 	='nli'.$j;
			$nli	=str_replace(",","",$_POST["$nli"]);
			
			$set	="	SET		t_setprp.nli	='". mysql_escape_string($nli)."'";

			$query 	="	UPDATE 	t_setprp ".$set. 
					 " 	WHERE 	t_setprp.set	='". mysql_escape_string($setB)	."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
			$j++;
		}
		$pilihan='detil';
		
		echo"<meta http-equiv='refresh' content=\"0;url=perpustakaan.php?mode=P6U01&pilihan=$pilihan\">\n";
 	}		
}//akhir class
?>