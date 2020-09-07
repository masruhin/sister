<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D03A.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi MATERI PELAJARAN
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D03Aclass
{
	// -------------------------------------------------- Item --------------------------------------------------
	function R1D03A()
	{
		require_once '../fungsi_umum/sysconfig.php';

		// deklarasi java
		echo"
		<LINK 	href='../css/val.css' 		rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 		src='../js/jquery-validate.js'></SCRIPT>";
		
		echo"<SCRIPT TYPE='text/javascript' 		src='../guru/js/R1D03A.js'></SCRIPT>";
		
		$nis	=$_SESSION["Admin"]["nis"];
        $kdekry	=$_SESSION["Admin"]["kdekry"];
		echo"
		<FORM METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>MATERI PELAJARAN</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Kelas</TD>
                    <TD WIDTH='85%'>:
							<SELECT NAME	='kdeklm'
									ID		='kdeklm'
									class	='kdeklm'
									value='$kdeklm'
									$isian1>
							<OPTION VALUE='' SELECTED>--Pilih--</OPTION>";
							$query2="	SELECT 	 	DISTINCT t_klmkls.kdeklm
										FROM 	   t_klmkls,t_prstkt
                                        WHERE t_prstkt.kdekry='". mysql_escape_string($kdekry)."'AND
                                              t_prstkt.kdetkt=t_klmkls.kdetkt
                                              order by t_klmkls.kdeklm";
							$result2=mysql_query($query2);

							while($data=mysql_fetch_array($result2))
							{
								if($kdeklm==$data[kdeklm])
									echo"<OPTION VALUE='$data[kdeklm]' SELECTED>$data[kdeklm]</OPTION>";
								else
									echo"<OPTION VALUE='$data[kdeklm]'>$data[kdeklm]</OPTION>";
							}
                            echo"</SELECT><TR>

				</TR>
			</TABLE>	

			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR> <TD WIDTH='25%'>
						<div style='overflow:auto;width:100%;height:380px;padding-right:-2px;'>
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' >
								<TR bgcolor='dedede'>
									<TD WIDTH='10%' HEIGHT='20'><CENTER>No	</CENTER></TD>
									<TD WIDTH='50%'><CENTER>Pelajaran		</CENTER></TD>
									<TD WIDTH='20%'><CENTER>Silabus			</CENTER></TD>
									<TD WIDTH='20%'><CENTER>Materi			</CENTER></TD>

								</TR>
								<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='plj'>
								</TABLE>

						</DIV>
					</TD>
					<TD WIDTH='75%'>
						<DIV style='overflow:auto;width:100%;height:380px;padding-right:-2px;'>                
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='modul1'>
							</TABLE>
						</DIV>
					</TD>
				</TR>
			</TABLE>
		</FORM>";
	}
}//akhir class
?>