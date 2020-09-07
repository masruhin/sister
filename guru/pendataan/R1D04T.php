<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D04T.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi SISWA print grading sheet smA 11-12 ipa
//----------------------------------------------------------------------------------------------------
if(!defined("sister"))
{
	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04Tclass
{
    // -------------------------------------------------- Cetak Daftar --------------------------------------------------
 	function R1D04T()
 	{   
	    $kdekry	=$_SESSION["Admin"]["kdekry"];
		$sms='1';
		$midtrm='1';
		echo"
		<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";	
		echo"<script TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></script>";
		//-----Validasi kelas----//
		   echo"<SCRIPT TYPE='text/javascript' 	src='../js/jquery-validate.js'></SCRIPT>
           <SCRIPT TYPE='text/javascript' src='../guru/js/R1D04T.js'></SCRIPT>
		";
		//----End Validasi Kelas---//

        

	 	echo"<BODY>
			
		<FORM ID='validasi' ACTION='pendataan/R1D04T_C01.php' target=_blank METHOD='post' NAME='f1' ENCTYPE='multipart/form-data'>
  			<TABLE BORDER='0' CELLPADDING='0' CELLSPACING='5' WIDTH='100%'>
        		<TR><TD COLSPAN='2'><B>PRINT GRADING SHEET (SHS) 12 <!--IPA--></B></TD></TR>
           		<TR></TR><TR></TR>
				<TR><TD WIDTH='15%'>Subject</TD>
					<TD WIDTH='85%'>:
					<INPUT TYPE='hidden' 	NAME='kdegru' ID='kdegru'	VALUE='$kdekry'>
					<SELECT 	NAME		='kdeplj'
								ID		 	='kdeplj'
                                CLASS		='kdeplj'
								onkeypress	='return enter(this,event)'>
					<OPTION VALUE='' SELECTED>--Select--</OPTION>";

					$query2	="	SELECT 		t_prstkt.* 
								FROM 		t_prstkt
								WHERE 		t_prstkt.kdekry='$kdekry' 
								ORDER BY 	t_prstkt.kdekry"; // mneghasilkan kode tingkat dan kode jabatan 300/400
					$result2	=mysql_query($query2);
					$kdejbt=1000;
					while($data2=mysql_fetch_array($result2))
					{
						if($data2[kdejbt]<$kdejbt AND $data2[kdejbt]!='')
							$kdejbt	=$data2[kdejbt];
					}	
					
					if(($kdejbt<300 OR $kdejbt==900) AND $kdejbt!=500)
					{
						$query2="	SELECT 	DISTINCT t_mstplj.kdeplj,t_mstplj.nmaplj
									FROM 	t_mstpng,t_mstplj
									WHERE 	t_mstpng.kdeplj=t_mstplj.kdeplj 
									ORDER BY t_mstplj.nmaplj"; // menghasilka nama matpel
					}
					if($kdejbt==300 OR $kdejbt==400) // khusus walikelas / guru
					{
						$query2="	SELECT 	DISTINCT t_mstplj.kdeplj,t_mstplj.nmaplj
									FROM 	t_mstpng,t_mstplj
									WHERE 	t_mstpng.kdegru='$kdekry' AND
											t_mstpng.kdeplj=t_mstplj.kdeplj 
									ORDER BY t_mstplj.nmaplj"; // menghasilka nama matpel
					}
					$result2=mysql_query($query2);
					while($data=mysql_fetch_array($result2))
					{
						echo"<OPTION VALUE='$data[kdeplj]'>$data[nmaplj]</OPTION>";
					}
					echo"
					</SELECT>
					</TD>
				</TR>
				<TR><TD WIDTH='15%'>Class</TD>
					<TD WIDTH='85%'>:
						<SELECT NAME		='kdekls'
												ID			='kdekls'
												
												onkeypress	='return enter(this,event)'
												disabled>
										<OPTION VALUE='' SELECTED>--Select--</OPTION>";
										$query2="	SELECT DISTINCT	t_mstpng.kdekls
													FROM 			t_mstpng
													WHERE 			t_mstpng.kdegru='$kdekry'
													ORDER BY t_mstpng.kdekls "; // menghasilka kelas berapa saja
										$result2=mysql_query($query2);
										while($data=mysql_fetch_array($result2))
										{
											if($kdekls==$data[kdekls])
												echo"<OPTION VALUE='$data[kdekls]' SELECTED>$data[kdekls]</OPTION>";
											else
												echo"<OPTION VALUE='$data[kdekls]'>$data[kdekls]</OPTION>";
										}
										echo"
										</SELECT>
					</TD>
				</TR>
				<TR><TD>Semester</TD>
					<TD>:
						<INPUT NAME			='sms'
								TYPE		='radio'
								VALUE 		='1'
								ID			='sms'";
						if($sms=='1')
							echo"checked";
							echo"> 
							1
						<INPUT 	NAME		='sms'
								TYPE		='radio'
								VALUE 		='2'
								ID			='sms'";
						if($sms=='2')
							echo"checked";
							echo"> 
							2
					</TD>
				</TR>
				<TR><TD>Mid Term</TD>
					<TD>:
						<INPUT NAME			='midtrm'
								TYPE		='radio'
								VALUE 		='1'
								ID			='midtrm'";
						if($midtrm=='1')
							echo"checked";
							echo"> 
							1
						<INPUT 	NAME		='midtrm'
								TYPE		='radio'
								VALUE 		='2'
								ID			='midtrm'";
						if($midtrm=='2')
							echo"checked";
							echo"> 
							2
					</TD>
				</TR>
                <TR><TD>Print Date</TD>
              		<TD>:
						<INPUT 	NAME		='tglctk'
								TYPE		='text'
								SIZE		='10'
								MAXLENGTH	='10'
								VALUE 		='$tglctk'
								ID			='tglctk'
								ONKEYPRESS	='return enter(this,event)'>
						<IMG onClick='WdatePicker({el:tglctk});' src='../js/DatePicker/skin/datePicker.gif' WIDTH='16' HEIGHT='16' align='absmiddle'>
					</TD>
				</TR>
            	<tr>
					<td>Tahun Pelajaran</td><td> : 
						
						<input type='text' NAME='thn_ajr' ID='thn_ajr' value='2018-2019' readonly/>
						
					</td>
				</tr>			
    	   	</TABLE>
			<INPUT TYPE=submit 		VALUE='Print'>
			      
		</FORM></BODY>
		";
		
 	}
}//akhir class
?>