<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D04A.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 23/04/2012
//Keterangan	: Fungsi-fungsi JENIS PENERIMAAN
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}

// -------------------------------------------------- Class --------------------------------------------------
class R1D04Aclass
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function R1D04A_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdetkt	=$_GET['kdetkt'];
			
		$query 	="	SELECT 		t_setpgwa.*
					FROM 		t_setpgwa 
					WHERE 		(t_setpgwa.kdetkt LIKE'%".$kdetkt."%' OR '$kdetkt'='')
					ORDER BY 	t_setpgwa.kdetkt,t_setpgwa.idwa";
		$result	=mysql_query($query) or die (mysql_error());

		echo"
		<FORM ACTION=guru.php METHOD='get'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN=3><B>SETTING WEEKLY PROGRESS</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='10%'>Level</TD>
				
					<TD WIDTH='90%'>:
						<SELECT NAME		='kdetkt'
								ID			='kdetkt'
								ONKEYUP		='uppercase(this.id)'>
						<OPTION VALUE='' SELECTED>--All--</OPTION>";
						$query2="	SELECT 		t_msttkt.*
									FROM 		t_msttkt
                                    WHERE      	t_msttkt.kdetkt='PG' OR t_msttkt.kdetkt='KG'
									ORDER BY 	t_msttkt.urt";
						$result2=mysql_query($query2);
						while($data=mysql_fetch_array($result2))
						{
							if ($kdetkt==$data[kdetkt])
								echo"<OPTION VALUE='$data[kdetkt]' SELECTED>$data[nmatkt]</OPTION>";
							else
								echo"<OPTION VALUE='$data[kdetkt]'>$data[nmatkt]</OPTION>";
						}
						echo"
						</SELECT>
						<INPUT TYPE='submit' 					VALUE='View'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='R1D04A_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM ACTION='guru.php?mode=R1D04A' METHOD='post'>
			<DIV style='overflow:auto;width:100%;height:340px;padding-right:-2px;'>		
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No		</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Level	</CENTER></TD>
						<TD WIDTH='78%'><CENTER>Name of Weekly Progress	</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Detail	</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Delete	</CENTER></TD>
					</TR>";

					$no=0;
					while($data =mysql_fetch_array($result))
					{
						$no++;
						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
							<TD><CENTER>$no			</CENTER></TD>
							<TD>$data[kdetkt]</TD>
							<TD>$data[nmawa]</TD>";
							
							// otorisasi akses detil
							echo"
							<TD><CENTER><a href='guru.php?mode=R1D04A&idwa=$data[idwa]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
						
							// otorisasi akses hapus
							echo"
							<TD><CENTER><a href='guru.php?mode=R1D04A_Hapus&idwa=$data[idwa]' onClick=\"return confirm('Are you sure ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
						echo"	
						</TR>";
					}
				echo"	
				</TABLE>
			</DIV>
			<BR>";
			// otorisasi akses tambah
			echo"<INPUT TYPE='button' VALUE='Setting WEEKLY PROGRESS' onClick=window.location.href='guru.php?mode=R1D04A&pilihan=tambah'>";
		echo"	
		</FORM>";
 	}

	// -------------------------------------------------- Detil --------------------------------------------------
	function R1D04A()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	

		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../guru/js/R1D04A_validasi_kdetkt.js'></SCRIPT>";
		
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
				$isian2	='disabled';
				break;
			case 'tambah':
				$isian	='enable';
				$isian2	='disabled';
				break;
			case 'edit':
				$isian	='disabled';
				$isian2	='enable';
				break;
		}		

		if ($pilihan=='detil' OR $pilihan=='edit')
		{
			$idwa=$_GET['idwa'];
			$query 	="	SELECT 		t_setpgwa.*
						FROM 		t_setpgwa
						WHERE 		t_setpgwa.idwa='". mysql_escape_string($idwa)."'";
			$result	=mysql_query($query) or die (mysql_error());
			$data = mysql_fetch_array($result);
			$kdetkt	=$data[kdetkt];
			$nmawa	=$data[nmawa];
			
			$query 	="	SELECT 		t_setpgwaplj.* 
						FROM 		t_setpgwaplj 
						WHERE 		t_setpgwaplj.kdetkt='". mysql_escape_string($kdetkt)."'	
						ORDER BY 	t_setpgwaplj.kdetkt,t_setpgwaplj.idplj";
			$result	=mysql_query($query) or die (mysql_error());

			$i=0;
			while($data = mysql_fetch_array($result))
			{
				$cell[$i][0]=$idwa;
				$cell[$i][1]=$nmawa;
				$cell[$i][2]=$kdetkt;
				$cell[$i][3]=$data[kdeplj];
				$cell[$i][4]=$data[nmaplj];
				$kdeplj		=$data[kdeplj];
				$query2 	="	SELECT 		t_setpgwatpk.* 
								FROM 		t_setpgwatpk
								WHERE 		t_setpgwatpk.idwa='". mysql_escape_string($idwa)."' AND
											t_setpgwatpk.kdeplj='". mysql_escape_string($kdeplj)."'";
				$result2	=mysql_query($query2) or die (mysql_error());
				$data2 		= mysql_fetch_array($result2);	
				$cell[$i][5]=$data2[tpk1];
				$cell[$i][6]=$data2[tpk2];
				$cell[$i][7]=$data2[tpk3];
				$cell[$i][8]=$data2[tpk4];
				$cell[$i][9]=$data2[tpk5];
				$cell[$i][10]=$data2[out1];
				$cell[$i][11]=$data2[out2];
				$cell[$i][12]=$data2[out3];
				$cell[$i][13]=$data2[out4];
				$cell[$i][14]=$data2[out5];

				$i++;
			}	
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='guru.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>SETTING WEEKLY PROGRESS</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Level</TD>
					<TD WIDTH='85%'>:
						<SELECT NAME		='kdetkt'
								VALUE 		='$kdetkt'
								ID			='kdetkt'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required'
								TITLE		='must be filled'
								$isian>
						<OPTION VALUE='' SELECTED>--Select--</OPTION>";		
						$query="	SELECT 		t_msttkt.*
									FROM 		t_msttkt
                                    WHERE      	t_msttkt.kdetkt='PG' OR t_msttkt.kdetkt='KG'
									ORDER BY 	t_msttkt.urt";
						$result=mysql_query($query);
						while($data=mysql_fetch_array($result))
						{
							if ($kdetkt==$data[kdetkt])
								echo"<OPTION VALUE='$data[kdetkt]' SELECTED>$data[nmatkt]</OPTION>";
							else
								echo"<OPTION VALUE='$data[kdetkt]'>$data[nmatkt]</OPTION>";
						}
						echo"
						</SELECT>
					</TD>
				</TR>
				<TR><TD>Weekly Progress Name</TD>
					<TD>:
						<INPUT 	NAME		='nmawa'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE		='$nmawa'
								id			='nmawa'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'
								CLASS		='required'
								TITLE		='must be filled'
								$isian>";
						if($pilihan=='tambah')		
						{
							echo"		
							<INPUT TYPE='submit' 				VALUE='Save'>
							<INPUT TYPE='hidden' NAME='mode'	VALUE='R1D04A_Save'>";
						}	
					echo"		
					</TD>
				</TR>
			</TABLE>

			<DIV style='overflow:auto;;width:100%;height:340px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='90%' class='table02'>
					<TR bgcolor='dedede'>
						<TD WIDTH='10%' HEIGHT=20><CENTER>Subject	    </CENTER></TD>
						<TD WIDTH='45%'><CENTER>Topic	    </CENTER></TD>
						<TD WIDTH='45%'><CENTER>Outcomes/Expectations	</CENTER></TD>
					</TR>";
					$j=0;
					while($j<$i)
					{
						$kdeplj	='kdeplj'.$j;
						$kdepljv=$cell[$j][3];
						$nmaplj	='nmaplj'.$j;
						$nmapljv=$cell[$j][4];
						$x=0;
						while($x<5)
						{
							$y=$x+1;
							$tpk	='tpk'.$j.$y;;
							$tpkv	=$cell[$j][$x+5];
							$out	='out'.$j.$y;
							$outv	=$cell[$j][$x+10];
							if($x==0)
							{
								echo"
								<TR>
									<TD HEIGHT=20><CENTER>
										<INPUT 	NAME='$kdeplj'	TYPE='hidden' VALUE ='$kdepljv'>
										<INPUT 	NAME		='$nmaplj'
												TYPE		='text'
												SIZE		='20'
												MAXLENGTH	='20'
												VALUE 		='$nmapljv'
												ID			='$nmaplj'
												ONKEYPRESS	='return enter(this,event)'
												$isian></CENTER>
									</TD>";
							}		
							else
							{
								echo"
								<TD bgcolor='#D4D0C8'></TD>";
							}
							echo"	
								<TD><CENTER>
									<INPUT 	NAME		='$tpk'
											TYPE		='text'
											SIZE		='90'
											MAXLENGTH	='100'
											VALUE 		='$tpkv'
											ID			='$tpk'
											ONKEYPRESS	='return enter(this,event)'
											$isian2></CENTER>
									</TD>							
								<TD><CENTER>
									<INPUT 	NAME		='$out'
											TYPE		='text'
											SIZE		='90'
											MAXLENGTH	='100'
											VALUE 		='$outv'
											ID			='$out'
											ONKEYPRESS	='return enter(this,event)'
											$isian2></CENTER>
								</TD>
							</TR>";
							$x++;
						}
						$j++;
					}		
				echo"	
				</TABLE>	
			</DIV>";
					
			// pilihan tombol pilihan
			// tombol tambah
			if ($pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 	VALUE='New' 	onClick=window.location.href='guru.php?mode=R1D04A&pilihan=tambah'>";
			}	
					
			// tombol edit
			if ($pilihan=='detil')	
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Edit' 	onClick=window.location.href='guru.php?mode=R1D04A&idwa=$idwa&pilihan=edit'>";
			}	
					
			// tombol hapus
			if ($pilihan=='detil')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Delete' onClick=\"return confirm('Are you sure ?');\">
				<INPUT TYPE='hidden' NAME='mode'	VALUE='R1D04A_Hapus'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='hapus'>
				<INPUT TYPE='hidden' NAME='idwa'	VALUE='$idwa'>";
			}	
						
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Save'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='R1D04A_Save_Edit'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='idwa'	VALUE='$idwa'>
				<INPUT TYPE='hidden' NAME='i'		VALUE='$i'>";
			}
			echo"
			<INPUT TYPE='button' 	VALUE='Search' 	onClick=window.location.href='guru.php?mode=R1D04A_Cari'>
		</FORM>"; 
 	}

	// -------------------------------------------------- Hapus --------------------------------------------------
	function R1D04A_Hapus()
	{
		$pilihan=$_POST['pilihan'];
		if ($pilihan=='hapus')
		{
			$idwa	=$_POST['idwa'];
		}
		else
		{
			$idwa	=$_GET['idwa'];
		}	
		
		$query	="	DELETE 
					FROM 	t_setpgwa 
					WHERE 	t_setpgwa.idwa='". mysql_escape_string($idwa)."'";
		$result	=mysql_query($query) or die (mysql_error());		

		$query	="	DELETE 
					FROM 	t_setpgwatpk 
					WHERE 	t_setpgwatpk.idwa='". mysql_escape_string($idwa)."'";
		$result	=mysql_query($query) or die (mysql_error());		
		
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04A_Cari\">\n"; 
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function R1D04A_Save()
	{
  		$kdetkt	=$_POST['kdetkt'];
  		$nmawa	=$_POST['nmawa'];
  		$pilihan=$_POST['pilihan'];
		$idwa=rand();

		$set	="	SET		t_setpgwa.idwa		='". mysql_escape_string($idwa)	."',
							t_setpgwa.nmawa		='". mysql_escape_string($nmawa)	."',
							t_setpgwa.kdetkt	='". mysql_escape_string($kdetkt)	."'";
  		$query 	="	INSERT INTO t_setpgwa ".$set; 
		$result	=mysql_query($query) or die (mysql_error());
		
		$query 	="	SELECT 	t_setpgwaplj.* 
					FROM 	t_setpgwaplj 
					WHERE 	t_setpgwaplj.kdetkt='". mysql_escape_string($kdetkt)."'";
		$result	=mysql_query($query) or die (mysql_error());
		while($data = mysql_fetch_array($result))
		{
			$kdeplj=$data[kdeplj];
			$set	="	SET		t_setpgwatpk.idwa		='". mysql_escape_string($idwa)."',
								t_setpgwatpk.kdeplj	='". mysql_escape_string($kdeplj)	."'";
  			$query2 	="	INSERT INTO t_setpgwatpk ".$set; 
			$result2	=mysql_query($query2) or die (mysql_error());
		}
		
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04A&idwa=$idwa&pilihan=detil\">\n"; 
 	}
	
	// -------------------------------------------------- Save --------------------------------------------------
	function R1D04A_Save_Edit()
	{
		$idwa	=$_POST['idwa'];
		$i		=$_POST['i'];
		$j=0;
		while($j<$i)
		{ 
			$kdeplj ='kdeplj'.$j;
			$kdeplj	=$_POST["$kdeplj"]; 
			$tpk1   ="tpk"."$j"."1";
			$tpk1   =$_POST["$tpk1"]; 
			$tpk2   ="tpk"."$j"."2";
			$tpk2   =$_POST["$tpk2"]; 
			$tpk3   ="tpk"."$j"."3";
			$tpk3   =$_POST["$tpk3"]; 
			$tpk4   ="tpk"."$j"."4";
			$tpk4   =$_POST["$tpk4"]; 
			$tpk5   ="tpk"."$j"."5";
			$tpk5   =$_POST["$tpk5"]; 
			$out1   ="out"."$j"."1";
			$out1   =$_POST["$out1"]; 
			$out2   ="out"."$j"."2";
			$out2   =$_POST["$out2"]; 
			$out3   ="out"."$j"."3";
			$out3   =$_POST["$out3"]; 
			$out4   ="out"."$j"."4";
			$out4   =$_POST["$out4"]; 
			$out5   ="out"."$j"."5";
			$out5   =$_POST["$out5"]; 

			$set	="	SET		t_setpgwatpk.tpk1	='". mysql_escape_string($tpk1)."',
								t_setpgwatpk.tpk2	='". mysql_escape_string($tpk2)."',
								t_setpgwatpk.tpk3	='". mysql_escape_string($tpk3)."',
								t_setpgwatpk.tpk4	='". mysql_escape_string($tpk4)."',
								t_setpgwatpk.tpk5	='". mysql_escape_string($tpk5)."',
								t_setpgwatpk.out1	='". mysql_escape_string($out1)."',
								t_setpgwatpk.out2	='". mysql_escape_string($out2)."',
								t_setpgwatpk.out3	='". mysql_escape_string($out3)."',
								t_setpgwatpk.out4	='". mysql_escape_string($out4)."',
								t_setpgwatpk.out5	='". mysql_escape_string($out5)."'";

			$query 	="	UPDATE 	t_setpgwatpk ".$set.
					"	WHERE 	t_setpgwatpk.idwa	='". mysql_escape_string($idwa)	."'	AND
								t_setpgwatpk.kdeplj	='". mysql_escape_string($kdeplj)	."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));		
			$j++;
		}
		
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D04A&idwa=$idwa&pilihan=detil\">\n"; 
 	}
}//akhir class
?>