$(function() 
{
	//untuk bukti keluar barang
	$(".utk").blur(function() 
	{
		var nmrbkb = $("#nmrbkb").val();
		var nmrbkbB = $("#nmrbkbB").val();
		var tglbkb = $("#tglbkb").val();
		var tglbkb1 = $("#tglbkb1").val();
		var prd = $("#prd").val();
		var utk = $("#utk").val();
		var edit = $("#edt").val();
		var dataString = 'nmrbkb='+ nmrbkb + '&nmrbkbB='+ nmrbkbB + '&tglbkb=' + tglbkb +'&tglbkb1=' + tglbkb1 + '&prd=' + prd + '&utk=' + utk+ '&pilihan=' + edit;

		if(utk=='')
		{ 
			alert('Isian tidak boleh kosong')
		}
		else
		if(tglbkb1!=prd)
		{ 
			alert('Periode tidak sama')
			document.f1.tglbkb.focus();
		}
		else
		{
			$.ajax(
			{
				type: "POST",
				url: "penjualan.php?mode=J1D04_Save",
				data: dataString,
				success: function()
				{
					document.f1.tglbkb.disabled=true;
					document.f1.utk.disabled=true;
					document.f1.nmabrn.disabled=false;
					document.f1.nmabrn.focus();
					$('.error').fadeOut(200).hide();
				}
			});
		}
		return false;
	});

	$("#submit").click(function() 
	{
		var nmrbkb = $("#nmrbkb").val();
		var kdebrn = $("#nmabrn_hidden").val();
		var utk = $("#utk").val();
		var cst = $("#cst").val();
		var cst1 = $("#cst1").val();
		var ck='Stok Tidak Mencukupi, Sisa Stok';
		var csk= ck + ' = ' + cst;
		var bny = $("#bny").val();
		var dataString = 'nmrbkb='+ nmrbkb + '&kdebrn=' + kdebrn + '&bny=' + bny;

		if(utk=='')
		{ 
			alert('form untuk belum diisi');
			document.f1.utk.focus();
		}
		else
		if(cst1<'0')
		{
			alert(csk);
			document.f1.nmabrn.focus();
			document.f1.nmabrn.value='';
			document.f1.bny.value='';
		}
		else
		{
			$.ajax(
			{
				type: "POST",
				url: "penjualan.php?mode=J1D04_Save_Item",
				data: dataString,
				success: function()
				{
					document.f1.nmrbkb.value;
					document.f1.tglbkb.disabled=true;
					document.f1.utk.disabled=true;
					document.f1.nmabrn.disabled=false;
					document.f1.nmabrn.focus();
					document.f1.nmabrn.value='';
					document.f1.bny.value='';
					$('#stok').load("../penjualan/fungsi_khusus/J1D04_keluar-barang.php?nmrbkb="+nmrbkb);

					$('.error').fadeOut(200).hide();
				}
			});
		}
		return false;
	});
});