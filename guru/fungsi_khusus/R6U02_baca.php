<?php
session_start();
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';

$id=$_GET[id];
$kdekrm=nomor_krm();
$nmak	=$_SESSION["Admin"]["nmakry"];
// buat update status pada g_trmeml//
$stt='R';
	
$set	="	SET		g_trmeml.stt	='". mysql_escape_string($stt)."'";

$query 	="	UPDATE 	g_trmeml ".$set.
        "	WHERE 	g_trmeml.id='". mysql_escape_string($id)."'";
$result =mysql_query ($query) or die (error("Data tidak berhasil di Rubah"));

//end//

$query 	="	SELECT 		g_trmeml.*,t_mstkry.*
			FROM 		g_trmeml,t_mstkry
			WHERE 		g_trmeml.id='". mysql_escape_string($id)."' AND
						g_trmeml.dri=t_mstkry.kdekry								
			ORDER BY	g_trmeml.id";
$result =mysql_query($query);

$j=0;
while($data=mysql_fetch_array($result))
{
	$kde=$data[kdekry];
	$nmakry=$data[nmakry];
	$kdetrm=$data[kdetrm];
	$dri=$data[dri];
	$utk=$data[utk];
	$atch=$data[atch];
	$sbj=$data[sbj];
	$ktr=$data['isi'];
}
$query 	="	SELECT 		g_krmeml.*,t_mstkry.nmakry
			FROM 		g_krmeml,t_mstkry
			WHERE 		g_krmeml.dri='". mysql_escape_string($dri)."' AND
						g_krmeml.dri=t_mstkry.kdekry";
$result1 =mysql_query($query);

$j=0;
while($data=mysql_fetch_array($result1))
{
	$kdek=$data[dri];
	$nmakrm=$data[nmakry];
	$utkk=$data[utk];
}

echo"
<SCRIPT TYPE='text/javascript' 		src='../guru/js/R6U02_baca.js'></SCRIPT>	
<b>INBOX</b>
<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
	<TR></TR><TR></TR>				
						
	<TR><TD>From</TD>
		<TD><INPUT 	NAME		='nmakrm'
					TYPE		='text'
					SIZE		='153'
					VALUE		='$nmakry'
					DISABLED>
			<INPUT 	NAME		='kdekry' TYPE='hidden' VALUE='$kdek' id='kdekry'>
			<input type='hidden' id='di' name='id' value='$id'>
			<INPUT 	NAME='kdekrm' TYPE='hidden' VALUE='$kdetrm'	id='kdekrm'>
		</TD>
	</TR>

	<TR><TD>To</TD>
		<TD COLSPAN='3'>
			<INPUT 	NAME		='nmakry'
					TYPE		='text'
					SIZE		='153'
					VALUE		='$nmak'
					DISABLED>
			<INPUT 	NAME='utk' TYPE='hidden' VALUE='$dri' ID='utk'>
		</TD>
	</TR>
    
	<TR><TD>Subject</TD>
		<TD COLSPAN='3'>
			<INPUT 	NAME		='sbjx'
					TYPE		='text'
					SIZE		='153'
					VALUE		='$sbj'
					DISABLED>
			<INPUT 	NAME='sbj' TYPE='hidden' ID='sbj' VALUE='$sbj'>
		</TD>
	</TR>";
     if($atch=='A')	
	{echo" <TR><TD>File</TD><TD><b>Attachment:</b></TD>";
	 $folder = '../../guru/file_email/terima/'.$kdetrm;  
     $handle = opendir($folder);
	 $ie = 1;
	 while(false !== ($filed = readdir($handle))){  
    if($filed != '.' && $filed != '..'){
	
     echo"<TD></TD>
        <TD COLSPAN='3'>
           $filed<a href='../guru/file_email/terima/$kdetrm/$filed'target='_blank'> [Download]</a><br/>";
		   $ie++;
	}echo"</TD>
    </TR>";
	}
	}	
	echo"<TR><TD VALIGN=top>Message</TD>
		<TD><TEXTAREA 	READONLY
		                NAME		='isi'
						ROWS		='18'
						cols       	='150'
						ID			='isi'
						>$ktr</TEXTAREA>
		</TD>
	</TR>				
				
	<TR>
		<TD>
			<INPUT TYPE='button' id='$kdetrm'  class='balas'		VALUE='Reply'>
		</TD>
	</TR>
</TABLE>";
?>