<?php
//----------------------------------------------------------------------------------------------------
//Program		: L1D05.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi PELAJARAN
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class L1D05class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function L1D05_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdeplj	=$_GET['kdeplj'];
		$nmaplj	=$_GET['nmaplj'];
			
		$query ="	SELECT 		t_mstplj.* 
					FROM 		t_mstplj
					WHERE 		(t_mstplj.kdeplj LIKE'%".$kdeplj."%' OR '$kdeplj'='')	AND
								(t_mstplj.nmaplj LIKE'%".$nmaplj."%' OR '$nmaplj'='')
					ORDER BY 	t_mstplj.kdeplj";
		$result= mysql_query($query)	or die (mysql_error());

		echo"
		<FORM ACTION=kurikulum.php METHOD='get'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>PELAJARAN</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='15%'>Kode Pelajaran</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdeplj'	
								ID			='kdeplj'	
								TYPE		='text' 		
								SIZE		='5' 
								MAXLENGTH	='5'
								onkeyup		='uppercase(this.id)'>										
					</TD>
				</TR>
				<TR><TD>Nama Pelajaran</TD>
					<TD>:
						<INPUT 	NAME		='nmaplj'	
								ID			='nmaplj'	
								TYPE		='text' 		
								SIZE		='50' 
								MAXLENGTH	='50'
								onkeyup		='uppercase(this.id)'>										
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='L1D05_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='kurikulum.php?mode=L1D05_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>
			
		<FORM ACTION='kurikulum.php?mode=L1D05' METHOD='post'>
			<DIV style='overflow:auto;width:100%;height:340px;padding-right:-2px;'>		
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
						<TD WIDTH=' 5%'><CENTER>Kode 			</CENTER></TD>
						<TD WIDTH='79%'><CENTER>Nama Pelajaran	</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Detil			</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Edit			</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Hapus			</CENTER></TD>
					</TR>";
					
					$no=0;
					while($data =mysql_fetch_array($result))
					{
						$no++;
						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
							<TD><CENTER>$no				</CENTER></TD>
							<TD><CENTER>$data[kdeplj]	</CENTER></TD>
							<TD><CENTER>$data[nmaplj]	</CENTER></TD>";
							// otorisasi akses detil
							if (hakakses("L1D05D")==1)
							{	
								echo"
								<TD><CENTER><a href='kurikulum.php?mode=L1D05&kdeplj=$data[kdeplj]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
							}
						
							// otorisasi akses edit
							if (hakakses("L1D05E")==1)
							{		
								echo"
								<TD><CENTER><a href='kurikulum.php?mode=L1D05&kdeplj=$data[kdeplj]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/edit_d.gif' 	BORDER='0'></a></CENTER></TD>";
							}		
							
							// otorisasi akses hapus
							if (hakakses("L1D05H")==1)	
							{		
								echo"
								<TD><CENTER><a href='kurikulum.php?mode=L1D05_Hapus&kdeplj=$data[kdeplj]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
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
			if (hakakses("L1D05T")==1)
			{
				echo"<INPUT TYPE='button' VALUE='Tambah PELAJARAN' onClick=window.location.href='kurikulum.php?mode=L1D05&pilihan=tambah'>";
			}	
		echo"	
		</FORM>";
 	}

	// -------------------------------------------------- Detil --------------------------------------------------
	function L1D05()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../kurikulum/js/L1D05_validasi_kdeplj.js'></SCRIPT>";
		
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
			$kdepljB=$_GET['kdeplj'];
			$query 	="	SELECT 	t_mstplj.* 
						FROM 	t_mstplj
						WHERE 	t_mstplj.kdeplj='". mysql_escape_string($kdepljB)."'";
			$result =mysql_query($query);
			$data 	=mysql_fetch_array($result);
		
			$str	=$data[str];
			if($str=='X')
				$status='EXTRA CURRICULAR';
			$kdeplj	=$data[kdeplj];
			$nmaplj	=$data[nmaplj];
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='kurikulum.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>PELAJARAN</B></TD>
				<TD COLSPAN='5' ALIGN='right'>";
						if ($pilihan=='detil')
						{
							echo"
							| <a href='kurikulum.php?mode=L1D05_Silabus&kdeplj=$kdeplj&pilihan=$pilihan'>Silabus</a>";
						}
					echo"
					</TD>
				</TR>	
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Kode Pelajaran</TD>
					<TD WIDTH='85%'>:
						<INPUT 	NAME		='kdeplj'
								TYPE		='text' 	
								SIZE		='5'
								MAXLENGTH	='5'
								VALUE 		='$kdeplj'
								ID			='kdeplj'
								ONKEYUP		='uppercase(this.id)'
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required' 
								TITLE		='...harus diisi'
								$isian>
						<SPAN 	ID			='msgbox'  
								STYLE		='display:none'>
						</SPAN>
						<B><span style='color: #FF0000;'>$status</B></span>
					</TD>
				</TR>
					
				<TR><TD>Nama Pelajaran</TD>
					<TD>:
						<INPUT 	NAME		='nmaplj'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$nmaplj'
								ID			='nmaplj'
								
								ONKEYPRESS	='return enter(this,event)'
								CLASS		='required'
								TITLE		='...harus diisi'
								$isian>
					</TD>
				</TR>
			</TABLE>";

			// pilihan tombol pilihan
			// tombol tambah
			if (hakakses('L1D05T')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Tambah' 	onClick=window.location.href='kurikulum.php?mode=L1D05&pilihan=tambah'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='L1D05_isidata'>";
			}	
						
			// tombol edit
			if (hakakses('L1D05E')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button'	VALUE='Edit' 	onClick=window.location.href='kurikulum.php?mode=L1D05&kdeplj=$kdeplj&pilihan=edit'>";
			}	
						
			// tombol hapus
			if (hakakses('L1D05H')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Hapus' onClick=\"return confirm('Benar data akan dihapus ?');\">
				<INPUT TYPE='hidden' NAME='mode'	VALUE='L1D05_Hapus'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='hapus'>
				<INPUT TYPE='hidden' NAME='kdeplj'	VALUE='$kdeplj'>";
			}	
			
			// tombol extra
			if (hakakses('L1D05T')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Extra Kurikuler' onClick=\"return confirm('Benar ini pelajaran extrakulikuler ?');\">
				<INPUT TYPE='hidden' NAME='mode'	VALUE='L1D05_Extra'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='detil'>
				<INPUT TYPE='hidden' NAME='kdeplj'	VALUE='$kdeplj'>";
			}	
						
			// tombol simpan (tambah)
			if($pilihan=='tambah')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='reset' 				VALUE='Ulang'>
				<INPUT TYPE='hidden' NAME='mode'	VALUE='L1D05_Save'>";
			}
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='L1D05_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='kdepljB'	VALUE='$kdepljB'>";
			}
			echo"
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='kurikulum.php?mode=L1D05_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
		</FORM>"; 
 	}

	// -------------------------------------------------- Hapus --------------------------------------------------
	function L1D05_Hapus()
	{
		$pilihan=$_POST['pilihan'];
		if ($pilihan=='hapus')
		{
			$kdeplj	=$_POST['kdeplj'];
		}
		else
		{
			$kdeplj	=$_GET['kdeplj'];
		}	
		
		$query	="	DELETE 
					FROM 	t_mstplj
					WHERE 	t_mstplj.kdeplj='". mysql_escape_string($kdeplj)."'";
		$result	=mysql_query($query) or die ("Query failed - Mysql");
		
		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L1D05_Cari\">\n";
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function L1D05_Save()
	{
  		$kdepljB=$_POST['kdepljB'];
  		$kdeplj	=$_POST['kdeplj'];
  		$nmaplj	=$_POST['nmaplj'];
  		$pilihan=$_POST['pilihan'];
		$set	="	SET		t_mstplj.kdeplj	='". mysql_escape_string($kdeplj)."',
                            t_mstplj.nmaplj	='". mysql_escape_string($nmaplj)."'";

  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	t_mstplj ".$set.
					 "	WHERE 	t_mstplj.kdeplj	='". mysql_escape_string($kdepljB)	."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
        }
  		else
  		{
  			$query 	="	INSERT INTO t_mstplj ".$set; 
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
  		}
		
		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L1D05&kdeplj=$kdeplj\">\n";
 	}
	// -------------------------------------------------- Save --------------------------------------------------
	function L1D05_Extra()
	{
  		$kdeplj	=$_POST['kdeplj'];
  		$pilihan=$_POST['pilihan'];
		
		$query 	="	SELECT 	t_mstplj.* 
					FROM 	t_mstplj
					WHERE 	t_mstplj.kdeplj='". mysql_escape_string($kdeplj)."'";
		$result =mysql_query($query);
		$data 	=mysql_fetch_array($result);
		
		$str	=$data[str];
		if($str=='')
			$str='X';
		else
			$str='';
		
		$set	="	SET		t_mstplj.str	='". mysql_escape_string($str)."'";

   		$query 	="	UPDATE 	t_mstplj ".$set.
				 "	WHERE 	t_mstplj.kdeplj	='". mysql_escape_string($kdeplj)	."'";
		$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
		
		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L1D05&kdeplj=$kdeplj\">\n";
 	}
	
