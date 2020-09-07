$(function() 
{
	//Untuk Penjualan //
	$(".nmabrn").change(function() 
	{
		var nmrpnj = $("#nmrpnj").val();
		var nmrpnjB = $("#nmrpnjB").val();
		var tglpnj = $("#tglpnj").val();
		var tglpnj1 = $("#tglpnj1").val();
		var prd = $("#prd").val();
		var edit = $("#edt").val();
		var dataString = 'nmrpnj='+ nmrpnj + '&nmrpnjB='+ nmrpnjB+'&tglpnj=' + tglpnj +'&tglpnj1=' + tglpnj1 + '&prd=' + prd + '&pilihan=' + edit;

		if(tglpnj==''||nmrpnj=='')
		{ 
			alert('Isian tidak boleh kosong')
		}
		else
		if(tglpnj1!=prd)
		{ 
			alert('Periode tidak sama3')
			document.f1.tglpnj.focus();
			return false;
		}
		else
		{
			$.ajax(
			{
				type: "POST",
				url: "penjualan.php?mode=J1D05_Save",
				data: dataString,
				success: function()
				{
					document.f1.tglpnj.disabled=true;
					document.f1.nmabrn.disabled=false;
					document.f1.bny.focus();
					$('.error').fadeOut(200).hide();
				}
			});
		}
		return false;
	});

	$("#submitp").click(function() 
	{
		var nmrpnj = $("#nmrpnj").val();
		var nmrpnjB = $("#nmrpnjB").val();
		var kdebrn = $("#nmabrn_hidden").val();
		var hrg = $("#hrg").val();
		var cst = $("#cst").val();
		var cst1 = $("#cst1").val();
		var ck='Stok Tidak Mencukupi, Sisa Stok';
		var csk= ck + ' = ' + cst;
		var bny = $("#bny").val();
		var dataString = 'nmrpnj='+ nmrpnj +'&kdebrn=' + kdebrn +'&hrg=' + hrg + '&bny=' + bny;

		if(tglpnj=='')
		{ 
			alert('form untuk belum diisi');
			document.f1.tglpnj.focus();
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
				url: "penjualan.php?mode=J1D05_Save_Item",
				data: dataString,
				success: function()
				{
					document.f1.nmrpnj.value;
					document.f1.tglpnj.disabled=true;
					document.f1.nmabrn.disabled=false;
					document.f1.nmabrn.focus();
					document.f1.nmabrn.value='';
					document.f1.bny.value='';
					$('#stok').load('../penjualan/fungsi_khusus/J1D05_penjualan.php?nmrpnj='+nmrpnj);
					$('#total').load('../penjualan/fungsi_khusus/J1D05_totalpenjualan.php?nmrpnj='+nmrpnj);

					$('.error').fadeOut(200).hide();
				}
			});
		}
		return false;
	});
});