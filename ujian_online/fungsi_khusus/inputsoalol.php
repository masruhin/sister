<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'sister_buatnomor.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
$nis	=$_GET[nis];
$isian	='readonly';
$rcu	=$_GET['kdeoln'];
$kdercu	=$_GET['kdercu'];
$id1	=$_GET['id'];

$query 	="	SELECT 	u_dtloln.*
			FROM 	u_dtloln
			WHERE 	u_dtloln.id='". mysql_escape_string($id1)."'";
$result =mysql_query($query);
$data 	=mysql_fetch_array($result);

$id		=$data['id'];
$soal	=$data['soal'];
$jwb1	=$data['jwb1'];
$jwb2	=$data['jwb2'];
$jwb3	=$data['jwb3'];
$jwb4	=$data['jwb4'];
$jwb5	=$data['jwb5'];
$sttjwb1=$data['sttjwb1'];
$kdeoln	=$data['kdeoln'];
$kdegbr	=$data['kdegbr'];

$query ="	SELECT 		u_dtloln.*
			FROM  		u_dtloln
			WHERE 		u_dtloln.kdeoln='$kdeoln'
            ORDER BY 	u_dtloln.id";
$result= mysql_query($query)	or die (mysql_error());

echo"
<TR>
	<TD WIDTH='10%' VALIGN='top'>
		<FORM  id='validasi'>
			<div style='overflow:scroll;width:100%;height:350;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' >
					<TR bgcolor='dedede'>
						<TD WIDTH='30%' HEIGHT='20'><CENTER>No		</CENTER></TD>
						<TD WIDTH='70%'><CENTER>Baca Soal</CENTER></TD>
					</TR>";
					$no=0;
					while($data1 =mysql_fetch_array($result))
					{
						$soal1 	=$data1['soal'];
						$sttjwb2=$data1['sttjwb1'];
						$no++;
						echo"
						<TR onMouseOver=\"this.classname='highlight'\" onMouseOut=\"this.classname='normal'\">
							<TD><CENTER>$no	</CENTER></TD>
							<TD><CENTER>";
								if($sttjwb2!='')
								{
									echo"<a href='#' id='$data1[id]'  onclick='openWindow();'class='det'><IMG src='../images/edit_d.gif' BORDER='0'></a></CENTER>";
								}
								else
								{
									echo"<a href='#' id='$data1[id]'  onclick='openWindow();'class='det'><IMG src='../images/edit_e.gif' BORDER='0'></a></CENTER>";
								}
							echo"
							</CENTER></TD>
						</TR>";
					}
				echo"
				</TABLE>
			</DIV><BR>
			<CENTER><INPUT TYPE='button' VALUE='Selesai' onClick=\"popup('popUpDiv')\"></CENTER>
		</FORM>
	</TD>		
	<TD WIDTH=' 5%'></TD>
	<TD WIDTH='40%' VALIGN='top' align='left'><b>SOAL</b>";
		$gb3	='<img src="../files/photo/soal/GBsoal'.$kdegbr.'.jpg" alt="NO IMG" width="50" height="30"/>';
        $gb4	='<img src="../files/photo/soal/noimg.jpeg" alt="" width="50" height="30"/>';
        $file	='../../';
        $fl		=realpath($file).'\photo\soal\GBsoal'.$kdegbr.'.jpg';
        if(file_exists($fl))
        {
			echo"
			<a href = 'javascript:void(0)'onclick = \"document.getElementById('s1').style.display='block';document.getElementById('fade1').style.display='block'\">
            <b>( Lihat Gambar Soal )</b></a>
            <div id='s1' class='white_content' '>
				<a href = 'javascript:void(0)' onclick = \"document.getElementById('s1').style.display='none';document.getElementById('fade1').style.display='none'\">
				<img src='../files/photo/soal/GBsoal".$kdegbr.".jpg' alt='' class='resize'></a>
			</div>
			<a href = 'javascript:void(0)' onclick=\"document.getElementById('s1').style.display='none';document.getElementById('fade1').style.display='none'\"> <div id='fade1' class='black_overlay'></div></a>";
		}
		echo"
		<BR>
		<input type='hidden' name='sttjwb' id='sttjwb' value='$sttjwb'>
		<input type='hidden' name='kdeoln' id='kdeoln' value='$kdeoln'>
		<TEXTAREA	ROWS	='17'
					COLS    ='50'
					$isian>$soal</TEXTAREA>
    </TD>
	<TD WIDTH=' 5%'></TD>
	<TD WIDTH='40%'  VALIGN='top'><b>PILIHAN JAWABAN</b>
		<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%'>
			<TR>
				<TD WIDTH='10%' VALIGN='center'><input type='hidden' name='id' id='id' value='$id'>
					<input 	type	='radio'
							name	='stsj'
							value	='A'
							onClick='stsc(this.form)'";if($sttjwb1=='A')echo"checked";echo">A
				</TD>
				<TD WIDTH='80%'>
					<TEXTAREA	ROWS	='2'
								COLS   	='50'
								$isian>$jwb1</TEXTAREA>
				</TD>
				<TD WIDTH='10%' VALIGN='center' align='left'>";
					$gb3	='<img src="../files/photo/soal/GBjwb1'.$kdegbr.'.jpg" alt="NO IMG" width="50" height="30"/>';
					$gb4	='<img src="../files/photo/soal/noimg.jpeg" alt="" width="50" height="30"/>';
					$file	='../../';
					$fl		=realpath($file).'\photo\soal\GBjwb1'.$kdegbr.'.jpg';
					if(file_exists($fl))
					{
						echo"
						<a href = 'javascript:void(0)'onclick = \"document.getElementById('j1').style.display='block';document.getElementById('fade2').style.display='block'\">
						<b>Gbr A</b></a>
						<div id='j1' class='white_content'>
							<a href = 'javascript:void(0)' onclick = \"document.getElementById('j1').style.display='none';document.getElementById('fade2').style.display='none' \">
							<img src='../files/photo/soal/GBjwb1".$kdegbr.".jpg' alt=''class='resize'></a>
						</div>
						<a href = 'javascript:void(0)' onclick=\"document.getElementById('j1').style.display='none';document.getElementById('fade2').style.display='none'\"> <div id='fade2' class='black_overlay'></div></a>";
					}
					else
					{
						echo"";
					}
					echo"
				</TD>
			</TR>
            <TR>
				<TD  VALIGN='center'>
					<input 	type	='radio'
							name	='stsj'
							value	='B'
							onClick	='stsc(this.form)'";if($sttjwb1=='B')echo"checked";echo">B
				</TD>
				<TD>
					<TEXTAREA	ROWS	='2'
								COLS   	='50'
								$isian>$jwb2</TEXTAREA>
				</TD>
				<TD VALIGN='center'>";
					$gb3	='<img src="../files/photo/soal/GBjwb2'.$kdegbr.'.jpg" alt="NO IMG" width="50" height="30"/>';
					$gb4	='<img src="../files/photo/soal/noimg.jpeg" alt="" width="50" height="30"/>';
					$file	='../../';
					$fl		=realpath($file).'\photo\soal\GBjwb2'.$kdegbr.'.jpg';
					if(file_exists($fl))
					{
						echo"
						<a href = 'javascript:void(0)'onclick = \"document.getElementById('j2').style.display='block';document.getElementById('fade3').style.display='block'\">
						<b>Gbr B</b></a>
						<div id='j2'class='white_content' '><a href = 'javascript:void(0)' onclick = \"document.getElementById('j2').style.display='none';document.getElementById('fade3').style.display='none'\">
							<img src='../files/photo/soal/GBjwb2".$kdegbr.".jpg' alt='' class='resize'></a>
						</div>
						<a href = 'javascript:void(0)' onclick=\"document.getElementById('j2').style.display='none';document.getElementById('fade3').style.display='none'\"> <div id='fade3' class='black_overlay'></div></a>";
					}
					else
					{
						echo"";
					}
				echo"
				</TD>
			</TR>
			<TR>
				<TD VALIGN='center'>
					<input 	type	='radio'
							name	='stsj'
							value	='C'
                            onClick	='stsc(this.form)'";if($sttjwb1=='C')echo"checked";echo">C
				</TD>
				<TD>
					<TEXTAREA	ROWS	='2'
								COLS   	='50'
								$isian>$jwb3</TEXTAREA>
				</TD>
				<TD VALIGN='center'>";
					$gb3	='<img src="../files/photo/soal/GBjwb3'.$kdegbr.'.jpg" alt="NO IMG" width="50" height="30"/>';
                    $gb4	='<img src="../files/photo/soal/noimg.jpeg" alt="" width="50" height="30"/>';
                    $file	='../../';
                    $fl		=realpath($file).'\photo\soal\GBjwb3'.$kdegbr.'.jpg';
                    if(file_exists($fl))
                    {
						echo"
						<a href = 'javascript:void(0)'onclick = \"document.getElementById('j3').style.display='block';document.getElementById('fade4').style.display='block'\">
						<b>Gbr C</b></a>
						<div id='j3'class='white_content' '><a href = 'javascript:void(0)' onclick = \"document.getElementById('j3').style.display='none';document.getElementById('fade4').style.display='none'\">
							<img src='../files/photo/soal/GBjwb3".$kdegbr.".jpg' alt='' class='resize'></a>
						</div>
						<a href = 'javascript:void(0)' onclick=\"document.getElementById('j3').style.display='none';document.getElementById('fade4').style.display='none'\"> <div id='fade4' class='black_overlay'></div></a>";
					}
                    else
                    {
						echo"";
					}
				echo"
				</TD>
			</TR>
			
			<TR>
				<TD VALIGN='center'>
					<input 	type	='radio'
							name	='stsj'
							value	='D'
							onClick	='stsc(this.form)'";if($sttjwb1=='D')echo"checked";echo">D
				</TD>
				<TD>
					<TEXTAREA	ROWS	='2'
								COLS   	='50'
								$isian>$jwb4</TEXTAREA>
				</TD>
				<TD VALIGN='center'>";
					$gb3	='<img src="../files/photo/soal/GBjwb4'.$kdegbr.'.jpg" alt="NO IMG" width="50" height="30"/>';
                    $gb4	='<img src="../files/photo/soal/noimg.jpeg" alt="" width="50" height="30"/>';
                    $file	='../../';
                    $fl		=realpath($file).'\photo\soal\GBjwb4'.$kdegbr.'.jpg';
					if(file_exists($fl))
					{
						echo"
						<a href = 'javascript:void(0)'onclick = \"document.getElementById('j4').style.display='block';document.getElementById('fade5').style.display='block'\">
						<b>Gbr D</b></a>
						<div id='j4'class='white_content' '><a href = 'javascript:void(0)' onclick = \"document.getElementById('j4').style.display='none';document.getElementById('fade5').style.display='none'\">
							<img src='../files/photo/soal/GBjwb4".$kdegbr.".jpg' alt=''></a>
						</div>
						<a href = 'javascript:void(0)' onclick=\"document.getElementById('j4').style.display='none';document.getElementById('fade5').style.display='none'\"> <div id='fade5' class='black_overlay'></div></a>";
					}
					else
					{
						echo"";
					}
					echo"
				</TD>
			</TR>
			<TR>
				<TD VALIGN='center'>
					<input 	type		='radio'
							name		='stsj'
							value		='E'
							onClick		='stsc(this.form)'";if($sttjwb1=='E')echo"checked";echo">E
				</TD>
				<TD>
					<TEXTAREA	ROWS	='2'
								COLS   	='50'
								$isian>$jwb5</TEXTAREA>
				</TD>
				<TD VALIGN='center'>";
					$gb3	='<img src="../files/photo/soal/GBjwb5'.$kdegbr.'.jpg" alt="NO IMG" width="50" height="30"/>';
                    $gb4	='<img src="../files/photo/soal/noimg.jpeg" alt="" width="50" height="30"/>';
                    $file	='../../';
                    $fl		=realpath($file).'\photo\soal\GBjwb5'.$kdegbr.'.jpg';
					if(file_exists($fl))
					{
						echo"
						<a href = 'javascript:void(0)'onclick = \"document.getElementById('j5').style.display='block';document.getElementById('fade6').style.display='block'\">
						<b>Gbr E</b></a>
						<div id='j5'class='white_content' '><a href = 'javascript:void(0)' onclick = \"document.getElementById('j5').style.display='none';document.getElementById('fade6').style.display='none'\">
							<img src='../files/photo/soal/GBjwb5".$kdegbr.".jpg' alt='' class='resize'></a>
						</div>
						<a href = 'javascript:void(0)' onclick=\"document.getElementById('j5').style.display='none';document.getElementById('fade6').style.display='none'\"> <div id='fade6' class='black_overlay'></div></a>";
					}
					else
					{
						echo"";
					}
				echo"
				</TD>
			</TR>
			<TR></TR>
			<TR><TD></TD>
				<TD align='left'>
					<INPUT TYPE='submit' VALUE='Save' id='save'>
				</TD>
			</TR>
		</TABLE>
	</TD>
