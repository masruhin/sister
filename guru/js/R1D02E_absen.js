$(function()
{
	$(".blnab").change(function() 
	{
		var kdekry = $("#kdekry").val();
		var thnabs = $("#thnabs").val();
		var blnab = $("#blnab").val();

		if(blnabs!='')
		{

            document.f1.blnabs.value=blnab
            $('#absn').load("../guru/fungsi_khusus/R1D02E_absen1.php?kdekry="+kdekry+"&thnabs="+thnabs+"&blnab="+blnab);

		}
	})

	$(".thnabs").change(function() 
	{
		var kdekry = $("#kdekry").val();
		var thnabs = $("#thnabs").val();
		var blnab = $("#blnab").val();
		var blnabs = $("#blnabs").val();

		if(thnabs!='')
		{
			$('#absn').load("../guru/fungsi_khusus/R1D02E_absen1.php?kdekry="+kdekry+"&thnabs="+thnabs+"&blnab="+blnab);

		}
	});
	
	
});