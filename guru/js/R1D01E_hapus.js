$(function()
{
	$(".hapustgs").click(function()
	{
		var element = $(this);
		var tugas = element.attr("id");
		var typ = element.attr("typ");
		var nmatgs = element.attr("nmatg");
		var info = 'id=' + tugas+'&type='+typ+'&nmatgs='+nmatgs;
		var kdetgs = $("#kdetgs").val();
		if(confirm("Apakah anda ingin hapus data ini!"))
		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D01E_hapustugas.php?kdetgs="+kdetgs,
				data: info,
				success: function()
				{
					window.location.href='guru.php?mode=R1D01E&kdetgs='+kdetgs+'&pilihan=tambah_item';
				}
			});

			$(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
		}
		return false;
	});
});