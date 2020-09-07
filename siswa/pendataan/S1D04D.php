<?php
//----------------------------------------------------------------------------------------------------
//Program		: S1D04A.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi PEMBAYARAN
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class S1D04Dclass
{
	// -------------------------------------------------- Item --------------------------------------------------
	function S1D04D()
	{   $user	=$_SESSION["Admin"]["nis"];
        $kdekls	=$_SESSION["Admin"]["kdekls"];
		require_once '../fungsi_umum/sysconfig.php';
         // untuk mendapatkan kode kelompok
        $query	="	SELECT 		t_btukng.*,t_mstssw.*,t_jtu.*
					FROM 		t_btukng,t_mstssw,t_jtu
					WHERE		t_btukng.nis	='$user' 		AND
								t_btukng.nis	= t_mstssw.nis 	AND
								t_btukng.kdejtu=t_jtu.kdejtu
					ORDER BY 	t_btukng.tglbtu";
        $no=0;
		$result= mysql_query($query)	or die (mysql_error());
		echo"
					<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>PEMBAYARAN</B></TD></TR>
				<TR></TR><TR></TR>
				</TABLE>

							<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR>
					<TD WIDTH='100%'>

        <div style='overflow:auto;width:100%;height:420px;padding-right:-2px;'>
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' >
							<TR bgcolor='dedede'>
									<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
									<TD WIDTH='15%'><CENTER>Nomor Pembayaran 	</CENTER></TD>
									<TD WIDTH='51%'><CENTER>Jenis Pembayaran 	</CENTER></TD>
									<TD WIDTH='10%'><CENTER>Tanggal  	</CENTER></TD>
                                    <TD WIDTH='10%'><CENTER>Nilai 			</CENTER></TD>
								</TR>";
                                 while($data	=mysql_fetch_array($result))
                                 {
                                  $nmrbtu 	=$data['nmrbtu'];
								  $nmajtu 	=$data['nmajtu'];
                                  $tglbtu	=$data['tglbtu'];
								  $nli	=number_format($data['nli']);
                                  $no++;
                                  echo"
                                  <TR bgcolor='white'>
									<TD HEIGHT='20'><CENTER>$no	</CENTER></TD>
									<TD><CENTER>$nmrbtu	</CENTER></TD>
									<TD><CENTER>$nmajtu	</CENTER></TD>
                                    <TD><CENTER>$tglbtu </CENTER></TD>
									<TD><CENTER>$nli 	</CENTER></TD>
								</TR>";
                                }
                                echo"
								</TABLE>
							</TABLE>
						</DIV>
					</TD>
				</TR>
			</TABLE>
						
		";
	}
}//akhir class
?>