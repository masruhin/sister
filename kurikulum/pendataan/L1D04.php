<?php
//----------------------------------------------------------------------------------------------------
//Program		: L1D04.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi KELAS
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class L1D04class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function L1D04_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdekls	=$_GET['kdekls'];
		$nmakry	=$_GET['nmakry'];
		$kdejrs	=$_GET['kdejrs'];
			
		$query ="	SELECT 		t_mstkls.*,t_mstkry.*  
					FROM 		t_mstkls,t_mstkry  
					WHERE 		(t_mstkls.kdekls LIKE'%".$kdekls."%' OR '$kdekls'='')	AND
								(t_mstkry.nmakry LIKE'%".$nmakry."%' OR '$nmakry'='')	AND
								(t_mstkls.kdejrs LIKE'%".$kdejrs."%' OR '$kdejrs'='')	AND
								t_mstkls.wlikls=t_mstkry.kdekry
					ORDER BY 	t_mstkls.kdeklm,t_mstkls.kdekls";
		$result= mysql_query($query)	or die (mysql_error());

		echo"
		<FORM ACTION=kurikulum.php METHOD='get'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>KELAS</B></TD></TR>
				<TR></TR><TR></TR>
				
				<TR><TD WIDTH='15%'>Kelas</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdekls'	
								ID			='kdekls'	
								TYPE		='text' 		
								SIZE		='10' 
								MAXLENGTH	='10'
								onkeyup		='uppercase(this.id)'>
					</TD>
				</TR>
				<TR><TD>Wali Kelas</TD>
					<TD>: 
						<INPUT 	NAME		='nmakry'	
								ID			='nmakry'	
								TYPE		='text' 		
								SIZE		='50' 
								MAXLENGTH	='50'
								onkeyup		='uppercase(this.id)'>										
					</TD>
				</TR>
				<TR><TD>Jurusan</TD>
					<TD>: 
						<INPUT 	NAME		='kdejrs'	
								ID			='kdejrs'	
								TYPE		='text' 		
								SIZE		='15' 
								MAXLENGTH	='15'
								onkeyup		='uppercase(this.id)'>										
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='L1D04_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='kurikulum.php?mode=L1D04_Cari'>
					</TD>
				</TR>	
			</TABLE>
		</FORM>
			
		<FORM ACTION='kurikulum.php?mode=L1D04' METHOD='post'>
			<DIV style='overflow:auto;width:100%;height:310px;padding-right:-2px;'>		
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No			</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Kelas		</CENTER></TD>
						<TD WIDTH='58%'><CENTER>Wali Kelas	</CENTER></TD>
						<TD WIDTH='16%'><CENTER>Jurusan		</CENTER></TD>
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
							<TD>$data[kdekls]</TD>
							<TD>$data[nmakry] ($data[kdekry])</TD>
							<TD><CENTER>$data[kdejrs]</CENTER></TD>";
							// otorisasi akses detil
							if (hakakses("L1D04D")==1)
							{
								echo"
								<TD><CENTER><a href='kurikulum.php?mode=L1D04&kdekls=$data[kdekls]'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
							}
						
							// otorisasi akses edit
							if (hakakses("L1D04E")==1)
							{		
								echo"
								<TD><CENTER><a href='kurikulum.php?mode=L1D04&kdekls=$data[kdekls]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/edit_d.gif' 	BORDER='0'></a></CENTER></TD>";
							}		
							
							// otorisasi akses hapus
							if (hakakses("L1D04H")==1)
							{		
								echo"
								<TD><CENTER><a href='kurikulum.php?mode=L1D04_Hapus&kdekls=$data[kdekls]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
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
			if (hakakses("L1D04T")==1)
			{
				echo"<INPUT TYPE='button' VALUE='Tambah KELAS' onClick=window.location.href='kurikulum.php?mode=L1D04&pilihan=tambah'>";
			}	
		echo"	
		</FORM>";
 	}

	// -------------------------------------------------- Detil --------------------------------------------------
	function L1D04()
	{
		// deklarasi java
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	

		echo"
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../kurikulum/js/L1D04_validasi_kdekls.js'></SCRIPT>";
		
		echo"
		<SCRIPT TYPE='text/javascript' src='../js/jquery-1.2.3.pack.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' src='../js/jquery.validate.pack.js'></SCRIPT>
        <SCRIPT TYPE='text/javascript'>
			$(document).ready(function() 
			{
				$('#validasi').validate()
			});
		</SCRIPT>
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
            case 'upload':
				$isian	='disabled';
				break;
		}		
		
		if ($pilihan=='detil' OR $pilihan=='edit' OR $pilihan=='upload')
		{
			$kdeklsB=$_GET['kdekls'];
			$query 	="	SELECT 	t_mstkls.*
						FROM 	t_mstkls
						WHERE 	t_mstkls.kdekls='". mysql_escape_string($kdeklsB)."'";
			$result =mysql_query($query);
			$data 	=mysql_fetch_array($result);
		
			$kdekls	=$data[kdekls];
			$wlikls	=$data[wlikls];
			$kdejrs	=$data[kdejrs];
			$kdeklm	=$data[kdeklm];
			/*$query2="	SELECT 		t_jdwplj.*
						FROM 		t_jdwplj
						WHERE		t_jdwplj.kdekls='". mysql_escape_string($kdeklsB)."'";
			$result2=mysql_query($query2);
			$data2=mysql_fetch_array($result2);
            $type=$data2['type'];*/
		}
		// akhir inisiasi parameter
		
		// detil form tampilan/isian
  		echo"
		<FORM ID='validasi' ACTION='kurikulum.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'onsubmit='return check();'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>KELAS</B></TD><TD COLSPAN='5' ALIGN='right'>";
						if ($pilihan=='detil'and $pilihan=='upload')
						{
							echo"
							| <a href='kurikulum.php?mode=L1D04_Pelajaran&kdekls=$kdekls&pilihan=$pilihan'>Silabus</a>";
						}
					echo"
					</TD>
				</TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Kelas</TD>
					<TD WIDTH='85%'>: 
						<INPUT 	NAME		='kdekls'	
								TYPE		='text' 	
								SIZE		='10' 	
								MAXLENGTH	='10'
								VALUE 		='$kdekls'
								id			='kdekls'
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
				<TR><TD>Wali Kelas</TD>
					<TD>: 
						<SELECT	NAME		='wlikls'	
								VALUE 		='$wlikls'
								ONKEYPRESS	='return enter(this,event)'
                                CLASS		='required'
								TITLE		='...harus diisi'
								$isian>";
						$query="	SELECT 		t_mstkry.* 
									FROM 		t_mstkry  
									WHERE 		t_mstkry.kdestt LIKE '%G%' AND substr(t_mstkry.kdekry,1,1)!='@'
									ORDER BY 	t_mstkry.nmakry";
						$result=mysql_query($query);
						echo"<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
						while($data=mysql_fetch_array($result))
						{
							if ($wlikls==$data[kdekry]) 
								echo"<OPTION VALUE='$data[kdekry]' SELECTED>$data[nmakry] ($data[kdekry])</OPTION>";
							else 
								echo"<OPTION VALUE='$data[kdekry]'>$data[nmakry] ($data[kdekry])</OPTION>";
						}
						echo
						"</SELECT>		
					</TD>
				</TR>				
				<TR><TD>Jurusan</TD>
					<TD>: 
						<SELECT	NAME		='kdejrs'	
								VALUE 		='$kdejrs'
								ONKEYPRESS	='return enter(this,event)'
                                CLASS		='required'
								TITLE		='...harus diisi'
								$isian>";
						$query="	SELECT 		t_mstjrs.* 
									FROM 		t_mstjrs  
									ORDER BY 	t_mstjrs.kdejrs DESC";
						$result=mysql_query($query);
						
						while($data=mysql_fetch_array($result))
						{
							if ($kdejrs==$data[kdejrs]) 
								echo"<OPTION VALUE='$data[kdejrs]' SELECTED>$data[kdejrs]</OPTION>";
							else 
								echo"<OPTION VALUE='$data[kdejrs]'>$data[kdejrs]</OPTION>";
						}
						echo"
						</SELECT>		
					</TD>
				</TR>				
				<TR><TD>Kelompok Kelas</TD>
					<TD>: 
						<SELECT	NAME		='kdeklm'	
								VALUE 		='$kdeklm'
								ONKEYPRESS	='return enter(this,event)'
                                CLASS		='required'
								TITLE		='...harus diisi'
								$isian>";
						$query="	SELECT 		t_klmkls.* 
									FROM 		t_klmkls 
									ORDER BY 	t_klmkls.kdeklm";
						$result=mysql_query($query);
						while($data=mysql_fetch_array($result))
						{
							if ($kdeklm==$data[kdeklm]) 
								echo"<OPTION VALUE='$data[kdeklm]' SELECTED>$data[kdeklm]</OPTION>";
							else 
								echo"<OPTION VALUE='$data[kdeklm]'>$data[kdeklm]</OPTION>";
						}
						echo"
						</SELECT>		
					</TD>
				</TR>
                <TR><TD>Jadwal Pelajaran</TD>
                <TD>: ";
                if($pilihan!='upload' and $type!='')
                {
                echo"<a href='../files/jadwal/$kdekls/$kdekls.".$type."' target='_blank'><img src='../images/icon_pdf_e.gif'></a></TD>";
                }
                else
                if($pilihan=='upload')
                { echo"
                 <INPUT 	NAME		='pdf'
									TYPE		='file'
									SIZE		='20'
									MAXLENGTH	='50'
									VALUE		='$pdf'
									id		    ='pdf'
									onkeypress	='return enter(this,event)'
									>&nbsp


                            <INPUT TYPE='submit' 				VALUE='Input'>
                            <INPUT TYPE='hidden' NAME='pilihan'	VALUE='upload'>
				            <INPUT TYPE='hidden' NAME='kdeklsB'	VALUE='$kdeklsB'>
                            <INPUT TYPE='hidden' NAME='mode'  id='mode'	VALUE='L1D04_Save_Pelajaran'>";
                }

                echo"
                </TR>
			</TABLE>";

			// pilihan tombol pilihan
			// tombol tambah
			if (hakakses('L1D04T')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Tambah' 	onClick=window.location.href='kurikulum.php?mode=L1D04&pilihan=tambah'>";
			}	
						
			// tombol edit
			if (hakakses('L1D04E')==1 and $pilihan=='detil')	
			{
				echo"
				<INPUT TYPE='button' 	VALUE='Edit' 	onClick=window.location.href='kurikulum.php?mode=L1D04&kdekls=$kdekls&pilihan=edit'>
                <INPUT TYPE='button' 	VALUE='Upload Jadwal' 	onClick=window.location.href='kurikulum.php?mode=L1D04&kdekls=$kdekls&pilihan=upload'>";
			}	
						
			// tombol hapus
			if (hakakses('L1D04H')==1 and $pilihan=='detil')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Hapus' onClick=\"return confirm('Benar data akan dihapus ?');\">
				<INPUT TYPE='hidden' NAME='mode'	VALUE='L1D04_Hapus'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='hapus'>
				<INPUT TYPE='hidden' NAME='kdekls'	VALUE='$kdekls'>";
			}	
						
			// tombol simpan (tambah)
			if($pilihan=='tambah')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='reset' 				VALUE='Ulang'>
				<INPUT TYPE='hidden' NAME='mode'	VALUE='L1D04_Save'>";
			}
			// tombol simpan (edit)
			if($pilihan=='edit')
			{
				echo"
				<INPUT TYPE='submit' 				VALUE='Simpan'>
				<INPUT TYPE='hidden' NAME='mode' 	VALUE='L1D04_Save'>
				<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
				<INPUT TYPE='hidden' NAME='kdeklsB'	VALUE='$kdeklsB'>";
			}
			echo"
			<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='kurikulum.php?mode=L1D04_Cari'>
			<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
		</FORM>"; 
 	}

    // -------------------------------------------------- Detil pelajaran --------------------------------------------------
	function L1D04_Pelajaran()
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

		<SCRIPT TYPE='text/javascript' 	src='../kurikulum/js/L1D05_isidata.js'></SCRIPT>
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

		$kdeklsB=$_GET['kdekls'];
		$query 	="	SELECT 	*
					FROM 	t_jdwplj
                    WHERE kdekls='$kdeklsB'
					ORDER BY kdekls";
		$result =mysql_query($query);
		$data 	=mysql_fetch_array($result);

		$kdekls	=$data[kdekls];
		$type	=$data[type];
		$kdeusr	=$data[kdeusr];
		$tglrbh	=$data[tglrbh];
		$jamrbh	=$data[jamrbh];

		$query 	="	SELECT 		t_jdwplj.*
					FROM 		t_jdwplj
					WHERE 		t_jdwplj.kdekls='". mysql_escape_string($kdeklsB)."'
					ORDER BY 	t_jdwplj.kdekls";
		$result =mysql_query($query);

		// akhir ikdepljiasi parameter

		// detil form tampilan/isian
  		echo"
		<FORM ACTION='kurikulum.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data' onsubmit='return check();'>
			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%' ID='isidata'>
				<TR><TD><B>JADWAL&nbsp;PELAJARAN</B></TD>
					<TD COLSPAN='2' ALIGN='right'>";
						if ($pilihan=='detil')
						{
							echo"
							| <a href='kurikulum.php?mode=L1D04&kdekls=$kdekls&pilihan=$pilihan'>Pelajaran</a> |";
						}
					echo"
					</TD>
				</TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Kelas</TD>
					<TD WIDTH='85%'>:<input type='hidden' name='kdekls' id='kdekls' value='$kdeklsB'>
                                     <input type='hidden' name='kdeusr' id='kdeusr' value='$user'>
						<INPUT 	NAME		='kdekls1'
								TYPE		='text'
								SIZE		='10'
								MAXLENGTH	='10'
								VALUE 		='$kdeklsB'
								DISABLED>


									Upload File :
							<INPUT 	NAME		='pdf'
									TYPE		='file'
									SIZE		='20'
									MAXLENGTH	='50'
									VALUE		='$pdf'
									id		    ='pdf'
									class       ='required'
									onkeypress	='return enter(this,event)'
									>&nbsp


                            <INPUT TYPE='submit' 				VALUE='Input'>
                            <INPUT TYPE='hidden' NAME='mode'  id='mode'	VALUE='L1D04_Save_Pelajaran'>
                </TR>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No		</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Kelas		</CENTER></TD>
						<TD WIDTH='86%'><CENTER>Jadwal Pelajaran		</CENTER></TD>
					</TR>
                    </TABLE>
                    <Form='pelajaran'>
                    <TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>";
                    $no=0;
                    while($data=mysql_fetch_array($result))
                    { $no++;
                     $kdekls=$data['kdekls'];
                     $type=$data['type'];
                     echo"
                     <TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>$no		</CENTER></TD>
						<TD WIDTH='10%'><CENTER>$kdekls		</CENTER></TD>";
                        switch($type)
                        {
                        case 'pdf' :
                        echo"
						<TD WIDTH='86%'><CENTER><a href='../files/jadwal/$kdekls/$kdekls.".$type."' target='_blank'><img src='../images/icon_pdf_e.gif'></a></CENTER></TD>";
                        break;
                        case 'txt':
                         echo"
						<TD WIDTH='86%'><a href='../files/jadwal/$kdekls/$kdekls.".$type."' target='_blank'><CENTER><img src='../images/icon_txt_e.gif'></CENTER></a></TD>";
                        break;
                        case 'doc'and 'docx':
                         echo"
						<TD WIDTH='86%'><a href='../files/jadwal/$kdekls/$kdekls.".$type."' target='_blank'><CENTER><img src='../images/icon_doc_e.gif'></CENTER></a></TD>";
                        break;
                        }
                    echo"
					</TR>
                     ";
                    }
                    echo"</TABLE></FORM>";

				// pilihan tombol pilihan
				// tombol edit
				if (hakakses('L1D04E')==1 and $pilihan=='detil')
				{
					echo"
					<INPUT TYPE='button'	VALUE='Edit' 	onClick=window.location.href='kurikulum.php?mode=L1D04_Saudara&kdeplj=$kdeplj&pilihan=edit'>";
				}

				// tombol simpan (edit)
				if($pilihan=='edit')
				{
					echo"
					<INPUT TYPE='submit' 				VALUE='Simpan'>
					<INPUT TYPE='hidden' NAME='mode' 	VALUE='L1D04_Save_Saudara'>
					<INPUT TYPE='hidden' NAME='pilihan'	VALUE='edit'>
					<INPUT TYPE='hidden' NAME='kdekls'		VALUE=$kdekls>";
				}
				echo"
				<INPUT TYPE='button' 	VALUE='Cari' 	onClick=window.location.href='kurikulum.php?mode=L1D04_Cari'>
				<INPUT TYPE='button'	VALUE='Kembali'	onClick=history.go(-1)>
				$kdeusr - $tglrbh - $jamrbh
		";
 	}
	// -------------------------------------------------- Hapus --------------------------------------------------
	function L1D04_Hapus()
	{
		$pilihan=$_POST['pilihan'];
		if ($pilihan=='hapus')
		{
			$kdekls	=$_POST['kdekls'];
		}
		else
		{
			$kdekls	=$_GET['kdekls'];
		}	
		
		$query	="	DELETE 
					FROM 	t_mstkls 
					WHERE 	t_mstkls.kdekls='". mysql_escape_string($kdekls)."'";
		$result	=mysql_query($query) or die ("Query failed - Mysql");
		
		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L1D04_Cari\">\n"; 
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function L1D04_Save()
	{
  		$kdeklsB=$_POST['kdeklsB'];
  		$kdekls	=$_POST['kdekls'];
  		$wlikls	=$_POST['wlikls'];
		$kdejrs	=$_POST['kdejrs'];
		$kdeklm	=$_POST['kdeklm'];
  		$pilihan=$_POST['pilihan'];
		$set	="	SET		t_mstkls.kdekls	='". mysql_escape_string($kdekls)."',
							t_mstkls.wlikls	='". mysql_escape_string($wlikls)."',
							t_mstkls.kdejrs	='". mysql_escape_string($kdejrs)."',
							t_mstkls.kdeklm	='". mysql_escape_string($kdeklm)."'";

  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	t_mstkls ".$set. 
					 "	WHERE 	t_mstkls.kdekls	='". mysql_escape_string($kdeklsB)	."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
        }
  		else
  		{
  			$query 	="	INSERT INTO t_mstkls ".$set;  
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
  		}
		
		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L1D04&kdekls=$kdekls\">\n"; 
 	}

