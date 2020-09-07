


<?php
session_start();
if(!defined('sister'))	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");

class P5L01class
{	
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function P5L01()
	{
		$tgl =date("d-m-Y");
		
		echo'<script TYPE="text/javascript" src="../js/DatePicker/WdatePicker.js"></script>';
		
		echo"
		<form action='?mdl=P5L01' target='_blank' method='post' class='form1' name='f1'>
			<table id='container'>
				<tr><td width='200'><b>LAPORAN BUKU DIPINJAM SISWA</b></td>
				<td align='right'>";
					
				echo"	
				</td></tr><tr><td colspan='2'><br></td></tr>
				<tr><td>From Borrowing :</td><td><input type='text' size='10' name='tgl1' id='tgl1' value=$tgl>&nbsp
						Until :<input type='text' size='10' name='tgl2' id='tgl2' value=$tgl>
					</td>
				</tr>";
				
				echo"<tr><td colspan='2'>&nbsp;</td></tr>	<tr><td>Class</td>
						<td><select name='kdekls' id='kdekls'>
								<OPTION VALUE='' SELECTED>--CHOOSE--</OPTION>";
									$qry=mysql_query("select t_mstkls.* from t_mstkls order by t_mstkls.kdeklm,kdekls asc");
									while($dta=mysql_fetch_array($qry))
									{
										if($kdekls==$dta[kdekls])	echo"<option value='$dta[kdekls]' selected>$dta[kdekls]</option>";
										else						echo"<option value='$dta[kdekls]' >$dta[kdekls]</option>";
									}
								echo
								"</select>
						</td>
					</tr>";
				
				echo"<tr><td colspan='2'>&nbsp;</td></tr>	<tr>
						<td>Condition</td>
						<td><select name='knd' id='knd'>
								<option value=''>--ALL--</option>
								<option value='G'>GOOD</option>
								<option value='B'>BROKEN</option>
								<option value='L'>LOST</option>
							</select>
						</td>
					</tr>
					<tr><td>Status</td>
						<td><input name='stt' type='radio' value='R'"; if($stt=='R') echo"checked"; echo"> Returned
							<input name='stt' type='radio' value='N'"; if($stt=='N') echo"checked"; echo"> Not Returned
							<input name='stt' type='radio' value=''";  if($stt=='')  echo"checked"; echo"> All
						</td>
					</tr>";
				
				echo"<tr><td colspan='2'>&nbsp;</td></tr><tr>";
					echo"<td colspan='2'><input type=submit value='Print' formmethod='post' formaction='laporan/P5L01_C01.php' class='input_button_red'></td>";
					
				echo"</tr>";
				
			echo"</table>
		</form>";
		
	}
}
?>