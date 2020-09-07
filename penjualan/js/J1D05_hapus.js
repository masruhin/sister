$(function() 
{
	//penjualan//
	$(".hapus1").click(function()
	{
		//Save the link in a variable called element
		var element = $(this);
		var id = element.attr("id");
		var bny = element.attr("bny");
		var nmrpnj = $("#nmrpnj").val();
		var info = 'id=' + id+ '&bny=' + bny;
		if(confirm("Apakah anda ingin hapus data Penjualan ini!"))
		{
			$.ajax(
			{
				type: "GET",
				url: "../penjualan/fungsi_khusus/J1D05_hapuspnj.php",
				data: info,
				success: function()
				{
					document.f1.nmabrn.value='';
					document.f1.nmabrn.focus();
					$('#stok').load("../penjualan/fungsi_khusus/J1D05_penjualan.php?nmrpnj="+nmrpnj);
					$('#total').load("../penjualan/fungsi_khusus/J1D05_totalpenjualan.php?nmrpnj="+nmrpnj);
				}
			});

			$(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
			.animate({ opacity: "hide" }, "slow");
		}
		return false;
	});
});