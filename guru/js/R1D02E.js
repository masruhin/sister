$(function()
{
	
	
	//untuk lihat detil nilai siswa
    $(".rpp").click(function()
	{
		var element 	= $(this);
		var kdekry 		= element.attr("id");
        //var nmassw 		= element.attr("nmasw");
		var dataString 	= 'kdekry=' + kdekry;

		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D02E_rpp.php",
				data: dataString,
				success: function()
				{
					$('#rpp').load("../guru/fungsi_khusus/R1D02E_rpp.php?kdekry="+kdekry);
                    //$('').html('');
                   
				}
			});
		}
		return false;
	});
    // end detil nilai siswa//

});