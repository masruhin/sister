$(function()
{
	$(".hapusmtr").click(function()
	{
		var element = $(this);
		var materi = element.attr("id");
		var info = 'id=' + materi;
		var kdemtr = $("#kdemtr").val();
		var nmamtr = $("#nmamtr").val();
		if(confirm("Apakah anda ingin hapus data ini!"))
		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D01A_hapusmateri.php?kdemtr="+kdemtr+"&nmamtr="+nmamtr,
				data: info,
				success: function()
				{
					window.location.href='guru.php?mode=R1D01A&kdemtr='+kdemtr+'&pilihan=tambah_item';
				}
			});

			$(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
		}
		return false;
	});
});