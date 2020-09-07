<?php
//----------------------------------------------------------------------------------------------------
//Program		: J1D03.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi BUKTI MASUK BARANG (GENERAL)
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class J1D03class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function J1D03_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";		
		
		echo"
		<SCRIPT TYPE='text/javascript'>
			function tgl()
			{
				document.f1.prd.value = document.f1.bln.value +-+ document.f1.tahun.value;
			}
		</SCRIPT>";
		
		$prd 	=periode("PENJUALAN");
		$nmrbmb	=$_GET['nmrbmb'];
		$tglbmb	=$_GET['tglbmb'];
		$dr		=$_GET['dr'];

		$query2 ="	SELECT 		t_gnrbmb.*
					FROM 		t_gnrbmb
					WHERE 		(t_gnrbmb.nmrbmb 	LIKE'%".$nmrbmb."%' OR '$nmrbmb'='')	AND
								(t_gnrbmb.tglbmb 	LIKE'%".$tglbmb."%' OR '$tglbmb'='') 	AND
								(t_gnrbmb.dr 		LIKE'%".$dr."%' 	OR '$dr'='')
					ORDER BY 	t_gnrbmb.nmrbmb";
		$result= mysql_query($query2)	or die (mysql_error());

		echo"
		<FORM ACTION=penjualan.php METHOD='get' NAME='f1'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>BUKTI MASUK BARANG</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='20%'>Periode</TD>
                    <TD WIDTH='80%'>:  
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
						<INPUT TYPE='hidden' name='tglbmb' id='prd'>
					</TD>
				</TR>
				<TR><TD>Nomor Bukti Masuk Barang</TD>
  					<TD>: 
						<INPUT 	NAME		='nmrbmb'
								TYPE		='text' 
								SIZE		='15' 
								MAXLENGTH	='15'
								id			='nmrbmb'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'>
					</TD>
  				</TR>
				<TR><TD>Dari</TD>
					<TD>: 
						<INPUT 	NAME		='dr'
								TYPE		='text' 		
								SIZE		='50' 
								MAXLENGTH	='50'
								id			='dr'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'>

					</TD>
				</TR>
				<TR><TD>Referensi</TD>
					<TD>:
						<INPUT 	NAME		='rfr'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								id			='rfr'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'>
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='J1D03_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='penjualan.php?mode=J1D03_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM ACTION='penjualan.php?mode=J1D03' METHOD='post'>
			<DIV style='overflow:auto;width:100%;height:280px;padding-right:-2px;'>		
			<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
				<TR bgcolor='dedede'>
  					<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No			</CENTER></TD>
  					<TD WIDTH='12%'><CENTER>Nomor Bukti </CENTER></TD>
  					<TD WIDTH='12%'><CENTER>Tanggal		</CENTER></TD>
       				<TD WIDTH='54%'><CENTER>Dari		</CENTER></TD>
       				<TD WIDTH=' 6%'><CENTER>Status		</CENTER></TD>					
                    <TD WIDTH=' 4%'><CENTER>Detil		</CENTER></TD>
  					<TD WIDTH=' 4%'><CENTER>Edit		</CENTER></TD>
  					<TD WIDTH=' 4%'><CENTER>Hapus		</CENTER></TD>
				</TR>";

				$no=0;
				while($data =mysql_fetch_array($result))
				{
					$tglbmb	=substr($data[tglbmb],-2).substr($data[tglbmb],3,2);
					$no++;
					echo"
					<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
  						<TD><CENTER>$no			</CENTER></TD>
  						<TD><CENTER>$data[nmrbmb]</CENTER></TD>
  						<TD><CENTER>$data[tglbmb]</CENTER></TD>
						<TD>$data[dr]</TD>";
						if ($data[str]=='P')
						{
							echo"
							<TD><SPAN STYLE='color: #FF0000;'><CENTER>$data[str]</CENTER></SPAN></TD>";
						}
						else
						{
							echo"
							<TD><CENTER>$data[str]</CENTER></TD>";
						}
						// otorisasi akses detil
						if (hakakses("J1D03D")==1)
						{
							echo"
							<TD><CENTER><a href='penjualan.php?mode=J1D03&nmrbmb=$data[nmrbmb]&pilihan=detilfull'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
						}
						else
						{
							echo"
							<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
						}
						
						// otorisasi akses edit
						if (hakakses("J1D03E")==1 AND $data[str]=='' AND $prd==$tglbmb)
						{		
							echo"
							<TD><CENTER><a href='penjualan.php?mode=J1D03&nmrbmb=$data[nmrbmb]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";
						}
						else
						{
							echo"
							<TD><CENTER><IMG src='../images/edit_d.gif' 	BORDER='0'></a></CENTER></TD>";
						}	
							
						// otorisasi akses hapus
						if (hakakses("J1D03H")==1 AND $data[str]=='' AND $prd==$tglbmb)
						{		
							echo"
							<TD><CENTER><a href='penjualan.php?mode=J1D03_Hapus&nmrbmb=$data[nmrbmb]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
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
			if (hakakses("J1D03T")==1)
			{
				echo"<INPUT TYPE='button' VALUE='Tambah BUKTI MASUK BARANG' onClick=window.location.href='penjualan.php?mode=J1D03&pilihan=tambah'>";
			}	
		echo"	
		</FORM>";
 	}

	// -------------------------------------------------- Item --------------------------------------------------
	function J1D03()
	{
		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';
		
		// deklarasi java
		echo"
		<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' src='../js/ajax.js'></SCRIPT>
        <SCRIPT TYPE='text/javascript' src='../js/ajax-dynamic-list.js'></SCRIPT>";
		
		echo"
		<SCRIPT TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></SCRIPT>";

		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../penjualan/js/J1D03_validasi_tglbmbj.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../penjualan/js/J1D03_validasi_nmabrn.js'></SCRIPT>		
		<SCRIPT TYPE='text/javascript'  src='../penjualan/js/J1D03_prd_bmbj.js'></SCRIPT>";
		
		echo"
		<SCRIPT TYPE='text/javascript'>
			<!-- menyembunyikan kode dari browser non-js
			function periksa()
			{
				formObj = document.f1;
				var prd=document.getElementById('prd').value;
				if ((formObj.tglbmb1.value != prd))
				{
					alert('Periode Tidak Sama');
					return false;
				}
				else
					return true;
				document.f1.kdebrn.focus();
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

		echo"
		<SCRIPT language='javascript'>
			// agar kursor keposisi isian kode barang
			function sf() 
			{ 
				document.f1.tglbmb.focus();
			}
		</SCRIPT>
		<SCRIPT TYPE='text/javascript' src='../penjualan/js/J1D03_cektotal.js'></SCRIPT>";
		
		// inisiasi parameter berdasarkan pilihan tombol
		$pilihan=$_GET['pilihan'];
		$prd 	=periode("PENJUALAN");
				
		if (empty($pilihan))
		{
			$pilihan='detil';
		}
		
		switch($pilihan)
		{
			case 'detil':
				$isian	='disabled';
				$isian2	='enable';
				break;
			case 'detilfull':
				$isian 	='disabled';
				$isian2	='disabled';
				break;
			case 'tambah':
				$isian	='enable';
				$isian2	='disabled';
				$nmrbmb =nomor_bmbj($prd);
				$tgl =date("d-m-Y");
				$tglbmb	=substr($tgl,-2).substr($tgl,3,2);
				break;
			case 'edit':
				$isian	='enable';
				$isian2	='disabled';
				$tglbmb	=$prd;
				break;
		}		
		
		if ($pilihan=='detil' or $pilihan=='edit' or $pilihan=='detilfull')
		{
			$nmrbmbB=$_GET['nmrbmb'];
			$query 	="	SELECT 	t_gnrbmb.*
						FROM 	t_gnrbmb
						WHERE 	t_gnrbmb.nmrbmb='". mysql_escape_string($nmrbmbB)."'";
			$result =mysql_query($query);
			$data 	=mysql_fetch_array($result);
		
			$str	=$data[str];
			$nmrbmb	=$data[nmrbmb];
			$tgl	=$data[tglbmb];
			$dr		=$data[dr];
			$rfr	=$data[rfr];
			$prdB	=tgltoprd($tgl);			
		}
		// akhir inisiasi parameter
		$query2 ="	SELECT 		t_dtlbmb.*,t_mstbrn.nmabrn,t_sldbrn.kdebrn
					FROM 		t_dtlbmb,t_mstbrn,t_sldbrn
					WHERE 		t_dtlbmb.nmrbmb='$nmrbmb'		AND 
								t_dtlbmb.kdebrn=t_mstbrn.kdebrn	AND 
								t_dtlbmb.kdebrn=t_sldbrn.kdebrn	AND 
								t_sldbrn.prd=$prd";
		$result= mysql_query($query2)	or die (mysql_error());

		echo"
		<BODY onload='sf()'>";
        
		if($isian=='enable')
			echo"<SCRIPT TYPE='text/javascript' src='../penjualan/js/J1D03.js'></SCRIPT>";

		echo"<FORM ID='validasi'  METHOD='post' NAME='f1'>";

		echo"
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>BUKTI MASUK BARANG</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='20%'>Nomor Bukti Masuk Barang</TD>
					<TD WIDTH='80%'>: 
						<INPUT 	NAME		='nmrbmb'
								TYPE		='text' 	
								SIZE		='15' 	
								MAXLENGTH	='15'
								VALUE 		='$nmrbmb'
								id			='nmrbmb'
								DISABLED>
						<INPUT TYPE='hidden' 	NAME='prd'	VALUE='$prd'>

						Tanggal :
                        <INPUT TYPE='hidden'id='tglbmb1' 	NAME='tglbmb1' 	VALUE='$tglbmb'>
						<INPUT TYPE='hidden'id='prd' 		NAME='prd'		VALUE='$prd'>
						<input type='hidden' name='kdebrn'id='nmabrn_hidden'>
						<INPUT 	NAME		='tglbmb'
								TYPE		='text' 
								SIZE		=10 
								MAXLENGTH	=10 
								VALUE		='$tgl'
								id			='tglbmb'
								onchange	='btu()'
								onkeypress	='return enter(this,event)'
								$isian>

						<SPAN 	ID			='msgbox'  
								STYLE		='display:none'>
						</SPAN>";

						if ($isian=='enable')		
						{ 
							echo"
							<IMG onClick='WdatePicker({el:tglbmb});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle'>";
						}	
					echo"	
					</TD>
              	</TR>
				<TR><TD>Dari</TD>
					<TD>: 
						<INPUT 	NAME		='dr'
								TYPE		='text' 
								SIZE		='50' 	
								MAXLENGTH	='50'		
								VALUE		='$dr'
								id			='dr'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								$isian>
					</TD>
				</TR>
                    <TD>Referensi</TD>
					<TD>:
						<INPUT 	NAME		='rfr'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE		='$rfr'
								id			='rfr'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'
                                CLASS		='rfr'
								TITLE		='...harus diisi'
								$isian>
					</TD>
				</TR>
			
				<TR><TD>Nama Barang</TD>
					<TD COLSPAN='2'>: 
						<INPUT 	NAME		='nmabrn'
								ID			='nmabrn'
								TYPE		='text' 		
								SIZE		='50' 
								MAXLENGTH	='50'
								onkeyup		='ajax_showOptions(this,\"suggest\",event);uppercase(this.id);'
                                onkeypress	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								$isian>
						Banyak :
						<INPUT 	NAME		='bny'	
								TYPE		='text' 
								SIZE		='12' 	
								MAXLENGTH	='12'		
								VALUE		='$bny'
								id			='bny'
								CLASS		='required' 
								TITLE		='...harus diisi'
								onkeypress	='return enter(this,event)'
								$isian>";
						if ($pilihan!='detilfull')		
						{
							echo"
							<INPUT TYPE='submit' 	id='submitk'				VALUE='Input'> ";
							if($isian=='enable')
							{
								echo"
								<INPUT TYPE='hidden' NAME='mode'	VALUE='J1D03_Save'>";
								if($pilihan=='edit')
									echo"
									<INPUT TYPE='hidden' 	id='edt' NAME='pilihan'	VALUE='edit'>
									<INPUT TYPE='hidden' 	id='nmrbmbB' NAME='nmrbmbB'	VALUE='$nmrbmb'>";
								else
									echo"
									<INPUT TYPE='hidden' NAME='pilihan'	VALUE='tambah'>";
							}		
							else
								echo"
								<INPUT TYPE='hidden' 	NAME='mode'		VALUE='J1D03_Save_Item'>
								<INPUT TYPE='hidden' 	NAME='nmrbmb'	VALUE='$nmrbmb'>";
						}		
						echo"	
						<SPAN 	ID			='msgbox1'  
								STYLE		='display:none'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM ID='validasi' >
			<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
				<TR bgcolor='dedede'>
  					<TD WIDTH=' 5%' HEIGHT='20'><CENTER>No			</CENTER></TD>
  					<TD WIDTH='10%'><CENTER>Kode  		</CENTER></TD>
  					<TD WIDTH='68%'><CENTER>Nama Barang	</CENTER></TD>
       				<TD WIDTH='12%'><CENTER>Banyak		</CENTER></TD>
  					<TD WIDTH=' 5%'><CENTER>Hapus		</CENTER></TD>
				</TR>
                <TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' id='stok' >";
					
				$no=0;
				while($data =mysql_fetch_array($result))
				{
					$bny	=number_format($data[bny]);
					$no++;
					echo"
					<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
  						<TD WIDTH=' 5%'><CENTER>$no			</CENTER></TD>
  						<TD WIDTH='10%'><CENTER>$data[kdebrn]</CENTER></TD>
  						<TD WIDTH='68%'><CENTER>$data[nmabrn]</CENTER></TD>
						<TD WIDTH='12%'><CENTER>$bny</CENTER></TD>";
						// otorisasi akses detil
						
						// otorisasi akses hapus
						if (hakakses("J1D03H")==1 and $pilihan!='detilfull')
						{		
							echo"
							<TD WIDTH=' 5%'><CENTER><a href='#' id='$data[kdebrn]'bny='$data[bny]'class='hapus'><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
						}
						else	
						{
							echo"
							<TD WIDTH='5%'><CENTER><IMG src='../images/hapus_d.gif' BORDER='0'></a></CENTER></TD>";
						}
					echo"	
					</TR>";
				}
				$i++;
				echo"
				<SCRIPT TYPE='text/javascript' src='../penjualan/js/J1D03_hapus.js'></SCRIPT>
			</TABLE>
			<BR>";
			// otorisasi akses tambah
			if (hakakses("J1D03T")==1 and ($pilihan=='detil' or $pilihan=='detilfull' or $pilihan=='tambah' or $pilihan=='edit'))
			{
				echo"
				<INPUT TYPE='button' VALUE='Tambah BUKTI MASUK BARANG' onClick=window.location.href='penjualan.php?mode=J1D03&pilihan=tambah'>";
			}	
			if (hakakses("J1D03E")==1 and ($pilihan=='detil' or $pilihan=='detilfull') and $str=='' and $prd==$prdB)
			{
				echo"
				<INPUT TYPE='button' VALUE='Edit' onClick=window.location.href='penjualan.php?mode=J1D03&pilihan=edit&nmrbmb=$nmrbmb'>";
			}	
			if (hakakses("J1D03H")==1 and ($pilihan=='detil' or $pilihan=='detilfull') and $str=='' and $prd==$prdB)
			{
				echo"
				<INPUT TYPE='button' VALUE='Hapus' onClick=window.location.href='penjualan.php?mode=J1D03_Hapus&nmrbmb=$nmrbmb'>";
			}	
			if ($pilihan=='detil' or $pilihan=='detilfull'or $pilihan=='tambah')
			{
				echo"
				<INPUT TYPE='button' VALUE='Cetak' 	onClick=window.open('pendataan/J1D03_C01.php?nmrbmb=$nmrbmb')>";
			}	
			echo"
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='penjualan.php?mode=J1D03_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>";
		echo"	
		</FORM>
		</BODY>";
	}			

	// -------------------------------------------------- Hapus --------------------------------------------------
	function J1D03_Hapus()
	{
		$pilihan=$_POST['pilihan'];
		if ($pilihan=='hapus')
		{
			$nmrbmb	=$_POST['nmrbmb'];
		}
		else
		{
			$nmrbmb	=$_GET['nmrbmb'];
		}	
		$prd 	=periode("PENJUALAN");

		$query 		="	SELECT 	t_dtlbmb.*
						FROM 	t_dtlbmb
						WHERE 	t_dtlbmb.nmrbmb='". mysql_escape_string($nmrbmb)."'";
		$result 	=mysql_query($query) or die('Query gagal');

		while($data = mysql_fetch_array($result))
		{		
			$kdebrn	=$data[kdebrn];
			$bny	=$data[bny];
			$query 	=mysql_query("	SELECT 	t_sldbrn.* 
									FROM 	t_sldbrn 
									WHERE 	t_sldbrn.prd	='". mysql_escape_string($prd)."'	AND
											t_sldbrn.kdebrn	='". mysql_escape_string($kdebrn)."'");
			$result2 =mysql_fetch_assoc($query);
			$msk 	=$result2['msk']-$bny;			

			$query 	="	UPDATE 	t_sldbrn 
						SET		t_sldbrn.msk	='". mysql_escape_string($msk)."'
						WHERE 	t_sldbrn.prd	='". mysql_escape_string($prd)."'	AND
								t_sldbrn.kdebrn	='". mysql_escape_string($kdebrn)."'";					
			$result3	=mysql_query ($query); 
		}
		
		$sql	="	DELETE 
					FROM 	t_gnrbmb
					WHERE 	t_gnrbmb.nmrbmb='". mysql_escape_string($nmrbmb)."'";
		$result	=mysql_query($sql) or die ("Query failed - Mysql");

		$sql	="	DELETE 
					FROM 	t_dtlbmb
					WHERE 	t_dtlbmb.nmrbmb	='". mysql_escape_string($nmrbmb)."'";
		$result	=mysql_query($sql) or die ("Query failed - Mysql");
		
		echo"<meta http-equiv='refresh' content=\"0;url=penjualan.php?mode=J1D03_Cari\">\n";
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function J1D03_Save()
	{
		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';
		
  		$nmrbmbB=$_POST['nmrbmbB'];
		$str	=$_POST['str'];
  		$nmrbmb	=$_POST['nmrbmb'];
  		$tglbmb	=$_POST['tglbmb'];
		$dr		=$_POST['dr'];
		$rfr	=$_POST['rfr'];
   	    $ktr	=$_POST['ktr'];
		
  		$pilihan=$_POST['pilihan'];
        $kdeusr =$_SESSION['Admin']['username'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");
		$prd 	=periode("PENJUALAN");

		if ($pilihan=='tambah')
		{
			$nmrbmb = nomor_bmbj($prd);
		}	
		$set	="	SET		t_gnrbmb.nmrbmb	='". mysql_escape_string($nmrbmb)."',
							t_gnrbmb.tglbmb	='". mysql_escape_string($tglbmb)."',
							t_gnrbmb.dr		='". mysql_escape_string($dr)."',
							t_gnrbmb.rfr	='". mysql_escape_string($rfr)."',
       		                                         t_gnrbmb.ktr	='". mysql_escape_string($ktr)."',
							t_gnrbmb.kdeusr	='". mysql_escape_string($kdeusr)."',
							t_gnrbmb.tglrbh	='". mysql_escape_string($tglrbh)."',
							t_gnrbmb.jamrbh	='". mysql_escape_string($jamrbh)."'";
									
  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	t_gnrbmb ".$set.
					 "	WHERE 	t_gnrbmb.nmrbmb	='". mysql_escape_string($nmrbmbB)."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
        }
  		else
  		{
  			$query 	="	INSERT INTO t_gnrbmb ".$set;
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Input yu"));

			$nmrbmbB=$nmrbmb;
  		}
 	}
	
	// -------------------------------------------------- Save Item --------------------------------------------------
	function J1D03_Save_Item()
	{
  		$nmrbmb	=$_POST['nmrbmb'];
		$kdebrn	=$_POST['kdebrn'];
		$bny	=str_replace(",","",$_POST['bny']);
		$prd	=periode('PENJUALAN');
		
		$query 	=mysql_query("	SELECT 	t_dtlbmb.*
								FROM 	t_dtlbmb
								WHERE 	t_dtlbmb.nmrbmb = '$nmrbmb'	AND
										t_dtlbmb.kdebrn = '$kdebrn'");
		$result =mysql_fetch_assoc($query);
		$bnyawl	=$result['bny'];
		if(mysql_num_rows($query) == "")
		{
			$query 	="	INSERT INTO t_dtlbmb
						SET			t_dtlbmb.nmrbmb	='". mysql_escape_string($nmrbmb)	."',
									t_dtlbmb.kdebrn	='". mysql_escape_string($kdebrn)	."',
									t_dtlbmb.bny	='". mysql_escape_string($bny)		."'";
		}
		else
		{
			$query 	="	UPDATE 	t_dtlbmb
						SET		t_dtlbmb.bny	='". mysql_escape_string($bny+$bnyawl)	."'
						WHERE 	t_dtlbmb.nmrbmb	='". mysql_escape_string($nmrbmb)		."'	AND
								t_dtlbmb.kdebrn	='". mysql_escape_string($kdebrn)		."'";
		}
		$q 		=mysql_query ($query)or die(error("Data tidak berhasil di Input")) ;

		$query 	=mysql_query("	SELECT 	t_sldbrn.* 
								FROM 	t_sldbrn 
								WHERE 	t_sldbrn.prd = '$prd'	AND
										t_sldbrn.kdebrn = '$kdebrn'");
		$result =mysql_fetch_assoc($query);
		$msk 	=$result['msk'];			
		if(mysql_num_rows($query) == "")
		{
			$query 	="	INSERT INTO t_sldbrn 
						SET			t_sldbrn.prd	='". mysql_escape_string($prd)."',
									t_sldbrn.kdebrn	='". mysql_escape_string($kdebrn)."',
									t_sldbrn.msk	='". mysql_escape_string($bny)	."'";
		}
		else
		{
			$query 	="	UPDATE 	t_sldbrn 
						SET		t_sldbrn.prd	='". mysql_escape_string($prd)."',
								t_sldbrn.msk	='". mysql_escape_string($msk+$bny)."'
						WHERE 	t_sldbrn.prd	='". mysql_escape_string($prd)."'	AND
								t_sldbrn.kdebrn	='". mysql_escape_string($kdebrn)."'";
		}							
		$q 		=mysql_query ($query)or die(error("Data tidak berhasil di Input")) ;
	}
}//akhir class
?>