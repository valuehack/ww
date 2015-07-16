<?php
require_once("dompdf/dompdf_config.inc.php");

$name = $_GET[q];

$html = file_get_contents($name.".html");

$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("a4", 'portrait');
$dompdf->render();
$dompdf->stream("ticket.pdf");
?>