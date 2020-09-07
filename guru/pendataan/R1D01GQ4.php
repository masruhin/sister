<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D01GQ4.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi RPP upload
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D01GQ4class
{
	// -------------------------------------------------- Item --------------------------------------------------
	function R1D01GQ4()
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
				$isian1	='disabled';
				$isian2	='enable';
				$isian3	='enable';
				$user1	=$user;
                $kdemtr =nomor_rpp();
				break;
			case 'tambah_item':
				$isian1	='enable';
				$isian2	='disabled';
				$isian3	='enable';
				break;
		}

		if ($pilihan=='detil_general'  or $pilihan=='tambah_item' )
		{
			$kdemtrB=$_GET['kdemtr'];
			$query 	="	SELECT 	g_gnrrpp.*
						FROM 	g_gnrrpp
						WHERE 	g_gnrrpp.kderpp='". mysql_escape_string($kdemtrB)."'";
			$result =mysql_query($query);
			$data 	=mysql_fetch_array($result);
            $kdemtr	=$data['kderpp'];
			$kdegru	=$data['kdegru'];
            $kdeplj =$data['kdeplj'];
            $ktr    =$data['ktr'];
            $kdeklm	=$data['kdeklm'];

		}	
		if ($pilihan=='detil_general' or $pilihan=='tambah_item')
		{	
			$id=$_GET['id'];
			$query1 ="	SELECT 		g_dtlrpp.*
						FROM 		g_dtlrpp
						WHERE 		g_dtlrpp.kderpp='". mysql_escape_string($kdemtr)."'";
			$result =mysql_query($query1);
			$data1 	=mysql_fetch_array($result);
			$nmamtr	=$data1['nmarpp'];
		}

		// akhir inisiasi parameter
		$query2 ="	SELECT 		g_dtlrpp.*,t_mstkry.*
					FROM  		g_dtlrpp,t_mstkry
					WHERE 		g_dtlrpp.kderpp='". mysql_escape_string($kdemtr)."'AND
                                g_dtlrpp.kdegru=t_mstkry.kdekry
					ORDER BY g_dtlrpp.nmarpp";
		$result= mysql_query($query2) or die (mysql_error());

		echo"
		<BODY onload='sf();'>
			<SCRIPT TYPE='text/javascript' src='../guru/js/R1D01GQ4.js'></SCRIPT>
			
			<FORM ID='validasi'  ACTION='guru.php'METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
				<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
					<TR><TD COLSPAN='2'><B>LESSON PLAN QUARTER 4</B></TD></TR>
					<TR></TR><TR></TR>
					<TR><TD WIDTH='10%'>Subject</TD>
						<TD WIDTH='90%'>:

							<INPUT TYPE='hidden' 	NAME='kdemtr'  	id='kdemtr'value='$kdemtr'>
							<INPUT TYPE='hidden' 	NAME='kdegru' id='kdegru'	VALUE='$user'>
							<SELECT NAME	='kdeplj'
									ID		='kdeplj'
									class	='kdeplj'
									value='$kdeplj'
									$isian2>
                                    <OPTION VALUE='' SELECTED>--Select--</OPTION>";
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

							Class :
							<SELECT NAME	='kdeklm'
									ID		='kdeklm'
									class	='kdeklm'
									value='$kdeklm'
									disabled>
							<OPTION VALUE='' SELECTED>--Select--</OPTION>";
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
					<TR><TD>Title</TD>
						<TD>:
							<INPUT 	NAME		='nmamtr'
									TYPE		='text'
									SIZE		='100'
									MAXLENGTH	='200'
									VALUE		=''
									onkeyup		='uppercase(this.id)'
									ID			='nmamtr'
									CLASS		='required'
									TITLE		='...must be filled'
									$isian1>
									Upload File :
							<INPUT 	NAME		='pdf'
									TYPE		='file'
									SIZE		='20'
									MAXLENGTH	='50'
									VALUE		='$pdf'
									id		    ='pdf'
									class       ='required'
									onkeypress	='return enter(this,event)'
									$isian1>&nbsp

							<input type='hidden' name='stt' id='stt' value='Disabled'>";
					
							if($pilihan!=detil_general)
							{
								echo"
								<INPUT TYPE='submit' 		id='inpt'		VALUE='Input' $isian1>";
							}
							echo"
						</TD>
					</TR>
					<INPUT TYPE='hidden' NAME='mode'  id='mode'	VALUE='R1D01GQ4_Save_Item'></TR>
				</TABLE>	

				<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
					<TR>
						<TD WIDTH='100%' valign='top'>
							<div style='overflow:auto;width:100%;height:330px;padding-right:-2px;'>                
								<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' class='table02'>
									<TR bgcolor='dedede'>
										<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
										<TD WIDTH='40%'><CENTER>Title  	</CENTER></TD>
                                        <TD WIDTH='25%'><CENTER>Teacher  	</CENTER></TD>
                                        <TD WIDTH='12%'><CENTER>Date/Time  	</CENTER></TD>
                                        <TD WIDTH='7%'><CENTER>Status  	</CENTER></TD>
										<TD WIDTH=' 7%'><CENTER>Detail  			</CENTER></TD>
										<TD WIDTH=' 7%'><CENTER>Delete			</CENTER></TD>
									</TR>
									<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='materi' class='table02'>
									</TABLE>

									<FORM  id='validasi'>
										<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' class='table02'>";
											$no=0;
											while($data =mysql_fetch_array($result))
											{   $id=$data['id'];
												$nmamtr2	=$data['nmarpp'];
                                                $nmakry	=$data['nmakry'];
                                                $kdegru=$data['kdegru'];
                                                $stt1   =$data['stt'];
                                                $tglinp=$data['tglinp'];
                                                $jaminp=$data['jaminp'];
												$type=$data['type'];
												
												$no++;
												echo"
												<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
													<TD WIDTH=' 4%'><CENTER>$no			</CENTER></TD>
													<TD WIDTH='40%'>$nmamtr2</TD>
                                                    <TD WIDTH='25%'><center>$nmakry</center></TD>
                                                    <TD WIDTH='12%'><center>$tglinp/$jaminp</center></TD>";
                                                    if($kdegru!=$user)
                                                            {
                                                          echo"<TD WIDTH='7%'><center><img src='../images/disable.gif'></center></TD>";
                                                            }
                                                    else
                                                            {
                                                              if($stt1=='Enabled')
                                                              {
                                                             echo"<TD WIDTH='7%'><center><a href='#' stt='$stt1' kdegr='$kdegru' id='$id'class='stt1'><img src='../images/enable.gif' ></a></center></TD>";
                                                             }
                                                             else
                                                             {
                                                               echo"<TD WIDTH='7%'><center><a href='#' stt='$stt1' kdegr='$kdegru' id='$id'class='stt1'><img src='../images/disable.gif' ></a></center></TD>";
                                                             }
                                                    }

													// otorisasi

													if ($pilihan=='detil_general' or $pilihan=='tambah_item')
													{

                                                        echo"
														<TD WIDTH='7%'><CENTER><a href='../files/semester2/quarter4/$kdemtr/$nmamtr2.$type'target='_blank'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
                                                        if($kdegru!=$user)
                                                        {
                                                          echo"
                                                          <TD WIDTH='7%'><CENTER><IMG src='../images/hapus_d.gif' BORDER='0'></CENTER></TD>";
                                                        }
                                                        else
                                                        {
                                                        echo"
														<TD WIDTH='7%'><CENTER><a href='#' id='$data[id]'typ='$type' nmamt='$nmamtr2'class='hapusmtr'><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
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
											<SCRIPT TYPE='text/javascript' src='../guru/js/R1D01GQ4_hapus.js'></SCRIPT>
										</TABLE>
									</FORM>
								</TABLE>
							</DIV>	
						</TD>
					</TR>
					<TR>
						<TD ALIGN='left'>
							<INPUT TYPE='button' VALUE='New' onClick=window.location.href='guru.php?mode=R1D01GQ4&pilihan=tambah_general'>";

							if ($pilihan=='detil_general')
							{
								echo"
								<INPUT TYPE='button' VALUE='Tambah Materi' onClick=window.location.href='guru.php?mode=R1D01GQ4&kdemtr=$kdemtr&pilihan=tambah_item'>
								<INPUT TYPE='button' VALUE='Hapus' onClick='confirmation()'>";
							}	
							if ($pilihan=='detil_general' or $pilihan=='tambah_item')
							{
								//echo"<INPUT TYPE='button' VALUE='Print' 	onClick=window.open('pendataan/R1D01GQ4_Cetak.php?kdemtr=$kdemtr')>";
							}
						echo"
						</TD>
					</TR>
				</TABLE>
			</FORM>	
		</BODY>";
	}

	// -------------------------------------------------- Save General --------------------------------------------------
	function R1D01GQ4_Save()
	{
		require_once '../fungsi_umum/sysconfig.php';

        $kdemtr	=$_POST['kdemtr'];
        $kdeklm	=$_POST['kdeklm'];
  		$kdeplj	=$_POST['kdeplj'];
  		$pilihan=$_POST['pilihan'];

        $query1 ="	SELECT 		g_gnrrpp.*
					FROM 		g_gnrrpp
					WHERE
								g_gnrrpp.kdeklm	='". mysql_escape_string($kdeklm)."'	and
								g_gnrrpp.kdeplj	='". mysql_escape_string($kdeplj)."'";

		$result =mysql_query($query1);
		$data1 	=mysql_fetch_array($result);
		if($data1==0)
		{
			$set	="	SET     g_gnrrpp.kderpp	='". mysql_escape_string($kdemtr)."',
								g_gnrrpp.kdeklm	='". mysql_escape_string($kdeklm)."',
								g_gnrrpp.kdeplj	='". mysql_escape_string($kdeplj)."'";

			$query 	="INSERT INTO g_gnrrpp ".$set;
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
        }
 	}
    // -------------------------------------------------- Save Detail --------------------------------------------------
	function R1D01GQ4_Save_Item()
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
		$cari=array(",",":","'","\\","/","\"","*","?","<",">","|",".");
		$ganti=array(" ","-"," "," "," "," "," "," ","-"," ","-"," ");
		$mtr=str_replace($cari,$ganti,$nmamtr);
		$nmamt=trim($mtr);

        $set		="	SET     g_dtlrpp.kderpp	='". mysql_escape_string($kdemtr)."',
                                g_dtlrpp.kdegru	='". mysql_escape_string($kdegru)."',
		   						g_dtlrpp.nmarpp	='". mysql_escape_string($nmamt)."',
                                g_dtlrpp.stt	='". mysql_escape_string($stt)."',
                                g_dtlrpp.tglinp	='". mysql_escape_string($tglinp)."',
                                g_dtlrpp.jaminp	='". mysql_escape_string($jaminp)."',
								g_dtlrpp.type	='". mysql_escape_string($type[1])."'";

  		$query 	="INSERT INTO g_dtlrpp ".$set;
		$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
		$kdegruB=$kdegru;

        $handle = is_dir("../files/semester2/quarter4/$kdemtr");
        if($handle=='')
        {
			mkdir("../files/semester2/quarter4/".$kdemtr, 0775);
        }

		if($pdf=='')
		{
			$newfile='';
		}
		else
		{
			$newfile= "../files/semester2/quarter4/$kdemtr/$nmamt.$type[1]";
			if (file_exists($newfile))
				unlink($newfile);
			copy($pdf, "../files/semester2/quarter4/$kdemtr/$nmamt.$type[1]");
		}
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D01GQ4&kdemtr=$kdemtr&pilihan=tambah_item\">\n";
	}


}//akhir class
?>