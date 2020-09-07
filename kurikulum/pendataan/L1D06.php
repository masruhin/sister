<?php
//----------------------------------------------------------------------------------------------------
//Program		: L1D06.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi PENGAJARAN
//----------------------------------------------------------------------------------------------------
//	KURIKULUM
//		pendataan
//			pengajaran
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class L1D06class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function L1D06_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$nmakry	=$_GET['nmakry'];
		$nmaplj	=$_GET['nmaplj'];
		$kdekls	=$_GET['kdekls'];

		$query ="	SELECT 		t_mstpng.*,t_mstkry.nmakry,t_mstplj.nmaplj
					FROM 		t_mstpng,t_mstkry,t_mstplj
					WHERE   	(t_mstkry.nmakry LIKE'%".$nmakry."%' OR '$nmakry'='')	AND
								(t_mstplj.nmaplj LIKE'%".$nmaplj."%' OR '$nmaplj'='') 	AND
								(t_mstpng.kdekls LIKE'%".$kdekls."%' OR '$kdekls'='') 	AND
								t_mstpng.kdegru=t_mstkry.kdekry AND
								t_mstpng.kdeplj=t_mstplj.kdeplj
					ORDER BY 	t_mstkry.nmakry,t_mstpng.kdekls,t_mstpng.kdeplj";
		$result= mysql_query($query)	or die (mysql_error());

		echo"
		<FORM ACTION=kurikulum.php METHOD='get'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>PENGAJARAN</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='15%'>Guru</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='nmakry'
								ID			='nmakry'
								TYPE		='text' 		
								SIZE		='50' 
								MAXLENGTH	='50'
								onkeyup		='uppercase(this.id)'>
					</TD>
				</TR>
				<TR><TD>Pelajaran</TD>
					<TD>: 
						<INPUT 	NAME		='nmaplj'
								ID			='nmaplj'
								TYPE		='text' 		
								SIZE		='50'
								MAXLENGTH	='50'
								onkeyup		='uppercase(this.id)'>
					</TD>
				</TR>
				<TR><TD>Kelas</TD>
					<TD>:
						<SELECT NAME		='kdekls'
								ID			='kdekls'
								ONKEYUP		='uppercase(this.id)'>";
						$query2="	SELECT 		t_mstkls.*
									FROM 		t_mstkls
									ORDER BY 	t_mstkls.kdeklm,t_mstkls.kdekls";
						$result2=mysql_query($query2);
						echo"<OPTION VALUE='' SELECTED>--Semua--</OPTION>";
						while($data2=mysql_fetch_array($result2))
						{
							if ($kdekls==$data2[kdekls])
								echo"<OPTION VALUE='$data2[kdekls]' SELECTED>$data2[kdekls]</OPTION>";
							else
								echo"<OPTION VALUE='$data2[kdekls]'>$data2[kdekls]</OPTION>";
						}
						echo"
						</SELECT>
                        <INPUT TYPE='submit' 				VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'	VALUE='L1D06_Cari'>
						<INPUT TYPE='button' 				VALUE='Tampilkan Semua' onClick=window.location.href='kurikulum.php?mode=L1D06_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM ACTION='kurikulum.php?mode=L1D06' METHOD='post'>
			<DIV style='overflow:auto;width:100%;height:320px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No			</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Kode		</CENTER></TD>
						<TD WIDTH='40%'><CENTER>Guru		</CENTER></TD>
						<TD WIDTH='29%'><CENTER>Pelajaran	</CENTER></TD>
						<TD WIDTH=' 5%'><CENTER>Kelas		</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Detil		</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Edit		</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Hapus		</CENTER></TD>
					</TR>";

					$no=0;
					while($data =mysql_fetch_array($result))
					{
						$no++;
						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
							<TD><CENTER>$no			</CENTER></TD>
							<TD><CENTER>$data[kdegru]</CENTER></TD>
							<TD>$data[nmakry]</TD>
							<TD><CENTER>$data[nmaplj]</CENTER></TD>
							<TD><CENTER>$data[kdekls]</CENTER></TD>";
						
							// otorisasi akses detil
							if (hakakses("L1D06D")==1)
							{
								echo"
								<TD><CENTER><a href='kurikulum.php?mode=L1D06&kdegru=$data[kdegru]&kdeplj=$data[kdeplj]&kdekls=$data[kdekls]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
							}
						
							// otorisasi akses edit
							if (hakakses("L1D06E")==1)
							{		
								echo"
								<TD><CENTER><a href='kurikulum.php?mode=L1D06&kdegru=$data[kdegru]&kdeplj=$data[kdeplj]&kdekls=$data[kdekls]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/edit_d.gif' 	BORDER='0'></a></CENTER></TD>";
							}	
							
							// otorisasi akses hapus
							if (hakakses("L1D06H")==1)
							{		
								echo"
								<TD><CENTER><a href='kurikulum.php?mode=L1D06_Hapus&kdegru=$data[kdegru]&kdeplj=$data[kdeplj]&kdekls=$data[kdekls]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
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
			if (hakakses("L1D06T")==1)
			{
				echo"
				<INPUT TYPE='button' VALUE='Tambah PENGAJARAN' onClick=window.location.href='kurikulum.php?mode=L1D06&pilihan=tambah'>";
				echo"
				<INPUT TYPE='button' VALUE='Cetak per Guru' onClick=window.location.href='kurikulum.php?mode=L1D06_CetakL1'>";
				echo"
				<INPUT TYPE='button' VALUE='Cetak per Pelajaran' onClick=window.location.href='kurikulum.php?mode=L1D06_CetakL2'>";
				echo"
				<INPUT TYPE='button' VALUE='Cetak per Kelas' onClick=window.location.href='kurikulum.php?mode=L1D06_CetakL3'>";
			}	
		echo"	
		</FORM>";
 	}

	// -------------------------------------------------- Detil --------------------------------------------------
	function L1D06()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	

		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>";
		
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
			$kdegruB=$_GET['kdegru'];
			$kdepljB=$_GET['kdeplj'];
			$kdeklsB=$_GET['kdekls'];
			$query 	="	SELECT 	t_mstpng.* 
						FROM 	t_mstpng
						WHERE 	t_mstpng.kdegru='". mysql_escape_string($kdegruB)."'	AND
								t_mstpng.kdeplj='". mysql_escape_string($kdepljB)."'	AND
								t_mstpng.kdekls='". mysql_escape_string($kdeklsB)."'";
			$result =mysql_query($query);
			$data 	=mysql_fetch_array($result);
		
			$kdegru	=$data[kdegru];
			$kdeplj	=$data[kdeplj];
			$kdekls	=$data[kdekls];
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='kurikulum.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>PENGAJARAN</B></TD></TR>
				<TR></TR><TR></TR>
                <TR><TD WIDTH='15%'>Guru</TD>
					<TD WIDTH='85%'>:
						<SELECT	NAME		='kdegru'
								VALUE 		='$kdegru'
								ONKEYPRESS	='return enter(this,event)'
                                CLASS		='required'
								TITLE		='...harus diisi'
								$isian>";
						$query="	SELECT 		t_mstkry.*
									FROM 		t_mstkry
									WHERE 		t_mstkry.kdestt LIKE '%G%'AND substr(t_mstkry.kdekry,1,1)!='@'
									ORDER BY 	t_mstkry.nmakry";
						$result=mysql_query($query);
						echo"<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
						while($data=mysql_fetch_array($result))
						{
							if ($kdegru==$data[kdekry])
								echo"<OPTION VALUE='$data[kdekry]' SELECTED>$data[nmakry] - ( $data[kdekry] )</OPTION>";
							else
								echo"<OPTION VALUE='$data[kdekry]'>$data[nmakry] - ( $data[kdekry] )</OPTION>";
						}
						echo
						"</SELECT>
					</TD>
				</TR>
				<TR><TD>Pelajaran</TD>
					<TD>: 
						<SELECT	NAME		='kdeplj'
								VALUE 		='$kdeplj'
								ONKEYPRESS	='return enter(this,event)'
                                CLASS		='required'
								TITLE		='...harus diisi'
								$isian>";
						$query="	SELECT 		t_mstplj.* 
									FROM 		t_mstplj
									ORDER BY 	t_mstplj.nmaplj";
						$result=mysql_query($query);
						echo"<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
						while($data=mysql_fetch_array($result))
						{
							if ($kdeplj==$data[kdeplj])
								echo"<OPTION VALUE='$data[kdeplj]' SELECTED>$data[nmaplj]</OPTION>";
							else 
								echo"<OPTION VALUE='$data[kdeplj]'>$data[nmaplj]</OPTION>";
						}
						echo
						"</SELECT>		
					</TD>
				</TR>				
				<TR><TD>Kelas</TD>
					<TD>: 
						<SELECT	NAME		='kdekls'
								VALUE 		='$kdekls'
								ONKEYPRESS	='return enter(this,event)'
                                CLASS		='required'
								TITLE		='...harus diisi'
								$isian>";
						$query="	SELECT 		t_mstkls.*
									FROM 		t_mstkls
									ORDER BY 	t_mstkls.kdeklm,t_mstkls.kdekls";
						$result=mysql_query($query);
						echo"<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
						while($data=mysql_fetch_array($result))
						{
							if ($kdekls==$data[kdekls])
								echo"<OPTION VALUE='$data[kdekls]' SELECTED>$data[kdekls]</OPTION>";
							else 
								echo"<OPTION VALUE='$data[kdekls]'>$data[kdekls]</OPTION>";
						}
						echo
						"</SELECT>		
					</TD>
				</TR>				
			</TABLE>";	

			// pilihan tombol pilihan
			// tombol tambah
			if (hakakses('L1D06T')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Tambah' 	onClick=window.location.href='kurikulum.php?mode=L1D06&pilihan=tambah'>";
			}	
				
			// tombol edit
			if (hakakses('L1D06E')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Edit' 	onClick=window.location.href='kurikulum.php?mode=L1D06&kdegru=$kdegru&kdeplj=$kdeplj&kdekls=$kdekls&pilihan=edit'>";
			}	
						
			// tombol hapus
			if (hakakses('L1D06H')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Hapus' onClick=\"return confirm('Benar data akan dihapus ?');\">
				<INPUT TYPE='hidden' NAME='mode'	VALUE='L1D06_Hapus'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='hapus'>
				<INPUT TYPE='hidden' NAME='kdegru'	VALUE='$kdegru'>
				<INPUT TYPE='hidden' NAME='kdeplj'	VALUE='$kdeplj'>
				<INPUT TYPE='hidden' NAME='kdekls'	VALUE='$kdekls'>";
			}	
						
			// tombol simpan (tambah)
			if($pilihan=='tambah')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='reset' 				VALUE='Ulang'>
				<INPUT TYPE='hidden' NAME='mode'	VALUE='L1D06_Save'>";
			}
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='L1D06_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='kdegruB'	VALUE='$kdegruB'>
				<INPUT TYPE='hidden' NAME='kdepljB'	VALUE='$kdepljB'>
				<INPUT TYPE='hidden' NAME='kdeklsB'	VALUE='$kdeklsB'>";
			}
			echo"
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='kurikulum.php?mode=L1D06_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
		</FORM>"; 
 	}

	// -------------------------------------------------- Hapus --------------------------------------------------
	function L1D06_Hapus()
	{
		$pilihan=$_POST['pilihan'];
		if ($pilihan=='hapus')
		{
			$kdegru	=$_POST['kdegru'];
			$kdeplj	=$_POST['kdeplj'];
			$kdekls	=$_POST['kdekls'];
		}
		else
		{
			$kdegru	=$_GET['kdegru'];
			$kdeplj	=$_GET['kdeplj'];
			$kdekls	=$_GET['kdekls'];
		}	
		
		$query	="	DELETE 
					FROM 	t_mstpng
					WHERE 	t_mstpng.kdegru='". mysql_escape_string($kdegru)."'	AND
							t_mstpng.kdeplj='". mysql_escape_string($kdeplj)."'	AND
							t_mstpng.kdekls='". mysql_escape_string($kdekls)."'";
		$result	=mysql_query($query) or die ("Query failed - Mysql");
		
		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L1D06_Cari\">\n";
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function L1D06_Save()
	{
  		$kdegruB=$_POST['kdegruB'];
		$kdepljB=$_POST['kdepljB'];
		$kdeklsB=$_POST['kdeklsB'];
  		$kdegru	=$_POST['kdegru'];
  		$kdeplj	=$_POST['kdeplj'];
  		$kdekls	=$_POST['kdekls'];
		
		$pilihan=$_POST['pilihan'];
		
		$set	="	SET		t_mstpng.kdegru	='". mysql_escape_string($kdegru)."',
							t_mstpng.kdeplj	='". mysql_escape_string($kdeplj)."',
							t_mstpng.kdekls	='". mysql_escape_string($kdekls)."'";
		
  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	t_mstpng ".$set.
					 "	WHERE 	t_mstpng.kdegru	='". mysql_escape_string($kdegruB)."'		AND
								t_mstpng.kdeplj	='". mysql_escape_string($kdepljB)."'		AND
								t_mstpng.kdekls	='". mysql_escape_string($kdeklsB)."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
        }
  		else
  		{
  			$query 	="	INSERT INTO t_mstpng ".$set; 
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
  		}
		
		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L1D06&kdegru=$kdegru&kdeplj=$kdeplj&kdekls=$kdekls\">\n"; 
 	}

    // -------------------------------------------------- Cetak Daftar Per Guru--------------------------------------------------
 	function L1D06_CetakL1()
 	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
	 	echo"
		<FORM ACTION='pendataan/L1D06_C01.php' target=_blank METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
  			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
        		<TR><TD COLSPAN='2'><B>CETAK DAFTAR PENGAJARAN (Per Guru)</B></TD></TR>
           		<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Guru</TD>
					<TD WIDTH='85%'>:
						<SELECT	NAME		='kdegru'
								VALUE 		='$kdegru'
								ONKEYPRESS	='return enter(this,event)'
                                CLASS		='required'
								TITLE		='...harus diisi'
								$isian>";
						$query="	SELECT 		t_mstkry.*
									FROM 		t_mstkry
									WHERE 		t_mstkry.kdestt LIKE '%G%'AND substr(t_mstkry.kdekry,1,1)!='@'
									ORDER BY 	t_mstkry.nmakry";
						$result=mysql_query($query);
						echo"<OPTION VALUE='' SELECTED>--Semua--</OPTION>";
						while($data=mysql_fetch_array($result))
						{
							if ($kdegru==$data[kdekry])
								echo"<OPTION VALUE='$data[kdekry]' SELECTED>$data[nmakry] - ( $data[kdekry] )</OPTION>";
							else
								echo"<OPTION VALUE='$data[kdekry]'>$data[nmakry] - ( $data[kdekry] )</OPTION>";
						}
						echo
						"</SELECT>
					</TD>
				</TR>
    	   	</TABLE>
			<INPUT TYPE=submit 		VALUE=Cetak>
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='kurikulum.php?mode=L1D06_Cari'>
		</FORM>";
 	}

    // -------------------------------------------------- Cetak Daftar Per Pelajaran --------------------------------------------------
 	function L1D06_CetakL2()
 	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
	 	echo"
		<FORM ACTION='pendataan/L1D06_C02.php' target=_blank METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
  			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
        		<TR><TD COLSPAN='2'><B>CETAK DAFTAR PENGAJARAN (Per Pelajaran)</B></TD></TR>
           		<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Pelajaran</TD>
					<TD WIDTH='85%'>: 
						<SELECT	NAME		='kdeplj'
								VALUE 		='$kdeplj'
								ONKEYPRESS	='return enter(this,event)'
                                CLASS		='required'
								TITLE		='...harus diisi'
								$isian>";
						$query="	SELECT 		t_mstplj.*
									FROM 		t_mstplj
									ORDER BY 	t_mstplj.kdeplj";
						$result=mysql_query($query);
						echo"<OPTION VALUE='' SELECTED>--Semua--</OPTION>";
						while($data=mysql_fetch_array($result))
						{
							if ($kdeplj==$data[kdeplj])
								echo"<OPTION VALUE='$data[kdeplj]' SELECTED>$data[nmaplj]</OPTION>";
							else 
								echo"<OPTION VALUE='$data[kdeplj]'>$data[nmaplj]</OPTION>";
						}
						echo
						"</SELECT>		
					</TD>
				</TR>				
    	   	</TABLE>
			<INPUT TYPE=submit 		VALUE=Cetak>
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='kurikulum.php?mode=L1D06_Cari'>
		</FORM>";
	}
	
    // -------------------------------------------------- Cetak Daftar Per Kelas --------------------------------------------------
 	function L1D06_CetakL3()
 	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
	 	echo"
		<FORM ACTION='pendataan/L1D06_C03.php' target=_blank METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
  			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
        		<TR><TD COLSPAN='2'><B>CETAK DAFTAR PENGAJARAN (Per Kelas)</B></TD></TR>
           		<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Kelas</TD>
					<TD WIDTH='85%'>: 
						<SELECT	NAME		='kdekls'
								VALUE 		='$kdekls'
								ONKEYPRESS	='return enter(this,event)'
                                CLASS		='required'
								TITLE		='...harus diisi'
								$isian>";
						$query="	SELECT 		t_mstkls.*
									FROM 		t_mstkls
									ORDER BY 	t_mstkls.kdeklm,t_mstkls.kdekls";
						$result=mysql_query($query);
						echo"<OPTION VALUE='' SELECTED>--Semua--</OPTION>";
						while($data=mysql_fetch_array($result))
						{
							if ($kdekls==$data[kdekls])
								echo"<OPTION VALUE='$data[kdekls]' SELECTED>$data[kdekls]</OPTION>";
							else 
								echo"<OPTION VALUE='$data[kdekls]'>$data[kdekls]</OPTION>";
						}
						echo
						"</SELECT>		
					</TD>
				</TR>				
    	   	</TABLE>
			<INPUT TYPE=submit 		VALUE=Cetak>
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='kurikulum.php?mode=L1D06_Cari'>
		</FORM>";
	}	
}//akhir class
?>