</TR>";

$query 	="	SELECT 		*,g_gnrrcu.kdercu,g_dtlrcu.kdercu
			FROM 		u_gnroln,u_dtloln,g_gnrrcu,g_dtlrcu
			WHERE 		u_gnroln.kdeoln	='$kdeoln'	AND
						u_gnroln.kdeoln	=u_dtloln.kdeoln AND
						u_gnroln.kdercu	=g_gnrrcu.kdercu AND
						u_gnroln.kdercu	=g_dtlrcu.kdercu AND
						g_gnrrcu.kdercu	=g_dtlrcu.kdercu AND
						u_dtloln.soal	=g_dtlrcu.soal
			ORDER BY u_gnroln.kdeoln";
$result	= mysql_query($query)	or die (mysql_error());
$jw		='0';
while($data =mysql_fetch_array($result))
{
	$soal   =$data[soal];
	$sttjwb	=$data[sttjwb];
	$sttjwb1=$data[sttjwb1];
	$kdercu	=$data[kdercu];
	$kdeoln	=$data[kdeoln];

	if($sttjwb==$sttjwb1)
	{
		$jwb='1';
	}
	else
	{
		$jwb='0';
	}
	$jw +=$jwb;
}
$que	="	SELECT 
			COUNT(*)as soal 
			FROM 	u_dtloln 
			WHERE 	u_dtloln.kdeoln='$kdeoln'";
