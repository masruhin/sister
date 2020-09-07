$(function()
{
    $(".kdekls").change(function()
	{
		var kdekls = $("#kdekls").val();

		if(kdekls!='')
		{
			$('#mstssw').load("../tatausaha/fungsi_khusus/T6U01_siswa.php?kdekls="+kdekls);
		}
	});
});