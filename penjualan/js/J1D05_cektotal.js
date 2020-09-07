var htmlobjek;
$(document).ready(function()
{
	//apabila terjadi event onchange terhadap object <select id=kop>
	$("#nmabrn").change(function()
	{
		var cst = $("#nmabrn_hidden").val();
    	$.ajax(
    	{
        	url: "../penjualan/fungsi_khusus/J1D05_stok.php",
        	data: "kdebrn="+cst,
	    	cache: false,
    		success: function(msg)
			{
				//jika data sukses diambil dari server kita tampilkan
				//di <select id=cst>
				$("#cst").val(msg);
			}
		})
	});
});