<?php
$s = !isset($_GET['s']) ? $_GET['s'] = 'all' : trim($_GET['s']);

if('all' == $s) {
	echo '<div id="view">';
	echo '<div style="font-size:18px;">All Services</div>';
	echo '<table style="margin-left:25px;"><tr>';
	echo '<td><div id="service-all"></div></td>';
	echo '</tr></table>';
	echo '</div>';

// /////// start javascript ///////
?>
<script language="javascript">
document.getElementById("service-all").innerHTML = getServices('<?php echo $WEBROOT; ?>');

$('#service-all').children('div').click(function(event) {
        service = $(event.target).text().split(' (');
        url = '<?php echo $WEBROOT; ?>view-service/' + service[0].replace(/\[/g, '').replace(/\]/g, '');
        location.href = url;
});
</script>
<?php
// /////// end javascript ///////

} else {
	echo '<div id="view">';
	echo '<div id="view-title">Analysis for ' . $s . '</div>';
	echo '<table width="90%"><tr><td>Hosts</td><td>Events</td><td></td></tr><tr>';
	echo '<td valign="top"><div id="hosts"></div></td>';
	echo '<td valign="top"><div id="events"></div></td>';
	echo '<td valign="top">';
		echo '<div id="tools" style="display:none;">Tools: <button id="php">php</button> <button id="dshield">dshield</button> <button id="firyx">firyx</button> <button id="twitter">twitter</button> <button id="google">google</button> <button id="virustotal">virus total</button></div><br>';
		echo '<div id="ip-info">&nbsp;</div>';
		echo '<div>Request Data</div>';
		echo '<textarea cols="100" rows="7" id="request-data">Select a RX event.</textarea>';
		echo '<br><br>';
		echo 'Project HoneyPot';
		echo '<pre id="projecthoneypot" style="width:100%;"></pre>';
		echo '<br><br>';
		echo 'Shodan';
		echo '<pre id="shodan" style="width:100%;">Select a host.</pre>';
		echo '<br><br>';
	echo '</td>';
	echo '</tr></table>';
	echo '</div>';

// /////// start javascript ///////
?> 
<script language="javascript">
document.getElementById("hosts").innerHTML = getHosts('<?php echo $WEBROOT; ?>', '<?php echo $s; ?>');
document.getElementById("view-title").innerHTML = document.getElementById("view-title").innerHTML + ' ' + getPort('<?php echo $WEBROOT; ?>', '<?php echo $s; ?>');

$('#hosts').children('div').click(function(event) {
        ip = $(event.target).text().split(' (');
	document.getElementById('request-data').innerHTML = 'Select a RX event';
	document.getElementById('ip-info').innerHTML = ip[0];
	document.getElementById('tools').style.display = '';
	document.getElementById('events').innerHTML = getEvents('<?php echo $WEBROOT; ?>', '<?php echo $s; ?>', ip[0]);
	$("#projecthoneypot").load('<?php echo $WEBROOT; ?>projecthoneypot/' + ip[0]);
	$("#shodan").load('<?php echo $WEBROOT; ?>shodan/' + ip[0]);
});

$('#dshield').click(function(event) {
        event.preventDefault();
        window.open('https://www.dshield.org/ipinfo.html?ip=' + document.getElementById('ip-info').innerHTML, 'dshield-ip-info', 'width=800,height=600,toolbar=no,scrollbars=yes');
});

$('#firyx').click(function(event) {
        event.preventDefault();
        window.open('https://www.firyx.com/whois?ip=' + document.getElementById('ip-info').innerHTML, 'firyx-ip-info', 'width=800,height=600,toolbar=no,scrollbars=yes');
});

$('#twitter').click(function(event) {
        event.preventDefault();
        window.open('https://twitter.com/search?f=realtime&q=' + document.getElementById('ip-info').innerHTML + '&src=typd', 'twitter-ip-info', 'width=1200,height=600,toolbar=no,scrollbars=yes');
});

$('#google').click(function(event) {
        event.preventDefault();
        window.open('https://www.google.com/#q=' + document.getElementById('ip-info').innerHTML + '&src=typd', 'google-ip-info', 'width=800,height=600,toolbar=no,scrollbars=yes');
});

$('#virustotal').click(function(event) {
        event.preventDefault();
        window.open('https://www.virustotal.com/en/ip-address/' + document.getElementById('ip-info').innerHTML + '/information/', 'virustotal-ip-info', 'width=800,height=600,toolbar=no,scrollbars=yes');
});
</script>
<?php   
// /////// end javascript ///////
}
?>