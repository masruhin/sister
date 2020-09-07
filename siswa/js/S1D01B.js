$(function()
{
	$(".kdeplj").change(function()
	{
		//var kdegru = $("#kdegru").val();
		var kdeplj = $("#kdeplj").val();
		var kdeklm = $("#kdeklm").val();

		if(kdeplj!='')
		{
			$('#tugas').load("../siswa/fungsi_khusus/S1D01B_tugas.php?kdeklm="+kdeklm+"&kdeplj="+kdeplj);
		}
	})
});