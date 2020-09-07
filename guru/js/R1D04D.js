$(function()
{  
	$(".kdekls").change(function()
	{
		var kdekls = $("#kdekls").val();
        var kdegru = $("#kdegru").val();
        var dataString = 'kdegru='+ kdegru +'&kdekls='+kdekls;
    	$.ajax(
    	{
			url: "../guru/fungsi_khusus/R1D04D_wa.php",
        	data: dataString,
    	    success: function(msg)
        	{
				document.f1.idwa.disabled=false;
            	$("#idwa").html(msg);
       		}
		})
	});	
});