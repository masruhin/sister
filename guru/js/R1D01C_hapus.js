$(function() 
{
	//Hapus Rencana Ujian//
	$(".hapusru").click(function()
	{
		//Save the link in a variable called element
		var element = $(this);
		var soal = element.attr("id");
		var info = 'id=' + soal;
		var kdercu = $("#kdercu").val();
		if(confirm("Apakah anda ingin hapus data ini!"))
		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D01C_hapussoal.php",
				data: info,
				success: function()
				{
					$('#rcu').load("../guru/fungsi_khusus/R1D01C_soalru.php?kdercu="+kdercu);
					document.f1.soal.value='';
					document.f1.sttjwb.value='';
					document.f1.soal1.value='';
				}
			});
			$(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
			.animate({ opacity: "hide" }, "slow");
		}
		return false;
	});
});