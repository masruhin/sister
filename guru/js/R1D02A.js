$(function()
{
	
	
    $(".kdeklm").change(function()
	{
		var kdeklm = $("#kdeklm").val();
		//var kdetkt = $("#kdetkt").val();

		if(kdeklm!='')
		{
			$('#plj').load("../guru/fungsi_khusus/R1D02A_plj.php?kdeklm="+kdeklm);//+"&kdetkt="+kdetkt
			//$('#modul1,#tugas1').html('');
			$('#krk1,#modul1,#tugas1,#rpp1').html('');
		}
	});
	
	//untuk lihat detil krk
    
	$(".krk").click(function()
	{
		var element 	= $(this);
		var kdeklm 		= element.attr("id");
        var kdeplj 		= element.attr("kdeplj");
		var dataString 	= 'kdeklm=' + kdeklm+'&kdeplj='+kdeplj;

		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D02A_krk.php",
				data: dataString,
				success: function()
				{
					$('#krk1').load("../guru/fungsi_khusus/R1D02A_krk.php?kdeklm="+kdeklm+"&kdeplj="+kdeplj);
					//$('#modul1').html('');
					$('#modul1,#tugas1,#rpp1').html('');
				}
			});
		}
		return false;
	});
	
    // end detil krk//

   //untuk lihat detil materi
    $(".mtr").click(function()
	{
		var element 	= $(this);
		var kdeklm 		= element.attr("id");
        var kdeplj 		= element.attr("kdeplj");
		var dataString 	= 'kdeklm=' + kdeklm+'&kdeplj='+kdeplj;

		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D02A_materi.php",
				data: dataString,
				success: function()
				{
					$('#modul1').load("../guru/fungsi_khusus/R1D02A_materi.php?kdeklm="+kdeklm+"&kdeplj="+kdeplj);
					//$('#tugas1').html('');
					$('#krk1,#tugas1,#rpp1').html('');
				}
			});
		}
		return false;
	});
    // end detil materi//

   //untuk lihat detil tugas
    $(".tgs").click(function()
	{
		var element 	= $(this);
		var kdeklm 		= element.attr("id");
        var kdeplj 		= element.attr("kdeplj");
		var dataString 	= 'kdeklm=' + kdeklm;

		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D02A_tugas.php",
				data: dataString,
				success: function()
				{
					$('#tugas1').load("../guru/fungsi_khusus/R1D02A_tugas.php?kdeklm="+kdeklm+"&kdeplj="+kdeplj);
					//$('#modul1').html('');
					$('#krk1,#modul1,#rpp1').html('');
				}
			});
		}
		return false;
	});
    // end detil tugas//
	
	//untuk lihat detil rpp
    
	$(".rpp").click(function()
	{
		var element 	= $(this);
		var kdeklm 		= element.attr("id");
        var kdeplj 		= element.attr("kdeplj");
		var dataString 	= 'kdeklm=' + kdeklm+'&kdeplj='+kdeplj;

		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D02A_rpp.php",
				data: dataString,
				success: function()
				{
					$('#rpp1').load("../guru/fungsi_khusus/R1D02A_rpp.php?kdeklm="+kdeklm+"&kdeplj="+kdeplj);
					//$('#modul1').html('');
					$('#modul1,#tugas1').html('');
				}
			});
		}
		return false;
	});
	
    // end detil rpp//
	
	
	
	

});