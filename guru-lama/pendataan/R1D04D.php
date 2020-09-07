<?php 
//----------------------------------------------------------------------------------------------------
//Program		: R1D04D.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi INPUT EXTRA CURRICULAR
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04Dclass
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function R1D04D_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdekry	=$_SESSION["Admin"]["kdekry"];
			
		$query	="	SELECT 		DISTINCT t_mstplj.kdeplj,t_mstplj.nmaplj
								FROM 		t_mstpng,t_mstplj
								WHERE		t_mstpng.kdegru='$kdekry' AND
											t_mstpng.kdeplj=t_mstplj.kdeplj	AND
											t_mstplj.str='X'";
		$result	=mysql_query($query) or die (mysql_error());

		echo"
		<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
			<TR><TD><B>INPUT EXTRA CURRICULAR</B></TD></TR>
			<TR></TR><TR></TR>
		</TABLE>
			
		<FORM ACTION='guru.php?mode=R1D04D' METHOD='post'>
			<DIV style='overflow:auto;width:25%;height:380px;padding-right:-2px;'>		
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH='80%'><CENTER>Pelajaran	</CENTER></TD>
						<TD WIDTH='20%'><CENTER>Detil		</CENTER></TD>
					</TR>";

					$no=0;
					while($data =mysql_fetch_array($result))
					{
						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
							<TD>$data[nmaplj]</TD>
							<TD><CENTER><a href='guru.php?mode=R1D04D&kdeplj=$data[kdeplj]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>
						</TR>";
					}
				echo"	
				</TABLE>
			</DIV>
		</FORM>
		<span style='color: #FF0000;'><B><U>Catatan</U></B></span><BR>
		<span style='color: #FF0000;'>Mata Pelajaran hanya khusus untuk Pelajaran Extra Curricular</span>";
 	}

	function R1D04D()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdekry	=$_SESSION["Admin"]["kdekry"];
		$kdekls	=$_GET['kdekls'];
		$kdeplj	=$_GET['kdeplj'];
		$pilihan=$_GET['pilihan'];

		$sms	='Semester';
		$query 	=mysql_query("	SELECT 		t_setthn.* 
								FROM 		t_setthn
								WHERE		t_setthn.set='$sms'");
		$data = mysql_fetch_array($query);
		$sms=$data[nli];
					
		$midtrm	='Mid Term';
		$query 	=mysql_query("	SELECT 		t_setthn.* 
								FROM 		t_setthn
								WHERE		t_setthn.set='$midtrm'");
		$data = mysql_fetch_array($query);
		$nlitrm=$data[nli];
		$midtrm=$midtrm.' '.$nlitrm;
		
		$query="	SELECT 			t_mstplj.*
					FROM 			t_mstplj
					WHERE 			t_mstplj.kdeplj='$kdeplj'";
		$result=mysql_query($query);
		$data=mysql_fetch_array($result);
		$nmaplj=$data[nmaplj];
		
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
					WHERE 		t_mstssw.kdekls	='". mysql_escape_string($kdekls)."'	
					ORDER BY	t_mstssw.kdekls,t_mstssw.nis";
		$result =mysql_query($query);

		$i=0;
		while($data = mysql_fetch_array($result))
		{
			$cell[$i][0]=$data[nis];
			$nis		=$data[nis];
			$cell[$i][1]=$data[nmassw];
			$kdeusr		=$data[kdeusr];
			$tglrbh		=$data[tglrbh];
			$jamrbh		=$data[jamrbh];

			$query2	="	SELECT 		t_extcrrps.*
						FROM 		t_extcrrps
						WHERE 		t_extcrrps.nis		='". mysql_escape_string($nis)."'	AND
									t_extcrrps.kdeplj	='". mysql_escape_string($kdeplj)."'";
			$result2 =mysql_query($query2);
			$data2 	 =mysql_fetch_array($result2);
			$cell[$i][2]=$data2['ext'."$sms"."$nlitrm"];
			$cell[$i][3]=$data2['ktr'."$sms"."$nlitrm"];
			
			$i++;
		}

		echo"
		<FORM ACTION='guru.php' METHOD='get' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>INPUT EXTRA CURRICULAR  <span style='color: #FF0000;'>( $nmaplj )</span></B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='15%'>Kelas</TD>
					<TD>:
						<SELECT	NAME		='kdekls'
								ID			='kdekls'
								onkeypress	='return enter(this,event)'>
						<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
						$query2="	SELECT 			t_mstpng.*,t_mstkls.*
									FROM 			t_mstpng,t_mstkls
									WHERE 			t_mstpng.kdegru='$kdekry'	AND
													t_mstpng.kdeplj='$kdeplj'	AND
													t_mstpng.kdekls=t_mstkls.kdekls
									ORDER BY 		t_mstkls.kdeklm,t_mstpng.kdekls";
						$result2=mysql_query($query2);
						while($data=mysql_fetch_array($result2))
						{
							if($kdekls==$data[kdekls])
								echo"<OPTION VALUE='$data[kdekls]' SELECTED>$data[kdekls]</OPTION>";
							else
								echo"<OPTION VALUE='$data[kdekls]'>$data[kdekls]</OPTION>";
						}
						echo"
						</SELECT>
						<INPUT TYPE='submit' 					VALUE='Tampilkan'>
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04D'>
						<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
						<INPUT TYPE='hidden' 	NAME='kdeplj'	VALUE=$kdeplj>
					</TD>	
              	</TR>				
			</TABLE>
		</FORM>
		
		<FORM ACTION='guru.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<DIV style='overflow:auto;;width:100%;height:340px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 3%' HEIGHT='20'><CENTER>No	</CENTER></TD>
						<TD WIDTH='20%'><CENTER>Nama Siswa	    </CENTER></TD>
						<TD WIDTH='07%'><CENTER>Nilai	</CENTER></TD>
						<TD WIDTH='66%'><CENTER>Keterangan	</CENTER></TD>
					</TR>";
					$j=0;
					$no=1;
					while($j<$i)
					{
						$nis	='nis'.$j;
						$nisv	=$cell[$j][0];
						$nma	='nmassw'.$j;
						$nmav	=$cell[$j][1];
						$ext	='ext'."$sms"."$nlitrm".$j;
						$extv	=$cell[$j][2];
						$ktr	='ktr'."$sms"."$nlitrm".$j;
						$ktrv	=$cell[$j][3];
				
						echo"
						<TR>
							<TD HEIGHT='25'><CENTER>$no	</CENTER>
								<INPUT TYPE='hidden' NAME='$nis'		VALUE=$nisv>		
							</TD>
							<TD><CENTER>$nmav</CENTER></TD>
							<TD><CENTER>
								<INPUT 	NAME		='$ext'
										TYPE		='text'
										SIZE		='1'
										MAXLENGTH	='1'
										VALUE 		='$extv'
										ID			='$ext'
										ONKEYUP		='uppercase(this.id)'
										ONKEYPRESS	='return enter(this,event)'
										$isian1></CENTER>
							</TD>
							<TD><CENTER>
								<INPUT 	NAME		='$ktr'
										TYPE		='text'
										SIZE		='100'
										MAXLENGTH	='100'
										VALUE 		='$ktrv'
										ID			='$ktr'
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
			<BR>
			<INPUT TYPE='button' 	VALUE='Pelajaran' 	onClick=window.location.href='guru.php?mode=R1D04D_Cari'>";

			// pilihan tombol pilihan
			if ($pilihan=='detil'  AND $kdekls!='')
			{
				echo"
				<INPUT TYPE='button'	VALUE='Edit Nilai per siswa' 	onClick=window.location.href='guru.php?mode=R1D04D&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=edit'>";
				if($kdekls!='')
				{
					echo"
					<INPUT TYPE='button'	VALUE='Seting Nilai per kelas' 	onClick=window.location.href='guru.php?mode=R1D04D&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=seting'>";
				}	
			}	
				
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 					VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 		VALUE='R1D04D_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'		VALUE='edit'>
				<INPUT TYPE='hidden' NAME='kdeplj'		VALUE=$kdeplj>
				<INPUT TYPE='hidden' NAME='kdekls'		VALUE=$kdekls>
				<INPUT TYPE='hidden' NAME='sms'			VALUE=$sms>
				<INPUT TYPE='hidden' NAME='nlitrm'		VALUE=$nlitrm>
				<INPUT TYPE='hidden' NAME='i'			VALUE=$i>";
			}

			if($pilihan=='seting')
			{
				echo"
				Seting Nilai  :
				<INPUT 	NAME		='midtrms'
						TYPE		='text'
						SIZE		='1'
						MAXLENGTH	='1'
						VALUE 		='$midtrms'
						ID			='midtrms'
						ONKEYUP		='uppercase(this.id)'
						ONKEYPRESS	='return enter(this,event)'
						$isian2></CENTER>
				<INPUT TYPE='submit' 					VALUE='Simpan'>
				<INPUT TYPE='hidden'	NAME='mode'		VALUE='R1D04D_Save'>
				<INPUT TYPE='hidden' NAME='kdeplj'		VALUE=$kdeplj>
				<INPUT TYPE='hidden' NAME='kdekls'		VALUE=$kdekls>
				<INPUT TYPE='hidden' NAME='sms'			VALUE=$sms>
				<INPUT TYPE='hidden' NAME='nlitrm'		VALUE=$nlitrm>
				<INPUT TYPE='hidden' NAME='i'			VALUE=$i>";
			}
				
			echo"
		</FORM>";
 	}

	// -------------------------------------------------- Save --------------------------------------------------
	function R1D04D_Save()
	{
		$kdekls	=$_POST['kdekls'];
		$kdeplj	=$_POST['kdeplj'];
		$sms	=$_POST['sms'];
		$nlitrm	=$_POST['nlitrm'];
		$midtrms=$_POST['midtrms'];
		$i		=$_POST['i'];
        $kdeusr =$_SESSION['Admin']['kdekry'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");

		$j=0;
		while($j<$i)
		{
			$nis 	='nis'.$j;
			$nis	=$_POST["$nis"]; 
			$ext 	="ext"."$sms"."$nlitrm".$j;
			if($midtrms=='')
			{
				$ext	=$_POST["$ext"]; 
			}	
			else
			{
				$ext	=$midtrms;
			}	
			$ktr 	="ktr"."$sms"."$nlitrm".$j;
			$ktr	=$_POST["$ktr"]; 

			if($midtrms=='')
			{
				$set	="	SET		t_extcrrps.nis		='". mysql_escape_string($nis)."',
									t_extcrrps.kdeplj	='". mysql_escape_string($kdeplj)."',
									t_extcrrps.ext"."$sms"."$nlitrm"."	='". mysql_escape_string($ext)."',
									t_extcrrps.ktr"."$sms"."$nlitrm"."	='". mysql_escape_string($ktr)."',
									t_extcrrps.kdeusr	='". mysql_escape_string($kdeusr)."',
									t_extcrrps.tglrbh	='". mysql_escape_string($tglrbh)."',
									t_extcrrps.jamrbh	='". mysql_escape_string($jamrbh)."'"; 
			}
			else
			{	
				$set	="	SET		t_extcrrps.nis		='". mysql_escape_string($nis)."',
									t_extcrrps.kdeplj	='". mysql_escape_string($kdeplj)."',
									t_extcrrps.ext"."$sms"."$nlitrm"."	='". mysql_escape_string($ext)."',
									t_extcrrps.kdeusr	='". mysql_escape_string($kdeusr)."',
									t_extcrrps.tglrbh	='". mysql_escape_string($tglrbh)."',
									t_extcrrps.jamrbh	='". mysql_escape_string($jamrbh)."'"; 
			}
			$query	="	SELECT 		t_extcrrps.*
						FROM 		t_extcrrps
						WHERE 		t_extcrrps.nis	='". mysql_escape_string($nis)."'	AND
									t_extcrrps.kdeplj	='". mysql_escape_string($kdeplj)."'";
			$result =mysql_query($query);
			$data	=mysql_fetch_array($result);
			if($data[nis]=='')
			{
			  	$query 	="	INSERT INTO t_extcrrps ".$set; 
				$result	=mysql_query($query) or die (error("Data tidak berhasil di simpan"));
			}
			else
			{
				$query 	="	UPDATE 	t_extcrrps ".$set.
						"	WHERE 	t_extcrrps.nis	='". mysql_escape_string($nis)	."'	AND
									t_extcrrps.kdeplj	='". mysql_escape_string($kdeplj)	."'";
				$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah"));		
			}	
			$j++;
		}
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04D&kdeplj=$kdeplj&kdekls=$kdekls&nis=$nis&pilihan=detil\">\n";
 	}		
}//akhir class
?>