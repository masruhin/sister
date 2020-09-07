$(function() 
{
	$(".blnab").change(function() 
	{
		var nis = $("#nis").val();
		var thnabs = $("#thnabs").val();
		var blnab = $("#blnab").val();

		if(blnabs!='')
		{
			document.f1.blnabs.value=blnab;
			document.f1.blnab.disabled=true;
			document.f1.thnabs.disabled=false;
		}
	})

	$(".thnabs").change(function() 
	{
		var nis = $("#nis").val();
		var thnabs = $("#thnabs").val();
		var blnab = $("#blnab").val();
		var blnabs = $("#blnabs").val();

		if(thnabs!='')
		{
			$('#hadir').load("../siswa/fungsi_khusus/S1D03_absen.php?nis="+nis+"&thnabs="+thnabs+"&blnabs="+blnabs);
			document.f1.thnabs.disabled=true;
		}
	});
	
	$("#ulang").click(function() 
	{
		window.location.href='siswa.php?mode=S1D03';
	});
});