// -------------------------------------------------- Save jadwal pelajaran--------------------------------------------------
	function L1D04_Save_Pelajaran()
	{
  		$kdeklsB=$_POST['kdeklsB'];
		$pdf		=$_FILES['pdf']['tmp_name'];
        $filetype	=$_FILES['pdf']['name'];
        $type1		=$_FILES['pdf']['type'];
        $type		=explode('.',$filetype);
		$kdeusr =$_POST['kdeusr'];;
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");

             	$types="SELECT  *FROM 	  t_jdwplj
                                        WHERE kdekls='$kdeklsB'
                                        ";
                $result =mysql_query($types);
		        $data1 	=mysql_fetch_array($result);
                $typen=$data1['type'];
                $kdekls=$data1['kdekls'];


			$set	="	SET		t_jdwplj.kdekls	='". mysql_escape_string($kdeklsB)."',
								t_jdwplj.kdeusr	='". mysql_escape_string($kdeusr)."',
								t_jdwplj.tglrbh	='". mysql_escape_string($tglrbh)."',
                                t_jdwplj.type	='". mysql_escape_string($type[1])."',
								t_jdwplj.jamrbh	='". mysql_escape_string($jamrbh)."'";

       if(empty($typen))
          {
        $query 	="INSERT INTO t_jdwplj ".$set;
		$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
           }
        else
        {
          $query 	="UPDATE t_jdwplj ".$set."
          WHERE kdekls='$kdekls'";
		  $result =mysql_query ($query) or die (error("Data tidak berhasil di Input $kdekls"));

        }



        $handle = is_dir("../files/jadwal/$kdeklsB");
        if($handle=='')
        {
			mkdir("../files/jadwal/".$kdeklsB, 0775);
        }

		if($pdf=='')
		{
			$newfile='';
		}
		else
		{
			$newfile= "../files/jadwal/$kdeklsB/$kdeklsB.$type[1]";
			if (file_exists($newfile))
				unlink($newfile);
			copy($pdf, "../files/jadwal/$kdeklsB/$kdeklsB.$type[1]");
		}
		echo"<meta http-equiv='refresh' content=\"0;url=kurikulum.php?mode=L1D04&kdekls=$kdeklsB&pilihan=detil\">\n";;
 	}
}//akhir class
?>