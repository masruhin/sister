<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';

$path 	="../../files/photo/soal/";
$kdesl	=$_POST['kdesl'];
$id		=$_POST['id'];
$gambar	=$_POST['gambar'];
$valid_formats =array("jpg", "png", "gif", "bmp");

if($gambar=='soal')
{
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] =="POST")
	{
		$name =$_FILES['phtsoals']['name'];
		$size =$_FILES['phtsoals']['size'];

		if(strlen($name))
		{
			list($txt, $ext) =explode(".", $name);
			if(in_array($ext,$valid_formats))
			{
				if($size<(1024*1024))
				{
					$actual_image_name =time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
					$soal =$_FILES['phtsoals']['tmp_name'];
					if($soal=='')
					{
						$newsoal='';
						echo"<span class='preview'><b>kosong</b></span>";
					}
					else
					{
						$newsoal="../../files/photo/soal/GBsoal".$kdesl."".$id.".jpg";
						if(file_exists($newsoal))
							unlink($newsoal);
							copy($soal, "../../files/photo/soal/GBsoal".$kdesl."".$id.".jpg");
							echo"
							<span class='preview'><img src='../files/photo/soal/GBsoal".$kdesl."".$id.".jpg' width='40' height='40'></span>
                            <a href='guru.php?mode=R1D01B_HapusG&kdesl=$kdesl&id=$id&hapus=gsoal'onclick='return confirm(\"Benar gambar akan dihapus ?\");'>
												<img src='../images/delete-icon.png' width='15' height='15'  VALIGN='center'></a>";
					}
				}
			}
		}
	}
	exit;

}

if($gambar=='jwb1')
{
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] =="POST")
	{
		$name =$_FILES['phtjwb1']['name'];
		$size =$_FILES['phtjwb1']['size'];

		if(strlen($name))
		{
			list($txt, $ext) =explode(".", $name);
			if(in_array($ext,$valid_formats))
			{
				if($size<(1024*1024))
				{
					$actual_image_name =time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
					$jwb1 =$_FILES['phtjwb1']['tmp_name'];
					if($jwb1=='')
					{
						$newjwb1='';
						echo"<span class='preview'><b>kosongss</b></span>";
					}
					else
					{
						$newjwb1="../../files/photo/soal/GBjwb1".$kdesl."".$id.".jpg";
						if(file_exists($newjwb1))
							unlink($newjwb1);
							copy($jwb1, "../../files/photo/soal/GBjwb1".$kdesl."".$id.".jpg");
							echo"
							<a href='../files/photo/soal/GBjwb1".$kdesl."".$id.".jpg' target='_blank'><span class='preview'><img src='../files/photo/soal/GBjwb1".$kdesl."".$id.".jpg' width='40' height='40'></span></a>
                            <a href='guru.php?mode=R1D01B_HapusG&kdesl=$kdesl&id=$id&hapus=gjwb1'onclick='return confirm(\"Benar gambar akan dihapus ?\");'>
												<img src='../images/delete-icon.png' width='15' height='15'  VALIGN='center'></a>";
					}
				}
			}
		}
		exit;
	}
}

if($gambar=='jwb2')
{
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] =="POST")
	{
		$name =$_FILES['phtjwb2']['name'];
		$size =$_FILES['phtjwb2']['size'];
		if(strlen($name))
		{
			list($txt, $ext) =explode(".", $name);
			if(in_array($ext,$valid_formats))
			{
				if($size<(1024*1024))
				{
					$actual_image_name =time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
					$jwb2 =$_FILES['phtjwb2']['tmp_name'];
					if($jwb2=='')
					{
						$newjwb2='';
						echo"<span class='preview'><b>kosongss</b></span>";
					}
					else
					{
						$newjwb2="../../files/photo/soal/GBjwb2".$kdesl."".$id.".jpg";
						if(file_exists($newjwb2))
							unlink($newjwb2);
							copy($jwb2, "../../files/photo/soal/GBjwb2".$kdesl."".$id.".jpg");
							echo"
							<a href='../files/photo/soal/GBjwb2".$kdesl."".$id.".jpg' target='_blank'><span class='preview'><img src='../files/photo/soal/GBjwb2".$kdesl."".$id.".jpg' width='40' height='40'></span></a>
                            <a href='guru.php?mode=R1D01B_HapusG&kdesl=$kdesl&id=$id&hapus=gjwb2'onclick='return confirm(\"Benar gambar akan dihapus ?\");'>
												<img src='../images/delete-icon.png' width='15' height='15'  VALIGN='center'></a>";
					}
				}
			}
		}
		exit;
	}
}

