$(function()
{  //tampilkan soal di R1D01C//
	$("#kdebbt").change(function()
	{
	    //tampilkan Keterangan di R1D01C//
    	var kdegru 		= $("#kdegru").val();
    	var kdeplj 		= $("#kdeplj").val();
    	var dataString	='kdeplj='+kdeplj+'&kdegru='+kdegru;
		
		$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D01C_kdercu.php",
				data: dataString,
				success: function(msg)
				{
					$("#kdercu").val(msg);
					$("#kdercu1").val(msg);

				}
			});
    	$.ajax(
    	{
	        url: "../guru/fungsi_khusus/R1D01C_ktr.php",
			data: dataString,
			cache: false,
        	success: function(msg)
        	{
            	//jika data sukses diambil dari server kita tampilkan

    	        $('#ktr').html(msg);
                document.f2.pilih.hidden=false;
        	}
		})
         
			
			
    	var kdegru 		= $("#kdegru").val();
    	var kdeplj 		= $("#kdeplj").val();
    	var dataString	='kdeplj='+kdeplj+'&kdegru='+kdegru;
    	$.ajax(
    	{
			url: "../guru/fungsi_khusus/R1D01C_tpsoal.php",
			data: dataString,
        	cache: false,
        	success: function()
        	{
            	//jika data sukses diambil dari server kita tampilkan

    	        $("#s").val();
				$('#soal-soal').load("../guru/fungsi_khusus/R1D01C_tpsoal.php?kdegru="+kdegru+"&kdeplj="+kdeplj);


        	}
		})
		
	});

   $(".kdeplj").change(function()
			{
	    		var kdeplj = $("#kdeplj").val();
                var kdegru = $("#kdegru").val();
                var dataString = 'kdegru='+ kdegru + '&kdeplj='+kdeplj;
    			$.ajax(
    			{
        			url: "../guru/fungsi_khusus/R1D01C_kls.php",
        			data: dataString,
    	    		success: function(msg)
        			{
            			//jika data sukses diambil dari server kita tampilkan
            			//di <select id=kdecls>
                        document.f1.kdekls.disabled=false;
            			$("#kdekls").html(msg);

	        		}
    			})

                        });

	//untuk R1D01C
	$(".nmauj").change(function() 
	{
		var kdercu 	= $("#kdercu").val();
		var kdeplj 	= $("#kdeplj").val();
		var kdegru 	= $("#kdegru").val();
		var kdekls 	= $("#kdekls").val();
		var stt 	= $("#stt").val();
		var ktr 	= $("#ktr1").val();
		var kdebbt 	= $("#kdebbt").val();
		var tglrcu 	= $("#tglrcu").val();
		var jamrcu 	= $(".jamrcu").val();
		var pilihan = $("#edt").val();
		var dataString = 'kdegru='+ kdegru + '&kdercu=' + kdercu + '&kdekls=' + kdekls +'&kdeplj=' + kdeplj +'&stt=' + stt+'&ktr='+ktr+'&kdebbt=' + kdebbt+'&tglrcu=' + tglrcu + '&jamrcu='+ jamrcu+ '&pilihan=' + pilihan;

		if(kdebbt=='')
		{ 
			alert('Isian tidak boleh kosong')
		}
		else
		{
			$.ajax(
			{
				type: "POST",
				url: "guru.php?mode=R1D01C_Save",
				data: dataString,
				success: function()
				{
					document.f1.kdeplj.disabled=true;
					document.f1.tglrcu.disabled=true;
					document.f1.kdekls.disabled=true;
					document.f1.stt.disabled=true;
					document.f1.jamrcu.disabled=true;
					document.f1.kdebbt.disabled=true;
					document.f1.ktr1.disabled=true;
					document.f1.soal.focus();
					$('.error').fadeOut(200).hide();
				}
			});
          
		}
		return false;
	});

	//untuk R1D01C Pilihan==edit
	$(".uj").click(function()
	{
		var kdercu 	= $("#kdercu").val();
		var kdercuB = $("#kdercuB").val();
		var kdeplj 	= $("#kdeplj1").val();
		var kdegru 	= $("#kdegru").val();
		var kdekls 	= $("#kdekls").val();
		var stt 	= $("#stt").val();
		var ktr 	= $("#ktr1").val();
		var kdebbt 	= $("#kdebbt").val();
		var tglrcu 	= $("#tglrcu").val();
		var jamrcu 	= $(".jamrcu").val();
		var pilihan = $("#edt").val();
		var dataString = 'kdegru='+ kdegru + '&kdercu=' + kdercu +'&kdercuB=' + kdercuB +'&kdeplj=' + kdeplj+'&kdekls=' + kdekls +'&stt=' + stt+'&ktr='+ktr+'&kdebbt=' + kdebbt+'&tglrcu=' + tglrcu + '&jamrcu='+ jamrcu+ '&pilihan=' + pilihan;

		if(kdebbt=='')
		{ 
			alert('tidak boleh kosong')
		}
		else
		{
			$.ajax(
			{
				type: "POST",
				url: "guru.php?mode=R1D01C_Save",
				data: dataString,
				success: function()
				{
					document.f1.kdeplj.disabled=true;
					document.f1.tglrcu.disabled=true;
					document.f1.stt.disabled=true;
					document.f1.jamrcu.disabled=true;
					document.f1.kdebbt.disabled=true;
					document.f1.kdekls.disabled=true;
					document.f1.ktr1.disabled=true;
					document.f1.soal.focus();
					$('.error').fadeOut(200).hide();
                    window.location.href='guru.php?mode=R1D01C&kdercu='+kdercu+'&pilihan=detil_general';
				}
			});
		}
		return false;
	});
	
	

	//masukan soal kedalam R1D01C
	//ambil kodesoal//
	$(".detil").click(function()
	{
		var element 	= $(this);
		var id 			= element.attr("id");
		var dataString 	= 'id=' + id;

		if(id=='')
		{ 
			alert('tidak boleh kosong')
			document.f1.id.focus();
			document.f1.id.value='';
		}
		else
		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D01C_inputsoal.php",
				data: dataString,
				success: function()
				{
					$('#inputsoal').load("../guru/fungsi_khusus/R1D01C_inputsoal.php?id="+id);
				}
			});
		}
		return false;
	});

	//ambil detail pada rencana ujian//
	$(".more").click(function() 
	{
		var element 	= $(this);
		var id 			= element.attr("id");
		var kdercu 		= $("#kdercu").val();
		var dataString 	= 'id=' + id;

		if(id=='')
		{ 
			alert('tidak boleh kosong')
			document.f1.id.focus();
			document.f1.id.value='';
		}
		else
		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D01C_inputsoalru.php",
				data: dataString,
				success: function()
				{
					$('#inputsoal').load("../guru/fungsi_khusus/R1D01C_inputsoalru.php?id="+id);
				}
			});
		}
		return false;
	});

//tampilkan soal di R1D01C//
	$("#pilih").change(function()
	{
        var pilih 		= $("#pilih").val();
        var kdegru 		= $("#kdegru").val();
    	var kdeplj 		= $("#kdeplj").val();
    	var dataString	='kdeplj='+kdeplj+'&kdegru='+kdegru;
        if(pilih=='banksoal')
        {
    	$.ajax(
    	{
	        url: "../guru/fungsi_khusus/R1D01C_ktr.php",
			data: dataString,
			cache: false,
        	success: function(msg)
        	{
            	//jika data sukses diambil dari server kita tampilkan
    	        $('#ktr').html(msg);
        	}
		})
        }
        else
        if(pilih=='rencanasoal')
        {
    	$.ajax(
    	{
	        url: "../guru/fungsi_khusus/R1D01C_rcnsoal.php",
			data: dataString,
			cache: false,
        	success: function(msg)
        	{
            	//jika data sukses diambil dari server kita tampilkan
    	        $('#ktr').html(msg);
        	}
		})
        }

});
});