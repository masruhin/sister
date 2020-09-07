<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D01C.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi RENCANA TEST
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D01Cclass
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function R1D01C_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";

		echo"
		<SCRIPT TYPE='text/javascript'>
			function tgl()
			{
				document.f1.prd.value = document.f1.bln.value +-+ document.f1.tahun.value;
			}
		</SCRIPT>";

		$user	=$_SESSION["Admin"]["kdekry"];
		$kdercu	=$_GET['kdercu'];
		$tglrcu	=$_GET['tglrcu'];
		$kdeplj	=$_GET['kdeplj'];

		$query 	="	SELECT 		g_gnrrcu.*,t_mstplj.nmaplj
					FROM   		g_gnrrcu,t_mstplj
					WHERE 		(g_gnrrcu.kdercu 	LIKE'%".$kdercu."%' OR '$kdercu'='')	AND
								(g_gnrrcu.kdegru 	LIKE'%".$user."%' 	OR '$user'='')   	AND
								(g_gnrrcu.kdeplj 	LIKE'%".$kdeplj."%' OR '$kdeplj'='') 	AND
								g_gnrrcu.kdeplj=t_mstplj.kdeplj
					ORDER BY 	g_gnrrcu.kdercu";
		$result	=mysql_query($query) or die (mysql_error());

		echo"
		<FORM ACTION=guru.php METHOD='get' NAME='f1'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>LIST OF PLANNING TEST</B></TD></TR>
				<TR></TR><TR></TR>

				<TR><TD WIDTH='10%'>Code</TD>
  					<TD WIDTH='90%'>:
						<INPUT 	NAME		='kdercu'
								TYPE		='text'
								SIZE		='15'
								MAXLENGTH	='15'
								id			='kdercu'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'>
					</TD>
  				</TR>
				<TR><TD>Subject</TD>
					<TD>:
						<INPUT 	NAME		='kdeplj'
								TYPE		='kdeplj'
								SIZE		='50'
								MAXLENGTH	='50'
								id			='kdeplj'
								onkeyup		='uppercase(this.id)'
								onkeypress	='return enter(this,event)'>
						<INPUT TYPE='submit' 					VALUE='Search'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='R1D01C_Cari'>
						<INPUT TYPE='button' 					VALUE='View All' onClick=window.location.href='guru.php?mode=R1D01C_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>

		<FORM ACTION='guru.php?mode=R1D01C' METHOD='post'>
			<div style='overflow:auto;width:100%;height:320px;padding-right:-2px;'>
			<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
				<TR bgcolor='dedede'>
  					<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No				</CENTER></TD>
  					<TD WIDTH='10%'><CENTER>Code 		</CENTER></TD>
  					<TD WIDTH='24%'><CENTER>Subject	</CENTER></TD>
					<TD WIDTH='40%'><CENTER>Description	</CENTER></TD>
					<TD WIDTH='10%'><CENTER>Status			</CENTER></TD>
					<TD WIDTH=' 4%'><CENTER>Detail			</CENTER></TD>
  					<TD WIDTH=' 4%'><CENTER>Edit			</CENTER></TD>
  					<TD WIDTH=' 4%'><CENTER>Delete			</CENTER></TD>
				</TR>";

				$no=0;
				while($data =mysql_fetch_array($result))
				{
					$no++;
					echo"
					<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
  						<TD><CENTER>$no			</CENTER></TD>
  						<TD><CENTER>$data[kdercu]</CENTER></TD>
  						<TD><CENTER>$data[nmaplj]</CENTER></TD>
						<TD><CENTER>$data[ktr]</CENTER></TD>
						<TD><center>$data[stt]</center></TD>";
						// otorisasi akses detil

						echo"
						<TD><CENTER><a href='guru.php?mode=R1D01C&kdercu=$data[kdercu]&pilihan=detil_general'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";

						echo"
						<TD><CENTER><a href='guru.php?mode=R1D01C&kdercu=$data[kdercu]&pilihan=edit'><IMG src='../images/edit_e.gif' 	BORDER='0'></a></CENTER></TD>";

						echo"
						<TD><CENTER><a href='guru.php?mode=R1D01C_Hapus&kdercu=$data[kdercu]' onClick=\"return confirm('Are you sure ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
					echo"
					</TR>";
				}
			echo"
			</TABLE>
			</DIV>
			<BR>";
			// otorisasi akses tambah
			echo"
			<INPUT TYPE='button' VALUE='Create Planning Test' onClick=window.location.href='guru.php?mode=R1D01C&pilihan=tambah'>";
		echo"
		</FORM>";
 	}

	// -------------------------------------------------- Item --------------------------------------------------
	function R1D01C()
	{
		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'fungsi_periode.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';
		require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';
		$user	=$_SESSION["Admin"]["kdekry"];
		
		// deklarasi java
		echo"
		
		<SCRIPT TYPE='text/javascript' src='../js/lightbox.js'></SCRIPT>
		<LINK 	href='../css/lightbox2.css' 	rel='stylesheet' TYPE='text/css' media='screen'>";
				 
		echo"
		<SCRIPT TYPE='text/javascript' 	src='../js/ajax.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../js/ajax-dynamic-list.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../js/fungsi_input.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 	src='../js/DatePicker/WdatePicker.js'></SCRIPT>
		<LINK 	href='../css/val.css' 	rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>";

		echo"		
		<SCRIPT TYPE='text/javascript' src='../js/jquery.validate.pack.js'></SCRIPT>
        <SCRIPT TYPE='text/javascript'>
			$(document).ready(function()
			{
				$('#validasi').validate()
			});
		</SCRIPT>";

		echo"
		<SCRIPT language='javascript'>
			//agar kursor keposisi isian kode barang
			function sf()
			{ 
				document.f1.kdeplj.focus();
			}
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
				$isian2	='disabled';
				break;
			case 'detil_general':
				$isian 	='disabled';
				$isian2	='disabled';
                $isian3	='disabled';
				break;
			case 'tambah':
				$isian	='enable';
				$isian2	='enable';
                $isian3	='enable';
				$user1	=$user;
				$tgl 	=date("d-m-Y H:i:s");
				$tglbt	=substr($tgl,-2).substr($tgl,3,2);
				break;
			case 'tambah_item':
				$isian 	='enable';
				$isian2	='disabled';
                $isian3	='disabled';
				$user1	=$user;
				$kdercu =nomor_rcu($kdeplj);
				$tgl 	=date("d-m-Y H:i:s");
				$tglbt	=substr($tgl,-2).substr($tgl,3,2);
				break;
			case 'edit':
				$isian	='enable';
				$isian2	='enable';
                $isian3	='disabled';
				$user1=$user;
				break;
		}

		if ($pilihan=='detil' or $pilihan=='edit' or $pilihan=='detil_general'or $pilihan=='tambah_item')
		{
			$kdercuB=$_GET['kdercu'];
			$query 	="	SELECT 		g_gnrrcu.*
						FROM 		g_gnrrcu
						WHERE 		g_gnrrcu.kdercu='". mysql_escape_string($kdercuB)."'
						ORDER BY 	g_gnrrcu.kdercu desc LIMIT 1";
			$result	=mysql_query($query) or die (mysql_error());
			$data 	=mysql_fetch_array($result);
			$kdercu	=$data['kdercu'];
			$kdercu1=$data['kdercu'];
			$kdeplj =$data['kdeplj'];
			$stt    =$data['stt'];
            $ktr    =$data['ktr'];
			$kdebbt	=$data['kdebbt'];
			$tglrcu	=$data['tglrcu'];
			$jamrcu	=$data['jamrcu'];
			$kdekls	=$data['kdekls'];
            $id		=$_GET['id'];
			
			$query1 	="	SELECT 		g_dtlrcu.*
							FROM 		g_dtlrcu
							WHERE 		g_dtlrcu.kdercu	='". mysql_escape_string($kdercuB)."'AND
										g_dtlrcu.id		='". mysql_escape_string($id)."'
                            ORDER BY 	g_dtlrcu.id";
			$result =mysql_query($query1);
			$data1 	=mysql_fetch_array($result);
			$soal	=$data1['soal'];
			$sttjwb =$data1['sttjwb'];
		}

		// akhir inisiasi parameter

		$query2 ="	SELECT 	g_dtlrcu.* 
					FROM  	g_dtlrcu
		            WHERE 	g_dtlrcu.kdercu='$kdercu1'
					ORDER BY 	g_dtlrcu.id";
		$result= mysql_query($query2)	or die (mysql_error());

		echo"
		<BODY onload='sf();'>
			<TABLE BORDER='0' WIDTH='100%'>
				<TR>
					<TD WIDTH='50%' VALIGN='top'>
						<FORM ID='validasi'  METHOD='post' NAME='f1' >
							<TABLE BORDER='0' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
								<TR><TD COLSPAN='2'><B>PLANNING TEST</B><TD></TR>
								<TR></TR><TR></TR>
								<TR><TD WIDTH='15%'>Code</TD>
									<TD WIDTH='85%'>:
										<INPUT 	NAME='kdercu' TYPE='hidden' id='kdercu' value='$kdercu1'>
										<INPUT	TYPE		='text'
												SIZE		='15'
												MAXLENGTH	='15'
												VALUE 		='$kdercu1'
												id			='kdercu1'
                                                NAME        ='kdercu1'
												DISABLED>
										Subject :
										<INPUT TYPE='hidden' 	NAME='kdegru' id='kdegru'	VALUE='$user'>
										<SELECT NAME		='kdeplj'
												ID			='kdeplj'
                                                CLASS		='kdeplj'
												value   	='$kdeplj'
												onkeypress	='return enter(this,event)'
												$isian3>
												<OPTION VALUE='' SELECTED>--Select--</OPTION>";
										$query2="	SELECT 	DISTINCT t_mstplj.kdeplj,t_mstplj.nmaplj
													FROM 	t_mstpng,t_mstplj
													WHERE 	t_mstpng.kdegru='$user' AND
															t_mstpng.kdeplj=t_mstplj.kdeplj ";
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
								<TR><TD>Class</TD> 
									<TD>:
										<SELECT NAME		='kdekls'
												ID			='kdekls'
												value   	='$kdekls'
												onkeypress	='return enter(this,event)'
												disabled>
										<OPTION VALUE='' SELECTED>--Select--</OPTION>";
										$query2="	SELECT DISTINCT	t_mstpng.kdekls
													FROM 			t_mstpng
													WHERE 			t_mstpng.kdegru='$user'
													ORDER BY t_mstpng.kdekls ";
										$result2=mysql_query($query2);
										while($data=mysql_fetch_array($result2))
										{
											if($kdekls==$data[kdekls])
												echo"<OPTION VALUE='$data[kdekls]' SELECTED>$data[kdekls]</OPTION>";
											else
												echo"<OPTION VALUE='$data[kdekls]'>$data[kdekls]</OPTION>";
										}
										echo"
										</SELECT>
										Schedule :
										<input type='text' size='12'name='tglrcu' id='tglrcu' value='$tglrcu' onkeypress	='return enter(this,event)'$isian2>";
										if($isian2=='enable')
										{
											echo"
											<IMG onClick='WdatePicker({el:tglrcu});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle'>";
										}
										echo"		
										Time : <input type='text'   onkeypress='return enter(this,event)' size='8' name='jamrcu' class='jamrcu' id='jamrcu' value='$jamrcu' $isian2><span style='color: #FF0000;'><I> * example '09:30'</I></span>
									</TD>                            
								</TR>
								<TR><TD>Note</TD>
									<TD>: 
										<input 	type		='text'
												maxlength	='50'
                                                size		='50'
                                                name		='ktr'
                                                id			='ktr1'
                                                class		='ktr'
                                                value		='$ktr'
                                                onkeypress	='return enter(this,event)'
                                                onkeyup		='uppercase(this.id)'
                                                $isian2>
									</TD>
								</TR>				
								<TR><TD>Status</TD>
									<TD>:
										<SELECT 	NAME		='stt'
													ID			='stt'
													CLASS		='required'
													TITLE		='...must be filled'
													$isian2>";
										$query4="	SELECT 		g_mststt.* 
													FROM 		g_mststt
													ORDER BY 	g_mststt.kdestt";
										$result4=mysql_query($query4);

										while($data2=mysql_fetch_array($result4))
										{
											if($stt==$data2[kdestt])
												echo"<OPTION VALUE='$data2[kdestt]' SELECTED>$data2[kdestt]</OPTION>";
											else
												echo"<OPTION VALUE='$data2[kdestt]'>$data2[kdestt]</OPTION>";
										}
										echo"
										</SELECT>
										
										Type :";
										if($pilihan=='tambah_item')
										{
											echo"<INPUT TYPE='hidden' 	NAME='kdegru' id='kdegru'	VALUE='$user'>";
											echo"
											<SELECT 	NAME	='kdebbt1'
														ID		='kdebbt1'
														CLASS	='required'
														TITLE	='...must be filled'
														$isian2>
											<OPTION VALUE='' SELECTED>--Select--</OPTION>";
											$query3="	SELECT 		t_mstbbt.*
														FROM 		t_mstbbt
														ORDER BY 	t_mstbbt.kdebbt";
											$result3=mysql_query($query3);
											while($data=mysql_fetch_array($result3))
											{
												if($kdebbt==$data[kdebbt])
													echo"<OPTION VALUE='$data[kdebbt]' SELECTED>$data[nmabbt]</OPTION>";
												else
													echo"<OPTION VALUE='$data[kdebbt]'>$data[nmabbt]</OPTION>";
											}
											echo"
											</SELECT>";
										}
										else
											if($pilihan=='edit')
											{
												echo"
												<SELECT NAME	='kdebbt'
														ID		='kdebbt'

														TITLE	='...must be filled'
														$isian >
												<OPTION VALUE='' SELECTED>--Select--</OPTION>";
												$query3="	SELECT 		t_mstbbt.*
															FROM 		t_mstbbt
															ORDER BY 	t_mstbbt.kdebbt";
												$result3=mysql_query($query3);

												while($data=mysql_fetch_array($result3))
												{
													if($kdebbt==$data[kdebbt])
														echo"<OPTION VALUE='$data[kdebbt]' SELECTED>$data[nmabbt]</OPTION>";
													else
														echo"<OPTION VALUE='$data[kdebbt]'>$data[nmabbt]</OPTION>";
												}
												echo"
												</SELECT>

												<INPUT TYPE='button'  class='uj'						VALUE='Update'>
                                                <INPUT TYPE='hidden'  id='kdeplj1' name='kdeplj'		VALUE='$kdeplj'>
												<INPUT TYPE='hidden'  id='edt' name='pilihan'			VALUE='edit'>
												<INPUT TYPE='hidden' id='kdercuB'	NAME='kdercuB'		VALUE='$kdercu'>";
											}
											else
											{
												echo"
												<SELECT NAME	='kdebbt'
														ID		='kdebbt'
														CLASS	='nmauj'
														TITLE	='...must be filled'
														$isian3 >
												<OPTION VALUE='' SELECTED>--Select--</OPTION>";
												$query3="	SELECT 		t_mstbbt.*
															FROM 		t_mstbbt
															ORDER BY 	t_mstbbt.kdebbt";
												$result3=mysql_query($query3);

												while($data=mysql_fetch_array($result3))
												{
													if($kdebbt==$data[kdebbt])
														echo"<OPTION VALUE='$data[kdebbt]' SELECTED>$data[nmabbt]</OPTION>";
													else
														echo"<OPTION VALUE='$data[kdebbt]'>$data[nmabbt]</OPTION>";
												}
											}
											echo"
                                            <INPUT TYPE='hidden'  id='edt' name='pilihan'		VALUE='tambah'>";
                                            if($pilihan=='detil_general')
                                            {echo"&nbsp;
                                            <INPUT TYPE='button' VALUE='Edit' onClick=window.location.href='guru.php?mode=R1D01C&kdercu=$kdercu&pilihan=edit'>";
                                            }
                                        echo"
									</TD>
								</TR>						
								<TR><TD COLSPAN='2'><HR></TD></TR>
							</TABLE>

							<TABLE BORDER='0' id='inputsoal'  BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
								<TR><TD><b>Question</b></TD></TR>
								<TR><TD>
									<div style='overflow:auto;width:100%;height:260px;padding-right:-2px;'>";
										echo"
										<input	NAME		='soal'
												ID			='soal'
												type		='hidden'
												VALUE		='$soal '
												/readonly>
										$soal
										</div>
									</TD>
								</TR>
								<TR><TD><b>Answer</b>
										<INPUT 	NAME		='sttjwb'
												ID	        ='sttjwb'
												TYPE	    ='text'
												SIZE	    ='1'
												MAXLENGTH   ='1'
												VALUE		='$sttjwb'
												/readonly> 
										<b>Value</b>
										<INPUT 	NAME		='bbtnli'
												ID	        ='bbtnli'
												TYPE	    ='text'
												SIZE	    ='2'
												MAXLENGTH   ='2'
												VALUE		='$bbtnli'
												/readonly>";
										if($pilihan=='detil')
											echo"
											<INPUT TYPE='button' VALUE='Create Question' onClick=window.location.href='guru.php?mode=R1D01C&kdercu=$kdercu1&pilihan=edit'>";
										else
											if($pilihan=='detil_general')
												echo"
												<INPUT TYPE='button' VALUE='Create Question' onClick=window.location.href='guru.php?mode=R1D01C&kdercu=$kdercu1&pilihan=tambah_item'>";
									echo"
									</TD>
								</TR>
							</TABLE>
						</FORM>		
					</TD>";
