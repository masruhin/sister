$(function()
{
	//untuk lihat detil kirim email
    $(".kirim_pesan").click(function()
	{
		var element 	= $(this);
		var kdekry 		= element.attr("id");
		var kdekrm 		= element.attr("kdkr");
		var dataString 	= 'kdekry=' + kdekry+'&kdekrm='+kdekrm;

					$('#kirim_pesan').load("../guru/fungsi_khusus/R6U02_kirim.php?kdekry="+kdekry)
					$('#inbox,#outbox,#balas,#inbfront,#cb').html('');
					document.f1.del.hidden=true;
				
		return false;
	});
    // end detilkirim pesan//
    //untuk lihat detil inbox
    $(".inbox").click(function()
	{
		var element 	= $(this);
		var kdekry 		= element.attr("id");
        //var nmassw 		= element.attr("nmasw");
		var dataString 	= 'kdekry=' + kdekry;

		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R6U02_inbox.php",
				data: dataString,
				success: function()
				{
					$('#inbox').load("../guru/fungsi_khusus/R6U02_inbox.php?kdekry="+kdekry);
                    $('#kirim_pesan,#outbox,#balas,#inbfront,#cb').html('');
					document.f1.del.hidden=true;
				
				}
			});
		}
		return false;
	});
    // end detil inbox//
	//untuk lihat detil outbox
    $(".outbox").click(function()
	{
		var element 	= $(this);
		var kdekry 		= element.attr("id");
        //var nmassw 		= element.attr("nmasw");
		var dataString 	= 'kdekry=' + kdekry;

		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R6U02_outbox.php",
				data: dataString,
				success: function()
				{
					$('#outbox').load("../guru/fungsi_khusus/R6U02_outbox.php?kdekry="+kdekry);
					$('#inbox,#kirim_pesan,#balas,#inbfront,#cb').html('');
					document.f1.del.hidden=true;
					
					
					
				}
			});
		}
		return false;
	});
    // end detil outbox//
	
	

	
});