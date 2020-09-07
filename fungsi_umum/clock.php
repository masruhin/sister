<?php
ob_start();
?>
<div id="jam">
<script language="javascript">
	jam();
	function jam(){
		var time = new Date();
		var m=time.getMinutes();
		var minutes=(m<10)?'0'+ m:m;
		var s=time.getSeconds();
		var seconds=(s<10)?'0'+ s:s;
		document.getElementById('jam').innerHTML = time.getHours()+ ":" + minutes + ":" + seconds;
		setTimeout("jam()", 1000);
	}
</script>
</div>
<?php
$jam = ob_get_contents();
ob_end_clean();
?>