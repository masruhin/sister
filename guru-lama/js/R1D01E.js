$(function()
{   //Disable/Enable
    //untuk R1D01E g_dtltgs
		$(".stt1").click(function()
	{
		var element = $(this);
		var id = element.attr("id");
        var stt = element.attr("stt");
		var info = 'id=' +id+'&stt1='+stt;
		//var kdegru = $("#kdegru").val();
        var kdetgs = $("#kdetgs").val();
        //var nmatgs = $("#nmatgs2").val();
		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D01E_Update.php",
				data: info,
				success: function(msg)
				{
					window.location.href='guru.php?mode=R1D01E&kdetgs='+kdetgs+'&pilihan=tambah_item';
                    document.f1.nmatgs.focus();
				}
			});

			$(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
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
        			url: "../guru/fungsi_khusus/R1D01E_kls.php",
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
	//untuk R1D01E g_gnrtgs
	$(".kdeklm").change(function()
	{
         var kdetgs = $("#kdetgs").val();
         var kdegru = $("#kdegru").val();
         var kdeklm = $("#kdeklm").val();
         var kdeplj = $("#kdeplj").val();
         var edit = $("#edt").val();
         var dataString = 'kdetgs='+ kdetgs+ '&kdeklm='+ kdeklm + '&kdeplj=' + kdeplj+ '&kdegru=' + kdegru+ '&pilihan=' + edit ;

        if(kdeplj=='')
        {
			alert('nama Tugas tidak boleh kosong')
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
				url: "guru.php?mode=R1D01E_Save",
				data: dataString,
				success: function(data)
				{

					$('#tugas').load("../guru/fungsi_khusus/R1D01E_tugas.php?kdeklm="+kdeklm+"&kdeplj="+kdeplj+"&kdegru="+kdegru);
				}
			})
		}

        $.ajax(
		{

            url: "../guru/fungsi_khusus/R1D01E_kdetgs.php",
			data: dataString,
			cache: false,
			success: function(msg)
			{
				//jika data sukses diambil dari server kita tampilkan
				$('#kdetgs').val(msg);
                    document.f1.kdeplj.disabled=true;
					document.f1.kdeklm.disabled=true;
					document.f1.nmatgs.focus();
			}
		})
	});
	return false;

	//untuk R1D01E g_dtltgs
	$("#sub").click(function() 
	{
		var kdegru = $("#kdegru").val();
		var nmatgs = $("#nmatgs").val();
		var pdf = $(".pdf").val();
		var edit = $("#edt").val();
		var dataString = 'kdegru='+ kdegru + '&nmatgs='+nmatgs+  '&pdf='+pdf+'&pilihan=' + edit ;

		if(nmatgs=='')
		{ 
			alert('nama Tugas tidak boleh kosong')
		}
		else
		{
			$.ajax(
			{
				type: "POST",
				url: "guru.php?mode=R1D01E_SaveD",
				data: dataString,
				success: function()
				{
					document.f1.kdeplj.disabled=true;
					document.f1.kdekls.disabled=true;
					document.f1.nmatgs.focus();
					document.f1.nmatgs.value='';
					document.f1.nmatgs.value=pdf;
				}
			});
		}
		return false;
	});




});