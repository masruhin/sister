$(function()
{
	$(".hapusmtr").click(function()
	{
		var element = $(this);
		var materi = element.attr("id");
		var typ = element.attr("typ");
		var nmamtr = element.attr("nmamt");
		var info = 'id=' + materi+'&type='+typ+'&nmamtr='+nmamtr;
		var kdemtr = $("#kdemtr").val();
		if(confirm("Apakah anda ingin hapus data ini!"))
		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D01GQ3_hapusmateri.php?kdemtr="+kdemtr,
				data: info,
				success: function()
				{
					window.location.href='guru.php?mode=R1D01GQ3&kdemtr='+kdemtr+'&pilihan=tambah_item';
				}
			});

			$(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
		}
		return false;
	});
});