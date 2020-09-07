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
class R1D02Cclass
{
	// -------------------------------------------------- Item --------------------------------------------------
	function R1D02C()
	{
		require_once '../fungsi_umum/sysconfig.php';

		// deklarasi java
		echo"
		<LINK 	href='../css/val.css' 		rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 		src='../js/jquery-validate.js'></SCRIPT>
        <SCRIPT TYPE='text/javascript' 	src='../js/fungsi_input.js'></SCRIPT> ";

		echo"<SCRIPT TYPE='text/javascript' 		src='../guru/js/R1D02C.js'></SCRIPT>";
		
		$user	=$_SESSION["Admin"]["nis"];
        $kdekry1	=$_SESSION["Admin"]["kdekry"];

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
				<TR><TD COLSPAN='2'><B>TEACHER</B></TD></TR>
				<TR></TR><TR></TR>

			</TABLE>

			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR>
                    <TD WIDTH='50%'>
						<div style='overflow:auto;width:100%;height:390px;padding-right:-2px;'>
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' class='table02'>
								<TR bgcolor='dedede'>
									<TD WIDTH=' 7%' HEIGHT='20'><CENTER>No	</CENTER></TD>
									<TD WIDTH='43%'><CENTER>Teacher		</CENTER></TD>
									
									<TD WIDTH='10%'><CENTER>Material				</CENTER></TD>
									<TD WIDTH='10%'><CENTER>Worksheet				</CENTER></TD>
                                    <TD WIDTH='10%'><CENTER>Att.				</CENTER></TD>
                                    <!--<TD WIDTH='10%'><CENTER>Activity				</CENTER></TD>-->
									<TD WIDTH='10%'><CENTER>Lesson Plan				</CENTER></TD>
									<!--<TD WIDTH='10%'><CENTER>BK				</CENTER></TD>-->
								</TR>";//Task
                                $querytkt="SELECT * FROM t_prstkt
                                       WHERE t_prstkt.kdekry='". mysql_escape_string($kdekry1)."'";
                                $res=mysql_query($querytkt);
								$kdejbt=1000;
								$kdetkt='';
                                while($da=mysql_fetch_array($res))
                                {
									if($da['kdejbt']<$kdejbt)
									{
										$kdejbt=$da['kdejbt'];
										$kdetkt=$da['kdetkt'];
									}	
                                 }
                                if($kdejbt=='000')
                                { 
									$querykls="	SELECT *
										    FROM 	t_mstkry
											WHERE		substr(t_mstkry.kdestt,1,1)	='G'	AND
														substr(t_mstkry.kdekry,1,1)!='@'	AND
														t_mstkry.str!='K'	
											ORDER BY    t_mstkry.nmakry";
													
							$result2=mysql_query($querykls);
                            $no=0;
							while($data=mysql_fetch_array($result2))
                              { $nmakry=$data[nmakry];
                                $kdekry=$data[kdekry];
                              $no++;
                               echo"
								<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">

		                       <TD><CENTER>$no 	</CENTER></TD>
  		                       <TD>($kdekry) $nmakry</TD>
							   
                                <TD><CENTER>
			                   <a href='#'  id='$kdekry' class='materi'>
			                    <IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		                         </TD>
								 <TD><CENTER>
			                   <a href='#'  id='$kdekry' class='tugas'>
			                    <IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		                         </TD>
                                 <TD><CENTER>
			                   <a href='#' id='$data[kdekry]' class='absensi'>
			                    <IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		                         </TD>
                                 <!--<TD><CENTER>
			                   <a href='#' id='$data[kdekry]' class='aktivitas'>
			                    <IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		                         </TD>-->
								 <TD><CENTER>
			                   <a href='#'  id='$kdekry' class='rpp'>
			                    <IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		                         </TD>
								 <!--<TD><CENTER>
			                   <a href='#'  id='$kdekry' class='aktivitas'>
			                    <IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		                         </TD>-->
                             	</TR>";
                                }

                                }
                                else
                                {
                                $querykls="	SELECT *,t_mstkry.nmakry
										    FROM 	 t_prstkt,t_mstkry
										WHERE 	t_prstkt.kdetkt='". mysql_escape_string($kdetkt)."'AND
												t_prstkt.kdekry=t_mstkry.kdekry	AND
												substr(t_prstkt.kdekry,1,1)!='@' AND
														t_mstkry.str!='K'
										ORDER BY    t_mstkry.nmakry";
							$result2=mysql_query($querykls);
                            $no=0;
							while($data=mysql_fetch_array($result2))
                              { $nmakry=$data[nmakry];
                                $kdekry=$data[kdekry];
                              $no++;
                                echo"
								<TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">

		                       <TD><CENTER>$no </CENTER></TD>
  		                       <TD><a href='../personalia/pendataan/G1D02_C01.php?kdekry=$kdekry' target='_blank' title='view detail employee data'>$nmakry</a></TD>
                                
								<TD><CENTER>
			                   <a href='#'  id='$kdekry' class='materi'>
			                    <IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		                         </TD>
								 <TD><CENTER>
			                   <a href='#'  id='$kdekry' class='tugas'>
			                    <IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		                         </TD>
                                 <TD><CENTER>
			                   <a href='#' id='$data[kdekry]' class='absensi'>
			                    <IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		                         </TD>
                                 <!--<TD><CENTER>
			                   <a href='#' id='$data[kdekry]' class='aktivitas'>
			                    <IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		                         </TD>-->
								 <TD><CENTER>
			                   <a href='#'  id='$kdekry' class='rpp'>
			                    <IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		                         </TD>
								 <!--<TD><CENTER>
			                   <a href='#'  id='$kdekry' class='aktivitas'>
			                    <IMG src='../images/detil_e.gif' BORDER='0'></a></CENTER>
		                         </TD>-->
                             	</TR>";
                                }
                                }
                        echo"</TABLE>
                    	</DIV>

					<TD WIDTH='50%'>
						<div style='overflow:auto;width:100%;height:390px;padding-right:-2px;'>
								
                                <TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='materi'> </table>
								<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='tugas'> </table>
								<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='absensi'></TABLE>
								<!--<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='aktivitas'> </table>-->
								<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='rpp'> </table>
								<!--<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='aktivitas'> </table>-->
						</DIV>
					</TD>
				</TR>
			</TABLE>
			<INPUT TYPE='button' VALUE='Statistic' 	onClick=window.open('pendataan/R1D02C_C01.php')>
			<!--<INPUT TYPE='button' VALUE='Statistic BK' 	onClick=window.open('pendataan/R1D02C_BK_C01.php')>-->
		</FORM>";
	}
}//akhir class
?>