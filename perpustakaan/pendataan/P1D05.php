<?php
//----------------------------------------------------------------------------------------------------
//Program		: P1D05.php
//Sumber		: sister
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi PENGEMBALIAN BUKU
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class P1D05class
{
	// -------------------------------------------------- Item --------------------------------------------------
	function P1D05()
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
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>";
		$tgl =date("d-m-Y");

		echo"
		<SCRIPT language='javascript'>
		//agar kursor keposisi isian kode buku
		function sf()
		{ 
			//document.f1.tglkmb.focus();
			document.f1.kdeang.focus();
		}
		</SCRIPT>";
		
		/*
						<INPUT type='hidden' name='tglkmb' 	VALUE='$tgl'	id='tglkmb'>
		
						<TD WIDTH='5%'>Tanggal</TD>
						<TD WIDTH='13%'>:
							<INPUT 	NAME		='tglpjm1'
									TYPE		='text'
									SIZE		=10
									MAXLENGTH	=10
									VALUE		='$tgl'
									ID			='tglpjm1'
									readonly/>
						</TD>
		*/

		echo"
		<BODY onload='sf()'>
			<SCRIPT TYPE='text/javascript' src='../perpustakaan/js/P1D05.js'></SCRIPT>
			<FORM ID='validasi'  METHOD='post' NAME='f1' >
				<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
					<TR><TD><B>PENGEMBALIAN BUKU</B></TD></TR>
					<TR></TR><TR></TR>
					<TR><TD>Tanggal</TD>
						<TD>:
							<INPUT 	NAME		='tglkmb'
									TYPE		='text'
									SIZE		=10
									MAXLENGTH	=10
									VALUE		='$tgl'
									ID			='tglkmb'
									/>
						</TD>
					</TR>
					<TR><TD WIDTH='15%'>Kode Peminjam</TD>
						<TD WIDTH='67%'>:
							
							<INPUT type='hidden' name='kdeang1' VALUE=''		id='kdeang1'>

							<INPUT 	NAME		='kdeang'
									TYPE		='text'
									SIZE		='10'
									MAXLENGTH	='10'
									VALUE 		='$kdeang'
									onkeyup		='uppercase(this.id)'
									onkeypress	='return enter(this,event)'
									CLASS		='kdeangp'
									ID			='kdeang'>
							<input 	type		='text'
									ID			='nmassw'
									NAME		='nmasw'
									SIZE		=50
									MAXLENGTH	=50
									readonly/>
						</TD>
						<TD WIDTH='5%'></TD>
						<TD WIDTH='13%'>
											<INPUT type='hidden' name='tglpjm1' 	VALUE='$tgl'	id='tglpjm1'>
						</TD>
					</TR>
					<TR><TD>Status Peminjam</TD>
						<TD>:
							<INPUT 	NAME		='stt'
									TYPE		='text'
									SIZE		=10
									MAXLENGTH	=10
									VALUE		=''
									ID			='stt'>
						</TD>
					</TR>
					<TR><TD>Kode buku</TD>
						<TD>:
							<INPUT 	NAME		='kdebku'
									ID			='kdebku'
									TYPE		='text'
									SIZE		='25'
									MAXLENGTH	='25'
									onkeyup		='uppercase(this.id)'
									CLASS		='kdebk'
									TITLE		='...harus diisi'>
						</TD>
					</TR>
				</TABLE>
			</FORM>

			<FORM id='validasi'>
				<DIV style='overflow:auto;width:100%;height:320px;padding-right:-2px;'>		
					<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
						<TR bgcolor='dedede'>
							<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No		</CENTER></TD>
							<TD WIDTH='10%'><CENTER>No Peminjaman  		</CENTER></TD>
							<TD WIDTH='10%'><CENTER>Kode  				</CENTER></TD>
							<TD WIDTH='56%'><CENTER>Nama buku			</CENTER></TD>
							<TD WIDTH='10%'><CENTER>Jadwal Kembali</CENTER></TD>
							<TD WIDTH='10%'><CENTER>Dikembalikan		</CENTER></TD>
						</TR>
						<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' id='pjm1'>
						</TABLE>
				</DIV>
				<BR>
				<INPUT TYPE='button' 	VALUE='Pengembalian Lain' 	onClick=window.location.href='perpustakaan.php?mode=P1D05'>
			</FORM>
		</BODY>";
	}		
}//akhir class
?>