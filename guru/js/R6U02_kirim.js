$(function()
{
	//untuk lihat detil kirim email
    $("#kirim").click(function()
	{
		var kdekrm = $("#kdekrm").val();
		var kdekry = $("#kdekry").val();
		var utk = $("#utk").val();
		var sbj = $("#sbj").val();
		var ktr = $("#isi").val();
		var id = $("#id").val();
		var atch = $("#atch").val();
        
		var dataString 	= 'id='+id+'&kdekrm='+ kdekrm + '&kdekry='+ kdekry + '&utk=' + utk +'&sbj=' + sbj + '&isi=' + ktr+'&atch='+atch ;

		{
			$.ajax(
			{
				type: "POST",
				url: "../guru/fungsi_khusus/R6U02_save.php",
				data: dataString,
				success: function()
				{   
				    document.f1.kdekry.value='';
					document.f1.utk.value='';
					document.f1.sbj.value='';
					document.f1.isi.value='';
					alert("Your message has been sent.");
				    window.location.href='guru.php?mode=R6U02';
                    $('#inbox,#kirim_pesan,#balas,#del').html('');
					
				}
			});
		}
		return false;
	});
	
});