<?php
//----------------------------------------------------------------------------------------------------
//Program		: J1D05.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi PENJUALAN
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class J1D05class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function J1D05_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_INPUT.js'></SCRIPT>";		
		
		echo"
		<SCRIPT TYPE='text/javascript'>
			function tgl()
			{
				document.f1.prd.value = document.f1.bln.value +-+ document.f1.tahun.value;
			}
		</SCRIPT>";
		
		$prd 	=periode("PENJUALAN");
		$nmrpnj	=$_GET['nmrpnj'];
		$tglpnj	=$_GET['tglpnj'];
		$dr		=$_GET['dr'];

		$query ="	SELECT 		t_gnrpnj.*
					FROM 		t_gnrpnj
					WHERE 		(t_gnrpnj.nmrpnj LIKE'%".$nmrpnj."%' OR '$nmrpnj'='')	AND
								(t_gnrpnj.tglpnj LIKE'%".$tglpnj."%' OR '$tglpnj'='') 	AND
								(t_gnrpnj.utk LIKE'%".$utk."%' OR '$utk'='')
					ORDER BY 	t_gnrpnj.nmrpnj";
		$result= mysql_query($query)	or die (mysql_error());

		echo"
		<FORM ACTION=penjualan.php METHOD='get' NAME='f1'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>PENJUALAN</B></TD></TR>
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
						<INPUT TYPE='hidden' name='tglpnj' id='prd'>
					</TD>
				</TR>
				<TR><TD>Nomor PENJUALAN</TD>
  					<TD>: 
						<INPUT 	NAME		='nmrpnj'
								TYPE		='text' 
								SIZE		='15' 
								MAXLENGTH	='15'
								id			='nmrpnj'
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
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='J1D05_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='penjualan.php?mode=J1D05_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM ACTION='penjualan.php?mode=J1D05' METHOD='post'>
			<DIV style='overflow:auto;width:100%;height:320px;padding-right:-2px;'>		
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
					$tglpnj	=substr($data[tglpnj],-2).substr($data[tglpnj],3,2);
					$no++;
					echo"
					<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
  						<TD><CENTER>$no			</CENTER></TD>
  						<TD><CENTER>$data[nmrpnj]</CENTER></TD>
  						<TD><CENTER>$data[tglpnj]</CENTER></TD>
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
						if (hakakses("J1D05D")==1)
						{
							echo"
							<TD><CENTER><a href='penjualan.php?mode=J1D05&nmrpnj=$data[nmrpnj]&pilihan=detilfull'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
						}
						else
						{
							echo"
							<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
						}
						
						// otorisasi akses edit
						if (hakakses("J1D05E")==1 AND $data[str]=='' AND $prd==$tglpnj)
						{		
							echo"
							<TD><CENTER><a href='penjualan.php?mode=J1D05&nmrpnj=$data[nmrpnj]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";
						}
						else
						{
							echo"
							<TD><CENTER><IMG src='../images/edit_d.gif' 	BORDER='0'></a></CENTER></TD>";
						}	
							
						// otorisasi akses hapus
						if (hakakses("J1D05H")==1 AND $data[str]=='' AND $prd==$tglpnj)
						{		
							echo"
							<TD><CENTER><a href='penjualan.php?mode=J1D05_Hapus&nmrpnj=$data[nmrpnj]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
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
			if (hakakses("J1D05T")==1)
			{
				echo"<INPUT TYPE='button' VALUE='Tambah PENJUALAN' onClick=window.location.href='penjualan.php?mode=J1D05&pilihan=tambah'>";
			}	
		echo"	
		</FORM>";
 	}
	
	// -------------------------------------------------- Item --------------------------------------------------
	function J1D05()
	{
		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';

		// deklarasi java
		echo"
		<SCRIPT TYPE='text/javascript' src='../js/fungsi_INPUT.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' src='../js/ajax.js'></SCRIPT>
        <SCRIPT TYPE='text/javascript' src='../js/ajax-dynamic-list.js'></SCRIPT>";
		
		echo"
		<SCRIPT TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></SCRIPT>";

		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../penjualan/js/J1D05_validasi_tglpnj.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../penjualan/js/J1D05_validasi_nmabrn.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../penjualan/js/J1D05_prd_pnj.js'></SCRIPT>";
		
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
			{ document.f1.tglpnj.focus();
			}
			function sf1()
			{ document.f1.kdebrn.focus();
			}
		</SCRIPT>";		
        
		echo"<SCRIPT TYPE='text/javascript' src='../penjualan/js/J1D05_cektotal.js'></SCRIPT>";
		
		echo"
        <SCRIPT TYPE='text/javascript'>
			var htmlobjek;
			$(document).ready(function()
			{
				//apabila terjadi event onchange terhadap object <SELECT id=kdebrn>
				$('#nmabrn').change(function()
				{
					var hrg = $('#nmabrn').val();
					$.ajax(
					{
						url: '/sister/penjualan/fungsi_khusus/J1D05_pnj.php',
						data: 'nmabrn='+hrg,
						cache: false,
						success: function(msg)
						{
							//jika data sukses diambil dari server kita tampilkan
							//di <SELECT id=hrg>
							$('#hrg').val(msg);
						}
					})
				});
			});
		</SCRIPT>";

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
				$nmrpnj =nomor_pnj($prd);
				$tgl =date("d-m-Y");
				$tglpnj	=substr($tgl,-2).substr($tgl,3,2);
				break;
			case 'edit':
				$isian	='enable';
				$isian2	='enable';
				$tglpnj	=$prd;
				$nmrpnj =nomor_pnj($prd);
				break;
		}		

		if ($pilihan=='detil' or $pilihan=='edit' or $pilihan=='detilfull')
		{
			$nmrpnjB=$_GET['nmrpnj'];
			$query 	="	SELECT 	t_gnrpnj.*
						FROM 	t_gnrpnj
						WHERE 	t_gnrpnj.nmrpnj='". mysql_escape_string($nmrpnjB)."'";
			$result =mysql_query($query);
			$data 	=mysql_fetch_array($result);
		
			$str	=$data[str];
			$nmrpnj	=$data[nmrpnj];
			$tgl	=$data[tglpnj];
			$utk	=$data[utk];			
			$ktr	=$data[ktr];
			$prdB	=tgltoprd($tglpnj);
		}

		// akhir inisiasi parameter
		$query ="	SELECT 		t_dtlpnj.*,t_mstbrn.nmabrn,t_sldbrn.kdebrn
					FROM 		t_dtlpnj,t_mstbrn,t_sldbrn
					WHERE 		t_dtlpnj.nmrpnj='$nmrpnj'		AND 
								t_dtlpnj.kdebrn=t_mstbrn.kdebrn	AND 
								t_dtlpnj.kdebrn=t_sldbrn.kdebrn	AND 
								t_sldbrn.prd=$prd";
		$result= mysql_query($query)	or die (mysql_error());

		echo"
		<BODY onload='sf();'>";
			if($isian=='enable')
				echo"
                <SCRIPT TYPE='text/javascript' src='../penjualan/js/J1D05.js'></SCRIPT>";

			echo"
			<FORM ID='validasi'  METHOD='post' NAME='f1'>";
				
			echo"
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>PENJUALAN</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Nomor Penjualan</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='nmrpnj'
								TYPE		='text' 	
								SIZE		='15' 	
								MAXLENGTH	='15'
								VALUE 		='$nmrpnj'
								id='nmrpnj'
								DISABLED>

						<INPUT TYPE='hidden' 	NAME='prd'				VALUE='$prd'>
						<INPUT TYPE='hidden' 	NAME='cst' 	id='cst'	VALUE=''>
						<INPUT TYPE='hidden' 	NAME='cst1' id='cst1'	VALUE=''>
					
						Tanggal :
						<INPUT TYPE='hidden'id='tglpnj1' 	NAME='tglpnj1' 	VALUE='$tglpnj'>
						<INPUT TYPE='hidden'id='prd' 		NAME='prd'		VALUE='$prd'>
						<INPUT type='hidden' name='kdebrn'id='nmabrn_hidden'>
						<INPUT 	NAME		='hrg'
								TYPE		='hidden'
								SIZE		='12'
								MAXLENGTH	='12'
								VALUE		='$hrg'
								id			='hrg'
								$isian2>
						<INPUT 	NAME		='tglpnj'
								TYPE		='text' 
								SIZE		=10 
								MAXLENGTH	=10 
								VALUE		='$tgl'
								id			='tglpnj'
                                onkeypress	='return enter(this,event)'
                                class      	='tglpnj'
                                onchange	='btu();'
								$isian>
						<SPAN 	ID			='msgbox'
								STYLE		='display:none'>
						</SPAN>";

						if ($isian=='enable')		
						{ 
							echo"
							<IMG onClick='WdatePicker({el:tglpnj});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle'>";
						}	
					echo"
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
								CLASS		='nmabrn' 
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
							<INPUT TYPE='submit'  	id='submitp'				VALUE='Input'> ";
							if($isian=='enable')
							{
								echo"<INPUT TYPE='hidden' NAME='mode'	VALUE='J1D05_Save'>";
								if($pilihan=='edit')
									echo"
									<INPUT TYPE='hidden' 	id='edt' NAME='pilihan'	VALUE='edit'>
									<INPUT TYPE='hidden' 	id='nmrpnjB'NAME='nmrpnjB'	VALUE='$nmrpnj'>";
								else
									echo"
									<INPUT TYPE='hidden' NAME='pilihan'	VALUE='tambah'>";
							}
							else
								echo"
								<INPUT TYPE='hidden' 	NAME='mode'		VALUE='J1D05_Save_Item'>
								<INPUT TYPE='hidden' 	NAME='nmrpnj'	VALUE='$nmrpnj'>";
						}		
						echo"
						<SPAN 	ID			='msgbox1'  
								STYLE		='display:none'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM id='validasi' >
			<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
				<TR bgcolor='dedede'>
  					<TD WIDTH=' 5%' HEIGHT='20'><CENTER>No				</CENTER></TD>
  					<TD WIDTH='10%'><CENTER>Kode  			</CENTER></TD>
  					<TD WIDTH='41%'><CENTER>Nama Barang		</CENTER></TD>
  					<TD WIDTH='15%'><CENTER>Harga @ (Rp.)	</CENTER></TD>
       				<TD WIDTH='12%'><CENTER>Quantity		</CENTER></TD>
       				<TD WIDTH='12%'><CENTER>Total (Rp.)		</CENTER></TD>
  					<TD WIDTH=' 5%'><CENTER>Hapus			</CENTER></TD>
				</TR>
            <TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' id='stok' >";
				$no=0;
                while($data =mysql_fetch_array($result))
				{
					$hr		=$data['hrg'];
					$bny	=$data['bny'];
					$total	=$hr*$bny;
					$tl[]	=$total;
					$ntotal	=number_format($total);
					$total1	=array_sum($tl);
					$subtotal=number_format($total1);
					$hrgt	=number_format($hr);
					$bny	=number_format($bny);
					$no++;
					echo"
					<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
  						<TD WIDTH=' 5%'><CENTER>$no				</CENTER></TD>
  						<TD WIDTH=' 10%'><CENTER>$data[kdebrn]	</CENTER></TD>
  						<TD WIDTH=' 41%'><CENTER>$data[nmabrn]	</CENTER></TD>
  						<TD WIDTH=' 15%'><CENTER>$hrgt			</CENTER></TD>
						<TD WIDTH=' 12%'><CENTER>$bny			</CENTER></TD>
                        <TD WIDTH=' 12%'><CENTER>$ntotal		</CENTER></TD>";
						// otorisasi akses detil
						
						// otorisasi akses hapus
						if (hakakses("J1D05H")==1 and $pilihan!='detilfull')
						{		
							echo"
							<TD WIDTH=' 5%'><CENTER><a href='#' id='$data[id]'bny='$data[bny]'class='hapus1'><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
						}
						else	
						{
							echo"
							<TD WIDTH=' 5%'><CENTER><IMG src='../images/hapus_d.gif' BORDER='0'></a></CENTER></TD>";
						}
					echo"
					</TR>";
				}
				$i++;
				echo"
				<SCRIPT TYPE='text/javascript' src='../penjualan/js/J1D05_hapus.js'></SCRIPT>";
					if($pilihan=='tambah')
						echo"
						<div class='total'><span id='total'>0</span></div>
						<div class='total1'>Rp.</div>";
					else
						echo"
						<div class='total' id='total'>$subtotal</div>
						<div class='total1'>Rp.</div>";
			echo"
			</TABLE>
			<BR>";
			// otorisasi akses tambah
			if (hakakses("J1D05T")==1 and ($pilihan=='detil' or $pilihan=='detilfull' or $pilihan=='tambah' or $pilihan=='edit'))
			{
				echo"
				<INPUT TYPE='button' VALUE='Tambah PENJUALAN' onClick=window.location.href='penjualan.php?mode=J1D05&pilihan=tambah'>";
			}	
			if (hakakses("J1D05E")==1 and ($pilihan=='detil' or $pilihan=='detilfull') and $str=='' and $prd==$prdB)
			{
				echo"
				<INPUT TYPE='button' VALUE='Edit' onClick=window.location.href='penjualan.php?mode=J1D05&pilihan=edit&nmrpnj=$nmrpnj'>";
			}	
			if (hakakses("J1D05H")==1 and ($pilihan=='detil' or $pilihan=='detilfull') and $str=='' and $prd==$prdB)
			{
				echo"
				<INPUT TYPE='button' VALUE='Hapus' onClick=window.location.href='penjualan.php?mode=J1D05_Hapus&nmrpnj=$nmrpnj'>";
			}	
			if ($pilihan=='detil' or $pilihan=='detilfull'or $pilihan=='tambah')
			{
				echo"
				<INPUT TYPE='button' VALUE='Cetak' 	onClick=window.open('pendataan/J1D05_C01.php?nmrpnj=$nmrpnj')>";
			}	
			echo"
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='penjualan.php?mode=J1D05_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>";
		echo"	
		</FORM>
		</BODY>";
	}		

	// -------------------------------------------------- Hapus --------------------------------------------------
	function J1D05_Hapus()
	{
		$pilihan=$_POST['pilihan'];
		if ($pilihan=='hapus')
		{
			$nmrpnj	=$_POST['nmrpnj'];
		}
		else
		{
			$nmrpnj	=$_GET['nmrpnj'];
		}	
		$prd 	=periode("PENJUALAN");
		
		$query 		="	SELECT 	t_dtlpnj.*
						FROM 	t_dtlpnj
						WHERE 	t_dtlpnj.nmrpnj='". mysql_escape_string($nmrpnj)."'";
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
					FROM 	t_gnrpnj
					WHERE 	t_gnrpnj.nmrpnj='". mysql_escape_string($nmrpnj)."'";
		$result	=mysql_query($query) or die ("Query failed - Mysql");
		
		$query	="	DELETE 
					FROM 	t_dtlpnj
					WHERE 	t_dtlpnj.nmrpnj	='". mysql_escape_string($nmrpnj)."'";
		$result	=mysql_query($query) or die ("Query failed - Mysql");
				
		echo"<meta http-equiv='refresh' content=\"0;url=penjualan.php?mode=J1D05_Cari\">\n";
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function J1D05_Save()
	{
		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';

  		$nmrpnjB=$_POST['nmrpnjB'];
		$str	=$_POST['str'];
  		$nmrpnj	=$_POST['nmrpnj'];
		$utk	=$_POST['utk'];
  		$tglpnj	=$_POST['tglpnj'];
		
  		$pilihan=$_POST['pilihan'];
		$kdeusr =$_SESSION['Admin']['username'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");
		$prd 	=periode("PENJUALAN");

		if ($pilihan=='tambah')
		{
			$nmrpnj = nomor_pnj($prd);
		}	
		$set	="	SET		t_gnrpnj.nmrpnj	='". mysql_escape_string($nmrpnj)."',
							t_gnrpnj.tglpnj	='". mysql_escape_string($tglpnj)."',
							t_gnrpnj.utk	='". mysql_escape_string($utk)."',
							t_gnrpnj.kdeusr	='". mysql_escape_string($kdeusr)."',
							t_gnrpnj.tglrbh	='". mysql_escape_string($tglrbh)."',
							t_gnrpnj.jamrbh	='". mysql_escape_string($jamrbh)."'";		
		
  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	t_gnrpnj ".$set.
					 "	WHERE 	t_gnrpnj.nmrpnj	='". mysql_escape_string($nmrpnjB)."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
        }
  		else
  		{
  			$query 	="	INSERT INTO t_gnrpnj ".$set;
			$result =mysql_query ($query) or die (error("Data tidak berhasil di INPUT"));
  		}
 	}
	
	// -------------------------------------------------- Save Item --------------------------------------------------
	function J1D05_Save_Item()
	{
		$nmrpnj	=$_POST['nmrpnj'];
		$kdebrn	=$_POST['kdebrn'];
		$bny	=str_replace(",","",$_POST['bny']);
		$hrg	=str_replace(",","",$_POST['hrg']);
		$prd	=periode('PENJUALAN');

		$query 	=mysql_query("	SELECT 	*,t_mstbrn.nmabrn
								FROM 	t_dtlpnj,t_mstbrn
								WHERE 	t_dtlpnj.nmrpnj = '$nmrpnj' AND
										t_dtlpnj.kdebrn = '$kdebrn'");
		$result =mysql_fetch_assoc($query);
		$bnyawl	=$result['bny'];
		if(mysql_num_rows($query) == "")
		{
			$query 	="	INSERT INTO t_dtlpnj
						SET			t_dtlpnj.nmrpnj	='". mysql_escape_string($nmrpnj)."',
									t_dtlpnj.kdebrn	='". mysql_escape_string($kdebrn)."',
									t_dtlpnj.bny	='". mysql_escape_string($bny)."',
                                    t_dtlpnj.hrg	='". mysql_escape_string($hrg)."'";
		}
		else
		{
			$query 	="	UPDATE 	t_dtlpnj
						SET		t_dtlpnj.bny	='". mysql_escape_string($bny+$bnyawl)."'
						WHERE 	t_dtlpnj.nmrpnj	='". mysql_escape_string($nmrpnj)."'	AND
								t_dtlpnj.kdebrn	='". mysql_escape_string($kdebrn)."'";
		}
		$result	=mysql_query ($query) or die(error("Data tidak berhasil di INPUT")) ;

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
		$result =mysql_query($query) or die(error("Data tidak berhasil di INPUT")) ;
 	}
}//akhir class
?>