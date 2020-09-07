$(function() 
{
	//Hapus SOal//
	$(".hapussl").click(function()
	{
		//Save the link in a variable called element
		var element = $(this);
		var soal = element.attr("id");
		var info = 'id=' + soal;
		var kdesl = $("#kdesl").val();
		if(confirm("Apakah anda ingin hapus data ini!"))
		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D01B_hapussoal.php",
				data: info,
				success: function()
				{
					$('#soal2').load("../guru/fungsi_khusus/R1D01B_soal2.php?kdesl="+kdesl);
					document.f1.soal.value='';
					document.f1.jwb1.value='';
					document.f1.jwb2.value='';
					document.f1.jwb3.value='';
					document.f1.jwb4.value='';
					document.f1.jwb5.value='';
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