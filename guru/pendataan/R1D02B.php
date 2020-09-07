<?php
//----------------------------------------------------------------------------------------------------
//Program		: S1D02.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi HASIL TEST
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D02Bclass
{
	// -------------------------------------------------- Item --------------------------------------------------
	function R1D02B()
	{
		require_once '../fungsi_umum/sysconfig.php';

		// deklarasi java
		echo"
		<LINK 	href='../css/val.css' 		rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 		src='../js/jquery-validate.js'></SCRIPT>
        <SCRIPT TYPE='text/javascript' 	src='../js/fungsi_input.js'></SCRIPT> ";

		echo"<SCRIPT TYPE='text/javascript' 		src='../guru/js/R1D02B.js'></SCRIPT>";
		
		//$user	=$_SESSION["Admin"]["nis"];
        $kdekry	=$_SESSION["Admin"]["kdekry"];

         // untuk mendapatkan kode guru
        $query	="	SELECT	t_mstssw.*,t_mstpng.kdegru
					FROM 	t_mstssw,t_mstpng
					WHERE	t_mstssw.nis='$user' AND
							t_mstssw.kdekls=t_mstpng.kdekls";
		$result	=mysql_query($query);
        $data	=mysql_fetch_array($result);
        $kdegru	=$data['kdegru'];

		// akhir inisiasi parameter
		$query ="	SELECT 		g_dtlmtr.*
					FROM  		g_dtlmtr
					WHERE 		g_dtlmtr.kdemtr='". mysql_escape_string($kdemtr)."'
					ORDER BY	g_dtlmtr.id";
		$result= mysql_query($query)	or die (mysql_error());

		echo"
		<FORM METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>CLASS</B></TD></TR>
				<TR></TR><TR></TR>

			</TABLE>

			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR>
                    <TD WIDTH='25%' VALIGN='top'>
						<div style='overflow:auto;width:100%;height:400px;padding-right:-2px;'>
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' class='table02'>
								<TR bgcolor='dedede'>
									<TD WIDTH='10%' HEIGHT='20'><CENTER>No	</CENTER></TD>
									<TD WIDTH='30%'><CENTER>Class			</CENTER></TD>
									<TD WIDTH='20%'><CENTER>Schedule			</CENTER></TD>
									<TD WIDTH='20%'><CENTER>Subject			</CENTER></TD>
                                    <TD WIDTH='20%'><CENTER>Student				</CENTER></TD>

								</TR>";
                                $querykls="	SELECT *,t_mstkls.kdekls
										FROM 		t_prstkt,t_klmkls,t_mstkls
                                        WHERE      t_prstkt.kdekry='". mysql_escape_string($kdekry)."'AND
                                                   t_prstkt.kdetkt=t_klmkls.kdetkt AND
												   t_prstkt.kdejbt<400 AND									
                                                   t_klmkls.kdeklm=t_mstkls.kdeklm	
                                                   ORDER BY t_mstkls.kdeklm,t_mstkls.kdekls
										";
							$result2=mysql_query($querykls);
                            $no=0;
							while($data=mysql_fetch_array($result2))
							{ 
								$kdekls=$data[kdekls];
								$type='pdf';
								$filename  = './../files/jadwal/'.$kdekls.'/'.$kdekls.'.'.$type;
                              $no++;
                                echo"
								<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
									<TD><CENTER>$no 	</CENTER></TD>
									<TD><center>$kdekls</center></TD>";
									if (file_exists($filename)) 
									{
										echo"
										<TD><CENTER><a href=$filename target='_blank'><img src='../images/icon_pdf_e.gif'></a></CENTER></TD>";
									}
									else
									{
										echo"
										<TD><CENTER><img src='../images/icon_pdf_d.gif'></a></CENTER></TD>";
									}
									echo"
									<TD><CENTER>
										<a href='#'  id='$data[kdekls]' class='pelajaran'>
										<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
									</TD>
									<TD><CENTER>
										<a href='#' id='$data[kdekls]' class='siswa'>
										<IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
									</TD>
                             	</TR>";
                                }
                        echo"</TABLE>
                    	</DIV>

					<TD WIDTH='75%' VALIGN='top'>
						<div style='overflow:auto;width:100%;height:400px;padding-right:-2px;'>
                                <TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='pelajaran'> </table>
								<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='siswa'>

							</TABLE>
						</DIV>
					</TD>
				</TR>
			</TABLE>
		</FORM>";
	}
}//akhir class
?>