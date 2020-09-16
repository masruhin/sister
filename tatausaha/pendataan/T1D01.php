<?php
//----------------------------------------------------------------------------------------------------
//Program		: T1D01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi SISWA
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class T1D01class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function T1D01_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";
		
		$nis	=$_GET['nis'];
		$nisn	=$_GET['nisn'];
		$nmassw	=$_GET['nmassw'];
		$jnsklm	=$_GET['jnsklm'];
		$kdeagm	=$_GET['kdeagm'];
		$kdekls	=$_GET['kdekls'];
			
		$query ="	SELECT 		t_mstssw.*,t_mstkls.* 
					FROM 		t_mstssw,t_mstkls
					WHERE 		(t_mstssw.nis 		LIKE'%".$nis."%' 	OR '$nis'='')		AND
								(t_mstssw.nisn 		LIKE'%".$nisn."%' 	OR '$nisn'='')		AND
								(t_mstssw.nmassw 	LIKE'%".$nmassw."%' OR '$nmassw'='')	AND
								(t_mstssw.jnsklm 	LIKE'%".$jnsklm."%' OR '$jnsklm'='')	AND
								(t_mstssw.kdeagm 	LIKE'%".$kdeagm."%' OR '$kdeagm'='')	AND
								(t_mstssw.kdekls 	LIKE'%".$kdekls."%' OR '$kdekls'='')	AND
								t_mstssw.kdekls=t_mstkls.kdekls
					ORDER BY 	t_mstkls.kdeklm,t_mstssw.kdekls,t_mstssw.nis";
		$result= mysql_query($query)	or die (mysql_error());

		echo"
		<FORM ACTION=tatausaha.php METHOD='get'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>SISWA</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='15%'>NIS</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='nis'	
								ID			='nis'	
								TYPE		='text' 		
								SIZE		='10' 
								MAXLENGTH	='10' 
								onkeyup		='uppercase(this.id)'>										
					</TD>
				</TR>
				<TR><TD>NISN</TD>
					<TD>: 
						<INPUT 	NAME		='nisn'	
								ID			='nisn'	
								TYPE		='text' 		
								SIZE		='50' 
								MAXLENGTH	='50' 
								onkeyup		='uppercase(this.id)'>										
					</TD>
				</TR>
				<TR><TD>Nama Siswa</TD>
					<TD>:
						<INPUT 	NAME		='nmassw'	
								ID			='nmassw'	
								TYPE		='text' 		
								SIZE		='50' 
								MAXLENGTH	='50'
								onkeyup		='uppercase(this.id)'>										
					</TD>
				</TR>
				<TR><TD>Jenis Kelamin</TD>
					<TD>:
						<INPUT NAME			='jnsklm'
								TYPE		='radio'
								VALUE 		='L'
								ID			='jnsklm'";
						if($jnsklm=='L')
							echo"checked";
							echo"> 
							Laki-laki
						<INPUT 	NAME		='jnsklm'
								TYPE		='radio'
								VALUE 		='P'
								ID			='jnsklm'";
						if($jnsklm=='P')
							echo"checked";
							echo"> 
							Perempuan
						<INPUT 	NAME		='jnsklm'
								TYPE		='radio'
								VALUE 		=''
								ID			='jnsklm'";
						if($jnsklm=='')
							echo"checked";
							echo"> 
							Semuanya
					</TD>
				</TR>
				<TR><TD>Agama</TD>
					<TD>:
						<SELECT NAME		='kdeagm'
								ID			='kdeagm'
								ONKEYUP		='uppercase(this.id)'>";
						$query="	SELECT 		t_mstagm.*
									FROM 		t_mstagm
									ORDER BY 	t_mstagm.kdeagm";
						$result02=mysql_query($query);
						echo"<OPTION VALUE='' SELECTED>--Semua--</OPTION>";
						while($data02=mysql_fetch_array($result02))
						{
							if ($kdeagm==$data02[kdeagm])
								echo"<OPTION VALUE='$data02[kdeagm]' SELECTED>$data02[nmaagm]</OPTION>";
							else
								echo"<OPTION VALUE='$data02[kdeagm]'>$data02[nmaagm]</OPTION>";
						}
						echo"
						</SELECT>
					</TD>
				</TR>				
				<TR><TD>Kelas</TD>
					<TD>:
						<SELECT NAME		='kdekls'
								ID			='kdekls'
								ONKEYUP		='uppercase(this.id)'>";
						$query="	SELECT 		t_mstkls.*
									FROM 		t_mstkls
									ORDER BY 	t_mstkls.kdeklm,t_mstkls.kdekls";
						$result03=mysql_query($query);
						echo"<OPTION VALUE='' SELECTED>--Semua--</OPTION>";
						while($data03=mysql_fetch_array($result03))
						{
							if ($kdekls==$data03[kdekls])
								echo"<OPTION VALUE='$data03[kdekls]' SELECTED>$data03[kdekls]</OPTION>";
							else
								echo"<OPTION VALUE='$data03[kdekls]'>$data03[kdekls]</OPTION>";
						}
						echo"
						</SELECT>
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='T1D01_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='tatausaha.php?mode=T1D01_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM ACTION='tatausaha.php?mode=T1D01' METHOD='post'>
			<DIV style='overflow:auto;width:100%;height:240px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No				</CENTER></TD>
						<TD WIDTH='10%'><CENTER>NIS 			</CENTER></TD>
						<TD WIDTH='10%'><CENTER>NISN 			</CENTER></TD>
						<TD WIDTH='44%'><CENTER>Nama Siswa	    </CENTER></TD>
						<TD WIDTH='15%'><CENTER>Jns.Kelamin	    </CENTER></TD>
						<TD WIDTH=' 5%'><CENTER>Kelas	        </CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Detil			</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Edit			</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Hapus			</CENTER></TD>
					</TR>";

					$no=0;
					while($data=mysql_fetch_array($result))
					{
						$no++;
						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
							<TD><CENTER>$no			</CENTER></TD>
							<TD><CENTER>$data[nis]</CENTER></TD>
							<TD><CENTER>$data[nisn]</CENTER></TD>
							<TD>$data[nmassw]</TD>";
							if($data[jnsklm]=='L')
							{
								echo"<TD><CENTER>LAKI-LAKI</CENTER></TD>";
							}
							else
							{	
								echo"<TD><CENTER>PEREMPUAN</CENTER></TD>";
							}
							echo"
							<TD><CENTER>$data[kdekls]</CENTER></TD>	";
							// otorisasi akses detil
							if (hakakses("T1D01D")==1)
							{
								echo"
								<TD><CENTER><a href='tatausaha.php?mode=T1D01&nis=$data[nis]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
							}
						
							// otorisasi akses edit
							if (hakakses("T1D01E")==1)
							{		
								echo"
								<TD><CENTER><a href='tatausaha.php?mode=T1D01&nis=$data[nis]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/edit_d.gif' 	BORDER='0'></a></CENTER></TD>";
							}	
							
							// otorisasi akses hapus
							if (hakakses("T1D01H")==1)
							{		
								echo"
								<TD><CENTER><a href='tatausaha.php?mode=T1D01_Hapus&nis=$data[nis]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else	
							{
								echo"
								<TD><CENTER><IMG src='../images/hapus_d.gif' BORDER='0'></a></CENTER></TD>";
							}
						echo"	
						</TR>";
					}
				echo"	
				</TABLE>
			</DIV>
			<BR>";
			// otorisasi akses tambah
			if (hakakses("T1D01T")==1)
			{
				echo"
				<INPUT TYPE='button' VALUE='Tambah SISWA' onClick=window.location.href='tatausaha.php?mode=T1D01&pilihan=tambah'>";
				echo"
				<INPUT TYPE='button' VALUE='Cetak Daftar SISWA' onClick=window.location.href='tatausaha.php?mode=T1D01_CetakL'>";
			}	
		echo"	
		</FORM>";
 	}

	// -------------------------------------------------- Detil --------------------------------------------------
	function T1D01()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../tatausaha/js/T1D01_validasi_nis.js'></SCRIPT>";

		echo"
		<SCRIPT TYPE='text/javascript' src='../js/jquery-1.2.3.pack.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' src='../js/jquery.validate.pack.js'></SCRIPT>
		<script TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></script>
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
				break;
			case 'tambah':
				$isian	='enable';
				break;
			case 'edit':
				$isian	='enable';
				break;
		}		
		
		if ($pilihan=='detil' OR $pilihan=='edit')
		{
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
			$sklasl	=$data[sklasl];
			$bhsdgn	=$data[bhsdgn];
			$dftkls	=$data[dftkls];
			$sttb	=$data[sttb];
			$nem	=$data[nem];
			$kdekls	=$data[kdekls];
			$ktr	=$data[ktr];
			$psswrd	=$data[psswrd];
			$pht	=$data[pht];
			$kdeusr	=$data[kdeusr];
			$tglrbh	=$data[tglrbh];
			$jamrbh	=$data[jamrbh];
			
			
			
			$d_unit		= $data[unit];
			$sttb_thn	= $data[sttb_thn];
			$sklasl_almt= $data[sklasl_almt];
			$pdatgl		= $data[pdatgl];
			$d_status	= $data[status];
			
			
			
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='tatausaha.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>SISWA</B></TD>
					<TD COLSPAN='5' ALIGN='right'>";
						if ($pilihan=='detil')
						{
							echo"
							| <a href='tatausaha.php?mode=T1D01_Ayah&nis=$nis&pilihan=$pilihan'>Ayah</a> 
							| <a href='tatausaha.php?mode=T1D01_Ibu&nis=$nis&pilihan=$pilihan'>Ibu</a> 
							| <a href='tatausaha.php?mode=T1D01_Wali&nis=$nis&pilihan=$pilihan'>Wali</a> 
							| <a href='tatausaha.php?mode=T1D01_Saudara&nis=$nis&pilihan=$pilihan'>Saudara</a> |";
						}	
					echo"
					</TD>
				</TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>NIS</TD>
					<TD WIDTH='65%'>:
						<INPUT 	NAME		='nis'
								TYPE		='text' 	
								SIZE		='10'
								MAXLENGTH	='10'
								VALUE 		='$nis'
								ID			='nis'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...diisi'
								$isian>
						<SPAN 	ID			='msgbox'  
								STYLE		='display:none'>
						</SPAN>
						NISN :
						<INPUT 	NAME		='nisn'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$nisn'
								ID			='nisn'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								$isian>
					</TD>
					<TD WIDTH='20%' COLSPAN='1' ROWSPAN='7' VALIGN='top' ALIGN='right'><IMG src='../images/siswa/$nis.jpg' HEIGHT='178' WIDTH='118' /><BR>";//IMG src='../images/Pre-K/$nis.jpg'
						if (hakakses('T1D01E')==1 and $pilihan=='detil')
						{
							echo"
							<a href='tatausaha.php?mode=T1D01_Reset&nis=$nis&i=1' onClick=\"return confirm('Benar password akan direset ?');\">Reset Password Siswa</a><br>
							<a href='tatausaha.php?mode=T1D01_Reset&nis=$nis&i=2' onClick=\"return confirm('Benar password akan direset ?');\">Reset Password Orang Tua</a>";
						}//ONKEYUP		='uppercase(this.id)'
					echo"		
					</TD>
				</TR>				
					
				<TR><TD>Nama Lengkap</TD>
					<TD>:
						<INPUT 	NAME		='nmassw'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$nmassw'
								ID			='nmassw'
								
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required'
								TITLE		='...diisi'
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
								ID			='nmapgl'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required'
								TITLE		='...diisi'
								$isian>
					</TD>
				</TR>		
				<TR><TD>Jenis Kelamin</TD>
					<TD>:
						<INPUT NAME			='jnsklm'
								TYPE		='radio'
								VALUE 		='L'
								ID			='jnsklm'
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required'
								TITLE		='...diisi'";
						if($jnsklm=='L')
							echo"checked";
							echo"	
							$isian> 
							Laki-laki
						<INPUT 	NAME		='jnsklm'
								TYPE		='radio'
								VALUE 		='P'
								ID			='jnsklm'
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required'
								TITLE		='...diisi' ";
						if($jnsklm=='P')
							echo"checked";
							echo" 
							$isian> 
							Perempuan
					</TD>
				</TR>
				
				<!--	ONKEYUP		='uppercase(this.id)'	-->
				
				<TR><TD>Tempat Lahir</TD>
					<TD COLSPAN='3'>:
						<INPUT 	NAME		='tmplhr'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$tmplhr'
								ID			='tmplhr'
								
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required'
								TITLE		='...diisi'
								$isian>
						Tanggal Lahir :
						<INPUT 	NAME		='tgllhr'
								TYPE		='text'
								SIZE		='10'
								MAXLENGTH	='10'
								VALUE 		='$tgllhr'
								ID			='tgllhr'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required'
								TITLE		='...diisi'
								$isian>";
						if ($isian=='enable')		
						{ 
							echo"
							<IMG onClick='WdatePicker({el:tgllhr});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle'>";
						}		
					echo"	
					</TD>
				</TR>
				<TR><TD>Golongan Darah</TD>
					<TD>:
						<SELECT NAME		='glndrh'
								VALUE 		='$glndrh'
								ID			='glndrh'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required'
								TITLE		='...diisi'
								$isian>";
								$query="	SELECT 	t_glndrh.*
											FROM 	t_glndrh";
						$result=mysql_query($query);
						while($data=mysql_fetch_array($result))
						{
							if ($glndrh==$data[glndrh])
								echo"<OPTION VALUE='$data[glndrh]' SELECTED>$data[glndrh]</OPTION>";
							else
								echo"<OPTION VALUE='$data[glndrh]'>$data[glndrh]</OPTION>";
						}
						echo"
						</SELECT>
					</TD>
				</TR>	
				<TR><TD>Agama</TD>
					<TD>:
						<SELECT NAME		='kdeagm'
								VALUE 		='$kdeagm'
								ID			='kdeagm'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required'
								TITLE		='...diisi'
								$isian>
						<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
						$query	="	SELECT 		t_mstagm.*
									FROM 		t_mstagm
									ORDER BY 	t_mstagm.kdeagm";
						$result	=mysql_query($query);
						while($data=mysql_fetch_array($result))
						{
							if ($kdeagm==$data[kdeagm])
								echo"<OPTION VALUE='$data[kdeagm]' SELECTED>$data[nmaagm]</OPTION>";
							else
								echo"<OPTION VALUE='$data[kdeagm]'>$data[nmaagm]</OPTION>";
						}//CLASS		='required'		CLASS		='required'							onchange	='uppercase(this.id)'
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
									ID			='alm'
									
									CLASS		='required'
									TITLE		='...diisi'
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
								ID			='kta'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								
								TITLE		='...diisi'
								$isian>
						Kode Pos :
						<INPUT 	NAME		='kdepos'
								TYPE		='text'
								SIZE		='5'
								MAXLENGTH	='5'
								VALUE 		='$kdepos'
								ID			='kdepos'
								onkeyup		='javascript:checknumber(f1.kdepos);'
								ONKEYPRESS	='return enter(this,event)'
								
								TITLE		='...diisi'
								$isian>
					</TD>
				</TR>
				<TR><TD></TD>
					<TD COLSPAN=3 align=left><span style='color: #FF0000;'>* contoh pengisian telpon/HP Aktif : +628xxxxxxxxx (untuk GSM) atau 021xxxxxxx (untuk CDMA)</span></TD>
				</TR>
				<TR><TD>Telpon</TD>
					<TD>:
						<INPUT 	NAME		='tlp'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$tlp'
								ID			='tlp'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
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
								ID			='hpakt'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								$isian>
						<SPAN style='color: #FF0000;'>* Akan digunakan untuk informasi via sms</SPAN>		
					</TD>
				</TR>
				<TR><TD>Sekolah Asal</TD>
					<TD>:
						<INPUT 	NAME		='sklasl'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$sklasl'
								ID			='sklasl'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								$isian>
					</TD>
				</TR>	<!--	sklasl_almt		-->
				<TR><TD>Alamat Sekolah Asal</TD>
					<TD>:
						<TEXTAREA 	NAME		='sklasl_almt'
									ROWS		='1'
									cols      	='50'
									VALUE 		='$sklasl_almt'
									ID			='sklasl_almt'
									
									$isian>$sklasl_almt</TEXTAREA>
					</TD>
				</TR>
				<TR><TD>STTB</TD>
					<TD>:
						<INPUT 	NAME		='sttb'
								TYPE		='text'
								SIZE		='20'
								MAXLENGTH	='20'
								VALUE 		='$sttb'
								ID			='sttb'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								$isian>
						NEM :
						<INPUT 	NAME		='nem'
								TYPE		='text'
								SIZE		='8'
								MAXLENGTH	='8'
								VALUE 		='$nem'
								ID			='nem'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								$isian>
						
						Tahun STTB :
						<INPUT 	NAME		='sttb_thn'
								TYPE		='text'
								SIZE		='4'
								MAXLENGTH	='4'
								VALUE 		='$sttb_thn'
								ID			='sttb_thn'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								$isian />
					</TD>
				</TR>
				<TR><TD>Bahasa sehari-hari</TD>
					<TD>:
						<INPUT 	NAME		='bhsdgn'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$bhsdgn'
								ID			='bhsdgn'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								$isian>
					</TD>
				</TR>
				<TR><TD>Status anak</TD>
					<TD>:
						<INPUT 	NAME		='d_status'
								TYPE		='text'
								SIZE		='20'
								MAXLENGTH	='20'
								VALUE 		='$d_status'
								ID			='d_status'
								
								ONKEYPRESS	='return enter(this,event)'
								
								TITLE		='Mohon tolong diisi ( Anak Kandung ) terima kasih'
								$isian />
					</TD>
				</TR>
				<tr>
					<td colspan='2'>
						
					</td>
				</tr>
				<TR><TD>Diterima di sekolah ini pada Tanggal</TD>
					<TD>:
						<INPUT 	NAME		='pdatgl'
								TYPE		='text'
								SIZE		='10'
								MAXLENGTH	='10'
								VALUE 		='$pdatgl'
								ID			='pdatgl'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								
								$isian>";
						if ($isian=='enable')		
						{ 
							echo"
							<IMG onClick='WdatePicker({el:pdatgl});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle'>";
						}
						
						echo"
					</TD>
					
				</TR>
				<tr>
					<td colspan='2'>
						
					</td>
				</tr>
				<TR><TD>Mendaftar untuk kelas</TD>
					<TD>:
						<SELECT NAME		='dftkls'
								VALUE 		='$dftkls'
								ID			='dftkls'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required'
								TITLE		='...diisi'
								$isian>
								<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";//";
						$query="	SELECT 		t_klmkls.*
									FROM 		t_klmkls
									ORDER BY 	t_klmkls.kdeklm";
						$result=mysql_query($query);
						while($data=mysql_fetch_array($result))
						{
							if ($dftkls==$data[kdeklm])
								echo"<OPTION VALUE='$data[kdeklm]' SELECTED>$data[kdeklm]</OPTION>";
							else
								echo"<OPTION VALUE='$data[kdeklm]'>$data[kdeklm]</OPTION>";
						}
						echo"
						</SELECT>
						
					</TD>
					
				</TR>
				<TR><TD>Kelas</TD>
					<TD>:
						<SELECT NAME		='kdekls'
								VALUE 		='$kdekls'
								ID			='kdekls'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required'
								TITLE		='...diisi'
								$isian>
								<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";//";
						$query="	SELECT 		t_mstkls.*
									FROM 		t_mstkls
									ORDER BY 	t_mstkls.kdeklm,t_mstkls.kdekls";
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
				
				
				
				<TR><TD>UNIT</TD>
					<TD>:
						<SELECT NAME		='d_unit'
								VALUE 		='$d_unit'
								ID			='d_unit'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required'
								TITLE		='...diisi'
								$isian>
								<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";//";
						$query="	SELECT 		t_msttkt.unit
									FROM 		t_msttkt
									
									ORDER BY 	t_msttkt.urt";//WHERE		t_msttkt.unit = 'SD'
						$result=mysql_query($query);
						while($data=mysql_fetch_array($result))
						{
							if ($d_unit==$data[unit])
								echo"<OPTION VALUE='$data[unit]' SELECTED>$data[unit]</OPTION>";
							else
								echo"<OPTION VALUE='$data[unit]'>$data[unit]</OPTION>";
						}
						echo"
						</SELECT>
					</TD>
				</TR>
				
				
				
				<TR><TD>Keterangan</TD>
					<TD>:
						<TEXTAREA 	NAME		='ktr'
									ROWS		='5'
									cols       	='50'
									VALUE 		='$ktr'
									ID			='ktr'
									onchange	='uppercase(this.id)'
									$isian>$ktr</TEXTAREA>
					</TD>
				</TR>
				<TR><TD>Photo</TD>
					<TD COLSPAN='3'>:
						<INPUT 	NAME		='pht'
								TYPE		='file'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE		='$pht'
								onkeypress	='return enter(this,event)'
								$isian>
						<SPAN style='color: #FF0000;'>* Format file JPG, ukuran 150px x 180px</SPAN>
					</TD>
				</TR>				
			</TABLE>";

			// pilihan tombol pilihan
			// tombol tambah
			if (hakakses('T1D01T')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Tambah' 	onClick=window.location.href='tatausaha.php?mode=T1D01&pilihan=tambah'>";
			}	
						
			// tombol edit
			if (hakakses('T1D01E')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button'	VALUE='Edit' 	onClick=window.location.href='tatausaha.php?mode=T1D01&nis=$nis&pilihan=edit'>";
			}	
						
			// tombol hapus
			if (hakakses('T1D01H')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Hapus' onClick=\"return confirm('Benar data akan dihapus ?');\">
				<INPUT TYPE='hidden' NAME='mode'	VALUE='T1D01_Hapus'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='hapus'>
				<INPUT TYPE='hidden' NAME='nis'	VALUE='$nis'>";
			}	
						
			// tombol simpan (tambah)
			if($pilihan=='tambah')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='reset' 				VALUE='Ulang'>
				<INPUT TYPE='hidden' NAME='mode'	VALUE='T1D01_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='tambah'>";
			}
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='T1D01_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='nisB'	VALUE='$nisB'>";
			}
			if($pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 				VALUE='Cetak' 	onClick=window.open('pendataan/T1D01_C01.php?nis=$nis')>";
			}
			echo"
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='tatausaha.php?mode=T1D01_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
			$kdeusr - $tglrbh - $jamrbh
		</FORM>"; 
 	}
	
	// -------------------------------------------------- Detil Ayah --------------------------------------------------
	function T1D01_Ayah()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		// inisiasi parameter berdasarkan pilihan tombol
		$pilihan=$_GET['pilihan'];

		switch($pilihan)
		{
			case 'detil':
				$isian	='disabled';
				break;
			case 'edit':
				$isian	='enable';
				break;
		}		
		
		$nisB	=$_GET['nis'];
		$query 	="	SELECT 	t_mstssw.* 
					FROM 	t_mstssw
					WHERE 	t_mstssw.nis='". mysql_escape_string($nisB)."'";
		$result =mysql_query($query);
		$data 	=mysql_fetch_array($result);
	
		$nis	=$data[nis];
		$nmassw	=$data[nmassw];
		$kdeagm	=$data[kdeagm];
		$nmaayh	=$data[nmaayh];
		$almayh	=$data[almayh];
		$tlpayh	=$data[tlpayh];
		$hpaayh	=$data[hpaayh];
		$agmayh	=$data[agmayh];
		if($agmayh=='')
		{
			$agmayh=$kdeagm;
		}
		$pkjayh	=$data[pkjayh];
		$kdeusr	=$data[kdeusr];
		$tglrbh	=$data[tglrbh];
		$jamrbh	=$data[jamrbh];		
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='tatausaha.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>ORANG TUA (AYAH)</B></TD>
					<TD COLSPAN='2' ALIGN='right'>";
						if ($pilihan=='detil')
						{
							echo"
							| <a href='tatausaha.php?mode=T1D01&nis=$nis&pilihan=$pilihan'>Siswa</a> 
							| <a href='tatausaha.php?mode=T1D01_Ibu&nis=$nis&pilihan=$pilihan'>Ibu</a> 
							| <a href='tatausaha.php?mode=T1D01_Wali&nis=$nis&pilihan=$pilihan'>Wali</a> 
							| <a href='tatausaha.php?mode=T1D01_Saudara&nis=$nis&pilihan=$pilihan'>Saudara</a> |";					
						}	
					echo"
					</TD>
				</TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>NIS</TD>
					<TD WIDTH='85%'>:
						<INPUT 	NAME		='nis'
								TYPE		='text' 	
								SIZE		='10'
								MAXLENGTH	='10'
								VALUE 		='$nis'
								DISABLED>
					</TD>
				</TR>				
				<TR><TD>Nama Lengkap</TD>
					<TD>:
						<INPUT 	NAME		='nmassw'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$nmassw'
								DISABLED>
					</TD>
				</TR>
				<TR><TD><HR></TD></TR>	<!--ONKEYUP		='uppercase(this.id)'-->
				<TR><TD>Nama Ayah</TD>
					<TD>:
						<INPUT 	NAME		='nmaayh'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$nmaayh'
								ID			='nmaayh'
								
								ONKEYPRESS	='return enter(this,event)'
								$isian>
					</TD>
				</TR>
				<TR><TD></TD>
					<TD><SPAN style='color: #FF0000;'>* Alamat dan Telpon diisi jika berbeda dengan data siswa / kosongkan jika sama</SPAN></TD>
				</TR>
				<TR><TD>Alamat</TD>
					<TD>:
						<TEXTAREA 	NAME		='almayh'
									ROWS		='5'
									cols      	='50'
									VALUE 		='$almayh'
									ID			='almayh'
									
									$isian>$almayh</TEXTAREA>
					</TD>
				</TR>				
				<TR><TD>Telpon</TD>
					<TD>:
						<INPUT 	NAME		='tlpayh'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$tlpayh'
								ID			='tlpayh'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								$isian>
					</TD>
				</TR>
				<TR><TD>No Hp Aktif</TD>
					<TD>:
						<INPUT 	NAME		='hpaayh'
								TYPE		='text'
								SIZE		='15'
								MAXLENGTH	='15'
								VALUE 		='$hpaayh'
								ID			='hpaayh'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								$isian>
						<SPAN style='color: #FF0000;'>* Akan digunakan untuk informasi via sms</SPAN>				
					</TD>
				</TR>
				<TR><TD>Agama</TD>
					<TD>:
						<SELECT NAME		='agmayh'
								VALUE 		='$agmayh'
								ID			='agmayh'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								$isian><OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
								$query="	SELECT 		t_mstagm.*
											FROM 		t_mstagm
											ORDER BY 	t_mstagm.kdeagm";
						$result=mysql_query($query);
						while($data=mysql_fetch_array($result))
						{
							if ($agmayh==$data[kdeagm])
								echo"<OPTION VALUE='$data[kdeagm]' SELECTED>$data[nmaagm]</OPTION>";
							else
								echo"<OPTION VALUE='$data[kdeagm]'>$data[nmaagm]</OPTION>";
						}
						echo"
						</SELECT>
					</TD>
				</TR>		
				<TR><TD>Pekerjaan</TD>
					<TD>:
						<INPUT 	NAME		='pkjayh'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$pkjayh'
								ID			='pkjayh'
								
								ONKEYPRESS	='return enter(this,event)'
								$isian>
					</TD>
				</TR>
			</TABLE>";

			// pilihan tombol pilihan
			// tombol edit
			if (hakakses('T1D01E')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button'	VALUE='Edit' 	onClick=window.location.href='tatausaha.php?mode=T1D01_Ayah&nis=$nis&pilihan=edit'>";
			}	
						
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='T1D01_Save_Ayah'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='nis'		VALUE=$nis>";
			}
			echo"
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='tatausaha.php?mode=T1D01_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
			$kdeusr - $tglrbh - $jamrbh
		</FORM>"; 
 	}

	// -------------------------------------------------- Detil Ibu --------------------------------------------------
	function T1D01_Ibu()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		// inisiasi parameter berdasarkan pilihan tombol
		$pilihan=$_GET['pilihan'];

		switch($pilihan)
		{
			case 'detil':
				$isian	='disabled';
				break;
			case 'edit':
				$isian	='enable';
				break;
		}		
		
		$nisB=$_GET['nis'];
		$query 	="	SELECT 	t_mstssw.* 
					FROM 	t_mstssw
					WHERE 	t_mstssw.nis='". mysql_escape_string($nisB)."'";
		$result =mysql_query($query);
		$data 	=mysql_fetch_array($result);
	
		$nis	=$data[nis];
		$nmassw	=$data[nmassw];
		$kdeagm	=$data[kdeagm];
		$nmaibu	=$data[nmaibu];
		$almibu	=$data[almibu];
		$tlpibu	=$data[tlpibu];
		$hpaibu	=$data[hpaibu];
		$agmibu	=$data[agmibu];
		if($agmibu=='')
		{
			$agmibu=$kdeagm;
		}
		$pkjibu	=$data[pkjibu];
		$kdeusr	=$data[kdeusr];
		$tglrbh	=$data[tglrbh];
		$jamrbh	=$data[jamrbh];		
		
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='tatausaha.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>ORANG TUA (IBU)</B></TD>
					<TD COLSPAN='2' ALIGN='right'>";
						if ($pilihan=='detil')
						{
							echo"
							| <a href='tatausaha.php?mode=T1D01&nis=$nis&pilihan=$pilihan'>Siswa</a> 
							| <a href='tatausaha.php?mode=T1D01_Ayah&nis=$nis&pilihan=$pilihan'>Ayah</a> 
							| <a href='tatausaha.php?mode=T1D01_Wali&nis=$nis&pilihan=$pilihan'>Wali</a> 
							| <a href='tatausaha.php?mode=T1D01_Saudara&nis=$nis&pilihan=$pilihan'>Saudara</a> |";					
						}	
					echo"
					</TD>
				</TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>NIS</TD>
					<TD WIDTH='85%'>:
						<INPUT 	NAME		='nis'
								TYPE		='text' 	
								SIZE		='10'
								MAXLENGTH	='10'
								VALUE 		='$nis'
								DISABLED>
					</TD>
				</TR>				
				<TR><TD>Nama Lengkap</TD>
					<TD>:
						<INPUT 	NAME		='nmassw'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$nmassw'
								DISABLED>
					</TD>
				</TR>
				<TR><TD><HR></TD></TR>	<!--ONKEYUP		='uppercase(this.id)'-->
				<TR><TD>Nama Ibu</TD>
					<TD>:
						<INPUT 	NAME		='nmaibu'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$nmaibu'
								ID			='nmaibu'
								
								ONKEYPRESS	='return enter(this,event)'
								$isian>
					</TD>
				</TR>
				<TR><TD></TD>
					<TD><SPAN style='color: #FF0000;'>* Alamat dan Telpon diisi jika berbeda dengan data siswa / kosongkan jika sama</SPAN></TD>
				</TR>
				<TR><TD>Alamat</TD>
					<TD>:
						<TEXTAREA 	NAME		='almibu'
									ROWS		='5'
									cols      	='50'
									VALUE 		='$almibu'
									ID			='almibu'
									
									$isian>$almibu</TEXTAREA>
					</TD>
				</TR>				
				<TR><TD>Telpon</TD>
					<TD>:
						<INPUT 	NAME		='tlpibu'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$tlpibu'
								ID			='tlpibu'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								$isian>
					</TD>
				</TR>
				<TR><TD>No Hp Aktif</TD>
					<TD>:
						<INPUT 	NAME		='hpaibu'
								TYPE		='text'
								SIZE		='15'
								MAXLENGTH	='15'
								VALUE 		='$hpaibu'
								ID			='hpaibu'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								$isian>
						<SPAN style='color: #FF0000;'>* Akan digunakan untuk informasi via sms</SPAN>				
					</TD>
				</TR>
				<TR><TD>Agama</TD>
					<TD>:
						<SELECT NAME		='agmibu'
								VALUE 		='$agmibu'
								ID			='agmibu'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								$isian><OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
						$query="	SELECT 		t_mstagm.*
									FROM 		t_mstagm
									ORDER BY 	t_mstagm.kdeagm";
						$result=mysql_query($query);
						while($data=mysql_fetch_array($result))
						{
							if ($agmibu==$data[kdeagm])
								echo"<OPTION VALUE='$data[kdeagm]' SELECTED>$data[nmaagm]</OPTION>";
							else
								echo"<OPTION VALUE='$data[kdeagm]'>$data[nmaagm]</OPTION>";
						}
						echo"
						</SELECT>
					</TD>
				</TR>		
				<TR><TD>Pekerjaan</TD>
					<TD>:
						<INPUT 	NAME		='pkjibu'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$pkjibu'
								ID			='pkjibu'
								
								ONKEYPRESS	='return enter(this,event)'
								$isian>
					</TD>
				</TR>
			</TABLE>";

			// pilihan tombol pilihan
			// tombol edit
			if (hakakses('T1D01E')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button'	VALUE='Edit' 	onClick=window.location.href='tatausaha.php?mode=T1D01_Ibu&nis=$nis&pilihan=edit'>";
			}	
						
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='T1D01_Save_Ibu'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='nis'		VALUE=$nis>";
			}
			echo"
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='tatausaha.php?mode=T1D01_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
			$kdeusr - $tglrbh - $jamrbh
		</FORM>"; 
 	}	

	// -------------------------------------------------- Detil Wali --------------------------------------------------
	function T1D01_Wali()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		// inisiasi parameter berdasarkan pilihan tombol
		$pilihan=$_GET['pilihan'];

		switch($pilihan)
		{
			case 'detil':
				$isian	='disabled';
				break;
			case 'edit':
				$isian	='enable';
				break;
		}		
		
		$nisB=$_GET['nis'];
		$query 	="	SELECT 	t_mstssw.* 
					FROM 	t_mstssw
					WHERE 	t_mstssw.nis='". mysql_escape_string($nisB)."'";
		$result =mysql_query($query);
		$data 	=mysql_fetch_array($result);
	
		$nis	=$data[nis];
		$nmassw	=$data[nmassw];
		$kdeagm	=$data[kdeagm];
		$nmawli	=$data[nmawli];
		$almwli	=$data[almwli];
		$tlpwli	=$data[tlpwli];
		$hpawli	=$data[hpawli];
		$agmwli	=$data[agmwli];
		if($agmwli=='')
		{
			$agmwli=$kdeagm;
		}
		$pkjwli	=$data[pkjwli];
		$kdeusr	=$data[kdeusr];
		$tglrbh	=$data[tglrbh];
		$jamrbh	=$data[jamrbh];		
		
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='tatausaha.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>WALI SISWA</B></TD>
					<TD COLSPAN='2' ALIGN='right'>";
						if ($pilihan=='detil')
						{
							echo"
							| <a href='tatausaha.php?mode=T1D01&nis=$nis&pilihan=$pilihan'>Siswa</a> 
							| <a href='tatausaha.php?mode=T1D01_Ayah&nis=$nis&pilihan=$pilihan'>Ayah</a> 
							| <a href='tatausaha.php?mode=T1D01_Ibu&nis=$nis&pilihan=$pilihan'>Ibu</a> 
							| <a href='tatausaha.php?mode=T1D01_Saudara&nis=$nis&pilihan=$pilihan'>Saudara</a> |";					
						}	
					echo"
					</TD>
				</TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>NIS</TD>
					<TD WIDTH='85%'>:
						<INPUT 	NAME		='nis'
								TYPE		='text' 	
								SIZE		='10'
								MAXLENGTH	='10'
								VALUE 		='$nis'
								DISABLED>
					</TD>
				</TR>				
				<TR><TD>Nama Lengkap</TD>
					<TD>:
						<INPUT 	NAME		='nmassw'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$nmassw'
								DISABLED>
					</TD>
				</TR>
				<TR><TD><HR></TD></TR>	
				<TR><TD>Nama Wali</TD>
					<TD>:
						<INPUT 	NAME		='nmawli'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$nmawli'
								ID			='nmawli'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								$isian>
					</TD>
				</TR>
				<TR><TD></TD>
					<TD><SPAN style='color: #FF0000;'>* Alamat dan Telpon diisi jika berbeda dengan data siswa / kosongkan jika sama</SPAN></TD>
				</TR>
				<TR><TD>Alamat</TD>
					<TD>:
						<TEXTAREA 	NAME		='almwli'
									ROWS		='5'
									cols      	='50'
									VALUE 		='$almwli'
									ID			='almwli'
									onchange	='uppercase(this.id)'
									$isian>$almwli</TEXTAREA>
					</TD>
				</TR>				
				<TR><TD>Telpon</TD>
					<TD>:
						<INPUT 	NAME		='tlpwli'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$tlpwli'
								ID			='tlpwli'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								$isian>
					</TD>
				</TR>
				<TR><TD>No Hp Aktif</TD>
					<TD>:
						<INPUT 	NAME		='hpawli'
								TYPE		='text'
								SIZE		='15'
								MAXLENGTH	='15'
								VALUE 		='$hpawli'
								ID			='hpawli'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								$isian>
						<SPAN style='color: #FF0000;'>* Akan digunakan untuk informasi via sms</SPAN>				
					</TD>
				</TR>
				<TR><TD>Agama</TD>
					<TD>:
						<SELECT NAME		='agmwli'
								VALUE 		='$agmwli'
								ID			='agmwli'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								$isian>
						<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
						$query="	SELECT 		t_mstagm.*
									FROM 		t_mstagm
									ORDER BY 	t_mstagm.kdeagm";
						$result=mysql_query($query);
						while($data=mysql_fetch_array($result))
						{
							if ($agmwli==$data[kdeagm])
								echo"<OPTION VALUE='$data[kdeagm]' SELECTED>$data[nmaagm]</OPTION>";
							else
								echo"<OPTION VALUE='$data[kdeagm]'>$data[nmaagm]</OPTION>";
						}
						echo"
						</SELECT>
					</TD>
				</TR>		
				<TR><TD>Pekerjaan</TD>
					<TD>:
						<INPUT 	NAME		='pkjwli'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$pkjwli'
								ID			='pkjwli'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								$isian>
					</TD>
				</TR>
			</TABLE>";

			// pilihan tombol pilihan
			// tombol edit
			if (hakakses('T1D01E')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button'	VALUE='Edit' 	onClick=window.location.href='tatausaha.php?mode=T1D01_Wali&nis=$nis&pilihan=edit'>";
			}	
						
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='T1D01_Save_Wali'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='nis'		VALUE=$nis>";
			}
			echo"
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='tatausaha.php?mode=T1D01_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
			$kdeusr - $tglrbh - $jamrbh
		</FORM>"; 
 	}	

	// -------------------------------------------------- Detil Saudara --------------------------------------------------
	function T1D01_Saudara()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	

		echo"
		<SCRIPT TYPE='text/javascript' src='../js/jquery-1.2.3.pack.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' src='../js/jquery.validate.pack.js'></SCRIPT>
		<script TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></script>";
		
		// inisiasi parameter berdasarkan pilihan tombol
		$pilihan=$_GET['pilihan'];

		switch($pilihan)
		{
			case 'detil':
				$isian	='disabled';
				break;
			case 'edit':
				$isian	='enable';
				break;
		}		
		
		$nisB=$_GET['nis'];
		$query 	="	SELECT 	t_mstssw.* 
					FROM 	t_mstssw
					WHERE 	t_mstssw.nis='". mysql_escape_string($nisB)."'";
		$result =mysql_query($query);
		$data 	=mysql_fetch_array($result);
	
		$nis	=$data[nis];
		$nmassw	=$data[nmassw];
		$kdeusr	=$data[kdeusr];
		$tglrbh	=$data[tglrbh];
		$jamrbh	=$data[jamrbh];		

		$query 	="	SELECT 		t_sdrssw.* 
					FROM 		t_sdrssw
					WHERE 		t_sdrssw.nis='". mysql_escape_string($nisB)."'
					ORDER BY 	t_sdrssw.tgllhr DESC";
		$result =mysql_query($query);

		$i=0;
		while($data = mysql_fetch_array($result))
		{
			$cell[$i][0] 	=$data[nmasdr];
			$cell[$i][1] 	=$data[tmplhr];
			$cell[$i][2] 	=$data[tgllhr];
			$cell[$i][3] 	=$data[pndsdr];
			$cell[$i][4] 	=$data[sklsdr];
			$i++;
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='tatausaha.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>SAUDARA KANDUNG</B></TD>
					<TD COLSPAN='2' ALIGN='right'>";
						if ($pilihan=='detil')
						{
							echo"
							| <a href='tatausaha.php?mode=T1D01&nis=$nis&pilihan=$pilihan'>Siswa</a> 
							| <a href='tatausaha.php?mode=T1D01_Ayah&nis=$nis&pilihan=$pilihan'>Ayah</a> 
							| <a href='tatausaha.php?mode=T1D01_Ibu&nis=$nis&pilihan=$pilihan'>Ibu</a> 
							| <a href='tatausaha.php?mode=T1D01_Wali&nis=$nis&pilihan=$pilihan'>Wali</a> |";					
						}	
					echo"
					</TD>
				</TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>NIS</TD>
					<TD WIDTH='85%'>:
						<INPUT 	NAME		='nis'
								TYPE		='text' 	
								SIZE		='10'
								MAXLENGTH	='10'
								VALUE 		='$nis'
								DISABLED>
					</TD>
				</TR>				
				<TR><TD>Nama Lengkap</TD>
					<TD>:
						<INPUT 	NAME		='nmassw'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$nmassw'
								DISABLED>
					</TD>
				</TR>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No		</CENTER></TD>
						<TD WIDTH='31%'><CENTER>Nama Saudara		</CENTER></TD>
						<TD WIDTH='16%'><CENTER>Tempat Lahir		</CENTER></TD>
						<TD WIDTH='15%'><CENTER>Tanggal Lahir   	</CENTER></TD>
						<TD WIDTH='16%'><CENTER>Pendidikan Terakhir </CENTER></TD>
						<TD WIDTH='18%'><CENTER>Sekolah/Instansi   	</CENTER></TD>
					</TR>";
					$j=0;
					$no=1;
					while($j<10)
					{
						$nmasdr	='nmasdr'.$j;
						$nmasdrv=$cell[$j][0];
						$tmplhr	='tmplhr'.$j;
						$tmplhrv=$cell[$j][1];
						$tgllhr	='tgllhr'.$j;
						$tgllhrv=$cell[$j][2];
						$pndsdr ='pndsdr'.$j;
						$pndsdrv=$cell[$j][3];
						$sklsdr ='sklsdr'.$j;
						$sklsdrv=$cell[$j][4];
						echo"
						<TR>
							<TD HEIGHT='25' WIDTH='4%'><CENTER>$no	</CENTER></TD>
							<TD><CENTER><INPUT 	
										NAME		='$nmasdr'
										TYPE		='text'
										SIZE		='31%'
										MAXLENGTH	='50'
										VALUE 		='$nmasdrv'
										ID			='$nmasdr'
										ONKEYUP		='uppercase(this.id)'
										ONKEYPRESS	='return enter(this,event)'
										$isian></CENTER>
							</TD>
							<TD><CENTER><INPUT 	
										NAME		='$tmplhr'
										TYPE		='text'
										SIZE		='16%'
										MAXLENGTH	='25'
										VALUE 		='$tmplhrv'
										ID			='$tmplhr'
										ONKEYUP		='uppercase(this.id)'
										ONKEYPRESS	='return enter(this,event)'
										$isian></CENTER>
							</TD>
							<TD><CENTER><INPUT 	
										NAME		='$tgllhr'
										TYPE		='text'
										SIZE		='15%'
										MAXLENGTH	='10'
										VALUE 		='$tgllhrv'
										ID 			='$tgllhr'
										ONKEYUP		='uppercase(this.id)'
										ONKEYPRESS	='return enter(this,event)'
										$isian>";
								if ($isian=='enable')		
								{ 
									echo"
									<IMG onClick='WdatePicker({el:$tgllhr});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle'>";
								}		
							echo"		
								</CENTER>							
							</TD>
							<TD><CENTER><INPUT 	
										NAME		='$pndsdr'
										TYPE		='text'
										SIZE		='16%'
										MAXLENGTH	='25'
										VALUE 		='$pndsdrv'
										ID			='$pndsdr'
										ONKEYUP		='uppercase(this.id)'
										ONKEYPRESS	='return enter(this,event)'
										$isian></CENTER>
							</TD>
							<TD><CENTER><INPUT 	
										NAME		='$sklsdr'
										TYPE		='text'
										SIZE		='18%'
										MAXLENGTH	='25'
										VALUE 		='$sklsdrv'
										ID			='$sklsdr'
										ONKEYUP		='uppercase(this.id)'
										ONKEYPRESS	='return enter(this,event)'
										$isian></CENTER>
							</TD>
						</TR>";
						$j++;
						$no++;
					}	
				echo"	
				</TABLE>";

				// pilihan tombol pilihan
				// tombol edit
				if (hakakses('T1D01E')==1 and $pilihan=='detil')
				{
					echo"
					<INPUT TYPE='button'	VALUE='Edit' 	onClick=window.location.href='tatausaha.php?mode=T1D01_Saudara&nis=$nis&pilihan=edit'>";
				}	
						
				// tombol simpan (edit)
				if($pilihan=='edit')
				{
					echo"
					<INPUT TYPE='submit' 				VALUE='Simpan'>
					<INPUT TYPE='hidden' NAME='mode' 	VALUE='T1D01_Save_Saudara'>
					<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
					<INPUT TYPE='hidden' NAME='nis'		VALUE=$nis>";
				}
				echo"
				<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='tatausaha.php?mode=T1D01_Cari'>
				<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
				$kdeusr - $tglrbh - $jamrbh
		</FORM>"; 
 	}	
	
	// -------------------------------------------------- Hapus --------------------------------------------------
	function T1D01_Hapus()
	{
		$pilihan=$_POST['pilihan'];
		if ($pilihan=='hapus')
		{
			$nis	=$_POST['nis'];
		}
		else
		{
			$nis	=$_GET['nis'];
		}	
		
		$query	="	DELETE 
					FROM 	t_mstssw
					WHERE 	t_mstssw.nis='". mysql_escape_string($nis)."'";
		$result	=mysql_query($query) or die ("Query failed - Mysql");
		
		echo"<meta http-equiv='refresh' content=\"0;url=tatausaha.php?mode=T1D01_Cari\">\n";
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function T1D01_Save()
	{
		require FUNGSI_UMUM_DIR.'fungsi_pass.php';
		
  		$nisB	=$_POST['nisB'];
  		$nis	=$_POST['nis'];
		$nisn	=$_POST['nisn'];
  		$nmassw	=$_POST['nmassw'];
		$nmapgl	=$_POST['nmapgl'];
  		$tmplhr	=$_POST['tmplhr'];
  		$tgllhr	=$_POST['tgllhr'];
  		$jnsklm	=$_POST['jnsklm'];
		$glndrh	=$_POST['glndrh'];
		$kdeagm	=$_POST['kdeagm'];
  		$alm	=$_POST['alm'];
  		$kta	=$_POST['kta'];
  		$kdepos	=$_POST['kdepos'];
  		$tlp	=$_POST['tlp'];
  		$hpakt	=$_POST['hpakt'];
		$sklasl	=$_POST['sklasl'];
		$bhsdgn	=$_POST['bhsdgn'];
		$dftkls	=$_POST['dftkls'];
  		$sttb	=$_POST['sttb'];
  		$nem	=$_POST['nem'];
  		$kdekls	=$_POST['kdekls'];
  		$ktr	=$_POST['ktr'];
  		$pht	=$_FILES['pht']['tmp_name'];
		$psswrd	=$_POST['psswrd'];
        $kdeusr =$_SESSION['Admin']['username'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");
		
  		$pilihan=$_POST['pilihan'];
		
		
		
		$d_unit		= $_POST['d_unit'];
		$sttb_thn	= $_POST['sttb_thn'];
		$sklasl_almt= $_POST['sklasl_almt'];
		$pdatgl		= $_POST['pdatgl'];
		$d_status	= $_POST['d_status'];
		
		
		
		if($pilihan=='tambah')
		{
			$psswrd 	=hex('123',82);
		}

  		$set	="	SET		t_mstssw.nis	='". mysql_escape_string($nis)."',
							t_mstssw.nisn	='". mysql_escape_string($nisn)."',
                            t_mstssw.nmassw	='". mysql_escape_string($nmassw)."',
							t_mstssw.nmapgl	='". mysql_escape_string($nmapgl)."',
                            t_mstssw.tmplhr	='". mysql_escape_string($tmplhr)."',
                            t_mstssw.tgllhr	='". mysql_escape_string($tgllhr)."',
							t_mstssw.glndrh	='". mysql_escape_string($glndrh)."',
                            t_mstssw.jnsklm	='". mysql_escape_string($jnsklm)."',
							t_mstssw.kdeagm	='". mysql_escape_string($kdeagm)."',
                            t_mstssw.alm	='". mysql_escape_string($alm)."',
                            t_mstssw.kta	='". mysql_escape_string($kta)."',
                            t_mstssw.kdepos	='". mysql_escape_string($kdepos)."',
                            t_mstssw.tlp	='". mysql_escape_string($tlp)."',
                            t_mstssw.hpakt	='". mysql_escape_string($hpakt)."',
                            t_mstssw.sklasl	='". mysql_escape_string($sklasl)."',
							t_mstssw.bhsdgn	='". mysql_escape_string($bhsdgn)."',
							t_mstssw.dftkls	='". mysql_escape_string($dftkls)."',
                            t_mstssw.sttb	='". mysql_escape_string($sttb)."',
                            t_mstssw.nem	='". mysql_escape_string($nem)."',
							t_mstssw.kdekls	='". mysql_escape_string($kdekls)."',
                            t_mstssw.ktr	='". mysql_escape_string($ktr)."',
							t_mstssw.psswrd	='". mysql_escape_string($psswrd)."',
							t_mstssw.kdeusr	='". mysql_escape_string($kdeusr)."',
							t_mstssw.tglrbh	='". mysql_escape_string($tglrbh)."',
							t_mstssw.jamrbh	='". mysql_escape_string($jamrbh)."',
							
							t_mstssw.unit		= '". mysql_escape_string($d_unit)."',
							t_mstssw.sttb_thn	= '". mysql_escape_string($sttb_thn)."',
							t_mstssw.sklasl_almt= '". mysql_escape_string($sklasl_almt)."',
							t_mstssw.pdatgl		= '". mysql_escape_string($pdatgl)."',
							t_mstssw.status		= '". mysql_escape_string($d_status)."'
							
							";
							
							
							
  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	t_mstssw ".$set.
					 "	WHERE 	t_mstssw.nis	='". mysql_escape_string($nisB)."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
        }
  		else
  		{
  			$query 	="	INSERT INTO t_mstssw ".$set; 
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
  		}
  		if($pht=='')
		{
			$newfile='';
		}
		else
		{
			$newfile= "../files/photo/siswa/$nis.jpg";
			if (file_exists($newfile))
				unlink($newfile);
			copy($pht, "../files/photo/siswa/$nis.jpg");
		}
		
		echo"<meta http-equiv='refresh' content=\"0;url=tatausaha.php?mode=T1D01&nis=$nis\">\n";
 	}

	// -------------------------------------------------- Save --------------------------------------------------
	function T1D01_Reset()
	{
		require FUNGSI_UMUM_DIR.'fungsi_pass.php';
		
  		$nis	=$_GET['nis'];
		$i		=$_GET['i'];
		$psswrd =hex('123',82);

		if($i=='1')
		{
			$set	="	SET		t_mstssw.psswrd	='". mysql_escape_string($psswrd)."'";
			$pesan	="Password siswa sudah di reset menjadi 123";
		}	
		else	
		{
			$set	="	SET		t_mstssw.psswrdot	='". mysql_escape_string($psswrd)."'";
			$pesan	="Password orang tua sudah di reset menjadi 123";
		}	
			
    	$query 	="	UPDATE 	t_mstssw ".$set.
				 "	WHERE 	t_mstssw.nis	='". mysql_escape_string($nis)	."'";
		$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
		
		echo"
		<SCRIPT LANGUAGE='JavaScript'>
			window.alert ('$pesan');
		</SCRIPT>";
		
		echo"<meta http-equiv='refresh' content=\"0;url=tatausaha.php?mode=T1D01&nis=$nis\">\n";
 	}
	
	// -------------------------------------------------- Save Ayah --------------------------------------------------
	function T1D01_Save_Ayah()
	{
  		$nis	=$_POST['nis'];
  		$nmaayh	=$_POST['nmaayh'];
		$almayh	=$_POST['almayh'];
  		$tlpayh	=$_POST['tlpayh'];
  		$hpaayh	=$_POST['hpaayh'];
		$agmayh	=$_POST['agmayh'];
		$pkjayh	=$_POST['pkjayh'];
        $kdeusr =$_SESSION['Admin']['username'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");

  		$set	="	SET		t_mstssw.nmaayh	='". mysql_escape_string($nmaayh)."',
							t_mstssw.almayh	='". mysql_escape_string($almayh)."',
                            t_mstssw.tlpayh	='". mysql_escape_string($tlpayh)."',
                            t_mstssw.hpaayh	='". mysql_escape_string($hpaayh)."',
							t_mstssw.agmayh	='". mysql_escape_string($agmayh)."',
							t_mstssw.pkjayh	='". mysql_escape_string($pkjayh)."',
							t_mstssw.kdeusr	='". mysql_escape_string($kdeusr)."',
							t_mstssw.tglrbh	='". mysql_escape_string($tglrbh)."',
							t_mstssw.jamrbh	='". mysql_escape_string($jamrbh)."'";

   		$query 	="	UPDATE 	t_mstssw ".$set.
				 "	WHERE 	t_mstssw.nis	='". mysql_escape_string($nis)	."'";
		$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));

		echo"<meta http-equiv='refresh' content=\"0;url=tatausaha.php?mode=T1D01_Ayah&nis=$nis&pilihan=detil\">\n";
 	}	

	// -------------------------------------------------- Save Ibu --------------------------------------------------
	function T1D01_Save_Ibu()
	{
  		$nis	=$_POST['nis'];
  		$nmaibu	=$_POST['nmaibu'];
		$almibu	=$_POST['almibu'];
  		$tlpibu	=$_POST['tlpibu'];
  		$hpaibu	=$_POST['hpaibu'];
		$agmibu	=$_POST['agmibu'];
		$pkjibu	=$_POST['pkjibu'];
        $kdeusr =$_SESSION['Admin']['username'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");

  		$set	="	SET		t_mstssw.nmaibu	='". mysql_escape_string($nmaibu)."',
							t_mstssw.almibu	='". mysql_escape_string($almibu)."',
                            t_mstssw.tlpibu	='". mysql_escape_string($tlpibu)."',
                            t_mstssw.hpaibu	='". mysql_escape_string($hpaibu)."',
							t_mstssw.agmibu	='". mysql_escape_string($agmibu)."',
							t_mstssw.pkjibu	='". mysql_escape_string($pkjibu)."',
							t_mstssw.kdeusr	='". mysql_escape_string($kdeusr)."',
							t_mstssw.tglrbh	='". mysql_escape_string($tglrbh)."',
							t_mstssw.jamrbh	='". mysql_escape_string($jamrbh)."'";

   		$query 	="	UPDATE 	t_mstssw ".$set.
				 "	WHERE 	t_mstssw.nis	='". mysql_escape_string($nis)	."'";
		$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
		
		echo"<meta http-equiv='refresh' content=\"0;url=tatausaha.php?mode=T1D01_Ibu&nis=$nis&pilihan=detil\">\n";
 	}	

	// -------------------------------------------------- Save Wali --------------------------------------------------
	function T1D01_Save_Wali()
	{
  		$nis	=$_POST['nis'];
  		$nmawli	=$_POST['nmawli'];
		$almwli	=$_POST['almwli'];
  		$tlpwli	=$_POST['tlpwli'];
  		$hpawli	=$_POST['hpawli'];
		$agmwli	=$_POST['agmwli'];
		$pkjwli	=$_POST['pkjwli'];
        $kdeusr =$_SESSION['Admin']['username'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");

  		$set	="	SET		t_mstssw.nmawli	='". mysql_escape_string($nmawli)."',
							t_mstssw.almwli	='". mysql_escape_string($almwli)."',
                            t_mstssw.tlpwli	='". mysql_escape_string($tlpwli)."',
                            t_mstssw.hpawli	='". mysql_escape_string($hpawli)."',
							t_mstssw.agmwli	='". mysql_escape_string($agmwli)."',
							t_mstssw.pkjwli	='". mysql_escape_string($pkjwli)."',
							t_mstssw.kdeusr	='". mysql_escape_string($kdeusr)."',
							t_mstssw.tglrbh	='". mysql_escape_string($tglrbh)."',
							t_mstssw.jamrbh	='". mysql_escape_string($jamrbh)."'";

   		$query 	="	UPDATE 	t_mstssw ".$set.
				 "	WHERE 	t_mstssw.nis	='". mysql_escape_string($nis)	."'";
		$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
		
		echo"<meta http-equiv='refresh' content=\"0;url=tatausaha.php?mode=T1D01_Wali&nis=$nis&pilihan=detil\">\n";
 	}		

	// -------------------------------------------------- Save Saudara --------------------------------------------------
	function T1D01_Save_Saudara()
	{
  		$nis	=$_POST['nis'];
        $kdeusr =$_SESSION['Admin']['username'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");
  		$set	="	SET		t_mstssw.kdeusr	='". mysql_escape_string($kdeusr)."',
							t_mstssw.tglrbh	='". mysql_escape_string($tglrbh)."',
							t_mstssw.jamrbh	='". mysql_escape_string($jamrbh)."'";

   		$query 	="	UPDATE 	t_mstssw ".$set.
				 "	WHERE 	t_mstssw.nis	='". mysql_escape_string($nis)	."'";
		$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));		

		$query	="	DELETE 
					FROM 	t_sdrssw
					WHERE 	t_sdrssw.nis='". mysql_escape_string($nis)."'";
		$result	=mysql_query($query) or die ("Query failed - Mysql");
		
		$j=0;
		while($j<10)
		{
			$nmasdr ='nmasdr'.$j;
			$nmasdr	=$_POST["$nmasdr"]; 
			$tmplhr ='tmplhr'.$j;
			$tmplhr	=$_POST["$tmplhr"];
			$tgllhr ='tgllhr'.$j;
			$tgllhr	=$_POST["$tgllhr"];
			$pndsdr ='pndsdr'.$j;
			$pndsdr	=$_POST["$pndsdr"];
			$sklsdr ='sklsdr'.$j;
			$sklsdr	=$_POST["$sklsdr"]; 

			if($nmasdr<>'')
			{
				$set	="	SET		t_sdrssw.nis	='". mysql_escape_string($nis)."',
									t_sdrssw.nmasdr	='". mysql_escape_string($nmasdr)."',
									t_sdrssw.tmplhr	='". mysql_escape_string($tmplhr)."',
									t_sdrssw.tgllhr	='". mysql_escape_string($tgllhr)."',
									t_sdrssw.pndsdr	='". mysql_escape_string($pndsdr)."',
									t_sdrssw.sklsdr	='". mysql_escape_string($sklsdr)."'";

				$query 	="	INSERT INTO t_sdrssw ".$set; 
				$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
			}	
			$j++;
		}
		
		echo"<meta http-equiv='refresh' content=\"0;url=tatausaha.php?mode=T1D01_Saudara&nis=$nis&pilihan=detil\">\n";
 	}		
	
    // -------------------------------------------------- Cetak Daftar --------------------------------------------------
 	function T1D01_CetakL()
 	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$urt='1';
	 	echo"
		<FORM ACTION='pendataan/T1D01_C02.php' target=_blank METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
  			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
        		<TR><TD COLSPAN='2'><B>CETAK DAFTAR SISWA</B></TD></TR>
           		<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Kelas</TD>
					<TD WIDTH='85%'>:
						<SELECT NAME		='kdekls'
								ID			='kdekls'
								ONKEYUP		='uppercase(this.id)'>";
						$query="	SELECT 		t_mstkls.*
									FROM 		t_mstkls
									ORDER BY 	t_mstkls.kdeklm,t_mstkls.kdekls";
						$result=mysql_query($query);
						echo"<OPTION VALUE='' SELECTED>--Semua--</OPTION>";
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
				<TR><TD>Jenis Kelamin</TD>
					<TD>:
						<INPUT NAME			='jnsklm'
								TYPE		='radio'
								VALUE 		='L'
								ID			='jnsklm'";
						if($jnsklm=='L')
							echo"checked";
							echo"> 
							Laki-laki
						<INPUT 	NAME		='jnsklm'
								TYPE		='radio'
								VALUE 		='P'
								ID			='jnsklm'";
						if($jnsklm=='P')
							echo"checked";
							echo"> 
							Perempuan
						<INPUT 	NAME		='jnsklm'
								TYPE		='radio'
								VALUE 		=''
								ID			='jnsklm'";
						if($jnsklm=='')
							echo"checked";
							echo"> 
							Semuanya
					</TD>
				</TR>
				<TR><TD>Agama</TD>
					<TD>:
						<SELECT NAME		='kdeagm'
								ID			='kdeagm'
								ONKEYUP		='uppercase(this.id)'>";
						$query	="	SELECT 		t_mstagm.*
									FROM 		t_mstagm
									ORDER BY 	t_mstagm.kdeagm";
						$result	=mysql_query($query);
						echo"<OPTION VALUE='' SELECTED>--Semua--</OPTION>";
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
				<TR><TD>Judul pada daftar</TD>
					<TD>:
						<INPUT 	NAME		='jdl'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$jdl'
								ID			='jdl'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'>
						<span style='color: #FF0000;'>* <i>default</i> <b>'DAFTAR SISWA'</b></span>
					</TD>
				</TR>		
				<TR><TD>Daftar diurut berdasarkan</TD>
					<TD>:
						<INPUT 	NAME			='urt'
								TYPE		='radio'
								VALUE 		='1'
								ID			='urt'";
						if($urt=='1')
							echo"checked";
							echo"> 
							NIS
						<INPUT 	NAME		='urt'
								TYPE		='radio'
								VALUE 		='2'
								ID			='urt'";
						if($urt=='2')
							echo"checked";
							echo"> 
							Nama Siswa
					</TD>
				</TR>
    	   	</TABLE>
			<INPUT TYPE=submit 		VALUE=Cetak>
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='tatausaha.php?mode=T1D01_Cari'>
		</FORM>";
 	}
}//akhir class
?>	