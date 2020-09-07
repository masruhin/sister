<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D01F.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi RENCANA TEST
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D01Fclass
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function R1D01F()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";

		echo"
		<SCRIPT TYPE='text/javascript'>
			function tgl()
			{
				document.f1.prd.value = document.f1.bln.value +-+ document.f1.tahun.value;
			}
		</SCRIPT>";

		$user	=$_SESSION["Admin"]["kdekry"];
		$kdercu	=$_GET['kdercu'];
		$tglrcu	=$_GET['tglrcu'];
		$kdeplj	=$_GET['kdeplj'];

		$query 	="	SELECT 		g_gnrrcu.*,t_mstplj.nmaplj
					FROM   		g_gnrrcu,t_mstplj
					WHERE 		(g_gnrrcu.kdercu 	LIKE'%".$kdercu."%' OR '$kdercu'='')	AND
								(g_gnrrcu.kdegru 	LIKE'%".$user."%' 	OR '$user'='')   	AND
								(g_gnrrcu.kdeplj 	LIKE'%".$kdeplj."%' OR '$kdeplj'='') 	AND
								g_gnrrcu.kdeplj=t_mstplj.kdeplj
					ORDER BY 	g_gnrrcu.kdercu";
		$result	=mysql_query($query) or die (mysql_error());

		echo"
		<FORM ACTION=guru.php METHOD='get' NAME='f1'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>TEST RESULT</B></TD></TR>
				<TR></TR><TR></TR>

				<TR><TD WIDTH='10%'>Code</TD>
  					<TD WIDTH='90%'>:
						<INPUT 	NAME		='kdercu'
								TYPE		='text'
								SIZE		='15'
								MAXLENGTH	='15'
								id			='kdercu'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'>
					</TD>
  				</TR>
				<TR><TD>Subject</TD>
					<TD>:
						<INPUT 	NAME		='kdeplj'
								TYPE		='kdeplj'
								SIZE		='50'
								MAXLENGTH	='50'
								id			='kdeplj'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'>
						<INPUT TYPE='submit' 					VALUE='Search'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='R1D01F_Cari'>
						<INPUT TYPE='button' 					VALUE='View All' onClick=window.location.href='guru.php?mode=R1D01F_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>

		<FORM ACTION='guru.php?mode=R1D01F' METHOD='post'>
			<div style='overflow:auto;width:100%;height:320px;padding-right:-2px;'>
			<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
				<TR bgcolor='dedede'>
  					<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No				</CENTER></TD>
  					<TD WIDTH='10%'><CENTER>Code 	</CENTER></TD>
  					<TD WIDTH='20%'><CENTER>Subject	</CENTER></TD>
					<TD WIDTH='14%'><CENTER>Class	</CENTER></TD>
					<TD WIDTH='24%'><CENTER>Note	</CENTER></TD>
					<TD WIDTH=' 10%'><CENTER>Date	</CENTER></TD>
  					<TD WIDTH=' 4%'><CENTER>Detail	</CENTER></TD>
  					
				</TR>";

				$no=0;
				while($data =mysql_fetch_array($result))
				{
					$no++;
					echo"
					<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
  						<TD><CENTER>$no			</CENTER></TD>
  						<TD><CENTER>$data[kdercu]</CENTER></TD>
  						<TD><CENTER>$data[nmaplj]</CENTER></TD>
						<TD><CENTER>$data[kdekls]</CENTER></TD>
						<TD><center>$data[ktr]</center></TD>
						<TD><center>$data[tglrcu]</center></TD>
						<TD><center><a href='guru.php?mode=R1D01F_Detil&kdercu=$data[kdercu]'><IMG src='../images/detil_e.gif' BORDER='0'></a></center></TD>";
						
					echo"
					</TR>";
				}
			echo"
			</TABLE>
			</DIV>
			<BR>";
		echo"
		</FORM>";
 	}

	// -------------------------------------------------- Item --------------------------------------------------
	function R1D01F_Detil()
	{
		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';
		$user	=$_SESSION["Admin"]["kdekry"];
		$kdercu	=$_GET['kdercu'];
		$thn	='Tahun Ajaran';
	    $sms	='Semester';
	    $trm	='Term';
	    $midtrm	='Mid Term';
	
	$query 	=mysql_query("	SELECT 		t_setthn.* 
							FROM 		t_setthn
							WHERE		t_setthn.set='$thn'");
	$data = mysql_fetch_array($query);
	$nlithn=$data[nli];
	
	$query 	=mysql_query("	SELECT 		t_setthn.* 
							FROM 		t_setthn
							WHERE		t_setthn.set='$sms'");
	$data = mysql_fetch_array($query);
	$nlisms=$data[nli];

	$query 	=mysql_query("	SELECT 		t_setthn.* 
							FROM 		t_setthn
							WHERE		t_setthn.set='$trm'");
	$data = mysql_fetch_array($query);
	$nlitrm=$data[nli];

	$query 	=mysql_query("	SELECT 		t_setthn.* 
							FROM 		t_setthn
							WHERE		t_setthn.set='$midtrm'");
	$data = mysql_fetch_array($query);
	$nlimidtrm=$data[nli];
	
	$query ="	SELECT 		g_gnrrcu.*,t_mstplj.*
				FROM 		g_gnrrcu,t_mstssw,t_mstplj
				WHERE 		g_gnrrcu.kdercu='". mysql_escape_string($kdercu)."' AND
				            g_gnrrcu.kdekls=t_mstssw.kdekls	AND
							g_gnrrcu.kdeplj=t_mstplj.kdeplj
				ORDER BY 	t_mstssw.nmassw";
	$result =mysql_query($query);
	$data =mysql_fetch_array($result);
	$tglrcu	=$data[tglrcu];
	$kdekls	=$data[kdekls];
	$ktr	=$data[ktr];
	$kdeplj	=$data[kdeplj];
	$nmaplj	=$data[nmaplj];
	
	//-----Validasi kelas----//
		   echo"<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
                <SCRIPT TYPE='text/javascript' src='../guru/js/R1D01F.js'></SCRIPT>
		";
		//----End Validasi Kelas---//
		
		echo"
		<FORM ACTION='guru.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>TEST RESULT</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='10%'>Code</TD>
  					<TD WIDTH='90%'>:
						<INPUT 	NAME		='kdercu'
								TYPE		='text'
								SIZE		='15'
								MAXLENGTH	='15'
								VALUE		='$kdercu'
								DISABLED>
						Date :
						<INPUT 	NAME		='tglrcu'
								TYPE		='text'
								SIZE		='10'
								MAXLENGTH	='10'
								VALUE		='$tglrcu'
								DISABLED>
					</TD>
  				</TR>
				<TR><TD>Subject</TD>
					<TD>:
						<INPUT 	NAME		='kdeplj'
								TYPE		='kdeplj'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE		='$nmaplj'
								DISABLED>
					Class :			
						<INPUT 	NAME		='kdekls'
								TYPE		='kdekls'
								SIZE		='10'
								MAXLENGTH	='10'
								VALUE		='$kdekls'
								DISABLED>
					Note :			
						<INPUT 	NAME		='ktr'
								TYPE		='ktr'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE		='$ktr'
								DISABLED>			
					</TD>
				</TR>
			</TABLE>	
		
			<DIV style='overflow:auto;;width:100%;height:330px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%' class='table02'>

					<TR bgcolor='dedede'>
						<TD WIDTH=' 8%' HEIGHT='20'><CENTER>No	</CENTER></TD>
						<TD WIDTH='10%'><CENTER>NIS			</CENTER></TD>
						<TD WIDTH='70%'><CENTER>Name			</CENTER></TD>
						<TD WIDTH='12%'><CENTER>Mark				</CENTER></TD>
					</TR>";
					//---Setting Semester dan Midterm--//
					echo"
					<input type='hidden' name='sms' id='sms' value='$nlisms'>
					<input type='hidden' name='midtrm' id='midtrm' value='$nlimidtrm'>";
					//--End--//

					$query ="	SELECT 		t_mstssw.*
								FROM 		t_mstssw
								WHERE 		t_mstssw.kdekls='". mysql_escape_string($kdekls)."'
								ORDER BY 	t_mstssw.nmassw";
					$result =mysql_query($query);
					$i=0;					     
					$no=1;	

					while($data =mysql_fetch_array($result))
					{
						$nis	=$data['nis'];
						$nmassw	=$data['nmassw'];

					
						$query ="	SELECT 		u_gnroln.*,t_mstssw.*
									FROM 		u_gnroln,t_mstssw
									WHERE 		u_gnroln.kdercu='". mysql_escape_string($kdercu)."' AND
												u_gnroln.nis='". mysql_escape_string($nis)."'";
						$result1 =mysql_query($query);
						$data1 =mysql_fetch_array($result1);
						   
						$nisj	='nis'.$i;
						$nlij	='nli'.$i;
						if($data1['nis']!='')
							$nli	=$data1['nli'];
						else
							$nli	=0;

						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
							<TD HEIGHT=20><CENTER>$no 	</CENTER></TD>
							<TD><CENTER>$nis 	</CENTER></TD>
							<TD><input type='hidden' id='nis' name='$nisj' value='$nis'>
								<input type='hidden' name='kdeplj'  id='kdeplj' value='$kdeplj'>
								$nmassw
							</TD>
							<TD><center><input type='hidden' name='$nlij' value='$nli'>
								$nli</center>
							</TD>
						</TR>";
						$i++;
						$no++;
					}
				echo"	
				</TABLE>	
			</DIV><BR>Move Result :
						<SELECT	NAME		='kdebbt'
								ID			='kdebbt'
								CLASS		='kdebbt'
								onkeypress	='return enter(this,event)'>
						<OPTION VALUE='' SELECTED>--Select--</OPTION>";
						$query2="	SELECT 			t_mstbbt.*
									FROM 			t_mstbbt
									ORDER BY 		t_mstbbt.kdebbt";
						$result2=mysql_query($query2);
						while($data=mysql_fetch_array($result2))
						{
								echo"<OPTION VALUE='$data[kdebbt]'>$data[nmabbt]</OPTION>";
						}
						echo"
						</SELECT> 
						<SELECT	NAME		='prdtes'
								ID			='prdtes'
								CLASS		='prdtes'
								onkeypress	='return enter(this,event)'
								disabled>
						<OPTION VALUE='' SELECTED>--Select--</OPTION>
						</SELECT>
						<input type='hidden' name='dta'  id='dta'  size='5' value=''>
						<INPUT TYPE='submit'					VALUE='Transfer'>
				         <INPUT TYPE='hidden' NAME='mode' 		VALUE='R1D01F_Save'>
						 <INPUT TYPE='hidden' NAME='i' id='i'			VALUE=$i>
					</FORM>
		</BODY>";
	}
	
	// -------------------------------------------------- Save --------------------------------------------------
	function R1D01F_Save()
	{
		$kdeplj	=$_POST['kdeplj'];
		$prdtes	=$_POST['prdtes'];
		$i		=$_POST['i'];
        $kdeusr =$_SESSION['Admin']['kdekry'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");

		$j=0;
		while($j<$i)
		{
			$nis 	='nis'.$j;
			$nli 	='nli'.$j;
			//$nli1 	='nli1'.$j;
			$nis	=$_POST["$nis"]; 	
			$nli	=$_POST["$nli"]; 
           
			$set	="	SET		t_prgrptps.nis		='". mysql_escape_string($nis)."',
								t_prgrptps.kdeplj	='". mysql_escape_string($kdeplj)."',
								t_prgrptps.$prdtes	='". mysql_escape_string($nli)."',
								t_prgrptps.kdeusr	='". mysql_escape_string($kdeusr)."',
								t_prgrptps.tglrbh	='". mysql_escape_string($tglrbh)."',
								t_prgrptps.jamrbh	='". mysql_escape_string($jamrbh)."'"; 

			$query	="	SELECT 		t_prgrptps.*
						FROM 		t_prgrptps
						WHERE 		t_prgrptps.nis	='". mysql_escape_string($nis)."'	AND
									t_prgrptps.kdeplj	='". mysql_escape_string($kdeplj)."'";
			$result =mysql_query($query);
			$data	=mysql_fetch_array($result);
			if($data[nis]=='' AND $data[kdeplj]=='')
			{
			  	$query 	="INSERT INTO t_prgrptps ".$set; 
				$result	=mysql_query($query) or die (error("Data tidak berhasil di simpan"));
			}
			else
			{ 
				$query 	="	UPDATE 	t_prgrptps ".$set.
						"	WHERE 	t_prgrptps.nis	='". mysql_escape_string($nis)."'	AND
									t_prgrptps.kdeplj	='". mysql_escape_string($kdeplj)	."'";
				$result =mysql_query ($query) or die (error("Data tidak berhasil di rubah"));		
			}	
			$j++;
			
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D01F\">";
 	    }
	}
}//akhir class
?>