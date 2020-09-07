<?php
require_once '../../fungsi_umum/sysconfig.php';
require_once FUNGSI_UMUM_DIR.'koneksi.php';

$kdejtu=$_GET['kdejtu'];
$query =mysql_query("	SELECT 		*
						FROM 		t_jtu
						WHERE 		t_jtu.kdejtu='$kdejtu'");
$data	=mysql_fetch_array($query);
$sttbyr	=$data['sttbyr'];
if($sttbyr=='S')
				{
					echo"

							<INPUT 	NAME		='dr'
									TYPE		='text'
									SIZE		='50'
									MAXLENGTH	='50'
									VALUE		='$dr'
									id			='dr'
									onkeyup		='ajax_showOptions(this,\"suggest\",event);uppercase(this.id);'
									onkeypress	='return enter(this,event)'
									CLASS		='required'
									TITLE		='...harus diisi'
									$isian> <input type='hidden' name='nis' id='nis'class='nis'/>
					   ";
				}
				else
				{
					echo"

							<INPUT 	NAME		='dr'
									TYPE		='text'
									SIZE		='50'
									MAXLENGTH	='50'
									VALUE		='$dr'
									id			='dr'
									onkeyup		='uppercase(this.id)'
									onkeypress	='return enter(this,event)'
									CLASS		='required'
									TITLE		='...harus diisi'
									$isian2>
							";
				}

echo"<SCRIPT TYPE='text/javascript' src='../keuangan/js/K1D03.js'></SCRIPT>";
?>