$(function() 
{
	//Untuk Peminjaman buku //
	$(".kdeang").change(function() 
	{
		var nmrpjm = $("#nmrpjm").val();
		var tglpjm = $("#tglpjm").val();
		var stt = $("#stt").val();
		var kode = $("#kode").val();
		var kdeang = $("#kdeang").val();
		var edit = $("#edt").val();
		var dataString = 'nmrpjm='+ nmrpjm + '&tglpjm='+ tglpjm +'&stt='+ stt +'&kdeang=' + kdeang+'&pilihan=' + edit;

		if(kode =='T')
		{ 
			alert('Kode Bukan Bagian dari sekolah')
			document.f1.kdeang.value='';
			return true;
		}
		else
		{
			$.ajax(
			{
				type: "POST",
				url: "perpustakaan.php?mode=P1D04_Save",
				data: dataString,
				success: function()
				{
					document.f1.tglpjm.disabled=true;
					document.f1.stt1.disabled=true;
					document.f1.kdeang.disabled=true;
					document.f1.kdeang1.value=kdeang;

					document.f1.kdebku.focus();
					$('.error').fadeOut(200).hide();
				}
			})
		}

		$.ajax(
    	{
			type: "GET",
            url: "../perpustakaan/fungsi_khusus/P1D04_nmasiswa.php?kdeang="+kdeang,
            data: dataString,
        	cache: false,
        	success: function(msg)
			{
            	//jika data sukses diambil dari server kita tampilkan
				$('#nmasw').val(msg);
				document.f1.nmasw.disabled=true;
        	}
		});
	});

	$(".kdebku").change(function() 
	{
		var nmrpjm = $("#nmrpjm").val();
		var kdebku = $("#kdebku").val();
		var kdeang = $("#kdeang1").val();
		var tglkmb = $("#tglkmb").val();
		var tglk = $("#tglk").val();
		var kbg = $("#kbg").val();
		var stt = $("#stt").val();
		var dataString = 'nmrpjm='+ nmrpjm + '&kdebku=' + kdebku+'&kdeang1='+kdeang+'&tglkmb='+tglkmb;

		if(kdebku=='')
		{ 
			alert('form  belum diisi');
			document.f1.kdeang.focus();
			document.f1.kdebku.value='';
		}
		else
		{
			$.ajax(
			{
				type: "POST",
				url: "perpustakaan.php?mode=P1D04_Save_Item",
				data: dataString,
				success: function(msg)
				{
					document.f1.kdebku.focus();
					document.f1.kdebku.value='';
					$('#kdebku').html(msg);
					$('#pjm').load("../perpustakaan/fungsi_khusus/P1D04_pinjaman.php?nmrpjm="+nmrpjm);
				}
			});
		}
		return false;
	});
});