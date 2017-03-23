<?php

						require_once "../../phpfreechat-1.7/src/phpfreechat.class.php";

						$params =  array("title"		  		=> "Diskussion",
				 						 "max_msg"		 		=> 400,
				 						 "max_text_len"	  		=> 2000,
				 						 "max_displayed_lines"	=> 1000,
				  						 "display_ping"   		=> true,
                 						 "clock"          		=> true,
                    					 "showsmileys"   		=> false,
                 						 "startwithsound" 		=> false,
                 						 "height"        		=> "200px",
                 						 "language"		 		=> "de_DE-formal",
                 						 "theme"		  		=> "scholarium",
                 						 "serverid"       		=> salon-1381,
				 						 "display_pfc_logo"		=> false,
				 						 "showwhosonline" 		=> true,
				 						 "admins"		  		=> array("scholarium" => "Werte333wirte"),
				 						 "channels"		  		=> array("Chat"),
				 						 "displaytabimage" 		=> false,
				 						 "btn_sh_smileys" 		=> false,
				 					 	 "nickmarker"	  		=> false,
				 					 	 "refresh_delay"		=> 6000,
				 					 	 "refresh_delay_steps" 	=> array(7000,20000,8000,60000,10000,120000,12000,240000),
				 					 	 "time_offset"			=> 32400,	 
                 					);

						$chat = new phpFreeChat($params);

						$chat->printJavascript();
						$chat->printStyle();

						$chat->printChat();
						?>