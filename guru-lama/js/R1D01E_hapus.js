$(function()
{
	$(".hapustgs").click(function()
	{
		var element = $(this);
		var tugas = element.attr("id");
		var info = 'id=' + tugas;
		var kdetgs = $("#kdetgs").val();
		var nmatgs = $("#nmatgs").val();
		if(confirm("Apakah anda ingin hapus data ini!"))
		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D01E_hapustugas.php?kdetgs="+kdetgs+"&nmatgs="+nmatgs,
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