// -------------------------------------------------- Detil Silabus --------------------------------------------------
	function L1D05_Silabus()
	{ require("../fungsi_umum/sysconfig.php");
    require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
	  $kdeusr =$_SESSION['Admin']['kdekry'];
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	

		echo"
		<SCRIPT TYPE='text/javascript' src='../js/jquery-1.2.3.pack.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' src='../js/jquery.validate.pack.js'></SCRIPT>
		<script TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></script>";

		echo"

        <script type='text/javascript' language='JavaScript'>
function check() {
  var ext = document.getElementById('pdf').value;
  ext = ext.substring(ext.length-3,ext.length);
  ext = ext.toLowerCase();
  if(ext != 'pdf') {
    alert('File yang anda pilih .'+ext+
          '; Hanya format PDF yang bisa di upload!');
           document.f1.pdf.value='';
          document.f1.pdf.focus();
    return false;
  } else {
    return true;
  }
}
</script>";


		// ikdepljiasi parameter berdasarkan pilihan tombol
		$pilihan=$_GET['pilihan'];

		switch($pilihan)
		{
			case 'detil':
				$isian	='disabled';
                 $user=$kdeusr;
				break;
			case 'edit':
				$isian	='enable';
				break;
		}		
		
		$kdepljB=$_GET['kdeplj'];
		$query 	="	SELECT 	t_mstplj.* 
					FROM 	t_mstplj
					WHERE 	t_mstplj.kdeplj='". mysql_escape_string($kdepljB)."'";
		$result =mysql_query($query);
		$data 	=mysql_fetch_array($result);
	
		$kdeplj	=$data[kdeplj];
		$nmaplj	=$data[nmaplj];
		$kdeusr	=$data[kdeusr];
		$tglrbh	=$data[tglrbh];
		$jamrbh	=$data[jamrbh];		

		$query 	="	SELECT 		t_mstslb.*
					FROM 		t_mstslb
					WHERE 		t_mstslb.kdeplj='". mysql_escape_string($kdepljB)."'
					ORDER BY 	t_mstslb.kdeplj,t_mstslb.kdeklm";
		$result =mysql_query($query);

		// akhir ikdepljiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ACTION='kurikulum.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data' onsubmit='return check();'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%' ID='isidata'>
				<TR><TD><B>SILABUS</B></TD>
					<TD COLSPAN='2' ALIGN='right'>";
						if ($pilihan=='detil')
						{
							echo"
							| <a href='kurikulum.php?mode=L1D05&kdeplj=$kdeplj&pilihan=$pilihan'>Pelajaran</a> |";					
						}	
					echo"
					</TD>
				</TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Kode Pelajaran</TD>
					<TD WIDTH='85%'>:<input type='hidden' name='kdeplj' id='kdeplj' value='$kdeplj'>
                                     <input type='hidden' name='kdeusr' id='kdeusr' value='$user'>
						<INPUT 	NAME		='kdeplj1'
								TYPE		='text' 	
								SIZE		='5'
								MAXLENGTH	='5'
								VALUE 		='$kdeplj'
								DISABLED>
					</TD>
				</TR>				
				<TR><TD>Nama Pelajaran</TD>
					<TD>:
						<INPUT 	NAME		='nmaplj'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='50'
								VALUE 		='$nmaplj'
								DISABLED>
					</TD>
				</TR>
                <TR>
                <TD>Kelas</TD> <TD>:
							<SELECT NAME	='kdeklm'
									ID		='kdeklm'
									class	='kdeklm'
									value='$kdeklm'
									>
							<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
							$query2="	SELECT  *
										FROM 	   t_klmkls
										ORDER BY kdeklm
                                                    ";
							$result2=mysql_query($query2);

							while($data=mysql_fetch_array($result2))
							{
								if($kdeklm==$data[kdeklm])
									echo"<OPTION VALUE='$data[kdeklm]' SELECTED>$data[kdeklm]</OPTION>";
								else
									echo"<OPTION VALUE='$data[kdeklm]'>$data[kdeklm]</OPTION>";
							}
							echo"
							</SELECT>

									Upload File :
							<INPUT 	NAME		='pdf'
									TYPE		='file'
									SIZE		='20'
									MAXLENGTH	='50'
									VALUE		='$pdf'
									id		    ='pdf'
									class       ='required'
									onkeypress	='return enter(this,event)'
									>
                            <INPUT TYPE='submit' 				VALUE='Input'>
                            <INPUT TYPE='hidden' NAME='mode'  id='mode'	VALUE='L1D05_Save_Silabus'>
                </TR>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No		</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Kelas		</CENTER></TD>
						<TD WIDTH='86%'><CENTER>Silabus		</CENTER></TD>
					</TR>
                    <TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' id='slb'>
                    </TABLE>
                    <Form='silabus'>
                    <TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>";
                    $no=0;
                    while($data=mysql_fetch_array($result))
                    { $no++;
                     $kdeklm=$data['kdeklm'];
                     $type=$data['type'];
                     echo"
                     <TR>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>$no		</CENTER></TD>
						<TD WIDTH='10%'><CENTER>$kdeklm		</CENTER></TD>";
                        echo"
						<TD WIDTH='86%'><CENTER><a href='../files/silabus/$kdeplj/$kdeklm$kdeplj.".$type."' target='_blank'><img src='../images/icon_pdf_e.gif'></a></CENTER></TD>";
                    echo"
					</TR>
                     ";
                    }
                    echo"</TABLE></FORM>";

				// pilihan tombol pilihan
				// tombol edit
				echo"
				<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='kurikulum.php?mode=L1D05_Cari'>
				<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>";
 	}

