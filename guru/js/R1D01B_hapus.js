$(function() 
{
	//Hapus SOal//
	$(".hapussl").click(function()
	{
		//Save the link in a variable called element
		var element = $(this);
		var soal = element.attr("id");
		var kdes = element.attr("kdes");
		var info = 'id=' + soal+'&kdesl='+kdes;
		var kdesl = $("#kdesl").val();
		if(confirm("Apakah anda ingin hapus data ini!"))
		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D01B_hapussoal.php?kdesl="+kdes,
				data: info,
				success: function()
				{
					$('#soal2').load("../guru/fungsi_khusus/R1D01B_soal2.php?kdesl="+kdesl);
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