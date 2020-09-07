<?php
//----------------------------------------------------------------------------------------------------
//Program		: L6U01SD.php
//Sumber		: sister
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi SET 
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class L6U01SDclass
{
	// -------------------------------------------------- Set kurikulum --------------------------------------------------
	function L6U01SD()
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

		$query 	="	SELECT 		t_setthn_sd.* 
					FROM 		t_setthn_sd";
		$result =mysql_query($query);

		$i=0;
		while($data = mysql_fetch_array($result))
		{
			$cell[$i][0] 	=$data[set];
			$cell[$i][1] 	=$data[nli];
			$i++;
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='kurikulum.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>SET TAHUN AJARAN SD</B></TD></TR>
				<TR></TR><TR></TR>";
					$j=0;
					while($j<4)
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
			if (hakakses('L6U01SD')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button'	VALUE='Edit' 	onClick=window.location.href='kurikulum.php?mode=L6U01SD&set=$set&pilihan=edit'>";
			}	
						
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='L6U01SD_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='set'		VALUE=$set>";
			}
		echo"
		</FORM>
		<span style='color: #FF0000;'><B><U>Catatan :</U></B></span><BR>
		<span style='color: #FF0000;'>Term : untuk membatasi pembagian progress report PG dan KG</span><BR>
		<span style='color: #FF0000;'>Mid Term : untuk membatasi pembagian report PS, JHS dan SHS</span>"; 
 	}	

	// -------------------------------------------------- Save --------------------------------------------------
	function L6U01SD_Save()
	{
		$setjdl[0]='Tahun Ajaran';
		$setjdl[1]='Semester';
		$setjdl[2]='Mid Term';
		$setjdl[3]='Term';
		$j=0;
		while($j<4)
		{
			$setB	=$setjdl["$j"]; 
			$nli 	='nli'.$j;
			$nli	=str_replace(",","",$_POST["$nli"]);
			
			$set	="	SET		t_setthn_sd.nli	='". mysql_escape_string($nli)."'";

			$query 	="	UPDATE 	t_setthn_sd ".$set. 
					 " 	WHERE 	t_setthn_sd.set	='". mysql_escape_string($setB)	."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
			$j++;
		}
		$pilihan='detil';
		
		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L6U01SD&pilihan=$pilihan\">\n";
 	}		
}//akhir class
?>