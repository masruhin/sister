<?php
//----------------------------------------------------------------------------------------------------
//Program		: K6U01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi SETING UANG SEKOLAH
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class K6U01class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function K6U01()
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
			$usruns		=$data[usruns];
			$trbuns		=$data[trbuns];
			$jrbuns		=$data[jrbuns];
			$i++;
		}

		echo"
		<FORM ACTION='keuangan.php' METHOD='get' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>SETING UANG SEKOLAH</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='15%'>Kelas</TD>
					<TD>:
						<SELECT NAME		='kdekls'
								ID			='kdekls'
								ONKEYUP		='uppercase(this.id)'>";
						$query2="	SELECT 		t_mstkls.*
									FROM 		t_mstkls
									ORDER BY 	t_mstkls.kdeklm,t_mstkls.kdekls";
						$result2=mysql_query($query2);
						echo"<OPTION VALUE='' SELECTED>--Semua--</OPTION>";
						while($data=mysql_fetch_array($result2))
						{
							if ($kdekls==$data[kdekls])
								echo"<OPTION VALUE='$data[kdekls]' SELECTED>$data[kdekls]</OPTION>";
							else
								echo"<OPTION VALUE='$data[kdekls]'>$data[kdekls]</OPTION>";
						}
						echo"
						</SELECT>
					</TD>	
              	</TR>				
				<TR><TD>Nama Siswa</TD>
					<TD>:
						<INPUT 	NAME		='nmassw'	
								ID			='nmassw'	
								VALUE		='$nmassw'	
								TYPE		='text' 		
								SIZE		='50' 
								MAXLENGTH	='50'
								onkeyup		='uppercase(this.id)'>
						<INPUT TYPE='submit' 					VALUE='Tampilkan'>
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='K6U01'>
						<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
		
		<FORM ACTION='keuangan.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<DIV style='overflow:auto;;width:100%;height:340px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Kelas 			</CENTER></TD>
						<TD WIDTH='10%'><CENTER>NIS 			</CENTER></TD>
						<TD WIDTH='46%'><CENTER>Nama Siswa	    </CENTER></TD>
						<TD WIDTH='10%'><CENTER>Uang Sekolah	</CENTER></TD>
						<TD WIDTH='20%'><CENTER>Virtual Account	</CENTER></TD>
					</TR>";
					$j=0;
					$no=1;
					while($j<$i)
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nmassw'.$j;
						$nmav	=$cell[$j][1];
						$unskl	='unskl'.$j;
						$unsklv	=$cell[$j][2];
						$nmrva	='nmrva'.$j;
						$nmrvav	=$cell[$j][3];
						$kls	='kdekls'.$j;
						$klsv	=$cell[$j][4];
				
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER></TD>
							<TD><CENTER>$klsv</CENTER>
							</TD>
							<TD><CENTER>$nisv</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>$nmav</CENTER>
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$unskl'
										TYPE		='text'
										SIZE		='12'
										MAXLENGTH	='12'
										VALUE 		='$unsklv'
										ID			='$unskl'
										ONKEYUP		='formatangka(this);'
										ONKEYPRESS	='return enter(this,event)'
										$isian1></CENTER>
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$nmrva'
										TYPE		='text'
										SIZE		='25'
										MAXLENGTH	='25'
										VALUE 		='$nmrvav'
										ID			='$nmrva'
										ONKEYUP		='uppercase(this.id)'
										ONKEYPRESS	='return enter(this,event)'
										$isian1></CENTER>
							</TD>
						</TR>";

						$j++;
						$no++;
					}		
				echo"	
				</TABLE>	
			</DIV>
			<BR>";

			// pilihan tombol pilihan
			if (hakakses('K6U01')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button'	VALUE='Edit Uang Sekolah per siswa' 	onClick=window.location.href='keuangan.php?mode=K6U01&kdekls=$kdekls&nmassw=$nmassw&pilihan=edit'>";
				if($kdekls!='' and $nmassw=='')
				{
					echo"
					<INPUT TYPE='button'	VALUE='Seting Uang Sekolah per kelas' 	onClick=window.location.href='keuangan.php?mode=K6U01&kdekls=$kdekls&pilihan=seting'>";
				}	
			}	
				
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 					VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='K6U01_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'		VALUE='edit'>
				<INPUT TYPE='hidden' NAME='kdekls'		VALUE=$kdekls>
				<INPUT TYPE='hidden' NAME='nmassw'		VALUE=$nmassw>
				<INPUT TYPE='hidden' NAME='i'			VALUE=$i>";
			}

			if($pilihan=='seting')
			{
				echo"
				Seting Uang Sekolah  :
				<INPUT 	NAME		='stunskl'
						TYPE		='text'
						SIZE		='12'
						MAXLENGTH	='12'
						VALUE 		='$stunskl'
						ID			='stunskl'
						ONKEYUP		='formatangka(this);'
						ONKEYPRESS	='return enter(this,event)'
						$isian2></CENTER>
				<INPUT TYPE='submit' 					VALUE='Simpan'>
				<INPUT TYPE='hidden'	NAME='mode'		VALUE='K6U01_Save_Seting'>
				<INPUT TYPE='hidden' 	NAME='kdekls'	VALUE=$kdekls>";
			}
				
			echo"
			$usruns - $trbuns - $jrbuns
		</FORM>";
 	}

	// -------------------------------------------------- Save Absensi --------------------------------------------------
	function K6U01_Save()
	{
  		$kdeklsB=$_POST['kdekls'];
		$nmassw	=$_POST['nmassw'];
		$i		=$_POST['i'];
		$usruns =$_SESSION['Admin']['username'];
        $trbuns =date("d-m-Y");
       	$jrbuns	=date("h:i:s");

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
								t_mstssw.nmrva	='". mysql_escape_string($nmrva)."',
								t_mstssw.usruns	='". mysql_escape_string($usruns)."',
								t_mstssw.trbuns	='". mysql_escape_string($trbuns)."',
								t_mstssw.jrbuns	='". mysql_escape_string($jrbuns)."'";
    		$query 	="	UPDATE 	t_mstssw ".$set. 
					 " 	WHERE 	t_mstssw.nis	='". mysql_escape_string($nis)	."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
			$j++;
		}
		$pilihan='detil';
		echo"<meta http-equiv='refresh' content=\"0;url=keuangan.php?mode=K6U01&kdekls=$kdeklsB&nmassw=$nmassw&pilihan=$pilihan\">\n";
 	}

	// -------------------------------------------------- Save Seting --------------------------------------------------
	function K6U01_Save_Seting()
	{
  		$kdeklsB=$_POST['kdekls'];
		$stunskl=str_replace(",","",$_POST['stunskl']);
		$usruns =$_SESSION['Admin']['username'];
        $trbuns =date("d-m-Y");
       	$jrbuns	=date("h:i:s");

		$set	="	SET		t_mstssw.unskl	='". mysql_escape_string($stunskl)."',
							t_mstssw.usruns	='". mysql_escape_string($usruns)."',
							t_mstssw.trbuns	='". mysql_escape_string($trbuns)."',
							t_mstssw.jrbuns	='". mysql_escape_string($jrbuns)."'";
   		$query 	="	UPDATE 	t_mstssw ".$set. 
				 " 	WHERE 	t_mstssw.kdekls	='". mysql_escape_string($kdeklsB)	."'";
		$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
		$pilihan='detil';
		echo"<meta http-equiv='refresh' content=\"0;url=keuangan.php?mode=K6U01&kdekls=$kdeklsB&pilihan=$pilihan\">\n";
 	}	
}//akhir class
?>