<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

//$isian	='readonly';
$pilih=$_GET['pilih'];
$isian	='disabled';
$rcu	=$_POST['kdercu'];
$id1	=$_GET['id'];

$query 	="	SELECT 	g_dtlsal.*
			FROM 	g_dtlsal
			WHERE 	g_dtlsal.id='". mysql_escape_string($id1)."'";
$result =mysql_query($query);
$data 	=mysql_fetch_array($result);

$id		=$data['id'];
$kdesl	=$data['kdesl'];
$soal	=$data['soal'];
$soal2	=str_replace('+','}',$data['soal']);
$sttjwb	=$data['sttjwb'];
$bbtnli	=$data['bbtnli'];
echo"
<TR><TD><b>Question</b></TD>
<TR><TD>
	<input 	NAME='soal'	TYPE='hidden' ID='soal'	value='$soal2'>
	<div style='overflow:auto;width:100%;height:260px;padding-right:-2px;'>
	$soal
	</div>
	</TD>
</TR>
<TR><TD><b>Answer</b>
		<INPUT 	NAME		='sttjwb'
				ID	        ='sttjwb'
				TYPE	    ='text'
				SIZE	    ='3'
				MAXLENGTH  	='2'
				VALUE		='$sttjwb'
                onkeyup		='uppercase(this.id)'
				CLASS		='required'
				TITLE		='...harus diisi'
				$isian>
		<b>Value</b>
		<INPUT 	NAME		='bbtnli'
				ID	        ='bbtnli'
				TYPE	    ='text'
				SIZE	    ='3'
				MAXLENGTH  	='2'
				VALUE		='$bbtnli'
                onkeyup		='uppercase(this.id)'
				CLASS		='required'
				TITLE		='...harus diisi'
				$isian>
		<INPUT TYPE='submit'  					id='submitrs'	VALUE='Input'>
	</TD>
</TR>	
		
<LINK href='../css/lightbox2.css' 	rel='stylesheet' TYPE='text/css'>
<SCRIPT TYPE='text/javascript' src='../js/hapus.js'></SCRIPT>
<SCRIPT TYPE='text/javascript'>
$(function() 
{
	//submit untuk R1D01C
	$('#submitrs').click(function()
	{
		var kdercu = $('#kdercu').val();
		var soal = $('#soal').val();
		var sttjwb = $('#sttjwb').val();
		var bbtnli = $('#bbtnli').val();
		var dataString ='kdercu='+ kdercu + '&soal=' + soal+ '&sttjwb=' + sttjwb+'&bbtnli='+bbtnli ;

		if(soal=='')
		{ 
			alert('Soal tidak boleh kosong');
			document.f1.soal.focus();
		}
		else
		if(sttjwb=='')
		{ 
			alert('Jawaban tidak boleh kosong');
			document.f1.sttjwb.focus();
		}
		else
		{
			$.ajax(
			{
				type: 'POST',
				url: '../guru/fungsi_khusus/R1D01C_saveru.php',
				data: dataString,
				success: function()
				{
					document.f1.soal.focus();
					$('#rcu').load('../guru/fungsi_khusus/R1D01C_soalru.php?kdercu='+kdercu);
					$('#inputsoal').load('../guru/fungsi_khusus/R1D01C_inputsoal.php?kdercu='+kdercu);
					$('.error').fadeOut(200).hide();
				}
			});
		}
		return false;
	});
});
</SCRIPT>

<SCRIPT TYPE='text/javascript' src='../js/jquery-mins.js'></SCRIPT>";

?>