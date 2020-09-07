//fungsi validasi nama yang sudah ada
$(document).ready(function()
{
	$('.kdebku').keyup(function()
	{
		//check the username exists or not from ajax
		$.post('../perpustakaan/fungsi_khusus/P1D06_validasi_bkupjm.php',{ kdebku:$(this).val() } ,function(data)
		{
			if(data=='yes') //if username not avaiable
			{
				document.f1.kbg.value='a';
			}
			else
			{
				document.f1.kbg.value='t';
			}
		});
	});

	$('#kdebku').change(function()
	{
		//check the username exists or not from ajax
		$.post('../perpustakaan/fungsi_khusus/P1D06_validasi_tglk.php',{ kdebku:$(this).val() } ,function(data)
		{
			if(data=='yes') //if username not avaiable
			{
				document.f1.tglk.value='p';
			}
			else
			{
				document.f1.tglk.value='a';
			}
		});
	});
	
	
	$('#kdeang').keyup(function()
	{
		//check the username exists or not from ajax
		$.post('../perpustakaan/fungsi_khusus/P1D06_validasi_siswa.php',{ kdeang:$(this).val() } ,function(data)
		{
			if(data=='yes') //if username not avaiable
			{
				document.f1.stt.value='S';
			}
			else
			{
				document.f1.stt.value='N';
			}
		});
	});
	
				
	$('#kdeang').keyup(function()
	{
		//check the username exists or not from ajax
		$.post('../perpustakaan/fungsi_khusus/P1D06_validasi_kde.php',{ kdeang:$(this).val() } ,function(data)
		{
			if(data=='yes') //if username not avaiable
			{
				document.f1.kode.value='A';
			}
			else
			{
				document.f1.kode.value='T';
				document.f1.kdeang.focus();
				document.f1.stt.value='';
			}
		});
	});
});