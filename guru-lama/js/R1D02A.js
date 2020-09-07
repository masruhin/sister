$(function()
{
    $(".kdeklm").change(function()
	{
		var kdeklm = $("#kdeklm").val();

		if(kdeklm!='')
		{
			$('#plj').load("../guru/fungsi_khusus/R1D02A_plj.php?kdeklm="+kdeklm);
			$('#modul1','#tugas1').html('');
		}
	});

   //untuk lihat detil materi
    $(".mtr").click(function()
	{
		var element 	= $(this);
		var kdeklm 		= element.attr("id");
        var kdeplj 		= element.attr("kdeplj");
		var dataString 	= 'kdeklm=' + kdeklm;

		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D02A_materi.php",
				data: dataString,
				success: function()
				{
					$('#modul1').load("../guru/fungsi_khusus/R1D02A_materi.php?kdeklm="+kdeklm+"&kdeplj="+kdeplj);
					$('#tugas1').html('');
				}
			});
		}
		return false;
	});
    // end detil materi//

   //untuk lihat detil tugas
    $(".tgs").click(function()
	{
		var element 	= $(this);
		var kdeklm 		= element.attr("id");
        var kdeplj 		= element.attr("kdeplj");
		var dataString 	= 'kdeklm=' + kdeklm;

		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D02A_tugas.php",
				data: dataString,
				success: function()
				{
					$('#tugas1').load("../guru/fungsi_khusus/R1D02A_tugas.php?kdeklm="+kdeklm+"&kdeplj="+kdeplj);
					$('#modul1').html('');
				}
			});
		}
		return false;
	});
    // end detil tugas//
	


});