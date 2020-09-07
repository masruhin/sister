<?php
//----------------------------------------------------------------------------------------------------
//Program		: T6U01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi SETING UANG SEKOLAH
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class T6U01class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function T6U01()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		echo"<SCRIPT TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></SCRIPT>";
		
		$kdekls	=$_GET['kdekls'];
		$nmassw	=$_GET['nmassw'];
		$pilihan=$_GET['pilihan'];
		
		if($pilihan=='')
			$pilihan='detil';

		switch($pilihan)
		{
			case 'detil':
				$isian1	='disabled';
				$isian2	='disabled';
				break;
			case 'edit':
				$isian1	='enable';
				$isian2	='disabled';
				break;
			case 'seting':
				$isian1	='disabled';
				$isian2	='enable';
				break;
		}		

		$query 	="	SELECT 		t_mstssw.*
					FROM 		t_mstssw
					WHERE 		(t_mstssw.kdekls	='". mysql_escape_string($kdekls)."'	OR '$kdekls'='')	AND
								(t_mstssw.nmassw LIKE'%".$nmassw."%' OR '$nmassw'='')
					ORDER BY	t_mstssw.kdekls,t_mstssw.nis";
		$result =mysql_query($query);

		$i=0;
		while($data = mysql_fetch_array($result))
		{
			$cell[$i][0]=$data[nis];
			$cell[$i][1]=$data[nmassw];

			if ($pilihan=='edit')
			{
				$cell[$i][2]=$data[unskl];
			}
			else
			{
				$cell[$i][2]=number_format($data[unskl]);
			}	
			$cell[$i][3]=$data[nmrva];
			$cell[$i][4]=$data[kdekls];
			$i++;
		}

		echo"
		<FORM ACTION='tatausaha.php' METHOD='get' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>SETING KELAS</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='15%'>Kelas</TD>
					<TD>:
						<SELECT NAME		='kdekls'
								ID			='kdekls'
								ONKEYUP		='uppercase(this.id)'>";
						$query2="	SELECT 		t_mstkls.*
									FROM 		t_mstkls
									ORDER BY 	t_mstkls.kdekls";
						$result2=mysql_query($query2);
						echo"<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
						while($data=mysql_fetch_array($result2))
						{
							if ($kdekls==$data[kdekls])
								echo"<OPTION VALUE='$data[kdekls]' SELECTED>$data[kdekls]</OPTION>";
							else
								echo"<OPTION VALUE='$data[kdekls]'>$data[kdekls]</OPTION>";
						}
						echo"
						</SELECT>
						<INPUT TYPE='submit' 					VALUE='Tampilkan'>
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='T6U01'>
						<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
		
		<DIV style='overflow:auto;;width:100%;height:420px;padding-right:-2px;'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
			<TR>
				<TD WIDTH='50%' VALIGN='top'><B>SISWA KELAS</B>
					<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
						<TR bgcolor='dedede'>
							<TD WIDTH=' 7%' HEIGHT='20'><CENTER>No	</CENTER></TD>
							<TD WIDTH='15%'><CENTER>NIS 			</CENTER></TD>
							<TD WIDTH='65%'><CENTER>Nama Siswa	    </CENTER></TD>
							<TD WIDTH='13%'><CENTER>Hapus	    </CENTER></TD>
						</TR>";
						$j=0;
						$no=1;
						while($j<$i)
						{
							$nis	='nis'.$j;
							$nisv	=$cell[$j][0];
							$nma	='nmassw'.$j;
							$nmav	=$cell[$j][1];
							$kls	='kdekls'.$j;
							$klsv	=$cell[$j][2];
				
							echo"
							<TR>
								<TD><CENTER>$no	</CENTER></TD>
								<TD><CENTER>$nisv</CENTER>
									<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
								</TD>
								<TD><CENTER>$nmav</CENTER></TD>
								<TD><CENTER><a href='tatausaha.php?mode=T1D01_Hapus_Personil&kdetkt=$data1[kdetkt]&&kdekry=$data1[kdekry]'><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>
							</TR>";

							$j++;
							$no++;
						}		
					echo"	
					</TABLE>	
				</TD>
				<TD WIDTH='50%' VALIGN='top'><B>DATA SISWA</B>";
					$query2 ="	SELECT 		DISTINCT t_mstkry.*,t_prstkt.kdetkt
								FROM 		t_mstkry
								LEFT JOIN 	t_prstkt ON t_mstkry.kdekry=t_prstkt.kdekry	AND t_prstkt.kdetkt='$kdetkt'
								ORDER BY 	t_mstkry.kdekry";  
					$result2= mysql_query($query2)	or die (mysql_error());
					echo"
					<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
						<TR bgcolor='dedede'>
							<TD WIDTH='15%' HEIGHT='20'><CENTER>Kode</CENTER></TD>
							<TD WIDTH='75%'><CENTER>Nama 			</CENTER></TD>
							<TD WIDTH='10%'><CENTER>Pilih 			</CENTER></TD>
						</TR>";

						while($data2 =mysql_fetch_array($result2))
						{
							$kdetkt	=$data2[kdetkt];
							echo"
							<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
								<TD><CENTER>$data2[kdekry]</CENTER></TD>
								<TD>$data2[nmakry]</TD>";

								if($kdetkt=='')
								{
									echo"
									<TD><CENTER><a href='tatausaha.php?mode=T1D01_Save_Personil&kdetkt=$kdetktB&kdekry=$data2[kdekry]'><IMG src='../images/pilih_e.gif' BORDER='0'></a></CENTER></TD>";
								}
								else
								{
									echo"
									<TD><CENTER><IMG src='../images/pilih_d.gif' BORDER='0'></a></CENTER></TD>";
								}
							echo"	
							</TR>";
						}
					echo"	
					</TABLE>
				</TD>
			</TR>
			</TABLE>				
		</DIV>";
 	}

	// -------------------------------------------------- Hapus_Personil --------------------------------------------------
	function T6U01_Hapus()
	{
		$kdeklsB=$_GET['kdekls'];
		$nis	=$_GET['nis'];
	
		$query	="	DELETE 
					FROM 	t_mstssw
					WHERE 	t_mstssw.nis='". mysql_escape_string($nis)."'";
		$result	=mysql_query($query) or die (mysql_error());

		$pilihan='detil';
		echo"<meta http-equiv='refresh' content=\"0;url=tatausaha.php?mode=T6U01&kdekls=$kdeklsB&nmassw=$nmassw&pilihan=$pilihan\">\n";
	}	
	
	// -------------------------------------------------- Save Absensi --------------------------------------------------
	function T6U01_Save()
	{
  		$kdeklsB=$_POST['kdekls'];
		$nmassw	=$_POST['nmassw'];
		$i		=$_POST['i'];

		$j=0;
		while($j<$i)
		{
			$nis 	='nis'.$j;
			$nis	=$_POST["$nis"]; 
			$unskl ='unskl'.$j;
			$unskl	=str_replace(",","",$_POST["$unskl"]);
			$nmrva ='nmrva'.$j;
			$nmrva	=str_replace(",","",$_POST["$nmrva"]);
			
			if($unskl=='')
				$unskl==1;

			$set	="	SET		t_mstssw.unskl	='". mysql_escape_string($unskl)."',
								t_mstssw.nmrva	='". mysql_escape_string($nmrva)."'";
    		$query 	="	UPDATE 	t_mstssw ".$set. 
					 " 	WHERE 	t_mstssw.nis	='". mysql_escape_string($nis)	."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
			$j++;
		}
		$pilihan='detil';
		echo"<meta http-equiv='refresh' content=\"0;url=tatausaha.php?mode=T6U01&kdekls=$kdeklsB&nmassw=$nmassw&pilihan=$pilihan\">\n";
 	}

	// -------------------------------------------------- Save Seting --------------------------------------------------
	function T6U01_Save_Seting()
	{
  		$kdeklsB=$_POST['kdekls'];
		$stunskl=str_replace(",","",$_POST['stunskl']);

		$set	="	SET		t_mstssw.unskl	='". mysql_escape_string($stunskl)."'";
   		$query 	="	UPDATE 	t_mstssw ".$set. 
				 " 	WHERE 	t_mstssw.kdekls	='". mysql_escape_string($kdeklsB)	."'";
		$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
		$pilihan='detil';
		echo"<meta http-equiv='refresh' content=\"0;url=tatausaha.php?mode=T6U01&kdekls=$kdeklsB&pilihan=$pilihan\">\n";
 	}	
}//akhir class
?>