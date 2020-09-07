<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D01B.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi SOAL
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D01Bclass
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function R1D01B_Cari()
	{
		$user	=$_SESSION["Admin"]["kdekry"];
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";

		$kdesl	=$_GET['kdesl'];
		$nmaplj	=$_GET['nmaplj'];

		$query ="	SELECT 		g_gnrsal.*,t_mstplj.nmaplj
					FROM   		g_gnrsal,t_mstplj
					WHERE 		(g_gnrsal.kdesl 	LIKE'%".$kdesl."%' 	OR '$kdesl'='')		AND
								(t_mstplj.nmaplj 	LIKE'%".$nmaplj."%'	OR '$nmaplj'='')	AND
								(g_gnrsal.kdegru 	LIKE'%".$user."%')  	AND
								g_gnrsal.kdeplj=t_mstplj.kdeplj
					ORDER BY 	g_gnrsal.kdesl";
		$result	=mysql_query($query) or die (mysql_error());

		echo"
		<FORM ACTION=guru.php METHOD='get' NAME='f1'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>SOAL</B></TD></TR>
				<TR></TR><TR></TR>

				<TR><TD WIDTH='10%'>Kode Soal</TD>
  					<TD WIDTH='90%'>:
						<INPUT 	NAME		='kdesl'
								TYPE		='text'
								SIZE		='15'
								MAXLENGTH	='15'
								id			='kdesl'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'>
					</TD>
  				</TR>
				<TR><TD>Pelajaran</TD>
					<TD>:
						<INPUT 	NAME		='nmaplj'
								TYPE		='nmaplj'
								SIZE		='50'
								MAXLENGTH	='50'
								id			='nmaplj'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'>
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='R1D01B_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='guru.php?mode=R1D01B_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>

		<FORM ACTION='guru.php?mode=R1D01B' METHOD='post'>
			<div style='overflow:auto;width:100%;height:320px;padding-right:-2px;'>                
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No			</CENTER></TD>
						<TD WIDTH=' 8%'><CENTER>Kode Soal 	</CENTER></TD>
						<TD WIDTH='21%'><CENTER>Pelajaran	</CENTER></TD>
						<TD WIDTH='55%'><CENTER>Keterangan	</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Detil		</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Edit		</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Hapus		</CENTER></TD>
					</TR>";

					$no=0;
					while($data =mysql_fetch_array($result))
					{
						$no++;
						echo"
						<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
							<TD><CENTER>$no			</CENTER></TD>
							<TD><CENTER>$data[kdesl]</CENTER></TD>
							<TD><CENTER>$data[nmaplj]</CENTER></TD>
							<TD>$data[ktr]</TD>
							<TD><CENTER><a href='guru.php?mode=R1D01B_Soal&kdesl=$data[kdesl]&pilihan=detil_general'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>
							<TD><CENTER><a href='guru.php?mode=R1D01B_Soal&kdesl=$data[kdesl]&pilihan=edit_general'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>
							<TD><CENTER><a href='guru.php?mode=R1D01B_Hapus&kdesl=$data[kdesl]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>
						</TR>";
					}
				echo"
				</TABLE>
			</DIV>
			<BR>
			<INPUT TYPE='button' VALUE='Buat Soal' onClick=window.location.href='guru.php?mode=R1D01B_Soal&pilihan=tambah_general'>
		</FORM>";
 	}

	// -------------------------------------------------- Item --------------------------------------------------
	function R1D01B_Soal()
	{
		require_once '../fungsi_umum/sysconfig.php';
    	require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';
		require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
		$user	=$_SESSION["Admin"]["kdekry"];

       	// deklarasi java
		echo"
        <SCRIPT TYPE='text/javascript' 		src='../js/ajax.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 		src='../js/ajax-dynamic-list.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 		src='../js/fungsi_input.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 		src='../js/DatePicker/WdatePicker.js'></SCRIPT>
		<LINK 	href='../css/val.css' 		rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 		src='../js/jquery-validate.js'></SCRIPT>
        <SCRIPT TYPE='text/javascript' 		src='../guru/js/R1D01B_ajaxupload.3.5.js'></SCRIPT>
        <SCRIPT TYPE='text/javascript' 		src='../guru/js/R1D01B_jquery-1.3.2.js'></SCRIPT>";

        echo"
		<SCRIPT language='javascript'>
		//agar kursor keposisi isian1 kode barang
		function sf()
		{
			document.f1.ktr.focus();
		}
		</SCRIPT>";

		// inisiasi parameter berdasarkan pilihan tombol
		$pilihan=$_GET['pilihan'];

		if (empty($pilihan))
		{
			$pilihan='detil_general';
		}

		switch($pilihan)
		{
			case 'detil_general':
				$isian1 ='disabled';
				$isian2	='disabled';
				$isian3	='disabled';
                $isian4	='disabled';
				break;
			case 'tambah_general':
				$isian1	='enable';
				$isian2	='enable';
				$isian3	='enable';
                $isian4	='disabled';
				$user1	=$user;
				break;
			case 'edit_general':
				$isian1	='disabled';
				$isian2	='enable';
				$isian3	='disabled';
				$user1	=$user;
				break;
			case 'detil_item':
				$isian1 ='disabled';
				$isian2	='disabled';
				$isian3	='disabled';
				break;
			case 'tambah_item':
				$isian1	='disabled';
				$isian2	='disabled';
				$isian3	='enable';
				$user1	=$user;
				break;
			case 'edit_item':
				$isian1	='disabled';
				$isian2	='disabled';
				$isian3	='enable';
                $isian4	='disabled';
				$user1	=$user;
				break;
            case 'gambar':
				$isian1	='disabled';
				$isian2	='disabled';
                $isian3	='disabled';
				$isian4	='enable';
				$user1	=$user;
				break;
		}

		if ($pilihan=='detil_general' or $pilihan=='edit_general' or $pilihan=='tambah_item' or $pilihan=='edit_item' or $pilihan=='gambar')
		{
			$kdeslB	=$_GET['kdesl'];
			$query 	="	SELECT 	g_gnrsal.*
						FROM 	g_gnrsal
						WHERE 	g_gnrsal.kdesl='". mysql_escape_string($kdeslB)."'";
			$result	=mysql_query($query) or die (mysql_error());
			$data 	=mysql_fetch_array($result);
			$kdesl	=$data['kdesl'];
            $kdesl1	=$data['kdesl'];
            $kdeplj =$data['kdeplj'];
            $ktr    =$data['ktr'];
		}	
		if ($pilihan=='detil_general' or $pilihan=='edit_general' or $pilihan=='edit_item' or $pilihan=='gambar')
		{	
			$id=$_GET['id'];
			$query1 ="	SELECT 		g_dtlsal.*
						FROM 		g_dtlsal
						WHERE 		g_dtlsal.kdesl	='". mysql_escape_string($kdeslB)."'AND
									g_dtlsal.id		='". mysql_escape_string($id)."'
                        ORDER BY 	g_dtlsal.id";
			$result =mysql_query($query1);
			$data1 	=mysql_fetch_array($result);
			$id		=$data1['id'];
			$kdesl	=$kdeslB;
			$soal	=$data1['soal'];
			$sttjwb =$data1['sttjwb'];
			$jwb1   =$data1['jwb1'];
			$jwb2   =$data1['jwb2'];
			$jwb3   =$data1['jwb3'];
			$jwb4   =$data1['jwb4'];
			$jwb5  	=$data1['jwb5'];
            $phtsoal=$data[phtsoal];
			$phtjwb1=$data[phtjwb1];
			$phtjwb2=$data[phtjwb2];
			$phtjwb3=$data[phtjwb3];
			$phtjwb4=$data[phtjwb4];
			$phtjwb5=$data[phtjwb5];
			$phtsoalid=$kdesl.$id;
		}

		// akhir inisiasi parameter
		$query2 ="	SELECT 		g_dtlsal.* 
					FROM  		g_dtlsal
					WHERE 		g_dtlsal.kdesl='$kdesl1'
					ORDER BY	g_dtlsal.id";
		$result= mysql_query($query2)	or die (mysql_error());

		echo"
		<BODY onload='sf();'>
        <script type='text/javascript'>
			$(document).ready(function()
			{
				$('#phtsoals').bind('change',function()
				{
					document.f1.gambar.value='soal';
					$('#preview').html('<img src=\"../images/loader.gif\" alt=\"Uploading....\"/>');

					$('#validasi').ajaxForm(
					{
						target: '#preview'

					}).submit();
					document.f1.phtsoals.hidden=true;
				})
				
				$('#phtjwb1').bind('change',function()
				{
					document.f1.gambar.value='jwb1';
					$('#preview1').html('<img src=\"../images/loader.gif\" alt=\"Uploading....\"/>');

					$('#validasi').ajaxForm(
					{
						target: '#preview1'
					}).submit();
                    document.f1.phtjwb1.hidden=true;
				})
				
				$('#phtjwb2').bind('change',function()
				{
					document.f1.gambar.value='jwb2';
					$('#preview2').html('<img src=\"../images/loader.gif\" alt=\"Uploading....\"/>');

					$('#validasi').ajaxForm(
					{
						target: '#preview2'
					}).submit();
                    document.f1.phtjwb2.hidden=true;
				})
				
				$('#phtjwb3').bind('change',function()
				{
					document.f1.gambar.value='jwb3';
					$('#preview3').html('<img src=\"../images/loader.gif\" alt=\"Uploading....\"/>');

					$('#validasi').ajaxForm(
					{
						target: '#preview3'
					}).submit();
                    document.f1.phtjwb3.hidden=true;
				})
				
				$('#phtjwb4').bind('change',function()
				{
					document.f1.gambar.value='jwb4';
					$('#preview4').html('<img src=\"../images/loader.gif\" alt=\"Uploading....\"/>');

					$('#validasi').ajaxForm(
					{
						target: '#preview4'
					}).submit();
                    document.f1.phtjwb4.hidden=true;
				})
				
				$('#phtjwb5').bind('change',function()
				{
					document.f1.gambar.value='jwb5';
					$('#preview5').html('<img src=\"../images/loader.gif\" alt=\"Uploading....\"/>');

					$('#validasi').ajaxForm(
					{
					target: '#preview5'
					}).submit();
                    document.f1.phtjwb5.hidden=true;
				});
			});
		</script>
		
		<SCRIPT TYPE='text/javascript' src='../guru/js/R1D01B.js'></SCRIPT>
        <SCRIPT TYPE='text/javascript' src='../js/lightbox.js'></SCRIPT>

        <LINK 	href='../css/lightbox.css' 	rel='stylesheet' TYPE='text/css' media='screen'>
			<FORM id='validasi'method='post' name='f1' enctype='multipart/form-data' action='../guru/fungsi_khusus/R1D01B_upload-file.php'>
				<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
					<TR><TD><B>SOAL</B></TD></TR>
					<TR></TR><TR></TR>
					<TR><TD WIDTH='10%'>Kode Soal</TD>
						<TD WIDTH='90%'>:
							<INPUT 	NAME		='kdesl1'
									TYPE		='text'
									SIZE		='15'
									MAXLENGTH	='15'
									VALUE 		='$kdesl1'
									id			='kdesl1'
									DISABLED>
							<INPUT 	TYPE='hidden' 	NAME='kdesl' id='kdesl' value='$kdesl1'>
							Pelajaran :
							<INPUT TYPE='hidden' 	NAME='kdegru' 	id='kdegru'	VALUE='$user1'>
							<INPUT type='hidden' 	NAME='id' 		id='id' 	value='$data1[id]'>
							<SELECT NAME	='kdeplj'
									ID		='kdeplj'
									class	='kdeplj'
									value='$kdeplj'
									$isian1>

								<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
								$query2="	SELECT 		DISTINCT t_mstpng.kdeplj,t_mstplj.nmaplj
											FROM 		t_mstpng,t_mstplj
											WHERE		t_mstpng.kdegru='$user' AND
														t_mstpng.kdeplj=t_mstplj.kdeplj 
											ORDER BY 	t_mstplj.nmaplj";
								$result2=mysql_query($query2);
							
								while($data=mysql_fetch_array($result2))
								{
									if($kdeplj==$data[kdeplj])
										echo"<OPTION VALUE='$data[kdeplj]' SELECTED>$data[nmaplj]</OPTION>";
									else
										echo"<OPTION VALUE='$data[kdeplj]'>$data[nmaplj]</OPTION>";
								}
								echo"
							</SELECT>
						</TD>
					</TR>
					<TR><TD>Keterangan</TD>
						<TD>:";
							if($pilihan=='edit_general')
							{
								echo"
								<INPUT 	NAME		='ktr'
										TYPE		='text'
										SIZE		='50'
										MAXLENGTH	='200'
										VALUE		='$ktr'
										onkeyup		='uppercase(this.id)'
										ID			='ktr'
										CLASS		='pel1'
										TITLE		='...harus diisi'
										$isian2>";
							}
							else
							{
								echo"
								<INPUT 	NAME		='ktr'
										TYPE		='text'
										SIZE		='50'
										MAXLENGTH	='200'
										VALUE		='$ktr'
										onkeyup		='uppercase(this.id)'
										onkeypress	='return enter(this,event)'
										ID			='ktr'
										CLASS		='pel'
										TITLE		='...harus diisi'
										$isian2>";
							}
						echo"
						</TD>
					</TR>
					<TR><TD COLSPAN='3'><HR></TD></TR>
				</TABLE>	

				<TABLE BORDER='0' class='tb1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%'>
					<TR>
						<TD WIDTH='50%'  valign='top'>
							<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%'>
								<TR><TD WIDTH='10%' VALIGN='top'><center><b>Soal</b></center></TD>
									<TD WIDTH='70%'>";
										if($pilihan=='tambah_general')
										{
											echo"
											<TEXTAREA 	NAME		='soal'
														ID			='soal'
														VALUE		='$soal'
														CLASS		='textarea_01'
														onkeypress	='return enter(this,event)'
														TITLE		='...harus diisi'
														$isian3></TEXTAREA>";
										}
										else
										{
											echo"
											<INPUT		NAME='soal' ID='soal' type='hidden' VALUE='$soal'>
											<TEXTAREA 	NAME		='soal1'
														ID			='soal1'
														onkeypress	='return enter(this,event)'
														CLASS		='textarea_01'
														$isian3>$soal</TEXTAREA>";
										}
										
										if($pilihan=='detil_general' )
										{
											$gb1='../files/photo/soal/GBsoal'.$kdesl.''.$id.'.jpg';
											$gb2='../files/photo/soal/noimg.jpeg';

											if(file_exists($gb1))
											{
												echo"
												<a href='../files/photo/soal/GBsoal".$kdesl."".$id.".jpg' rel='lightbox'><img src='../files/photo/soal/GBsoal".$kdesl."".$id.".jpg'alt='' width='40' height='40'></a>
												<a href='guru.php?mode=R1D01B_HapusG&kdesl=$kdesl&id=$id&hapus=gsoal'onclick='return confirm(\"Benar gambar akan dihapus ?\");'>
												<img src='../images/delete-icon.png' width='15' height='15'  VALIGN='center'></a><br>";
											}
										}
										else
										if($pilihan=='gambar')
										{
										   $gb1='../files/photo/soal/GBsoal'.$kdesl.''.$id.'.jpg';
											$gb2='../files/photo/soal/noimg.jpeg';
										   if(!file_exists($gb1))
										   {	
												echo"
												<INPUT 	NAME		='phtsoals'
														TYPE		='file'
														size        ='3px'
														id			='phtsoals'
														VALUE		='$phtsoals'
														onkeypress	='return enter(this,event)'
														$isian4>
												<span id='preview'></span>";
                                            }
                                            else
                                            {
												echo"
												<img src='../files/photo/soal/GBsoal".$kdesl."".$id.".jpg'alt='' width='40' height='40'>
												<a href='guru.php?mode=R1D01B_HapusG&kdesl=$kdesl&id=$id&hapus=gsoal'onclick='return confirm(\"Benar gambar akan dihapus ?\");'>
												<img src='../images/delete-icon.png' width='15' height='15'  VALIGN='center'></a>";
                                            }
										}
									echo"
									</TD>
								</TR>
								<TR><TD VALIGN='top'><center><p style='font-size:18px'><b>A</b></p></center></TD>
									<TD><TEXTAREA 	NAME		='jwb1'
													ID	        ='jwb1'	
													TYPE	   	='text'
													CLASS		='textarea_02'
													onkeypress	='return enter(this,event)'
													$isian3>$jwb1</TEXTAREA>";
										if($pilihan=='detil_general' )
										{
											$gb1='../files/photo/soal/GBjwb1'.$kdesl.''.$id.'.jpg';
											$gb2='../files/photo/soal/noimg.jpeg';

											if(file_exists($gb1))
											{
												echo"
												<a href='../files/photo/soal/GBjwb1".$kdesl."".$id.".jpg' rel='lightbox'><img src='../files/photo/soal/GBjwb1".$kdesl."".$id.".jpg'alt='' width='40' height='40'></a>
												<a href='guru.php?mode=R1D01B_HapusG&kdesl=$kdesl&id=$id&hapus=gjwb1'onclick='return confirm(\"Benar gambar akan dihapus ?\");'>
												<img src='../images/delete-icon.png' width='15' height='15'  VALIGN='center'></a><br>";
											}
										}
										else
										if($pilihan=='gambar' )
										{
										  $gb1='../files/photo/soal/GBjwb1'.$kdesl.''.$id.'.jpg';
											$gb2='../files/photo/soal/noimg.jpeg';
                                            if(!file_exists($gb1))
											{
												echo"
												<INPUT 	NAME		='phtjwb1'
														TYPE		='file'
														size        ='3px'
														id			='phtjwb1'
														VALUE		='$phtjwb1'
														onkeypress	='return enter(this,event)'
														$isian4>
												<span id='preview1'></span>";
											}
											else
                                            {
												echo"
												<img src='../files/photo/soal/GBjwb1".$kdesl."".$id.".jpg'alt='' width='40' height='40'>
												<a href='guru.php?mode=R1D01B_HapusG&kdesl=$kdesl&id=$id&hapus=gjwb1'onclick='return confirm(\"Benar gambar akan dihapus ?\");'>
												<img src='../images/delete-icon.png' width='15' height='15'  VALIGN='center'></a>";
                                            }
										}
									echo"
									</TD>
								</TR>
								<TR><TD VALIGN='top'><center><p style='font-size:18px'><b>B</b></p></center></TD>
									<TD><TEXTAREA 	NAME		='jwb2'
													ID			='jwb2'
													TYPE		='text'
													CLASS		='textarea_02'
													onkeypress	='return enter(this,event)'
													$isian3>$jwb2</TEXTAREA>";
										if($pilihan=='detil_general' )
										{
											$gb1='../files/photo/soal/GBjwb2'.$kdesl.''.$id.'.jpg';
											$gb2='../files/photo/soal/noimg.jpeg';

											if(file_exists($gb1))
											{
												echo"
												<a href='../files/photo/soal/GBjwb2".$kdesl."".$id.".jpg' rel='lightbox'><img src='../files/photo/soal/GBjwb2".$kdesl."".$id.".jpg'alt='' width='40' height='40'></a>
												<a href='guru.php?mode=R1D01B_HapusG&kdesl=$kdesl&id=$id&hapus=gjwb2'onclick='return confirm(\"Benar gambar akan dihapus ?\");'>
												<img src='../images/delete-icon.png' width='15' height='15'  VALIGN='center'></a><br>";
											}
										}
										else
										if($pilihan=='gambar' )
										{
										  	$gb1='../files/photo/soal/GBjwb2'.$kdesl.''.$id.'.jpg';
											$gb2='../files/photo/soal/noimg.jpeg';

											if(!file_exists($gb1))
                                            {
												echo"
												<INPUT 	NAME		='phtjwb2'
														TYPE		='file'
														size        ='3px'
														id			='phtjwb2'
														VALUE		='$phtjwb2'
														onkeypress	='return enter(this,event)'
														$isian4>
												<span id='preview2'></span>";
											}
											else
											{
												echo"
												<img src='../files/photo/soal/GBjwb2".$kdesl."".$id.".jpg' width='40' height='40'>
												<a href='guru.php?mode=R1D01B_HapusG&kdesl=$kdesl&id=$id&hapus=gjwb2'onclick='return confirm(\"Benar gambar akan dihapus ?\");'>
												<img src='../images/delete-icon.png' width='15' height='15'  VALIGN='center'></a>";
                                            }
										}
									echo"
									</TD>
								</TR>
								<TR><TD VALIGN='top'><center><p style='font-size:18px'><b>C</b></p></center></TD>
									<TD><TEXTAREA 	NAME		='jwb3'
													ID			='jwb3'
													TYPE		='text'
													CLASS		='textarea_02'
													onkeypress	='return enter(this,event)'
													$isian3>$jwb3</TEXTAREA>";
										if($pilihan=='detil_general' )
										{
											$gb1='../files/photo/soal/GBjwb3'.$kdesl.''.$id.'.jpg';
											$gb2='../files/photo/soal/noimg.jpeg';

											if(file_exists($gb1))
											{
												echo"
												<a href='../files/photo/soal/GBjwb3".$kdesl."".$id.".jpg' rel='lightbox'><img src='../files/photo/soal/GBjwb3".$kdesl."".$id.".jpg' width='40' height='40'></a>
												<a href='guru.php?mode=R1D01B_HapusG&kdesl=$kdesl&id=$id&hapus=gjwb3'onclick='return confirm(\"Benar gambar akan dihapus ?\");'>
												<img src='../images/delete-icon.png' width='15' height='15'  VALIGN='center'></a><br>";
											}
										}
										else
										if($pilihan=='gambar' )
										{  $gb1='../files/photo/soal/GBjwb3'.$kdesl.''.$id.'.jpg';
											$gb2='../files/photo/soal/noimg.jpeg';

											if(!file_exists($gb1))
											{
												echo"
												<INPUT 	NAME		='phtjwb3'
														TYPE		='file'
														size        ='3px'
														id			='phtjwb3'
														VALUE		='$phtjwb3'
														onkeypress	='return enter(this,event)'
														$isian4>
												<span id='preview3'></span>";
											}
											else
											{
												echo"
												<img src='../files/photo/soal/GBjwb3".$kdesl."".$id.".jpg' width='40' height='40'>
												<a href='guru.php?mode=R1D01B_HapusG&kdesl=$kdesl&id=$id&hapus=gjwb3'onclick='return confirm(\"Benar gambar akan dihapus ?\");'>
												<img src='../images/delete-icon.png' width='15' height='15'  VALIGN='center'></a>";
                                            }
										}
									echo"
									</TD>
								</TR>
								<TR><TD VALIGN='top'><center><p style='font-size:18px'><b>D</b></p></center></TD>
									<TD><TEXTAREA 	NAME		='jwb4'
													ID			='jwb4'
													TYPE		='text'
													CLASS		='textarea_02'
													onkeypress	='return enter(this,event)'
													$isian3>$jwb4</TEXTAREA>";
										if($pilihan=='detil_general' )
										{
											$gb1='../files/photo/soal/GBjwb4'.$kdesl.''.$id.'.jpg';
											$gb2='../files/photo/soal/noimg.jpeg';

											if(file_exists($gb1))
											{
												echo"
												<a href='../files/photo/soal/GBjwb4".$kdesl."".$id.".jpg' rel='lightbox'><img src='../files/photo/soal/GBjwb4".$kdesl."".$id.".jpg' width='40' height='40'></a>
												<a href='guru.php?mode=R1D01B_HapusG&kdesl=$kdesl&id=$id&hapus=gjwb4'onclick='return confirm(\"Benar gambar akan dihapus ?\");'>
												<img src='../images/delete-icon.png' width='15' height='15'  VALIGN='center'></a><br>";
											}
										}
										else
										if($pilihan=='gambar' )
										{  $gb1='../files/photo/soal/GBjwb4'.$kdesl.''.$id.'.jpg';
											$gb2='../files/photo/soal/noimg.jpeg';

											if(!file_exists($gb1))
											{
												echo"
												<INPUT 	NAME		='phtjwb4'
														TYPE		='file'
														size        ='3px'
														id			='phtjwb4'
														VALUE		='$phtjwb4'
														onkeypress	='return enter(this,event)'
														$isian4>
												<span id='preview4'></span>";
											}
											else
											{
												echo"
												<img src='../files/photo/soal/GBjwb4".$kdesl."".$id.".jpg'alt='' width='40' height='40'>
												<a href='guru.php?mode=R1D01B_HapusG&kdesl=$kdesl&id=$id&hapus=gjwb4'onclick='return confirm(\"Benar gambar akan dihapus ?\");'>
												<img src='../images/delete-icon.png' width='15' height='15'  VALIGN='center'></a>";
                                            }
										}
									echo"
									</TD>
								</TR>
								<TR><TD VALIGN='top'><center><p style='font-size:18px'><b>E</b></p></center></TD>
									<TD><TEXTAREA 	NAME		='jwb5'
													ID			='jwb5'
													TYPE		='text'
													CLASS		='textarea_02'
													onkeypress	='return enter(this,event)'
													$isian3>$jwb5</TEXTAREA>";
										if($pilihan=='detil_general' )
										{
											$gb1='../files/photo/soal/GBjwb5'.$kdesl.''.$id.'.jpg';
											$gb2='../files/photo/soal/noimg.jpeg';
											if(file_exists($gb1))
											{
												echo"
												<a href='../files/photo/soal/GBjwb5".$kdesl."".$id.".jpg' rel='lightbox'><img src='../files/photo/soal/GBjwb5".$kdesl."".$id.".jpg'alt='' width='40' height='40'></a>
												<a href='guru.php?mode=R1D01B_HapusG&kdesl=$kdesl&id=$id&hapus=gjwb5'onclick='return confirm(\"Benar gambar akan dihapus ?\");'>
												<img src='../images/delete-icon.png' width='15' height='15'  VALIGN='center'></a><br>";
											}
										}

										else
										if($pilihan=='gambar' )
										{
											$gb1='../files/photo/soal/GBjwb5'.$kdesl.''.$id.'.jpg';
											$gb2='../files/photo/soal/noimg.jpeg';
											if(!file_exists($gb1))
											{
												echo"
												<INPUT 	NAME		='phtjwb5'
														TYPE		='file'
														size        ='3px'
														id			='phtjwb5'
														VALUE		='$phtjwb5'
														onkeypress	='return enter(this,event)'
														$isian4>
												<span id='preview5'></span>";
											}
											else
											{
												echo"
												<img src='../files/photo/soal/GBjwb5".$kdesl."".$id.".jpg'alt='' width='40' height='40'>
												<a href='guru.php?mode=R1D01B_HapusG&kdesl=$kdesl&id=$id&hapus=gjwb5'onclick='return confirm(\"Benar gambar akan dihapus ?\");'>
												<img src='../images/delete-icon.png' width='15' height='15'  VALIGN='center'></a>";
                                            }
                                        }
									echo"
									</TD>
								</TR>
								<TR><TD><center><b>Jawaban</b></center></TD>
									<TD><INPUT 	NAME		='sttjwb'
												ID	        ='sttjwb'
												TYPE	    ='text'
												SIZE	    ='1'
												MAXLENGTH   ='1'
												VALUE		='$sttjwb'
												onkeyup		='uppercase(this.id)'
												CLASS		='required'
												TITLE		='...harus diisi'
												onkeypress	='return enter(this,event)'
												$isian3>";
							
										if($pilihan=='edit_item')
										{
											echo"
											<INPUT TYPE='button'   	id='submitup'	VALUE='Simpan'>";
										}	
										if($pilihan=='tambah_general' or $pilihan=='tambah_item')
										{
											echo"
											<INPUT TYPE='button'  				id='submitsl'	VALUE='Simpan'>
											<INPUT TYPE='hidden' NAME='pilihan' id='edt'		VALUE='tambah_general'>";
										}	
										if($pilihan!='tambah_general' and $pilihan!='tambah_item' and $pilihan!='edit_general')
										{
											echo" 
											<INPUT TYPE='button' 	VALUE='Tambah No. Soal' onClick=window.location.href='guru.php?mode=R1D01B_Soal&kdesl=$kdesl1&pilihan=tambah_item'>";
										}
										if($pilihan=='edit_general')
										{
											echo"
											<INPUT TYPE='hidden' 	NAME='pilihan' 	id='edt'	VALUE='edit_general'>
											<INPUT TYPE='hidden' 	NAME='kdeslB' 	id='kdeslB'	VALUE='$kdesl'>
											<INPUT TYPE='hidden'	NAME='kdesl' 	id='kdesl'	VALUE='$kdesl'>
											<INPUT TYPE='hidden' 	NAME='kdeplj' 	id='kdeplj'	VALUE='$kdeplj'>";
										}
										if($pilihan=='gambar')
										{
											echo"
											<INPUT TYPE='hidden' NAME='gambar'id='gambar' VALUE=''>
											<INPUT TYPE='button' VALUE='Kembali' onClick=window.location.href='guru.php?mode=R1D01B_Soal&kdesl=$kdesl1&pilihan=detil_general'>";
										}
										if($pilihan=='detil_general')
										{
											echo"
											<INPUT TYPE='hidden' NAME='hapus' id='hapus' VALUE=''>";
										}
									echo"
									</TD>
								</TR>
							</TABLE>
						</TD>
				
						<TD WIDTH='50%' valign='top'><B>DAFTAR SOAL</B>
							<div style='overflow:auto;width:100%;height:319px;padding-right:-2px;'>                
								<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' >
									<TR bgcolor='dedede'>
										<TD WIDTH=' 5%' HEIGHT='20'><CENTER>No		</CENTER></TD>
										<TD WIDTH='55%'><CENTER>Soal  	</CENTER></TD>
										<TD WIDTH='10%'><CENTER>Gambar  </CENTER></TD>
										<TD WIDTH='10%'><CENTER>Detil	</CENTER></TD>
										<TD WIDTH='10%'><CENTER>Edit	</CENTER></TD>
										<TD WIDTH='10%'><CENTER>Hapus	</CENTER></TD>
									</TR>
								</TABLE>

								<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='soal2' >";
									$no=0;
									while($data =mysql_fetch_array($result))
									{
										$soal = susun_kalimat($data['soal'],65);
										$no++;
										echo"
										<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
											<TD WIDTH=' 5%'><CENTER>$no			</CENTER></TD>
											<TD WIDTH='55%'>$soal[0]...</TD>";
											// otorisasi
											if ($pilihan=='detil_general')
											{
												echo"<TD WIDTH=' 10%'><CENTER><a href='guru.php?mode=R1D01B_Soal&kdesl=$data[kdesl]&id=$data[id]&pilihan=gambar'><IMG src='../images/images_e.gif' BORDER='0'></a></CENTER></TD>";
											}
											else
											{
												echo"<TD WIDTH='10%'><CENTER><IMG src='../images/images_d.gif' BORDER='0'></a></CENTER></TD>";
											}
											if ($pilihan=='detil_general')
											{
												echo"<TD WIDTH=' 10%'><CENTER><a href='guru.php?mode=R1D01B_Soal&kdesl=$data[kdesl]&id=$data[id]&pilihan=detil_general'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
											}
											else
											{
												echo"<TD WIDTH='10%'><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
											}
											if ($pilihan=='detil_general')
											{
												echo"<TD WIDTH='10%'><CENTER><a href='guru.php?mode=R1D01B_Soal&kdesl=$data[kdesl]&id=$data[id]&pilihan=edit_item'><IMG src='../images/edit_e.gif' BORDER='0'></a></CENTER></TD>";
											}
											else
											{
												echo"<TD WIDTH='10%'><CENTER><IMG src='../images/edit_d.gif' BORDER='0'></a></CENTER></TD>";
											}
											if ($pilihan=='detil_general')
											{
												echo"<TD WIDTH='10%'><CENTER><a href='#' id='$data[id]'class='hapussl'><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
											}
											else
											{
												echo"<TD WIDTH='10%'><CENTER><IMG src='../images/hapus_d.gif' BORDER='0'></a></CENTER></TD>";
											}
										echo"
										</TR>";
									}
									echo"
									<script type='text/javascript' src='../js/jquery.min.js'></script>
									<script type='text/javascript' src='../js/jquery.form.js'></script>

									<style>
										body
										{
											font-family:arial;
										}
										.preview.preview1.preview2.preview3.preview4.preview5
										{
											width:50px;
											border:solid 1px #dedede;
											padding:3px;
										}
										#preview#preview1#preview2#preview3#preview4#preview5
										{
											margin-top:55px;
											color:#cc0000;
											font-size:10px
										}
									</style>
									<SCRIPT TYPE='text/javascript' src='../js/jquery-mins.js'></SCRIPT>
									<SCRIPT TYPE='text/javascript' src='../guru/js/R1D01B_hapus.js'></SCRIPT>
								</TABLE>
							</DIV>";	
							echo"
							<script type='text/javascript'>
							<!--
								function confirmation()
								{
									var answer = confirm('Benar data akan dihapus ?')
									if (answer)
									{
										window.location.href='guru.php?mode=R1D01B_Hapus&kdesl=$kdesl';
									}
								}
								//-->
							</script>";

							echo"
							<INPUT TYPE='button' VALUE='Buat Soal' onClick=window.location.href='guru.php?mode=R1D01B_Soal&pilihan=tambah_general'>";

							if ($pilihan=='detil_general')
							{
								echo"
								<INPUT TYPE='button' VALUE='Edit' onClick=window.location.href='guru.php?mode=R1D01B_Soal&kdesl=$kdesl&pilihan=edit_general'>
								<INPUT TYPE='button' VALUE='Hapus' onClick='confirmation()'>";
							}	
							if ($pilihan=='detil_general' or $pilihan=='tambah_item')
							{
								echo"
								<INPUT TYPE='button' VALUE='Cetak' 	onClick=window.open('pendataan/R1D01B_C01.php?kdesl=$kdesl')>";					
							}
							echo"
							<INPUT TYPE='button' 	VALUE='Daftar Soal' 	onClick=window.location.href='guru.php?mode=R1D01B_Cari'>
						</TD>	
					</TR>
				</TABLE>
			</FORM>	
		</BODY>";
	}

	// -------------------------------------------------- Hapus --------------------------------------------------
	function R1D01B_Hapus()
	{
		$kdesl	=$_GET['kdesl'];

		$sql	="	DELETE
					FROM  g_gnrsal
					WHERE 	g_gnrsal.kdesl='". mysql_escape_string($kdesl)."'";
		$result	=mysql_query($sql) or die ("Query failed - Mysql");

		$sql	="	DELETE
					FROM  	g_dtlsal
					WHERE 	g_dtlsal.kdesl='". mysql_escape_string($kdesl)."'";
		$result	=mysql_query($sql) or die ("Query failed - Mysql");
		
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D01B_Cari\">\n";
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function R1D01B_Save()
	{
		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';

  		$kdegru	=$_POST['kdegru'];
  		$kdesl	=$_POST['kdesl'];
  		$kdeslB	=$_POST['kdeslB'];
  		$kdeplj	=$_POST['kdeplj'];
  		$ktr	=str_replace(" ","-",($_POST['ktr']));
  		$pilihan=$_POST['pilihan'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");
		
		if ($pilihan=='tambah_general')
		{
			$kdesl = nomor_soal($kdeplj);
		}
		$set	="	SET		g_gnrsal.kdegru	='". mysql_escape_string($kdegru)."',
		                    g_gnrsal.kdesl	='". mysql_escape_string($kdesl)."',
		                    g_gnrsal.kdeplj	='". mysql_escape_string($kdeplj)."',
		                    g_gnrsal.ktr	='". mysql_escape_string($ktr)."',
							g_gnrsal.tglrbh	='". mysql_escape_string($tglrbh)."',
							g_gnrsal.jamrbh	='". mysql_escape_string($jamrbh)."'";

  		if ($pilihan=='edit_general')
  		{
    		$query 	="	UPDATE 	g_gnrsal ".$set.
					 "	WHERE 	g_gnrsal.kdesl	='". mysql_escape_string($kdeslB)."'";
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
        }
  		else
  		{
  			$query 	="INSERT INTO g_gnrsal ".$set;
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
			$kdeslB=$kdesl;
  		}
 	}

	// -------------------------------------------------- Hapus gambar --------------------------------------------------
	function R1D01B_HapusG()
	{
	    $kdesl	=$_GET[kdesl];
        $id		=$_GET[id];
        $hapus	=$_GET[hapus];
        if($hapus=='gsoal')
        {
			$files = glob('../files/photo/soal/GBsoal'.$kdesl.''.$id.'.jpg');
			foreach($files as $file) 
			{
				unlink($file);
			}
        }
        if($hapus=='gjwb1')
        {
			$files = glob('../files/photo/soal/GBjwb1'.$kdesl.''.$id.'.jpg');
			foreach($files as $file) 
			{
			unlink($file);
			}
        }
        if($hapus=='gjwb2')
        {
			$files = glob('../files/photo/soal/GBjwb2'.$kdesl.''.$id.'.jpg');
			foreach($files as $file) 
			{
			unlink($file);
			}
        }
        if($hapus=='gjwb3')
        {
			$files = glob('../files/photo/soal/GBjwb3'.$kdesl.''.$id.'.jpg');
			foreach($files as $file) 
			{
				unlink($file);
			}
        }
        if($hapus=='gjwb4')
        {
			$files = glob('../files/photo/soal/GBjwb4'.$kdesl.''.$id.'.jpg');
			foreach($files as $file) 
			{
				unlink($file);
			}
        }
        if($hapus=='gjwb5')
        {
			$files = glob('../files/photo/soal/GBjwb5'.$kdesl.''.$id.'.jpg');
			foreach($files as $file) 
			{
				unlink($file);
			}
        }

		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D01B_Soal&kdesl=$kdesl&id=$id&pilihan=gambar\">\n";
	}
}//akhir class
?>