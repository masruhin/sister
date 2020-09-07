$(function()
{
	//untuk lihat baca email
     $(".baca").click(function()
	{
		var element 	= $(this);
		var kdekry 		= element.attr("id");
		var dataString 	= 'id=' + kdekry;

		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R6U02_baca.php",
				data: dataString,
				success: function()
				{   
					$('#balas').load("../guru/fungsi_khusus/R6U02_baca.php?id="+kdekry)
					$('#inbox,#outbox,#inbfront,#cb').html('');
					$.ajax(
				{
				url: "../guru/fungsi_khusus/R6U02_juminbox.php",
				data: dataString,
				success: function(msg)
				{
					$("#inb").html(msg);
					$('#inbx,#inbfront,#cb').html('');
					document.f1.del.hidden=true;
				}
			     });
					
				}
			});
		}
		return false;
	});
	
	//untuk lihat baca email
     $(".baca1").click(function()
	{
		var element 	= $(this);
		var kdekr 		= element.attr("id");
		//var kdekrm      = $("#kdekrm").val();
		var dataString 	= 'id='+kdekr;

		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R6U02_bacaout.php",
				data: dataString,
				success: function()
				{   
					$('#balas').load("../guru/fungsi_khusus/R6U02_bacaout.php?id="+kdekr)
					$('#inbox,#outbox,#inbfront,#cb').html('');
					document.f1.del.hidden=true;
					
					
				}
			});
		}
		return false;
	});
	
	//untuk lihat detil balas email
    $(".balas").click(function()
	{
		var element 	= $(this);
		var kdekrm 		= element.attr("id");
		var id      = $("#di").val();
		var dataString 	= 'kdekrm=' + kdekrm+'&id='+id;

		
					$('#balas').load("../guru/fungsi_khusus/R6U02_balas.php?kdekrm="+kdekrm+'&id='+id)
					$('#inbx,#inbox,#outbox,#inbfront,#cb,#del').html('');
							
		
		return false;
	});
    // end balas pesan//
	
	
	
});