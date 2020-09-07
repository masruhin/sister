$(function()
{
	//untuk lihat detil nilai siswa
    $(".pelajaran").click(function()
	{
		var element 	= $(this);
		var kdekls 		= element.attr("id");
        //var nmassw 		= element.attr("nmasw");
		var dataString 	= 'kdekls=' + kdekls;

		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D02B_pelajaran.php",
				data: dataString,
				success: function()
				{
					$('#pelajaran').load("../guru/fungsi_khusus/R1D02B_pelajaran.php?kdekls="+kdekls);
                    $('#siswa').html('');
				}
			});
		}
		return false;
	});
    // end detil nilai siswa//
    //untuk lihat detil nilai siswa
    $(".siswa").click(function()
	{
		var element 	= $(this);
		var kdekls 		= element.attr("id");
        //var nmassw 		= element.attr("nmasw");
		var dataString 	= 'kdekls=' + kdekls;

		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D02B_siswa.php",
				data: dataString,
				success: function()
				{
					$('#siswa').load("../guru/fungsi_khusus/R1D02B_siswa.php?kdekls="+kdekls);
                    $('#pelajaran').html('');
				}
			});
		}
		return false;
	});
    // end detil nilai siswa//

});