?>
					<SCRIPT TYPE='text/javascript'>
					$(function()
					{
						//submit untuk Pilih Semua
						$('#all').click(function()
						{
							var kdercu 		= $('#kdercu').val();
                            var kdercu2 		= $('#kdercu2').val();
                            var pilih 		= $('#pilih').val();
							var ktr 		= $('#ktr').val();
							var kdesl 		= $('#kdesl').val();
							var dataString 	='kdercu='+ kdercu+'&ktr='+ktr+'&kdesl='+kdesl+'&pilih='+pilih+'&kdercu2='+kdercu2;
							if(ktr=='')
							{
								alert('Anda belum pilih kelompok soal')
							}
							else
							if(confirm('Apakah anda ingin Masukan data semuanya?!'))
							{
								$.ajax(
								{
									type: 'POST',
									url: '../guru/fungsi_khusus/R1D01C_saveall.php',
									data: dataString,
									success: function()
									{
										document.f1.soal.focus();
										document.f1.soal.value='';
										document.f1.sttjwb.value='';

										$('#rcu').load('../guru/fungsi_khusus/R1D01C_soalru.php?kdercu='+kdercu);

										$('.error').fadeOut(200).hide();
									}
								});
							}
							return false;
						});

						//tampilkan soal pada keterangan di R1D01C//
						$('#kdesl').change(function()
						{
                            var pilih 		= $('#pilih').val();
                            var kdegru 		= $('#kdegru').val();
							var kdeplj 		= $('#kdeplj').val();
							var kdesl 		= $('#kdesl').val();
							
							var dataString	='kdeplj='+kdeplj+'&kdegru='+kdegru+'&kdesl='+kdesl;
							$.ajax(
							{
								type: 'GET',
								url: '../guru/fungsi_khusus/R1D01C_ketsoal.php',
								data: dataString,
								success: function()
								{
									//jika data sukses diambil dari server kita tampilkan
									$('#soal-soal').load('../guru/fungsi_khusus/R1D01C_ketsoal.php?kdegru='+kdegru+'&kdeplj='+kdeplj+'&kdesl='+kdesl+'&pilih='+pilih);
								}
							})
						});
					});
					</script>
