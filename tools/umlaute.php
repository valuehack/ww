<?php
if ($_POST['send'] === 'ok') {
	$ersetzt = ersetzen($_POST['umlaute']);
	
	echo 'Ohne Umlaute: '.$ersetzt;
}

else {
?>

<form method="post" action="">
	<input type="hidden" name="send" value="ok">
	<input type="text" name="umlaute" value="">
	<input type="submit" value="Jetzt Ersetzen">
</form>

<?php
}

function ersetzen($umlaute) {
		
	$uml = array('Ä','ä','Ö','ö','Ü','ü','ß');
	$ers = array('Ae','ae','Oe','oe','Ue','ue','ss');
	$oumlaute = str_replace($uml, $ers, utf8_encode($umlaute));
	
	$oumlaute = preg_replace('/[^a-z0-9_-]/isU', '', $oumlaute);
	
	return $oumlaute;
}
?>