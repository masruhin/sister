<?php
//----------------------------------------------------------------------------------------------------
//Program		: S1D04A.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi MATERI PELAJARAN
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class S1D04Cclass
{
	// -------------------------------------------------- Item --------------------------------------------------
	function S1D04C()
	{   $user	=$_SESSION["Admin"]["nis"];
        $kdekls	=$_SESSION["Admin"]["kdekls"];
		require_once '../fungsi_umum/sysconfig.php';
         // untuk mendapatkan kode kelompok
        $query	="	SELECT 	t_mstssw.*,t_gnrpjm.tglpjm,t_dtlpjm.tglkmb,t_mstbku.jdl
					FROM 	t_mstssw,t_gnrpjm,t_dtlpjm,t_mstbku
					WHERE	t_mstssw.nis	='$user' 		AND
							t_mstssw.nis	=t_gnrpjm.kdeang AND
                            t_gnrpjm.nmrpjm=t_dtlpjm.nmrpjm AND
                            t_dtlpjm.kdebku=t_mstbku.kdebku";
        $no=0;
		$result= mysql_query($query)	or die (mysql_error());
		echo"
					<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR><TD COLSPAN='2'><B>PEMINJAMAN BUKU</B></TD></TR>
				<TR></TR><TR></TR>
				</TABLE>

							<TABLE BORDER='0' BORDERCOLOR='#000000' CELLPADDING='5' CELLSPACING='5' WIDTH='100%'>
				<TR>
					<TD WIDTH='100%'>

        <div style='overflow:auto;width:100%;height:420px;padding-right:-2px;'>
							<TABLE BORDER='1' BORDERCOLOR='#000000' CELLPADDING='0' CELLSPACING='0' WIDTH='100%' >
							<TR bgcolor='dedede'>
									<TD WIDTH=' 4%' HEIGHT='20'><CENTER>No	</CENTER></TD>
									<TD WIDTH='75%'><CENTER>Judul Buku 	</CENTER></TD>
                                    <TD WIDTH='10%'><CENTER>Tanggal Pinjam 	</CENTER></TD>
                                    <TD WIDTH='10%'><CENTER>Tanggal Kembali 	</CENTER></TD>
								</TR>";
                                 while($data	=mysql_fetch_array($result))
                                 {
                                  $nmabku = $data['jdl'];
                                  $tglpjm=$data['tglpjm'];
                                  $tglkmb=$data['tglkmb'];
                                  $no++;
                                  echo"
                                  <TR onMouseOver=\"this.className='highlight'\" onMouseOut=\"this.className='normal'\">
									<TD WIDTH=' 4%' HEIGHT='20'><CENTER>$no	</CENTER></TD>
									<TD WIDTH='75%'><CENTER>$nmabku	</CENTER></TD>
                                    <TD WIDTH='10%'><CENTER>$tglpjm 	</CENTER></TD>
                                    <TD WIDTH='10%'><CENTER>$tglkmb 	</CENTER></TD>
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