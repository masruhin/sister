$(function()
{
   //untuk Soal
	$(".pel").blur(function() 
	{
		var kdesl 	= $("#kdesl").val();
		var kdeslb 	= $("#kdeslB").val();
		var kdesl1	= $("#kdesl1").val();
		var kdeplj 	= $("#kdeplj").val();
		var kdegru 	= $("#kdegru").val();
		var ktr    	= $("#ktr").val();
		var pilihan = $("#edt").val();
		var dataString = 'kdegru='+ kdegru + '&kdesl=' + kdesl+ '&kdeslB=' + kdeslb +'&kdeplj=' + kdeplj + '&ktr=' + ktr+ '&pilihan=' + pilihan;
   
		{
			$.ajax(
			{
				type: "POST",
				url: "guru.php?mode=R1D01B_Save",
				data: dataString,
				success: function()
				{
				 $.ajax(
			{
				type: "GET",
				url: "../guru/fungsi_khusus/R1D01B_kdesl.php",
				data: dataString,
				success: function(msg)
				{
				    $("#kdesl,#kdesl1").val(msg);
				    document.f1.kdeplj.disabled=true;
					document.f1.ktr.disabled=true;
					document.f1.soal.focus();
					
					//$("#kdesl1").val(msg);
				}
			});	
					
				}
			});
           
		}
		
	});  
  


	$(".kdeplj").change(function() 
	 {
		document.f1.ktr.disabled=false;
		document.f1.ktr.focus();
		return false;
	 });
	

	//untuk Edit_General
	$(".pel1").blur(function() 
	{
		var kdesl 	= $("#kdesl").val();
		var kdeslb 	= $("#kdeslB").val();
		var kdesl1	= $("#kdesl1").val();
		var kdeplj 	= $("#kdeplj").val();
		var kdegru 	= $("#kdegru").val();
		var ktr     = $("#ktr").val();
		var pilihan = $("#edt").val();
		var dataString = 'kdegru='+ kdegru + '&kdesl=' + kdesl+ '&kdeslB=' + kdeslb +'&kdeplj=' + kdeplj + '&ktr=' + ktr+ '&pilihan=' + pilihan;

		if(ktr=='')
		{ 
			alert('Isian tidak boleh kosong')
		}
		else
		{
			$.ajax(
			{
				type: "POST",
				url: "guru.php?mode=R1D01B_Save",
				data: dataString,
				success: function()
				{
					document.f1.kdeplj.disabled=true;
					document.f1.ktr.disabled=true;
					document.f1.kdesl.value=kdesl1;
					window.location.href='guru.php?mode=R1D01B_Soal&kdesl='+kdesl+'&pilihan=detil_general';
					$('.error').fadeOut(200).hide();
				}
			});

		}
		return false;
	});
	



	$("#submitsl").click(function() 
	{
		var kdesl = $("#kdesl").val();
		var soal = $("#soal").val();
		var soal1 = $("#soal1").val();
		var sttjwb = $("#sttjwb").val();
		var bbtnli = $("#bbtnli").val();
		var dataString = 'kdesl='+ kdesl+'&soal=' + soal+ '&sttjwb=' + sttjwb+'&bbtnli'+bbtnli ;

		if(soal=='')
		{ 
			alert('Soal tidak boleh kosong');
			document.f1.soal1.focus();
		}
		else
		if(sttjwb=='')
		{ 
			alert('Jawaban tidak boleh kosong');
			document.f1.sttjwb.focus();
		}
		else
		{
			$.ajax(
			{
				type: "POST",
				url: "../guru/fungsi_khusus/R1D01B_save_item.php",
				data: dataString,
				success: function()
				{
					document.f1.soal.focus();
					document.f1.soal.value='';
					document.f1.sttjwb.value='';
					$('#soal2').load("../guru/fungsi_khusus/R1D01B_soal2.php?kdesl="+kdesl);
					document.f1.soal1.value='';
					$('.error').fadeOut(200).hide();
				}
			});
		}
		return false;
	});

	$("#soal1").keyup(function() 
	{
		var sol=document.f1.soal1.value;
		document.f1.soal.value=sol;
	})

	$("#submitup").click(function() 
	{
		var id = $("#id").val();
		var kdesl = $("#kdesl").val();

		var soal = $("#soal").val();
		var soal1 = $("#soal1").val();
		var sttjwb = $("#sttjwb").val();
		var dataString = 'id='+ id +'&kdesl='+ kdesl +'&soal=' + soal+ '&sttjwb=' + sttjwb ;

		if(soal=='')
		{ 
			alert('Soal tidak boleh kosong');
			document.f1.soal.focus();
		}
		else
		if(sttjwb=='')
		{ 
			alert('Jawaban tidak boleh kosong');
			document.f1.sttjwb.focus();
		}
		else
		{
			$.ajax(
			{
				type: "POST",
				url: "../guru/fungsi_khusus/R1D01B_update.php",
				data: dataString,
				success: function()
				{
					document.f1.soal.disabled=true;
					document.f1.soal1.disabled=true;
					document.f1.sttjwb.disabled=true;
					document.f1.submitup.hidden=true;

					window.location.href='guru.php?mode=R1D01B_Soal&kdesl='+kdesl+'&pilihan=detil_general';
					$('.error').fadeOut(200).hide();
				}
			});
		}
		return false;
	});

	$("#soal1").keyup(function() 
	{
		var sol=document.f1.soal1.value;
		document.f1.soal.value=sol;
	})
});