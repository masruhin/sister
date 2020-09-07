<?php
//----------------------------------------------------------------------------------------------------
//Program		: L1D08.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi 
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class L1D08class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function L1D08()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		echo"<SCRIPT TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></SCRIPT>";
		
		$kdekls	=$_GET['kdekls'];
		$kdekls1=$_GET['kdekls'];
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
		}		

		$query 	="	SELECT 		t_kkm.*
					FROM 		t_kkm
					WHERE 		t_kkm.kdekls	='". mysql_escape_string($kdekls)."'
					ORDER BY	t_kkm.kdekls,t_kkm.kdeplj";
		$result =mysql_query($query);

		$i=0;
		while($data = mysql_fetch_array($result))
		{
			$cell[$i][0]=$data[kdekls];
			$cell[$i][1]=$data[kdeplj];
			$cell[$i][2]=$data[kkm];
			$cell[$i][2]=$data[kkm];
			$i++;
		}

		echo"
		<FORM ACTION='kurikulum.php' METHOD='get' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>MINIMUM KRITERIA</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='10%'>Kelas</TD>
					<TD WIDTH='90%'>:
						<SELECT NAME		='kdekls'
								ID			='kdekls'
								ONKEYUP		='uppercase(this.id)'>";
						$query2="	SELECT 		t_mstkls.*
									FROM 		t_mstkls
									ORDER BY 	t_mstkls.kdeklm, t_mstkls.kdekls";
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
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='L1D08'>
						<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
		
		<FORM ACTION='kurikulum.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<div style='overflow:auto;width:50%;height:360px;overflow-x:hidden;position: relative;bottom:0;'>
				<table class='tabel' BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<thead>
						<tr bgcolor='dedede'>
							<td width='10%' align='center'>No</td>
							<td width='80%'>Subject</td>
							<td width='10%' align='center'>Value</td>
						</tr>
					</thead>";
					$qry 	=mysql_query("	select 	t_mstkls.*,t_klmkls.*
											from 	t_mstkls,t_klmkls
											where	t_mstkls.kdekls='". mysql_escape_string($kdekls)."' and
													t_mstkls.kdeklm=t_klmkls.kdeklm");
					$dta 	=mysql_fetch_array($qry);
					$kdetkt	=$dta[kdetkt];

					$qry 	=mysql_query("	select 		t_setpsrpt.*
											from 		t_setpsrpt
											where 		t_setpsrpt.kdetkt='". mysql_escape_string($kdetkt)."' and
														t_setpsrpt.kdeplj!=''
											order by	t_setpsrpt.id");
					$i=0;
					while($dta=mysql_fetch_array($qry))
					{
						$kdeplj		=$dta[kdeplj];
						$cll[$i][0] =$dta[kdeplj];
						$cll[$i][1] =$dta[nmasbj];
						$qry2	=mysql_query("	select 	t_kkm.*
												from 	t_kkm
												where 	t_kkm.kdekls	='". mysql_escape_string($kdekls)."' and
														t_kkm.kdeplj	='". mysql_escape_string($kdeplj)."'");
						$dta2 	=mysql_fetch_array($qry2);
						$cll[$i][2]	=$dta2[kkm];
						$kdeusr		=$dta2[kdeusr];
						$tglrbh		=$dta2[tglrbh];
						$jamrbh		=$dta2[jamrbh];

						$i++;
					}
					$j=0;
					$no=1;
					while($j<$i)
					{
						$kdeplj	='kdeplj'.$j;
						$kdepljv=$cll[$j][0];
						$nmasbj	='nmasbj'.$j;
						$nmasbjv=$cll[$j][1];
						$nmasbjv=str_replace("=","","$nmasbjv");
						$nmasbjv=str_replace("*","","$nmasbjv");
						$kkm	='kkm'.$j;
						$kkmv	=$cll[$j][2];
						
						echo"
						<tr onMouseOver=\"this.classname='highlight'\" onMouseOut=\"this.classname='normal'\">
							<td><center>$no</center></td>
							<td>$nmasbjv
								<input type='hidden' name='$kdeplj'	value='$kdepljv'>		
							</td>
							<td align='center'><input name='$kkm' type='text' size='2' maxlength='2' value='$kkmv' autofocus onkeyup='formatangka(this);' onkeypress='return enter(this,event)' $isian1></td>
						</tr>";
						$j++;
						$no++;
					}	
				echo"	
				</table><br><br>
			</div>
			<!-- 
			<DIV style='overflow:auto;;width:50%;height:370px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
						<TD WIDTH='40%'><CENTER>Pelajaran 		</CENTER></TD>
						<TD WIDTH=' 6%'><CENTER>Nilai 			</CENTER></TD>
					</TR>";
					$j=0;
					$no=1;
					while($j<$i)
					{
						$kdekls	='kdeplj'.$j;
						$kdepljv=$cell[$j][0];
						$nmasbj	='nmasbj'.$j;
						$nmasbjv=$cell[$j][1];
						$nmasbjv=str_replace("=","","$nmasbjv");
						$nmasbjv=str_replace("*","","$nmasbjv");
						$kkm	='kkm'.$j;
						$kkmv	=$cell[$j][2];
				
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER></TD>
							<TD>
								<INPUT TYPE='hidden' NAME='$kdeplj'		VALUE=$kdepljv>		
								$nmasbjv
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$kkm'
										TYPE		='text'
										SIZE		='2'
										MAXLENGTH	='2'
										VALUE 		='$kkmv'
										ID			='$kkm'
										ONKEYUP		='formatangka(this);'
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
			-->
			<BR>";

			// pilihan tombol pilihan
			if (hakakses('L1D08')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button'	VALUE='Edit KKM' 	onClick=window.location.href='kurikulum.php?mode=L1D08&kdekls=$kdekls1&pilihan=edit'>";
			}	
				
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 					VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='L1D08_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'		VALUE='edit'>
				<INPUT TYPE='hidden' NAME='kdekls'		VALUE=$kdekls1>
				<INPUT TYPE='hidden' NAME='i'			VALUE=$i>";
			}
			echo"
		</FORM>";
 	}

	// -------------------------------------------------- Save Absensi --------------------------------------------------
	function L1D08_Save()
	{
		$kdekls =$_POST['kdekls'];
		$i		=$_POST['i'];

		$j=0;
		while($j<$i)
		{
			$kdeplj ='kdeplj'.$j;
			$kdeplj	=$_POST["$kdeplj"]; 
			$kkm 	='kkm'.$j;
			$kkm	=$_POST["$kkm"];
				
			$set	="	set	t_kkm.kdekls='". mysql_escape_string($kdekls)."',
							t_kkm.kdeplj='". mysql_escape_string($kdeplj)."',
							t_kkm.kkm	='". mysql_escape_string($kkm)."',
							t_kkm.kdeusr='". mysql_escape_string($userid)."',
							t_kkm.tglrbh='". mysql_escape_string($tgl)."',
							t_kkm.jamrbh='". mysql_escape_string($jam)."'";

			$qry	=mysql_query("	select 	t_kkm.*
									from 	t_kkm
									where 	t_kkm.kdekls='". mysql_escape_string($kdekls)."' and
											t_kkm.kdeplj='". mysql_escape_string($kdeplj)."'");
			$bny	=mysql_num_rows($qry);
						
			if($bny>0)	mysql_query("	update 	t_kkm ".$set. 
									" 	where 	t_kkm.kdekls='". mysql_escape_string($kdekls)."' and
												t_kkm.kdeplj='". mysql_escape_string($kdeplj)."'");
			else		mysql_query("insert into t_kkm ".$set);							
			$j++;
		}

		/*
  		$kdetktB=$_POST['kdetkt'];
		$i		=$_POST['i'];

		$j=0;
		while($j<$i)
		{
			$kdeplj ='kdeplj'.$j;
			$kdeplj	=$_POST["$kdeplj"]; 
			$kkm 	='kkm'.$j;
			$kkm	=str_replace(",","",$_POST["$kkm"]);
			
			if($kkm=='')
				$kkm==1;

			$set	="	SET		t_setpsrpt.kkm	='". mysql_escape_string($kkm)."'";
    		$query 	="	UPDATE 	t_setpsrpt ".$set. 
					 " 	WHERE 	t_setpsrpt.kdetkt	='". mysql_escape_string($kdetktB)	."'	AND
								t_setpsrpt.kdeplj	='". mysql_escape_string($kdeplj)	."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
			$j++;
		}*/
		$pilihan='detil';
		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L1D08&kdekls=$kdekls&pilihan=$pilihan\">\n";
 	}

}//akhir class
?>