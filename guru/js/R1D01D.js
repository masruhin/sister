//untuk R1D01D g_gnrnli
$(function() 
{   $(".kdekls").change(function()
			{
	    		var kdekls = $("#kdekls").val();
                var kdegru = $("#kdegru").val();
                var dataString = 'kdegru='+ kdegru + '&kdekls='+kdekls;
    			$.ajax(
    			{
        			url: "../guru/fungsi_khusus/R1D01D_plj.php",
        			data: dataString,
    	    		success: function(msg)
        			{
            			//jika data sukses diambil dari server kita tampilkan
            			//di <select id=kdecls>
                        document.f1.kdeplj.disabled=false;
            			$("#kdeplj").html(msg);

	        		}
    			})

                        });




  $("#edit").click(function()
	{
	                 document.f1.kdebbt.disabled=false;
					document.f1.tglujn.disabled=false;
					document.f1.ktr1.disabled=false;
                    document.f1.update.disabled=false;
                    document.f1.edit.hidden=true;
                    document.f1.update.hidden=false;
	})
    $("#update").click(function()
	{
        var kdenli 	= $("#kdenli").val();
        var kdebbt 	= $("#kdebbt").val();
		var tglujn 	= $("#tglujn").val();
		var ktr 	= $("#ktr1").val();
        var pilihan = $("#edt").val();
        var dataString = 'kdenli='+ kdenli +'&kdebbt='+ kdebbt+'&tglujn='+ tglujn+'&ktr1='+ ktr+'&pilihan='+pilihan;

        $.ajax(
			{
				type: "POST",
				url: "guru.php?mode=R1D01D_Update",
				data: dataString,
				success: function(data)
				{
					window.location.href='guru.php?mode=R1D01D&kdenli='+kdenli+'&pilihan=detil_general';
				}
			})
	})


    $(".ktr").change(function()
	{
		var kdenli 	= $("#kdenli").val();
		var kdegru 	= $("#kdegru").val();
		var kdekls 	= $("#kdekls").val();
		var kdeplj 	= $("#kdeplj").val();
		var kdebbt 	= $("#kdebbt").val();
		var tglujn 	= $("#tglujn").val();
		var ktr 	= $("#ktr").val();
		var edit 	= $("#edt").val();
		var dataString = 'kdegru='+ kdegru + '&kdenli='+ kdenli+ '&kdekls='+ kdekls + '&kdeplj=' + kdeplj+ '&kdebbt=' + kdebbt+ '&tglujn=' + tglujn+ '&ktr=' + ktr+ '&pilihan=' + edit ;

		if(kdeplj=='')
		{
			alert('nama Materi Pelajaran tidak boleh kosong')
		}
		else
		if(kdekls=='')
		{
			alert('nama kelas tidak boleh kosong')
		}
		else
		{
			$.ajax(
			{
				type: "POST",
				url: "guru.php?mode=R1D01D_Save",
				data: dataString,
				success: function(data)
				{
					document.f1.kdeplj.disabled=true;
					document.f1.kdekls.disabled=true;
					document.f1.kdebbt.disabled=true;
					document.f1.tglujn.disabled=true;
					document.f1.ktr.disabled=true;
					document.f1.kdekls1.value=kdekls;
					window.location.href='guru.php?mode=R1D01D&kdenli='+kdenli+'&pilihan=input_nilai';
				}
			})
		}
	});
	return false;





});