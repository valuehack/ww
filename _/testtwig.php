<?php 

ini_set('display_errors',1);
error_reporting(E_ALL);

#require_once '/path/to/lib/Twig/Autoloader.php';
require_once '../_/Twig-1.24.0/lib/Twig/Autoloader.php';



Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem('.');

$twig = new Twig_Environment($loader, array(
'cache' => false,
));

$template = $twig->loadTemplate('testtwig.html.twig');

echo $template->render(array('the' => 'variables', 'go' => 'here'));


?>

