<?php
session_start();
if(!defined('sister'))	die("<h1>Permission Denied</h1>You don't have permission to access the this page.");

class P5L03class
{	
	// -------------------------------------------------- Layar Utama --------------------------------------------------
	function P5L03()
	{
		$tgl =date("d-m-Y");
		
		echo'<script TYPE="text/javascript" src="../js/DatePicker/WdatePicker.js"></script>';
		
		echo"
		<form action='?mdl=P5L03' target='_blank' method='post' class='form1' name='f1'>
			<table id='container'>
				<tr><td width='150'><b>BORROWING FINES</b></td>
				<td align='right'>";
					
				echo"	
				</td></tr><tr><td colspan='2'>&nbsp;</td></tr>
				<tr><td>From Returning</td><td><input type='text' size='10' name='tgl1' id='tgl1' value=$tgl>&nbsp
						Until :<input type='text' size='10' name='tgl2' id='tgl2' value=$tgl>
					</td>
				</tr>";
				
				echo"<tr><td colspan='2'>&nbsp;</td></tr><tr>";
					echo"<td colspan='2'><input type=submit value='Print All' formmethod='post' formaction='laporan/P5L03_C01.php' class='input_button_red'>";
					echo"<input type=submit value='Paid' formmethod='post' formaction='laporan/P5L03_C02.php' class='input_button_red'>";
					echo"<input type=submit value='Not Yet Paid' formmethod='post' formaction='laporan/P5L03_C03.php' class='input_button_red'></td>";
				echo"</tr>";
				
			echo"</table>
		</form>";
		
	}
}
?>