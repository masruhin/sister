<?php
session_start();
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';
//style CSS upload file
echo"
<style>
#uploadd{
	margin:0px 0px; padding:2px;
	font-weight:bold; font-size:12px;
	font-family:Arial, Helvetica, sans-serif;
	text-align:center;
	background:#f2f2f2;
	color:#3366cc;
	border:1px solid #ccc;
	width:97px;
	height:15px;
	cursor:pointer !important;
	-moz-border-radius:0px; -webkit-border-radius:0px;
}
.darkbg{
	background:#ddd !important;
}
#status{
	font-family:Arial; padding:2px;
}
ul#files{ list-style:none; padding:0; margin:0; }
ul#files li{ padding:3px; margin-bottom:0px; width:180px; float:left; margin-right:2px;}
.success{ }
ul#files li.dl{ padding:3px; margin-bottom:0px; width:17px; float:left; text-align:center; background:#f2f2f2; border:1px; }
.error{ background:#f0c6c3; border:1px solid #cc6622; }
</style>
";
//END style

$kdekrm=$_GET[kdekrm];
$kdekrm1=nomor_krm();
$nmak	=$_SESSION["Admin"]["nmakry"];

$query 	="	SELECT 		g_trmeml.*,t_mstkry.nmakry
			FROM 		g_trmeml,t_mstkry
			WHERE 		g_trmeml.kdetrm='". mysql_escape_string($kdekrm)."' AND
						g_trmeml.utk=t_mstkry.kdekry 								
			ORDER BY	g_trmeml.id";
$result =mysql_query($query);
while($data=mysql_fetch_array($result))
{
	$kde=$data[kdekry];
	$nmakry=$data[nmakry];
	$kdetrm=$data[kdetrm];
	$dri=$data[dri];
	$utk=$data[utk];
	$sbj=$data[sbj];
	$ktr=$data[isi];
	$atch=$data[atch];
}
$query 	="	SELECT 		g_krmeml.*,t_mstkry.nmakry
			FROM 		g_krmeml,t_mstkry
			WHERE 		g_krmeml.kdekrm='". mysql_escape_string($kdekrm)."' AND
                        g_krmeml.dri=t_mstkry.kdekry";
$result =mysql_query($query);
while($data=mysql_fetch_array($result))
{
	$nmakryp=$data[nmakry];
	$kdekryp=$data[dri];
}
//save nomor kirim 
$set	="	SET    	g_krmeml.kdekrm	='". mysql_escape_string($kdekrm)."',
                    g_krmeml.dri	='". mysql_escape_string($kdekryp)."'";							
$query 	="	INSERT INTO g_krmeml ".$set;
$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));

$query 	="	SELECT 		g_krmeml.*
			FROM 		g_krmeml
			WHERE 		g_krmeml.dri='". mysql_escape_string($kdekryp)."'	
			ORDER BY	g_krmeml.id DESC limit 1";
$result =mysql_query($query);
$j=0;
while($data=mysql_fetch_array($result))
{
	$id=$data[id];
	
}

//end
echo"
<SCRIPT TYPE='text/javascript' 		src='../guru/js/R6U02_kirim.js'></SCRIPT>	
<b>REPLY</b>
<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
	<TR></TR><TR></TR>				

	<TR><TD>From</TD>
		<TD>
			<INPUT 	NAME		='nmakry'
					TYPE		='text'
					SIZE		='153'
					VALUE		='$nmak'
					DISABLED>
			<INPUT 	NAME='kdekry' TYPE='hidden' VALUE='$utk' id='kdekry'>
			<INPUT 	NAME='kdekrm' TYPE='hidden'	VALUE='$kdekrm' id='kdekrm'>
			  
		</TD>
	</TR>

	<TR><TD>To</TD>
		<TD COLSPAN='3'>
			<select data-placeholder='Destination'  name='utk' id='utk'  value='$dri'style='width:934px;height:20px;'cols='8' multiple class='chzn-select' tabindex='8'>";
				$query2="	SELECT 		t_mstkry .*
							FROM 		t_mstkry 
							ORDER BY 	t_mstkry.nmakry";
				$result2=mysql_query($query2);
					
				while($data=mysql_fetch_array($result2))
				{
					if($dri==$data[kdekry])
						echo"<OPTION VALUE='$data[kdekry]' SELECTED>$data[nmakry]</OPTION>";
					else
						echo"<OPTION VALUE='$data[kdekry]'>$data[nmakry]</OPTION>";
				}
				echo"
			</select></TD>
	</TR>
	<TR><TD>Subject</TD>
		<TD COLSPAN='3'>
			<INPUT 	NAME		='sbj'
					TYPE		='text'
					SIZE		='153'
					MAXLENGTH	='150'
					ID			='sbj'
					VALUE		='Re:$sbj'
					ONKEYPRESS	='return enter(this,event)'
					CLASS		='required'
					TITLE		='...diisi'
					$isian>
		</TD>
	</TR>
	<TR><TD VALIGN=top>Attach File</TD>
	<TD COLSPAN='3'><div id='uploadd'><span>Upload File<span></div>
		<ul id='files' ></ul><input type='text' name='atch' id='atch' value='K'>

    </TD>
    </TR>
			
	<TR><TD VALIGN=top>Message</TD>
		<TD><TEXTAREA 	NAME		='isi'
						ROWS		='18'
						cols       	='150'
						ID			='isi'
						$isian>>$ktr</TEXTAREA>
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
	echo"			
	<TR>
		<TD><INPUT TYPE='button' 	id='kirim'			VALUE='Kirim'></TD></TR>
</TABLE>
<script type='text/javascript'> $('.chzn-select').chosen(); $('.chzn-select-deselect').chosen({allow_single_deselect:true}); </script>
";
echo"
<script type=\"text/javascript\" >
	$(function(){
		var btnUpload=$('#uploadd');
		var status=$('#status');
		var kdekrm = $('#kdekrm').val();
		new AjaxUpload(btnUpload, {
			action: '../guru/fungsi_khusus/R6U02_uploadfile.php?kdekrm='+kdekrm,
			name: 'uploadfile',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif|txt|xls|ppt|pps|doc|docx|xlsc)$/.test(ext))){ 
                    // extension is not allowed 
					status.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
				status.text('Uploading...');
			},
			onComplete: function(file, response){
				//On completion clear the status
				status.text('');
				
				//Add uploaded file to list
				if(response===\"success\"){
				    document.f1.atch.value='A';
				    $('<li></li>').appendTo('#files').html(file+'&nbsp <a href=\"#\" style=\"text-decoration:none;align:right;width:20px;\" class=\"del\">(Del)</a>').addClass('success');
					
					$(\".del\", document.getElementById('files')).live('click', function(){
					
					$.ajax(
					{
						type: \"GET\",
						url: \"../guru/fungsi_khusus/R6U02_hapusimg.php?file=\"+file+\"&kdekrm=\"+kdekrm,
						
					});
					$(this).parent().remove();
					if($('#files').text())
					{
					document.f1.atch.value='A';
					}
					else
					{
					document.f1.atch.value='K';
					}
					
					
					})
					
					
				} else{
					$('<li></li>').appendTo('#files').text('File Error').addClass('error');
				}
			}
		});
		
	});
</script>";
?>