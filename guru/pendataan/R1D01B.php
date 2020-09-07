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
		$ktr	=$_GET['ktr'];
		$pilihan=$_GET['pilihan'];

		$query ="	SELECT 		g_gnrsal.*,t_mstplj.nmaplj
					FROM   		g_gnrsal,t_mstplj
					WHERE 		(g_gnrsal.kdesl 	LIKE'%".$kdesl."%' 	OR '$kdesl'='')		AND
								(t_mstplj.nmaplj 	LIKE'%".$nmaplj."%'	OR '$nmaplj'='')	AND
								(g_gnrsal.ktr	 	LIKE'%".$ktr."%'	OR '$ktr'='')	AND
								(g_gnrsal.kdegru 	LIKE'%".$user."%')  	AND
								g_gnrsal.kdeplj=t_mstplj.kdeplj
					ORDER BY 	g_gnrsal.ktr"; // menghasilkan soal per guru
		$result	=mysql_query($query) or die (mysql_error());

		echo"
		<FORM ACTION=guru.php METHOD='get' NAME='f1'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN=2><B>LIST OF QUESTIONS</B></TD></TR>
				<TR></TR><TR></TR>

				<TR><TD WIDTH='10%'>Code</TD>
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
				<TR><TD>Subject</TD>
					<TD>:
						<INPUT 	NAME		='nmaplj'
								TYPE		='nmaplj'
								SIZE		='50'
								MAXLENGTH	='50'
								id			='nmaplj'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'>
					</TD>
				</TR>
				<TR><TD>Topic</TD>
					<TD>:
						<INPUT 	NAME		='ktr'
								TYPE		='ktr'
								SIZE		='50'
								MAXLENGTH	='50'
								id			='ktr'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'>
						<INPUT TYPE='submit' 					VALUE='Search'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='R1D01B_Cari'>
						<INPUT TYPE='button' 					VALUE='View All' onClick=window.location.href='guru.php?mode=R1D01B_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>

		<FORM ACTION='guru.php' METHOD='post'>
			<div style='overflow:auto;width:100%;height:290px;padding-right:-2px;'>                
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No			</CENTER></TD>
						<TD WIDTH=' 8%'><CENTER>Code 		</CENTER></TD>
						<TD WIDTH='21%'><CENTER>Subject		</CENTER></TD>
						<TD WIDTH='51%'><CENTER>Topic		</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Transf.		</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Detail		</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Edit		</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Delete		</CENTER></TD>
					</TR>";

					$no=0;
					while($data =mysql_fetch_array($result))
					{
						$no++;
						echo"
						<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
							<TD><CENTER>$no			</CENTER></TD>
							<TD><CENTER>$data[kdesl]</CENTER></TD>
							<TD><CENTER>$data[nmaplj]</CENTER></TD>
							<TD>$data[ktr]</TD>
							<TD><CENTER><a href='guru.php?mode=R1D01B_Cari&kdeslT=$data[kdesl]&kdeplj=$data[kdeplj]&pilihan=transfer' onClick=\"return confirm('Are you sure ?');\"><IMG src='../images/transfer.gif' BORDER='0'></a></CENTER></TD>
							<TD><CENTER><a href='guru.php?mode=R1D01B_Soal&kdesl=$data[kdesl]&pilihan=detil_general'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>
							<TD><CENTER><a href='guru.php?mode=R1D01B_Soal&kdesl=$data[kdesl]&pilihan=edit_general'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>
							<TD><CENTER><a href='guru.php?mode=R1D01B_Hapus&kdesl=$data[kdesl]' onClick=\"return confirm('Are you sure ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>
						</TR>";
					}
				echo"
				</TABLE>
			</DIV>
			<BR>";
			if($pilihan!='transfer')
				echo"<INPUT TYPE='button' VALUE='Create Questions' onClick=window.location.href='guru.php?mode=R1D01B_Soal&pilihan=tambah_general'>";
			else	
			{
				$kdeplj	=$_GET['kdeplj'];
				$kdeslT	=$_GET['kdeslT'];
				
				echo" Transfer to :
				<SELECT	NAME		='kdegru'
						ONKEYPRESS	='return enter(this,event)'
                        CLASS		='required'
						TITLE		='...harus diisi'>";
				$query2="	SELECT 	DISTINCT t_mstpng.kdeplj,t_mstkry.*
							FROM 		t_mstpng,t_mstkry
							WHERE 		t_mstpng.kdeplj='$kdeplj'	AND
										t_mstpng.kdegru=t_mstkry.kdekry AND
										t_mstpng.kdegru!='$user'
							ORDER BY 	t_mstkry.nmakry"; // menghasilkan subjek per guru
				$result2=mysql_query($query2);
				echo"<OPTION VALUE='' SELECTED>--Select--</OPTION>";
				while($data2=mysql_fetch_array($result2))
				{
					echo"<OPTION VALUE='$data2[kdekry]'>$data2[nmakry] - ( $data2[kdekry] )</OPTION>";
				}

				echo
				"</SELECT>
				<INPUT TYPE='hidden'	NAME='kdesl' 	VALUE='$kdeslT'>
				<INPUT TYPE='submit' 					VALUE='Process'>
				<INPUT TYPE='hidden' 	NAME='mode'		VALUE='R1D01B_Transfer'>";
			}
		echo"	
		</FORM>";
 	}

	// -------------------------------------------------- Item --------------------------------------------------
	function R1D01B_Soal()
	{
		include "../fungsi_umum/aktifkan_tinymce.php";
		echo editor_full();
	
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
			document.f1.kdeplj.focus();
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
		}

		if ($pilihan=='detil_general' or $pilihan=='edit_general' or $pilihan=='tambah_item' or $pilihan=='edit_item')
		{
			$kdeslB	=$_GET['kdesl'];
			$query 	="	SELECT 	g_gnrsal.*
						FROM 	g_gnrsal
						WHERE 	g_gnrsal.kdesl='". mysql_escape_string($kdeslB)."'";//menghasilkan di tabel general
			$result	=mysql_query($query) or die (mysql_error());
			$data 	=mysql_fetch_array($result);
			$kdesl	=$data['kdesl'];
            $kdesl1	=$data['kdesl'];
            $kdeplj =$data['kdeplj'];
            $ktr    =$data['ktr'];
		}	
		if ($pilihan=='detil_general' or $pilihan=='edit_general' or $pilihan=='tambah_item' or $pilihan=='edit_item')
		{	
			$id=$_GET['id'];
			$query1 ="	SELECT 		g_dtlsal.*
						FROM 		g_dtlsal
						WHERE 		g_dtlsal.kdesl	='". mysql_escape_string($kdeslB)."'AND
									g_dtlsal.id		='". mysql_escape_string($id)."'
                        ORDER BY 	g_dtlsal.id"; // menghasilkan di tabel detil
			$result =mysql_query($query1);
			$data1 	=mysql_fetch_array($result);
			$id		=$data1['id'];
			$kdesl	=$kdeslB;
			$soal	=$data1['soal'];
			$sttjwb =$data1['sttjwb'];
			$bbtnli =$data1['bbtnli'];
		}

		// akhir inisiasi parameter
		$query2 ="	SELECT 		g_dtlsal.* 
					FROM  		g_dtlsal
					WHERE 		g_dtlsal.kdesl='$kdesl1'
					ORDER BY	g_dtlsal.id";
		$result= mysql_query($query2)	or die (mysql_error()); // menghasilkan di tabel detil

		echo"
		<BODY onload='sf();'>
		
		<SCRIPT TYPE='text/javascript' src='../guru/js/R1D01B.js'></SCRIPT>
        <SCRIPT TYPE='text/javascript' src='../js/lightbox.js'></SCRIPT>

        <LINK 	href='../css/lightbox.css' 	rel='stylesheet' TYPE='text/css' media='screen'>
			<FORM id='validasi'method='post' name='f1' enctype='multipart/form-data' action='guru.php'>
				<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
					<TR><TD COLSPAN=2><B>CREATE QUESTIONS</B></TD></TR>
					<TR></TR><TR></TR>
					<TR><TD WIDTH='10%'>Code</TD>
						<TD WIDTH='90%'>:
							<INPUT 	NAME		='kdesl1'
									TYPE		='text'
									SIZE		='15'
									MAXLENGTH	='15'
									VALUE 		='$kdesl1'
									id			='kdesl1'
									DISABLED>
							<INPUT 	TYPE='hidden' 	NAME='kdesl' id='kdesl' value='$kdesl1'>
							Subject :
							<INPUT TYPE='hidden' 	NAME='kdegru' 	id='kdegru'	VALUE='$user1'>
							<INPUT type='hidden' 	NAME='id' 		id='id' 	value='$data1[id]'>
							<SELECT NAME	='kdeplj'
									ID		='kdeplj'
									class	='kdeplj'
									value='$kdeplj'
									$isian1>

								<OPTION VALUE='' SELECTED>--Select--</OPTION>";
								$query2="	SELECT 		DISTINCT t_mstpng.kdeplj,t_mstplj.nmaplj
											FROM 		t_mstpng,t_mstplj
											WHERE		t_mstpng.kdegru='$user' AND
														t_mstpng.kdeplj=t_mstplj.kdeplj 
											ORDER BY 	t_mstplj.nmaplj"; // menghasilkan subjek
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
					<TR><TD>Note</TD>
						<TD>:";
							if($pilihan=='edit_general')
							{
								echo"
								<INPUT 	NAME		='ktr'
										TYPE		='text'
										SIZE		='100'
										MAXLENGTH	='200'
										VALUE		='$ktr'
										onkeyup		='uppercase(this.id)'
										ID			='ktr'
										CLASS		='pel1'
										TITLE		='...must be filled'
										$isian2>";
							}
							else
							{
								echo"
								<INPUT 	NAME		='ktr'
										TYPE		='text'
										SIZE		='100'
										MAXLENGTH	='200'
										VALUE		='$ktr'
										onkeyup		='uppercase(this.id)'
										onkeypress	='return enter(this,event)'
										ID			='ktr'
										CLASS		='pel'
										TITLE		='...must be filled'
										disabled>";
							}
						echo"
						</TD>
					</TR>
					<TR><TD COLSPAN='3'><HR></TD></TR>
				</TABLE>	

				<TABLE BORDER='0' class='tb1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
					<TR>
						<TD WIDTH='50%'  valign='top'><B>QUESTION</B>
						<div style='overflow:auto;width:100%;height:300px;padding-right:-2px;'>   
						<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%'>
								<TR><TD valign='top'>";
									if($pilihan=='detil_general' OR $pilihan=='edit_general')
									{
										echo"
										<div style='overflow:auto;width:100%;height:300px;padding-right:-2px;'>                
										$soal
										</div>";
									}
									else
									{
										echo"
										<TEXTAREA 	NAME		='soal'
													ID			='soal'
													VALUE		='$soal'
													
													CLASS		='textarea_01'
													
													$isian3>$soal</TEXTAREA>";//onkeypress	='return enter(this,event)'//rowspan		='10'
									}
								echo"
								</TD>
								</TR>
							</TABLE>		
							</div>";
							echo"
								<b>Answer</b>
									<INPUT 	NAME		='sttjwb'
												ID	        ='sttjwb'
												TYPE	    ='text'
												SIZE	    ='1'
												MAXLENGTH   ='1'
												VALUE		='$sttjwb'
												onkeyup		='uppercase(this.id)'
												CLASS		='required'
												TITLE		='...must be filled'
												onkeypress	='return enter(this,event)'
												$isian3> <b>Value</b>
									<INPUT 	NAME		='bbtnli'
												ID	        ='bbtnli'
												TYPE	    ='text'
												SIZE	    ='2'
												MAXLENGTH   ='2'
												VALUE		='$bbtnli'
												onkeyup		='uppercase(this.id)'
												CLASS		='required'
												TITLE		='...must be filled'
												onkeypress	='return enter(this,event)'
												$isian3>";
						
									if($pilihan=='edit_item')
									{
										echo"
										<INPUT TYPE='submit'   	VALUE='Save'>
										<INPUT TYPE='hidden' NAME='mode'		VALUE='R1D01B_Save_Item'>";
									}	
									if($pilihan=='tambah_general' or $pilihan=='tambah_item')
									{
										echo"
										<INPUT TYPE='submit'  					VALUE='Save'>
										<INPUT TYPE='hidden' NAME='mode'		VALUE='R1D01B_Save_Item'>
										<INPUT TYPE='hidden' NAME='pilihan' id='edt'		VALUE='tambah_general'>";
									}	
									if($pilihan!='tambah_general' and $pilihan!='tambah_item' and $pilihan!='edit_general')
									{
										echo" 
										<INPUT TYPE='button' 	VALUE='Create Number' onClick=window.location.href='guru.php?mode=R1D01B_Soal&kdesl=$kdesl1&pilihan=tambah_item'>";
									}
									if($pilihan=='edit_general')
									{
										echo"
										<INPUT TYPE='hidden' 	NAME='pilihan' 	id='edt'	VALUE='edit_general'>
										<INPUT TYPE='hidden' 	NAME='kdeslB' 	id='kdeslB'	VALUE='$kdesl'>
										<INPUT TYPE='hidden'	NAME='kdesl' 	id='kdesl'	VALUE='$kdesl'>
										<INPUT TYPE='hidden' 	NAME='kdeplj' 	id='kdeplj'	VALUE='$kdeplj'>";
									}
									if($pilihan=='detil_general')
									{
										echo"
										<INPUT TYPE='hidden' NAME='hapus' id='hapus' VALUE=''>";
									}			
								echo"	
						</TD>
				
						<TD WIDTH='50%' valign='top'><B>QUESTIONNAIRE</B>
							<div style='overflow:auto;width:100%;height:300px;padding-right:-2px;'>                
								<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='soal2' class='table02'>
									<TR bgcolor='dedede'>
										<TD WIDTH=' 5%' HEIGHT='20'><CENTER>No		</CENTER></TD>
										<TD WIDTH='65%'><CENTER>Questions</CENTER></TD>
										<TD WIDTH='10%'><CENTER>Detail	</CENTER></TD>
										<TD WIDTH='10%'><CENTER>Edit	</CENTER></TD>
										<TD WIDTH='10%'><CENTER>Delete	</CENTER></TD>
									</TR>";

									$no=0;
									while($data =mysql_fetch_array($result))
									{
										$soal = susun_kalimat(strip_tags($data['soal']),50);
										$no++;
										if ($pilihan!='tambah_general' )
										{
										echo"
										<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
											<TD WIDTH=' 5%'><CENTER>$no			</CENTER></TD>
											<TD WIDTH='65%'>$soal[0]...</TD>";
											}
											// otorisasi
											if ($pilihan=='detil_general' OR $pilihan=='tambah_item' OR $pilihan=='edit_item')
											{
												echo"<TD WIDTH=' 10%'><CENTER><a href='guru.php?mode=R1D01B_Soal&kdesl=$data[kdesl]&id=$data[id]&pilihan=detil_general'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
											}
											else
											if ($pilihan=='edit_general')
											{
												echo"<TD WIDTH='10%'><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
											}
											if ($pilihan=='detil_general' OR $pilihan=='tambah_item' OR $pilihan=='edit_item')
											{
												echo"<TD WIDTH='10%'><CENTER><a href='guru.php?mode=R1D01B_Soal&kdesl=$data[kdesl]&id=$data[id]&pilihan=edit_item'><IMG src='../images/edit_e.gif' BORDER='0'></a></CENTER></TD>";
											}
											else
											if ($pilihan=='edit_general')
											{
												echo"<TD WIDTH='10%'><CENTER><IMG src='../images/edit_d.gif' BORDER='0'></a></CENTER></TD>";
											}
											if ($pilihan=='detil_general' OR $pilihan=='tambah_item' OR $pilihan=='edit_item')
											{
												echo"<TD WIDTH='10%'><CENTER><a href='#' id='$data[id]'kdes='$data[kdesl]'class='hapussl'><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
											}
											else
											if ($pilihan=='edit_general')
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
									var answer = confirm('Are you sure ?')
									if (answer)
									{
										window.location.href='guru.php?mode=R1D01B_Hapus&kdesl=$kdesl';
									}
								}
								//-->
							</script>";

							echo"
							<INPUT TYPE='button' VALUE='New' onClick=window.location.href='guru.php?mode=R1D01B_Soal&pilihan=tambah_general'>";

							if ($pilihan=='detil_general')
							{
								echo"
								<INPUT TYPE='button' VALUE='Edit' onClick=window.location.href='guru.php?mode=R1D01B_Soal&kdesl=$kdesl&pilihan=edit_general'>
								<INPUT TYPE='button' VALUE='Delete' onClick='confirmation()'>";
							}	
							if ($pilihan=='detil_general' or $pilihan=='tambah_item')
							{
								echo"
								<INPUT TYPE='button' VALUE='Print by Teacher ' 	onClick=window.open('pendataan/R1D01B_C01.php?kdesl=$kdesl')>";
								echo"
								<INPUT TYPE='button' VALUE='Print by Student ' onClick=window.open('pendataan/R1D01B2_C01.php?kdesl=$kdesl')>";
							}
							echo"
							<INPUT TYPE='button' 	VALUE='List of Questions' 	onClick=window.location.href='guru.php?mode=R1D01B_Cari'>
							
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
		$query 	=mysql_query("	SELECT 		g_dtlsal.*
						FROM   		g_dtlsal
						WHERE   	g_dtlsal.kdesl='$kdesl'
						ORDER BY 	g_dtlsal.kdesl DESC LIMIT 1"); // pilih tabel detil
        $data =mysql_fetch_array($query);
		$id=$data['id'];
		
		$sql	="	DELETE
					FROM  g_gnrsal
					WHERE 	g_gnrsal.kdesl='". mysql_escape_string($kdesl)."'";
		$result	=mysql_query($sql) or die ("Query failed - Mysql"); // hapus tabel general

		$sql	="	DELETE
					FROM  	g_dtlsal
					WHERE 	g_dtlsal.kdesl='". mysql_escape_string($kdesl)."'"; // hapus tabel detil
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
  		//$ktr	=str_replace(" ","-",($_POST['ktr']));
		$ktr	=($_POST['ktr']);
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
			$result =mysql_query ($query) or die (error("Data tidak berhasil di Input 1"));
			$kdeslB=$kdesl;
			echo"<input type='text' name='kdeslB' id='kdeslBb'>";
  		}
 	}
	
	// -------------------------------------------------- Transfer --------------------------------------------------
	function R1D01B_Transfer()
	{
		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';

  		$kdegru		=$_POST['kdegru'];
		$kdesl		=$_POST['kdesl'];
		
		$set	="	SET		g_gnrsal.kdegru	='". mysql_escape_string($kdegru)."'";

   		$query 	="	UPDATE 	g_gnrsal ".$set.
				"	WHERE 	g_gnrsal.kdesl	='". mysql_escape_string($kdesl)."'";
		$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));

		echo"
		<script type='text/javascript'>
			window.alert('Transfer has done')
		</script>";
		
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D01B_Cari\">\n"; 
 	}
	
	// -------------------------------------------------- Save --------------------------------------------------
	function R1D01B_Save_Item()
	{
		$id		=$_POST['id'];
		$kdesl	=$_POST['kdesl'];
		$soal	=trim($_POST['soal']);
		$sttjwb	=$_POST['sttjwb'];
		$bbtnli	=$_POST['bbtnli'];

		$query 	=mysql_query("	SELECT 	g_dtlsal.*
								FROM 	g_dtlsal
								WHERE 	g_dtlsal.id = '$id' AND g_dtlsal.kdesl='$kdesl'"); // pilih tabel detil

		$set	="	SET		g_dtlsal.id		='". mysql_escape_string($id)."',
							g_dtlsal.kdesl	='". mysql_escape_string($kdesl)."',
							g_dtlsal.soal	='". mysql_escape_string($soal)	."',
							g_dtlsal.sttjwb	='". mysql_escape_string($sttjwb)."',
							g_dtlsal.bbtnli	='". mysql_escape_string($bbtnli)."'";	

		if(mysql_num_rows($query) == "")
		{
			$query 	="	INSERT INTO g_dtlsal ".$set;
			$result	=mysql_query ($query)or die(error("Data tidak berhasil di Input 2")) ;
			echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D01B_Soal&kdesl=$kdesl&pilihan=tambah_item\">\n"; 
		}
		else
		{
			$query 	="	UPDATE 		g_dtlsal ".$set.
					"	WHERE 		g_dtlsal.id	='". mysql_escape_string($id)."'";
			$result	=mysql_query ($query)or die(error("Data tidak berhasil di Input 3")) ;
			echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D01B_Soal&kdesl=$kdesl&id=$id&pilihan=detil_general\">\n"; 
		}
	}		
}//akhir class
?>