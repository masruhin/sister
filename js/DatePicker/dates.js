function copy()

{

var d=document.getElementById('Afname').value;
d = d.split("-");
//var dateString=parseInt(d[0]+"/"d[1]+"/"d[2]);
var now=new Date(d[1]+"/"+d[0]+"/"+d[2]);
var d1=now.getDate();
var day=(d1<10)?'0'+ d1:d1;
var m1=parseInt(now.getMonth())+1 ;
var month=(m1<10)?'0'+ m1:m1;
var year=now.getFullYear();
var dform=day + "-" + month + "-" + year;

var days = 15;

var res = now.setTime(now.getTime() + (days * 24 * 60 * 60 * 1000));
var d2=now.getDate();
var day1=(d2<10)?'0'+ d2:d2;
var m2=parseInt(now.getMonth()) + 1;
var month1=(m2<10)?'0'+ m2:m2;
var year1=now.getFullYear();
var dform1=day1 + "-" + month1 + "-" + year1;

var dayr=1-days;
var res1 = now.setTime(now.getTime() + (dayr * 24 * 60 * 60 * 1000));
var d3=now.getDate();
var day2=(d3<10)?'0'+ d3:d3;
var m=parseInt(now.getMonth()) + 1;
var month2=(m<10)?'0'+ m:m;
var year2=now.getFullYear();
var dform2=day2 + "-" + month2 + "-" + year2;

document.getElementById('Afname').value=dform;
  document.getElementById('Bfname').value = dform1;
  document.getElementById('Cfname').value = dform2;
}
