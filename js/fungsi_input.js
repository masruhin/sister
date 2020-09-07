//----------------------------------------------------------------------------------------------------
//Fungsi		: uppercase
//Keterangan	: fungsi untuk input huruf besar semua
//Sintak		:	<INPUT	....	onkeyup		='uppercase(this.id)'>
//Contoh		:	<INPUT 	NAME		='kode'	
//							TYPE		='text' 	
//							id			='kode'
//							onkeyup		='uppercase(this.id)'>
//----------------------------------------------------------------------------------------------------
function uppercase(x)
{
	var y=document.getElementById(x).value
	document.getElementById(x).value=y.toUpperCase()
}
//----------------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------------
//Fungsi		: enter
//Keterangan	: fungsi untuk enter saat input 
//Sintak		:	<INPUT	....	onkeypress='return enter(this,event)'>
//Contoh		:	<INPUT 	NAME		='kode'	
//							TYPE		='text' 	
//							id			='kode'
//							onkeypress	='return enter(this,event)'>
//----------------------------------------------------------------------------------------------------
function enter (field, event) 
{
	var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode;
	if (keyCode == 13) 
	{
		var i;
		for (i = 0; i < field.form.elements.length; i++)
			if (field == field.form.elements[i])
				break;
			i = (i + 1) % field.form.elements.length;
			field.form.elements[i].focus();
			return false;
	}
	else
		return true;
}
//----------------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------------
//Fungsi		: checknumber (fungsi ini sudah diganti dengan format angka)
//Keterangan	: fungsi untuk input angka semua
//				: fungsi checknumber memanggil fungsi CalcKeyCode  	
//Sintak		:	<INPUT	....	onkeyup='javascript:checkNumber(f1.prd);'
//Contoh		:	<INPUT 	NAME		='kode'	
//							TYPE		='text' 	
//							id			='kode'
//							onkeyup='javascript:checkNumber(f1.prd);'>
//----------------------------------------------------------------------------------------------------
function CalcKeyCode(aChar) 
{
	var character 	=aChar.substring(0,1);
	var code 		=aChar.charCodeAt(0);
	return code;
}

function checknumber(val) 
{
	var strPass 	=val.value;
	var strLength 	=strPass.length;
	var lchar 		=val.value.charAt((strLength) - 1);
	var cCode 		=CalcKeyCode(lchar);

	/* 	Check if the keyed in character is a number
		do you want alphabetic uppercase only ?
		or lower case only just check their respective
		codes and replace the 48 and 57 */

	if (cCode < 48 || cCode > 57 ) 
	{
		var myNumber=val.value.substring(0, (strLength) - 1);
		val.value 	=myNumber;
	}
	return false;
}
//----------------------------------------------------------------------------------------------------

//----------------------------------------------------------------------------------------------------
//Fungsi		: formatangka (fungsi ini untuk menggantikan checknumber)
//Keterangan	: fungsi untuk input angka semua dan angka di format menjadi 999,999....
//Sintak		:	<INPUT	....	onKeyUp		='formatangka(this);'
//Contoh		:	<INPUT 	NAME		='kode'	
//							TYPE		='text' 	
//							id			='kode'
//							onKeyUp		='formatangka(this);'>
//----------------------------------------------------------------------------------------------------
function formatangka(objek) 
{
	a = objek.value;
	b = a.replace(/[^\d]/g,"");
	c = "";
	panjang = b.length;
	j = 0;
	for (i = panjang; i > 0; i--) 
	{
		j = j + 1;
		if (((j % 3) == 1) && (j != 1)) 
		{
			c = b.substr(i-1,1) + "," + c;
		} 
		else 
		{
			c = b.substr(i-1,1) + c;
		}
	}
	objek.value = c;
}
//----------------------------------------------------------------------------------------------------