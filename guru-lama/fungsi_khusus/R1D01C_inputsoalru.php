<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
//require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
//require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';

//$isian='readonly';
$isian	='disabled';
$kdercu	=$_GET['kdercu'];
$id1	=$_GET['id'];
$query 	="	SELECT 	g_dtlrcu.*
			FROM 	g_dtlrcu
			WHERE 	g_dtlrcu.id='". mysql_escape_string($id1)."'";
$result =mysql_query($query);
while($data =mysql_fetch_array($result))
{
	$id		=$data['id'];
	$soal	=$data['soal'];
	$jwb1	=$data['jwb1'];
	$jwb2	=$data['jwb2'];
	$jwb3	=$data['jwb3'];
	$jwb4	=$data['jwb4'];
	$jwb5	=$data['jwb5'];
	$sttjwb	=$data['sttjwb'];
	$kdegbr	=$data['kdegbr'];

	echo"
	<TR><TD WIDTH='10%' VALIGN='top'><center><b>Soal</b></center></TD>
		<TD width='90%' valign='top'>
			<textarea 	NAME		='soal'
						ID			='soal'
						CLASS		='textarea_01'
						$isian>$soal</textarea>";
			$gb3	='<img src="../files/photo/soal/GBsoal'.$kdegbr.'.jpg" alt="NO IMG" width="40" height="40"/>';
			$gb4	='<img src="../files/photo/soal/noimg.jpeg" alt="" width="40" height="40"/>';
			$file	='../../';
			$fl		=realpath($file).'\photo\soal\GBsoal'.$kdegbr.'.jpg';
			if(file_exists($fl))
			{
				echo"
				<a href = 'javascript:void(0)'onclick = \"document.getElementById('s1').style.display='block';document.getElementById('fade1').style.display='block'\">
				<img src='../files/photo/soal/GBsoal".$kdegbr.".jpg' alt='' width='40' height='40'></a>
				<div id='s1'class='white_content' '><a href = 'javascript:void(0)' onclick = \"document.getElementById('s1').style.display='none';document.getElementById('fade1').style.display='none'\">
					<img src='../files/photo/soal/GBsoal".$kdegbr.".jpg' alt='' class='resize'></a>
				</div>
				<a href = 'javascript:void(0)' onclick=\"document.getElementById('s1').style.display='none';document.getElementById('fade1').style.display='none'\"> <div id='fade1' class='black_overlay'></div></a>";
			}
		echo"
		</TD>
	</TR>
	<TR><TD><center><p style='font-size:18px'><b>A</b></p></center></TD>
		<TD><textarea 	NAME		='jwb1'
						ID	        ='jwb1'
						TYPE	    ='text'
						CLASS		='textarea_02'
						$isian>$jwb1</textarea>";
			$gb3	='<img src="../files/photo/soal/GBjwb1'.$kdegbr.'.jpg" alt="NO IMG" width="40" height="40"/>';
			$gb4	='<img src="../files/photo/soal/noimg.jpeg" alt="" width="40" height="40"/>';
			$file	='../../';
			$fl		=realpath($file).'\photo\soal\GBjwb1'.$kdegbr.'.jpg';
			if(file_exists($fl))
			{
				echo"
				<a href = 'javascript:void(0)'onclick = \"document.getElementById('j1').style.display='block';document.getElementById('fade2').style.display='block'\">
				<img src='../files/photo/soal/GBjwb1".$kdegbr.".jpg' alt='' width='40' height='40'></a>
				<div id='j1'class='white_content' '><a href = 'javascript:void(0)' onclick = \"document.getElementById('j1').style.display='none';document.getElementById('fade2').style.display='none' \">
					<img src='../files/photo/soal/GBjwb1".$kdegbr.".jpg' alt=''class='resize'></a>
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
			$gb3	='<img src="../files/photo/soal/GBjwb2'.$kdegbr.'.jpg" alt="NO IMG" width="40" height="40"/>';
			$gb4	='<img src="../files/photo/soal/noimg.jpeg" alt="" width="40" height="40"/>';
			$file	='../../';
			$fl		=realpath($file).'\photo\soal\GBjwb2'.$kdegbr.'.jpg';
			if(file_exists($fl))
			{
				echo"
				<a href = 'javascript:void(0)'onclick = \"document.getElementById('j2').style.display='block';document.getElementById('fade3').style.display='block'\">
				<img src='../files/photo/soal/GBjwb2".$kdegbr.".jpg' alt='' width='40' height='40'></a>
				<div id='j2'class='white_content' '><a href = 'javascript:void(0)' onclick = \"document.getElementById('j2').style.display='none';document.getElementById('fade3').style.display='none'\">
					<img src='../files/photo/soal/GBjwb2".$kdegbr.".jpg' alt='' class='resize'></a>
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
			$gb3	='<img src="../files/photo/soal/GBjwb3'.$kdegbr.'.jpg" alt="NO IMG" width="40" height="40"/>';
			$gb4	='<img src="../files/photo/soal/noimg.jpeg" alt="" width="40" height="40"/>';
			$file	='../../';
			$fl		=realpath($file).'\photo\soal\GBjwb3'.$kdegbr.'.jpg';
			if(file_exists($fl))
			{
				echo"
				<a href = 'javascript:void(0)'onclick = \"document.getElementById('j3').style.display='block';document.getElementById('fade4').style.display='block'\">
				<img src='../files/photo/soal/GBjwb3".$kdegbr.".jpg' alt='' width='40' height='40'></a>
				<div id='j3'class='white_content' '><a href = 'javascript:void(0)' onclick = \"document.getElementById('j3').style.display='none';document.getElementById('fade4').style.display='none'\">
					<img src='../files/photo/soal/GBjwb3".$kdegbr.".jpg' alt='' class='resize'></a>
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
			$gb3	='<img src="../files/photo/soal/GBjwb4'.$kdegbr.'.jpg" alt="NO IMG" width="40" height="40"/>';
			$gb4	='<img src="../files/photo/soal/noimg.jpeg" alt="" width="40" height="40"/>';
			$file	='../../';
			$fl		=realpath($file).'\photo\soal\GBjwb4'.$kdegbr.'.jpg';
			if(file_exists($fl))
			{
				echo"
				<a href = 'javascript:void(0)'onclick = \"document.getElementById('j4').style.display='block';document.getElementById('fade5').style.display='block'\">
				<img src='../files/photo/soal/GBjwb4".$kdegbr.".jpg' alt='' width='40' height='40'></a>
				<div id='j4'class='white_content' '><a href = 'javascript:void(0)' onclick = \"document.getElementById('j4').style.display='none';document.getElementById('fade5').style.display='none'\">
					<img src='../files/photo/soal/GBjwb4".$kdegbr.".jpg' alt='' class='resize'></a>
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
			$gb3	='<img src="../files/photo/soal/'.$kdegbr.'.jpg" alt="NO IMG" width="40" height="40"/>';
			$gb4	='<img src="../files/photo/soal/noimg.jpeg" alt="" width="40" height="40"/>';
			$file	='../../';
			$fl		=realpath($file).'\photo\soal\GBjwb5'.$kdegbr.'.jpg';
			if(file_exists($fl))
			{
				echo"
				<a href = 'javascript:void(0)'onclick = \"document.getElementById('j5').style.display='block';document.getElementById('fade6').style.display='block'\">
				<img src='../files/photo/soal/GBjwb5".$kdegbr.".jpg' alt='' width='40' height='40'></a>
				<div id='j5'class='white_content' '><a href = 'javascript:void(0)' onclick = \"document.getElementById('j5').style.display='none';document.getElementById('fade6').style.display='none'\">
					<img src='../files/photo/soal/GBjwb5".$kdegbr.".jpg' alt='' class='resize'></a>
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
					MAXLENGTH   ='2'
					VALUE		='$sttjwb'
					onkeyup		='uppercase(this.id)'
					CLASS		='required'
					TITLE		='...harus diisi'
					$isian>";
		echo"
		</TD>
	</TR>
	<LINK 	href='../css/lightbox2.css' 	rel='stylesheet' TYPE='text/css'>";
}
?>