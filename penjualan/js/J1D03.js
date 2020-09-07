$(function() 
{
	//untuk bukti masuk barang
	$(".rfr").blur(function() 
	{
		var nmrbmb = $("#nmrbmb").val();
		var nmrbmbB = $("#nmrbmbB").val();
		var tglbmb = $("#tglbmb").val();
		var tglbmb1 = $("#tglbmb1").val();
		var prd = $("#prd").val();
		var dr = $("#dr").val();
		var rfr = $("#rfr").val();
		var edit = $("#edt").val();
		var dataString = 'nmrbmb='+ nmrbmb + '&nmrbmbB='+ nmrbmbB + '&tglbmb=' + tglbmb +'&tglbmb1=' + tglbmb1 + '&prd=' + prd + '&dr=' + dr+ '&rfr=' + rfr+ '&pilihan=' + edit;

		if(dr==''||rfr=='')
		{ 
			alert('Isian tidak boleh kosong')
		}
		else
		if(tglbmb1!=prd)
		{ 
			alert('Periode tidak sama2')
			document.f1.tglbmb.focus();
		}
		else
		{
			$.ajax(
			{
				type: "POST",
				url: "penjualan.php?mode=J1D03_Save",
				data: dataString,
				success: function()
				{
					document.f1.tglbmb.disabled=true;
					document.f1.dr.disabled=true;
					document.f1.rfr.disabled=true;
					document.f1.nmabrn.disabled=false;
					document.f1.nmabrn.focus();
					$('.error').fadeOut(200).hide();
				}
			});
		}
		return false;
	});

	$("#submitk").click(function() 
	{
		var nmrbmb = $("#nmrbmb").val();
		var kdebrn = $("#nmabrn_hidden").val();
		var utk = $("#utk").val();
		var cst = $("#cst").val();
		var cst1 = $("#cst1").val();
		var ck='Stok Tidak Mencukupi, Sisa Stok';
		var csk= ck + ' = ' + cst;
		var bny = $("#bny").val();
		var pilihan = $("#edt").val();
		var dataString = 'nmrbmb='+ nmrbmb + '&kdebrn=' + kdebrn + '&bny=' + bny;

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
				url: "penjualan.php?mode=J1D03_Save_Item",
				data: dataString,
				success: function()
				{
					document.f1.nmrbmb.value;
					document.f1.tglbmb.disabled=true;
					document.f1.dr.disabled=true;
					document.f1.rfr.disabled=true;
					document.f1.nmabrn.disabled=false;
					document.f1.nmabrn.focus();
					document.f1.nmabrn.value='';
					document.f1.bny.value='';
					$('#stok').load("../penjualan/fungsi_khusus/J1D03_masuk_barang.php?nmrbmb="+nmrbmb);
					$('.error').fadeOut(200).hide();
				}
			});
		}
		return false;
	});
});