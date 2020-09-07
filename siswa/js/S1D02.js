$(function()
{
	$(".kdeplj").change(function() 
	{
		var nis = $("#nis").val();
		var kdeplj = $("#kdeplj").val();
		var kdekls = $("#kdekls").val();

		if(kdeplj!='')
		{
			$('#test').load("../siswa/fungsi_khusus/S1D02_hasil_test.php?nis="+nis+"&kdekls="+kdekls+"&kdeplj="+kdeplj);
            
		}
	})
});