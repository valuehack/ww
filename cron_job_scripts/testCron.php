

<?php
/*
The installed versions of PHP 4 and PHP 5 do not support the interpreter specification in a PHP file. In order to run a PHP script via Cron, you must specify the interpreter manually. For example:

    PHP 4: /web/cgi-bin/php "$HOME/html/test.php"
    PHP 5: /web/cgi-bin/php5 "$HOME/html/test.php5"

/web/cgi-bin/php5 "$HOME/html/cron.php"

Installed on my computer:PHP Version 5.5.9-1
*/

$to = 'email@address';
$subject = 'TEST: CRON JOB WORKS!';
$body = 'That is sehr gut!';

mail($to, $subject, $body, $headers);

?>
