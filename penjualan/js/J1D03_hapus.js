$(function() 
{
	//bmb//
	$(".hapusm").click(function()
	{
		//Save the link in a variable called element
		var element = $(this);
		var kdebr = element.attr("id");
		var bny = element.attr("bny");
		var nmrbmb = $("#nmrbmb").val();
		var info = 'id=' + kdebr+ '&bny=' + bny;
		if(confirm("Apakah anda ingin hapus data ini!"))
		{
			$.ajax(
			{
				type: "GET",
				url: "../penjualan/fungsi_khusus/J1D03_hapusbmb.php",
				data: info,
				success: function()
				{
					document.f1.nmabrn.value='';
					document.f1.nmabrn.focus();
					$('#stok').load("../penjualan/fungsi_khusus/J1D03_masuk_barang.php?nmrbmb="+nmrbmb);
				}
			});

			$(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
			.animate({ opacity: "hide" }, "slow");
		}
		return false;
	});
});