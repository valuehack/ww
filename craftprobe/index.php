<?php include "header.php";

$ok = $_POST['ok'];
$email = $_POST['email'];
$firstname = $_POST['firstname'];
$name = $_POST['name'];
$street = $_POST['street'];
$postal = $_POST['postal'];
$city = $_POST['city'];
$country = $_POST['country'];
$telephone = $_POST['telephone'];
$note = $_POST['note'];
$found_us = $_POST['found_us'];

if ($ok) {

$sql = "INSERT INTO cb_anmeldung (id, email, firstname, name, street, postal, city, country, telephone, found_us, sub_date, note) VALUES ('', '$email', '$firstname', '$name', '$street', '$postal', '$city', '$country', '$telephone', '$found_us', NOW(), '$note')";

$result = mysql_query($sql) or die("Failed Query of " . $sql. mysql_error());

	/*$insert_query = $wwalt->db_connection->prepare('INSERT INTO cb_anmeldung (id, email, firstname, name, country, telephone, nationality, found_us, note, sub_date) VALUES (:email, :firstname, :name, :street, :postal, :city, :country, :telephone, :found_us, :note, NOW())');
	
	$insert_query->bindValue(':email', $email, PDO::PARAM_STR);
	$insert_query->bindValue(':firstname', $firstname, PDO::PARAM_STR);
	$insert_query->bindValue(':name', $name, PDO::PARAM_STR);
	$insert_query->bindValue(':street', $street, PDO::PARAM_STR);
	$insert_query->bindValue(':postal', $postal, PDO::PARAM_STR);
	$insert_query->bindValue(':city', $city, PDO::PARAM_STR);
	$insert_query->bindValue(':country', $country, PDO::PARAM_STR);
	$insert_query->bindValue(':telephone', $telephone, PDO::PARAM_STR);
	$insert_query->bindValue(':found_us', $found_us, PDO::PARAM_STR);
	$insert_query->bindValue(':note', $note, PDO::PARAM_STR);

	$insert_query->execute();*/

//Email an Interessenten

$body = "Hello $firstname,\n\n
We are glad that you are interested in joining our voyage and we will get back to you shortly.\n\n
Looking forward to seeing you on board!\n
The craftprobe crew\n\n
-----------------\n
craftprobe is a program offered by\n\n
Scholarium\n
Schloesselgasse 19/2/18\n
1080 Vienna, Austria\n
info@scholarium.at";

mail ($email,"Welcome to craftprobe",$body,"From: info@scholarium.at\nContent-Type: text/plain; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit\nX-Mailer: SimpleForm");

//Email an Uns

mail ("info@scholarium.at","craftprobe Anmeldung","$firstname, $name, $email hat sich als Interessent eingetragen","From: $email\nContent-Type: text/plain; charset=\"iso-8859-1\"\nContent-Transfer-Encoding: 8bit\nX-Mailer: SimpleForm");
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>craftprobe</title>
        <meta name="description" content="One Month Program in Entrepreneurship">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="style.css">        
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <script type="text/javascript" src="js/general.js"></script>

		<script>
  			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
 			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  			ga('create', 'UA-62940948-1', 'auto');
  			ga('send', 'pageview');
		</script>
			
    </head>
    <body>
    	<div id="notice" class="notice">
    		<a href="http://scholarium.at/eltern.php">&rarr; deutschsprachige Information f&uuml;r Eltern</a>
    		<button class="dismiss" onclick="dismissNotice();">X</button>
    	</div>
    	<section class="main-title">
        	<header class="header" id="top">
            	<p>craft<span>probe</span></p>
            	<div class="nav-trigger">
					<div class="nav-trigger__icon">
						<a href="#" onclick="showNav();return false;"><img src="img/navicon.svg" alt="Menu" title="Menu"></a>
					</div>
				</div>
				<div id="nav">
            		<ul>
               	 		<li><a href="#about" onclick="showNav();return false;">About</a></li>
                		<li><a href="#manual" onclick="showNav();return false;">Manual</a></li>
                		<li><a href="#course" onclick="showNav();return false;">Course</a></li>
                		<li><a href="#vessel" onclick="showNav();return false;">Vessel</a></li>
                		<li><a href="#crew" onclick="showNav();return false;">Crew</a></li>
                		<li><a href="#board" onclick="showNav();return false;">Board</a></li>
            		</ul>
           		</div>
       	 	</header>
        	<?   if($ok == 1) {
					echo '<div class="ok">
					<h1>Thank you for your interest in craftprobe!</h1>
					<p>You successfully submitted your boarding request.</p>
					</div>';
}
?>
          	<div class="banner">
            	<div class="bannerimg" style="background-image: url(img/craftprobe.jpg);"></div>
	        	<div class="arrow-down">
            		<a href="#about">
                    	<div class="arrow-down__icon"></div>
                	</a>
            	</div>
        	</div>
        </section>
        <!--<div class="content">-->
            <section id="about" class="s1">
            	<!-- <p>Sense: the final frontier. These are the voyages of craftprobe, an exploratory enterprise. Its mission: to explore alternatives to create real value and make sense, to boldly pierce through the endless swaths of bullshit that surround us every day in search of intelligent life. Our craft is a perpetual start-up, with some of the coolness, but none of the hype.</p> -->

<p>craftprobe is an intense one-month program in Vienna, Austria, offering a limited number of selected participants a unique educational and life experience to prepare for the future and make better decisions. Young people today are flooded with educational, entrepreneurial and career options, which makes life decisions really difficult. After a month of craftprobe you will know your strengths, have a clearer picture of future developments and your place within the world. You will be able to develop, with the support of some of the best brains and tools and through entrepreneurial projects, practical experiments and profound reflection, the necessary skills and ideas to create real value. Not the fake value pseudo-managers and pseudo-politicians are offering: either some over-hyped shiny stuff you do not need, to be paid for with money you do not have, or the fiction by which everyone tries to live at the expense of everybody else. Cut the crap, get real!</p>

<p>craftprobe is a systematic reality check, always intent to build real things and develop real solutions, as it is run by an enterprise and not an agency, program or school. In view of the hugely distorted markets the shareholders of craftprobe&apos;s mothership do not strive to pocket quick profits but to develop a unique entrepreneurial laboratory to find feasible, small-scale solutions for tomorrow&apos;s problems.</p>

<p>Are you looking for a job? Almost everyone is, but entry level jobs are becoming scarcer and scarcer. Bad news: Due to current technological developments, the business cycle and political interventionism, soon there will be hardly any jobs for young people who have had no chance to prove their creativity and productivity &mdash; a vicious circle, because how to prove yourself without ever landing a sustainable job? Teachers, journalists, politicians have been misleading you for quite a while, but they do not know better. We understand your anger and fear. Better shape up and try to prepare for an uncertain future where many economic premises will turn out to be illusions.</p>

<p>This is where we come in. Not because we know the future, but because we are open and willing to face it. We are an enterprise that does not entirely depend on current markets but explores future markets and checks today&apos;s premises. craftprobe is a unique personal development program to help you prepare for this uncertain future, but not through brainwashing, psychobabble or motivational lectures, ebooks, guides and videos that promise you some kind of bogus certainty, but through concrete and relevant projects and tasks that explore products, processes, tools, markets and ideas.</p>

<p>We love exploring the unknown, we love entrepreneurship, we love learning new ideas, new skills and new ways, and we love our liberty and individuality. We distrust experts, politicians, bankers, managers, journalists, teachers, venture capitalists, just as much as we distrust gurus, doomsayers, ideologues, do-gooders, hipsters, internet celebrities and trolls. Ready to board our craft? Ready to develop your skills and probe into the unknown? craftprobe is a trial of strength. Joining our expedition is definitely not for the weak of heart. Illusions might get shattered. We cannot tolerate any bullshit on board (it stinks). If you have what it takes, apply to join us on the bridge.</p>
                <p><a href="#top">Back to the top</a></p>
            </section>
            
            <section id="manual" class="s2">
            	<h1>MANUAL</h1>

				<h2>Who is this for?</h2>
				
				<p>Anyone old enough to be or become independent, and young enough to challenge conceived wisdom and walk off the beaten track. This means that the usual age bracket of our explorers is 18 to 28. 18 is the minimum age for insurance reasons (we do some dangerous stuff). If you are above 28, but absolutely longing for such a restart and reexamination, and financially independent, we may be able to make it happen. In this case do not apply, just contact us. Normally, 28 is the maximum age, because after that you will either have already invested too much sunk costs in the status quo or be a sad failure (most are, do not take it personally). Please leave us alone if you are looking for a 9-5 career where someone tells you what to do until retirement or if you think your degree somehow deserves you a well paid, fun and easy job. If you suspect that there is more out there than university teaches, the media informs about and politicians admit and that the future may be radically different from what the generation of your parents expects, but do not feel like retiring to virtual reality from a challenging world and have the courage and energy to confront those challenges, then you may just be the crew member we have been looking for.</p>

				<h2>When should I do it?</h2>
				<p>The most common options are:</p>
					<ol>
						<li>Directly after your school-leaving exam, before enrolling at university or making another career choice. You either take a gap year or at least use shorter gaps to prepare for a better decision and lay the right foundations for your life. The earlier the better, the longer you wait the more you will regret. Taking time for a month before going to university is the best choice you can make.</li>
						<li>After your Bachelor&apos;s degree, when considering or waiting for enrollment for a Master&apos;s degree. Many students face extended periods in doubt and frustration. Do not waste this time! craftprobe is the perfect gap filler, next to which in retrospect your studies and degrees will fade in importance.</li>
						<li>After finishing university and when trying to enter the job market. You will realize that it is getting more and more difficult to land a job right out of university. Have you considered entrepreneurial alternatives? Even if you just want to grow personally, develop a network and get a head-start for your professional career, by making up for all the real-life lessons university has spared you, craftprobe is just what you are looking for.</li>
					</ol>

				<h2>How much does it cost?</h2>
				<p>A practical program of this kind is usually prohibitively expensive. As the program is run by a non-profit enterprise which puts a high value on efficiency and effectiveness, we are able to cut costs to 1.900&euro;. Usually, parents or close relatives are willing to help you get a head-start in life. In order to convince them to bear the costs, you can direct them to <a href="http://scholarium.at/eltern.php">this page</a>, if they speak German, where we have compiled all information for your parents/relatives/sponsors.</p>

				<h2>Do I get a degree? Will my employability rise?</h2>
				<p>You will not get a state-accredited degree, but a personal certificate and a documentation of your strengths. Coming on board is not an alternative to university or vocational training, but a short-time program to help you make better decisions on your education and career. Your employability in the sense of a real and proven capacity to create value for real clients should rise a lot.</p>

				<h2>Why should I do that? No degree, no certificate, no money, no prestige, are you kidding? What is in it for me?</h2>
				<p>YOU should not. It all seems so easy in the beginning. You will get a degree, you will gather a few more certificates, and your dream job is waiting for you. If you are not employed right away, you only have to gather more certificates and do more internships. Until some day you realize that no-one is waiting for you. Then the only way out of frustration is enthusiasm for some start-up. While you dream of sudden riches, you exploit yourself for another web app, another drink, another gadget. Only that 80% of start-ups fail, and we are still in the midst of a bubble economy. More will fail when the bubble bursts. Or, on the other hand, you are a high-potential. A consultancy firm, investment bank or big corporation has recruited you right away. If you are checking out this site it is unlikely that you are at this stage. You would be exploited for good money and prestige and have neither time nor eagerness to explore alternatives. If you are not broken physically, you are broken mentally, and if not mentally, you are broken spiritually. At age 30 you may come to us whining, and it may well be too late. We do not mean to take away all hope. We are quite optimistic, only very down to earth. If you aim too hard at success, you will most certainly miss it. But there is still so much to succeed at in this world, so many unsolved problems, awaiting challenges, hidden treasures. We may not have a map for treasure island, but our amazing vessel can go places where no one else is digging. Yes, you will get no fancy paper. Instead, you will get inspired, challenged, and prepared for the real world. No bullshit.</p>

				<h2>Why is it all in English? Are you embarrassing hipsters?</h2>
				<p>We live in a global age. We have been connected for power and profit, for this we cannot take the blame. The things, ideas and voices that make sense are so rare and widely dispersed in this ocean of bullshit, which has been let loose around the globe, that we simply cannot afford to withdraw from the world and play deaf and mute for national pride. For most of our team, English is not a native language, but we are natives of a world that converses in English. We are masters of our native languages, we love them and we need them. Currently, our team is able to converse in German, French, Spanish, Persian, Arabic and Hungarian as well, if you prefer. Everyone who joins us will at least perfect his English and learn German. Speaking German or English is no condition to come on board, but speaking either of those languages and being willing to learn some of the other is. German is not only one of the richest and most precise languages that opens up a rich heritage of science and culture, but also the language that adds the most economic benefit for foreign speakers. According to a recent study, Americans who are able to speak German earn on average $128,000 more during their lifetime.</p>
                <p><a href="#top">Back to the top</a></p>
            </section>
            <section  id="course" class="s3">
                <h1>Course</h1>
                
                <p>You will probe into <b>culture</b>: Most start-ups and entrepreneurial education programs are rather shallow. You mainly learn how to sell promises of endless riches to greedy investors, promises of faked coolness to indebted consumers and promises of heroic images to funding bureaucrats. Our vessel goes much further and ignores all the need for hype and glamour. Based in one of the capitals of old European culture, a historic center of science, art, literature, music and trade, we have access to an ancient treasure trove of thought and creation. We do not live in the past but think about the future standing on the shoulders of giants. Right on board we carry along one of the most spectacular private libraries of Austria, with a unique selection of masterworks in practical philosophy, economics and history.</p>

				<p>You will probe into the <b>market</b>: Many alternative educational programs are too much rooted in the past or too aloof in ivory towers to really understand what is going on in the world today and where it will lead. We are young natives of a globalized and digital world. Our captain is a renowned visionary with both feet firmly on the ground: As an economist, entrepreneur, physicist and investment consultant, he has just the eye to tell promising trends and ominous dynamics from hyped bullshit. We are following the markets and geopolitics, and are sober, down-to-earth entrepreneurs at the forefront of innovation. We are continually checking premises, gathering data, scouting for opportunities and challenges.</p>

				<p>You will probe into <b>nature</b>: Austria is famous for its magnificent, largely intact, rough nature. This is a boundless resource for knowledge and self-reliance. It is a historic center of alpinism, of seeking challenges, sharpening the senses and strengthening the body in the world&apos;s most beautiful and breathtaking training circuit toughened by elements and terrain. In Austria, ancient traditions of agriculture, horticulture, medicine and craft have survived the ages which contain amazing amounts of lost knowledge. We gain hands-on experience and learn from masters hidden in distant valleys and on secluded mountains. No laboratory, no network, no university can replace this immense study resource at our hands. Our team comprises tough sportsmen and survivalists that guide us through challenging explorations of natural abundance and our inner potential to become truly self-reliant.</p>

				<p>You will probe into <b>digital tools</b>: A thorough command of cutting-edge digital tools is a precondition of a successful, creative, entrepreneurial and self-reliant life. Most modern interactions, be it in communication, research or trade, are based on a digital infrastructure. Learning to code is like the sailing license without which you will not be very useful on board of a craft in today's stormy waters. We are learning by doing and continually probing into the newest tools, most of which are of course senseless time-wasters, but some of which are absolutely necessary to stay on top of the wave. Access to modern CNC and prototyping equipment allows us to translate our digital endeavors into real objects.</p>

				<p>You will probe into <b>analog tools</b>: Austria is infused with a spirit of makers, craftsmen and artists. On the countryside people are to an amazing degree technologically self-reliant, being able to fix what is broken and continually finding hacks to make work what seems impossible. We get our hands dirty and experiment with the most versatile tools we can lay our hands on. A network of master craftsmen helps us in our explorations. The artist and creator is unthinkable without the right tools. There is so much of value outside our screens with their unhandy, fake gadgets. We need to understand the real, physical world in order to change it. Most educational alternatives just bombard you with even more digital information. You need to cut the cord once in a while if you really mean to learn something useful.</p>

				<p>You will probe into your <b>own projects and ideas</b>. We will support you with infrastructure, investment, tools, contacts, and brains. This way you will be able to try out and develop skills, ideas, products, solutions, campaigns, brands, research interests, maybe even your own company or organization, in the widest possible variety of industries and fields. In your free time you can have all the culture, partying and nature you like &ndash; partly on your own, making new friends, partly with fellow crew members. Explore art, music, theatre, opera, history, go skiing, rafting, hiking, biking, travel to neighboring Italy, Czech Republic, Hungary, Slovakia, Slovenia, Switzerland, Germany, Liechtenstein, or simply relax in the place ranked to have the highest quality of life on this planet.</p>
                <p><a href="#top">Back to the top</a></p>
            </section>
            <section  id="vessel" class="s4">
                <h1>Vessel</h1>
                <p>Our first craft is anchored in one of the most ancient, creative and educated parts of Vienna, close to one of the oldest universities of the world (alas, of past glories not much more than the facades has survived), neighboring a beautiful, hidden monastery where the last remaining urban monks tend to their garden and library. The beauty of our deck and cabins will inspire you: in a historic building with high ceilings and impeccable interiors we explore, experiment and innovate within walls adorned by one of the most spectacular private libraries of Vienna, yet with plenty of space and equipment for practical endeavors.</p>

				<p>We chose Austria as our home port for the high quality of life (Vienna is ranked highest worldwide), the unparalleled access to culture and nature, and the rich heritage as a center of science and entrepreneurship. Austria is the birthplace of the Austrian School of Economics, the only economic tradition that focusses on the entrepreneur and cherishes entrepreneurship while at the same time being highly critical of the financially and politically inflated bubble economy and the concomitant inflation of bullshit. But Austria is also the birthplace of logo-therapy, of the search for meaning and the rejection of cynicism, relativism and short-term materialism.</p>

				<!--<p>Our current craft only offers space for twelve explorers, which is why our expeditions into the unknown are selective. The journey takes 2-12 months; new explorers may come on board anytime. The cost of riding along is either borne by sponsorship through private donors, by parents and relatives or by the explorers themselves. Proven explorers may stay on and earn their living on board depending on their courage and entrepreneurial acumen.</p>-->

				<p>Our mothership is a private, tax-exempted, non-profit enterprise founded by successful entrepreneurs and visionaries from Austria, Germany, Liechtenstein and Switzerland eager to pass on the spark to future generations. Contributions go directly to financing our explorations and scholarships, without deductions for interests, profits or taxes, keeping the costs for new explorers as low as possible. Even if you are unable to finance your journey, do not hesitate to apply.</p>


				<p>If you have what it takes, we are absolutely sure that you will love this journey and it will be one of the greatest experiences of your life. No other educational program, internship, traineeship or job opportunity comes close to it. You will be reluctant to go ashore again and will either stay on board or join another vessel to boldly go where no one has gone before.</p>
                <p><a href="#top">Back to the top</a></p>
            </section>

            
            
            <section  id="crew"  class="s3">
                <h1>crew</h1>

<?php		
		$get_crew = $pdocon->db_connection->prepare("SELECT * from crew WHERE level <8 order by level asc");
		$get_crew->execute();
		$crew_result = $get_crew->fetchAll();
	
		$check_lvl1 = 0;
		$check_lvl2 = 0;
		$check_lvl3 = 0;
		$check_lvl4 = 0;
		$check_lvl5 = 0;
		$check_lvl6 = 0;
		$check_lvl7 = 0;
		$check_lvl8 = 0;
		
		for ($i=0; $i < count($crew_result); $i++) {
				
			$level = $crew_result[$i]['level'];
			$id = $crew_result[$i]['id'];
			$link = $crew_result[$i]['link'];
			$name = $crew_result[$i]['name'];
			$text_en = $crew_result[$i]['text_en'];
			
			if ($level == 1){
				if ($check_lvl1 == 0){
					$check_lvl1 = 1;
					echo '<p class="crew_levels">Captain</p>'; 
				}
			}
			if ($level == 2){
				if ($check_lvl2 == 0){
					$check_lvl2 = 1;
					echo '<p class="crew_levels">Admiralty</p>'; 
				}
			}
			if ($level == 3){
				if ($check_lvl3 == 0){
					$check_lvl3 = 1;
					echo '<p class="crew_levels">Officers</p>'; 
				}
			}
			if ($level == 4){
				if ($check_lvl4 == 0){
					$check_lvl4 = 1;
					echo '<p class="crew_levels">Mates</p>'; 
				}
			}
			if ($level == 5){
				if ($check_lvl5 == 0){
					$check_lvl5 = 1;
					echo '<p class="crew_levels">Ehrenpr&auml;sidenten</p>'; 
				}
			}
			if ($level == 6){
				if ($check_lvl6 == 0){
					$check_lvl6 = 1;
					echo '<p class="crew_levels">Beir&auml;te</p>'; 
				}
			}
			if ($level == 7){
				if ($check_lvl7 == 0){
					$check_lvl7 = 1;
					echo '<p class="crew_levels">Partner</p>'; 
				}
			}
			if ($level == 8){
				if ($check_lvl8 == 0){
					$check_lvl8 = 1;
					echo '<p class="crew_levels">Sailors</p>'; 
				}
			}
?>			
			<div class="crew">
				<div class="crew__col-1">
					<img src="http://www.craftprobe.com/img/<?=$id?>.jpg">
				</div>
				<div class="crew__col-4">
					<h1><?=$name?></h1>
					<a class="crew__col-4__a" href="http://<?=$link?>"><?=$link?></a>
					<p><?=$text_en?></p>
				</div>
			</div>
<?php
		}
?>	                                             				            
                    <p><a href="#top">Back to the top</a></p>
            </section>
            
            
       		<section id="board" class="s5">
                <div class="s5img" style="background: url(img/code2.jpg) center;">
                <div class="form">
                 <h1>Now it&apos;s your turn. Join our voyage!</h1> 
                 <p>What are you waiting for? A television spot to tell you that this is meant for you? A government decree? A viral video to make you part of a crowd? We will try the best we can to avoid hypes, unwanted publicity, and official recognition. A craft like ours has to shun such shallow waters. If you are afraid, then stay ashore. No worries, anyway there is not enough space for everyone. Lifeboats get crowded easily. If you have the courage but just lack the confidence that you are good enough, go ahead and apply. We will get in touch with you. It won&apos;t hurt. But it might open up opportunities you have not even dared to dream about.</p>              
                     <input type="button" class="inputbutton" value="Boarding request" data-toggle="modal" data-target="#myModal">
                 </div>
                </div>
            </section>
        <!--</div>-->    
        <footer class="footer">
            <p>
                &copy; 2015 | scholarium&trade; | Schl&ouml;sselgasse 19/2/18 | 1080 Vienna | Austria <br>
            </p>
            <p class="img_links">
                Background-Image: <a href="https://www.flickr.com/photos/riebart/4466482623/in/photolist-7NFTF6-4qquBv-4qvivG-6WxYTc-57hHm6-mjhDwB-5VKcCj-8SjwXw-79EVn6-nfPx72-6xfvm9-ccQ6rL-75cgcM-59ib1t-7Gyyds-9UNeUM-fKSF1d-asasy3-Mdf4-ptJh3V-apgafX-KnCK4-4U2GPi-bpd8Ht-4usG5p-GH7wh-jmr8PB-as7QVk-ec78kF-b7r6g-6fmKyW-3AvBtV-4nqiZn-5RUuNN-6NKzvV-kmhEbE-7E9fqU-d9A4Eb-7d7ipd-8dpeZZ-buRLHu-5WvBYq-7tnkmy-8dsw7J-asaxj1-asawS3-5XzfyW-aMG5S4-9dUbHm-d9A3SY">"Code" by Michael Himbeault</a>
            </p>
        </footer>        

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog-login">
    <div class="modal-content-login">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2 class="modal-title" id="myModalLabel">Join our voyage</h2>
      </div>
      <div class="modal-body">
		<form method="post" action="index.php" name="user_create_profile_form">
				<p><span class="inputlabel2">Application form can be filled out in English, German, French, Spanish, Arabic, Persian, Italian or Hungarian.</span></p>
				<div class="input">
					<input type="hidden" name="ok" value="1">
					
					<input class="inputfield" type="text" name="firstname" placeholder=" First Name" required><br>
        			<input class="inputfield" type="text" name="name" placeholder=" Surname" required><br>
        			<input class="inputfield" type="email" name="email" placeholder=" Email" required><br> 
        			<input class="inputfield" type="tel" name="telephone" placeholder=" Telephone/ Mobile (e.g. +431234567)"><br>
					<input class="inputfield" type="text" name="street" placeholder=" Street" required><br>
					<input class="inputfield" type="text" name="postal" placeholder=" Postal Code" required><br>
					<input class="inputfield" type="text" name="city" placeholder=" City" required><br>
					 
        			<select class="inputfield_select" id="user_country" name="country" placeholder=" Country" required>
<option value="Austria" selected>Austria</option>
<option value="Germany">Germany</option>
<option value="Switzerland">Switzerland</option>
<option value="Liechtenstein">Liechtenstein</option>
<option value="divider" disabled>&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;&mdash;</option>
<option value="Afghanistan">Afghanistan</option>
<option value="Åland Islands">Aland Islands</option>
<option value="Albania">Albania</option>
<option value="Algeria">Algeria</option>
<option value="American Samoa">American Samoa</option>
<option value="Andorra">Andorra</option>
<option value="Angola">Angola</option>
<option value="Anguilla">Anguilla</option>
<option value="Antarctica">Antarctica</option>
<option value="Antigua and Barbuda">Antigua and Barbuda</option>
<option value="Argentina">Argentina</option>
<option value="Armenia">Armenia</option>
<option value="Aruba">Aruba</option>
<option value="Australia">Australia</option>
<option value="Austria">Austria</option>
<option value="Azerbaijan">Azerbaijan</option>
<option value="Bahamas">Bahamas</option>
<option value="Bahrain">Bahrain</option>
<option value="Bangladesh">Bangladesh</option>
<option value="Barbados">Barbados</option>
<option value="Belarus">Belarus</option>
<option value="Belgium">Belgium</option>
<option value="Belize">Belize</option>
<option value="Benin">Benin</option>
<option value="Bermuda">Bermuda</option>
<option value="Bhutan">Bhutan</option>
<option value="Bolivia">Bolivia</option>
<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
<option value="Botswana">Botswana</option>
<option value="Bouvet Island">Bouvet Island</option>
<option value="Brazil">Brazil</option>
<option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
<option value="Brunei Darussalam">Brunei Darussalam</option>
<option value="Bulgaria">Bulgaria</option>
<option value="Burkina Faso">Burkina Faso</option>
<option value="Burundi">Burundi</option>
<option value="Cambodia">Cambodia</option>
<option value="Cameroon">Cameroon</option>
<option value="Canada">Canada</option>
<option value="Cape Verde">Cape Verde</option>
<option value="Cayman Islands">Cayman Islands</option>
<option value="Central African Republic">Central African Republic</option>
<option value="Chad">Chad</option>
<option value="Chile">Chile</option>
<option value="China">China</option>
<option value="Christmas Island">Christmas Island</option>
<option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
<option value="Colombia">Colombia</option>
<option value="Comoros">Comoros</option>
<option value="Congo">Congo</option>
<option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
<option value="Cook Islands">Cook Islands</option>
<option value="Costa Rica">Costa Rica</option>
<option value="Cote D'ivoire">Cote D'ivoire</option>
<option value="Croatia">Croatia</option>
<option value="Cuba">Cuba</option>
<option value="Cyprus">Cyprus</option>
<option value="Czech Republic">Czech Republic</option>
<option value="Denmark">Denmark</option>
<option value="Djibouti">Djibouti</option>
<option value="Dominica">Dominica</option>
<option value="Dominican Republic">Dominican Republic</option>
<option value="Ecuador">Ecuador</option>
<option value="Egypt">Egypt</option>
<option value="El Salvador">El Salvador</option>
<option value="Equatorial Guinea">Equatorial Guinea</option>
<option value="Eritrea">Eritrea</option>
<option value="Estonia">Estonia</option>
<option value="Ethiopia">Ethiopia</option>
<option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
<option value="Faroe Islands">Faroe Islands</option>
<option value="Fiji">Fiji</option>
<option value="Finland">Finland</option>
<option value="France">France</option>
<option value="French Guiana">French Guiana</option>
<option value="French Polynesia">French Polynesia</option>
<option value="French Southern Territories">French Southern Territories</option>
<option value="Gabon">Gabon</option>
<option value="Gambia">Gambia</option>
<option value="Georgia">Georgia</option>
<option value="Germany">Germany</option>
<option value="Ghana">Ghana</option>
<option value="Gibraltar">Gibraltar</option>
<option value="Greece">Greece</option>
<option value="Greenland">Greenland</option>
<option value="Grenada">Grenada</option>
<option value="Guadeloupe">Guadeloupe</option>
<option value="Guam">Guam</option>
<option value="Guatemala">Guatemala</option>
<option value="Guernsey">Guernsey</option>
<option value="Guinea">Guinea</option>
<option value="Guinea-bissau">Guinea-bissau</option>
<option value="Guyana">Guyana</option>
<option value="Haiti">Haiti</option>
<option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
<option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
<option value="Honduras">Honduras</option>
<option value="Hong Kong">Hong Kong</option>
<option value="Hungary">Hungary</option>
<option value="Iceland">Iceland</option>
<option value="India">India</option>
<option value="Indonesia">Indonesia</option>
<option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
<option value="Iraq">Iraq</option>
<option value="Ireland">Ireland</option>
<option value="Isle of Man">Isle of Man</option>
<option value="Israel">Israel</option>
<option value="Italy">Italy</option>
<option value="Jamaica">Jamaica</option>
<option value="Japan">Japan</option>
<option value="Jersey">Jersey</option>
<option value="Jordan">Jordan</option>
<option value="Kazakhstan">Kazakhstan</option>
<option value="Kenya">Kenya</option>
<option value="Kiribati">Kiribati</option>
<option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
<option value="Korea, Republic of">Korea, Republic of</option>
<option value="Kuwait">Kuwait</option>
<option value="Kyrgyzstan">Kyrgyzstan</option>
<option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
<option value="Latvia">Latvia</option>
<option value="Lebanon">Lebanon</option>
<option value="Lesotho">Lesotho</option>
<option value="Liberia">Liberia</option>
<option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
<option value="Liechtenstein">Liechtenstein</option>
<option value="Lithuania">Lithuania</option>
<option value="Luxembourg">Luxembourg</option>
<option value="Macao">Macao</option>
<option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
<option value="Madagascar">Madagascar</option>
<option value="Malawi">Malawi</option>
<option value="Malaysia">Malaysia</option>
<option value="Maldives">Maldives</option>
<option value="Mali">Mali</option>
<option value="Malta">Malta</option>
<option value="Marshall Islands">Marshall Islands</option>
<option value="Martinique">Martinique</option>
<option value="Mauritania">Mauritania</option>
<option value="Mauritius">Mauritius</option>
<option value="Mayotte">Mayotte</option>
<option value="Mexico">Mexico</option>
<option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
<option value="Moldova, Republic of">Moldova, Republic of</option>
<option value="Monaco">Monaco</option>
<option value="Mongolia">Mongolia</option>
<option value="Montenegro">Montenegro</option>
<option value="Montserrat">Montserrat</option>
<option value="Morocco">Morocco</option>
<option value="Mozambique">Mozambique</option>
<option value="Myanmar">Myanmar</option>
<option value="Namibia">Namibia</option>
<option value="Nauru">Nauru</option>
<option value="Nepal">Nepal</option>
<option value="Netherlands">Netherlands</option>
<option value="Netherlands Antilles">Netherlands Antilles</option>
<option value="New Caledonia">New Caledonia</option>
<option value="New Zealand">New Zealand</option>
<option value="Nicaragua">Nicaragua</option>
<option value="Niger">Niger</option>
<option value="Nigeria">Nigeria</option>
<option value="Niue">Niue</option>
<option value="Norfolk Island">Norfolk Island</option>
<option value="Northern Mariana Islands">Northern Mariana Islands</option>
<option value="Norway">Norway</option>
<option value="Oman">Oman</option>
<option value="Pakistan">Pakistan</option>
<option value="Palau">Palau</option>
<option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
<option value="Panama">Panama</option>
<option value="Papua New Guinea">Papua New Guinea</option>
<option value="Paraguay">Paraguay</option>
<option value="Peru">Peru</option>
<option value="Philippines">Philippines</option>
<option value="Pitcairn">Pitcairn</option>
<option value="Poland">Poland</option>
<option value="Portugal">Portugal</option>
<option value="Puerto Rico">Puerto Rico</option>
<option value="Qatar">Qatar</option>
<option value="Reunion">Reunion</option>
<option value="Romania">Romania</option>
<option value="Russian Federation">Russian Federation</option>
<option value="Rwanda">Rwanda</option>
<option value="Saint Helena">Saint Helena</option>
<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
<option value="Saint Lucia">Saint Lucia</option>
<option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
<option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
<option value="Samoa">Samoa</option>
<option value="San Marino">San Marino</option>
<option value="Sao Tome and Principe">Sao Tome and Principe</option>
<option value="Saudi Arabia">Saudi Arabia</option>
<option value="Senegal">Senegal</option>
<option value="Serbia">Serbia</option>
<option value="Seychelles">Seychelles</option>
<option value="Sierra Leone">Sierra Leone</option>
<option value="Singapore">Singapore</option>
<option value="Slovakia">Slovakia</option>
<option value="Slovenia">Slovenia</option>
<option value="Solomon Islands">Solomon Islands</option>
<option value="Somalia">Somalia</option>
<option value="South Africa">South Africa</option>
<option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
<option value="Spain">Spain</option>
<option value="Sri Lanka">Sri Lanka</option>
<option value="Sudan">Sudan</option>
<option value="Suriname">Suriname</option>
<option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
<option value="Swaziland">Swaziland</option>
<option value="Sweden">Sweden</option>
<option value="Switzerland">Switzerland</option>
<option value="Syrian Arab Republic">Syrian Arab Republic</option>
<option value="Taiwan, Province of China">Taiwan, Province of China</option>
<option value="Tajikistan">Tajikistan</option>
<option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
<option value="Thailand">Thailand</option>
<option value="Timor-leste">Timor-leste</option>
<option value="Togo">Togo</option>
<option value="Tokelau">Tokelau</option>
<option value="Tonga">Tonga</option>
<option value="Trinidad and Tobago">Trinidad and Tobago</option>
<option value="Tunisia">Tunisia</option>
<option value="Turkey">Turkey</option>
<option value="Turkmenistan">Turkmenistan</option>
<option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
<option value="Tuvalu">Tuvalu</option>
<option value="Uganda">Uganda</option>
<option value="Ukraine">Ukraine</option>
<option value="United Arab Emirates">United Arab Emirates</option>
<option value="United Kingdom">United Kingdom</option>
<option value="United States">United States</option>
<option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
<option value="Uruguay">Uruguay</option>
<option value="Uzbekistan">Uzbekistan</option>
<option value="Vanuatu">Vanuatu</option>
<option value="Venezuela">Venezuela</option>
<option value="Viet Nam">Viet Nam</option>
<option value="Virgin Islands, British">Virgin Islands, British</option>
<option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
<option value="Wallis and Futuna">Wallis and Futuna</option>
<option value="Western Sahara">Western Sahara</option>
<option value="Yemen">Yemen</option>
<option value="Zambia">Zambia</option>
<option value="Zimbabwe">Zimbabwe</option>
					</select><br>
					<textarea name="note" class="inputarea" placeholder=" Do you have questions or comments?" rows="10" required></textarea><br>
					<input class="inputfield bottom_border" type="text" name="found_us" placeholder=" How did you find us?"><br>					
				</div>
    			<input type="submit" class="inputbutton_subscribe" name="registrationform" value="Boarding request">
			</form>
		</div>
    </div>
  </div>
</div>

    </body>
</html>