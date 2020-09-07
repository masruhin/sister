$(function()
{  $(".kdekls").change(function()
			{
	    		var kdeplj = $("#kdekls").val();
                //var kdegru = $("#kdegru").val();
                var dataString = 'kdeplj='+kdeplj;//'kdegru='+ kdegru +
    			$.ajax(
    			{
					url: "../guru/fungsi_khusus/R1D04R_kls.php",
        			data: dataString,
    	    		success: function(msg)
        			{
            			//jika data sukses diambil dari server kita tampilkan
            			//di <select id=kdekls>
                        document.f1.kdekls.disabled=false;
            			$("#kdekls").html(msg);

	        		}
    			})

                        });	
	
	
						
						
						

});