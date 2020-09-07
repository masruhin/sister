$(function()
{
	$(".hapusrpp").click(function()
	{
		var element = $(this);
		var materi = element.attr("id");
		var typ = element.attr("typ");
		var nmarpp = element.attr("nmamt");
		var info = 'id=' + materi+'&type='+typ+'&nmarpp='+nmarpp;
		var kderpp = $("#kderpp").val();
		if(confirm("Apakah anda ingin hapus data ini!"))
		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D01G_hapusrpp.php?kderpp="+kderpp,
				data: info,
				success: function()
				{
					window.location.href='guru.php?mode=R1D01G&kderpp='+kderpp+'&pilihan=tambah_item';
				}
			});

			$(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
		}
		return false;
	});
});