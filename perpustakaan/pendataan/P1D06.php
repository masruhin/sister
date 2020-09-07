<?php
//----------------------------------------------------------------------------------------------------
//Program		: P1D06.php
//Sumber		: sister
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi PEMINJAMAN
//----------------------------------------------------------------------------------------------------
//	PEMINJAMAN BUKU
//	perpustakaan
//		pendataan
//			peminjaman Guru
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class P1D06class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function P1D06_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";

		$nmrpjm	=$_GET['nmrpjm'];
		$tglpjm	=$_GET['tglpjm'];
		$kdeang	=$_GET['kdeang'];

		$query2 ="	SELECT 		t_gnrpjm.*,t_mstkry.*,t_sttkry.*
					FROM 		t_gnrpjm,t_mstkry,t_sttkry
					WHERE 		(t_gnrpjm.nmrpjm LIKE'%".$nmrpjm."%' OR '$nmrpjm'='')	AND
								(t_gnrpjm.tglpjm LIKE'%".$tglpjm."%' OR '$tglpjm'='') 	AND
								(t_gnrpjm.kdeang LIKE'%".$kdeang."%' OR '$kdeang'='')	AND
								t_mstkry.kdekry = t_gnrpjm.kdeang						AND
								t_mstkry.kdestt	= t_sttkry.kdestt
					ORDER BY 	t_gnrpjm.nmrpjm";
		$result	= mysql_query($query2)	or die (mysql_error());

		echo"
		<FORM ACTION=perpustakaan.php METHOD='get' NAME='f1'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>PEMINJAMAN GURU</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Nomor Peminjaman</TD>
  					<TD WIDTH='85%'>:
						<INPUT 	NAME		='nmrpjm'
								TYPE		='text'
								SIZE		='15'
								MAXLENGTH	='15'
								id			='nmrpjm'
								VALUE		='$nmrpjm'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'>
					</TD>
  				</TR>
				<TR><TD>Peminjam</TD>
					<TD>:
						<INPUT 	NAME		='kdeang'
								TYPE		='text'
								SIZE		='10'
								MAXLENGTH	='10'
								id			='kdeang'
								value		='$kdeang'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'>
					</TD>
				</TR>
				<TR><TD>Tanggal Peminjaman</TD>
					<TD>:
						<INPUT 	NAME		='tglpjm'
								TYPE		='text'
								SIZE		='10'
								MAXLENGTH	='10'
								id			='tglpjm'
								value		='$tglpjm'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'>
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='P1D06_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='perpustakaan.php?mode=P1D06_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>

		<FORM ACTION='perpustakaan.php?mode=P1D06' METHOD='post'>
			<DIV style='overflow:auto;width:100%;height:340px;padding-right:-2px;'>		
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No			</CENTER></TD>
						<TD WIDTH='20%'><CENTER>Nomor Bukti </CENTER></TD>
						<TD WIDTH='12%'><CENTER>Tanggal	Peminjaman</CENTER></TD>
						<TD WIDTH='12%'><CENTER>Tanggal	Pengembalian</CENTER></TD>
						<TD WIDTH='48%'><CENTER>Peminjam	</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Detil		</CENTER></TD>
					</TR>";

					$no=0;
					while($data =mysql_fetch_array($result))
					{
						$tglpjm	=substr($data[tglpjm],-2).substr($data[tglpjm],3,2);
						$query1 = mysql_query("SELECT * FROM t_setprp");
						$result1 = mysql_fetch_array($query1);
						$setprp  = $result1['nli'];
						
						$tglpjm = date('d-m-Y',strtotime("+$setprp day",strtotime($data['tglpjm'])));
						
						$no++;
						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
							<TD><CENTER>$no				</CENTER></TD>
							<TD><CENTER>$data[nmrpjm]	</CENTER></TD>
							<TD><CENTER>$data[tglpjm]	</CENTER></TD>
							<TD><CENTER>$tglpjm</CENTER></TD>
							<TD>$data[nmakry] ($data[kdekry] - $data[nmastt])</TD>";
							// otorisasi akses detil
							if (hakakses("P1D06D")==1)
							{
								echo"
								<TD><CENTER><a href='perpustakaan.php?mode=P1D06&nmrpjm=$data[nmrpjm]&pilihan=detilfull'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
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
			<BR>";
			// otorisasi akses tambah
			if (hakakses("P1D06T")==1)
			{
				echo"<INPUT TYPE='button' VALUE='Tambah PEMINJAMAN' onClick=window.location.href='perpustakaan.php?mode=P1D06&pilihan=tambah'>";
			}
		echo"
		</FORM>";
 	}
	
	// -------------------------------------------------- Item --------------------------------------------------
	function P1D06()
	{
		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';

		// deklarasi java
		echo"
		<SCRIPT TYPE='text/javascript' src='../js/ajax.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' src='../js/ajax-dynamic-list.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";
		
		echo"<SCRIPT TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></SCRIPT>";

		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../perpustakaan/js/P1D06_validasi_bkupjm.js'></SCRIPT>";
		
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
		//agar kursor keposisi isian kode buku
		function sf()
			{ 
				//document.f1.tglpjm.focus();
				document.f1.kdeang.focus();
			}
		</SCRIPT>
		
		<SCRIPT>
		function sw()
		{ 
			
		}
		</SCRIPT>
		";
		
		/*
		<SCRIPT>
		function sw()
		{ 
			formObj = document.f1;
			if ((formObj.stt.value =='S'))
			{
				//formObj.stt.value='S';
				//formObj.stt1.value='Siswa';
			}
			else
			{
				//formObj.stt.value='N';
				//formObj.stt1.value='Non Siswa';
			}
		}
		</SCRIPT>
		*/

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
				$isian2	='enable';
				break;
			case 'detilfull':
				$isian 	='disabled';
				$isian2	='disabled';
				break;
			case 'tambah':
				$isian	='enable';
				$isian2	='enable';
				$nmrpjm =nomor_pjm();
				$tgl =date("d-m-Y");
				$tglpjm	=substr($tgl,-2).substr($tgl,3,2);
				break;
		}

		if ($pilihan=='detil' or $pilihan=='detilfull')
		{
			$query 	="	SELECT 	t_setprp.*
						FROM 	t_setprp
						WHERE	t_setprp.set LIKE'%".'Batas'."%'"; // -- batas peminjaman, mis : 7 hari
			$result =mysql_query($query);
			$data 	=mysql_fetch_array($result);
			$bts	=$data[nli];
		
			$nmrpjmB=$_GET['nmrpjm'];
			$query 	="	SELECT 	*,t_mststt.nmastt
						FROM 	t_gnrpjm,t_mststt
						WHERE 	t_gnrpjm.nmrpjm='". mysql_escape_string($nmrpjmB)."'AND
                                t_gnrpjm.stt=t_mststt.kdestt"; // -- utk. mendapatkan nama status || cek nomor peminjaman & nama status (Siswa / Non Siswa)
			$result =mysql_query($query);
			$data 	=mysql_fetch_array($result);

			$nmrpjm	=$data[nmrpjm];
			$tgl	=$data[tglpjm];
			$kdeang	=$data[kdeang];
			$nmastt	=$data[nmastt];
			$jdwpb  =date('d-m-Y',strtotime($tgl."+$bts day"));
		}
		
		$query2 ="	SELECT 		t_dtlpjm.*,t_mstbku.jdl
					FROM 		t_dtlpjm,t_mstbku
					WHERE 		t_dtlpjm.nmrpjm='$nmrpjm'AND
								t_dtlpjm.kdebku=t_mstbku.kdebku"; // -- utk. mendapatkan judul buku || cek nomor peminjaman & kode buku
		$result= mysql_query($query2)	or die (mysql_error());
		
		/*
					<TR><TD WIDTH='15%'>Nomor Peminjaman</TD>
						<TD WIDTH='67%'>:
							<INPUT 	NAME		='nmrpjm'
									TYPE		='text'
									SIZE		='15'
									MAXLENGTH	='15'
									VALUE 		='$nmrpjm'
									id			='nmrpjm'
									DISABLED>
						</TD>
						<TD WIDTH='5%'>Tanggal</TD>
						<TD WIDTH='13%'>:       
							
							<INPUT type='hidden' name='kdeang1' VALUE=''id='kdeang1'>
							<INPUT type='hidden' name='tglkmb' VALUE=''id='tglkmb'>
							<INPUT 	NAME		='tglpjm'
									TYPE		='text'
									SIZE		=10
									MAXLENGTH	=10
									VALUE		='$tgl'
									id		='tglpjm'
									>
						</TD>
					</TR>
		
		asli nya tanggal :
		
		<INPUT type='hidden' name='tglpjm' VALUE='$tgl'id='tglpjm'>
							<INPUT type='hidden' name='kdeang1' VALUE=''id='kdeang1'>
							<INPUT type='hidden' name='tglkmb' VALUE=''id='tglkmb'>
							<INPUT 	NAME		='tglpjm1'
									TYPE		='text'
									SIZE		=10
									MAXLENGTH	=10
									VALUE		='$tgl'
									id		='tglpjm1'
									DISABLED>
		
		<INPUT 	NAME		='stt1'
									ID			='stt1'
									SIZE		='10'
									MAXLENGTH	='10'
									onkeypress	='return enter(this,event)'
									VALUE		='$nmastt'
									$isian2>
		*/
		
		echo"
		<BODY onload='sf()'>
			<SCRIPT TYPE='text/javascript' src='../perpustakaan/js/P1D06.js'></SCRIPT>
			<FORM ID='validasi'  METHOD='post' NAME='f1'>
			
				<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
					<TR><TD><B>PEMINJAMAN GURU</B></TD></TR>
					<TR></TR><TR></TR>
					<TR><TD WIDTH='15%'>Nomor Peminjaman</TD>
						<TD WIDTH='67%'>:
							<INPUT 	NAME		='nmrpjm'
									TYPE		='text'
									SIZE		='15'
									MAXLENGTH	='15'
									VALUE 		='$nmrpjm'
									id			='nmrpjm'
									DISABLED>
						</TD>
					</tr>
					<tr>
						<TD WIDTH='5%'>Tanggal Peminjaman</TD>
						<TD WIDTH='13%'>:       
							
							<INPUT type='hidden' name='kdeang1' VALUE=''id='kdeang1'>
							<INPUT type='hidden' name='tglkmb' VALUE=''id='tglkmb'>
							<INPUT 	NAME		='tglpjm'
									TYPE		='text'
									SIZE		=10
									MAXLENGTH	=10
									VALUE		='$tgl'
									id		='tglpjm'
									/>
						</TD>
					</TR>
					<TR><TD>Kode Peminjam</TD>
						<TD>:   
							<INPUT 	type='hidden' name='kode' 	id='kode'>
							<INPUT 	type='hidden' name='stt' 	id='stt' value='N' />
							<INPUT 	NAME		='kdeang'
									ID			='kdeang'
									TYPE		='text'
									SIZE		='10'
									MAXLENGTH	='10'
									VALUE		='$kdeang'
									onkeyup		='uppercase(this.id)'
									onkeypress	='return enter(this,event)'
									onchange    =sw();
									CLASS		='kdeang'
									TITLE		='...harus diisi'
									$isian2>";
							if($pilihan=='tambah')
							{
								echo"
								<input 	type		='text'
										ID			='nmasw'
										NAME		='nmasw'
										SIZE		=50
										MAXLENGTH	=50
										readonly/>";
							}
						echo"
						</TD>
					</TR>
					<TR><TD>Status Peminjam</TD>
						<TD>:
							<INPUT 	NAME		='stt1'
									ID			='stt1'
									SIZE		='10'
									MAXLENGTH	='10'
									onkeypress	='return enter(this,event)'
									VALUE		='Non Siswa'
									>
						</TD>
					</TR>
					<TR><TD>Kode buku</TD>
						<TD>:
							<INPUT 	NAME		='kdebku'
									ID			='kdebku'
									TYPE		='text'
									SIZE		='25'
									MAXLENGTH	='25'
									CLASS		='kdebku'
									onkeyup		='uppercase(this.id)'
									TITLE		='...harus diisi'
									$isian>
							<span id='msgbox'  style='display:none'></span>";
							if ($pilihan!='detilfull')
							{
								if($isian=='enable')
								{
									echo"<INPUT TYPE='hidden' NAME='mode'		VALUE='P1D06_Save'>";
									echo"<INPUT TYPE='hidden' NAME='pilihan'	VALUE='tambah'>";
								}
								else
									echo"
									<INPUT TYPE='hidden' 	NAME='mode'		VALUE='P1D06_Save_Item'>
									<INPUT TYPE='hidden' 	NAME='nmrpjm'	VALUE='$nmrpjm'>";
							}
						echo"
						</TD>
					</TR>
				</TABLE>
			</FORM>

			<FORM id='validasi'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No		</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Kode  				</CENTER></TD>
						<TD WIDTH='76%'><CENTER>Nama buku			</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Jadwal Kembali		</CENTER></TD>
					</TR>
					<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' id='pjm'>";
					$no=0;
					while($data =mysql_fetch_array($result))
					{
						$no++;
						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
							<TD WIDTH=' 4%' HEIGHT='20'><CENTER>$no	</CENTER></TD>
							<TD WIDTH='10%'><CENTER>$data[kdebku]	</CENTER></TD>
							<TD WIDTH='76%'>$data[jdl]</TD>
							<TD WIDTH='10%'><CENTER>$jdwpb			</CENTER></TD>
					</TR>";
					}
				echo"
				</TABLE>
				<BR>";
				// otorisasi akses tambah
				if (hakakses("P1D06T")==1 and ($pilihan=='detil' or $pilihan=='detilfull'))
				{
					echo"
					<INPUT TYPE='button' VALUE='Tambah PEMINJAMAN' onClick=window.location.href='perpustakaan.php?mode=P1D06&pilihan=tambah'>";
				}
				if ($pilihan=='detil' or $pilihan=='detilfull')
				{
					echo"
					<INPUT TYPE='button' VALUE='Cetak' 	onClick=window.open('pendataan/P1D06_Cetak.php?nmrpjm=$nmrpjm')>";
				}
				echo"
				<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='perpustakaan.php?mode=P1D06_Cari'>
				<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
			</FORM>
		</BODY>";
	}		

	// -------------------------------------------------- Save --------------------------------------------------
	function P1D06_Save()
	{
        require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';

		//User acces//
        $kdeusr =$_SESSION['Admin']['username'];
		$tglrbh =date("d-m-Y");
		$jamrbh	=date("h:i:s");
  		//end User acces//
		
		$userid_x	=$_SESSION["Admin"]["userid"];	// buatan d $userid_x

  		$nmrpjmB=$_POST['nmrpjmB'];
  		$nmrpjm	=$_POST['nmrpjm'];
  		$tglpjm	=$_POST['tglpjm'];
  		$stt	=$_POST['stt'];
		$kdeang	=$_POST['kdeang'];
  		$pilihan=$_POST['pilihan'];

		if ($pilihan=='tambah')
		{
			$nmrpjm = nomor_pjm();
		}
		
		$set	="	SET	t_gnrpjm.str	='',
						t_gnrpjm.nmrpjm	='". mysql_escape_string($nmrpjm)."',
						t_gnrpjm.tglpjm	='". mysql_escape_string($tglpjm)."',
						t_gnrpjm.stt	='N',
						t_gnrpjm.kdeang	='". mysql_escape_string($kdeang)."',
						t_gnrpjm.kdeusr	='". mysql_escape_string($userid_x)."',
						t_gnrpjm.tglrbh	='". mysql_escape_string($tglrbh)."',
						t_gnrpjm.jamrbh	='". mysql_escape_string($jamrbh)."'"; // t_gnrpjm.kdeusr	='". mysql_escape_string($kdeusr)."',	|| diubah buatan d $userid_x
		
		// ". mysql_escape_string($stt)."
		
		$query =mysql_query("	SELECT 		*
						FROM 		t_mstkry
						WHERE 		t_mstkry.kdekry='$kdeang'");
		
		if(mysql_num_rows($query)=='0')
		{
			echo
				"<SCRIPT LANGUAGE='JavaScript'>
					window.alert(' ".$kdeang." bukan kode siswa  ');
				</SCRIPT>";
		}
		else
		{
			$query 	="	INSERT INTO t_gnrpjm ".$set;  
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
		}
		
		//..sampai sini
 	}

	// -------------------------------------------------- Save Item --------------------------------------------------
	function P1D06_Save_Item()
	{
        $nmrpjm	=$_POST['nmrpjm'];
        $kdeang	=$_POST['kdeang1'];
		$kdebku	=$_POST['kdebku'];
        $tglkmb	=$_POST['tglkmb'];

		$query 	=mysql_query("	SELECT 		kdeang,kdebku,tglkmb 
								FROM  		t_gnrpjm
								INNER JOIN 	t_dtlpjm 
								ON 			t_gnrpjm.nmrpjm=t_dtlpjm.nmrpjm
								WHERE   	t_gnrpjm.kdeang='$kdeang' 	AND  
											t_dtlpjm.kdebku='$kdebku'	AND 
											t_dtlpjm.tglkmb='$tglkmb' 
								ORDER BY 	kdebku");
        while($data =mysql_fetch_array($query))
        {
			$kdeangB=$data['kdeang'];
			$kdebkuB=$data['kdebku'];
			$tglkmbB=$data['tglkmb'];
			$nmrpjmB=$data['nmrpjm'];
        }
		if(mysql_num_rows($query)=='0')
		{
			
			$query =mysql_query("	SELECT 		*
						FROM 		t_mstkry
						WHERE 		t_mstkry.kdekry='$kdeang'");
		
			if(mysql_num_rows($query)=='0')
			{
				echo
					"<SCRIPT LANGUAGE='JavaScript'>
						window.alert(' ".$kdeang." bukan kode siswa  ');
					</SCRIPT>";
			}
			else
			{
				$query 	="	INSERT INTO t_dtlpjm
						SET			t_dtlpjm.nmrpjm	='". mysql_escape_string($nmrpjm)."',
									t_dtlpjm.kdebku	='". mysql_escape_string($kdebku)."',
									t_dtlpjm.tglkmb	='". mysql_escape_string($tglkmb)."',
									t_dtlpjm.dnd	='0'";
				$result =mysql_query ($query)or die(error("Data tidak berhasil di Input"));
			}
			
		}
		else
		{
			echo
			"<SCRIPT LANGUAGE='JavaScript'>
				window.alert('Anda Sudah Meminjam Buku dengan kode ".$kdeangB." ".$tglkmbB."')
			</SCRIPT>";
		}
 	}
}//akhir class
?>