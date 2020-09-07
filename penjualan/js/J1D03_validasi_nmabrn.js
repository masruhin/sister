//Validasi Untuk Nama Barang
$(document).ready(function()
{
	$('#nmabrn').blur(function()
	{
		//remove all the class add the messagebox classes and start fading
		$('#msgbox1').removeClass().addClass('messagebox').text('Checking...').fadeIn('1000');
		//check the username exists or not from ajax
		$.post('../penjualan/fungsi_khusus/J1D03_validasi_nmabrn.php',{ nmabrn:$(this).val() } ,function(data1)
		{
			if(data1=='no') //if username not avaiable
			{
				$('#msgbox1').fadeTo(200,0.1,function() //start fading the messagebox
				{
					//add message and change the class of the box and start fading
					$(this).html('Nama Barang Tidak Ada..').addClass('messageboxerror').fadeTo(900,1)
					document.f1.kdebrn.focus();
				});
			}
			else
			{ 
				$('#msgbox1').fadeOut(200,0.1,function()  //start fading the messagebox
				{
					$(this).html('Barang Ada..').addClass('messageboxok').fadeTo(300,1).fadeOut(700,1);
				});
			}
		});
	});
});