$(function()
{
	$(".kdekls").change(function()
	{
		var kdeplj = $("#kdeplj").val();
		var kdekls = $("#kdekls").val();

		if(kdekls!='')
		{
			$('#nma').load("../guru/fungsi_khusus/R1D02D_nama.php?kdekls="+kdekls);
			$('#kehadiran,#nilai,#pelajaran').html('');
		}
	});

	$("#nmassw").change(function()
	{

		var kdekls = $("#kdekls").val();
		var nmassw = $("#nmassw").val();

		if(nmassw!='')
		{
			$('#nma').load("../guru/fungsi_khusus/R1D02D_nama1.php?nmassw="+nmassw+"&kdekls="+kdekls);

		}
        if(nmassw=='')
		{
			$('#nma').load("../guru/fungsi_khusus/R1D02D_nama.php?kdekls="+kdekls);


		}
	});
    	$("#all").click(function()
	{

		var kdekls = $("#kdekls").val();
		var nmassw = $("#nmassw").val();
          {

			$('#nma').load("../guru/fungsi_khusus/R1D02D_nama.php?kdekls="+kdekls);
            document.f1.nmassw.value='';
           }

	});

	//untuk lihat detil nilai siswa
    $(".nilai").click(function()
	{
		var element 	= $(this);
		var nis 		= element.attr("id");
        var nmassw 		= element.attr("nmasw");
		var dataString 	= 'nis=' + nis;

		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D02D_hasil_test.php",
				data: dataString,
				success: function()
				{
					$('#nilai').load("../guru/fungsi_khusus/R1D02D_hasil_test.php?nis="+nis);
                    $('#kehadiran,#bayar').html('');
				}
			});
		}
		return false;
	});
    // end detil nilai siswa//
    //untuk lihat detil nilai siswa
    $(".kehadiran").click(function()
	{
		var element 	= $(this);
		var nis 		= element.attr("id");
        var nmassw 		= element.attr("nmasw");
		var dataString 	= 'nis=' + nis;

		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D02D_absen.php",
				data: dataString,
				success: function()
				{
					$('#kehadiran').load("../guru/fungsi_khusus/R1D02D_absen.php?nis="+nis);
                    $('#nilai,#bayar').html('');
				}
			});
		}
		return false;
	});
    // end detil nilai siswa//
	//untuk lihat detil nilai siswa
    $(".bayar").click(function()
	{
		var element 	= $(this);
		var nis 		= element.attr("id");
        var nmassw 		= element.attr("nmasw");
		var dataString 	= 'nis=' + nis;

		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D02D_bayar.php",
				data: dataString,
				success: function()
				{
					$('#bayar').load("../guru/fungsi_khusus/R1D02D_bayar.php?nis="+nis);
                    $('#nilai,#kehadiran').html('');
				}
			});
		}
		return false;
	});
    // end detil bayar siswa//
});