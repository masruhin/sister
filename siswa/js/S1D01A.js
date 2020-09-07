$(function()
{
	$(".kdeplj").change(function()
	{
		//var kdegru = $("#kdegru").val();
		var kdeplj = $("#kdeplj").val();
		var kdeklm = $("#kdeklm").val();

		if(kdeplj!='')
		{
			$('#modul').load("../siswa/fungsi_khusus/S1D01A_materi.php?kdeklm="+kdeklm+"&kdeplj="+kdeplj);
		}
	})
});