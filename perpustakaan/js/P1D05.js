$(function() 
{
	//Untuk Pengembalian buku //

	$(".kdeangp").change(function() 
	{
		var kdeang = $("#kdeang").val();
		var dataString = 'kdeang=' + kdeang;

		if(kdeang=='')
		{ 
			alert('Kode Peminjam Tidak Boleh Kosong')
			document.f1.kdeang.focus();
			document.f1.kdeang.value='';
		}
		else
		if(kdeang =='')
		{ 
			alert('Periode tidak sama')
			document.f1.tglpnj.focus();
			return false;
		}
		else
		{
			$.ajax(
			{
				type: "GET",
				url: "../perpustakaan/fungsi_khusus/P1D05_pengembalian.php",
				data: dataString,
				success: function(msg)
				{
					$('#pjm1').load("../perpustakaan/fungsi_khusus/P1D05_pengembalianbk.php?kdeang="+kdeang);
					document.f1.stt.disabled=true;
					document.f1.tglpjm1.disabled=true;
					document.f1.kdeang.disabled=true;
					$("#stt").val(msg);
					document.f1.kdebku.focus();
					document.f1.kdeang1.value=kdeang;
					$('.error').fadeOut(200).hide();
				}
			})
		}

		$.ajax(
    	{
			type: "GET",
			url: "../perpustakaan/fungsi_khusus/P1D05_nmasiswa.php?kdeang="+kdeang,
			data: dataString,
        	cache: false,
        	success: function(msg)
        	{
            	//jika data sukses diambil dari server kita tampilkan
    	        $('#nmassw').val(msg);
				document.f1.nmassw.disabled=true;
        	}
		});
	});

	$(".kdebk").change(function() 
	{
		var kdebku = $("#kdebku").val();
		var tglkmb = $("#tglkmb").val();
		var kdeang = $("#kdeang1").val();
		var npj = $("#npj").val();
		var dataString = 'kdebku='+ kdebku + '&tglkmb=' + tglkmb+'&kdeang1='+kdeang+ '&npj=' + npj ;

		if(kdebku=='')
		{ 
			alert('form untuk belum diisi');
			document.f1.tglkmb.focus();
		}
		else
		{
			$.ajax(
			{
				type: "POST",
				url: "../perpustakaan/fungsi_khusus/P1D05_update.php",
				data: dataString,
				success: function()
				{
					document.f1.kdebku.focus();
					document.f1.kdebku.value='';

					$('#pjm1').load("../perpustakaan/fungsi_khusus/P1D05_pengembalianbk.php?kdeang="+kdeang);

					$('.error').fadeOut(200).hide();
				}
			});
		}
		return false;
	});

	$("#kdebku").keyup(function() 
	{
		var kdebku = $("#kdebku").val();
		var kdeang = $("#kdeang1").val();
		var tglkmb = $("#tglkmb").val();
		var dataString = 'kdebku=' + kdebku+'&kdeang='+kdeang;

		if(tglkmb2=='')
		{ 
			alert('Tanggal Kosong')
			document.f1.kdebku.focus();
			document.f1.kdebku.value='';
		}
		else
		{
			$.ajax(
			{
				type: "GET",
				url: "../perpustakaan/fungsi_khusus/P1D05_bku.php",
				data: dataString,
				success: function(msg)
				{
					$("#npj").val(msg);
				}
			});
		}
		return false;
	});
});