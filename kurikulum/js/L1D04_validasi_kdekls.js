//fungsi validasi kode yang sudah ada
$(document).ready(function()
{
	$('#kdekls').blur(function()
	{
		//remove all the class add the messagebox classes and start fading
		$('#msgbox').removeClass().addClass('messagebox').text('Checking...').fadeIn('1000');
		//check the username exists or not from ajax
		$.post('../kurikulum/fungsi_khusus/L1D04_validasi_kdekls.php',{ kdekls:$(this).val() } ,function(data)
		{
			if(data=='no') //if username not avaiable
			{
				$('#msgbox').fadeTo(200,0.1,function() //start fading the messagebox
				{
					//add message and change the class of the box and start fading
					$(this).html('Kode sudah ada...').addClass('messageboxerror').fadeTo(900,1)
					document.f1.kdekls.focus();
				});
			}
			else
			{
				$('#msgbox').fadeOut(200,0.1,function()  //start fading the messagebox
				{
					//add message and change the class of the box and start fading
					$(this).html('Kode masih kosong...').addClass('messageboxok').fadeTo(900,1).fadeOut(100,1);
				});
			}
		});
	});
});