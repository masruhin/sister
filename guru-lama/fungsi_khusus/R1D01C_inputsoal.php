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
$jwb1	=$data['jwb1'];
$jwb2	=$data['jwb2'];
$jwb3	=$data['jwb3'];
$jwb4	=$data['jwb4'];
$jwb5	=$data['jwb5'];
$sttjwb	=$data['sttjwb'];

echo"
<TR><TD WIDTH='10%' VALIGN='top'><center><b>Soal</b></center></TD>
	<TD width='90%' valign='top'>
		<textarea 	NAME		='soal'
					ID			='soal'
					CLASS		='textarea_01'
					$isian>$soal</textarea>";
		$gb3	='<img src="../files/photo/soal/GBsoal'.$kdesl.''.$id.'.jpg" alt="NO IMG" width="40" height="40"/>';
        $gb4	='<img src="../files/photo/soal/noimg.jpeg" alt="" width="40" height="40"/>';
        $file	='../../';
        $fl		=realpath($file).'\photo\soal\GBsoal'.$kdesl.''.$id.'.jpg';
        if(file_exists($fl))
        {
			echo"
			<a href = 'javascript:void(0)'onclick = \"document.getElementById('s1').style.display='block';document.getElementById('fade1').style.display='block'\">
            <img src='../files/photo/soal/GBsoal".$kdesl."".$id.".jpg' alt='' width='40' height='40'></a>
            <div id='s1'class='white_content' '><a href = 'javascript:void(0)' onclick = \"document.getElementById('s1').style.display='none';document.getElementById('fade1').style.display='none'\">
				<img src='../files/photo/soal/GBsoal".$kdesl."".$id.".jpg' alt='' class='resize'></a>
			</div>
			<a href = 'javascript:void(0)' onclick=\"document.getElementById('s1').style.display='none';document.getElementById('fade1').style.display='none'\"> <div id='fade1' class='black_overlay'></div></a>";
		}
        echo"
	</TD>
</TR>
<TR><TD><center><p style='font-size:18px'><b>A</b></p></center></TD>
	<TD ><textarea 	NAME		='jwb1'
					ID	        ='jwb1'
					TYPE	    ='text'
					CLASS		='textarea_02'
					$isian>$jwb1</textarea>";
		$gb3	='<img src="../files/photo/soal/GBjwb1'.$kdesl.''.$id.'.jpg" alt="NO IMG" width="40" height="40"/>';
        $gb4	='<img src="../files/photo/soal/noimg.jpeg" alt="" width="40" height="40"/>';
        $file	='../../';
        $fl		=realpath($file).'\photo\soal\GBjwb1'.$kdesl.''.$id.'.jpg';
        if(file_exists($fl))
        {
			echo"
			<a href = 'javascript:void(0)'onclick = \"document.getElementById('j1').style.display='block';document.getElementById('fade2').style.display='block'\">
            <img src='../files/photo/soal/GBjwb1".$kdesl."".$id.".jpg' alt='' width='40' height='40'></a>
            <div id='j1'class='white_content' '><a href = 'javascript:void(0)' onclick = \"document.getElementById('j1').style.display='none';document.getElementById('fade2').style.display='none'\">
				<img src='../files/photo/soal/GBjwb1".$kdesl."".$id.".jpg' alt='' class='resize'></a>
			</div>
			<a href = 'javascript:void(0)' onclick=\"document.getElementById('j1').style.display='none';document.getElementById('fade2').style.display='none'\"> <div id='fade2' class='black_overlay'></div></a>";
		}
		echo"
	</TD>
