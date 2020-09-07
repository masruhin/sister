<?php
//----------------------------------------------------------------------------------------------------
//Program		: A6U06.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi BUAT PROGRESS
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class A6U06class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function A6U06()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";
		
		echo"
		<FORM ACTION='administrator.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>BUAT DATA PROGRESS</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='15%'>Kelas</TD>
					<TD WIDTH='85%'>:
						<SELECT NAME		='kdekls'
								ID			='kdekls'
								ONKEYUP		='uppercase(this.id)'>";
						$query="	SELECT 		t_mstkls.*,t_klmkls.*
									FROM 		t_mstkls,t_klmkls
									WHERE		t_mstkls.kdeklm=t_klmkls.kdeklm 	AND
												(t_klmkls.kdetkt='PG' OR  t_klmkls.kdetkt='KG')
									ORDER BY 	t_mstkls.kdeklm,t_mstkls.kdekls";
						$result=mysql_query($query);
						echo"<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
						while($data=mysql_fetch_array($result))
						{
							if ($kdekls==$data[kdekls])
								echo"<OPTION VALUE='$data[kdekls]' SELECTED>$data[kdekls]</OPTION>";
							else
								echo"<OPTION VALUE='$data[kdekls]'>$data[kdekls]</OPTION>";
						}
						echo"
						</SELECT>
						<INPUT TYPE='submit' 					VALUE='Proses'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='A6U06_Buat'>
					</TD>
				</TR>
			</TABLE>
		</FORM>";
 	}

	// -------------------------------------------------- Save --------------------------------------------------
	function A6U06_Buat()
	{
		require_once '../fungsi_umum/sysconfig.php';
		
		$kdekls=$_POST['kdekls'];
		
		$query	="	SELECT 		t_mstssw.*,t_mstkls.*,t_klmkls.*,t_setpgrpt.*
					FROM 		t_mstssw,t_mstkls,t_klmkls,t_setpgrpt
					WHERE		t_mstssw.kdekls='$kdekls'			AND
								t_mstssw.kdekls=t_mstkls.kdekls	AND
								t_mstkls.kdeklm=t_klmkls.kdeklm	AND
								t_klmkls.kdetkt=t_setpgrpt.kdetkt	
				ORDER BY		t_mstssw.nis";
		$result=mysql_query($query) or die('Query gagal');

		$i=1;
		while($data = mysql_fetch_array($result))
		{
			$nis 	=$data[nis];
			$kdetkt =$data[kdetkt];

			$query2 =mysql_query("	SELECT 		t_prgrptpg.*
									FROM 		t_prgrptpg
									WHERE   	t_prgrptpg.nis='". mysql_escape_string($nis)."'");
			$data2 = mysql_fetch_array($query2);
			if($data2[nis]=='')
			{
				$query3 	="	SELECT 		t_setpgrpt.*
								FROM 		t_setpgrpt
								WHERE		t_setpgrpt.kdetkt='$kdetkt'	
								ORDER BY	t_setpgrpt.id";
				$result3 =mysql_query($query3);

				while($data3 = mysql_fetch_array($result3))
				{
					$id	=$data3[id];

					$set	="	SET		t_prgrptpg.nis	='". mysql_escape_string($nis)."',
										t_prgrptpg.id	='". mysql_escape_string($id)."'";

					$query4 ="	INSERT INTO t_prgrptpg ".$set; 
					$result4=mysql_query($query4) or die (mysql_error());
				}

				$query5 =mysql_query("	SELECT 		t_attspcpg.*
										FROM 		t_attspcpg
										WHERE   	t_attspcpg.nis='". mysql_escape_string($nis)."'");
				$data5 = mysql_fetch_array($query5);
				if($data5[nis]=='')
				{
					$set	="	SET		t_attspcpg.nis	='". mysql_escape_string($nis)."'";

					$query2 ="	INSERT INTO t_attspcpg ".$set; 
					$result2=mysql_query($query2) or die (mysql_error());
				}	
			}	
		}		
		echo"
		<script type='text/javascript'>
			window.alert('Proses MEMBUAT DATA PROGRESS sudah selesai')
		</script>";
		echo"<meta http-equiv='refresh' content=\"0;url=administrator.php?mode=A6U06\">\n";
 	}
}//akhir class
?>