$(function()
{  $(".kdeplj").change(function()
			{
	    		var kdeplj = $("#kdeplj").val();
                var kdegru = $("#kdegru").val();
                var dataString = 'kdegru='+ kdegru +'&kdeplj='+kdeplj;
    			$.ajax(
    			{
					url: "../guru/fungsi_khusus/R1D04S_kls.php",
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