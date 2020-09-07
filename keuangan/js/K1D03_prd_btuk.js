function btu()
{
	var d		=document.getElementById('tglbtu').value;
		d 		= d.split("-");
	var now		=new Date(d[1]+"/"+d[0]+"/"+d[2]);
	var d1		=now.getDate();
	var day		=(d1<10)?'0'+ d1:d1;
	var m1		=parseInt(now.getMonth())+1 ;
	var month	=(m1<10)?'0'+ m1:m1;
	var year	=parseInt(now.getYear())-100;
	document.getElementById('tglbtu1').value=year+""+month;
}