
<?php
//----------------------------------------------------------------------------------------------------
//Program		: R1D04LTK2.php
//Di Edit oleh	: ITPCS
//Tanggal Edit	: 21/12/2011
//Keterangan	: Fungsi-fungsi SISWA print ledger sd
//----------------------------------------------------------------------------------------------------
if (!defined("sister")) {
  die("<h1>Permission Denied</h1>You don't have permission to access the this page.");
}
// -------------------------------------------------- Class --------------------------------------------------
class R1D04LTK21class
{
  // -------------------------------------------------- Cetak Daftar --------------------------------------------------
  function R1D04LTK21()
  {
    echo "<SCRIPT TYPE='text/javascript' src='../js/fungsi_input.js'></SCRIPT>";
    echo "<script TYPE='text/javascript' src='../js/DatePicker/WdatePicker.js'></script>";

    $kdekry  = $_SESSION["Admin"]["kdekry"];
    $sms = '1';
    $midtrm = '1';

    echo
      "

<body action=''>
		<tr>
      <td colspan='6' style='text-align: center; font-weight: bold'>
      <span>
       <img src = '../images/logo_sjs_meruya.png' style='text-align:center' height='100px' width='100px' alt=''>
      </span>
      <p><h3>Student Progress Report</h3></p>
              <p><h3>Pre-Kindergarten</h3></p>
              <p><h3>Academic Year 2020 - 2021</h3></p><br/>
      </td>
    </tr>
    <tr>
			<td width='20%'> <h3>Term/Semester</h3></td><td width='1%'><h3>:</h3></td><td width='39%' class='tbl'>
    </tr>
		<tr>
			<td width='20%'>Name</td><td width='1%'>:</td><td width='39%' class='tbl'>MTsN Sidoharjo</td>
			<td width='20%'>Date Of Birth</td><td width='1%'>:</td><td width='19%' class='tbl'></td>
		</tr>
		<tr>
			<td>Student No</td><td>:</td><td class='tbl'>Sumoroto, Sidoharjo, Samigaluh</td>
			<td>Class</td><td>:</td><td class='tbl'></td>
		</tr>
		<tr>
		</tr>
		<tr>
			<td colspan='3'></td>
		</tr>
		<tr><td colspan='6'><br><br></td></tr>
						
				</thead>
				</tbody>
    </tbody>
</thead>
</table>  
</body>
";
  }
}//akhir class
