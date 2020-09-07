<?php
//----------------------------------------------------------------------------------------------------
//Program		: A6U04.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi SETING BEHAVIOUR PS-JHS-SHS
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class A6U04class
{
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function A6U04()
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

		if($kdetkt!='')
		{
			$query 	="	SELECT 		t_setpsbhv.*
						FROM 		t_setpsbhv
						ORDER BY	t_setpsbhv.id";
			$result =mysql_query($query);

			$i=0;
			while($data = mysql_fetch_array($result))
			{
				$cell[$i][0]=$data[indctring];
				$cell[$i][1]=$data[indctrind];
				$i++;
			}	
		}

		echo"
		<FORM ACTION='administrator.php' METHOD='get' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN=3><B>SETING BEHAVIOUR PS-JHS-SHS</B></TD></TR>
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
						<INPUT TYPE='hidden'	NAME='mode'		VALUE='A6U04'>
						<INPUT TYPE='hidden' 	NAME='pilihan'	VALUE='detil'>
						
					</TD>	
              	</TR>				
				
			</TABLE>
		</FORM>
		
		<FORM ACTION='administrator.php' METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<DIV style='overflow:auto;;width:100%;height:380px;padding-right:-2px;'>
				<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='0' WIDTH='100%'>
					<TR bgcolor='dedede'>
						<TD WIDTH='50%'><CENTER>Indicator (Inggris)	</CENTER></TD>
						<TD WIDTH='50%'><CENTER>Indicator (Indonesia)	</CENTER></TD>
					</TR>";
					$j=0;
					$no=1;
					while($j<$i)
					{
						$indctring	='indctring'.$j;
						$indctringv=$cell[$j][0];
						$indctrind	='indctrind'.$j;
						$indctrindv=$cell[$j][1];				
						echo"
						<TR>
							<TD>$indctringv</TD>
							<TD>$indctrindv</TD>
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
				<INPUT TYPE='button' 				VALUE='Cetak Behaviour' 	onClick=window.open('utility/A6U04_C01.php?kdetkt=$kdetkt')>";			
			}	
		echo"
		</FORM>";
 	}
}//akhir class
?>