// -------------------------------------------------- Save Absensi --------------------------------------------------
	function L1D05_Save_Silabus()
	{
  		$kdepljB=$_POST['kdeplj'];
		$kdeklmB=$_POST['kdeklm'];
		$pdf		=$_FILES['pdf']['tmp_name'];
        $filetype	=$_FILES['pdf']['name'];
        $type1		=$_FILES['pdf']['type'];
        $type		=explode('.',$filetype);
		$kdeusr =$_POST['kdeusr'];;
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");


            	$types="SELECT  *FROM 	  t_mstslb
                                        WHERE kdeklm='$kdeklmB'AND
                                        kdeplj='$kdepljB'";
                $result =mysql_query($types);
		        $data1 	=mysql_fetch_array($result);
                $typen=$data1['type'];
                $kdeklm=$data1['kdeklm'];
                $kdeplj=$data1['kdeplj'];



            $set	="	SET		t_mstslb.kdeplj	='". mysql_escape_string($kdepljB)."',
								t_mstslb.kdeklm	='". mysql_escape_string($kdeklmB)."',
								t_mstslb.kdeusr	='". mysql_escape_string($kdeusr)."',
								t_mstslb.tglrbh	='". mysql_escape_string($tglrbh)."',
                                t_mstslb.type	='". mysql_escape_string($type[1])."',
								t_mstslb.jamrbh	='". mysql_escape_string($jamrbh)."'";



          if(empty($typen))
          {
        $query 	="INSERT INTO t_mstslb ".$set;
		$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
           }
        else
        {
          $query 	="UPDATE t_mstslb ".$set."
          WHERE kdeklm=$kdeklm
                ";
		  $result =mysql_query ($query) or die (error("Data tidak berhasil di Input3"));

        }

        $handle = is_dir("../files/silabus/$kdepljB");
        if($handle=='')
        {
			mkdir("../files/silabus/".$kdepljB, 0775);
        }

		if($pdf=='')
		{
			$newfile='';
		}
		else
		{
			$newfile= "../files/silabus/$kdepljB/$kdeklmB$kdepljB.$type[1]";
			if (file_exists($newfile))
				unlink($newfile);
			copy($pdf, "../files/silabus/$kdepljB/$kdeklmB$kdepljB.$type[1]");
		}
		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L1D05_Silabus&kdeplj=$kdepljB&pilihan=detil\">\n";;
 	}
}//akhir class
?>