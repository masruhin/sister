<?php
//----------------------------------------------------------------------------------------------------
//Program		: J1D04.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi BUKTI KELUAR BARANG
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class J1D04class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function J1D04_Cari()
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
		$nmrbkb	=$_GET['nmrbkb'];
		$tglbkb	=$_GET['tglbkb'];
		$utk	=$_GET['utk'];

		$query ="	SELECT 		t_gnrbkb.*
					FROM 		t_gnrbkb
					WHERE 		(t_gnrbkb.nmrbkb 	LIKE'%".$nmrbkb."%' OR '$nmrbkb'='')	AND
								(t_gnrbkb.tglbkb 	LIKE'%".$tglbkb."%' OR '$tglbkb'='') 	AND
								(t_gnrbkb.utk 		LIKE'%".$utk."%' 	OR '$utk'='')	
					ORDER BY 	t_gnrbkb.nmrbkb";
		$result= mysql_query($query)	or die (mysql_error());

		echo"
		<FORM ACTION=penjualan.php METHOD='get' NAME='f1'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>BUKTI KELUAR BARANG</B></TD></TR>
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
						<INPUT TYPE='hidden' name='tglbkb' id='prd'>
					</TD>
				</TR>
				<TR><TD>Nomor Bukti Keluar Barang</TD>
  					<TD>: 
						<INPUT 	NAME		='nmrbkb'
								TYPE		='text' 
								SIZE		='15' 
								MAXLENGTH	='15'
								id			='nmrbkb'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'>
					</TD>
  				</TR>
				<TR><TD>Untuk</TD>
					<TD>: 
						<INPUT 	NAME		='utk'
								TYPE		='text' 		
								SIZE		='50' 
								MAXLENGTH	='50'
								id			='utk'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'>
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='J1D04_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='penjualan.php?mode=J1D04_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM ACTION='penjualan.php?mode=J1D04' METHOD='post'>
			<DIV style='overflow:auto;width:100%;height:310px;padding-right:-2px;'>		
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No			</CENTER></TD>
						<TD WIDTH='12%'><CENTER>Nomor Bukti </CENTER></TD>
						<TD WIDTH='12%'><CENTER>Tanggal		</CENTER></TD>
						<TD WIDTH='54%'><CENTER>Untuk		</CENTER></TD>
						<TD WIDTH=' 6%'><CENTER>Status		</CENTER></TD>					
						<TD WIDTH=' 4%'><CENTER>Detil		</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Edit		</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Hapus		</CENTER></TD>
					</TR>";
				
					$no=0;
					while($data =mysql_fetch_array($result))
					{
						$tglbkb	=substr($data[tglbkb],-2).substr($data[tglbkb],3,2);
						$no++;
						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
							<TD><CENTER>$no				</CENTER></TD>
							<TD><CENTER>$data[nmrbkb]	</CENTER></TD>
							<TD><CENTER>$data[tglbkb]	</CENTER></TD>
							<TD>$data[utk]</TD>";
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
							if (hakakses("J1D04D")==1)
							{
								echo"
								<TD><CENTER><a href='penjualan.php?mode=J1D04&nmrbkb=$data[nmrbkb]&pilihan=detilfull'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
							}
						
							// otorisasi akses edit
							if (hakakses("J1D04E")==1 AND $data[str]=='' AND $prd==$tglbkb)
							{		
								echo"
								<TD><CENTER><a href='penjualan.php?mode=J1D04&nmrbkb=$data[nmrbkb]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/edit_d.gif' 	BORDER='0'></a></CENTER></TD>";
							}	
							
							// otorisasi akses hapus
							if (hakakses("J1D04H")==1 AND $data[str]=='' AND $prd==$tglbkb)
							{		
								echo"
								<TD><CENTER><a href='penjualan.php?mode=J1D04_Hapus&nmrbkb=$data[nmrbkb]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
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
			if (hakakses("J1D04T")==1)
			{
				echo"<INPUT TYPE='button' VALUE='Tambah BUKTI KELUAR BARANG' onClick=window.location.href='penjualan.php?mode=J1D04&pilihan=tambah'>";
			}	
		echo"	
		</FORM>";
 	}
	
	// -------------------------------------------------- Item --------------------------------------------------
	function J1D04()
	{
		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';

		// deklarasi java
		echo"
		<SCRIPT TYPE='text/javascript' src='../js/ajax.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' src='../js/ajax-dynamic-list.js'></SCRIPT>

		<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";
		
		echo"
		<SCRIPT TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></SCRIPT>";

		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../penjualan/js/J1D04_validasi_tglbkbj.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../penjualan/js/J1D04_validasi_nmabrn.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../penjualan/js/J1D04_prd_bkbj.js'></SCRIPT>";
		
		echo"
        <SCRIPT TYPE='text/javascript'>
			function cstk()
			{
				var cst	=document.f1.cst.value;
                var bny	=document.f1.bny.value;
                var stk= parseInt(cst)- parseInt(bny);
                document.getElementById('cst1').value=stk;
			}
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
		//agar kursor keposisi isian kode barang
		function sf() 
			{ document.f1.tglbkb.focus();
			}
			function sf1()
			{ document.f1.kdebrn.focus();
			}
		</SCRIPT>";
		
		echo"<SCRIPT TYPE='text/javascript' src='../penjualan/js/J1D04_cektotal.js'></SCRIPT>";
		
        //buat suggest pencarian barang

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
				$isian2	='enable';
				$nmrbkb =nomor_bkbj($prd);
				$tgl =date("d-m-Y");
				$tglbkb	=substr($tgl,-2).substr($tgl,3,2);
				break;
			case 'edit':
				$isian	='enable';
				$isian2	='enable';
				$tglbkb	=$prd;
				break;
		}		

		if ($pilihan=='detil' or $pilihan=='edit' or $pilihan=='detilfull')
		{
			$nmrbkbB=$_GET['nmrbkb'];
			$query 	="	SELECT 	*
						FROM 	t_gnrbkb
						WHERE 	t_gnrbkb.nmrbkb='". mysql_escape_string($nmrbkbB)."'";
			$result =mysql_query($query);
			$data 	=mysql_fetch_array($result);
		
			$str	=$data[str];
			$nmrbkb	=$data[nmrbkb];
			$tgl	=$data[tglbkb];
			$utk	=$data[utk];			
			$ktr	=$data[ktr];
			$prdB	=tgltoprd($tglbkb);
		}

		// akhir inisiasi parameter
		
		$query ="	SELECT 		t_dtlbkb.*,t_mstbrn.nmabrn,t_sldbrn.kdebrn
					FROM 		t_dtlbkb,t_mstbrn,t_sldbrn
					WHERE 		t_dtlbkb.nmrbkb='$nmrbkb'		AND 
								t_dtlbkb.kdebrn=t_mstbrn.kdebrn	AND 
								t_dtlbkb.kdebrn=t_sldbrn.kdebrn	AND 
								t_sldbrn.prd= $prd";
		$result= mysql_query($query)	or die (mysql_error());

		echo"
		<BODY onload='sf();'>";
		
		if($isian=='enable')
			echo"<SCRIPT TYPE='text/javascript' src='../penjualan/js/J1D04.js'></SCRIPT>";

		echo"
		<FORM ID='validasi'  METHOD='post' NAME='f1'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>BUKTI KELUAR BARANG</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='20%'>Nomor Bukti Keluar Barang</TD>
					<TD WIDTH='80%'>: 
						<INPUT 	NAME		='nmrbkb'	
								TYPE		='text' 	
								SIZE		='15' 	
								MAXLENGTH	='15'
								id         	='nmrbkb'
								VALUE 		='$nmrbkb'
								DISABLED>
						<INPUT TYPE='hidden' 	NAME='prd'				VALUE='$prd'>
						<INPUT TYPE='hidden' 	NAME='cst' 	id='cst'	VALUE=''>
						<INPUT TYPE='hidden' 	NAME='cst1' id='cst1'	VALUE=''>
						
						Tanggal :     
						<INPUT TYPE='hidden'id='tglbkb1' 	NAME='tglbkb1' 	VALUE='$tglbkb'>
						<INPUT TYPE='hidden'id='prd' 		NAME='prd'		VALUE='$prd'>
						<input type='hidden' name='kdebrn'id='nmabrn_hidden'>
						<INPUT 	NAME		='tglbkb'  
								TYPE		='text' 
								SIZE		=10 
								MAXLENGTH	=10 
								VALUE		='$tgl'
								id		='tglbkb'
								onchange	='bcb();'
								onkeypress	='return enter(this,event)'
								$isian>

						<SPAN 	ID			='msgbox'  
								STYLE		='display:none'>
						</SPAN>";

						if ($isian=='enable')		
						{ 
							echo"
							<IMG onClick='WdatePicker({el:tglbkb});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle'>";
						}
					echo"
					</TD>
              	</TR>
				<TR><TD>Untuk</TD>
					<TD>: 
						<INPUT 	NAME		='utk'	
								ID			='utk'						
								TYPE		='text' 
								SIZE		='50' 	
								MAXLENGTH	='50'		
								VALUE		='$utk'
								onkeyup		='uppercase(this.id)'
                                onkeypress	='return enter(this,event)'
                                CLASS		='utk'
								TITLE		='...harus diisi'
								$isian2>
					</TD>
				</TR>

				<TR><TD>Nama Barang</TD>
					<TD>:
						<INPUT 	NAME		='nmabrn'
								ID			='nmabrn'
								TYPE		='text' 		
								SIZE		='50' 
								MAXLENGTH	='50'
								onkeyup		='ajax_showOptions(this,\"suggest\",event);uppercase(this.id);'
                                onkeypress	='return enter(this,event)'
								CLASS		='required'
								TITLE		='...harus diisi'
								$isian2>
						Banyak :
						<INPUT 	NAME		='bny'	
								TYPE		='text' 
								SIZE		='12' 	
								MAXLENGTH	='12'		
								VALUE		='$bny'
								id			='bny'
                                onkeyup		='cstk();'
								onkeypress	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								$isian2>";
						if ($pilihan!='detilfull')
						{
							echo"
							<INPUT TYPE='submit'  	id='submit'			VALUE='Input'>";
							if($isian=='enable')
							{
								echo"
								<INPUT TYPE='hidden' NAME='mode' 	VALUE='J1D04_Save'>";
								if($pilihan=='edit')
									echo"
									<INPUT TYPE='hidden' 	id='edt' NAME='pilihan'	VALUE='edit'>
									<INPUT TYPE='hidden' 	id='nmrbkbB'NAME='nmrbkbB'	VALUE='$nmrbkb'>";
								else
									echo"
									<INPUT TYPE='hidden' NAME='pilihan'	VALUE='tambah'>";
							}
							else
								echo"
								<INPUT TYPE='hidden' 	NAME='mode'		VALUE='J1D04_Save_Item'>
								<INPUT TYPE='hidden' 	NAME='nmrbkb'	VALUE='$nmrbkb'>";
						}		
						echo"
						<SPAN 	ID			='msgbox1'  
								STYLE		='display:none'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM id='validasi'>
			<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' >
				<TR bgcolor='dedede'>
  					<TD WIDTH='	5%' HEIGHT='20'><CENTER>No			</CENTER></TD>
  					<TD WIDTH='10%'><CENTER>Kode  		</CENTER></TD>
  					<TD WIDTH='68%'><CENTER>Nama Barang	</CENTER></TD>
					<TD WIDTH='12%'><CENTER>Banyak		</CENTER></TD>
  					<TD WIDTH=' 5%'><CENTER>Hapus		</CENTER></TD>
				</TR>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' id='stok' >";

				$no=0;
				while($data =mysql_fetch_array($result))
				{
					$cekstok=$data['sldawl']+$data['msk']-$data['klr'];
					$bny	=number_format($data[bny]);
					$no++;
					echo"

					<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
  						<TD WIDTH='	5%'><CENTER>$no				</CENTER></TD>
  						<TD WIDTH='10%'><CENTER>$data[kdebrn]	</CENTER></TD>
  						<TD WIDTH='68%'><CENTER>$data[nmabrn]	</CENTER></TD>
						<TD WIDTH='12%'><CENTER>$bny			</CENTER></TD>";
						// otorisasi akses detil
						
						// otorisasi akses hapus
						if (hakakses("J1D04H")==1 and $pilihan!='detilfull')
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
				<SCRIPT TYPE='text/javascript' src='../penjualan/js/J1D04_hapus.js'></SCRIPT>
				<SCRIPT TYPE='text/javascript' src='../js/copykde.js'></SCRIPT>";
			echo"	
			</TABLE>
			<BR>";
			// otorisasi akses tambah
			if (hakakses("J1D04T")==1 and ($pilihan=='detil' or $pilihan=='detilfull' or $pilihan=='tambah' or $pilihan=='edit'))
			{
				echo"
				<INPUT TYPE='button' VALUE='Tambah BUKTI KELUAR BARANG' onClick=window.location.href='penjualan.php?mode=J1D04&pilihan=tambah'>";
			}	
			if (hakakses("J1D04E")==1 and ($pilihan=='detil' or $pilihan=='detilfull') and $str=='' and $prd==$prdB)
			{
				echo"
				<INPUT TYPE='button' VALUE='Edit' onClick=window.location.href='penjualan.php?mode=J1D04&pilihan=edit&nmrbkb=$nmrbkb'>";
			}	
			if (hakakses("J1D04H")==1 and ($pilihan=='detil' or $pilihan=='detilfull') and $str=='' and $prd==$prdB)
			{
				echo"
				<INPUT TYPE='button' VALUE='Hapus' onClick=window.location.href='penjualan.php?mode=J1D04_Hapus&nmrbkb=$nmrbkb'>";
			}	
			if ($pilihan=='detil' or $pilihan=='detilfull'or $pilihan=='tambah')
			{
				echo"
				<INPUT TYPE='button' VALUE='Cetak' 	onClick=window.open('pendataan/J1D04_C01.php?nmrbkb=$nmrbkb')>";
			}	
			echo"
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='penjualan.php?mode=J1D04_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>";
		echo"	
		</FORM>
		</BODY>";
	}		

	// -------------------------------------------------- Hapus --------------------------------------------------
	function J1D04_Hapus()
	{
		$pilihan=$_POST['pilihan'];
		if ($pilihan=='hapus')
		{
			$nmrbkb	=$_POST['nmrbkb'];
		}
		else
		{
			$nmrbkb	=$_GET['nmrbkb'];
		}	
		$prd 	=periode("PENJUALAN");
		
		$query 		="	SELECT 	t_dtlbkb.*
						FROM 	t_dtlbkb
						WHERE 	t_dtlbkb.nmrbkb='". mysql_escape_string($nmrbkb)."'";
		$result 	=mysql_query($query) or die('Query gagal');

		while($data = mysql_fetch_array($result))
		{		
			$kdebrn	=$data[kdebrn];
			$bny	=$data[bny];
			$query 	=mysql_query("	SELECT 	t_sldbrn.* 
									FROM 	t_sldbrn 
									WHERE 	t_sldbrn.prd	='". mysql_escape_string($prd)."'	AND
											t_sldbrn.kdebrn	='". mysql_escape_string($kdebrn)."'");
			$data 	=mysql_fetch_assoc($query);
			$klr 	=$data['klr']-$bny;			

			$query 	="	UPDATE 	t_sldbrn 
						SET		t_sldbrn.klr	='". mysql_escape_string($klr)."'
						WHERE 	t_sldbrn.prd	='". mysql_escape_string($prd)."'	AND
								t_sldbrn.kdebrn	='". mysql_escape_string($kdebrn)."'";					
			$result2=mysql_query ($query); 
		}
		
		$query	="	DELETE 
					FROM 	t_gnrbkb 
					WHERE 	t_gnrbkb.nmrbkb='". mysql_escape_string($nmrbkb)."'";
		$result	=mysql_query($query) or die ("Query failed - Mysql");
		
		$query	="	DELETE 
					FROM 	t_dtlbkb 
					WHERE 	t_dtlbkb.nmrbkb	='". mysql_escape_string($nmrbkb)."'";
		$result	=mysql_query($query) or die ("Query failed - Mysql");
				
		echo"<meta http-equiv='refresh' content=\"0;url=penjualan.php?mode=J1D04_Cari\">\n";  
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function J1D04_Save()
	{
		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';

  		$nmrbkbB=$_POST['nmrbkbB'];
		$str	=$_POST['str'];
  		$nmrbkb	=$_POST['nmrbkb'];
  		$tglbkb	=$_POST['tglbkb'];
		$utk	=$_POST['utk'];
  		$ktr	=$_POST['ktr'];
		
  		$pilihan=$_POST['pilihan'];
        $kdeusr =$_SESSION['Admin']['username'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");
		$prd 	=periode("PENJUALAN");

		if ($pilihan=='tambah')
		{
			$nmrbkb =nomor_bkbj($prd);
		}	
		$set	="	SET		t_gnrbkb.nmrbkb	='". mysql_escape_string($nmrbkb)."',
							t_gnrbkb.tglbkb	='". mysql_escape_string($tglbkb)."',
							t_gnrbkb.utk	='". mysql_escape_string($utk)."',
							t_gnrbkb.ktr	='". mysql_escape_string($ktr)."',
							t_gnrbkb.kdeusr	='". mysql_escape_string($kdeusr)."',
							t_gnrbkb.tglrbh	='". mysql_escape_string($tglrbh)."',
							t_gnrbkb.jamrbh	='". mysql_escape_string($jamrbh)."'";
							
  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	t_gnrbkb ".$set. 
					 "	WHERE 	t_gnrbkb.nmrbkb	='". mysql_escape_string($nmrbkb)."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
        }
  		else
  		{
  			$query 	="	INSERT INTO t_gnrbkb ".$set; 
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
  		}
 	}
	
	// -------------------------------------------------- Save Item --------------------------------------------------
	function J1D04_Save_Item()
	{
		$nmrbkb	=$_POST['nmrbkb'];
		$kdebrn	=$_POST['kdebrn'];
		$bny	=str_replace(",","",$_POST['bny']);
        $prd	=periode('PENJUALAN');

		$query 	=mysql_query("	SELECT 	t_dtlbkb.* 
								FROM 	t_dtlbkb 
								WHERE 	t_dtlbkb.nmrbkb = '$nmrbkb'	AND
										t_dtlbkb.kdebrn = '$kdebrn'");
		$data 	=mysql_fetch_assoc($query);
		$bnyawl	=$data['bny'];			
		if(mysql_num_rows($query) == "")
		{
			$query 	="	INSERT INTO t_dtlbkb 
						SET			t_dtlbkb.nmrbkb	='". mysql_escape_string($nmrbkb)."',
									t_dtlbkb.kdebrn	='". mysql_escape_string($kdebrn)."',
									t_dtlbkb.bny	='". mysql_escape_string($bny)."'";
			$result =mysql_query ($query)or die(error("Data tidak berhasil di Input")) ;									
		}
		else
		{
			$query 	="	UPDATE 	t_dtlbkb 
						SET		t_dtlbkb.bny	='". mysql_escape_string($bny+$bnyawl)."'
						WHERE 	t_dtlbkb.nmrbkb	='". mysql_escape_string($nmrbkb)."'	AND
								t_dtlbkb.kdebrn	='". mysql_escape_string($kdebrn)."'";
			$result	=mysql_query ($query)or die(error("Data tidak berhasil di Input")) ;																	
		}							

		$query 	=mysql_query("	SELECT 	t_sldbrn.* 
								FROM 	t_sldbrn 
								WHERE 	t_sldbrn.prd = '$prd'	AND
										t_sldbrn.kdebrn = '$kdebrn'");
		$data 	=mysql_fetch_assoc($query);
		$klr 	=$data['klr'];			
		if(mysql_num_rows($query) == "")
		{
			$query 	="	INSERT INTO t_sldbrn 
						SET			t_sldbrn.prd	='". mysql_escape_string($prd)."',
									t_sldbrn.kdebrn	='". mysql_escape_string($kdebrn)."',
									t_sldbrn.klr	='". mysql_escape_string($bny)	."'";
		}
		else
		{
			$query 	="	UPDATE 	t_sldbrn 
						SET		t_sldbrn.prd	='". mysql_escape_string($prd)."',
								t_sldbrn.klr	='". mysql_escape_string($klr+$bny)."'
						WHERE 	t_sldbrn.prd	='". mysql_escape_string($prd)."'	AND
								t_sldbrn.kdebrn	='". mysql_escape_string($kdebrn)."'";
		}							
		$result	=mysql_query ($query)or die(error("Data tidak berhasil di Input")) ;
 	}
}//akhir class
?>