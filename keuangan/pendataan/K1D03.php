<?php
//----------------------------------------------------------------------------------------------------
//Program		: K1D03.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 23/04/2012
//Keterangan	: Fungsi-fungsi BUKTI TERIMA UANG
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class K1D03class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function K1D03_Cari()
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
		$nmrbtu	=$_GET['nmrbtu'];
		$tglbtu	=$_GET['tglbtu'];
		$nmajtu	=$_GET['nmajtu'];

		$query	="	SELECT 		t_btukng.*,t_jtu.nmajtu  
					FROM 		t_btukng,t_jtu  
					WHERE 		(t_btukng.nmrbtu LIKE'%".$nmrbtu."%' 	OR '$nmrbtu'='')	AND
								(t_btukng.tglbtu LIKE'%".$tglbtu."%' 	OR '$tglbtu'='') 	AND
								(t_jtu.nmajtu LIKE'%".$nmajtu."%' 		OR '$nmajtu'='')	AND
								t_btukng.kdejtu=t_jtu.kdejtu
					ORDER BY 	t_btukng.nmrbtu";
		$result	=mysql_query($query) or die (mysql_error());

		echo"
		<FORM ACTION=keuangan.php METHOD='get' NAME='f1'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>BUKTI TERIMA UANG</B></TD></TR>
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
						<INPUT TYPE='hidden' name='tglbtu' id='prd'>
					</TD>
				</TR>
				<TR><TD>Nomor Bukti Terima Uang</TD>
  					<TD>: 
						<INPUT 	NAME		='nmrbtu'
								TYPE		='text' 
								SIZE		='15' 
								MAXLENGTH	='15'
								id			='nmrbtu'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'>
					</TD>
  				</TR>
				<TR><TD>Jenis Penerimaan</TD>
					<TD>: 
						<INPUT 	NAME		='nmajtu'
								TYPE		='text' 		
								SIZE		='50' 
								MAXLENGTH	='50'
								id			='nmajtu'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'>
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='K1D03_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='keuangan.php?mode=K1D03_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM ACTION='keuangan.php?mode=K1D03' METHOD='post' >
			<DIV style='overflow:auto;width:100%;height:320px;padding-right:-2px;'>		
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No						</CENTER></TD>
						<TD WIDTH='15%'><CENTER>Nomor Bukti Terima Uang	</CENTER></TD>
						<TD WIDTH='12%'><CENTER>Tanggal					</CENTER></TD>
						<TD WIDTH='31%'><CENTER>Dari					</CENTER></TD>
						<TD WIDTH='20%'><CENTER>Jenis Penerimaan		</CENTER></TD>
						<TD WIDTH=' 6%'><CENTER>Status					</CENTER></TD>					
						<TD WIDTH=' 4%'><CENTER>Detil					</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Edit					</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Hapus					</CENTER></TD>
					</TR>";

					$no=0;
					while($data =mysql_fetch_array($result))
					{
						$tglbtu	=substr($data[tglbtu],-2).substr($data[tglbtu],3,2);
						$no++;
						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
							<TD><CENTER>$no				</CENTER></TD>
							<TD><CENTER>$data[nmrbtu]	</CENTER></TD>
							<TD><CENTER>$data[tglbtu]	</CENTER></TD>
							<TD>$data[dr]</TD>
							<TD>$data[nmajtu]</TD>";
							if ($data[str]=='P')
							{
								echo"<TD><SPAN STYLE='color: #FF0000;'><CENTER>$data[str]</CENTER></SPAN></TD>";
							}
							else
							{
								echo"<TD><CENTER>$data[str]</CENTER></TD>";
							}
							
							// otorisasi akses detil
							if (hakakses("K1D03D")==1)
							{
								echo"
								<TD><CENTER><a href='keuangan.php?mode=K1D03&nmrbtu=$data[nmrbtu]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
							}
						
							// otorisasi akses edit
							if (hakakses("K1D03E")==1 AND $data[str]=='' AND $prd==$tglbtu AND $data[nis]=='')
							{		
								echo"
								<TD><CENTER><a href='keuangan.php?mode=K1D03&nmrbtu=$data[nmrbtu]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/edit_d.gif' 	BORDER='0'></a></CENTER></TD>";
							}	
							
							// otorisasi akses hapus
							if (hakakses("K1D03H")==1 AND $data[str]=='' AND $prd==$tglbtu AND $data[nis]=='')
							{		
								echo"
								<TD><CENTER><a href='keuangan.php?mode=K1D03_Hapus&nmrbtu=$data[nmrbtu]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
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
			if (hakakses("K1D03T")==1)
			{
				echo"
				<INPUT TYPE='button' VALUE='Tambah BUKTI TERIMA UANG' onClick=window.location.href='keuangan.php?mode=K1D03&pilihan=tambah'>";
				echo"
				<INPUT TYPE='button' VALUE='BUKTI TERIMA UANG per Kelas' onClick=window.location.href='keuangan.php?mode=K1D03_Check'>";
			}	
		echo"	
		</FORM>";
 	}

	// -------------------------------------------------- Detil --------------------------------------------------
	function K1D03()
	{
		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';

		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";
		  //untuk autosuggest
        echo"
        <SCRIPT TYPE='text/javascript' src='../js/ajax.js'></SCRIPT>
        <SCRIPT TYPE='text/javascript' src='../js/ajax-dynamic-list1.js'></SCRIPT>";
        //end autosuggest
		echo"
		<SCRIPT TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></SCRIPT>
        ";


		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../keuangan/js/K1D03_validasi_tglbtuk.js'>
        <SCRIPT TYPE='text/javascript' 	src='../keuangan/js/K1D03_validasi_kdejtu.js'></SCRIPT>";
		
		echo"
		<SCRIPT TYPE='text/javascript' src='../keuangan/js/K1D03_prd_btuk.js'>




";

		echo"

		<SCRIPT TYPE='text/javascript' src='../js/jquery-1.2.3.pack.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' src='../js/jquery.validate.pack.js'></SCRIPT>
        <SCRIPT TYPE='text/javascript'>
			$(document).ready(function()
			{
				$('#validasi').validate()
			});
		</SCRIPT>
        <SCRIPT TYPE='text/javascript'>
			<!-- menyembunyikan kode dari browser non-js
			function periksa()
			{
				formObj = document.f1;
				var prd=document.getElementById('prd').value;
				if ((formObj.tglbtu1.value != prd))
				{
					alert('Periode Tidak Sama');
					return false;
				}
				else
                if ((formObj.code.value =='A'))
				{
					alert('Siswa sudah membayar untuk jenis penerimaan tersebut');
                    window.location.href='keuangan.php?mode=K1D03&pilihan=tambah';
					return false;
				}
                else
					return true;
			}
			// akhir dari penyembunyian -->
		</SCRIPT>
        ";

		// inisiasi parameter berdasarkan pilihan tombol
		$pilihan=$_GET['pilihan'];
		$kdekls	=$_GET['kdekls'];
		$nis	=$_GET['nis'];
		$kdejtu	=$_GET['kdejtu'];
		$siswa	=$_GET['siswa'];
		$prd 	=periode("KEUANGAN");
				
		if(empty($pilihan))
		{
			$pilihan='detil';
		}
		if(empty($siswa))
		{
			$siswa='tidak';
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
				$nmrbtu =nomor_btuk($prd);
				//$tglbtu =date("d-m-Y");
				break;
			case 'edit':
				$isian	='enable';
				$isian2	='enable';
				break;
		}		
		
		if ($pilihan=='detil' OR $pilihan=='edit')
		{
			$nmrbtuB=$_GET['nmrbtu'];
			$query 	="	SELECT 	t_btukng.*,t_jtu.nmajtu,t_mstssw.nmassw
						FROM 	t_btukng,t_jtu,t_mstssw 
						WHERE 	t_btukng.nmrbtu	='". mysql_escape_string($nmrbtuB)."'	AND
								t_btukng.kdejtu	=t_jtu.kdejtu";
			$result =mysql_query($query);
			$data 	=mysql_fetch_array($result);
		
			$str	=$data[str];
			$nmrbtu	=$data[nmrbtu];
			$tglbtu	=$data[tglbtu];
			$kdejtu	=$data[kdejtu];			
			$dr		=$data[dr];
			$nis	=$data[nis];
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
			$prdB	=tgltoprd($tglbtu);	
			$kdeusr	=$data[kdeusr];
			$tglrbh	=$data[tglrbh];
			$jamrbh	=$data[jamrbh];
			
			if($nis!='')
			{
				$query2 ="	SELECT 	t_mstssw.*
							FROM 	t_mstssw 
							WHERE 	t_mstssw.nis='$nis'";
				$result2=mysql_query($query2);
				$data2 	=mysql_fetch_array($result2);
				$nmassw	=$data2[nmassw];
				$kdekls	=$data2[kdekls];
			}
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"

		<FORM ID='validasi' ACTION='keuangan.php' onsubmit='return periksa();' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>BUKTI TERIMA UANG</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Nomor Bukti Terima Uang</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='nmrbtu'	
								TYPE		='text' 	
								SIZE		='15' 	
								MAXLENGTH	='15'
								VALUE 		='$nmrbtu'
								DISABLED>
					</TD>
				</TR>
              	";
					echo"	
					</TD>
              	</TR>
				<TR><TD>Jenis Penerimaan</TD>
					<TD>:
						<SELECT	NAME		='kdejtu'
                                ID          ='kdejtu'
                                CLASS		='required'
								onkeypress	='return enter(this,event)'
								$isian2>
                                <OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
						$sql2	="	SELECT 		t_jtu.*
									FROM 		t_jtu
									ORDER BY 	t_jtu.kdejtu";
    					$my		=mysql_query($sql2);
    					while($al=mysql_fetch_array($my))
    					{    $kdj=$al[kdejtu];

							if ($kdejtu==$al[kdejtu])
								echo
								"<OPTION VALUE='$al[kdejtu]' SELECTED>$al[nmajtu]</OPTION>";
  	  						else
								echo
								"<OPTION VALUE='$al[kdejtu]' >$al[nmajtu]</OPTION>";
    					}
       					echo
						"</SELECT>
					</TD>
				</TR>
					<TR><TD>Dari</TD>
						<TD>:
							<span id='dri'></span>
							<INPUT 	NAME		='dp1'
									TYPE		='text' 
									SIZE		='50' 	
									MAXLENGTH	='50'		
									VALUE		='$dr'
									id			='dp1'
									CLASS		='required' 
									TITLE		='...harus diisi'
									disabled>
						</TD>
					</TR>
                <TR><TD>Tanggal</TD>
              		<TD>:<INPUT TYPE='hidden'	NAME='tglbtu1' 	VALUE='$prd'	id='tglbtu1'>
					      <INPUT TYPE='hidden'	NAME='prd'		VALUE='$prd'	id='prd'>
						<INPUT 	NAME		='tglbtu'
								TYPE		='text'
								SIZE		=10
								MAXLENGTH	=10
								VALUE		='$tglbtu'
								id			='tglbtu'
								onchange	='btu()'
								onkeypress	='return enter(this,event)'
								$isian2>
						<SPAN 	ID			='msgbox'
								STYLE		='display:none'>
						</SPAN>";

						if ($isian=='enable' and $isian2=='enable')
						{
							echo"
							<IMG onClick='WdatePicker({el:tglbtu});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle'>
							";
						}
				echo"
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
									$isian>$ktr</TEXTAREA><input type='hidden' name='code' id='code'class'code'>
					</TD>
				</TR>
			</TABLE>";	
				
			// pilihan tombol pilihan
			// tombol tambah
			if(hakakses('K1D03T')==1 and $pilihan=='detil')
			{	
				echo"
				<INPUT TYPE='button' 				VALUE='Tambah' 	onClick=window.location.href='keuangan.php?mode=K1D03&pilihan=tambah'>";
			}	
						
			// tombol edit
			if(hakakses('K1D03E')==1 and $pilihan=='detil' and $str=='' and $prd==$prdB  AND $nis=='')
			{
				echo"
				<INPUT TYPE='button' 				VALUE='Edit' 	onClick=window.location.href='keuangan.php?mode=K1D03&nmrbtu=$nmrbtu&pilihan=edit'>";
			}	
						
			// tombol hapus
			if(hakakses('K1D03H')==1 and $pilihan=='detil' and $str=='' and $prd==$prdB AND $nis=='')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Hapus' onClick=\"return confirm('Benar data akan dihapus ?');\">
				<INPUT TYPE='hidden' NAME='mode'	VALUE='K1D03_Hapus'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='hapus'>
				<INPUT TYPE='hidden' NAME='nmrbtu'	VALUE='$nmrbtu'>";
			}	
						
			// tombol simpan (tambah)
			if($pilihan=='tambah')
			{
				echo"
				<INPUT TYPE='submit' id='submit'				VALUE='Simpan'>
				<INPUT TYPE='reset' 				VALUE='Ulang'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='tambah'>
				<INPUT TYPE='hidden' NAME='mode'	VALUE='K1D03_Save'>";
			}

			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='nmrbtu'	VALUE='$nmrbtuB'>
				<INPUT TYPE='hidden' NAME='nmrbtuB'	VALUE='$nmrbtuB'>
				<INPUT TYPE='hidden' NAME='nlilma'	VALUE='$nlilma'>
				<INPUT TYPE='hidden' NAME='dr'		VALUE='$dr'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='K1D03_Save'>";
			}
			if($pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 				VALUE='Cetak' 	onClick=window.open('pendataan/K1D03_C01.php?nmrbtu=$nmrbtu')>";
			}
						
			if($nis=='')
			{
				echo"
				<INPUT TYPE='button' 					VALUE='Cari' 	onClick=window.location.href='keuangan.php?mode=K1D03_Cari'>";
			}
			else
			{
				echo"
				<INPUT TYPE='button' 					VALUE='Cari' 	onClick=window.location.href='keuangan.php?mode=K1D03_Check&kdekls=$kdekls&kdejtu=$kdejtu'>";
			}	
			echo"
			<INPUT TYPE='button'					VALUE='Kembali'	onClick=history.go(-1)>						
			$kdeusr - $tglrbh - $jamrbh
            <SCRIPT TYPE='text/javascript' src='../keuangan/js/K1D03.js'></SCRIPT>
		</FORM>"; 
 	}

	// -------------------------------------------------- Hapus --------------------------------------------------
	function K1D03_Hapus()
	{
		$pilihan=$_POST['pilihan'];
		if ($pilihan=='hapus')
		{
			$nmrbtu	=$_POST['nmrbtu'];
		}
		else
		{
			$nmrbtu	=$_GET['nmrbtu'];
		}	
		$prd 	=periode("KEUANGAN");
		
		$query 	=mysql_query("	SELECT 	t_btukng.* 
								FROM 	t_btukng 
								WHERE 	t_btukng.nmrbtu='". mysql_escape_string($nmrbtu)."'");
		$result =mysql_fetch_assoc($query);
		$nli	=$result['nli'];
		
		$sql	="	DELETE 
					FROM 	t_btukng 
					WHERE 	t_btukng.nmrbtu='". mysql_escape_string($nmrbtu)."'";
		$result	=mysql_query($sql) or die ("Query failed - Mysql");
				
		$query 	=mysql_query("	SELECT 	t_sldkng.* 
								FROM 	t_sldkng 
								WHERE 	t_sldkng.prd	='". mysql_escape_string($prd)."'");
		$result =mysql_fetch_assoc($query);
		$msk 	=$result['msk']-$nli;			
				
		$query 	="	UPDATE 	t_sldkng 
					SET		t_sldkng.msk	='". mysql_escape_string($msk)."'
					WHERE 	t_sldkng.prd	='". mysql_escape_string($prd)."'";					
		$result	=mysql_query ($query); 
		
		echo"<meta http-equiv='refresh' content=\"0;url=keuangan.php?mode=K1D03_Cari\">\n"; 
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function K1D03_Save()
	{
		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';
		
  		$nmrbtuB=$_POST['nmrbtuB'];
		$str	=$_POST['str'];
  		$nmrbtu	=$_POST['nmrbtu'];
  		$tglbtu	=$_POST['tglbtu'];
		$kdejtu	=$_POST['kdejtu'];
		$dr		=$_POST['dr'];		
		$nis	=$_POST['nis'];
		$nli	=str_replace(",","",$_POST['nli']);
		$nlilma	=$_POST['nlilma'];
  		$ktr	=$_POST['ktr'];
        $kdeusr =$_SESSION['Admin']['username'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");
  		$pilihan=$_POST['pilihan'];
		$prd 	=periode("KEUANGAN");
		
		if($pilihan=='tambah')
		{
			$nmrbtu = nomor_btuk($prd);




			if($nis!='')
			{
				$query2 ="	SELECT 	t_mstssw.*
							FROM 	t_mstssw
							WHERE 	t_mstssw.nis='$nis'";
				$result2=mysql_query($query2);
				$data2 	=mysql_fetch_array($result2);
				$dr		=$data2[nmassw]." ( KELAS : ".$data2[kdekls]." )";
			}
		}
		$set	="	SET		t_btukng.nmrbtu	='". mysql_escape_string($nmrbtu)."',
							t_btukng.tglbtu	='". mysql_escape_string($tglbtu)."',
							t_btukng.kdejtu	='". mysql_escape_string($kdejtu)."',
							t_btukng.nis	='". mysql_escape_string($nis)."',
							t_btukng.dr		='". mysql_escape_string($dr)."',
							t_btukng.nli	='". mysql_escape_string($nli)."',
							t_btukng.ktr	='". mysql_escape_string($ktr)."',
							t_btukng.kdeusr	='". mysql_escape_string($kdeusr)."',
							t_btukng.tglrbh	='". mysql_escape_string($tglrbh)."',
							t_btukng.jamrbh	='". mysql_escape_string($jamrbh)."'";
									
  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	t_btukng ".$set. 
					 "	WHERE 	t_btukng.nmrbtu	='". mysql_escape_string($nmrbtuB)."'";
			$result	=mysql_query($query) or die (mysql_error());

			$query 	=mysql_query("	SELECT 	* 
									FROM 	t_sldkng 
									WHERE 	t_sldkng.prd = '$prd'");
			$result =mysql_fetch_assoc($query);
			$msk 	=$result['msk']-$nlilma;			

			$query 	="	UPDATE 	t_sldkng 
						SET		t_sldkng.msk	='". mysql_escape_string($msk+$nli)."'
						WHERE 	t_sldkng.prd	='". mysql_escape_string($prd)."'";							
			$result	=mysql_query($query) or die (mysql_error());
        }
  		else
  		{
  			$query 	="	INSERT INTO t_btukng ".$set; 
			$result	=mysql_query($query) or die (mysql_error());

			$query 	=mysql_query("	SELECT 	t_sldkng.* 
									FROM 	t_sldkng 
									WHERE 	t_sldkng.prd = '$prd'");
			$result =mysql_fetch_assoc($query);
			$msk 	=$result['msk'];			
			if(mysql_num_rows($query) == "")
			{
				$query 	="	INSERT INTO t_sldkng 
							SET			t_sldkng.prd	='". mysql_escape_string($prd)."',
										t_sldkng.msk	='". mysql_escape_string($nli)."'";
			}
			else
			{
				$query 	="	UPDATE 	t_sldkng 
							SET		t_sldkng.prd	='". mysql_escape_string($prd)."',
									t_sldkng.msk	='". mysql_escape_string($msk+$nli)."'
							WHERE 	t_sldkng.prd	='". mysql_escape_string($prd)."'";
			}							
			$result	=mysql_query($query) or die (mysql_error());
			
			$nmrbtuB=$nmrbtu;
  		}

         {
		echo"<meta http-equiv='refresh' content=\"0;url=keuangan.php?mode=K1D03&nmrbtu=$nmrbtuB\">\n";
        }
 	}
	
	// -------------------------------------------------- Check Pembayaran --------------------------------------------------
	function K1D03_Check()
	{
		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
	
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>

        <SCRIPT TYPE='text/javascript' src='../js/jquery-1.2.3.pack.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' src='../js/jquery.validate.pack.js'></SCRIPT>";
		
		$kdekls	=$_GET['kdekls'];
		$kdejtu	=$_GET['kdejtu'];
		$nmassw	=$_GET['nmassw'];
		$nmrva	=$_GET['nmrva'];

		$queryx ="	SELECT 				t_mstssw.*
					FROM 				t_mstssw
					WHERE 				(t_mstssw.kdekls	='". mysql_escape_string($kdekls)."'	OR '$kdekls'='')	AND
										(t_mstssw.nmassw 	LIKE'%".$nmassw."%' OR '$nmassw'='')						AND
										(t_mstssw.nmrva 	LIKE'%".$nmrva."%' 	OR '$nmrva'='')							
					ORDER BY 			t_mstssw.kdekls,t_mstssw.nis";
		$result= mysql_query($queryx)	or die (mysql_error());

		echo"
        <SCRIPT TYPE='text/javascript'>
			$(document).ready(function()
			{
				$('#validasi').validate()
			});
		</SCRIPT>
		<FORM ACTION=keuangan.php METHOD='get'  id='validasi' NAME='f1'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>BUKTI TERIMA UANG ( PER KELAS )</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Kelas</TD>
					<TD WIDTH='85%'>:
						<SELECT NAME		='kdekls'
								ID			='kdekls'
								VALUE 		='$kdekls'
								ONKEYUP		='uppercase(this.id)'>";
						$query2="	SELECT 		t_mstkls.*
									FROM 		t_mstkls
									ORDER BY 	t_mstkls.kdeklm,t_mstkls.kdekls";
						$result2=mysql_query($query2);
						echo"
						<OPTION VALUE='' SELECTED>--Semua--</OPTION>";
						while($data2=mysql_fetch_array($result2))
						{
							if ($kdekls==$data2[kdekls])
								echo
								"<OPTION VALUE='$data2[kdekls]' SELECTED>$data2[kdekls]</OPTION>";
							else
								echo"
								<OPTION VALUE='$data2[kdekls]'>$data2[kdekls]</OPTION>";
						}
						echo"
						</SELECT>
					</TD>
				</TR>
				<TR><TD>Jenis Penerimaan</TD>
					<TD>: 
						<SELECT	NAME		='kdejtu'	
								VALUE 		='$kdejtu'
								onkeypress	='return enter(this,event)'
                                class       ='required'
								$isian>";
						$sql2	="	SELECT 		t_jtu.* 
									FROM 		t_jtu  
									ORDER BY 	t_jtu.kdejtu";
    					$my		=mysql_query($sql2);
						echo"
						<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
    					while($al=mysql_fetch_array($my))
    					{
							if ($kdejtu==$al[kdejtu]) 
								echo 
								"<OPTION VALUE='$al[kdejtu]' SELECTED>$al[nmajtu]</OPTION>";
  	  						else 
								echo 
								"<OPTION VALUE='$al[kdejtu]' >$al[nmajtu]</OPTION>";
    					}
       					echo
						"</SELECT>		
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
								onkeyup		='uppercase(this.id)'
								$isian1>
					</TD>
				</TR>
				<TR><TD>Virtual Account</TD>
					<TD>:
						<INPUT 	NAME		='nmrva'	
								ID			='nmrva'	
								VALUE		='$nmrva'	
								TYPE		='text' 		
								SIZE		='25' 
								MAXLENGTH	='25'
								onkeyup		='uppercase(this.id)'
								$isian1>
						<INPUT TYPE='submit' 					VALUE='Tampilkan'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='K1D03_Check'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM ACTION='keuangan.php?mode=K1D03' METHOD='post' >
			<DIV style='overflow:auto;width:100%;height:290px;padding-right:-2px;'>		
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No		</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Kelas			</CENTER></TD>
						<TD WIDTH='10%'><CENTER>NIS				</CENTER></TD>
						<TD WIDTH='32%'><CENTER>Nama			</CENTER></TD>
						<TD WIDTH='15%'><CENTER>Virtual Account	</CENTER></TD>
						<TD WIDTH='15%'><CENTER>Nomor Bukti	<span style='color: #FF0000;'>*</span></CENTER></TD>
						<TD WIDTH='10%'><CENTER>Tanggal			</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Detil			</CENTER></TD>
					</TR>";

					$no=0;
					while($data =mysql_fetch_array($result))
					{
						$nis   =$data[nis];
						$queryy ="	SELECT 				t_btukng.*
									FROM 				t_btukng
									WHERE 				t_btukng.nis	='$nis'		AND
														t_btukng.kdejtu	='$kdejtu'";
						$resulty=mysql_query($queryy)	or die (mysql_error());
						$datay 	=mysql_fetch_array($resulty);
						$nmrbtu	=$datay[nmrbtu];
						$tglbtu	=$datay[tglbtu];
					
						$no++;
						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
							<TD><CENTER>$no				</CENTER></TD>
							<TD><CENTER>$data[kdekls]	</CENTER></TD>
							<TD><CENTER>$data[nis]		</CENTER></TD>
							<TD>$data[nmassw]					</TD>
							<TD><CENTER>$data[nmrva]	</CENTER></TD>
							<TD><CENTER>$nmrbtu	</CENTER></TD>
							<TD><CENTER>$tglbtu	</CENTER></TD>";

							// otorisasi akses detil
							if (hakakses("K1D03D")==1 and $nmrbtu!='')
							{
								echo"
								<TD><CENTER><a href='keuangan.php?mode=K1D03&nmrbtu=$nmrbtu'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
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
			<BR>
			<INPUT TYPE='button' 					VALUE='BUKTI TERIMA UANG per nomor' 	onClick=window.location.href='keuangan.php?mode=K1D03_Cari'>
			<INPUT TYPE='button'					VALUE='Kembali'	onClick=history.go(-1)>	
			<span style='color: #FF0000;'><i>* jika nomor bukti sudah ada maka siswa tersebut sudah membayar untuk jenis penerimaan tersebut</i></span>
		</FORM>";
 	}	
}//akhir class
?>