<?php
					echo"
					<TD WIDTH='50%' VALIGN='top'>
						<FORM id='detail' name='f2'>
							<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='0' WIDTH='100%'>
								<TR><TD WIDTH='10%'><B>QUESTIONS</B><TD>
									<TD WIDTH='90%' ALIGN='right'>";
										if($pilihan=='tambah_item')
										{
											echo"
                                            <SELECT NAME ='pilih'
                                                    ID   ='pilih'
                                                    TITLE	='...must be filled'>
                                                    <OPTION VALUE='' SELECTED>--Select--</OPTION>
                                                   <OPTION VALUE='banksoal' >--Bank Soal--</OPTION>
                                                   <OPTION VALUE='rencanasoal' >--Rencana Soal--</OPTION>
                                            </select>
											<SELECT 	NAME	='kdesl'
														ID		='kdesl'
														CLASS	='required'
														TITLE	='...must be filled'>
											<OPTION VALUE='' SELECTED>--Select--</OPTION></SELECT>";
											}
										else
										{
											echo"
                                            <SELECT NAME ='pilih'
                                                    ID   ='pilih'
                                                    CLASS='pilih'
                                                    hidden>
                                                    <OPTION VALUE='' SELECTED>--Select--</OPTION>
                                                   <OPTION VALUE='banksoal' >--Bank Soal--</OPTION>
                                                   <OPTION VALUE='rencanasoal' >--Rencana Soal--</OPTION>
                                            </select>
											<SELECT 	NAME	='kdesl'
														ID		='kdesl'
														CLASS	='required'
														$isian3>
											<option value=''>--Select--</option>
											</SELECT>";
										}
										if($pilihan!='detil_general' and $pilihan!='edit')
										{
											echo"
											<INPUT TYPE='button' id='all' class='all' VALUE='All' onClick=window.location.href='#'>";
										}
										echo"		
									</TD>
								</TR>
							</TABLE>
							<div style='overflow:auto;width:100%;height:190px;padding-right:-2px;'>
								<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
									<TR bgcolor='dedede'>
										<TD WIDTH=' 5%' HEIGHT='20'><CENTER>No		</CENTER></TD>
										<TD WIDTH='85%'><CENTER>Question  	</CENTER></TD>
										<TD WIDTH='10%'><CENTER>Detail	</CENTER></TD>
									</TR>";
									if($pilihan=='edit')
									{	
										echo"
										<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>";}
									else
									{
										echo"<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' id='soal-soal' class='table02'>";
									}
									echo"
								</TABLE>
							</div>
						</FORM>

						<FORM id='validasi'>
							<B>QUESTIONS SELECTED</B>
							<div style='overflow:auto;width:100%;height:190px;padding-right:-2px;'>
								<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' class='table02'>
									<TR bgcolor='dedede'>
										<TD WIDTH=' 5%' HEIGHT='20'><CENTER>No		</CENTER></TD>
										<TD WIDTH='75%'><CENTER>Question  	</CENTER></TD>
										<TD WIDTH='10%'><CENTER>Detail	</CENTER></TD>
										<TD WIDTH='10%'><CENTER>Delete	</CENTER></TD>
									</TR>
								<TABLE>	
								<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%' id='rcu' class='table02'>";
									$no=0;
									while($data =mysql_fetch_array($result))
									{ 
										$soal = susun_kalimat(strip_tags($data['soal']),65);
										$no++;
										echo"
										<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
											<TD WIDTH=' 5%'><CENTER>$no			</CENTER></TD>
											<TD WIDTH='75%'>$soal[0]...</TD>";
											// otorisasi akses detil
											// otorisasi akses hapus
											if ($pilihan!='detil_general' and $pilihan!='edit')
											{
												echo"
												<TD WIDTH='10%'><CENTER><a href='#' id='$data[id]' kode='1' class='more'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";
											}
											else
											{
												echo"<TD WIDTH='10%'><CENTER><IMG src='../images/detil_d.gif' BORDER='0'></a></CENTER></TD>";
											}
											if ($pilihan!='detil_general' and $pilihan!='edit')
											{
												echo"<TD WIDTH='10%'><CENTER><a href='#' id='$data[id]'class='hapusru'><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>";
											}
											else
											{
												echo"<TD WIDTH='10%'><CENTER><IMG src='../images/hapus_d.gif' BORDER='0'></a></CENTER></TD>";
											}
										echo"
										</TR>";
									}
									echo"
									<SCRIPT TYPE='text/javascript' src='../guru/js/R1D01C.js'></SCRIPT>
									<SCRIPT TYPE='text/javascript' src='../js/jquery-mins.js'></SCRIPT>
									<SCRIPT TYPE='text/javascript' src='../guru/js/R1D01C_hapus.js'></SCRIPT>
								</TABLE>
							</div>

							<script type='text/javascript'>
							<!--
							function confirmation()
							{
								var answer = confirm('Are you sure ?')
								if (answer)
								{
									window.location.href='guru.php?mode=R1D01C_Hapus&kdercu=$kdercu';
								}
							}
							//-->
							</script>";
							
							echo"			<INPUT TYPE='button' VALUE='New' onClick=window.location.href='guru.php?mode=R1D01C&pilihan=tambah'>";
										if ($pilihan=='detil_general')
										{
											echo"
											
											<INPUT TYPE='button' VALUE='Delete' onClick='confirmation()'>";
										}
										if ($pilihan=='detil_general' or $pilihan=='tambah_item')
										{
											echo"
											<INPUT TYPE='button' VALUE='Print' 	onClick=window.open('pendataan/R1D01C_C01.php?kdercu=$kdercu')>";
										}
										echo"
										<INPUT TYPE='button' 	VALUE='List of Planning Test' 	onClick=window.location.href='guru.php?mode=R1D01C_Cari'>";
							echo"
						</FORM>
					</TD>
				</TR>
			</TABLE>
		</BODY>";
	}

	// -------------------------------------------------- Hapus --------------------------------------------------
	function R1D01C_Hapus()
	{
        $kdercu	=$_GET['kdercu'];

		$query	="	DELETE
					FROM  	g_gnrrcu
					WHERE 	g_gnrrcu.kdercu='". mysql_escape_string($kdercu)."'";
		$result	=mysql_query($query) or die (mysql_error());

		$query	="	DELETE
					FROM  	g_dtlrcu
					WHERE 	g_dtlrcu.kdercu='". mysql_escape_string($kdercu)."'";
		$result	=mysql_query($query) or die (mysql_error());
		
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D01C_Cari\">\n";
	}

	// -------------------------------------------------- Save --------------------------------------------------
	function R1D01C_Save()
	{
		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';

  		$kdegru	=$_POST['kdegru'];
		$kdercu	=$_POST['kdercu'];
        $kdercuB=$_POST['kdercuB'];
  		$kdeplj	=$_POST['kdeplj'];
        $kdekls	=$_POST['kdekls'];
  		$stt	=$_POST['stt'];
  		$kdebbt	=$_POST['kdebbt'];
  		$tglrcu	=$_POST['tglrcu'];
  		$jamrcu	=$_POST['jamrcu'];
        $ktr	=$_POST['ktr'];
  		$pilihan=$_POST['pilihan'];
        $tglrbh =date("d-m-Y");
       	$jamrbh	=date("h:i:s");


		if ($pilihan=='tambah')
		{
			$kdercu = nomor_rcu($kdeplj);
		}
		$set	="	SET		g_gnrrcu.kdegru	='". mysql_escape_string($kdegru)."',
                            g_gnrrcu.kdercu	='". mysql_escape_string($kdercu)."',
		                    g_gnrrcu.kdeplj	='". mysql_escape_string($kdeplj)."',
		                    g_gnrrcu.kdekls	='". mysql_escape_string($kdekls)."',
		                    g_gnrrcu.stt	='". mysql_escape_string($stt)."',
		                    g_gnrrcu.kdebbt	='". mysql_escape_string($kdebbt)."',
		                    g_gnrrcu.tglrcu	='". mysql_escape_string($tglrcu)."',
		                    g_gnrrcu.jamrcu	='". mysql_escape_string($jamrcu)."',
                            g_gnrrcu.ktr	='". mysql_escape_string($ktr)."'";

  		if ($pilihan=='edit')
  		{
    		$query 	="	UPDATE 	g_gnrrcu ".$set.
					 "	WHERE 	g_gnrrcu.kdercu	='". mysql_escape_string($kdercuB)."'";
			$result	=mysql_query($query) or die (mysql_error());
        }
  		else
  		{
  			$query 	="INSERT INTO g_gnrrcu ".$set;
			$result	=mysql_query($query) or die (mysql_error());
  		}
 	}
}//akhir class
?>