$(function()
{   //Disable/Enable
    //untuk R1D01G g_dtlmtr
		$(".stt1").click(function()
	{
		var element = $(this);
		var id = element.attr("id");
        var stt = element.attr("stt");
		var kdegru = element.attr("kdegr");
		var info = 'id=' +id+'&stt='+stt+'&kdegru='+kdegru;
        var kderpp = $("#kderpp").val();
        //var nmarpp = $("#nmarpp2").val();
		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D01G_Update.php",
				data: info,
				success: function(msg)
				{
					window.location.href='guru.php?mode=R1D01G&kderpp='+kderpp+'&pilihan=tambah_item';
                    document.f1.nmarpp.focus();
				}
			});
		}
		return false;
	});
    //end disable/enable


    $(".kdeplj").change(function()
			{
	    		var kdeplj = $("#kdeplj").val();
                var kdegru = $("#kdegru").val();
                var dataString = 'kdegru='+ kdegru + '&kdeplj='+kdeplj;
    			$.ajax(
    			{
        			url: "../guru/fungsi_khusus/R1D01G_kls.php",
        			data: dataString,
    	    		success: function(msg)
        			{
            			//jika data sukses diambil dari server kita tampilkan
            			//di <select id=kdecls>
                        document.f1.kdeklm.disabled=false;
            			$("#kdeklm").html(msg);

	        		}
    			})

                        });
	//untuk R1D01G g_gnrmtr
	$(".kdeklm").change(function()
	{
         var kderpp = $("#kderpp").val();
         var kdegru = $("#kdegru").val();
         var kdeklm = $("#kdeklm").val();
         var kdeplj = $("#kdeplj").val();
         var edit = $("#edt").val();
         var dataString = 'kderpp='+ kderpp+ '&kdeklm='+ kdeklm + '&kdeplj=' + kdeplj+ '&kdegru=' + kdegru+ '&pilihan=' + edit ;

        if(kdeplj=='')
        {
			alert('nama rpp Pelajaran tidak boleh kosong')
            document.f1.kdeplj.focus();
            return false;
        }
        else
        if(kdeklm=='')
        { 
			alert('kelas tidak boleh kosong')
        }
        else
        {
			$.ajax(
			{
				type: "POST",
				url: "guru.php?mode=R1D01G_Save",
				data: dataString,
				success: function(data)
				{
                    $.ajax(
		{

            url: "../guru/fungsi_khusus/R1D01G_kderpp.php",
			data: dataString,
			cache: false,
			success: function(msg)
			{
				//jika data sukses diambil dari server kita tampilkan
				$('#kderpp').val(msg);
                    document.f1.kdeplj.disabled=true;
					document.f1.kdeklm.disabled=true;
					document.f1.nmarpp.disabled=false;
					document.f1.pdf.disabled=false;
					document.f1.inpt.disabled=false;
					document.f1.nmarpp.focus();
			}
		})
					$('#rpp').load("../guru/fungsi_khusus/R1D01G_rpp.php?kdeklm="+kdeklm+"&kdeplj="+kdeplj+"&kdegru="+kdegru);
					
				}
			})
		}
		
	});
	return false;

	//untuk R1D01G g_dtlmtr
	$("#sub").click(function() 
	{
		var kdegru = $("#kdegru").val();
		var nmarpp = $("#nmarpp").val();
		var pdf = $(".pdf").val();
		var edit = $("#edt").val();
		var dataString = 'kdegru='+ kdegru + '&nmarpp='+nmarpp+  '&pdf='+pdf+'&pilihan=' + edit ;

		if(nmarpp=='')
		{ 
			alert('nama rpp Pelajaran tidak boleh kosongss')
		}
		else
		{
			$.ajax(
			{
				type: "POST",
				url: "guru.php?mode=R1D01G_SaveD",
				data: dataString,
				success: function()
				{
					document.f1.kdeplj.disabled=true;
					document.f1.kdekls.disabled=true;
					document.f1.nmarpp.focus();
					document.f1.nmarpp.value='';
					document.f1.nmarpp.value=pdf;
				}
			});
		}
		return false;
	});




});