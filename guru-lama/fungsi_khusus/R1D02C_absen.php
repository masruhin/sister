<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';

$kdekry	=$_GET['kdekry'];
$query 	="	SELECT 	t_abskry.*,t_sttabs.nmastt
			FROM 	t_abskry,t_sttabs
			WHERE 	t_abskry.kdekry='". mysql_escape_string($kdekry)."'		AND
                    t_abskry.kdestt=t_sttabs.kdestt";
$result =mysql_query($query);
echo"
<div style='overflow:auto;width:100%;height:390px;padding-right:-2px;'>
         <TR>
					<TD WIDTH='90%'>
						<INPUT TYPE='hidden' NAME='kdekry'  	id='kdekry'	VALUE='$kdekry'>
						<INPUT TYPE='hidden' NAME='blnabs'  id='blnabs'	VALUE=''>
						Bulan :
						<SELECT NAME	='blnab'
								ID		='blnab'
								class	='blnab'
								>
						<OPTION VALUE='' SELECTED>--Pilih--</OPTION>
						<OPTION VALUE='01'> Januari </option>
						<OPTION VALUE='02'> Februari </option>
						<OPTION VALUE='03'> Maret </option>
						<OPTION VALUE='04'> April </option>
						<OPTION VALUE='05'> Mei </option>
						<OPTION VALUE='06'> Juni </option>
						<OPTION VALUE='07'> Juli </option>
						<OPTION VALUE='08'> Agustus </option>
						<OPTION VALUE='09'> September </option>
						<OPTION VALUE='10'> Oktober </option>
						<OPTION VALUE='11'> November </option>
						<OPTION VALUE='12'> Desember </option>
						</SELECT>
						Tahun :
						<SELECT NAME	='thnabs'
								ID		='thnabs'
								class	='thnabs'
								>
						<OPTION VALUE='' SELECTED>--Pilih--</OPTION>
						<OPTION VALUE='2012'> 2012 </option>
						<OPTION VALUE='2013'> 2013 </option>
						<OPTION VALUE='2014'> 2014 </option>
						<OPTION VALUE='2015'> 2015 </option>
						<OPTION VALUE='2016'> 2016 </option>
						<OPTION VALUE='2017'> 2017 </option>
						<OPTION VALUE='2018'> 2018 </option>
						<OPTION VALUE='2019'> 2019 </option>
						<OPTION VALUE='2020'> 2020 </option>
						</SELECT>

					</TD>
                </TR><br><br>
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%'>
								<TR bgcolor='dedede'>
									<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No</CENTER></TD>
									<TD WIDTH='10%'><CENTER>Tanggal		</CENTER></TD>
									<TD WIDTH='10%'><CENTER>Status		</CENTER>  </TD>
									<TD WIDTH='76%'><CENTER>Keterangan	</CENTER> </TD>
								</TR>
							 <TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='absn'>
							</TABLE>
						</DIV>";
$no=0;
while($data =mysql_fetch_array($result))
{
	$tglabs	=$data['tglabs'];
    $nmastt	=$data['nmastt'];
    $ktr	=$data['ktr'];

	$no++;
	echo"
	";
}
echo"<SCRIPT TYPE='text/javascript' src='../guru/js/R1D02C_absen.js'></SCRIPT>";
?>