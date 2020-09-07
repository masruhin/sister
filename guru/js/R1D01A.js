$(function()
{   //Disable/Enable
    //untuk R1D01A g_dtlmtr
		$(".stt1").click(function()
	{
		var element = $(this);
		var id = element.attr("id");
        var stt = element.attr("stt");
		var kdegru = element.attr("kdegr");
		var info = 'id=' +id+'&stt='+stt+'&kdegru='+kdegru;
        var kdemtr = $("#kdemtr").val();
        //var nmamtr = $("#nmamtr2").val();
		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D01A_Update.php",
				data: info,
				success: function(msg)
				{
					window.location.href='guru.php?mode=R1D01A&kdemtr='+kdemtr+'&pilihan=tambah_item';
                    document.f1.nmamtr.focus();
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
        			url: "../guru/fungsi_khusus/R1D01A_kls.php",
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
	//untuk R1D01A g_gnrmtr
	$(".kdeklm").change(function()
	{
         var kdemtr = $("#kdemtr").val();
         var kdegru = $("#kdegru").val();
         var kdeklm = $("#kdeklm").val();
         var kdeplj = $("#kdeplj").val();
         var edit = $("#edt").val();
         var dataString = 'kdemtr='+ kdemtr+ '&kdeklm='+ kdeklm + '&kdeplj=' + kdeplj+ '&kdegru=' + kdegru+ '&pilihan=' + edit ;

        if(kdeplj=='')
        {
			alert('nama Materi Pelajaran tidak boleh kosong')
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
				url: "guru.php?mode=R1D01A_Save",
				data: dataString,
				success: function(data)
				{
                    $.ajax(
		{

            url: "../guru/fungsi_khusus/R1D01A_kdemtr.php",
			data: dataString,
			cache: false,
			success: function(msg)
			{
				//jika data sukses diambil dari server kita tampilkan
				$('#kdemtr').val(msg);
                    document.f1.kdeplj.disabled=true;
					document.f1.kdeklm.disabled=true;
					document.f1.nmamtr.disabled=false;
					document.f1.pdf.disabled=false;
					document.f1.inpt.disabled=false;
					document.f1.nmamtr.focus();
			}
		})
					$('#materi').load("../guru/fungsi_khusus/R1D01A_materi.php?kdeklm="+kdeklm+"&kdeplj="+kdeplj+"&kdegru="+kdegru);
					
				}
			})
		}
		
	});
	return false;

	//untuk R1D01A g_dtlmtr
	$("#sub").click(function() 
	{
		var kdegru = $("#kdegru").val();
		var nmamtr = $("#nmamtr").val();
		var pdf = $(".pdf").val();
		var edit = $("#edt").val();
		var dataString = 'kdegru='+ kdegru + '&nmamtr='+nmamtr+  '&pdf='+pdf+'&pilihan=' + edit ;

		if(nmamtr=='')
		{ 
			alert('nama Materi Pelajaran tidak boleh kosongss')
		}
		else
		{
			$.ajax(
			{
				type: "POST",
				url: "guru.php?mode=R1D01A_SaveD",
				data: dataString,
				success: function()
				{
					document.f1.kdeplj.disabled=true;
					document.f1.kdekls.disabled=true;
					document.f1.nmamtr.focus();
					document.f1.nmamtr.value='';
					document.f1.nmamtr.value=pdf;
				}
			});
		}
		return false;
	});




});