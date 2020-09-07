<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';

$kdekry=$_GET[kdekry];
$kdekrm=nomor_krm();

//save nomor kirim 
$set	="	SET    	g_krmeml.kdekrm	='". mysql_escape_string($kdekrm)."',
                    g_krmeml.dri	='". mysql_escape_string($kdekry)."'";							
$query 	="	INSERT INTO g_krmeml ".$set;
$result =mysql_query ($query) or die (error("Data tidak berhasil di Input"));

$query 	="	SELECT 		g_krmeml.*
			FROM 		g_krmeml
			WHERE 		g_krmeml.dri='". mysql_escape_string($kdekry)."'	
			ORDER BY	g_krmeml.kdekrm DESC limit 1";
$result =mysql_query($query);
$j=0;
while($data=mysql_fetch_array($result))
{
	$kdek=$data[kdekrm];
	$id=$data[id];
	
}

//end

$query 	="	SELECT 		t_mstkry.*
			FROM 		t_mstkry
			WHERE 		t_mstkry.kdekry='". mysql_escape_string($kdekry)."'	
			ORDER BY	t_mstkry.kdekry";
$result =mysql_query($query);
$j=0;
while($data=mysql_fetch_array($result))
{
	$kde=$data[kdekry];
	$nmakry=$data[nmakry];
}
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
echo"
<b>COMPOSE</b>
<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
	<TR></TR><TR></TR>				
						
	<TR><TD>From</TD>
		<TD>
			<INPUT 	NAME		='nmakry'
					TYPE		='text'
					SIZE		='153'
					VALUE		='$nmakry'
					DISABLED>
			<INPUT 	NAME='kdekry' TYPE='hidden' VALUE='$kdekry'	id='kdekry'>
			<INPUT 	NAME='kdekrm' TYPE='hidden' VALUE='$kdek'	id='kdekrm'>
			<INPUT 	NAME='id' TYPE='hidden'	VALUE='$id' id='id'>
		</TD>
	</TR>

	<TR><TD>To</TD>
		<TD><select data-placeholder='Destination'  name='utk' id='utk' style='width:934px;height:20px;' multiple class='chzn-select' tabindex='5'>";
			$query2="	SELECT 	*
						FROM 		t_mstkry 
						ORDER BY 	t_mstkry.nmakry";
			$result2=mysql_query($query2);
							
			while($data=mysql_fetch_array($result2))
			{
				echo"<OPTION VALUE='$data[kdekry]'>$data[nmakry]</OPTION>";
			}
			echo"
			</select>
		</TD>
	</TR>
    <TR><TD>Subject</TD>
	<TD COLSPAN='3'>
		<INPUT 	NAME		='sbj'
				TYPE		='text'
				SIZE		='153'
				MAXLENGTH	='500'
				ID			='sbj'
				ONKEYPRESS	='return enter(this,event)'
				CLASS		='required'
				TITLE		='...diisi'
				$isian></TD>
	</TR>
     <TR><TD VALIGN=top>Attach File</TD>
	<TD COLSPAN='3'><div id='uploadd'><span>Upload File<span></div>
		<ul id='files' ></ul><input type='hidden' name='atch' id='atch' value='K'>

    </TD>
    </TR>	
			
	<TR><TD VALIGN=top>Message</TD>
		<TD><TEXTAREA 	NAME		='isi'
						ROWS		='18'
						cols       	='150'
						VALUE 		='$isi'
						ID			='isi'
						$isian/></TEXTAREA>
		</TD>
	</TR>				
				
	<TR>
		<TD>
			<INPUT TYPE='button' 	id='kirim'			VALUE='Send'>
		</TD>
	</TR>
</TABLE>";
echo"
<script type='text/javascript'> $('.chzn-select').chosen(); $('.chzn-select-deselect').chosen({allow_single_deselect:true}); </script>";
			
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
</script>
<SCRIPT TYPE='text/javascript' 		src='../guru/js/R6U02_kirim.js'></SCRIPT>
";
?>