$(function()
{  $(".kdebbt").change(function()
			{
	    		var kdebbt = $("#kdebbt").val();
                var sms = $("#sms").val();
				var midtrm = $("#midtrm").val();
                var dataString = 'kdebbt='+ kdebbt+'&sms='+sms+'&midtrm='+midtrm;
    			$.ajax(
    			{
					url: "../guru/fungsi_khusus/R1D01F_tgs.php",
        			data: dataString,
    	    		success: function(msg)
        			{
            			//jika data sukses diambil dari server kita tampilkan
            			//di <select id=kdekls>
                        document.f1.prdtes.disabled=false;
            			$("#prdtes").html(msg);

	        		}
    			})

                        })
						
						
$("#prdtes").change(function()
			{
	    		var kdeplj = $("#kdeplj").val();
				var prdtes = $("#prdtes").val();
                var i = $("#i").val();
				
                var dataStrings = 'kdeplj='+kdeplj+'&prdtes='+prdtes+'&i='+i;
				var dta = $("#dta").val();
			
    			$.ajax(
    			{
					type: "POST",
					url: "../guru/fungsi_khusus/R1D01F_cekdta.php",
        			data: dataStrings,
					cache: false,
    	    		success: function(msg)
        			{
            			//document.f1.dta.value='dsd';
            			$("#dta").val(msg);
						var dta = $("#dta").val();
						if(dta!='0')
						{
                        confirm('Data Nilai Sudah Ada...\nBila Anda ingin Replace Data Tekan OK \nLalu Klik Tombol Transfer Nilai \nBila ingin membatalkan tekan Cancel');
						}
	        		}
				
    			})
				

                        });

$("#dta").keyup(function()
			{
	    		var dta = $("#dta").val();
				if(dta!='0')
				{
				confirm('Data Sudah Ada');
				}
                        });
						
});