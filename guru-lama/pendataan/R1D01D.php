<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D01D.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi MATERI PELAJARAN
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D01Dclass
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function R1D01D_Cari()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";
		
		$user	=$_SESSION["Admin"]["kdekry"];
        $kdekls	=$_GET['kdekls'];
		$kdeplj	=$_GET['kdeplj'];

		$query 	="	SELECT 		g_gnrnli.*,t_mstplj.nmaplj,t_mstbbt.*
					FROM   		g_gnrnli,t_mstplj,t_mstbbt
					WHERE 		(t_mstplj.kdeplj 	LIKE'%".$kdeplj."%'	OR '$kdeplj'='')	AND
                                (g_gnrnli.kdekls 	LIKE'%".$kdekls."%'	OR '$kdekls'='')	AND
								(g_gnrnli.kdegru 	LIKE'%".$user."%')  					AND
								g_gnrnli.kdeplj=t_mstplj.kdeplj								AND
								g_gnrnli.kdebbt=t_mstbbt.kdebbt
					ORDER BY 	g_gnrnli.kdekls,g_gnrnli.kdenli";
		$result =mysql_query($query) or die (mysql_error());

		echo"
		<FORM ACTION=guru.php METHOD='get' NAME='f1'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD><B>NILAI</B></TD></TR>
				<TR></TR><TR></TR>

				<TR><TD WIDTH='15%'>Kelas</TD>
  					<TD WIDTH='85%'>:
						<SELECT	NAME		='kdekls'
								ID			='kdekls'
								onkeypress	='return enter(this,event)'>
						<OPTION VALUE='' SELECTED>--Semua--</OPTION>";
						$query2="	SELECT DISTINCT	t_mstpng.kdekls,t_mstkls.*
									FROM 			t_mstpng,t_mstkls
									WHERE 			t_mstpng.kdegru='$user'	AND
													t_mstpng.kdekls=t_mstkls.kdekls
									ORDER BY 		t_mstkls.kdeklm,t_mstpng.kdekls ";
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
					</TD>
  				</TR>
				<TR><TD>Pelajaran</TD>
					<TD>:
						<SELECT NAME	='kdeplj'
								ID		='kdeplj'>
						<OPTION VALUE='' SELECTED>--Semua--</OPTION>";
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
						<INPUT TYPE='submit' 					VALUE='Cari'>
						<INPUT TYPE='hidden' 	NAME='mode'		VALUE='R1D01D_Cari'>
						<INPUT TYPE='button' 					VALUE='Tampilkan Semua' onClick=window.location.href='guru.php?mode=R1D01D_Cari'>
					</TD>
				</TR>
			</TABLE>
		</FORM>

		<FORM ACTION='guru.php?mode=R1D01D' METHOD='post'>
			<DIV style='overflow:auto;width:100%;height:310px;padding-right:-2px;'>		
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No				</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Kelas 		</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Kode Nilai 	</CENTER></TD>
						<TD WIDTH='25%'><CENTER>Pelajaran	</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Tanggal 	</CENTER></TD>
						<TD WIDTH=' 8%'><CENTER>Bobot		</CENTER></TD>
						<TD WIDTH='25%'><CENTER>Keterangan	</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Detil		</CENTER></TD>
						<TD WIDTH=' 4%'><CENTER>Hapus		</CENTER></TD>
					</TR>";

					$no=0;
					while($data =mysql_fetch_array($result))
					{
						$no++;
						echo"
						<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
							<TD><CENTER>$no				</CENTER></TD>
							<TD><CENTER>$data[kdekls]	</CENTER></TD>
							<TD><CENTER>$data[kdenli]	</CENTER></TD>
							<TD><CENTER>$data[nmaplj]	</CENTER></TD>
							<TD><CENTER>$data[tglujn]	</CENTER></TD>
							<TD><CENTER>$data[nmabbt]	</CENTER></TD>
							<TD><CENTER>$data[ktr]		</CENTER></TD>";
							
							// otorisasi detil
							echo"
							<TD><CENTER><a href='guru.php?mode=R1D01D&kdenli=$data[kdenli]&pilihan=detil_general' id='update'><IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>";

							// otorisasi hapus
							echo"
							<TD><CENTER><a href='guru.php?mode=R1D01D_Hapus&kdenli=$data[kdenli]' onClick=\"return confirm('Benar data akan dihapus ?');\"><IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>
						</TR>";
					}
				echo"
				</TABLE>
			</DIV>	
			<BR>
			<INPUT TYPE='button' VALUE='Isi Nilai Baru' onClick=window.location.href='guru.php?mode=R1D01D&pilihan=tambah_general'>
		</FORM>";
 	}

	// -------------------------------------------------- Item --------------------------------------------------
	function R1D01D()
	{
	  //buat tampilkan murid2

		require_once '../fungsi_umum/sysconfig.php';
		require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';
		$user	=$_SESSION["Admin"]["kdekry"];
		// deklarasi java
		echo"
		<SCRIPT TYPE='text/javascript' 		src='../js/ajax.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 		src='../js/ajax-dynamic-list.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' 		src='../js/DatePicker/WdatePicker.js'></SCRIPT>
		<LINK 	href='../css/val.css' 		rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 		src='../js/jquery-validate.js'></SCRIPT>";

		echo"
		<SCRIPT TYPE='text/javascript' src='../js/jquery-1.2.3.pack.js'></SCRIPT>
		<SCRIPT TYPE='text/javascript' src='../js/jquery.validate.pack.js'></SCRIPT>";

		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		echo"<SCRIPT TYPE='text/javascript' src='../guru/js/R1D01D.js'></SCRIPT>";
		
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
                //$kdenli =nomor_nli();
                $isian4	='disabled';
				break;
			case 'tambah_general':
				$isian1	='enable';
				$isian2	='enable';
				$isian3	='enable';
				$user1	=$user;
                $kdenli =nomor_nli();
				break;
			case 'input_nilai':
				$isian1 ='disabled';
				$isian2	='disabled';
				$isian3	='disabled';
                $isian4	='enable';
				break;

		}

		if ($pilihan=='detil_general' or $pilihan=='input_nilai' )
		{
			$kdenliB=$_GET['kdenli'];
			$query 	="	SELECT 	g_gnrnli.*
						FROM 	g_gnrnli
						WHERE 	g_gnrnli.kdenli='". mysql_escape_string($kdenliB)."'";
			$result =mysql_query($query);
			$data 	=mysql_fetch_array($result);
            $kdenli	=$data['kdenli'];
			$kdekls	=$data['kdekls'];
            $kdenli1=$data['kdenli'];
            $kdeplj =$data['kdeplj'];
            $ktr	=$data['ktr'];
            $tglujn	=$data['tglujn'];
            $kdebbt	=$data['kdebbt'];
		}	
		
		if ($pilihan=='detil_general' or $pilihan=='input_nilai')
		{
			$kdenli3=$_GET['kdenli'];
			$query1 ="	SELECT 		g_dtlnli.*,t_mstssw.nmassw
						FROM 		g_dtlnli,t_mstssw
						WHERE 		g_dtlnli.kdenli	='". mysql_escape_string($kdenli3)."'AND
                                    g_dtlnli.nis	=t_mstssw.nis
                        ORDER BY 	g_dtlnli.kdenli";
			$result =mysql_query($query1);
			$data1 	=mysql_fetch_array($result);
			$kdenli	=$data1['kdenli'];
			$nis	=$data1['nis'];
            $nmassw	=$data1['nmassw'];
            $nli	=$data1['nli'];
		}

		// akhir inisiasi parameter
		$query2 ="	SELECT 		*,t_mstssw.nmassw
					FROM  		g_dtlnli,t_mstssw
					WHERE 		g_dtlnli.kdenli='". mysql_escape_string($kdenli)."'AND
                                g_dtlnli.nis=t_mstssw.nis
					ORDER BY	g_dtlnli.kdenli";
		$result= mysql_query($query2) or die (mysql_error());

		echo"
		<FORM ID='validasi'  METHOD='post' NAME='f1'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>NILAI</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Kelas</TD>
					<TD WIDTH='85%'>:
						<INPUT TYPE='hidden' 	NAME='kdegru' id='kdegru'	VALUE='$user'>
                        <INPUT TYPE='hidden' 	NAME='kdenli' id='kdenli'	VALUE='$kdenli'>
                        <INPUT TYPE='hidden' 	NAME='kdekls1' id='kdekls1'	VALUE=''>

                        <SELECT NAME	='kdekls'
								ID		='kdekls'
                                CLASS	='kdekls'
								value	='$kdekls'
                                $isian1>
						<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
						$query2="	SELECT 		DISTINCT t_mstpng.kdekls,t_mstkls.*
									FROM 		t_mstpng,t_mstkls
									WHERE		t_mstpng.kdegru='$user'	AND
												t_mstpng.kdekls=t_mstkls.kdekls
									ORDER BY	t_mstkls.kdeklm,t_mstpng.kdekls";
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

						Pelajaran :
						<SELECT NAME	='kdeplj'
								ID		='kdeplj'
								class	='kdeplj'
								value	='$kdeplj'
                                disabled>
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
					</TD>
				</TR>
				<TR><TD>Bobot</TD>
                    <TD>:
						<SELECT NAME	='kdebbt'
								ID		='kdebbt'
								CLASS	='kdebbt'
								TITLE	='...harus diisi'
								$isian3 >
						<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
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
                        Tanggal : 
							<input 	name		='tglujn' 
									type		='text' 
									size		='12'
									id			='tglujn' 
									value		='$tglujn' 
									onkeypress	='return enter(this,event)'
									$isian2>
						<IMG onClick='WdatePicker({el:tglujn});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle'>
					</TD>
              	</TR>
              	<TR><TD>Keterangan</TD>
					<TD>:";
                    if($pilihan=='tambah_general')
                    {echo"

						<INPUT 	NAME		='ktr'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='200'
								VALUE		='$ktr'
								onkeyup		='uppercase(this.id)'
								ID			='ktr'
                                CLASS		='ktr'
								TITLE		='...harus diisi'
								$isian3>";

                    }
                    else
                    {
                     echo"

						<INPUT 	NAME		='ktr1'
								TYPE		='text'
								SIZE		='50'
								MAXLENGTH	='200'
								VALUE		='$ktr'
								onkeyup		='uppercase(this.id)'
								ID			='ktr1'
								TITLE		='...harus diisi'
								$isian3> &nbsp";
                                if($pilihan=='detil_general')
                                {echo"<input type='button' id='edit'value='Edit'>
                                      <input type='button' id='update'value='Update' hidden/>

                                      <INPUT TYPE='hidden'  id='edt' name='pilihan'		VALUE='detil_general'>";
                    }
                    }
                                echo"
                      </TD>
				</TR>	  
			</TABLE>
		</FORM>

		<FORM  id='validasi' method='post' action='../guru/fungsi_khusus/R1D01D_updatenli.php' NAME='f2'>
			<div style='overflow:auto;width:100%;height:290px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
						<TD WIDTH='10%'><CENTER>NIS  			</CENTER></TD>
						<TD WIDTH='76%'><CENTER>Nama Siswa  	</CENTER></TD>
						<TD WIDTH='10%'><CENTER>Nilai  			</CENTER></TD>
					</TR>";
					
					$kdenli =$_GET['kdenli'];
					$query 	=mysql_query("	SELECT   	g_dtlnli.*,t_mstssw.nmassw
											FROM 		g_dtlnli,t_mstssw
											WHERE    	g_dtlnli.kdenli ='$kdenli' AND
														g_dtlnli.nis = t_mstssw.nis
											ORDER BY 	g_dtlnli.nis");
					$i=1;

					while($data =mysql_fetch_array($query))
					{
						$nmassw	=$data[nmassw];
						$nis	=$data[nis];
                       	echo"
						<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
							<TD><CENTER>$i	</CENTER></TD>
							<TD><CENTER>$nis</CENTER></TD>
							<TD><input type='hidden' name='kdenli'		id='kdenli' value='$data[kdenli]'>
								<input type='hidden' name='nis".$i."'	id='nis' 	value='$data[nis]'>$nmassw</TD>
							<TD><center>
								<input 	type		='text'  
										size		='4'
										name		='nli".$i."'
										id			='nli'
										class		='nli'
										value		='$data[nli]' 
										ONKEYUP		='uppercase(this.id)'
										ONKEYPRESS	='return enter(this,event)'
										$isian4></center>
							</TD>
						</TR>";
						$i++;
					}
					$jumSiswa=$i-1;
					
					echo"
                    <input type='hidden' id='n' name='n' value='$jumSiswa'>
				</TABLE>
			</DIV>
			<BR>";
		
			if ($pilihan=='input_nilai')
			{
				echo"
				<INPUT TYPE='submit' VALUE='Simpan' name='submit'>";
			}
			if ($pilihan=='detil_general')
			{
				echo"
				<INPUT TYPE='button' VALUE='Edit' 	onClick=window.location.href='guru.php?mode=R1D01D&kdenli=$kdenli&pilihan=input_nilai'>
				<INPUT TYPE='button' VALUE='Cetak' 	onClick=window.open('pendataan/R1D01D_Cetak.php?kdenli=$kdenli')>";
			}
		echo"
		<INPUT TYPE='button' VALUE='Daftar Nilai' onClick=window.location.href='guru.php?mode=R1D01D_Cari'>
		</FORM>";
	}

	// -------------------------------------------------- Hapus --------------------------------------------------
	function R1D01D_Hapus()
	{
		$kdegru	=$_GET['kdenli'];

		$query	="	DELETE
					FROM  	g_gnrnli
					WHERE 	g_gnrnli.kdenli='". mysql_escape_string($kdegru)."'";
		$result =mysql_query($query) or die (mysql_error());

		$query	="	DELETE
					FROM  	g_dtlnli
					WHERE 	g_dtlnli.kdenli='". mysql_escape_string($kdegru)."'";
		$result =mysql_query($query) or die (mysql_error());
		
		echo"<meta http-equiv='refresh' content=\"0;url=guru.php?mode=R1D01D_Cari\">\n";
	}

	// -------------------------------------------------- Save General --------------------------------------------------
	function R1D01D_Save()
	{
		require_once '../fungsi_umum/sysconfig.php';
		
		$thn	='Tahun Ajaran';
		$sms	='Semester';
	
		$query 	=mysql_query("	SELECT 		t_setthn.* 
								FROM 		t_setthn
								WHERE		t_setthn.set='$thn'");
		$data = mysql_fetch_array($query);
		$thnajr=$data[nli];
	
		$query 	=mysql_query("	SELECT 		t_setthn.* 
								FROM 		t_setthn
								WHERE		t_setthn.set='$sms'");
		$data = mysql_fetch_array($query);
		$kdesms=$data[nli];

        $kdenli	=$_POST['kdenli'];
  		$kdegru	=$_POST['kdegru'];
        $kdekls	=$_POST['kdekls'];
  		$kdeplj	=$_POST['kdeplj'];
        $kdebbt	=$_POST['kdebbt'];
        $tglujn	=$_POST['tglujn'];
        $ktr	=$_POST['ktr'];
  		$pilihan=$_POST['pilihan'];

		$set	="	SET     g_gnrnli.kdenli	='". mysql_escape_string($kdenli)."',
							g_gnrnli.thnajr	='". mysql_escape_string($thnajr)."',
							g_gnrnli.kdesms	='". mysql_escape_string($kdesms)."',
                            g_gnrnli.kdegru	='". mysql_escape_string($kdegru)."',
		                    g_gnrnli.kdekls	='". mysql_escape_string($kdekls)."',
		                    g_gnrnli.kdeplj	='". mysql_escape_string($kdeplj)."',
                            g_gnrnli.kdebbt	='". mysql_escape_string($kdebbt)."',
		                    g_gnrnli.tglujn	='". mysql_escape_string($tglujn)."',
		                    g_gnrnli.ktr	='". mysql_escape_string($ktr)."'";

		$query 	="INSERT INTO g_gnrnli ".$set;
		$result	=mysql_query($query) or die (mysql_error());

		$query 	="	INSERT INTO g_dtlnli(kdenli,nis)
					SELECT 		'$kdenli'as kdenli,nis 
					FROM 		t_mstssw 
					WHERE  		t_mstssw.kdekls='". mysql_escape_string($kdekls)."'";
		$result =mysql_query($query) or die (mysql_error());
 	}
// -------------------------------------------------- Update General --------------------------------------------------
	function R1D01D_Update()
	{
		require_once '../fungsi_umum/sysconfig.php';

        $kdenli	=$_POST['kdenli'];
        $kdebbt	=$_POST['kdebbt'];
        $tglujn	=$_POST['tglujn'];
        $ktr	=$_POST['ktr1'];

		$set	="	SET     g_gnrnli.kdebbt	='". mysql_escape_string($kdebbt)."',
		                    g_gnrnli.tglujn	='". mysql_escape_string($tglujn)."',
		                    g_gnrnli.ktr	='". mysql_escape_string($ktr)."'";

		$query 	="UPDATE g_gnrnli ".$set.
                 "WHERE 	g_gnrnli.kdenli	='". mysql_escape_string($kdenli)."'";
		$result	=mysql_query($query) or die (mysql_error());
 	}
}//akhir class
?>