</TR>
<TR><TD><center><p style='font-size:18px'><b>B</b></p></center></TD>
	<TD><textarea 	NAME		='jwb2'
					ID			='jwb2'
					TYPE		='text'
					CLASS		='textarea_02'
					$isian>$jwb2</textarea>";
		$gb3	='<img src="../files/photo/soal/GBjwb2'.$kdesl.''.$id.'.jpg" alt="NO IMG" width="40" height="40"/>';
        $gb4	='<img src="../files/photo/soal/noimg.jpeg" alt="" width="40" height="40"/>';
        $file	='../../';
        $fl		=realpath($file).'\photo\soal\GBjwb2'.$kdesl.''.$id.'.jpg';
        if(file_exists($fl))
        {
			echo"
			<a href = 'javascript:void(0)'onclick = \"document.getElementById('j2').style.display='block';document.getElementById('fade3').style.display='block'\">
            <img src='../files/photo/soal/GBjwb2".$kdesl."".$id.".jpg' alt='' width='40' height='40'></a>
            <div id='j2'class='white_content' '><a href = 'javascript:void(0)' onclick = \"document.getElementById('j2').style.display='none';document.getElementById('fade3').style.display='none'\">
				<img src='../files/photo/soal/GBjwb2".$kdesl."".$id.".jpg' alt='' class='resize'></a>
			</div>
			<a href = 'javascript:void(0)' onclick=\"document.getElementById('j2').style.display='none';document.getElementById('fade3').style.display='none'\"> <div id='fade3' class='black_overlay'></div></a>";
		}
        echo"
	</TD>
</TR>
<TR><TD><center><p style='font-size:18px'><b>C</b></p></center></TD>
	<TD><textarea 	NAME		='jwb3'
					ID			='jwb3'
					TYPE		='text'
					CLASS		='textarea_02'
					$isian>$jwb3</textarea>";
		$gb3	='<img src="../files/photo/soal/GBjwb3'.$kdesl.''.$id.'.jpg" alt="NO IMG" width="40" height="40"/>';
        $gb4	='<img src="../files/photo/soal/noimg.jpeg" alt="" width="40" height="40"/>';
        $file	='../../';
        $fl		=realpath($file).'\photo\soal\GBjwb3'.$kdesl.''.$id.'.jpg';
        if(file_exists($fl))
        {
			echo"
			<a href = 'javascript:void(0)'onclick = \"document.getElementById('j3').style.display='block';document.getElementById('fade4').style.display='block'\">
            <img src='../files/photo/soal/GBjwb3".$kdesl."".$id.".jpg' alt='' width='40' height='40'></a>
            <div id='j3'class='white_content' '><a href = 'javascript:void(0)' onclick = \"document.getElementById('j3').style.display='none';document.getElementById('fade4').style.display='none'\">
				<img src='../files/photo/soal/GBjwb3".$kdesl."".$id.".jpg' alt='' class='resize'></a>
			</div>
			<a href = 'javascript:void(0)' onclick=\"document.getElementById('j3').style.display='none';document.getElementById('fade4').style.display='none'\"> <div id='fade4' class='black_overlay'></div></a>";
		}
		echo"
	</TD>
</TR>
<TR><TD><center><p style='font-size:18px'><b>D</b></p></center></TD>
	<TD><textarea 	NAME		='jwb4'
					ID			='jwb4'
					TYPE		='text'
					CLASS		='textarea_02'
					$isian>$jwb4</textarea>";
		$gb3	='<img src="../files/photo/soal/GBjwb4'.$kdesl.''.$id.'.jpg" alt="NO IMG" width="40" height="40"/>';
        $gb4	='<img src="../files/photo/soal/noimg.jpeg" alt="" width="40" height="40"/>';
        $file	='../../';
        $fl		=realpath($file).'\photo\soal\GBjwb4'.$kdesl.''.$id.'.jpg';
        if(file_exists($fl))
        {
			echo"
			<a href = 'javascript:void(0)'onclick = \"document.getElementById('j4').style.display='block';document.getElementById('fade5').style.display='block'\">
            <img src='../files/photo/soal/GBjwb4".$kdesl."".$id.".jpg' alt='' width='40' height='40'></a>
            <div id='j4'class='white_content' '><a href = 'javascript:void(0)' onclick = \"document.getElementById('j4').style.display='none';document.getElementById('fade5').style.display='none'\">
				<img src='../files/photo/soal/GBjwb4".$kdesl."".$id.".jpg' alt='' class='resize'></a>
			</div>
			<a href = 'javascript:void(0)' onclick=\"document.getElementById('j4').style.display='none';document.getElementById('fade5').style.display='none'\"> <div id='fade5' class='black_overlay'></div></a>";
		}
		echo"
	</TD>
