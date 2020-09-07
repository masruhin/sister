<?php
//----------------------------------------------------------------------------------------------------
//Program		: A6U03.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi SETING RAPORT PS-JHS-SHS
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class A6U03class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function A6U03()
	{
		echo"<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		
		$kdetkt	=$_GET['kdetkt'];
		$pilihan=$_GET['pilihan'];
		
		if($pilihan=='')
			$pilihan='detil';

		switch($pilihan)
		{
			case 'detil':
				$isian1	='disabled';
				$isian2	='disabled';
				break;
		}		

		$query 	="	SELECT 		t_setpsrpt.*
					FROM 		t_setpsrpt
					WHERE 		t_setpsrpt.kdetkt	='". mysql_escape_string($kdetkt)."'
					ORDER BY	t_setpsrpt.kdetkt,t_setpsrpt.id";
		$result =mysql_query($query);

		$i=0;
		while($data = mysql_fetch_array($result))
		{
			$cell[$i][0]=$data[kdetkt];
			$cell[$i][1]=$data[nmasbj];
			$i++;
		}

		echo"
		<FORM ACTION='administrator.php' METHOD='get' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN=3><B>SETING RAPORT PS-JHS-SHS</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Tingkat</TD>
					<TD>:
						<SELECT NAME		='kdetkt'
								ID			='kdetkt'
								ONKEYUP		='uppercase(this.id)'>";
						$query2="	SELECT 		t_msttkt.*
									FROM 		t_msttkt
									WHERE		t_msttkt.kdetkt='PS' OR t_msttkt.kdetkt='JHS' OR t_msttkt.kdetkt='SHS'
									ORDER BY 	t_msttkt.kdetkt";
						$result2=mysql_query($query2);
						echo"<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
						while($data=mysql_fetch_array($result2))
						{
							if ($kdetkt==$data[kdetkt])
								echo"<OPTION VALUE='$data[kdetkt]' SELECTED>$data[nmatkt]</OPTION>";
							else
								echo"<OPTION VALUE='$data[kdetkt]'>$data[nmatkt]</OPTION>";
						}
						echo"
						</SELECT>
						<INPUT TYPE='submit' 					VALUE='Tampilkan'>
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='A6U03'>
						<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
						
					</TD>	
              	</TR>				
				
			</TABLE>
		</FORM>
		
		<FORM ACTION='administrator.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<DIV style='overflow:auto;;width:54%;height:380px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH='50%'><CENTER>Subject	</CENTER></TD>
					</TR>";
					$j=0;
					$no=1;
					while($j<$i)
					{
						$nmasbj	='nmasbj'.$j;
						$nmasbjv=$cell[$j][1];
				
						echo"
						<TR>
							<TD>";
								if(substr($nmasbjv,0,1)=='/')
								{
									$nmasbjvx 	=str_replace("/","","$nmasbjv");
									echo"<CENTER><B>$nmasbjvx</B></CENTER>";
								}
								else
									echo"$nmasbjv";
							echo"
							</TD>
						</TR>";

						$j++;
						$no++;
					}		
				echo"	
				</TABLE>	
			</DIV>";
			if($kdetkt!='')
			{
				echo"
				<INPUT TYPE='button' 				VALUE='Cetak Progres Report' 	onClick=window.open('utility/A6U03_C01.php?kdetkt=$kdetkt')>";			
				echo"
				<INPUT TYPE='button' 				VALUE='Cetak Report' 	onClick=window.open('utility/A6U03_C02.php?kdetkt=$kdetkt')>";
			}	
		echo"
		</FORM>";
 	}
}//akhir class
?>