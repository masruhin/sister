<?php
require '../fungsi_umum/sysconfig.php';
require FUNGSI_UMUM_DIR.'koneksi.php';
require FUNGSI_UMUM_DIR.'fungsi_pass.php';
echo"<HTML>\n<HEAD>\n<TITLE>INFO ABSEN</TITLE>\n<LINK rel='stylesheet' type='text/css' href='../css/styleabsen.css'></HEAD>\n<BODY>\n";

$absen 	=$_POST['absen'];
$tglabs =$_POST['tglabs'];
$jamabs =$_POST['jamabs'];
$kdestt	='1';

//untuk absen siswa//

$ssw 	=mysql_query("	SELECT 	t_absssw.*
						FROM 	t_absssw
						WHERE 	t_absssw.nis 	='".mysql_escape_string($absen)."' 		AND
								t_absssw.tglabs ='". mysql_escape_string($tglabs) ."'");
while($data=mysql_fetch_array($ssw))
{
	$nis=$data['nis'];
    $kdekls=$data['kdekls'];
    $jamdtn=$data['jamdtn'];
    $jampln=$data['jampln'];
}

$mstss 	=mysql_query("	SELECT 	t_mstssw.*
						FROM 	t_mstssw
						WHERE 	t_mstssw.nis 	='".mysql_escape_string($absen)."'");
while($data=mysql_fetch_array($mstss))
{
	$nis=$data['nis'];
    $kdekls=$data['kdekls'];
    $nmassw=$data['nmassw'];
}

if (mysql_num_rows($ssw)== 0 AND $absen==$nis)
{
	$set	="	SET t_absssw.kdekls	='". mysql_escape_string($kdekls)."',
                    t_absssw.nis	='". mysql_escape_string($absen)."',
                    t_absssw.kdestt	='". mysql_escape_string($kdestt)."',
                    t_absssw.tglabs	='". mysql_escape_string($tglabs)."',
					t_absssw.jamdtn	='". mysql_escape_string($jamabs)."'";

	$query 	="	INSERT INTO t_absssw ".$set;
	$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
    
	echo"
	<CENTER>
	<DIV  class='display_absen'>
	<TABLE class='table_absen'>
		<TR><TD COLSPAN=2><u>DATA ABSEN ( IN )</u></TD></TR>
		<TR><TD WIDTH='75%'>$nmassw</TD>
			<TD WIDTH='25%' ROWSPAN=5 valign='top'><IMG src='../files/photo/siswa/$nis.jpg' ALIGN=left HEIGHT=130 WIDTH=110>
		</TR>
		<TR><TD>$tglabs - $jamabs</TD></TR>
        <TR><TD COLSPAN=2>Absen berhasil...</TD></TR>
	</TABLE>
	</DIV>
	</CENTER>";
    
	echo"<meta http-equiv=\"refresh\" content=\"1;url=index.php\">\n";
}
else
if(!empty($jamdtn))
{
	$set	="	SET t_absssw.jampln	='". mysql_escape_string($jamabs)."'";

	$query 	="	UPDATE 	t_absssw ".$set."
				WHERE 	t_absssw.nis='". mysql_escape_string($nis)."'AND
						t_absssw.tglabs='". mysql_escape_string($tglabs)."'";
	$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
		
	echo"
	<CENTER><DIV  class='display_absen'>
		<TABLE class='table_absen'>
			<TR><TD COLSPAN=2><u>DATA ABSEN ( OUT )</u></TD></TR>
			<TR><TD WIDTH='75%'>$nmassw</TD>
				<TD WIDTH='25%' ROWSPAN=5 valign='top'><IMG src='../files/photo/siswa/$nis.jpg' ALIGN=left HEIGHT=130 WIDTH=110>
			</TR>	
			<TR><TD>$tglabs - $jamabs</TD></TR>
			<TR><TD COLSPAN=2>Absen berhasil...</TD></TR>
		</TABLE>
	</DIV></CENTER>";
            
	echo"<meta http-equiv=\"refresh\" content=\"1;url=index.php\">\n";
}

// END Absen siswa

//untuk absen karyawan
$kry 	=mysql_query("	SELECT 	t_abskry.*
						FROM 	t_abskry
						WHERE 	t_abskry.kdekry 	='".mysql_escape_string($absen)."' 		AND
						        t_abskry.tglabs 	='". mysql_escape_string($tglabs) ."'");
while($data=mysql_fetch_array($kry))
{
	$kdekry=$data['kdekry'];
	$jamdtnk=$data['jamdtn'];
	$jamplnk=$data['jampln'];
}

$mstkry	=mysql_query("	SELECT 	t_mstkry.*
						FROM 	t_mstkry
						WHERE 	t_mstkry.kdekry 	='".mysql_escape_string($absen)."'");
						
while($data=mysql_fetch_array($mstkry))
{
	$kdekry=$data['kdekry'];
	$nmakry=$data['nmakry'];
}

if (mysql_num_rows($kry)== 0 and $absen==$kdekry)
{
	$set	="	SET t_abskry.kdekry	='". mysql_escape_string($absen)."',
					t_abskry.kdestt	='". mysql_escape_string($kdestt)."',
					t_abskry.tglabs	='". mysql_escape_string($tglabs)."',
					t_abskry.jamdtn	='". mysql_escape_string($jamabs)."'";

	$query 	="	INSERT INTO t_abskry ".$set;
	$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
	echo"
    <CENTER><DIV  class='display_absen'>
		<TABLE class='table_absen'>
			<TR><TD COLSPAN=2><u>DATA ABSEN ( IN )</u></TD></TR>
			<TR><TD WIDTH='75%'>$nmakry</TD>
				<TD WIDTH='25%' ROWSPAN=5 valign='top'><IMG src='../files/photo/karyawan/$kdekry.jpg' ALIGN=left HEIGHT=130 WIDTH=110></TD>
			</TR>	
			<TR><TD>$tglabs - $jamabs</TD></TR>
			<TR><TD COLSPAN=2>Absen berhasil...</TD></TR>
		</TABLE>
	</DIV></CENTER> ";
	echo"<meta http-equiv=\"refresh\" content=\"1;url=index.php\">\n";
}
else
if(!empty($jamdtnk))
{
	$set	="	SET t_abskry.jampln	='". mysql_escape_string($jamabs)."'";

	$query 	="	UPDATE 	t_abskry ".$set."
                WHERE 	kdekry='". mysql_escape_string($kdekry)."'AND
						tglabs='". mysql_escape_string($tglabs)."'";
	$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));
	echo"
	<CENTER><DIV  class='display_absen'>
		<TABLE class='table_absen'>
			<TR><TD COLSPAN=2><u>DATA ABSEN ( OUT )</u></TD></TR>
			<TR><TD WIDTH='75%'>$nmakry</TD>
				<TD WIDTH='25%' ROWSPAN=5 valign='top'><IMG src='../files/photo/karyawan/$kdekry.jpg' ALIGN=left HEIGHT=130 WIDTH=110></TD>
			</TR>	
			<TR><TD>$tglabs - $jamabs</TD></TR>
			<TR><TD COLSPAN=2>Absen berhasil...</TD></TR>
		</TABLE>
	</DIV></CENTER> ";
	echo"<meta http-equiv=\"refresh\" content=\"1;url=index.php\">\n";
}
else
if($absen!=$nis and $absen!=$kdekry)
{
	echo"
	<CENTER><DIV class='display_error'>
		<TABLE class='table_error'>
			<TR><TD><CENTER>MAAF DATA TIDAK TERDAFTAR</CENTER></TD></TR>
		</TABLE>
	</DIV></CENTER>";

	echo"<meta http-equiv=\"refresh\" content=\"1;url=index.php\">\n";
}
 //end absen karywan
?>