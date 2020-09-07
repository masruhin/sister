$(function()
{
	$(".blnab").change(function() 
	{
		var nis = $("#nis").val();
		var thnabs = $("#thnabs").val();
		var blnab = $("#blnab").val();

		if(blnabs!='')
		{

            document.f1.blnabs.value=blnab
            $('#absn').load("../guru/fungsi_khusus/R1D02D_absen1.php?nis="+nis+"&thnabs="+thnabs+"&blnab="+blnab);

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
			$('#absn').load("../guru/fungsi_khusus/R1D02D_absen1.php?nis="+nis+"&thnabs="+thnabs+"&blnab="+blnab);

		}
	});
	
	
});