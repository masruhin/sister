<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D01A.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi MATERI PELAJARAN
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D01Aclass
{
	// -------------------------------------------------- Item --------------------------------------------------
	function R1D01A()
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
		<SCRIPT TYPE='text/javascript' 		src='../js/jquery-validate.js'></SCRIPT>";

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
		//agar kursor keposisi isian1 kode barang
		function sf()
		{ 
			document.f1.kdeplj.focus();
		}
		</SCRIPT>";

		// inisiasi parameter berdasarkan pilihan tombol
		$pilihan=$_GET['pilihan'];

		if (empty($pilihan))
		{
			$pilihan='tambah_general';
		}

		switch($pilihan)
		{
			case 'detil_general':
				$isian1 ='disabled';
				$isian2	='disabled';
				$isian3	='disabled';
				break;
			case 'tambah_general':
				$isian1	='enable';
				$isian2	='enable';
				$isian3	='enable';
				$user1	=$user;
                $kdemtr =nomor_mtr();
				break;
			case 'tambah_item':
				$isian1	='disabled';
				$isian2	='disabled';
				$isian3	='enable';
				break;
		}

		if ($pilihan=='detil_general'  or $pilihan=='tambah_item' )
		{
			$kdemtrB=$_GET['kdemtr'];
			$query 	="	SELECT 	g_gnrmtr.*
						FROM 	g_gnrmtr
						WHERE 	g_gnrmtr.kdemtr='". mysql_escape_string($kdemtrB)."'";
			$result =mysql_query($query);
			$data 	=mysql_fetch_array($result);
            $kdemtr	=$data['kdemtr'];
			$kdegru	=$data['kdegru'];
            $kdeplj =$data['kdeplj'];
            $ktr    =$data['ktr'];
            $kdeklm	=$data['kdeklm'];

		}	
		if ($pilihan=='detil_general' or $pilihan=='tambah_item')
		{	
			$id=$_GET['id'];
			$query1 ="	SELECT 		g_dtlmtr.*
						FROM 		g_dtlmtr
						WHERE 		g_dtlmtr.kdemtr='". mysql_escape_string($kdemtr)."'";
			$result =mysql_query($query1);
			$data1 	=mysql_fetch_array($result);
			$nmamtr	=$data1['nmamtr'];
		}

		// akhir inisiasi parameter
		$query2 ="	SELECT 		g_dtlmtr.*,t_mstkry.*
					FROM  		g_dtlmtr,t_mstkry
					WHERE 		g_dtlmtr.kdemtr='". mysql_escape_string($kdemtr)."'AND
                                g_dtlmtr.kdegru=t_mstkry.kdekry
					ORDER BY g_dtlmtr.id";
		$result= mysql_query($query2) or die (mysql_error());

		echo"
		<BODY onload='sf();'>
			<SCRIPT TYPE='text/javascript' src='../guru/js/R1D01A.js'></SCRIPT>
			<FORM ID='validasi'  ACTION='guru.php'METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
				<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
					<TR><TD COLSPAN='2'><B>MATERI PELAJARAN</B></TD></TR>
					<TR></TR><TR></TR>
					<TR><TD WIDTH='10%'>Pelajaran</TD>
						<TD WIDTH='90%'>:

							<INPUT TYPE='hidden' 	NAME='kdemtr'  	id='kdemtr'value='$kdemtr'>
							<INPUT TYPE='hidden' 	NAME='kdegru' id='kdegru'	VALUE='$user'>
							<SELECT NAME	='kdeplj'
									ID		='kdeplj'
									class	='kdeplj'
									value='$kdeplj'
									$isian1>
                                    <OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
							$query2="	SELECT 		DISTINCT t_mstplj.kdeplj,t_mstplj.nmaplj
										FROM 		t_mstpng,t_mstplj
										WHERE		t_mstpng.kdegru='$user' AND
													t_mstpng.kdeplj=t_mstplj.kdeplj";
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

							Kelas :
							<SELECT NAME	='kdeklm'
									ID		='kdeklm'
									class	='kdeklm'
									value='$kdeklm'
									disabled>
							<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
							$query2="	SELECT 	 	DISTINCT t_mstkls.kdeklm
										FROM 	   t_mstkls,t_mstpng
										WHERE       t_mstkls.kdekls=t_mstpng.kdekls AND
                                                    t_mstpng.kdegru='$user'
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
						</TD>
					</TR>
					<TR><TD>Judul Materi</TD>
						<TD>:
							<INPUT 	NAME		='nmamtr'
									TYPE		='text'
									SIZE		='50'
									MAXLENGTH	='200'
									VALUE		=''
									onkeyup		='uppercase(this.id)'
									ID			='nmamtr'
									CLASS		='required'
									TITLE		='...harus diisi'
									$isian3>
									Upload File :
							<INPUT 	NAME		='pdf'
									TYPE		='file'
									SIZE		='20'
									MAXLENGTH	='50'
									VALUE		='$pdf'
									id		    ='pdf'
									class       ='required'
									onkeypress	='return enter(this,event)'
									$isian3>&nbsp

							<input type='hidden' name='stt' id='stt' value='Disabled'>";
					
							if($pilihan!=detil_general)
							{
								echo"
								<INPUT TYPE='submit' 				VALUE='Input'>";
							}
							echo"
						</TD>
					</TR>
					<INPUT TYPE='hidden' NAME='mode'  id='mode'	VALUE='R1D01A_Save_Item'></TR>
				</TABLE>	

				<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
					<TR>
						<TD WIDTH='100%' valign='top'>
							<div style='overflow:auto;width:100%;height:330px;padding-right:-2px;'>                
								<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' >
									<TR bgcolor='dedede'>
										<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
										<TD WIDTH='35%'><CENTER>Judul Materi  	</CENTER></TD>
                                        <TD WIDTH='30%'><CENTER>Guru  	</CENTER></TD>
                                        <TD WIDTH='12%'><CENTER>Tanggal/Jam  	</CENTER></TD>
                                        <TD WIDTH='7%'><CENTER>Status  	</CENTER></TD>
										<TD WIDTH=' 7%'><CENTER>Detil  			</CENTER></TD>
										<TD WIDTH=' 7%'><CENTER>Hapus			</CENTER></TD>
									</TR>
									<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='materi'>
									</TABLE>

									<FORM  id='validasi'>
										<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%'  >";
											$no=0;
											while($data =mysql_fetch_array($result))
											{   $id=$data['id'];
												$nmamtr2	=$data['nmamtr'];
                                                $nmakry	=$data['nmakry'];
                                                $kdegru=$data['kdegru'];
                                                $stt1   =$data['stt'];
                                                $tglinp=$data['tglinp'];
                                                $jaminp=$data['jaminp'];
												$type=$data['type'];
												$no++;
												echo"
												<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
													<TD WIDTH=' 4%'><CENTER>$no			</CENTER></TD>
													<TD WIDTH='35%'>$nmamtr2</TD>
                                                    <TD WIDTH='30%'><center>$nmakry</center></TD>
                                                    <TD WIDTH='12%'><center>$tglinp/$jaminp</center></TD>";
                                                    if($kdegru!=$user)
                                                            {
                                                          echo"<TD WIDTH='7%'><center><img src='../images/disable.gif'></center></TD>";
                                                            }
                                                    else
                                                            {
                                                              if($stt1=='Enabled')
                                                              {
                                                             echo"<TD WIDTH='7%'><center><a href='#' stt='$stt1' id='$nmamtr2'class='stt1'><img src='../images/enable.gif' ></a></center></TD>";
                                                             }
                                                             else
                                                             {
                                                               echo"<TD WIDTH='7%'><center><a href='#' stt='$stt1' id='$nmamtr2'class='stt1'><img src='../images/disable.gif' ></a></center></TD>";
                                                             }
                                                    }

													// otorisasi

													if ($pilihan=='detil_general' or $pilihan=='tambah_item')
													{

                                                        echo"
														<TD WIDTH='7%'><CENTER><a href='../files/materi/$kdemtr/$nmamtr2.$type'target='_blank'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
                                                        if($kdegru!=$user)
                                                        {
                                                          echo"
                                                          <TD WIDTH='7%'><CENTER><IMG src='../images/hapus_d.gif' BORDER='0'></CENTER></TD>";
                                                        }
                                                        else
                                                        {
                                                        echo"
														<TD WIDTH='7%'><CENTER><a href='#' id='$data[id]'class='hapusmtr'><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
                                                        }
													}
													else
													{
														echo"<TD WIDTH='4%'><CENTER><IMG src='../images/hapus_d.gif' BORDER='0'></CENTER></TD>";
													}
												echo"
												</TR>";
											}
											echo"
											<SCRIPT TYPE='text/javascript' src='../js/jquery-mins.js'></SCRIPT>
											<SCRIPT TYPE='text/javascript' src='../guru/js/R1D01A_hapus.js'></SCRIPT>
										</TABLE>
									</FORM>
								</TABLE>
							</DIV>	
						</TD>
					</TR>
					<TR>
						<TD ALIGN='left'>
							<INPUT TYPE='button' VALUE='Buat Materi' onClick=window.location.href='guru.php?mode=R1D01A&pilihan=tambah_general'>";

							if ($pilihan=='detil_general')
							{
								echo"
								<INPUT TYPE='button' VALUE='Tambah Materi' onClick=window.location.href='guru.php?mode=R1D01A&kdemtr=$kdemtr&pilihan=tambah_item'>
								<INPUT TYPE='button' VALUE='Hapus' onClick='confirmation()'>";
							}	
							if ($pilihan=='detil_general' or $pilihan=='tambah_item')
							{
								echo"
								<INPUT TYPE='button' VALUE='Cetak' 	onClick=window.open('pendataan/R1D01A_Cetak.php?kdemtr=$kdemtr')>";
							}
						echo"
						</TD>
					</TR>
				</TABLE>
			</FORM>	
		</BODY>";
	}

	// -------------------------------------------------- Save General --------------------------------------------------
	function R1D01A_Save()
	{
		require_once '../fungsi_umum/sysconfig.php';

        $kdemtr	=$_POST['kdemtr'];
        $kdeklm	=$_POST['kdeklm'];
  		$kdeplj	=$_POST['kdeplj'];
  		$pilihan=$_POST['pilihan'];

        $query1 ="	SELECT 		g_gnrmtr.*
					FROM 		g_gnrmtr
					WHERE
								g_gnrmtr.kdeklm	='". mysql_escape_string($kdeklm)."'	and
								g_gnrmtr.kdeplj	='". mysql_escape_string($kdeplj)."'";

		$result =mysql_query($query1);
		$data1 	=mysql_fetch_array($result);
		if($data1==0)
		{
			$set	="	SET     g_gnrmtr.kdemtr	='". mysql_escape_string($kdemtr)."',
								g_gnrmtr.kdeklm	='". mysql_escape_string($kdeklm)."',
								g_gnrmtr.kdeplj	='". mysql_escape_string($kdeplj)."'";

			$query 	="INSERT INTO g_gnrmtr ".$set;
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
        }
 	}
    // -------------------------------------------------- Save Detail --------------------------------------------------
	function R1D01A_Save_Item()
	{
		require_once '../fungsi_umum/sysconfig.php';

        $kdeklm     =$_POST['kdeklm'];
        $kdemtr		=$_POST['kdemtr'];
        $kdegru		=$_POST['kdegru'];
        $nmamtr		=$_POST['nmamtr'];
  		$pilihan	=$_POST['pilihan'];
        $stt	    =$_POST['stt'];
        $pdf		=$_FILES['pdf']['tmp_name'];
        $filetype	=$_FILES['pdf']['name'];
        $type1		=$_FILES['pdf']['type'];
        $type		=explode('.',$filetype);
        $tglinp     =date("d-m-Y");
       	$jaminp	    =date("h:i:s");

        $set		="	SET     g_dtlmtr.kdemtr	='". mysql_escape_string($kdemtr)."',
                                g_dtlmtr.kdegru	='". mysql_escape_string($kdegru)."',
		   						g_dtlmtr.nmamtr	='". mysql_escape_string($nmamtr)."',
                                g_dtlmtr.stt	='". mysql_escape_string($stt)."',
                                g_dtlmtr.tglinp	='". mysql_escape_string($tglinp)."',
                                g_dtlmtr.jaminp	='". mysql_escape_string($jaminp)."',
								g_dtlmtr.type	='". mysql_escape_string($type[1])."'";

  		$query 	="INSERT INTO g_dtlmtr ".$set;
		$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
		$kdegruB=$kdegru;

        $handle = is_dir("../files/materi/$kdemtr");
        if($handle=='')
        {
			mkdir("../files/materi/".$kdemtr, 0775);
        }

		if($pdf=='')
		{
			$newfile='';
		}
		else
		{
			$newfile= "../files/materi/$kdemtr/$nmamtr.$type[1]";
			if (file_exists($newfile))
				unlink($newfile);
			copy($pdf, "../files/materi/$kdemtr/$nmamtr.$type[1]");
		}
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D01A&kdemtr=$kdemtr&pilihan=tambah_item\">\n";
	}

