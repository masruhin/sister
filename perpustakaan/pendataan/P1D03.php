<?php
//----------------------------------------------------------------------------------------------------
//Program		: P1D03.php
//Sumber		: sister
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi ANGGOTA
//----------------------------------------------------------------------------------------------------
//	ANGGOTA siswa & non siswa
//	perpustakaan
//		pendataan
//			anggota
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class P1D03class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function P1D03_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$jnsang	=$_GET['jnsang'];
		$nmrang	=$_GET['nmrang'];
		$nmaang	=$_GET['nmaang'];
		$kdekls	=$_GET['kdekls'];

		if ($jnsang=='')
		{
			$query ="	SELECT 		t_mstssw.* 
						FROM 		t_mstssw
						WHERE 		(t_mstssw.nis 		LIKE'%".$nmrang."%' OR '$nmrang'='')	AND
									(t_mstssw.nmassw 	LIKE'%".$nmaang."%' OR '$nmaang'='')	AND
									(t_mstssw.kdekls 	LIKE'%".$kdekls."%' OR '$kdekls'='')	AND
									t_mstssw.str != 'K'											
						ORDER BY 	t_mstssw.nis";
		}
		else
		{
			$query	="	SELECT 		t_mstkry.*,t_sttkry.nmastt 
						FROM 		t_mstkry,t_sttkry
						WHERE 		(t_mstkry.kdekry	LIKE'%".$nmrang."%' OR '$nmrang'='')	AND
									(t_mstkry.nmakry 	LIKE'%".$nmaang."%' OR '$nmaang'='')	AND
									t_mstkry.str != 'K'											AND
									t_mstkry.kdestt=t_sttkry.kdestt
						ORDER BY 	t_mstkry.kdekry";
		}
		$result= mysql_query($query)	or die (mysql_error());

		echo"
		<FORM ACTION=perpustakaan.php METHOD='get'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>ANGGOTA</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Jenis Anggota</TD>
					<TD WIDTH='85%'>:
						<INPUT NAME			='jnsang'
								TYPE		='radio'
								VALUE 		=''
								ID			='jnsang'";
						if($jnsang=='')
							echo"checked";
							echo"> 
							SISWA
						<INPUT 	NAME		='jnsang'
								TYPE		='radio'
								VALUE 		='1'
								ID			='jnsang'";
						if($jnsang=='1')
							echo"checked";
							echo"> 
							NON SISWA
					</TD>
				</TR>				
				<TR><TD>Nomor Anggota</TD>
					<TD>: 
						<INPUT 	NAME		='nmrang'	
								ID			='nmrang'	
								TYPE		='text' 		
								SIZE		='10' 
								MAXLENGTH	='10' 
								onkeyup		='uppercase(this.id)'>										
					</TD>
				</TR>
				<TR><TD>Nama</TD>
					<TD>:
						<INPUT 	NAME		='nmaang'	
								ID			='nmaang'	
								TYPE		='text' 		
								SIZE		='50' 
								MAXLENGTH	='50'
								onkeyup		='uppercase(this.id)'>										
					</TD>
				</TR>
				<TR><TD>Kelas</TD>
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
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='P1D03_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='perpustakaan.php?mode=P1D03_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM ACTION='perpustakaan.php?mode=P1D03' METHOD='post'>
			<DIV style='overflow:auto;width:100%;height:320px;padding-right:-2px;'>				
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No				</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Nomor Anggota	</CENTER></TD>
						<TD WIDTH='57%'><CENTER>Nama		    </CENTER></TD>";
							if($jnsang=='') 	
							{
								echo"<TD WIDTH='25%'><CENTER>Kelas    </CENTER></TD>";
							}
							else 				
							{
								echo"<TD WIDTH='25%'><CENTER>Status   </CENTER></TD>";
							}	
						echo"
						<TD WIDTH=' 4%'><CENTER>Detil			</CENTER></TD>
					</TR>";

					$no=0;
					while($data =mysql_fetch_array($result))
					{
						$no++;
						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">";
							if($jnsang=='')
							{
								$nmr=$data[nis];
								$nma=$data[nmassw];
								$kls=$data[kdekls];
							}
							else
							{
								$nmr=$data[kdekry];
								$nma=$data[nmakry];
								$kls=$data[nmastt];
							}
							echo"
							<TD><CENTER>$no		</CENTER></TD>
							<TD><CENTER>$nmr	</CENTER></TD>
							<TD>$nma</TD>
							<TD><CENTER>$kls	</CENTER></TD>";
							// otorisasi akses detil
							if (hakakses("P1D03D")==1)
							{
								if($jnsang=='')
									echo"
									<TD><CENTER><a href='../perpustakaan/perpustakaan.php?mode=P1D03_Siswa&nis=$data[nis]'><IMG src='../images/detil_e.gif' BORDER='0' ></a></CENTER></TD>";
								else
									echo"
									<TD><CENTER><a href='../perpustakaan/perpustakaan.php?mode=P1D03_Karyawan&kdekry=$data[kdekry]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
							}
						echo"	
						</TR>";
					}
				echo"	
				</TABLE>	
			</DIV>
		</FORM>";
 	}

	// -------------------------------------------------- Detil Siswa --------------------------------------------------
	function P1D03_Siswa()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		// inisiasi parameter berdasarkan pilihan tombol
		$isian	='disabled';
		$nisB	=$_GET['nis'];
		$query 	="	SELECT 	t_mstssw.* 
					FROM 	t_mstssw
					WHERE 	t_mstssw.nis='". mysql_escape_string($nisB)."'";
		$result =mysql_query($query);
		$data 	=mysql_fetch_array($result);
		
		$nis	=$data[nis];
		$nisn	=$data[nisn];
		$nmassw	=$data[nmassw];
		$nmapgl	=$data[nmapgl];
		$tmplhr	=$data[tmplhr];
		$tgllhr	=$data[tgllhr];
		$jnsklm	=$data[jnsklm];
		$glndrh	=$data[glndrh];
		$kdeagm	=$data[kdeagm];
		$alm	=$data[alm];
		$kta	=$data[kta];
		$kdepos	=$data[kdepos];
		$tlp	=$data[tlp];
		$hpakt	=$data[hpakt];
		$kdekls	=$data[kdekls];
		$ktr	=$data[ktr];
		$pht	=$data[pht];
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='perpustakaan.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD WIDTH='15%'><B>SISWA</B></TD>
					<TD WIDTH='75%'></TD>
					<TD WIDTH='10%' COLSPAN='1' ROWSPAN='7' VALIGN='top' ALIGN='right'><IMG src='../files/photo/siswa/$nis.jpg' HEIGHT='130' WIDTH='110'></TD>
				</TR>
				<TR></TR><TR></TR>
				<TR><TD>NIS</TD>
					<TD>:
						<INPUT 	NAME		='nis'
								TYPE		='text' 	
								SIZE		='10'
								MAXLENGTH	='10'
								VALUE 		='$nis'
								$isian>
						NISN :
						<INPUT 	NAME		='nisn'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$nisn'
								$isian>
					</TD>
				</TR>				
				<TR><TD>Nama Lengkap</TD>
					<TD>:
						<INPUT 	NAME		='nmassw'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$nmassw'
								$isian>
					</TD>
				</TR>
				<TR><TD>Nama Panggilan</TD>
					<TD>:
						<INPUT 	NAME		='nmapgl'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$nmapgl'
								$isian>
					</TD>
				</TR>		
				<TR><TD>Jenis Kelamin</TD>
					<TD>:
						<INPUT NAME			='jnsklm'
								TYPE		='radio'
								VALUE 		='L'";
						if($jnsklm=='L')
							echo"checked";
							echo"	
							$isian> 
						Laki-laki
						<INPUT 	NAME		='jnsklm'
								TYPE		='radio'
								VALUE 		='P'";
						if($jnsklm=='P')
							echo"checked";
							echo" 
							$isian> 
						Perempuan
					</TD>
				</TR>
				
				<TR><TD>Tempat Lahir</TD>
					<TD COLSPAN='3'>:
						<INPUT 	NAME		='tmplhr'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$tmplhr'
								$isian>
						Tanggal Lahir :
						<INPUT 	NAME		='tgllhr'
								TYPE		='text'
								SIZE		='10'
								MAXLENGTH	='10'
								VALUE 		='$tgllhr'
								$isian>";
						if ($isian=='enable')		
						{ 
							echo"
							<IMG onClick='WdatePicker({el:tgllhr});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle'>";
						}		
					echo"	
					</TD>
				</TR>
				<TR><TD>Agama</TD>
					<TD>:
						<SELECT NAME		='kdeagm'
								VALUE 		='$kdeagm'
								$isian><OPTION>--Pilih--</OPTION>";
								$query="	SELECT 		t_mstagm.*
											FROM 		t_mstagm
											ORDER BY 	t_mstagm.kdeagm";
						$result=mysql_query($query);
						while($data=mysql_fetch_array($result))
						{
							if ($kdeagm==$data[kdeagm])
								echo"<OPTION VALUE='$data[kdeagm]' SELECTED>$data[nmaagm]</OPTION>";
							else
								echo"<OPTION VALUE='$data[kdeagm]'>$data[nmaagm]</OPTION>";
						}
						echo"
						</SELECT>
					</TD>
				</TR>				
				<TR><TD>Alamat</TD>
					<TD>:
						<TEXTAREA 	NAME		='alm'
									ROWS		='5'
									cols      	='50'
									VALUE 		='$alm'
									onchange	='uppercase(this.id)'
									$isian>$alm</TEXTAREA>
					</TD>
				</TR>
				<TR><TD>Kota</TD>
					<TD>:
						<INPUT 	NAME		='kta'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$kta'
								$isian>
						Kode Pos :
						<INPUT 	NAME		='kdepos'
								TYPE		='text'
								SIZE		='5'
								MAXLENGTH	='5'
								VALUE 		='$kdepos'
								$isian>
					</TD>
				</TR>
				<TR><TD>Telpon</TD>
					<TD>:
						<INPUT 	NAME		='tlp'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$tlp'
								$isian>
					</TD>
				</TR>
				<TR><TD>No Hp Siswa Aktif</TD>
					<TD>:
						<INPUT 	NAME		='hpakt'
								TYPE		='text'
								SIZE		='15'
								MAXLENGTH	='15'
								VALUE 		='$hpakt'
								$isian>
					</TD>
				</TR>
				<TR><TD>Kelas</TD>
					<TD>:
						<SELECT NAME		='kdekls'
								VALUE 		='$kdekls'
								$isian>";
						$query="	SELECT 		t_mstkls.*
									FROM 		t_mstkls
									ORDER BY 	t_mstkls.kdekls";
						$result=mysql_query($query);
						while($data=mysql_fetch_array($result))
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
			</TABLE>
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='perpustakaan.php?mode=P1D03_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
		</FORM>"; 
 	}	

	// -------------------------------------------------- Detil Karyawan --------------------------------------------------
	function P1D03_Karyawan()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	

		// inisiasi parameter berdasarkan pilihan tombol
	
		$isian	='disabled';
		
		$kdekryB=$_GET['kdekry'];
		$query 	="	SELECT 	t_mstkry.*,t_sttkry.nmastt 
					FROM 	t_mstkry,t_sttkry  
					WHERE 	t_mstkry.kdekry='". mysql_escape_string($kdekryB)."' 	AND
							t_mstkry.kdestt=t_sttkry.kdestt";
		$result =mysql_query($query);
		$data 	=mysql_fetch_array($result);
		
		$kdestt	=$data[kdestt];
		$kdekry	=$data[kdekry];
		$nmakry	=$data[nmakry];
		$alm	=$data[alm];
		$kta	=$data[kta];
		$kdepos	=$data[kdepos];
		$tlp	=$data[tlp];
		$hpakt	=$data[hpakt];
		$pht	=$data[pht];
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='perpustakaan.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD WIDTH='15%'><B>KARYAWAN</B></TD>
					<TD WIDTH='75%'></TD>
					<TD WIDTH='10%' COLSPAN='1' ROWSPAN='7' VALIGN='top' ALIGN='right'>
						<IMG src='../files/photo/karyawan/$kdekry.jpg' HEIGHT='130' WIDTH='110'>
					</TD>
				</TR>
				<TR></TR><TR></TR>
				<TR><TD>Status</TD>
					<TD>: 
						<SELECT	NAME		='kdestt'	
								VALUE 		='$kdestt'
								onkeypress	='return enter(this,event)'
								$isian>";
						$query="	SELECT 		t_sttkry.* 
								FROM 		t_sttkry  
								ORDER BY 	t_sttkry.kdestt";
    					$result=mysql_query($query);
    					while($data=mysql_fetch_array($result))
    					{
							if ($kdestt==$data[kdestt]) 
								echo"<OPTION VALUE='$data[kdestt]' SELECTED>$data[kdestt]-$data[nmastt]</OPTION>";
  	  						else 
								echo"<OPTION VALUE='$data[kdestt]' >$data[kdestt]-$data[nmastt]</OPTION>";
    					}
       					echo
						"</SELECT>		
					</TD>
				</TR>				
				<TR><TD>Kode Karyawan</TD>
					<TD>: 
						<INPUT 	NAME		='kdekry'	
								TYPE		='text' 	
								SIZE		='10' 	
								MAXLENGTH	='10'
								VALUE 		='$kdekry'
								$isian>
					</TD>
				</TR>
				<TR><TD>Nama Karyawan</TD>
					<TD>: 
						<INPUT 	NAME		='nmakry'	
								TYPE		='text' 
								SIZE		='50' 	
								MAXLENGTH	='50'		
								VALUE		='$nmakry'
								$isian>
					</TD>
				</TR>
				<TR><TD>Alamat</TD>
					<TD>: 
						<TEXTAREA	NAME		='alm'
									COLS		='50'
									ROWS		='3'
									$isian>$alm</TEXTAREA>
					</TD>
				</TR>
				<TR><TD>Kota</TD>
					<TD>: 
						<INPUT 	NAME		='kta'	
								TYPE		='text' 
								SIZE		='50' 	
								MAXLENGTH	='50'		
								VALUE		='$kta'
								$isian>
					</TD>
				</TR>
				<TR><TD>Kode Pos</TD>
					<TD>: 
						<INPUT 	NAME		='kdepos'	
								TYPE		='text' 
								SIZE		='5' 	
								MAXLENGTH	='5'		
								VALUE		='$kdepos'
								$isian>
					</TD>
				</TR>
				<TR><TD>Telpon</TD>
					<TD>: 
						<INPUT 	NAME		='tlp'	
								TYPE		='text' 
								SIZE		='50' 	
								MAXLENGTH	='50'		
								VALUE		='$tlp'
								$isian>
					</TD>
				</TR>
				<TR><TD>HP Aktif</TD>
					<TD>: 
						<INPUT 	NAME		='hpakt'	
								TYPE		='text' 
								SIZE		='15' 	
								MAXLENGTH	='15'		
								VALUE		='$hpakt'
								$isian>
					</TD>
				</TR>
			</TABLE>
			<INPUT TYPE='button' 				VALUE='Cari' 	onClick=window.location.href='perpustakaan.php?mode=P1D03_Cari'>
			<INPUT TYPE='button'				VALUE='Kembali'	onClick=history.go(-1)>						
		</FORM>"; 
 	}	
}//akhir class
?>