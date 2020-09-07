<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';
require_once FUNGSI_UMUM_DIR.'fungsi_admin1.php';
require_once FUNGSI_UMUM_DIR.'fungsi_bantuan.php';

$kdercu	=$_GET['kdercu'];
$query 	="	SELECT 	g_gnrrcu.*
			FROM 	g_gnrrcu
			WHERE 	g_gnrrcu.kdercu='". mysql_escape_string($kdercu)."'";
$result =mysql_query($query);
$data 	=mysql_fetch_array($result);

$kdercu1=$data['kdercu'];

$query1	=" 	SELECT 		g_dtlrcu.*
			FROM 		g_dtlrcu
			WHERE 		g_dtlrcu.kdercu='$kdercu'";

$result1 =mysql_query($query1);
$no=0;
while($data =mysql_fetch_array($result1))
{ 
	$soal =susun_kalimat($data['soal'], 80);
	$jwb1 =strip_tags(substr($data['jwb1'],0,13));
	$jwb2 =strip_tags(substr($data['jwb2'],0,13));
	$jwb3 =strip_tags(substr($data['jwb3'],0,13));
	$jwb4 =strip_tags(substr($data['jwb4'],0,13));
	$jwb5 =strip_tags(substr($data['jwb5'],0,13));

	$no++;
	echo"
	<TR onMouseOver=\"this.className='normal'\" onMouseOut=\"this.className='normal'\">
		<TD WIDTH=' 5%'><CENTER>$no			</CENTER></TD>
		<TD WIDTH='75%'>$soal[0]...</TD>
		<TD WIDTH='10%'><CENTER><a href='#' id='$data[id]' class='more'>
							   	<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER></TD>
		<TD WIDTH='10%'><CENTER><a href='#' id='$data[id]' class='hapusru'>
								<IMG src='../images/hapus_e.gif' BORDER='0'></a></CENTER></TD>
	</TR>";
}

echo"
<SCRIPT TYPE='text/javascript'>
$(function() 
{
	//submit untuk Pilih Semua
	//Hapus SOal R1D01C//
	$('.hapusru').click(function()
	{
		//Save the link in a variable called element
		var element = $(this);
		var soal 	= element.attr('id');
		var info 	= 'id=' + soal;
		var kdercu 	= $('#kdercu').val();
		if(confirm('Apakah anda ingin hapus data ini!'))
		{
			$.ajax(
			{
				type: 'GET',
				url: '../guru/fungsi_khusus/R1D01C_hapussoal.php',
				data: info,
				success: function()
				{
					$('#rcu').load('../guru/fungsi_khusus/R1D01C_soalru.php?kdercu='+kdercu);
                    $('#inputsoal').load('../guru/fungsi_khusus/R1D01C_inputsoal.php?kdercu='+kdercu);
					
				}
			});

			$(this).parents('.record').animate({ backgroundColor: '#fbc7c7' }, 'fast')
		}
		return false;
	});
});
</script>
<SCRIPT TYPE='text/javascript' src='../guru/js/R1D01C.js'></SCRIPT>
<SCRIPT TYPE='text/javascript' src='../js/jquery-mins.js'></SCRIPT>";
?>