// -------------------------------------------------- Save --------------------------------------------------
	function R1D01A_Update()
	{
		require_once '../fungsi_umum/sysconfig.php';

  		$kdegru	=$_GET['kdegru'];
  		$stt1	=$_GET['stt1'];
        $di     ='Disabled';
        $en     ='Enabled';
  		$nmamtr1=$_GET['nmamtr1'];
        if($stt1=='Disabled')
        {
		$set	="	SET		g_dtlmtr.stt	='". mysql_escape_string($en)."'";

    	$query 	="	UPDATE 	g_dtlmtr ".$set.
		         "	WHERE 	g_dtlmtr.nmamtr='". mysql_escape_string($nmamtr1)."'AND
                            g_dtlmtr.kdegru='". mysql_escape_string($kdegru)."'";
		$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
        }
        else
        if($stt1=='enable')
        {
		$set	="	SET		g_dtlmtr.stt	='". mysql_escape_string($di)."'";

    	$query 	="	UPDATE 	g_dtlmtr ".$set.
		         "	WHERE 	g_dtlmtr.nmamtr='". mysql_escape_string($nmamtr1)."'AND
                            g_dtlmtr.kdegru='". mysql_escape_string($kdegru)."'";
		$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));
        }
    
 	}
}//akhir class
?>