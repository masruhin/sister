<?php
//----------------------------------------------------------------------------------------------------
//Program		: UJO01.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi BUKTI KELUAR BARANG
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class UJO01class
{
	// -------------------------------------------------- Daftar Ujian --------------------------------------------------
	function UJO01()
	{
		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';

		// deklarasi java
		echo"
		<LINK 	href='../css/val.css' 		rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 		src='../js/jquery-validate.js'></SCRIPT>";

		$nis	=$_SESSION["Admin"]["nis"];
        $kdekls	=$_SESSION["Admin"]["kdekls"];
        $kdeoln =nomor_ujian($kdeplj,$kdekls);

		// akhir inisiasi parameter
		$query 	="	SELECT 	   	g_gnrrcu.*,t_mstpng.*,t_mstplj.*,t_mstbbt.*
					FROM  		g_gnrrcu,t_mstpng,t_mstplj,t_mstbbt
					WHERE 		t_mstpng.kdekls='$kdekls'			AND
                                t_mstpng.kdegru=g_gnrrcu.kdegru AND
                                t_mstpng.kdeplj=g_gnrrcu.kdeplj AND
                                t_mstpng.kdeplj=t_mstplj.kdeplj AND
                                g_gnrrcu.kdebbt=t_mstbbt.kdebbt AND
                                g_gnrrcu.kdekls='$kdekls'
					ORDER BY	t_mstplj.nmaplj,g_gnrrcu.tglrcu";
		$result	=mysql_query($query)	or die (mysql_error());

		echo"
		<FORM NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD WIDTH='90%'><B>DAFTAR TES ONLINE</B></TD><TD WIDTH='10%'><DIV class='LeftMenuHead' onclick='clickOpenPage(\"../guru/index.php\",\"_top\"); return false;' style='cursor: pointer;'><IMG src='../images/logout.png' WIDTH='16' HEIGHT='16' ALIGN='absmiddle'> LOGOUT </DIV></TD></TR>
				<TR></TR><TR></TR>
			<TABLE>	
			<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' >
				<TR bgcolor='dedede'>
					<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
					<TD WIDTH='60%'><CENTER>Pelajaran  	</CENTER></TD>
					<TD WIDTH='10%'><CENTER>Tanggal		</CENTER></TD>
					<TD WIDTH='10%'><CENTER>Jam			</CENTER></TD>
					<TD WIDTH='10%'><CENTER>Jenis		</CENTER></TD>
					<TD WIDTH=' 4%'><CENTER>Mulai</CENTER></TD>
				</TR>";
				$no=0;
				while($data =mysql_fetch_array($result))
				{
					$std	='Disabled';
					$kdercu	=$data[kdercu];
					$nmaplj	=$data[nmaplj];
					$kdeplj	=$data[kdeplj];
					$stt   	=$data[stt];
					$nmaujn	=$data[nmabbt];
					$tglrcu	=$data[tglrcu];
					$jam	=$data[jamrcu];
					$nli	=$data[nli];
					{
						$no++;
						echo"
						<TR onMouseOver=\"this.classname='highlight'\" onMouseOut=\"this.classname='normal'\">
							<TD><CENTER>$no		</CENTER></TD>
							<TD><CENTER>$nmaplj	</CENTER></TD>
							<TD><CENTER>$tglrcu	</CENTER></TD>
							<TD><CENTER>$jam	</CENTER></TD>
							<TD><CENTER>$nmaujn	</CENTER></TD>";
							if($stt!=$std)
							{
								echo"
								<TD><CENTER><a href='ujian_online.php?mode=UJO01_Save&kdercu=$kdercu&nis=$nis'><IMG src='../images/mulai_e.gif' BORDER='0'></a></CENTER></TD>";
							}
							else
							{
								echo"
								<TD><CENTER><IMG src='../images/mulai_d.gif' BORDER='0'></a></CENTER></TD>";
							}
						echo"			
						</TR>";
					}	
				}
			echo"
			</TABLE>
			<INPUT 	TYPE='hidden' 	NAME='kls' 		id='kls' 	value='$kdekls'>
            <INPUT 	TYPE='hidden' 	NAME='nis' 		id='nis' 	value='$nis'>
            <INPUT 	TYPE='hidden' 	NAME='kdeplj' 	id='kdeplj' value='$kdeoln'>
		</FORM>";
	}

	// -------------------------------------------------- Layar Ujian --------------------------------------------------
	function UJO01_ujian()
	{
		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';
		
		$nis	=$_SESSION["Admin"]["nis"];
        $kdekls	=$_SESSION["Admin"]["kdekls"];
        $kdeoln	=$_GET[kdeoln];
        $query 	="	SELECT 		u_gnroln.*,g_gnrrcu.kdercu,t_mstplj.nmaplj
					FROM  		u_gnroln,g_gnrrcu,t_mstplj
					WHERE   	u_gnroln.kdeoln='$kdeoln'AND
                                u_gnroln.kdercu=g_gnrrcu.kdercu AND
                                g_gnrrcu.kdeplj=t_mstplj.kdeplj
					ORDER BY	u_gnroln.kdeoln";
		$result	=mysql_query($query)	or die (mysql_error());
        while($data=mysql_fetch_array($result))
        {
			$nmaplj=$data['nmaplj'];
			$kdercu=$data['kdercu'];
         }
		// deklarasi java
		echo"
		<LINK 	href='../css/val.css' 		rel='stylesheet' TYPE='text/css'>
        <LINK 	href='../css/fullscreen.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 		src='../js/jquery-validate.js'></SCRIPT>";
		
		echo"
		<LINK 	href='../css/lightbox2.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' src='../ujian_online/js/UJO01.js'></SCRIPT>";

		echo"
		<script>
			function openWindow()
			{
				var docElm = document.documentElement;
				if (docElm.requestFullscreen) 
				{
					docElm.requestFullscreen();
				}
				else if (docElm.mozRequestFullScreen) 
				{
					docElm.mozRequestFullScreen();
				}
				else if (docElm.webkitRequestFullScreen) 
				{
					docElm.webkitRequestFullScreen();
				}
				else if(typeof window.ActiveXObject!='undefined')
				{
					var wscript = new ActiveXObject('WScript.Shell');
					if (wscript!=null) 
					{
						wscript.SendKeys('{F11}');
					}
				}
			}
		</script>
        <script language=JavaScript>
    document.onkeydown = function (e) {
            if(e.which == 115 ||e.which == 116 ||e.which == 9 || e.which == 122 || e.which == 20 || e.which == 27){
                    return false;
            }
           if(e.which==17 && e.which==83){
             return false;
           }
         if(altKey&&keyCode==115) // disable alt+f4
          {
return cancel();
}
if(keyCode==18&&keyCode==9) // disable alt+tab
{
return cancel();
}
if(e.keyCode==27) // disable alt+tab
{
return cancel();
}

}


</script>";

		// akhir inisiasi parameter
        $stt	='Enable';
		$query 	="	SELECT 		u_dtloln.*
					FROM  		u_dtloln
					WHERE 		u_dtloln.kdeoln='$kdeoln'
					ORDER BY 	u_dtloln.id";
		$result	= mysql_query($query)	or die (mysql_error());

		echo"
        <body onload='openWindow();'>
		<FORM ID='validasi'  METHOD='post'ACTION='../ujian_online/fungsi_khusus/saveol.php' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>TES ONLINE</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='10%'>Kode Ujian</TD>
					<TD WIDTH='90%'>:
						<INPUT 	TYPE='hidden' 	NAME='nli' 		id='nli' value=''>
						<INPUT 	TYPE='hidden' 	NAME='nmaujn' 	id='nmaujn' value='$nmaujn'>
                        <INPUT 	TYPE='hidden' 	NAME='kdeoln' 	id='kdeoln' value='$kdeoln'><b>$kdeoln</b>
                        No.Induk Siswa : 
						<INPUT 	TYPE='hidden' 	NAME='nis' id='nis' value='$nis'><b>$nis</b>
						Kelas  : 
						<INPUT 	TYPE='hidden'   size='3'	NAME='kls' id='kls' value='$kdekls'><b>$kdekls</b>
					</TD>
              	</TR>
              	<TR><TD>Pelajaran</TD>
					<TD>:
						<INPUT 	TYPE='hidden' 	NAME='kdercu' id='kdercu' value='$kdercu'>
						<INPUT 	TYPE='hidden' 	NAME='kdeplj' id='kdeplj' value='$kdeplj'><b>$nmaplj</b>
					</TD>
				</TR>
				<TR><TD COLSPAN='3'><HR></TD></TR>
			</TABLE>

			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='2' CELLSPACING='2' WIDTH='100%' id='uol'>
				<TR>
					<TD WIDTH='10%' VALIGN='top'>
						<FORM  id='validasi'>
							<div style='overflow:auto;width:100%;height:350px;padding-right:-2px;'>
								<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' >
									<TR bgcolor='dedede'>
										<TD WIDTH=' 30%' HEIGHT='20'><CENTER>No	</CENTER></TD>
										<TD WIDTH=' 70%'><CENTER>Baca Soal		</CENTER></TD>
									</TR>";
									$no=0;
									while($data =mysql_fetch_array($result))
									{
										$soal 	=$data['soal'];
										$sttjwb =$data['sttjwb'];
										$no++;
										echo"
										<TR onMouseOver=\"this.classname='highlight'\" onMouseOut=\"this.classname='normal'\">
											<TD><CENTER>$no	</CENTER></TD>
											<TD><CENTER>";
												if($sttjwb!='')
												{
													echo"<a href='#' id='$data[id]' class='dety'><IMG src='../images/edit_d.gif' BORDER='0'></a>";
												}
												else
												{
													echo"<a href='#' id='$data[id]'  onclick='openWindow();' class='dety'><IMG src='../images/edit_e.gif' BORDER='0'></a>";
												}
											echo"
											</CENTER></TD>
										</TR>";
									}
								echo"
								</TABLE>
							</DIV></BR>	
						</FORM>
					</TD>	
					<TD WIDTH=' 5%'></TD>
					<TD WIDTH='40%'  VALIGN='top' align='left'><b>SOAL</b><br>
						<TEXTAREA 	NAME		='soal'
									ID			='soal'
									ROWS		='17'
									COLS      	='50'
									VALUE		='$kdeplj'
									onkeypress	='return enter(this,event)'
									TITLE		='...harus diisi'
									$isian3></TEXTAREA>
					</TD>
					<TD WIDTH=' 5%'></TD>
					<TD WIDTH='40%' VALIGN='top'><b>PILIHAN JAWABAN</b>
						<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%'>
							<TR>
								<TD WIDTH='10%' VALIGN='center'><input type='hidden' name='id' id='id' value='$id'>
									<input 	type	='radio'
											name	='sttjwb'
											id		='sttjwb'
											value	='A'>A
								</TD>
								<TD WIDTH='80%'>
									<TEXTAREA	ROWS	='2'
												COLS  	='50'
												$isian>$jwb1</TEXTAREA>
								</TD>
								<TD WIDTH='10%'></TD>
							</TR>
							<TR>
								<TD VALIGN='center'>
									<input 	type	='radio'
											name	='sttjwb'
											id		='sttjwb'
											value	='B'>B
								</TD>
								<TD><TEXTAREA	ROWS	='2'
												COLS    ='50'
												$isian>$jwb2</TEXTAREA>
								</TD>
							</TR>
							<TR>
								<TD VALIGN='center'>
									<input 	type	='radio'
											name	='sttjwb'
											id		='sttjwb'
											value	='C'>C
								</TD>
								<TD><TEXTAREA	ROWS	='2'
												COLS   	='50'
												$isian>$jwb3</TEXTAREA>
								</TD>
							</TR>
							<TR>
								<TD VALIGN='center'>
									<input 	type	='radio'
											name	='sttjwb'
											id		='sttjwb'
											value	='D'>D
								</TD>
								<TD><TEXTAREA	ROWS	='2'
												COLS   	='50'
												$isian>$jwb4</TEXTAREA>
								</TD>
							</TR>
							<TR>
								<TD VALIGN='center'>
									<input 	type	='radio'
											name	='sttjwb'
											id		='sttjwb'
											value	='E'>E
								</TD>
								<TD><TEXTAREA	ROWS	='2'
												COLS   	='50'
												$isian>$jwb5</TEXTAREA>
								</TD>
							</TR>
						</TABLE>
					</TD>
				</TR>
			</TABLE>
		</FORM>
        </BODY>";
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function UJO01_Save()
	{
		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';

        $nis	=$_SESSION["Admin"]["nis"];
  		$kdercu	=$_GET['kdercu'];
        $tglujn =date("d-m-Y");
       	$jamujn	=date("h:i:s");
		$thn	='Tahun Ajaran';
		$sms	='Semester';
	
		$query 	=mysql_query("	SELECT 		t_setthn.* 
								FROM 		t_setthn
								WHERE		t_setthn.set='$thn'");
		$data 	=mysql_fetch_array($query);
		$thnajr	=$data[nli];
	
		$query 	=mysql_query("	SELECT 		t_setthn.* 
								FROM 		t_setthn
								WHERE		t_setthn.set='$sms'");
		$data 	=mysql_fetch_array($query);
		$kdesms =$data[nli];
		
		$query 	="	SELECT 		u_gnroln.*
					FROM 		u_gnroln
					WHERE 		u_gnroln.nis	='$nis'	AND
								u_gnroln.kdercu	='$kdercu'";
		$result	=mysql_query($query)	or die (mysql_error());
		$data 	=mysql_fetch_array($result);
        $kdeoln	=$data[kdeoln];
		
        if($data[nli]!=0)
        {
			echo"
			<script>
				alert('Anda Sudah Melakukan Ujian Dengan Nilai $data[nli]')
				window.location.href= 'ujian_online.php?mode=UJO01';
			</script>";
        }

		if($nis!=$data[nis] and $data[kdercu]=='')
		{
			$query 	="	SELECT 		g_gnrrcu.*
						FROM 		g_gnrrcu
						WHERE 		g_gnrrcu.kdercu='$kdercu'";
			$result	=mysql_query($query)	or die (mysql_error());
			$data 	=mysql_fetch_array($result);
			$kdekls	=$data[kdekls];
			$kdeplj	=$data[kdeplj];

			$kdeoln =nomor_ujian($kdeplj,$kdekls);

			$set	="	SET		u_gnroln.kdeoln	='". mysql_escape_string($kdeoln)."',
								u_gnroln.thnajr	='". mysql_escape_string($thnajr)."',
								u_gnroln.kdesms	='". mysql_escape_string($kdesms)."',
								u_gnroln.nis	='". mysql_escape_string($nis)."',
								u_gnroln.kdercu	='". mysql_escape_string($kdercu)."',
								u_gnroln.kdeplj	='". mysql_escape_string($kdeplj)."',
								u_gnroln.kdekls	='". mysql_escape_string($kdekls)."',
								u_gnroln.tglujn	='". mysql_escape_string($tglujn)."',
								u_gnroln.jamujn	='". mysql_escape_string($jamujn)."'";

			$query 	="	INSERT INTO u_gnroln ".$set;
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));


			$query ="	INSERT INTO u_dtloln (kdeoln,soal,jwb1,jwb2,jwb3,jwb4,jwb5,kdegbr)
						SELECT '$kdeoln' as kdeoln,soal,jwb1,jwb2,jwb3,jwb4,jwb5,kdegbr 
						FROM 	g_dtlrcu 
						WHERE 	g_dtlrcu.kdercu='$kdercu'";
			$result	=mysql_query ($query)	or die(error("Data tidak berhasil di Input $kdeoln $kdercu")) ;
		}

	   echo"<meta http-equiv='refresh' content=\"0;url=ujian_online.php?mode=UJO01_Ujian&kdeoln=$kdeoln#\">\n";
 	}
}//akhir class
?>