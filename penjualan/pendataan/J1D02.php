<?php
//----------------------------------------------------------------------------------------------------
//Program		: J1D02.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi BARANG
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class J1D02class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function J1D02_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdebrn	=$_GET['kdebrn'];
		$nmabrn	=$_GET['nmabrn'];
		$nmaklm	=$_GET['nmaklm'];
		$prd 	=periode("PENJUALAN");
		
		$query2 ="	SELECT 		t_mstbrn.*,t_klmbrn.nmaklm,t_sldbrn.sldawl,t_sldbrn.msk,t_sldbrn.klr
					FROM 		t_mstbrn,t_klmbrn,t_sldbrn
					WHERE 		(t_mstbrn.kdebrn LIKE'%".$kdebrn."%' OR '$kdebrn'='')	AND
								(t_mstbrn.nmabrn LIKE'%".$nmabrn."%' OR '$nmabrn'='')	AND
								(t_klmbrn.nmaklm LIKE'%".$nmaklm."%' OR '$nmaklm'='')	AND
								t_mstbrn.kdeklm	=t_klmbrn.kdeklm 						AND
								t_mstbrn.kdebrn	=t_sldbrn.kdebrn 						AND
								t_sldbrn.prd	='$prd'
					ORDER BY 	t_mstbrn.kdebrn";
		$result	= mysql_query($query2)	or die (mysql_error());

		echo"
		<FORM ACTION=penjualan.php METHOD='get'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>BARANG</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='15%'>Kode Barang</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdebrn'
								ID			='kdebrn'
								TYPE		='text' 		
								SIZE		='10' 
								MAXLENGTH	='10'
								onkeyup		='uppercase(this.id)'>
					</TD>
				</TR>
				<TR><TD>Nama Barang</TD>
					<TD>: 
						<INPUT 	NAME		='nmabrn'	
								ID			='nmabrn'
								TYPE		='text' 		
								SIZE		='50' 
								MAXLENGTH	='50'
								onkeyup		='uppercase(this.id)'>
					</TD>
				</TR>
				<TR><TD>Kelompok Barang</TD>
					<TD>: 
						<INPUT 	NAME		='nmaklm'	
								ID			='nmaklm'
								TYPE		='text' 		
								SIZE		='50' 
								MAXLENGTH	='50'
								onkeyup		='uppercase(this.id)'>
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='J1D02_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='penjualan.php?mode=J1D02_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM ACTION='penjualan.php?mode=J1D02' METHOD='post'>
			<DIV style='overflow:auto;width:100%;height:320px;padding-right:-2px;'>		
			<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
				<TR bgcolor='dedede'>
  					<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
  					<TD WIDTH='10%'><CENTER>Kode 			</CENTER></TD>
  					<TD WIDTH='29%'><CENTER>Nama Barang		</CENTER></TD>
  					<TD WIDTH='15%'><CENTER>Harga Satuan	</CENTER></TD>
					<TD WIDTH='20%'><CENTER>Kelompok 		</CENTER></TD>
					<TD WIDTH='10%'><CENTER>Stok 			</CENTER></TD>
  					<TD WIDTH=' 4%'><CENTER>Detil			</CENTER></TD>
  					<TD WIDTH=' 4%'><CENTER>Edit			</CENTER></TD>
  					<TD WIDTH=' 4%'><CENTER>Hapus			</CENTER></TD>
				</TR>";

				$no=0;
				while($data =mysql_fetch_array($result))
				{ 
					$no++;
					$hrg	=number_format($data[hrg]);
					$sldakhr=$data[sldawl]+$data[msk]-$data[klr];
					$sldakhr=number_format($sldakhr);
					echo"
					<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
  						<TD><CENTER>$no				</CENTER></TD>
  						<TD><CENTER>$data[kdebrn]	</CENTER></TD>
	  					<TD>$data[nmabrn]</TD>
	  					<TD><CENTER>$hrg			</CENTER></TD>
						<TD><CENTER>$data[nmaklm]	</CENTER></TD>
                        <TD><CENTER>$sldakhr		</CENTER></TD>";
						// otorisasi akses detil
						if (hakakses("J1D02D")==1)
						{
							echo"
							<TD><CENTER><a href='penjualan.php?mode=J1D02&kdebrn=$data[kdebrn]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
						}
						else
						{
							echo"
							<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
						}
						
						// otorisasi akses edit
						if (hakakses("J1D02E")==1)
						{		
							echo"
							<TD><CENTER><a href='penjualan.php?mode=J1D02&kdebrn=$data[kdebrn]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";
						}
						else
						{
							echo"
							<TD><CENTER><IMG src='../images/edit_d.gif' 	BORDER='0'></a></CENTER></TD>";
						}	
							
						// otorisasi akses hapus
						if (hakakses("J1D02H")==1)
						{		
							echo"
							<TD><CENTER><a href='penjualan.php?mode=J1D02_Hapus&kdebrn=$data[kdebrn]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
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
			if (hakakses("J1D02T")==1)
			{
				echo"<INPUT TYPE='button' VALUE='Tambah BARANG' onClick=window.location.href='penjualan.php?mode=J1D02&pilihan=tambah'>";
			}	
		echo"	
		</FORM>";
 	}

	// -------------------------------------------------- Detil --------------------------------------------------
	function J1D02()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	

		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../penjualan/js/J1D02_validasi_kdebrn.js'></SCRIPT>";
		
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
			$kdebrnB=$_GET['kdebrn'];
			$query 	="	SELECT 	t_mstbrn.*,t_klmbrn.nmaklm 
						FROM 	t_mstbrn,t_klmbrn  
						WHERE 	t_mstbrn.kdebrn='". mysql_escape_string($kdebrnB)."' 	AND
								t_mstbrn.kdeklm=t_klmbrn.kdeklm";
			$result =mysql_query($query);
			$data 	=mysql_fetch_array($result);
		
			$kdeklm	=$data[kdeklm];
			$kdebrn	=$data[kdebrn];
			$nmabrn	=$data[nmabrn];
			$isi	=$data[isi];
			$stn	=$data[stn];
			if ($pilihan=='edit')
			{
				$hrg	=$data[hrg];
			}
			else
			{
				$hrg	=number_format($data[hrg]);
			}	
			$ktr	=$data[ktr];
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='penjualan.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>BARANG</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Kode Kelompok</TD>
					<TD WIDTH='85%'>: 
						<SELECT	NAME		='kdeklm'	
								VALUE 		='$kdeklm'
								onkeypress	='return enter(this,event)'
								$isian>";
						$sql2="SELECT * FROM t_klmbrn  ORDER BY kdeklm";
    					$my=mysql_query($sql2);
    					while($al=mysql_fetch_array($my))
    					{
							if ($kdeklm==$al[kdeklm]) 
								echo 
								"<OPTION VALUE='$al[kdeklm]' SELECTED>$al[kdeklm]-$al[nmaklm]</OPTION>";
  	  						else 
								echo 
								"<OPTION VALUE='$al[kdeklm]' >$al[kdeklm]-$al[nmaklm]</OPTION>";
    					}
       					echo
						"</SELECT>		
					</TD>
				</TR>				
				<TR><TD>Kode Barang</TD>
					<TD>: 
						<INPUT 	NAME		='kdebrn'	
								TYPE		='text' 	
								SIZE		='10' 	
								MAXLENGTH	='10'
								VALUE 		='$kdebrn'
								id			='kdebrn'
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
				<TR><TD>Nama Barang</TD>
					<TD>: 
						<INPUT 	NAME		='nmabrn'	
								TYPE		='text' 
								SIZE		='50' 	
								MAXLENGTH	='50'		
								VALUE		='$nmabrn'
								id			='nmabrn'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								$isian>
					</TD>
				</TR>
				<TR><TD>Isi</TD>
					<TD>: 
						<INPUT 	NAME		='isi'	
								TYPE		='text' 
								SIZE		='10' 	
								MAXLENGTH	='10'		
								VALUE		='$isi'
								id			='isi'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								$isian>
					</TD>
				</TR>
				<TR><TD>Satuan</TD>
					<TD>: 
						<INPUT 	NAME		='stn'	
								TYPE		='text' 
								SIZE		='10' 	
								MAXLENGTH	='10'		
								VALUE		='$stn'
								id			='stn'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								$isian>
					</TD>
				</TR>
				<TR><TD>Harga</TD>
					<TD>: 
						<INPUT 	NAME		='hrg'	
								TYPE		='text' 
								SIZE		='12' 	
								MAXLENGTH	='12'		
								VALUE		='$hrg'
								id			='hrg'
								ONKEYUP		='formatangka(this);'
								onkeypress	='return enter(this,event)'
								$isian>
					</TD>
				</TR>				
				<TR><TD>Keterangan</TD>
					<TD>: 
						<TEXTAREA	NAME		='ktr'
									COLS		='50'
									ROWS		='3'
									id			='ktr'
									onchange	='uppercase(this.id)'
									$isian>$ktr</TEXTAREA>
					</TD>
				</TR>
				
				<TABLE>
					<TR>
						<TD>";
						// pilihan tombol pilihan
						// tombol tambah
						if (hakakses('J1D02T')==1 and $pilihan=='detil')
						{
							echo"
							<INPUT TYPE='button' 	VALUE='Tambah' 	onClick=window.location.href='penjualan.php?mode=J1D02&pilihan=tambah'>";
						}	
						
						// tombol edit
						if (hakakses('J1D02E')==1 and $pilihan=='detil')	
						{
							echo"
							<INPUT TYPE='button' 	VALUE='Edit' 	onClick=window.location.href='penjualan.php?mode=J1D02&kdebrn=$kdebrn&pilihan=edit'>";
						}	
						
						// tombol hapus
						if (hakakses('J1D02H')==1 and $pilihan=='detil')
						{
							echo"
							<INPUT TYPE='submit' 				VALUE='Hapus' onClick=\"return confirm('Benar data akan dihapus ?');\">
							<INPUT TYPE='hidden' NAME='mode'	VALUE='J1D02_Hapus'>
							<INPUT TYPE='hidden' NAME='pilihan'	VALUE='hapus'>
							<INPUT TYPE='hidden' NAME='kdebrn'	VALUE='$kdebrn'>";
						}	
						
						// tombol simpan (tambah)
						if($pilihan=='tambah')
						{
							echo"
							<INPUT TYPE='submit' 				VALUE='Simpan'>
							<INPUT TYPE='reset' 				VALUE='Ulang'>
							<INPUT TYPE='hidden' NAME='mode'	VALUE='J1D02_Save'>";
						}
						// tombol simpan (edit)
						if($pilihan=='edit')
						{
							echo"
							<INPUT TYPE='submit' 				VALUE='Simpan'>
							<INPUT TYPE='hidden' NAME='mode' 	VALUE='J1D02_Save'>
							<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
							<INPUT TYPE='hidden' NAME='kdebrnB'	VALUE='$kdebrnB'>";
						}
						echo"
						<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='penjualan.php?mode=J1D02_Cari'>
						<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>						
						</TD>
					</TR>
				</TABLE>
			</TABLE>
		</FORM>"; 
 	}

	// -------------------------------------------------- Hapus --------------------------------------------------
	function J1D02_Hapus()
	{
		$pilihan=$_POST['pilihan'];
		if ($pilihan=='hapus')
		{
			$kdebrn	=$_POST['kdebrn'];
		}
		else
		{
			$kdebrn	=$_GET['kdebrn'];
		}	
		
		$query	="	DELETE 
					FROM 	t_mstbrn 
					WHERE 	t_mstbrn.kdebrn='". mysql_escape_string($kdebrn)."'";
		$result	=mysql_query($query) or die ("Query failed - Mysql");
		
		echo"<meta http-equiv='refresh' content=\"0;url=penjualan.php?mode=J1D02_Cari\">\n"; 
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function J1D02_Save()
	{
		//User acces//
        $kdeusr =$_SESSION['Admin']['username'];
		$tglrbh =date("d-m-Y");
		$jamrbh	=date("h:i:s");
  		//end User acces//				
	
  		$kdebrnB=$_POST['kdebrnB'];
		$kdeklm	=$_POST['kdeklm'];
  		$kdebrn	=$_POST['kdebrn'];
  		$nmabrn	=$_POST['nmabrn'];
		$isi	=$_POST['isi'];
		$stn	=$_POST['stn'];
		$hrg	=str_replace(",","",$_POST['hrg']);
		$ktr	=$_POST['ktr'];
		
  		$pilihan=$_POST['pilihan'];
		
		$set="	SET		t_mstbrn.kdeklm	='". mysql_escape_string($kdeklm)	."',
						t_mstbrn.kdebrn	='". mysql_escape_string($kdebrn)	."',
						t_mstbrn.nmabrn	='". mysql_escape_string($nmabrn)	."',
						t_mstbrn.isi	='". mysql_escape_string($isi)		."',
						t_mstbrn.stn	='". mysql_escape_string($stn)		."',
						t_mstbrn.hrg	='". mysql_escape_string($hrg)		."',
						t_mstbrn.ktr	='". mysql_escape_string($ktr)		."',
						t_mstbrn.kdeusr	='". mysql_escape_string($kdeusr)	."',
						t_mstbrn.tglrbh	='". mysql_escape_string($tglrbh)	."',
						t_mstbrn.jamrbh	='". mysql_escape_string($jamrbh)	."'";

  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	t_mstbrn ".$set. 
					 "	WHERE 	t_mstbrn.kdebrn	='". mysql_escape_string($kdebrnB)."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
        }
  		else
  		{
  			$query 	="	INSERT INTO t_mstbrn ".$set; 
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
  		}
		
		echo"<meta http-equiv='refresh' content=\"0;url=penjualan.php?mode=J1D02&kdebrn=$kdebrn\">\n"; 
 	}
}//akhir class
?>