</TR>
<TR><TD><center><p style='font-size:18px'><b>E</b></p></center></TD>
	<TD><textarea 	NAME		='jwb5'
					ID			='jwb5'
					TYPE		='text'
					CLASS		='textarea_02'
					$isian>$jwb5</textarea>";
		$gb3	='<img src="../files/photo/soal/GBjwb5'.$kdesl.''.$id.'.jpg" alt="NO IMG" width="40" height="40"/>';
        $gb4	='<img src="../files/photo/soal/noimg.jpeg" alt="" width="40" height="40"/>';
        $file	='../../';
        $fl		=realpath($file).'\photo\soal\GBjwb5'.$kdesl.''.$id.'.jpg';
        if(file_exists($fl))
        {
			echo"
			<a href = 'javascript:void(0)'onclick = \"document.getElementById('j5').style.display='block';document.getElementById('fade6').style.display='block'\">
            <img src='../files/photo/soal/GBjwb5".$kdesl."".$id.".jpg' alt='' width='40' height='40'></a>
            <div id='j5'class='white_content' '><a href = 'javascript:void(0)' onclick = \"document.getElementById('j5').style.display='none';document.getElementById('fade6').style.display='none'\">
				<img src='../files/photo/soal/GBjwb5".$kdesl."".$id.".jpg' alt='' class='resize'></a>
			</div>
			<a href = 'javascript:void(0)' onclick=\"document.getElementById('j5').style.display='none';document.getElementById('fade6').style.display='none'\"> <div id='fade6' class='black_overlay'></div></a>";
		}
		echo"
	</TD>
</TR>
<TR><TD><center><b>Jawaban</b></center></TD>
	<TD><INPUT 	NAME		='sttjwb'
				ID	        ='sttjwb'
				TYPE	    ='text'
				SIZE	    ='3'
				MAXLENGTH  	='2'
				VALUE		='$sttjwb'
                onkeyup		='uppercase(this.id)'
				CLASS		='required'
				TITLE		='...harus diisi'
				$isian>
		<INPUT TYPE='hidden' 	name='kdegbr' 	id='kdegbr' 	VALUE='$kdesl$id'>
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
		var jwb1 = $('#jwb1').val();
		var jwb2 = $('#jwb2').val();
		var jwb3 = $('#jwb3').val();
		var jwb4 = $('#jwb4').val();
		var jwb5 = $('#jwb5').val();
		var sttjwb = $('#sttjwb').val();
		var kdegbr = $('#kdegbr').val();
		var dataString ='kdercu='+ kdercu + '&soal=' + soal+ '&jwb1=' + jwb1+ '&jwb2=' + jwb2+ '&jwb3=' + jwb3+ '&jwb4=' + jwb4+ '&jwb5=' + jwb5+ '&sttjwb=' + sttjwb+ '&kdegbr=' + kdegbr ;

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
		if(jwb1=='')
		{ 	
			alert('Pilihan A tidak boleh kosong');
			document.f1.jwb1.focus();
		}
		else
		if(jwb2=='')
		{ 
			alert('Pilihan B tidak boleh kosong');
			document.f1.jwb2.focus();
		}
		else
		if(jwb3=='')
		{ 
			alert('Pilihan C tidak boleh kosong');
			document.f1.jwb3.focus();
		}
		else
		if(jwb4=='')
		{ 
			alert('Pilihan D tidak boleh kosong');
			document.f1.jwb4.focus();
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