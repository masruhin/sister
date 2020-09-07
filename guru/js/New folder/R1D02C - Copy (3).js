$(function()
{
	
	
	//untuk lihat detil nilai siswa
    $(".materi").click(function()
	{
		var element 	= $(this);
		var kdekry 		= element.attr("id");
        //var nmassw 		= element.attr("nmasw");
		var dataString 	= 'kdekry=' + kdekry;

		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D02C_materi.php",
				data: dataString,
				success: function()
				{
					$('#materi').load("../guru/fungsi_khusus/R1D02C_materi.php?kdekry="+kdekry);
                    $('#tugas,#absensi,#rpp,#aktivitas').html('');//,#aktivitas
                   
				}
			});
		}
		return false;
	});
    // end detil nilai siswa//
	
	//untuk lihat detil nilai siswa
    $(".tugas").click(function()
	{
		var element 	= $(this);
		var kdekry 		= element.attr("id");
        //var nmassw 		= element.attr("nmasw");
		var dataString 	= 'kdekry=' + kdekry;

		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D02C_tugas.php",
				data: dataString,
				success: function()
				{
					$('#tugas').load("../guru/fungsi_khusus/R1D02C_tugas.php?kdekry="+kdekry);
                    $('#materi,#absensi,#rpp,#aktivitas').html('');//,#aktivitas
                   
				}
			});
		}
		return false;
	});
    // end detil nilai siswa//
	
    //untuk lihat detil absen guru
    $(".absensi").click(function()
	{
		var element 	= $(this);
		var kdekry 		= element.attr("id");
        //var nmassw 		= element.attr("nmasw");
		var dataString 	= 'kdekry=' + kdekry;

		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D02C_absen.php",
				data: dataString,
				success: function()
				{
					$('#absensi').load("../guru/fungsi_khusus/R1D02C_absen.php?kdekry="+kdekry);
                    $('#materi,#tugas,#rpp,#aktivitas').html('');//,#aktivitas

				}
			});
		}
		return false;
	});
    // end detil absen guru//

    //untuk lihat detil aktivitas guru
    /*$(".aktivitas").click(function()
	{
		var element 	= $(this);
		var kdekry 		= element.attr("id");
        //var nmassw 		= element.attr("nmasw");
		var dataString 	= 'kdekry=' + kdekry;

		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D02C_aktivitas.php",
				data: dataString,
				success: function()
				{
					$('#aktivitas').load("../guru/fungsi_khusus/R1D02C_aktivitas.php?kdekry="+kdekry);
                    $('#materi,#tugas,#absensi,#rpp').html('');

				}
			});
		}
		return false;
	});*/
    // end detil aktivitas guru//
	
	//untuk lihat detil nilai siswa
    $(".rpp").click(function()
	{
		var element 	= $(this);
		var kdekry 		= element.attr("id");
        //var nmassw 		= element.attr("nmasw");
		var dataString 	= 'kdekry=' + kdekry;

		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D02C_rpp.php",
				data: dataString,
				success: function()
				{
					$('#rpp').load("../guru/fungsi_khusus/R1D02C_rpp.php?kdekry="+kdekry);
                    $('#materi,#tugas,#absensi,#aktivitas').html('');//,#aktivitas
                   
				}
			});
		}
		return false;
	});
    // end detil nilai siswa//
	
	//untuk lihat detil nilai siswa
     $(".aktivitas").click(function()
	{
		var element 	= $(this);
		var kdekry 		= element.attr("id");
        //var nmassw 		= element.attr("nmasw");
		var dataString 	= 'kdekry=' + kdekry;

		{
			$.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D02C_aktivitas.php",
				data: dataString,
				success: function()
				{
					$('#aktivitas').load("../guru/fungsi_khusus/R1D02C_aktivitas.php?kdekry="+kdekry);
                    $('#materi,#tugas,#absensi,#rpp').html('');

				}
			});
		}
		return false;
	});
    // end detil nilai siswa//
	
	

});