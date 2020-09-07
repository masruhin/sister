//untuk UJO01 g_gnrnli
$(function() 
{ 
	//ambil detail pada ujian Online (UJO01)//
	$(".dety").click(function() 
	{
		var element = $(this);
		var id = element.attr("id");
		var kdeoln = $("#kdeoln").val();
		var dataString ='id='+id;

		$.ajax(
		{
			type: "GET",
			url: "../ujian_online/fungsi_khusus/inputsoalol.php",
			data: dataString,
			success: function()
			{
				$('#uol').load("../ujian_online/fungsi_khusus/inputsoalol.php?id="+id);
			}
		})
	});
});