if($gambar=='jwb3')
{
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] =="POST")
	{
		$name =$_FILES['phtjwb3']['name'];
		$size =$_FILES['phtjwb3']['size'];
		if(strlen($name))
		{
			list($txt, $ext) =explode(".", $name);
			if(in_array($ext,$valid_formats))
			{
				if($size<(1024*1024))
				{
					$actual_image_name =time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
					$jwb3 =$_FILES['phtjwb3']['tmp_name'];
					if($jwb3=='')
					{
						$newjwb3='';
						echo"<span class='preview'><b>kosongss</b></span>";
					}
					else
					{
						$newjwb3="../../files/photo/soal/GBjwb3".$kdesl."".$id.".jpg";
						if(file_exists($newjwb3))
							unlink($newjwb3);
							copy($jwb3, "../../files/photo/soal/GBjwb3".$kdesl."".$id.".jpg");
							echo"
							<a href='../files/photo/soal/GBjwb3".$kdesl."".$id.".jpg' target='_blank><span class='preview'><img src='../files/photo/soal/GBjwb3".$kdesl."".$id.".jpg' width='40' height='40'></span></a>
                            <a href='guru.php?mode=R1D01B_HapusG&kdesl=$kdesl&id=$id&hapus=gjwb3'onclick='return confirm(\"Benar gambar akan dihapus ?\");'>
												<img src='../images/delete-icon.png' width='15' height='15'  VALIGN='center'></a>";
					}
				}
			}
		}
		exit;
	}
}

if($gambar=='jwb4')
{
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] =="POST")
	{
		$name =$_FILES['phtjwb4']['name'];
		$size =$_FILES['phtjwb4']['size'];
		if(strlen($name))
		{
			list($txt, $ext) =explode(".", $name);
			if(in_array($ext,$valid_formats))
			{
				if($size<(1024*1024))
				{
					$actual_image_name =time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
					$jwb4 =$_FILES['phtjwb4']['tmp_name'];
					if($jwb4=='')
					{
						$newjwb4='';
						echo"<span class='preview'><b>kosongss</b></span>";
					}
					else
					{
						$newjwb4="../../files/photo/soal/GBjwb4".$kdesl."".$id.".jpg";
						if(file_exists($newjwb4))
							unlink($newjwb4);
							copy($jwb4, "../../files/photo/soal/GBjwb4".$kdesl."".$id.".jpg");
							echo"
							<a href='../files/photo/soal/GBjwb4".$kdesl."".$id.".jpg' target='_blank><span class='preview'><img src='../files/photo/soal/GBjwb4".$kdesl."".$id.".jpg' width='40' height='40'></span></a>
                            <a href='guru.php?mode=R1D01B_HapusG&kdesl=$kdesl&id=$id&hapus=gjwb4'onclick='return confirm(\"Benar gambar akan dihapus ?\");'>
												<img src='../images/delete-icon.png' width='15' height='15'  VALIGN='center'></a>";
					}
				}
			}
		}
		exit;
	}
}

if($gambar=='jwb5')
{
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] =="POST")
	{
		$name =$_FILES['phtjwb5']['name'];
		$size =$_FILES['phtjwb5']['size'];
		if(strlen($name))
		{
			list($txt, $ext) =explode(".", $name);
			if(in_array($ext,$valid_formats))
			{
				if($size<(1024*1024))
				{
					$actual_image_name =time().substr(str_replace(" ", "_", $txt), 5).".".$ext;
					$jwb5 =$_FILES['phtjwb5']['tmp_name'];
					if($jwb5=='')
					{
						$newjwb5='';
					}
					else
					{
						$newjwb5="../../files/photo/soal/GBjwb5".$kdesl."".$id.".jpg";
						if(file_exists($newjwb5))
							unlink($newjwb5);
							copy($jwb5, "../../files/photo/soal/GBjwb5".$kdesl."".$id.".jpg");
							echo"<a href='../files/photo/soal/GBjwb5".$kdesl."".$id.".jpg' target='_blank><span class='preview'><img src='../files/photo/soal/GBjwb5".$kdesl."".$id.".jpg' width='40' height='40'></span></a>
                            <a href='guru.php?mode=R1D01B_HapusG&kdesl=$kdesl&id=$id&hapus=gjwb5'onclick='return confirm(\"Benar gambar akan dihapus ?\");'>
												<img src='../images/delete-icon.png' width='15' height='15'  VALIGN='center'></a>";
					}
				}
			}
		}

		exit;
	}
}

?>