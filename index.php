<?php
	include_once 'config.php';
?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js"></script>
<script type="text/javascript" src="./fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="./fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<a id="various1" href="JavaScript:newPopup('<?php echo $yahoo_connected_path; ?>')"><img src = './img/yahoo.png' alt='Yahoo Connect'></a>
<a href="JavaScript:newPopup('<?php echo $google_connected_path; ?>')"><img src = './img/google.png' alt='Google Connect'></a>
<a href="JavaScript:newPopup('<?php echo $msn_connected_path; ?>')"><img src = './img/msn.png' alt='MSN Connect'></a>
<div style="display: none;">
		<div id="emails" style="width:600px;height:500;overflow:auto;">
		</div>
</div>

<script type="text/javascript">
// Popup window code
function newPopup(url) {
	$('#emails').html('');
	$("#various1").fancybox({
		'titlePosition'		: 'inside',
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'hideOnOverlayClick':false,
		'hideOnContentClick':false,
		'href'   : '#emails',
		
	}).click();
	popupWindow = window.open(
		url,'popUpWindow','height=700,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes')
}
function GetValueFromChild(emails)
{
	var data = $.parseJSON(emails);
	var info = '<table><tbody>';
	$.each(data, function(i, item) {
		info += '<tr>';
		info += '<td>';
		info += item.title;
		info += '</td>';
		info += '<td>';
		info += item.email;
		info += '</td>';
		info += '</tr>';
	});
	info += '</tbody></table>';
	$('#emails').html(info);
}
</script>


