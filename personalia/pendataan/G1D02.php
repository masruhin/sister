<?php
//----------------------------------------------------------------------------------------------------
//Program		: G1D02.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi KARYAWAN
//----------------------------------------------------------------------------------------------------
// MASTER KARYAWAN
// 		personalia
//			pendataan
//				karyawan
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class G1D02class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function G1D02_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdekry	=$_GET['kdekry'];
		$nmakry	=$_GET['nmakry'];
		$jnsklm	=$_GET['jnsklm'];
		$kdeagm	=$_GET['kdeagm'];
		
		$d_unit	=$_GET['d_unit'];

		$query ="	SELECT 		t_mstkry.*,t_sttkry.nmastt 
					FROM 		t_mstkry,t_sttkry 
					WHERE 		(t_mstkry.kdekry LIKE'%".$kdekry."%' OR '$kdekry'='')	AND
								(t_mstkry.nmakry LIKE'%".$nmakry."%' OR '$nmakry'='')	AND		
								(t_mstkry.jnsklm 	LIKE'%".$jnsklm."%' OR '$jnsklm'='')	AND
								(t_mstkry.kdeagm 	LIKE'%".$kdeagm."%' OR '$kdeagm'='')	AND
								(t_mstkry.unit 	LIKE'%".$d_unit."%' OR '$d_unit'='')	AND
								substr(t_mstkry.kdekry,1,1)!='@'	AND
								t_mstkry.kdestt=t_sttkry.kdestt
					ORDER BY 	t_mstkry.kdestt,t_mstkry.kdekry";
		$result= mysql_query($query)	or die (mysql_error());

		echo"
		<FORM ACTION=personalia.php METHOD='get'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>KARYAWAN</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='15%'>Kode Karyawan</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdekry'	
								ID			='kdekry'	
								TYPE		='text' 		
								SIZE		='10' 
								MAXLENGTH	='10'
								onkeyup		='uppercase(this.id)'>
					</TD>
				</TR>
				<TR><TD>Nama Karyawan</TD>
					<TD>: 
						<INPUT 	NAME		='nmakry'	
								ID			='nmakry'	
								TYPE		='text' 		
								SIZE		='50' 
								MAXLENGTH	='50'
								onkeyup		='uppercase(this.id)'>
					</TD>
				</TR>
				<TR><TD>Unit</TD>
					<TD>: 
						<SELECT NAME		='d_unit'
								ID			='d_unit'
								ONKEYUP		='uppercase(this.id)'>";
							$query2="	SELECT 		t_msttkt.*
										FROM 		t_msttkt
										ORDER BY 	t_msttkt.urt";
							$result2=mysql_query($query2);
							echo"<OPTION VALUE='' SELECTED>--Semua--</OPTION>";
							while($data2=mysql_fetch_array($result2))
							{
								if ($d_unit==$data2[unit])
									echo"<OPTION VALUE='$data2[unit]' SELECTED>$data2[unit]</OPTION>";
								else
									echo"<OPTION VALUE='$data2[unit]'>$data2[unit]</OPTION>";
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
							$query2="	SELECT 		t_mstagm.*
										FROM 		t_mstagm
										ORDER BY 	t_mstagm.kdeagm";
							$result2=mysql_query($query2);
							echo"<OPTION VALUE='' SELECTED>--Semua--</OPTION>";
							while($data2=mysql_fetch_array($result2))
							{
								if ($kdeagm==$data2[kdeagm])
									echo"<OPTION VALUE='$data2[kdeagm]' SELECTED>$data2[nmaagm]</OPTION>";
								else
									echo"<OPTION VALUE='$data2[kdeagm]'>$data2[nmaagm]</OPTION>";
							}
						echo"
						</SELECT>
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='G1D02_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='personalia.php?mode=G1D02_Cari'>
					</TD>
				</TR>						
			</TABLE>
		</FORM>
			
		<FORM ACTION='personalia.php?mode=G1D02' METHOD='post'>
			<DIV style='overflow:auto;width:100%;height:290px;padding-right:-2px;'>		
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
						<TD WIDTH=' 8%'><CENTER>Kode 			</CENTER></TD>
						<TD WIDTH='36%'><CENTER>Nama Karyawan	</CENTER></TD>
						<TD WIDTH='14%'><CENTER>Jns.Kelamin	    </CENTER></TD>
						<TD WIDTH='22%'><CENTER>Status 			</CENTER></TD>
						<TD WIDTH='4%'><CENTER>Unit	</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Detil			</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Edit			</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Hapus			</CENTER></TD>
					</TR>";

					$no=0;
					while($data =mysql_fetch_array($result))
					{
						$no++;
						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
							<TD><CENTER>$no				</CENTER></TD>
							<TD><CENTER>$data[kdekry]	</CENTER></TD>
							<TD>$data[nmakry]</TD>";
							if($data[jnsklm]=='L')
							{
								echo"<TD><CENTER>LAKI-LAKI</CENTER></TD>";
							}
							else
							{	
								echo"<TD><CENTER>PEREMPUAN</CENTER></TD>";
							}
							echo"
							<TD><CENTER>$data[nmastt]	</CENTER></TD>
							
							<TD><CENTER>$data[unit]	</CENTER></TD>
							
							";
						
							// otorisasi akses detil
							if (hakakses("G1D02D")==1)
							{
								echo"
								<TD><CENTER><a href='personalia.php?mode=G1D02&kdekry=$data[kdekry]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
							}
						
							// otorisasi akses edit
							if (hakakses("G1D02E")==1)
							{		
								echo"
								<TD><CENTER><a href='personalia.php?mode=G1D02&kdekry=$data[kdekry]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/edit_d.gif' 	BORDER='0'></a></CENTER></TD>";
							}	
							
							// otorisasi akses hapus
							if (hakakses("G1D02H")==1)
							{		
								echo"
								<TD><CENTER><a href='personalia.php?mode=G1D02_Hapus&kdekry=$data[kdekry]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
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
			if (hakakses("G1D02T")==1)
			{
				echo"
				<INPUT TYPE='button' VALUE='Tambah KARYAWAN' onClick=window.location.href='personalia.php?mode=G1D02&pilihan=tambah'>";
				echo"
				<INPUT TYPE='button' VALUE='Cetak Daftar KARYAWAN' onClick=window.location.href='personalia.php?mode=G1D02_CetakL'>";
			}	
		echo"	
		</FORM>";
 	}

	// -------------------------------------------------- Detil --------------------------------------------------
	function G1D02()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	

		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../personalia/js/G1D02_validasi_kdekry.js'></SCRIPT>";
		
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
				$isian2	='disabled';
				break;
			case 'tambah':
				$isian	='enable';
				$isian2	='enable';
				break;
			case 'edit':
				$isian	='enable';
				$isian2	='disabled';
				break;
		}		
		
		if ($pilihan=='detil' OR $pilihan=='edit')
		{
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
			$tmplhr	=$data[tmplhr];
			$tgllhr	=$data[tgllhr];
			$jnsklm	=$data[jnsklm];
			$kdeagm	=$data[kdeagm];			
			$alm	=$data[alm];
			$kta	=$data[kta];
			$kdepos	=$data[kdepos];
			$tlp	=$data[tlp];
			$hpakt	=$data[hpakt];
			$wrgngr	=$data[wrgngr];
			$nmapsn	=$data[nmapsn];
			$ktr	=$data[ktr];
			$psswrd	=$data[psswrd];
			$pht	=$data[pht];		
			$kdeusr	=$data[kdeusr];
			$tglrbh	=$data[tglrbh];
			$jamrbh	=$data[jamrbh];
			
			$d_unit	=$data[unit];
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='personalia.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD WIDTH='15%'><B>KARYAWAN</B></TD>
					<TD WIDTH='55%'></TD>
					<TD WIDTH='30%' COLSPAN='1' ROWSPAN='15' VALIGN='top' ALIGN='right'><IMG src='../images/karyawan/$kdekry.jpg' HEIGHT='130' WIDTH='110'><BR>";
						if (hakakses('G1D02E')==1 and $pilihan=='detil')	
						{
							echo"<a href='personalia.php?mode=G1D02_Reset&kdekry=$kdekry' onClick=\"return confirm('Benar password akan direset ?');\">Reset Password</a>";
						}
					echo"
					<BR><BR>";
					$query 	="	SELECT 		t_prstkt.*,t_msttkt.*,t_mstjbt.*
								FROM 		t_prstkt,t_msttkt,t_mstjbt
								WHERE 		t_prstkt.kdekry='". mysql_escape_string($kdekryB)."'	AND
											t_prstkt.kdetkt=t_msttkt.kdetkt							AND
											t_prstkt.kdejbt=t_mstjbt.kdejbt
								ORDER BY	t_prstkt.kdetkt,t_prstkt.kdejbt"; // -- sampai sini
					$result =mysql_query($query);
					$j=0;
					while($data=mysql_fetch_array($result))
					{
						if($j==0)
							echo"<U><B>Posisi pada unit</B></U><BR>";
							
						echo"<B>$data[nmatkt]</B> - $data[nmajbt]<BR>";
						$j++;
					}
					
					echo"<BR>";
					
					$query 	="	SELECT 		t_mstpng.*,t_mstplj.*
								FROM 		t_mstpng,t_mstplj
								WHERE 		t_mstpng.kdegru='". mysql_escape_string($kdekryB)."'	AND
											t_mstpng.kdeplj=t_mstplj.kdeplj
								ORDER BY	t_mstpng.kdekls,t_mstpng.kdeplj";
					$result =mysql_query($query);
					$j=0;
					while($data=mysql_fetch_array($result))
					{
						if($j==0)
							echo"<U><B>Data Pengajaran</B></U><BR>";
							
						echo"<B>$data[kdekls]</B> - $data[nmaplj]<BR>";
						$j++;
					}
					
					echo"	
					</TD>
				</TR>
				<TR></TR><TR></TR>
				<TR><TD>Status</TD>
					<TD>: 
						<SELECT	NAME		='kdestt'	
								VALUE 		='$kdestt'
								onkeypress	='return enter(this,event)'
								$isian>";
						$query	="	SELECT 		t_sttkry.* 
									FROM 		t_sttkry  
									ORDER BY 	t_sttkry.kdestt";
    					$result	=mysql_query($query);
    					while($data=mysql_fetch_array($result))
    					{
							if ($kdestt==$data[kdestt]) 
								echo"<OPTION VALUE='$data[kdestt]' SELECTED>$data[kdestt]-$data[nmastt]</OPTION>";
  	  						else 
								echo"<OPTION VALUE='$data[kdestt]' >$data[kdestt]-$data[nmastt]</OPTION>";
    					}
						echo"
						</SELECT>		
					</TD>
				</TR>				
				<TR><TD>Kode Karyawan</TD>
					<TD>: 
						<INPUT 	NAME		='kdekry'	
								TYPE		='text' 	
								SIZE		='10' 	
								MAXLENGTH	='10'
								VALUE 		='$kdekry'
								id			='kdekry'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								$isian2>
						<SPAN 	ID			='msgbox'  
								STYLE		='display:none'>
						</SPAN>
					</TD>
				</TR>
				<TR><TD>Nama Karyawan</TD>
					<TD>: 
						<INPUT 	NAME		='nmakry'	
								TYPE		='text' 
								SIZE		='50' 	
								MAXLENGTH	='50'		
								VALUE		='$nmakry'
								id			='nmakry'
								
								onkeypress	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								$isian/>
						
						UNIT : <SELECT NAME		='d_unit'
								VALUE 		='$d_unit'
								ID			='d_unit'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								TITLE		='...diisi'
								$isian/>
								<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";//";
						$query="	SELECT 		t_msttkt.unit
									FROM 		t_msttkt
									
									ORDER BY 	t_msttkt.urt";//
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
				<TR><TD>Tempat Lahir</TD>
					<TD COLSPAN='3'>:
						<INPUT 	NAME		='tmplhr'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$tmplhr'
								ID			='tmplhr'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								
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
								
								TITLE		='...diisi'
								$isian>";
						if ($isian=='enable')//CLASS		='required'		CLASS		='required'
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
								ID			='kdeagm'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								
								TITLE		='...diisi'
								$isian><OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
								$query="	SELECT 		t_mstagm.*
											FROM 		t_mstagm
											ORDER BY 	t_mstagm.kdeagm";//CLASS		='required'
						$result=mysql_query($query);
						while($data=mysql_fetch_array($result))
						{
							if ($kdeagm==$data[kdeagm])
								echo"<OPTION VALUE='$data[kdeagm]' SELECTED>$data[nmaagm]</OPTION>";
							else
								echo"<OPTION VALUE='$data[kdeagm]'>$data[nmaagm]</OPTION>";
						}//CLASS		='required'
						echo"
						</SELECT>
					</TD>
				</TR>					
				<TR><TD>Alamat</TD>
					<TD>: 
						<TEXTAREA	NAME		='alm'
									ROWS		='5'
									cols       	='50'
									id			='alm'
									onchange	='uppercase(this.id)'
									 
									TITLE		='...harus diisi'
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
								id			='kta'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'
								 
								TITLE		='...harus diisi'
								$isian>
					</TD>
				</TR><!--CLASS		='required'-->
				<TR><TD>Kode Pos</TD>
					<TD>: 
						<INPUT 	NAME		='kdepos'	
								TYPE		='text' 
								SIZE		='5' 	
								MAXLENGTH	='5'		
								VALUE		='$kdepos'
								id			='kdepos'
								onkeyup		='javascript:checknumber(f1.kdepos);'
								onkeypress	='return enter(this,event)'
								 
								TITLE		='...harus diisi'
								$isian>
					</TD>
				</TR>
				<TR><TD></TD>
					<TD COLSPAN=2 align=left><span style='color: #FF0000;'>* contoh pengisian telpon/HP Aktif : +628xxxxxxxxx (untuk GSM) atau 021xxxxxxx (untuk CDMA)</span></TD>
				</TR>
				<TR><TD>Telpon</TD>
					<TD>: 
						<INPUT 	NAME		='tlp'	
								TYPE		='text' 
								SIZE		='50' 	
								MAXLENGTH	='50'		
								VALUE		='$tlp'
								id			='tlp'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'
								
								TITLE		='...harus diisi'
								$isian>
					</TD>
				</TR><!--CLASS		='required'-->
				<TR><TD>HP Aktif</TD>
					<TD>: 
						<INPUT 	NAME		='hpakt'	
								TYPE		='text' 
								SIZE		='15' 	
								MAXLENGTH	='15'		
								VALUE		='$hpakt'
								id		='hpakt'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'
								 
								TITLE		='...harus diisi'
								$isian>
						<SPAN style='color: #FF0000;'>* Akan digunakan untuk informasi via sms</SPAN>
					</TD>
				</TR>
				<TR><TD>Warga Negara</TD>
					<TD>:
						<INPUT 	NAME		='wrgngr'
								TYPE		='text'
								SIZE		='25'
								MAXLENGTH	='25'
								VALUE 		='$wrgngr'
								ID			='wrgngr'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								$isian>
					</TD>
				</TR>						
				<TR><TD>Nama Pasangan</TD>
					<TD>:
						<INPUT 	NAME		='nmapsn'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$nmapsn'
								ID			='nmapsn'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								$isian>
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
					<TD COLSPAN='2'>: 
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
			if (hakakses('G1D02T')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 				VALUE='Tambah' 	onClick=window.location.href='personalia.php?mode=G1D02&pilihan=tambah'>";
			}	
						
			// tombol edit
			if (hakakses('G1D02E')==1 and $pilihan=='detil')	
			{
				echo"
				<INPUT TYPE='button' 				VALUE='Edit' 	onClick=window.location.href='personalia.php?mode=G1D02&kdekry=$kdekry&pilihan=edit'>";
			}	
						
			// tombol hapus
			if (hakakses('G1D02H')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Hapus' onClick=\"return confirm('Benar data akan dihapus ?');\">
				<INPUT TYPE='hidden' NAME='mode'	VALUE='G1D02_Hapus'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='hapus'>
				<INPUT TYPE='hidden' NAME='kdekry'	VALUE='$kdekry'>";
			}	
						
			// tombol simpan (tambah)
			if($pilihan=='tambah')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='reset' 				VALUE='Ulang'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='tambah'>
				<INPUT TYPE='hidden' NAME='mode'	VALUE='G1D02_Save'>";
			}
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='kdekryB'	VALUE='$kdekryB'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='G1D02_Save'>";
			}
			if($pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 				VALUE='Cetak' 	onClick=window.open('pendataan/G1D02_C01.php?kdekry=$kdekry')>";
			}
			echo"
			<INPUT TYPE='button' 				VALUE='Cari' 	onClick=window.location.href='personalia.php?mode=G1D02_Cari'>
			<INPUT TYPE='button'				VALUE='Kembali'	onClick=history.go(-1)>						
			$kdeusr - $tglrbh - $jamrbh
		</FORM>"; 
 	}

	// -------------------------------------------------- Hapus --------------------------------------------------
	function G1D02_Hapus()
	{
		$pilihan=$_POST['pilihan'];
		if ($pilihan=='hapus')
		{
			$kdekry	=$_POST['kdekry'];
		}
		else
		{
			$kdekry	=$_GET['kdekry'];
		}	
		
		$query	="	DELETE 
					FROM 	t_mstkry 
					WHERE 	t_mstkry.kdekry='". mysql_escape_string($kdekry)."'";
		$result	=mysql_query($query) or die ("Query failed - Mysql");
		
		echo"<meta http-equiv='refresh' content=\"0;url=personalia.php?mode=G1D02_Cari\">\n"; 
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function G1D02_Save()
	{
		require FUNGSI_UMUM_DIR.'fungsi_pass.php';
	
  		$kdekryB=$_POST['kdekryB'];
		$kdestt	=$_POST['kdestt'];
  		$kdekry	=$_POST['kdekry'];
  		$nmakry	=$_POST['nmakry'];
  		$tmplhr	=$_POST['tmplhr'];
  		$tgllhr	=$_POST['tgllhr'];
  		$jnsklm	=$_POST['jnsklm'];
		$kdeagm	=$_POST['kdeagm'];
		$alm	=$_POST['alm'];
		$kta	=$_POST['kta'];
		$kdepos	=$_POST['kdepos'];
		$tlp	=$_POST['tlp'];
		$hpakt	=$_POST['hpakt'];
		$wrgngr	=$_POST['wrgngr'];
		$nmapsn	=$_POST['nmapsn'];
		$psswrd	=$_POST['psswrd'];
		$ktr	=$_POST['ktr'];
		$pht	=$_FILES['pht']['tmp_name'];
        $kdeusr =$_SESSION['Admin']['username'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");
		
		
		
		$d_unit	=$_POST['d_unit'];
		
		
		
  		$pilihan=$_POST['pilihan'];
		if($pilihan=='edit')
		{
			$kdekry=$kdekryB;
			$psswrd 	=hex('123',82);
		}

		if($pilihan=='tambah')
		{
			$psswrd 	=hex('123',82);
		}
		
		$set	="	SET		t_mstkry.kdestt	='". mysql_escape_string($kdestt)."',
							t_mstkry.kdekry	='". mysql_escape_string($kdekry)."',
							t_mstkry.nmakry	='". mysql_escape_string($nmakry)."',
                            t_mstkry.tmplhr	='". mysql_escape_string($tmplhr)."',
                            t_mstkry.tgllhr	='". mysql_escape_string($tgllhr)."',
                            t_mstkry.jnsklm	='". mysql_escape_string($jnsklm)."',
							t_mstkry.kdeagm	='". mysql_escape_string($kdeagm)."',
							t_mstkry.alm	='". mysql_escape_string($alm)."',
							t_mstkry.kta	='". mysql_escape_string($kta)."',
							t_mstkry.kdepos	='". mysql_escape_string($kdepos)."',
							t_mstkry.tlp	='". mysql_escape_string($tlp)."',
							t_mstkry.hpakt	='". mysql_escape_string($hpakt)."',
							t_mstkry.wrgngr	='". mysql_escape_string($wrgngr)."',
							t_mstkry.nmapsn	='". mysql_escape_string($nmapsn)."',
							t_mstkry.ktr	='". mysql_escape_string($ktr)."',
							t_mstkry.psswrd	='". mysql_escape_string($psswrd)."',
							t_mstkry.kdeusr	='". mysql_escape_string($kdeusr)."',
							t_mstkry.tglrbh	='". mysql_escape_string($tglrbh)."',
							t_mstkry.jamrbh	='". mysql_escape_string($jamrbh)."',
							
							t_mstkry.unit	='". mysql_escape_string($d_unit)."'
							
							";
		
  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	t_mstkry ".$set. 
					 "	WHERE 	t_mstkry.kdekry	='". mysql_escape_string($kdekryB)."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
        }
  		else
  		{
  			$query 	="	INSERT INTO t_mstkry ".$set;  
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
  		}
		
		if($pht=='') 
		{
			$newfile='';
		}
		else 
		{  
			$newfile= "../files/photo/karyawan/$kdekry.jpg";
			if (file_exists($newfile)) 
				unlink($newfile);
			copy($pht, "../files/photo/karyawan/$kdekry.jpg");
		}
		
		echo"<meta http-equiv='refresh' content=\"0;url=personalia.php?mode=G1D02&kdekry=$kdekry\">\n"; 
 	}

	// -------------------------------------------------- Save --------------------------------------------------
	function G1D02_Reset()
	{
		require FUNGSI_UMUM_DIR.'fungsi_pass.php';
		
  		$kdekry	=$_GET['kdekry'];
		$psswrd 	=hex('123',82);

  		$set	="	SET		t_mstkry.psswrd	='". mysql_escape_string($psswrd)."'";

    	$query 	="	UPDATE 	t_mstkry ".$set.
				 "	WHERE 	t_mstkry.kdekry	='". mysql_escape_string($kdekry)	."'";
		$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
		
		echo"
		<SCRIPT LANGUAGE='JavaScript'>
			window.alert ('Password sudah di reset menjadi 123');
		</SCRIPT>";
		
		echo"<meta http-equiv='refresh' content=\"0;url=personalia.php?mode=G1D02&kdekry=$kdekry\">\n";
 	}	

    // -------------------------------------------------- Cetak Daftar --------------------------------------------------
 	function G1D02_CetakL()
 	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$urt='1';
	 	echo"
		<FORM ACTION='pendataan/G1D02_C02.php' target=_blank METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
  			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
        		<TR><TD COLSPAN='2'><B>CETAK DAFTAR KARYAWAN</B></TD></TR>
           		<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Status Karyawan</TD>
					<TD WIDTH='85%'>:
						<SELECT NAME		='kdestt'
								ID			='kdestt'
								ONKEYUP		='uppercase(this.id)'>";
							$query="	SELECT 		t_sttkry.*
										FROM 		t_sttkry
										ORDER BY 	t_sttkry.kdestt";
							$result=mysql_query($query);
							echo"
							<OPTION VALUE='' SELECTED>--Semua--</OPTION>";
							while($data=mysql_fetch_array($result))
							{
								if ($kdestt==$data[kdestt])
									echo
									"<OPTION VALUE='$data[kdestt]' SELECTED>$data[nmastt]</OPTION>";
								else
									echo"
									<OPTION VALUE='$data[kdestt]'>$data[nmastt]</OPTION>";
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
							$query="	SELECT 		t_mstagm.*
										FROM 		t_mstagm
										ORDER BY 	t_mstagm.kdeagm";
							$result=mysql_query($query);
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
						<span style='color: #FF0000;'>* <i>default</i> <b>'DAFTAR KARYAWAN'</b></span>
					</TD>
				</TR>		
				
				<TR><TD>Daftar diurut berdasarkan</TD>
					<TD>:
						<INPUT 	NAME		='urt'
								TYPE		='radio'
								VALUE 		='1'
								ID			='urt'";
						if($urt=='1')
							echo"checked";
							echo">
							Kode Karyawan
						<INPUT 	NAME		='urt'
								TYPE		='radio'
								VALUE 		='2'
								ID			='urt'";
						if($urt=='2')
							echo"checked";
							echo"> 
							Nama Karyawan
					</TD>
				</TR>
    	   	</TABLE>
			<INPUT TYPE=submit 		VALUE=Cetak>
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='personalia.php?mode=G1D02_Cari'>
		</FORM>";
 	}
}//akhir class
?>