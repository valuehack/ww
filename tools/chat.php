<?php

require_once "../phpfreechat/src/phpfreechat.class.php"; // adjust to your own path

$params =  array("title"		  => "Diskussion",
				 "max_msg"		  => 400,
				 "max_text_len"	  => 2000,
				 "max_displayed_lines"	=> 1000,
				 "display_ping"   => true,
                 "clock"          => true,
                 "showsmileys"    => false,
                 "startwithsound" => false,
                 "height"         => "200px",
                 "language"		  => "de_DE-formal",
                 "theme"		  => "scholarium",
                 "serverid"       => md5(__FILE__),
				 "display_pfc_logo"	=> false,
				 "showwhosonline" => true,
				 "admins"		  => array("scholarium" => "Werte333wirte"),
				 "channels"		  => array("$channel"),
				 "displaytabimage" => false,
				 "btn_sh_smileys" => false,
				 "nickmarker"	  => false,	 
                 );

$chat = new phpFreeChat($params);

$chat->printJavascript();
$chat->printStyle();

$chat->printChat();
?>