$sl		=mysql_query($que);
$kl		=mysql_fetch_assoc($sl);
$j		=$kl['soal'];

$nilai=round($jw / $j * '100');

echo"
<TD width='10%' align='center'>
	<input type='hidden' name='nli'id='nli' value='$nilai'>
	<div id='blanket' style='display:none;'></div>
		<div id='popUpDiv' style='display:none;'><center><h2>NILAI ANDA</h2></center>
			<center><h1><b>$nilai</b></h1></center>
			<center>
				<div id='sls'><input type='button' value='Selesai' id='nilai'onClick=\"popup('popUpDiv');window.location.href= '../ujian_online/fungsi_khusus/savenilai.php?&kdeoln=$kdeoln&nli=$nilai';\"></div>
			</center>
		</div>
	</div>	
</TD>
<LINK 	href='../css/lightbox2.css' 	rel='stylesheet' TYPE='text/css'>
<SCRIPT TYPE='text/javascript'>
$(function() 
{
	//save hasil jawaban
	$('#save').click(function() 
	{
		var id = $('#id').val();
		var kdeoln = $('#kdeoln').val();
		var sttjwb = $('#sttjwb').val();
		var dataString ='kdeoln='+ kdeoln + '&id=' + id+'&sttjwb='+ sttjwb ;

		if(sttjwb=='')
		{ 
			alert('Anda Belum Menjawab');
			document.f1.sttjwb.focus();
		}
		else
		{
			$.ajax(
			{
				type: 'POST',
				url: '../ujian_online/fungsi_khusus/saveol.php',
				data: dataString,
				success: function()
				{
					$('#uol').load('../ujian_online/fungsi_khusus/inputsoalol.php?id='+id);
					$('.error').fadeOut(200).hide();
				}
			});
		}
		return false;
	});

	$('#nilai').click(function() 
	{
		var kdeoln = $('#kdeoln').val();
		var dataString ='kdeoln='+ kdeoln;

		if(sttjwb=='')
		{ 
			alert('Anda Belum Menjawab');
			document.f1.sttjwb.focus();
		}
		else
		{
			$.ajax(
			{
				type: 'POST',
				url: '../ujian_online/fungsi_khusus/savenilai.php',
				data: dataString,
				success: function()
				{
					$('.error').fadeOut(200).hide();
				}
			});
		}
		return false;
	});

	//ambil detail pada ujian Online (UJO01)//
	$('.det').click(function() 
	{
		var element = $(this);
		var id = element.attr('id');
		var kdeoln = $('#kdeoln').val();
		var dataString = 'id=' + id;

		$.ajax(
		{
			type: 'GET',
			url: '../ujian_online/fungsi_khusus/inputsoalol.php',
			data: dataString,
			success: function()
			{
				$('#uol').load('../ujian_online/fungsi_khusus/inputsoalol.php?id='+id);
			}
		})
	});
});
</script>

<SCRIPT TYPE='text/javascript' src='../../js/jquery-mins.js'></SCRIPT>
<SCRIPT TYPE='text/javascript' src='../js/css.js'></SCRIPT>
<SCRIPT LANGUAGE='JavaScript'>
function stsc(form) 
{
	for (var i = 0; i < form.stsj.length; i++) 
	{
		if (form.stsj[i].checked) 
		{
			break
		}
	}
	var er=form.stsj[i].value;
	document.getElementById('sttjwb').value=er;
}
</SCRIPT>
<style type='text/css'>
<!--
#blanket 
{
	background-color:#111;
	opacity: 0.65;
	position:absolute;

	z-index: 9001; /*ooveeerrrr nine thoussaaaannnd*/
	left:0px;
	width:100%;
}

#popUpDiv 
{
	position:absolute;
	background-color:#eeeeee;
	width:300px;
	height:250px;
	z-index: 9002; /*ooveeerrrr nine thoussaaaannnd*/
}
h1 
{
	font-size:950%;
	top:-50px;
	position:relative;
	text-align:center;
}
h2 
{
	font-size200%;
}

#sls 
{
	top:220px;
	left:110px;
	position:absolute;
}
-->
</style>";
?>