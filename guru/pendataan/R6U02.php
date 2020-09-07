<?php
session_start();
//----------------------------------------------------------------------------------------------------
//Program		: R6U02.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 26/12/2011
//Keterangan	: Fungsi-fungsi GANTI PASSWORD
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<H1>Permission Denied</H1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R6U02class
{
    // -------------------------------------------------- Layar Utama --------------------------------------------------
	function R6U02() 
	{
		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'koneksi.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';
		$kdekrm=nomor_krm();
        //require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

		// deklarasi java
		echo"
		
		<LINK 	href='../css/val.css' 		rel='stylesheet' TYPE='text/css'>
	    <link 	rel='stylesheet' href ='../css/chosen.css' />
		<SCRIPT TYPE='text/javascript' 		src='../js/jquery-validate.js'></SCRIPT>
        <SCRIPT TYPE='text/javascript' 	src='../js/fungsi_input.js'></SCRIPT> 
		";
		echo"
		<SCRIPT TYPE='text/javascript' 		src='../guru/js/R6U02.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 		src='../guru/js/R1D01B_jquery-1.3.2.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 		src='../guru/js/R1D01B_ajaxupload.3.5.js'></SCRIPT>
        
		";
		echo'
		<link 	rel="stylesheet" href ="../css/chosen.css" />
		<script src="../js/jquery.min.js" type="text/javascript"></script>
        <script src="../js/chosen.jquery.js" type="text/javascript"></script>';
		
        echo"
		     
		 
		<SCRIPT>
		function inbox()
		{
			$.ajax(
			{
				url: '../guru/fungsi_khusus/R6U02_juminbox.php',
				success: function(dta)
				{
					$('#inbx').html(dta);
					$('#cb').html('<b>INBOX</b>');
				}
			});
		}
		</script>
		";
		
		echo'
		<script>
		var jumlahnya;
		function ceksemua()
		{
			jumlahnya = document.getElementById("jumlahcek").value;
			if(document.getElementById("cekbox").checked==true)
			{
				for(i=0;i<jumlahnya;i++)
				{
					idcek = "id"+i;
					idtr = "tr"+i;
					document.getElementById(idtr).style.backgroundColor = "#efefef";
					document.getElementById(idcek).checked = true;
				}
			}
			else
			{
				for(i=0;i<jumlahnya;i++)
				{
					idcek = "id"+i;
					idtr = "tr"+i;
					document.getElementById(idtr).style.backgroundColor = "#FFFFFF";
					document.getElementById(idcek).checked = false;
				}
			}
		}
		
		function konfirmasicek2()
		{
			ada = 0;            //untuk mengecek apakah ada checkbox yang dicek
			semuanyakah = 1;    //untuk mengecek apakah semua checkbox tercek
		
			//untuk mengambil jumlah total checkbox yang ada
			jumlahnya = document.getElementById("jumlahcek").value;
		
			jumlahx = 0         //untuk mengetahui jumlah yang dicek
			for(i=0;i<jumlahnya;i++)
			{
				idcek = "id"+i;
				if(document.getElementById(idcek).checked == true)
				{
					jumlahx++;
					ada = 1;
				}
				else
				{
					semuanyakah = 0;
				}
			}
			if(ada==1)
			{
				if(semuanyakah == 1)
				{
					tanya = confirm("Delete All?");
					if(tanya == 1)
					{
						document.getElementById("f1").submit();
					}
				}
				else
				{
					tanya = confirm("Delete "+jumlahx+" item ?");
					if(tanya == 1)
					{
						document.getElementById("f1").submit();
					}
				}
			}
		}
		
		function konfirmasicek3()
		{
			ada = 0;            //untuk mengecek apakah ada checkbox yang dicek
			semuanyakah = 1;    //untuk mengecek apakah semua checkbox tercek
    
			//untuk mengambil jumlah total checkbox yang ada
			jumlahnya = document.getElementById("jumlahcek").value;
        
			jumlahx = 0         //untuk mengetahui jumlah yang dicek
			for(i=0;i<jumlahnya;i++)
			{
				idcek = "id"+i;
				if(document.getElementById(idcek).checked == true)
				{
					jumlahx++;
					ada = 1;
				}
				else
				{
					semuanyakah = 0;
				}
			}
			if(ada==1)
			{
				if(semuanyakah == 1)
				{    tanya = confirm("Delete All?");
				    if(tanya == 1)
					{
				      document.f1.action="../guru/fungsi_khusus/R6U02_houtbox.php";
					  document.f1.submit();
					}
				}
				else
				{   
					tanya = confirm("Delete "+jumlahx+" item ?");
					 if(tanya == 1) 
					{ 
					  document.f1.action="../guru/fungsi_khusus/R6U02_houtbox.php";
					  document.f1.submit();
					}
				}
			}
		}
		</script>';

        $kdekry	=$_SESSION["Admin"]["kdekry"];
		$st='';
         // untuk mendapatkan kode guru
        $query	="	SELECT COUNT(utk) as jum
					FROM g_trmeml
					WHERE g_trmeml.utk='$kdekry' AND
					      g_trmeml.stt='$st'";
		$result	=mysql_query($query);
        $data	=mysql_fetch_array($result);
        $utk	=$data['jum'];
		
		echo"
		<body  onload='inbox();'>
		<FORM METHOD='post' action='../guru/fungsi_khusus/R6U02_hinbox.php' NAME='f1' id='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>eMail</B></TD></TR>
				<TR></TR><TR></TR>
			</TABLE>
            <input type='hidden' id='kdekry' value='$kdekry'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR>
                    <TD WIDTH='10%' VALIGN='top'>
						<div style='overflow:auto;width:100%;height:400px;padding-right:-2px;'>
							<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' >
								<TR>
									<TD WIDTH=90% HEIGHT=25 bgcolor='1F437F' ALIGN=center>
										<a href='#'  kdkr='$kdekrm' id='$kdekry' class='kirim_pesan'><span style='color: #ffffff;'><b>COMPOSE</b></span></a>
									</TD>
									<TD WIDTH=10%></TD>
								</TR>
								<TR>
									<TD HEIGHT=25>
										<a href='#'  id='$kdekry' class='inbox'>Inbox(<span id='inbx'></span><span id='inb' value='$utk'></span>)</a>
									</TD>
								</TR>
								<TR>
									<TD HEIGHT=25>
										<a href='#'  id='$kdekry' class='outbox'>Outbox</a>
									</TD>
								</TR>
							</TABLE>
						</DIV>
					</TD>
					
					<TD WIDTH='90%' VALIGN='top'>
						<div style='overflow:auto;width:100%;height:400px;padding-right:-2px;'>";
							$query ="	SELECT 		g_trmeml.*,t_mstkry.nmakry,t_mstkry.kdekry
										FROM 		g_trmeml,t_mstkry
										WHERE 		g_trmeml.utk='". mysql_escape_string($kdekry)."' AND
													g_trmeml.dri=t_mstkry.kdekry
										ORDER BY	g_trmeml.tglkrm DESC";
							$result =mysql_query($query);

							echo"
							<span id='cb'></span>
							<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='inbfront'>
								<TR bgcolor='dedede'>
									<TD WIDTH=' 3%'><CENTER><input type='checkbox' onclick='ceksemua()' id='cekbox'	name='cekbox'		</CENTER></TD>
									<TD WIDTH='17%' HEIGHT='20'><CENTER><b>From</b></CENTER></TD>
									<TD WIDTH='65%'><CENTER><b>Subject</b></CENTER></TD>
									<TD WIDTH='15%'><CENTER><b>Date</b>				</CENTER></TD>
								</TR>";
								$no=0;
								while($data =mysql_fetch_array($result))
								{
									$kdetrm	=$data['kdetrm'];
									$dri	=$data['dri'];
									$nmakry	=$data['nmakry'];
									$kdekry =$data['kdekry'];
									$sbj	=$data['sbj'];
									$tglkrm	=$data['tglkrm'];
									$ktr    =$data['isi'];
									$atch    =$data['atch'];
									$stt    =$data['stt'];
									$id     =$data['id'];
										
									echo"
									<TR id='tr$no'\" bgcolor='F5F5F5'>
										<TD><CENTER><input type=checkbox name='id[]' id='id$no' value='$id'></CENTER></TD>";
										
										if($stt=='')
										{
											echo"
											<TD><a href='#'  id='$data[id]' class='baca'><b>$nmakry</b></a></TD>
											<TD><input type='hidden' id='kdetrm' value='$kdetrm'><a href='#'  id='$data[id]' class='baca'><b>$sbj</b></a>";
											if($atch=='A')
											{
												echo" &nbsp <IMG src='../images/paperclip.gif' BORDER='0'>";
											}echo"</TD>
											<TD><center><a href='#'  id='$data[id]' class='baca'><b>$tglkrm</b></a></center></TD>";
										}
										else
										{
											echo"
											<TD><a href='#'  id='$data[id]' class='baca'>$nmakry</a></TD>
											<TD><input type='hidden' id='kdetrm' value='$kdetrm'><a href='#'  id='$data[id]' class='baca'>$sbj</a>";
											if($atch=='A')
											{
												echo" &nbsp <IMG src='../images/paperclip.gif' BORDER='0'>";
											}echo"</TD>
											<TD><center><a href='#'  id='$data[id]' class='baca'>$tglkrm</a></center></TD>";
										}
										echo"
									</TR>";
									$no++;
								}
	
								echo"
								<input type='hidden' id='jumlahcek' value='$no' name='jumlahcek'>
							</TABLE>
							<SCRIPT TYPE='text/javascript' 		src='../guru/js/R6U02_baca.js'></SCRIPT>";
							echo'
							<input type="button"  id="del" value="delete" onclick="konfirmasicek2()">';

							echo"
                            <TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='kirim_pesan'> </table>
							<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='inbox'></TABLE>
							<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='outbox'></TABLE>
							<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='balas'></TABLE>
						</DIV>
					</TD>
				</TR>
			</TABLE>
		</FORM>
		</body>
		"; 
	}
}
?>