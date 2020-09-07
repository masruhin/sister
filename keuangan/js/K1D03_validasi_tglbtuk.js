//fungsi validasi nama yang sudah ada
$(document).ready(function()
{
	$('#tglbtu').blur(function()
	{
		//remove all the class add the messagebox classes and start fading
		$('#msgbox').removeClass().addClass('messagebox').text('Checking...').fadeIn('1000');
		//check the username exists or not from ajax
		$.post('../keuangan/fungsi_khusus/K1D03_validasi_tglbtuk.php',{ tglbtu:$(this).val() } ,function(data)
		{
			if(data=='no') //if username not avaiable
			{
				$('#msgbox').fadeTo(200,0.1,function() //start fading the messagebox
				{
					//add message and change the class of the box and start fading
					$(this).html('Bulan dan Tahun tidak sama dengan Periode..').addClass('messageboxerror').fadeTo(900,1);
					document.f1.tglbtu.focus();
				});
			}
			else
			{
				$('#msgbox').fadeTo(200,0.1,function()  //start fading the messagebox
				{
					//add message and change the class of the box and start fading
					$(this).html('Bulan dan Tahun sama dengan Periode..').addClass('messageboxok').fadeTo(900,1).fadeOut(100,1);
				});
			}
		});
	});
});