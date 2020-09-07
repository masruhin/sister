<?php
//----------------------------------------------------------------------------------------------------
//Program		: P1D02.php
//Sumber		: sister
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi BUKU
//----------------------------------------------------------------------------------------------------
// MASTER BUKU
//		perpustakaan
//			pendataan
//				buku
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class P1D02class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function P1D02_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdebku	=$_GET['kdebku'];
		$jdl	=$_GET['jdl'];
		$png	=$_GET['png'];
		
		$userid_x	=$_SESSION["Admin"]["userid"];	// buatan d $userid_x
		
		$query='';
		if( $userid_x=='66' OR $userid_x=='85' ) // staff perpus
		{
			$query ="	SELECT 		t_mstbku.*,t_ktg.nmaktg 
						FROM 		t_mstbku,t_ktg
						WHERE 		(t_mstbku.kdebku 	LIKE'%".$kdebku."%' OR '$kdebku'='')	AND
									(t_mstbku.jdl 		LIKE'%".$jdl."%' 	OR '$jdl'='')		AND
									(t_mstbku.png 		LIKE'%".$png."%' 	OR '$png'='')		AND
									t_mstbku.kdektg=t_ktg.kdektg AND t_mstbku.lvl = '".$userid_x."'
						ORDER BY 	t_mstbku.kdebku"; // AND t_mstbku.lvl = '".$userid_x."' buatan d $userid_x
		}
		else
		{
			$query ="	SELECT 		t_mstbku.*,t_ktg.nmaktg 
						FROM 		t_mstbku,t_ktg 
						WHERE 		(t_mstbku.kdebku 	LIKE'%".$kdebku."%' OR '$kdebku'='')	AND
									(t_mstbku.jdl 		LIKE'%".$jdl."%' 	OR '$jdl'='')		AND
									(t_mstbku.png 		LIKE'%".$png."%' 	OR '$png'='')		AND
									t_mstbku.kdektg=t_ktg.kdektg
						ORDER BY 	t_mstbku.kdebku"; // t_mstbku.kdektg,t_mstbku.jdl
		}
		$result= mysql_query($query)	or die (mysql_error());
		
		
		
		echo"
		<FORM ACTION=perpustakaan.php METHOD='get'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>BUKU</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='15%'>Kode Buku</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdebku'	
								ID			='kdebku'	
								TYPE		='text' 		
								SIZE		='25' 
								MAXLENGTH	='25'
								onkeyup		='uppercase(this.id)'>
					</TD>
				</TR>
				<TR><TD>Judul</TD>
					<TD>: 
						<INPUT 	NAME		='jdl'	
								ID			='jdl'	
								TYPE		='text' 		
								SIZE		='50' 
								MAXLENGTH	='50'
								onkeyup		='uppercase(this.id)'>
					</TD>
				</TR>
				<TR><TD>Pengarang</TD>
					<TD>: 
						<INPUT 	NAME		='png'	
								ID			='png'	
								TYPE		='text' 		
								SIZE		='50' 
								MAXLENGTH	='50'
								onkeyup		='uppercase(this.id)'>
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='P1D02_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='perpustakaan.php?mode=P1D02_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM ACTION='perpustakaan.php?mode=P1D02' METHOD='post'>
			<DIV style='overflow:auto;width:100%;height:320px;padding-right:-2px;'>		
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No				</CENTER></TD>
						<TD WIDTH='15%'><CENTER>Kode 			</CENTER></TD>
						<TD WIDTH='27%'><CENTER>Judul			</CENTER></TD>
						<TD WIDTH='20%'><CENTER>Pengarang		</CENTER></TD>
						<TD WIDTH='12%'><CENTER>Kategori 		</CENTER></TD>
						<TD WIDTH='5%'><CENTER>Stok 			</CENTER></TD><!--Status	10%-->
						<TD WIDTH='5%'><CENTER>Perpus 			</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Detil			</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Edit			</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Hapus			</CENTER></TD>
					</TR>";

					$no=0;
					while($data =mysql_fetch_array($result))
					{
						$kdebk=$data[kdebku];
						$level=$data[lvl];
						$no++;
						
						/*$qry = "SELECT * FROM `t_dtlpjm` WHERE kdebku = '$kdebk' AND tglkmb = '' ";
						$rsl= mysql_query($qry)	or die (mysql_error());
						$dta =mysql_fetch_array($rsl);*/
						
						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
							<TD><CENTER>$no				</CENTER></TD>
							<TD><CENTER>$data[kdebku]	</CENTER></TD>
							<TD>$data[jdl]</TD>
							<TD>$data[png]</TD>
							<TD><CENTER>$data[nmaktg]	</CENTER></TD>
							<TD><CENTER>";
								$qr=mysql_query("	select 	t_dtlpjm.* 
													from 	t_dtlpjm
													where 	t_dtlpjm.kdebku='$kdebk'AND
															t_dtlpjm.tglkmb=''");
								$quer=mysql_num_rows($qr);
								$stok=$data[jmlstc]- $quer;
								
								if( $quer=='1' )
									$quer='Sedang dipinjam';
								else if( $quer=='0' )
									$quer='Belum dipinjam';
								
								if( $level=='66' )
									$level='Lt. 2';//Lantai
								else if( $level=='85' )
									$level='Lt. 3';
								
								echo"$quer";//$stok
							echo"
							</CENTER></TD><td align='center'>$level</td>";
							
							// otorisasi akses detil
							if (hakakses("P1D02D")==1)
							{
								echo"
								<TD><CENTER><a href='perpustakaan.php?mode=P1D02&kdebku=$data[kdebku]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
							}
						
							// otorisasi akses edit
							if (hakakses("P1D02E")==1)
							{		
								echo"
								<TD><CENTER><a href='perpustakaan.php?mode=P1D02&kdebku=$data[kdebku]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/edit_d.gif' 	BORDER='0'></a></CENTER></TD>";
							}	
							
							// otorisasi akses hapus
							if (hakakses("P1D02H")==1)
							{		
								echo"
								<TD><CENTER><a href='perpustakaan.php?mode=P1D02_Hapus&kdebku=$data[kdebku]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
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
			if (hakakses("P1D02T")==1)
			{
				echo"<INPUT TYPE='button' VALUE='Tambah' onClick=window.location.href='perpustakaan.php?mode=P1D02&pilihan=tambah'>";
			}	
		echo"	
		</FORM>";
 	}

	// -------------------------------------------------- Detil --------------------------------------------------
	function P1D02()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	

		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../perpustakaan/js/P1D02_validasi_kdebku.js'></SCRIPT>";
		
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
			$kdebkuB=$_GET['kdebku'];
			$query 	="	SELECT 	t_mstbku.*,t_ktg.nmaktg 
						FROM 	t_mstbku,t_ktg  
						WHERE 	t_mstbku.kdebku='". mysql_escape_string($kdebkuB)."' 	AND
								t_mstbku.kdektg=t_ktg.kdektg";
			$result =mysql_query($query);
			$data 	=mysql_fetch_array($result);
		
			$kdektg	=$data[kdektg];
			$kdebku	=$data[kdebku];
			$jdl	=$data[jdl];
			$png	=$data[png];
			$pnr	=$data[pnr];
			$thntrb	=$data[thntrb];
			$jns	=$data[jns];
			$jmlstc	=$data[jmlstc];
			$cvr	=$data[cvr];
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='perpustakaan.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD WIDTH='15%'><B>BUKU</B></TD>
					<TD WIDTH='75%'></TD>
					<TD WIDTH='10%' COLSPAN='1' ROWSPAN='7' ALIGN='right'><IMG src='../files/photo/buku/$kdebku.jpg' HEIGHT='130' WIDTH='110'></TD>
				</TR>
				<TR></TR><TR></TR>
				<TR><TD>Kategori</TD>
					<TD>: 
						<SELECT	NAME		='kdektg'	
								VALUE 		='$kdektg'
								onkeypress	='return enter(this,event)'
								$isian>";
						$query	="	SELECT 		t_ktg.* 
									FROM 		t_ktg  
									ORDER BY 	t_ktg.kdektg";
    					$result=mysql_query($query);
    					while($data=mysql_fetch_array($result))
    					{
							if ($kdektg==$data[kdektg]) 
								echo"<OPTION VALUE='$data[kdektg]' SELECTED>$data[nmaktg]</OPTION>";
  	  						else 
								echo"<OPTION VALUE='$data[kdektg]'>$data[nmaktg]</OPTION>";
    					}
       					echo
						"</SELECT>		
					</TD>
				</TR>				
				<TR><TD>Kode Buku</TD>
					<TD>: 
						<INPUT 	NAME		='kdebku'	
								TYPE		='text' 	
								SIZE		='25' 	
								MAXLENGTH	='25'
								VALUE 		='$kdebku'
								id			='kdebku'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								$isian>
						<SPAN 	ID			='msgbox'  
								STYLE		='display:none'>
						</SPAN>
					</TD>
				</TR>
				<TR><TD>Judul</TD>
					<TD>: 
						<INPUT 	NAME		='jdl'	
								TYPE		='text' 
								SIZE		='50' 	
								MAXLENGTH	='50'		
								VALUE		='$jdl'
								id			='jdl'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								$isian>
					</TD>
				</TR>
				<TR><TD>Pengarang</TD>
					<TD>: 
						<INPUT 	NAME		='png'	
								TYPE		='text' 
								SIZE		='50' 	
								MAXLENGTH	='50'		
								VALUE		='$png'
								id			='png'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								$isian>
					</TD>
				</TR>
				<TR><TD>Penerbit</TD>
					<TD>: 
						<INPUT 	NAME		='pnr'	
								TYPE		='text' 
								SIZE		='50' 	
								MAXLENGTH	='50'		
								VALUE		='$pnr'
								id			='pnr'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								$isian>
					</TD>
				</TR>
				<TR><TD>Tahun Terbit</TD>
					<TD>: 
						<INPUT 	NAME		='thntrb'	
								TYPE		='text' 
								SIZE		='4' 	
								MAXLENGTH	='4'		
								VALUE		='$thntrb'
								id			='thntrb'
								onKeyUp		='javascript:checknumber(f1.thntrb);'
								onkeypress	='return enter(this,event)'
								$isian>
					</TD>
				</TR>
				<TR><TD>Jenis</TD>
					<TD>:
						<INPUT NAME			='jns'
								TYPE		='radio'
								VALUE 		='D'
								ID			='jns'";
						if($jns=='D')
							echo"checked";
							echo"> 
						DIGITAL
						<INPUT 	NAME		='jns'
								TYPE		='radio'
								VALUE 		='N'
								ID			='jns'";
						if($jns=='N')
							echo"checked";
							echo"> 
						NON DIGITAL
						<INPUT 	NAME		='jns'
								TYPE		='radio'
								VALUE 		=''
								ID			='jns'";
						if($jns=='')
							echo"checked";
							echo"> 
						KEDUANYA
					</TD>
				</TR>				
				<TR><TD>Jumlah Stock</TD>
					<TD>: 
						<INPUT 	NAME		='jmlstc'	
								TYPE		='text' 
								SIZE		='5' 	
								MAXLENGTH	='5'		
								VALUE		='$jmlstc'
								id			='jmlstc'
								onKeyUp		='javascript:checknumber(f1.jmlstc);'
								onkeypress	='return enter(this,event)'
								$isian>
					</TD>
				</TR>
				<TR><TD>Cover</TD>
					<TD COLSPAN='2'>: 
						<INPUT 	NAME		='cvr'	
								TYPE		='file' 
								SIZE		='50' 	
								MAXLENGTH	='50'		
								VALUE		='$cvr'
								onkeypress	='return enter(this,event)'
								$isian>
						<SPAN style='color: #FF0000;'>* Format file JPG, ukuran 150px x 180px</SPAN>
					</TD>
				</TR>
			</TABLE>";

			// pilihan tombol pilihan
			// tombol tambah
			if (hakakses('P1D02T')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 				VALUE='Tambah' 	onClick=window.location.href='perpustakaan.php?mode=P1D02&pilihan=tambah'>";
			}	
					
			// tombol edit
			if (hakakses('P1D02E')==1 and $pilihan=='detil')	
			{
				echo"
				<INPUT TYPE='button' 				VALUE='Edit' 	onClick=window.location.href='perpustakaan.php?mode=P1D02&kdebku=$kdebku&pilihan=edit'>";
			}	
				
			// tombol hapus
			if (hakakses('P1D02H')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Hapus' onClick=\"return confirm('Benar data akan dihapus ?');\">
				<INPUT TYPE='hidden' NAME='mode'	VALUE='P1D02_Hapus'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='hapus'>
				<INPUT TYPE='hidden' NAME='kdebku'	VALUE='$kdebku'>";
			}	
						
			// tombol simpan (tambah)
			if($pilihan=='tambah')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='reset' 				VALUE='Ulang'>
				<INPUT TYPE='hidden' NAME='mode'	VALUE='P1D02_Save'>";
			}
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='P1D02_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='kdebkuB'	VALUE='$kdebkuB'>";
			}
			echo"
			<INPUT TYPE='button' 				VALUE='Cari' 	onClick=window.location.href='perpustakaan.php?mode=P1D02_Cari'>
			<INPUT TYPE='button'				VALUE='Kembali'	onClick=history.go(-1)>						
		</FORM>"; 
 	}

	// -------------------------------------------------- Hapus --------------------------------------------------
	function P1D02_Hapus()
	{
		$pilihan=$_POST['pilihan'];
		if ($pilihan=='hapus')
		{
			$kdebku	=$_POST['kdebku'];
		}
		else
		{
			$kdebku	=$_GET['kdebku'];
		}	
		
		$query	="	DELETE 
					FROM 	t_mstbku 
					WHERE 	t_mstbku.kdebku='". mysql_escape_string($kdebku)."'";
		$result	=mysql_query($query) or die ("Query failed - Mysql");
		
		echo"<meta http-equiv='refresh' content=\"0;url=perpustakaan.php?mode=P1D02_Cari\">\n"; 
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function P1D02_Save()
	{
		$userid_x	=$_SESSION["Admin"]["userid"];	// buatan d $userid_x
  		$kdebkuB=$_POST['kdebkuB'];
		$kdektg	=$_POST['kdektg'];
  		$kdebku	=$_POST['kdebku'];
  		$jdl	=$_POST['jdl'];
		$png	=$_POST['png'];
		$pnr	=$_POST['pnr'];
		$thntrb	=$_POST['thntrb'];
		$jns	=$_POST['jns'];
		$jmlstc	=$_POST['jmlstc'];
		$cvr	=$_FILES['cvr']['tmp_name'];
		
  		$pilihan=$_POST['pilihan'];
		
		$set	="	SET	t_mstbku.kdektg	='". mysql_escape_string($kdektg)."',
						t_mstbku.kdebku	='". mysql_escape_string($kdebku)."',
						t_mstbku.jdl	='". mysql_escape_string($jdl)."',
						t_mstbku.png	='". mysql_escape_string($png)."',
						t_mstbku.pnr	='". mysql_escape_string($pnr)."',
						t_mstbku.thntrb	='". mysql_escape_string($thntrb)."',
						t_mstbku.jns	='". mysql_escape_string($jns)."',
						t_mstbku.jmlstc	='". mysql_escape_string($jmlstc)."',
						t_mstbku.lvl = '". mysql_escape_string($userid_x)."'"; // , t_mstbku.lvl = '". mysql_escape_string($userid_x)."' buatan d $userid_x

  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	t_mstbku ".$set. 
					 "	WHERE 	t_mstbku.kdebku	='". mysql_escape_string($kdebkuB)."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
        }
  		else
  		{
  			$query 	="	INSERT INTO t_mstbku ".$set;   
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
  		}
		
		if($cvr=='') 
		{
			$newfile='';
		}
		else 
		{
			$newfile=".../files/photo/buku/$kdebku.jpg";
			if (file_exists($newfile)) 
				unlink($newfile);
			copy($cvr, "../files/photo/buku/$kdebku.jpg");
		}
		
		echo"
		<meta http-equiv='refresh' content=\"0;url=perpustakaan.php?mode=P1D02&kdebku=$kdebku\">\n"; 
 	}
}//akhir class
?>