$(function()
{
	//validasi status penerimaan
	$("#kdejtu").change(function()
	{

        var kdejtu = $("#kdejtu").val();
        var dataString ='kdejtu='+kdejtu;
		$.ajax(
    	{
			type: "GET",
            url: "../keuangan/fungsi_khusus/K1D03_stt.php?kdejtu="+kdejtu,
            data: dataString,
        	cache: false,
        	success: function()
			{
            	//jika data sukses diambil dari server kita tampilkan
				$('#dri').load("../keuangan/fungsi_khusus/K1D03_stt.php?kdejtu="+kdejtu);
                document.f1.dp1.hidden=true;
                document.f1.dr.focus();
                document.f1.tglbtu.value='';
               

        	}
            })
		return false;


	})
     //validasi nis
	$("#tglbtu").change(function()
    {
       var dro = $("#dr").val();
        var dataString ='dr='+dro;
		$.ajax(
    	{
			type: "GET",
            url: "../keuangan/fungsi_khusus/K1D03_dr.php?dr="+dro,
            data: dataString,
        	cache: false,
        	success: function(msg)
			{
            	//jika data sukses diambil dari server kita tampilkan

				$('#nis').val(msg);
                document.f1.nli.focus();
                //document.f1.niss.value=dro;


        	}
            })

		$.ajax(
    	{
			type: "GET",
            url: "../keuangan/fungsi_khusus/K1D03_uskl.php?dr="+dro,
            data: dataString,
        	cache: false,
        	success: function(msg)
			{
            	//jika data sukses diambil dari server kita tampilkan
				$('#nli').val(msg);

                //document.f1.niss.value=dro;



        	}
            })
		return false;


	})

  //validasi nis
	$("#dr").change(function()
    {
        document.f1.tglbtu.value='';
        document.f1.nli.value='';
            })

    $("#nli").mousemove(function()
    {
         var kdejtu = $("#kdejtu").val();
         var nis = $("#nis").val();
        var dataString ='kdejtu='+kdejtu+'&nis='+nis;

     $.ajax(
    	{
			type: "GET",
            url: "../keuangan/fungsi_khusus/K1D03_validasi_kdejtu.php?kdejtu="+kdejtu+"&nis="+nis,
            data: dataString,
        	cache: false,
        	success: function(msg)
			{
            	//jika data sukses diambil dari server kita tampilkan

				$('#code').val(msg);
                

                //document.f1.niss.value=dro;


        	}
            })
     })

     $("#nli").keypress(function()
    {
         var kdejtu = $("#kdejtu").val();
         var nis = $("#nis").val();
        var dataString ='kdejtu='+kdejtu+'&nis='+nis;

     $.ajax(
    	{
			type: "GET",
            url: "../keuangan/fungsi_khusus/K1D03_validasi_kdejtu.php?kdejtu="+kdejtu+"&nis="+nis,
            data: dataString,
        	cache: false,
        	success: function(msg)
			{
            	//jika data sukses diambil dari server kita tampilkan

				$('#code').val(msg);


                //document.f1.niss.value=dro;


        	}
            })
     })

});