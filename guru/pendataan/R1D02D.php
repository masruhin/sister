<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D02D.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi HASIL TEST
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D02Dclass
{
	// -------------------------------------------------- Item --------------------------------------------------
	function R1D02D()
	{
		require_once '../fungsi_umum/sysconfig.php';

		// deklarasi java
		echo"
		<LINK 	href='../css/val.css' 		rel='stylesheet' TYPE='text/css'>
		<SCRIPT TYPE='text/javascript' 		src='../js/jquery-validate.js'></SCRIPT>
        <SCRIPT TYPE='text/javascript' 	src='../js/fungsi_input.js'></SCRIPT> ";

		echo"<SCRIPT TYPE='text/javascript' 		src='../guru/js/R1D02D.js'></SCRIPT>";
		
		$user	=$_SESSION["Admin"]["nis"];
        $kdekry	=$_SESSION["Admin"]["kdekry"];

         // untuk mendapatkan kode guru
        $query	="	SELECT	t_mstssw.*,t_mstpng.kdegru
					FROM 	t_mstssw,t_mstpng
					WHERE	t_mstssw.nis='$user' AND
							t_mstssw.kdekls=t_mstpng.kdekls";
		$result	=mysql_query($query);
        $data	=mysql_fetch_array($result);
        $kdegru	=$data['kdegru'];

		echo"
		<FORM METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>STUDENT</B></TD></TR>
				<TR></TR><TR></TR>
				<TR><TD WIDTH='10%'>Class</TD>
                    <TD WIDTH='90%'>:
							<SELECT NAME	='kdekls'
									ID		='kdekls'
									class	='kdekls'
									value='$kdekls'
									$isian1>
							<OPTION VALUE='' SELECTED>--Select--</OPTION>";
							$query2="	SELECT 		*,t_mstkls.kdekls
										FROM 		t_prstkt,t_klmkls,t_mstkls
                                        WHERE      	t_prstkt.kdekry='". mysql_escape_string($kdekry)."'AND
													t_prstkt.kdetkt=t_klmkls.kdetkt AND
													t_prstkt.kdejbt<400 AND
													t_klmkls.kdeklm=t_mstkls.kdeklm
										ORDER BY t_mstkls.kdeklm,t_mstkls.kdekls";
							$result2=mysql_query($query2);

							while($data=mysql_fetch_array($result2))
							{
								if($kdekls==$data[kdekls])
									echo"<OPTION VALUE='$data[kdekls]' SELECTED>$data[kdekls]</OPTION>";
								else
									echo"<OPTION VALUE='$data[kdekls]'>$data[kdekls]</OPTION>";
							}
                            echo"</SELECT>
						</SELECT>
              	</TR>
                <TR><TD>Name</TD>
                    <TD>: <input type='text'
                                           id='nmassw'
                                           name='nmassw'
										   SIZE		='50'
								           MAXLENGTH	='50'

                    onkeypress	='return enter(this,event)'
                    onkeyup		='uppercase(this.id)'>

					</TD>
                </TR>
			</TABLE>

			<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR>
                    <TD WIDTH='42%'>
						<div style='overflow:auto;width:100%;height:350px;padding-right:-2px;'>
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='nma' class='table02'></TABLE>
						</DIV>
					</TD>
					<TD WIDTH='58%'>
						<div style='overflow:auto;width:100%;height:350px;padding-right:-2px;'>
							<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='nilai'></TABLE>
							<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='kehadiran'></TABLE>
                            <TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' id='bayar'></TABLE>
						</DIV>
					</TD>
				</TR>
			</TABLE>
		</FORM>";
	}
}//akhir class
?>