<?php
//----------------------------------------------------------------------------------------------------
//Program		: K1D04.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 23/04/2012
//Keterangan	: Fungsi-fungsi BUKTI KELUAR UANG
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class K1D04class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function K1D04_Cari()
	{
		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
	
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";		
		
		echo"
		<SCRIPT TYPE='text/javascript'>
			function tgl()
			{
				document.f1.prd.value = document.f1.bln.value +-+ document.f1.tahun.value;
			}
		</SCRIPT>";
		
		$prd 	=periode("KEUANGAN");
		$nmrbku	=$_GET['nmrbku'];
		$tglbku	=$_GET['tglbku'];
		$kdejku	=$_GET['kdejku'];
			
		$query	="	SELECT 		t_bkukng.*,t_jku.nmajku  
					FROM 		t_bkukng,t_jku  
					WHERE 		(t_bkukng.nmrbku LIKE'%".$nmrbku."%' OR '$nmrbku'='')	AND
								(t_bkukng.tglbku LIKE'%".$tglbku."%' OR '$tglbku'='') 	AND
								(t_bkukng.kdejku LIKE'%".$kdejku."%' OR '$kdejku'='')	AND
								t_bkukng.kdejku=t_jku.kdejku
					ORDER BY 	t_bkukng.nmrbku";
		$result	=mysql_query($query) or die (mysql_error());

		echo"
		<FORM ACTION=keuangan.php METHOD='get' NAME='f1'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>BUKTI KELUAR UANG</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Periode</TD>
                    <TD WIDTH='85%'>:  
						<SELECT NAME='bln' id='bln' onchange='tgl()'>
                            <OPTION VALUE=''>Pilih
							<OPTION VALUE='01'>Januari
							<OPTION VALUE='02'>Februari
							<OPTION VALUE='03'>Maret
							<OPTION VALUE='04'>April
							<OPTION VALUE='05'>Mei
							<OPTION VALUE='06'>Juni
							<OPTION VALUE='07'>Juli
							<OPTION VALUE='08'>Agustus
							<OPTION VALUE='09'>September
							<OPTION VALUE='10'>Oktober
							<OPTION VALUE='11'>November
							<OPTION VALUE='12'>Desember
							</OPTION>
                        </SELECT>
						 
						<SELECT NAME='tahun' id='tahun' onchange='tgl()'>
							<OPTION VALUE=''>Pilih
                            <OPTION VALUE='2011'>2011
                            <OPTION VALUE='2012'>2012
                            <OPTION VALUE='2013'>2013
                            <OPTION VALUE='2014'>2014
                            <OPTION VALUE='2015'>2015
                            <OPTION VALUE='2016'>2016
                            <OPTION VALUE='2017'>2017
                            <OPTION VALUE='2018'>2018
                            <OPTION VALUE='2019'>2019
                            <OPTION VALUE='2020'>2020
                            <OPTION VALUE='2021'>2021
                            <OPTION VALUE='2022'>2022
						</SELECT>
						<INPUT TYPE='hidden' name='tglbku' id='prd'>
					</TD>
				</TR>
				<TR><TD>Nomor Bukti Keluar Uang</TD>
  					<TD>: 
						<INPUT 	NAME		='nmrbku'
								TYPE		='text' 
								SIZE		='15' 
								MAXLENGTH	='15'
								id			='nmrbku'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'>
					</TD>
  				</TR>
				<TR><TD>Jenis Pengeluaran</TD>
					<TD>: 
						<INPUT 	NAME		='kdejku'
								TYPE		='text' 		
								SIZE		='10' 
								MAXLENGTH	='10'
								id			='kdejku'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'>
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='K1D04_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='keuangan.php?mode=K1D04_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM ACTION='keuangan.php?mode=K1D04' METHOD='post' >
			<DIV style='overflow:auto;width:100%;height:320px;padding-right:-2px;'>		
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No						</CENTER></TD>
						<TD WIDTH='20%'><CENTER>Nomor Bukti Keluar Uang	</CENTER></TD>
						<TD WIDTH='12%'><CENTER>Tanggal					</CENTER></TD>
						<TD WIDTH='26%'><CENTER>Untuk					</CENTER></TD>
						<TD WIDTH='20%'><CENTER>Jenis Pengeluaran		</CENTER></TD>
						<TD WIDTH=' 6%'><CENTER>Status					</CENTER></TD>					
						<TD WIDTH=' 4%'><CENTER>Detil					</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Edit					</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Hapus					</CENTER></TD>
					</TR>";

					$no=0;
					while($data =mysql_fetch_array($result))
					{
						$tglbku	=substr($data[tglbku],-2).substr($data[tglbku],3,2);
						$no++;
						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
							<TD><CENTER>$no				</CENTER></TD>
							<TD><CENTER>$data[nmrbku]	</CENTER></TD>
							<TD><CENTER>$data[tglbku]	</CENTER></TD>
							<TD>$data[utk]</TD>
							<TD>$data[kdejku] ($data[nmajku])</TD>";
							if ($data[str]=='P')
							{
								echo"<TD><SPAN STYLE='color: #FF0000;'><CENTER>$data[str]</CENTER></SPAN></TD>";
							}
							else
							{
								echo"<TD><CENTER>$data[str]</CENTER></TD>";
							}
							// otorisasi akses detil
							if (hakakses("K1D04D")==1)
							{
								echo"
								<TD><CENTER><a href='keuangan.php?mode=K1D04&nmrbku=$data[nmrbku]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
							}
						
							// otorisasi akses edit
							if (hakakses("K1D04E")==1 AND $data[str]=='' AND $prd==$tglbku)
							{		
								echo"
								<TD><CENTER><a href='keuangan.php?mode=K1D04&nmrbku=$data[nmrbku]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/edit_d.gif' 	BORDER='0'></a></CENTER></TD>";
							}	
							
							// otorisasi akses hapus
							if (hakakses("K1D04H")==1 AND $data[str]=='' AND $prd==$tglbku)
							{		
								echo"
								<TD><CENTER><a href='keuangan.php?mode=K1D04_Hapus&nmrbku=$data[nmrbku]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
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
			if (hakakses("K1D04T")==1)
			{
				echo"
				<INPUT TYPE='button' VALUE='Tambah BUKTI KELUAR UANG' onClick=window.location.href='keuangan.php?mode=K1D04&pilihan=tambah'>";
			}	
		echo"	
		</FORM>";
 	}

	// -------------------------------------------------- Detil --------------------------------------------------
	function K1D04()
	{
		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';

		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";
		echo"<SCRIPT TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></SCRIPT>";

		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../keuangan/js/K1D04_validasi_tglbkuk.js'></SCRIPT>";
		
		echo"
		<SCRIPT TYPE='text/javascript' src='../keuangan/js/K1D04_prd_bkuk.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript'>
			<!-- menyembunyikan kode dari browser non-js
			function periksa()
			{
				formObj = document.f1;
				var prd=document.getElementById('prd').value;
				if ((formObj.tglbku1.value != prd))
				{
					alert('Periode Tidak Sama');
					return false;
				}
				else
					return true;
			}
			// akhir dari penyembunyian -->
		</SCRIPT>";

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
		$prd 	=periode("KEUANGAN");
				
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
				$nmrbku =nomor_bkuk($prd);
				//$tglbku =date("d-m-Y");
				break;
			case 'edit':
				$isian	='enable';
				break;
		}		
		
		if ($pilihan=='detil' OR $pilihan=='edit')
		{
			$nmrbkuB=$_GET['nmrbku'];
			$query 	="	SELECT 	t_bkukng.*,t_jku.nmajku
						FROM 	t_bkukng,t_jku 
						WHERE 	t_bkukng.nmrbku='". mysql_escape_string($nmrbkuB)."'	AND
								t_bkukng.kdejku=t_jku.kdejku";
			$result =mysql_query($query);
			$data 	=mysql_fetch_array($result);
		
			$str	=$data[str];
			$nmrbku	=$data[nmrbku];
			$tglbku	=$data[tglbku];
			$kdejku	=$data[kdejku];			
			$utk	=$data[utk];
			if ($pilihan=='edit')
			{
				$nli	=$data[nli];
			}
			else
			{
				$nli	=number_format($data[nli]);
			}	
			$nlilma	=$data[nli];
			$ktr	=$data[ktr];
			$prdB	=tgltoprd($tglbku);	
			$kdeusr	=$data[kdeusr];
			$tglrbh	=$data[tglrbh];
			$jamrbh	=$data[jamrbh];
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='keuangan.php' onsubmit='return periksa()' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>BUKTI KELUAR UANG</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Nomor Bukti Keluar Uang</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='nmrbku'	
								TYPE		='text' 	
								SIZE		='15' 	
								MAXLENGTH	='15'
								VALUE 		='$nmrbku'
								DISABLED>
					</TD>
				</TR>
              	<TR><TD>Tanggal</TD>
              		<TD>: 
						<INPUT 	NAME		='tglbku'  
								TYPE		='text' 
								SIZE		=10 
								MAXLENGTH	=10 
								VALUE		='$tglbku' 
								id			='tglbku' 
								onchange	='bku()'
								onkeypress	='return enter(this,event)'
								$isian>
						<SPAN 	ID			='msgbox'  
								STYLE		='display:none'>
						</SPAN>";

						if ($isian=='enable')		
						{ 
							echo"
							<IMG onClick='WdatePicker({el:tglbku});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle'>
							<INPUT TYPE='hidden'	NAME='tglbku1' 	VALUE='$prd'	id='tglbku1'>
							<INPUT TYPE='hidden'	NAME='prd'		VALUE='$prd'	id='prd'>";
						}	
					echo"	
					</TD>
              	</TR>
				<TR><TD>Jenis Pengeluaran</TD>
					<TD>: 
						<SELECT	NAME		='kdejku'	
								VALUE 		='$kdejku'
								onkeypress	='return enter(this,event)'
								$isian>";
						$sql2	="	SELECT 		t_jku.* 
									FROM 		t_jku  
									ORDER BY 	t_jku.kdejku";
    					$my		=mysql_query($sql2);
    					while($al=mysql_fetch_array($my))
    					{
							if ($kdejku==$al[kdejku]) 
								echo 
								"<OPTION VALUE='$al[kdejku]' SELECTED>$al[nmajku]</OPTION>";
  	  						else 
								echo 
								"<OPTION VALUE='$al[kdejku]'>$al[nmajku]</OPTION>";
    					}
       					echo
						"</SELECT>		
					</TD>
				</TR>	
				<TR><TD>Untuk</TD>
					<TD>: 
						<INPUT 	NAME		='utk'	
								TYPE		='text' 
								SIZE		='50' 	
								MAXLENGTH	='50'		
								VALUE		='$utk'
								id			='utk'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								$isian>
					</TD>
				</TR>
				<TR><TD>Jumlah (Rp.)</TD>
					<TD>: 
						<INPUT 	NAME		='nli'	
								TYPE		='text' 
								SIZE		='12' 	
								MAXLENGTH	='12'		
								VALUE		='$nli'
								id			='nli'
								ONKEYUP		='formatangka(this);'
								onkeypress	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								$isian>
					</TD>
				</TR>
				<TR><TD>Keterangan</TD>
					<TD>: <TEXTAREA	NAME		='ktr'
									COLS		='50'
									ROWS		='3'
									id			='ktr'
									onchange	='uppercase(this.id)'
									$isian>$ktr</TEXTAREA>
					</TD>
				</TR>
			</TABLE>";
						
			// pilihan tombol pilihan
			// tombol tambah
			if(hakakses('K1D04T')==1 and $pilihan=='detil')
			{	
				echo"
				<INPUT TYPE='button' 				VALUE='Tambah' 	onClick=window.location.href='keuangan.php?mode=K1D04&pilihan=tambah'>";
			}	
			
			// tombol edit
			if(hakakses('K1D04E')==1 and $pilihan=='detil' and $str=='' and $prd==$prdB)
			{
				echo"
				<INPUT TYPE='button' 				VALUE='Edit' 	onClick=window.location.href='keuangan.php?mode=K1D04&nmrbku=$nmrbku&pilihan=edit'>";
			}	
						
			// tombol hapus
			if(hakakses('K1D04H')==1 and $pilihan=='detil' and $str=='' and $prd==$prdB)
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Hapus' onClick=\"return confirm('Benar data akan dihapus ?');\">
				<INPUT TYPE='hidden' NAME='mode'	VALUE='K1D04_Hapus'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='hapus'>
				<INPUT TYPE='hidden' NAME='nmrbku'	VALUE='$nmrbku'>";
			}	
						
			// tombol simpan (tambah)
			if($pilihan=='tambah')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='reset' 				VALUE='Ulang'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='tambah'>
				<INPUT TYPE='hidden' NAME='mode'	VALUE='K1D04_Save'>";
			}

			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='nmrbku'	VALUE='$nmrbkuB'>
				<INPUT TYPE='hidden' NAME='nmrbkuB'	VALUE='$nmrbkuB'>
				<INPUT TYPE='hidden' NAME='nlilma'	VALUE='$nlilma'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='K1D04_Save'>";
			}
			if($pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 				VALUE='Cetak' 	onClick=window.open('pendataan/K1D04_C01.php?nmrbku=$nmrbku')>";
			}
			echo"
			<INPUT TYPE='button' 					VALUE='Cari' 	onClick=window.location.href='keuangan.php?mode=K1D04_Cari'>
			<INPUT TYPE='button'					VALUE='Kembali'	onClick=history.go(-1)>						
			$kdeusr - $tglrbh - $jamrbh
		</FORM>"; 
 	}

	// -------------------------------------------------- Hapus --------------------------------------------------
	function K1D04_Hapus()
	{
		$pilihan=$_POST['pilihan'];
		if ($pilihan=='hapus')
		{
			$nmrbku	=$_POST['nmrbku'];
		}
		else
		{
			$nmrbku	=$_GET['nmrbku'];
		}	
		$prd 	=periode("KEUANGAN");
		
		$query 	=mysql_query("	SELECT 	t_bkukng.* 
								FROM 	t_bkukng 
								WHERE 	t_bkukng.nmrbku='". mysql_escape_string($nmrbku)."'");
		$result =mysql_fetch_assoc($query);
		$nli	=$result['nli'];
		
		$sql	="	DELETE 
					FROM 	t_bkukng 
					WHERE 	t_bkukng.nmrbku='". mysql_escape_string($nmrbku)."'";
		$result	=mysql_query($sql) or die ("Query failed - Mysql");
				
		$query 	=mysql_query("	SELECT 	t_sldkng.* 
								FROM 	t_sldkng 
								WHERE 	t_sldkng.prd	='". mysql_escape_string($prd)."'");
		$result =mysql_fetch_assoc($query);
		$klr 	=$result['klr']-$nli;			
				
		$query 	="	UPDATE 	t_sldkng 
					SET		t_sldkng.klr	='". mysql_escape_string($klr)."'
					WHERE 	t_sldkng.prd	='". mysql_escape_string($prd)."'";					
		$result	=mysql_query ($query); 
		
		echo"<meta http-equiv='refresh' content=\"0;url=keuangan.php?mode=K1D04_Cari\">\n"; 
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function K1D04_Save()
	{
		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';

  		$nmrbkuB=$_POST['nmrbkuB'];
		$str	=$_POST['str'];
  		$nmrbku	=$_POST['nmrbku'];
  		$tglbku	=$_POST['tglbku'];
		$kdejku	=$_POST['kdejku'];
		$utk	=$_POST['utk'];		
		$nli	=str_replace(",","",$_POST['nli']);
		$nlilma	=$_POST['nlilma'];
  		$ktr	=$_POST['ktr'];
        $kdeusr =$_SESSION['Admin']['username'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");
		
  		$pilihan=$_POST['pilihan'];
		$prd 	=periode("KEUANGAN");

		if ($pilihan=='tambah')
		{
			$nmrbku = nomor_bkuk($prd);
		}	
		$set	="	SET		t_bkukng.nmrbku	='". mysql_escape_string($nmrbku)	."',
							t_bkukng.tglbku	='". mysql_escape_string($tglbku)	."',
							t_bkukng.kdejku	='". mysql_escape_string($kdejku)	."',
							t_bkukng.utk	='". mysql_escape_string($utk)		."',
							t_bkukng.nli	='". mysql_escape_string($nli)		."',
							t_bkukng.ktr	='". mysql_escape_string($ktr)		."',
							t_bkukng.kdeusr	='". mysql_escape_string($kdeusr)	."',
							t_bkukng.tglrbh	='". mysql_escape_string($tglrbh)	."',
							t_bkukng.jamrbh	='". mysql_escape_string($jamrbh)	."'";
		
  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	t_bkukng ".$set. 
					 "	WHERE 	t_bkukng.nmrbku	='". mysql_escape_string($nmrbkuB)	."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));

			$query 	=mysql_query("	SELECT 	t_sldkng.* 
									FROM 	t_sldkng 
									WHERE 	t_sldkng.prd = '$prd'");
			$result =mysql_fetch_assoc($query);
			$klr 	=$result['klr']-$nlilma;			

			$query 	="	UPDATE 	t_sldkng 
						SET		t_sldkng.klr	='". mysql_escape_string($klr+$nli)	."'
						WHERE 	t_sldkng.prd	='". mysql_escape_string($prd)		."'";							
        	$result	=mysql_query ($query) or die(error("Data tidak berhasil di Rubah"));			
        }
  		else
  		{
  			$query 	="	INSERT INTO t_bkukng ".$set; 
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));

			$query 	=mysql_query("	SELECT 	t_sldkng.* 
									FROM 	t_sldkng 
									WHERE 	t_sldkng.prd = '$prd'");
			$result =mysql_fetch_assoc($query);
			$klr 	=$result['klr'];			
			if(mysql_num_rows($query) == "")
			{
				$query 	="	INSERT INTO t_sldkng 
							SET			t_sldkng.prd	='". mysql_escape_string($prd)	."',
										t_sldkng.klr	='". mysql_escape_string($nli)	."'";
			}
			else
			{
				$query 	="	UPDATE 	t_sldkng 
							SET		t_sldkng.prd	='". mysql_escape_string($prd)		."',
									t_sldkng.klr	='". mysql_escape_string($klr+$nli)	."'
							WHERE 	t_sldkng.prd	='". mysql_escape_string($prd)		."'";
			}							
  			$result	=mysql_query ($query)or die(error("Data tidak berhasil di Input")) ;
			
			$nmrbkuB=$nmrbku;
  		}
		
		echo"<meta http-equiv='refresh' content=\"0;url=keuangan.php?mode=K1D04&nmrbku=$nmrbkuB\">\n"; 
 	}
}//akhir class
?>