$(function()
{
    $(".kdeklm").change(function()
	{
		var kdeklm = $("#kdeklm").val();

		if(kdeklm!='')
		{
			$('#plj').load("../guru/fungsi_khusus/R1D03A_plj.php?kdeklm="+kdeklm);
			$('#modul1').html('');
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
				url: "../guru/fungsi_khusus/R1D03A_materi.php",
				data: dataString,
				success: function()
				{
					$('#modul1').load("../guru/fungsi_khusus/R1D03A_materi.php?kdeklm="+kdeklm+"&kdeplj="+kdeplj);
				}
			});
		}
		return false;
	});
    // end detil materi//



});