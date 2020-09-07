<?php
//session_start();
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';
//$nmak	=$_SESSION["Admin"]["nmakry"];
$id=$_GET[id];
//$kdekrm=$_GET[kdekrm];
//$kdekrm=nomor_krm();

$query 	="	SELECT 		g_krmeml.*,t_mstkry.nmakry
			FROM 		g_krmeml,t_mstkry
			WHERE 		g_krmeml.id='". mysql_escape_string($id)."'AND
						g_krmeml.dri=t_mstkry.kdekry";
$result =mysql_query($query);
$j=0;
while($data=mysql_fetch_array($result))
{
	$kde=$data[kdekry];
	$nmakry=$data[nmakry];
	$sbj=$data[sbj];
	$ktr=$data['isi'];
	$utk=$data[utk];
	$atch=$data['atch'];
	$kdekrm=$data['kdekrm'];
}
					
echo"
<SCRIPT TYPE='text/javascript' 		src='../js/email_baca.js'></SCRIPT>	
<b>OUTBOX</b>
<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
	<TR></TR><TR></TR>				
			 
	<TR><TD>From</TD>
		<TD>
			<INPUT 	NAME		='nmakry'
					TYPE		='text'
					SIZE		='153'
					VALUE		='$nmakry'
					DISABLED>
			<INPUT 	NAME		='kdekrm' TYPE='hidden' VALUE='$kdekrm'	id='kdekrm'>
		</TD>
	</TR>

	<TR><TD VALIGN=top>To</TD>
		<TD COLSPAN='3'>";
			$ut=(explode(",",$utk));
			$jmlut=count($ut);
			for($t=0;$t<$jmlut;$t++)
			{
				$query2 	="	SELECT t_mstkry.nmakry
							FROM 		t_mstkry
							WHERE 		t_mstkry.kdekry='". mysql_escape_string($ut[$t])."'";
				$result2 =mysql_query($query2);
				$j=0;
				while($data2=mysql_fetch_array($result2))
				{
					$nmak='['.$data2[nmakry].'] '.$nmak;
				}
			}			
			echo"
			<TEXTAREA 	NAME		='nmak'
						VALUE 		='$nmak'
						ID			='nmak'
						ROWS		='1'
						cols       	='150'
						DISABLED>$nmak</TEXTAREA>";
			
        echo"
		</TD>
	</TR>

	<TR><TD>Subject</TD>
		<TD COLSPAN='3'>
			<INPUT 	NAME		='sbj'
					TYPE		='text'
					SIZE		='153'
					VALUE		='$sbj'
					DISABLED>
		</TD>
	</TR>";
    if($atch=='A')	
	{echo" <TR><TD>File</TD><TD><b>Attachment:</b></TD>";
	 $folder = '../../guru/file_email/kirim/'.$kdekrm;  
     $handle = opendir($folder);
	 $ie = 1;
	 while(false !== ($filed = readdir($handle))){  
    if($filed != '.' && $filed != '..'){
	
     echo"<TD></TD>
        <TD COLSPAN='3'>
           $filed<a href='../guru/file_email/kirim/$kdekrm/$filed'target='_blank'> [Download]</a><br/>";
		   $ie++;
	}echo"</TD>
    </TR>";
	}
	}	
	echo"		
	<TR><TD VALIGN=top>Messages</TD>
		<TD><TEXTAREA DISABLED
						ROWS		='18'
						cols       	='150'
						>$ktr</TEXTAREA>
		</TD>
	</TR>				
</TABLE>";
?>