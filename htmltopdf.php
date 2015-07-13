<?php
require_once("dompdf/dompdf_config.inc.php");

$html = file_get_contents("ticket.html");

$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->set_paper("a4", 'portrait');
$dompdf->render();
$dompdf->stream("ticket.pdf");
?>