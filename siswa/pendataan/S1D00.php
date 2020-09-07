<?php
//----------------------------------------------------------------------------------------------------
//Program		: S1D00.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi SISWA
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class S1D00class
{
	// -------------------------------------------------- Detil --------------------------------------------------
	function S1D00()
	{
		require_once '../fungsi_umum/sysconfig.php';
		
		// inisiasi parameter berdasarkan pilihan tombol
		$nisB	=$_SESSION["Admin"]["nis"];
		$query 	="	SELECT 	t_mstssw.*,t_mstagm.*
					FROM 	t_mstssw,t_mstagm
					WHERE 	t_mstssw.nis='". mysql_escape_string($nisB)."'	AND
							t_mstssw.kdeagm=t_mstagm.kdeagm";
		$result =mysql_query($query);
		$data 	=mysql_fetch_array($result);
		
		$nis	=$data[nis];
		$nisn	=$data[nisn];
		$nmassw	=$data[nmassw];
		$nmapgl	=$data[nmapgl];
		$tmplhr	=$data[tmplhr];
		$tgllhr	=$data[tgllhr];
		$jnsklm	=$data[jnsklm];
		if($jnsklm=='L')
			$jnsklm='LAKI-LAKI';
		else
			$jnsklm='PEREMPUAN';
		$glndrh	=$data[glndrh];
		$kdeagm	=$data[kdeagm];
		$nmaagm	=$data[nmaagm];
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
		
		// detil form tampilan/isian
  		echo"
		<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
			<TR><TD><B>SISWA</B></TD>
				<TD COLSPAN='5' ALIGN='right'>
					| <a href='siswa.php?mode=S1D00_Ayah'>Ayah</a> 
					| <a href='siswa.php?mode=S1D00_Ibu'>Ibu</a> 
					| <a href='siswa.php?mode=S1D00_Wali'>Wali</a> 
					| <a href='siswa.php?mode=S1D00_Saudara'>Saudara</a> |
				</TD>
			</TR>
			<TR></TR><TR></TR>
			<TR><TD WIDTH='15%'>NIS</TD>
				<TD WIDTH='65%'>: $nis &nbsp&nbsp&nbspNISN : $nisn</TD>
				<TD WIDTH='20%' COLSPAN='1' ROWSPAN='7' VALIGN='top' ALIGN='right'><IMG src='../files/photo/siswa/$nis.jpg' HEIGHT='178' WIDTH='118'><BR>
			</TR>				
				
			<TR><TD>Nama Lengkap</TD>
				<TD>: $nmassw</TD>
			</TR>
			<TR><TD>Nama Panggilan</TD>
				<TD>: $nmapgl</TD>
			</TR>		
			<TR><TD>Jenis Kelamin</TD>
				<TD>: $jnsklm</TD>
			</TR>
			<TR><TD>Tempat Lahir</TD>
				<TD>: $tmplhr &nbsp&nbsp&nbspTanggal Lahir :$tgllhr</TD>
			</TR>
			<TR><TD>Golongan Darah</TD>
				<TD>: $glndrh</TD>
			</TR>	
			<TR><TD>Agama</TD>
				<TD>: $nmaagm</TD>
			</TR>				
			<TR><TD>Alamat</TD>
				<TD>: $alm</TD>
			</TR>
			<TR><TD>Kota</TD>
				<TD>: $kta &nbsp&nbsp&nbspKode Pos : $kdepos</TD>
			</TR>
			<TR><TD>Telpon</TD>
				<TD>: $tlp</TD>
			</TR>
			<TR><TD>No Hp Siswa Aktif</TD>
				<TD>: $hpakt</TD>
			</TR>
			<TR><TD>Sekolah Asal</TD>
				<TD>: $sklasl</TD>
			</TR>
			<TR><TD>STTB</TD>
				<TD>: $sttb	&nbsp&nbsp&nbspNEM : $nem</TD>
			</TR>
			<TR><TD>Bahasa sehari-hari</TD>
				<TD>: $bhsdgn</TD>
			</TR>
			<TR><TD>Mendaftar untuk kelas</TD>
				<TD>: $dftkls</TD>
			</TR>
			<TR><TD>Kelas</TD>
				<TD>: $kdekls</TD>
			</TR>
			<TR><TD>Keterangan</TD>
				<TD>: $ktr</TD>
			</TR>
		</TABLE>";
 	}
	
	// -------------------------------------------------- Detil Ayah --------------------------------------------------
	function S1D00_Ayah()
	{
		$nisB	=$_SESSION["Admin"]["nis"];
		$query 	="	SELECT 	t_mstssw.*,t_mstagm.*
					FROM 	t_mstssw,t_mstagm
					WHERE 	t_mstssw.nis='". mysql_escape_string($nisB)."'	AND
							t_mstssw.agmayh=t_mstagm.kdeagm";
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
		$nmaagm	=$data[nmaagm];
		if($agmayh=='')
		{
			$agmayh=$kdeagm;
			$query2="	SELECT 		t_mstagm.*
						FROM 		t_mstagm
						WHERE		t_mstagm.kdeagm='". mysql_escape_string($kdeagm)."'";
			$result2=mysql_query($query2);
			$data2=mysql_fetch_array($result2);
			$nmaagm=$data2[nmaagm];
		}
		$pkjayh	=$data[pkjayh];
		$kdeusr	=$data[kdeusr];
		$tglrbh	=$data[tglrbh];
		$jamrbh	=$data[jamrbh];		
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
			<TR><TD><B>ORANG TUA (AYAH)</B></TD>
				<TD COLSPAN='2' ALIGN='right'>
					| <a href='siswa.php?mode=S1D00'>Siswa</a> 
					| <a href='siswa.php?mode=S1D00_Ibu'>Ibu</a> 
					| <a href='siswa.php?mode=S1D00_Wali'>Wali</a> 
					| <a href='siswa.php?mode=S1D00_Saudara'>Saudara</a> |
				</TD>
			</TR>
			<TR></TR><TR></TR>
			<TR><TD WIDTH='15%'>NIS</TD>
				<TD WIDTH='85%'>: $nis</TD>
			</TR>				
			<TR><TD>Nama Lengkap</TD>
				<TD>: $nmassw</TD>
			</TR>
			<TR><TD><HR></TD></TR>	
			<TR><TD>Nama Ayah</TD>
				<TD>: $nmaayh</TD>
			</TR>
			<TR><TD>Alamat</TD>
				<TD>: $almayh</TD>
			</TR>				
			<TR><TD>Telpon</TD>
				<TD>: $tlpayh</TD>
			</TR>
			<TR><TD>No Hp Aktif</TD>
				<TD>: $hpaayh</TD>
			</TR>
			<TR><TD>Agama</TD>
				<TD>: $nmaagm</TD>
			</TR>		
			<TR><TD>Pekerjaan</TD>
				<TD>: $pkjayh</TD>
			</TR>
		</TABLE>";
 	}

	// -------------------------------------------------- Detil Ibu --------------------------------------------------
	function S1D00_Ibu()
	{
		$nisB	=$_SESSION["Admin"]["nis"];
		$query 	="	SELECT 	t_mstssw.*,t_mstagm.*
					FROM 	t_mstssw,t_mstagm
					WHERE 	t_mstssw.nis='". mysql_escape_string($nisB)."'	AND
							t_mstssw.agmibu=t_mstagm.kdeagm";
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
		$nmaagm	=$data[nmaagm];
		if($agmibu=='')
		{
			$agmibu=$kdeagm;
			$query2="	SELECT 		t_mstagm.*
						FROM 		t_mstagm
						WHERE		t_mstagm.kdeagm='". mysql_escape_string($kdeagm)."'";
			$result2=mysql_query($query2);
			$data2=mysql_fetch_array($result2);
			$nmaagm=$data2[nmaagm];
		}
		$pkjibu	=$data[pkjibu];
		$kdeusr	=$data[kdeusr];
		$tglrbh	=$data[tglrbh];
		$jamrbh	=$data[jamrbh];		
		
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
			<TR><TD><B>ORANG TUA (IBU)</B></TD>
				<TD COLSPAN='2' ALIGN='right'>
						| <a href='siswa.php?mode=S1D00'>Siswa</a> 
						| <a href='siswa.php?mode=S1D00_Ayah'>Ayah</a> 
						| <a href='siswa.php?mode=S1D00_Wali'>Wali</a> 
						| <a href='siswa.php?mode=S1D00_Saudara'>Saudara</a> |
				</TD>
			</TR>
			<TR></TR><TR></TR>
			<TR><TD WIDTH='15%'>NIS</TD>
				<TD WIDTH='85%'>: $nis</TD>
			</TR>				
			<TR><TD>Nama Lengkap</TD>
				<TD>: $nmassw</TD>
			</TR>
			<TR><TD><HR></TD></TR>	
			<TR><TD>Nama Ibu</TD>
				<TD>: $nmaibu</TD>
			</TR>
			<TR><TD>Alamat</TD>
				<TD>: $almibu</TD>
			</TR>				
			<TR><TD>Telpon</TD>
				<TD>: $tlpibu</TD>
			</TR>
			<TR><TD>No Hp Aktif</TD>
				<TD>: $hpaibu</TD>
			</TR>
			<TR><TD>Agama</TD>
				<TD>: $nmaagm</TD>
			</TR>		
			<TR><TD>Pekerjaan</TD>
				<TD>: $pkjibu</TD>
			</TR>
		</TABLE>";
 	}	

	// -------------------------------------------------- Detil Wali --------------------------------------------------
	function S1D00_Wali()
	{
		$nisB	=$_SESSION["Admin"]["nis"];
		$query 	="	SELECT 	t_mstssw.*,t_mstagm.* 
					FROM 	t_mstssw,t_mstagm
					WHERE 	t_mstssw.nis='". mysql_escape_string($nisB)."'	AND
							t_mstssw.agmwli=t_mstagm.kdeagm";
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
		$nmaagm	=$data[nmaagm];
		if($agmwli=='')
		{
			$agmwli=$kdeagm;
			$query2="	SELECT 		t_mstagm.*
						FROM 		t_mstagm
						WHERE		t_mstagm.kdeagm='". mysql_escape_string($kdeagm)."'";
			$result2=mysql_query($query2);
			$data2=mysql_fetch_array($result2);
			$nmaagm=$data2[nmaagm];
		}
		$pkjwli	=$data[pkjwli];
		$kdeusr	=$data[kdeusr];
		$tglrbh	=$data[tglrbh];
		$jamrbh	=$data[jamrbh];		
		
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
			<TR><TD><B>WALI SISWA</B></TD>
				<TD COLSPAN='2' ALIGN='right'>
					| <a href='siswa.php?mode=S1D00'>Siswa</a> 
					| <a href='siswa.php?mode=S1D00_Ayah'>Ayah</a> 
					| <a href='siswa.php?mode=S1D00_Ibu'>Ibu</a> 
					| <a href='siswa.php?mode=S1D00_Saudara'>Saudara</a> |
				</TD>
			</TR>
			<TR></TR><TR></TR>
			<TR><TD WIDTH='15%'>NIS</TD>
				<TD WIDTH='85%'>: $nis </TD>
			</TR>				
			<TR><TD>Nama Lengkap</TD>
				<TD>: $nmassw</TD>
			</TR>
			<TR><TD><HR></TD></TR>	
			<TR><TD>Nama Wali</TD>
				<TD>: $nmawli</TD>
			</TR>
			<TR><TD>Alamat</TD>
				<TD>: $almwli</TD>
			</TR>				
			<TR><TD>Telpon</TD>
				<TD>: $tlpwli</TD>
			</TR>
			<TR><TD>No Hp Aktif</TD>
				<TD>: $hpawli</TD>
			</TR>
			<TR><TD>Agama</TD>
				<TD>: $nmaagm</TD>
			</TR>		
			<TR><TD>Pekerjaan</TD>
				<TD>: $pkjwli</TD>
			</TR>
		</TABLE>";
 	}	

	// -------------------------------------------------- Detil Saudara --------------------------------------------------
	function S1D00_Saudara()
	{
		$nisB	=$_SESSION["Admin"]["nis"];
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
		<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
			<TR><TD><B>SAUDARA KANDUNG</B></TD>
				<TD COLSPAN='2' ALIGN='right'>
					| <a href='siswa.php?mode=S1D00'>Siswa</a> 
					| <a href='siswa.php?mode=S1D00_Ayah'>Ayah</a> 
					| <a href='siswa.php?mode=S1D00_Ibu'>Ibu</a> 
					| <a href='siswa.php?mode=S1D00_Wali'>Wali</a> |
				</TD>
			</TR>
			<TR></TR><TR></TR>
			<TR><TD WIDTH='15%'>NIS</TD>
				<TD WIDTH='85%'>: $nis</TD>
			</TR>				
			<TR><TD>Nama Lengkap</TD>
				<TD>: $nmassw</TD>
			</TR>
		</TABLE>	
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
					<TD><CENTER>$nmasdrv</CENTER></TD>
					<TD><CENTER>$tmplhrv</CENTER></TD>
					<TD><CENTER>$tgllhrv</CENTER></TD>
					<TD><CENTER>$pndsdrv</CENTER></TD>
					<TD><CENTER>$sklsdrv</CENTER></TD>
				</TR>";
				$j++;
				$no++;
			}	
		echo"	
		</TABLE>";
 	}	
}//akhir class
?>