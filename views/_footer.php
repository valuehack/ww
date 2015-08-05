        <footer class="footer">
        	<div class="footer_section">
        		<div class="footer_info">
        			<?php
						$sql = "SELECT * from static_content WHERE (page LIKE 'footer')";
						$result = mysql_query($sql) or die("Failed Query of " . $sql. " - ". mysql_error());
						$entry = mysql_fetch_array($result);
				
						echo $entry[info];			
					?>
        		</div>
        		<div class="footer_contact">
        			<img src="../style/gfx/footer_logo.png" alt="Scholarium Logo">
        			<ul>
        				<li>Schl&ouml;sselgasse 19/2/18</li>
        				<li>A - 1080 Wien</li>
        				<li>&Ouml;sterreich</li>
        				<li>&nbsp;</li>
        				<li>E-Mail:&nbsp;<a href="mailto:&#105;nf&#111;&#064;&#119;&#101;rt&#101;wirtsc&#104;&#097;f&#116;.or&#103;">&#105;nf&#111;&#064;&#119;&#101;rt&#101;wirtsc&#104;&#097;f&#116;.or&#103;</a></li>
					</ul>
					<p><a href="../kontakt/">Impressum</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="../agb/">AGB</a></p> 
        		</div>
        	</div>
        	<div class="footer_section">
        		<div class="footer_tm">
        			<p>&copy; scholarium GmbH&trade;</p>
        		</div>
        		<div class="footer_social">
        			<ul>
        				<li><a class="footer_social_facebook" href="https://www.facebook.com/wertewirtschaft" target="_blank" title="Besuche uns auf Facebook"></a></li>
        				<li><a class="footer_social_twitter" href="https://www.twitter.com/wertewirtschaft" target="_blank" title="Folge Scholarium auf Twitter"></a></li>
        				<li><a class="footer_social_xing" href="https://www.xing.com/companies/institutf%C3%BCrwertewirtschaft" target="_blank" title="Scholarium bei Xing"></a></li>
        				<li><a class="footer_social_youtube" href="https://www.youtube.com/user/Wertewirtschaft" target="_blank" title="Schau unsere Videos auf YouTube"></a></li>
        			</ul>
        		</div>
        	</div>
        </footer>
    </body>
</html>