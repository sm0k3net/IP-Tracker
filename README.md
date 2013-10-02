IP-Tracker
==========

Small IP Tracking system for website on PHP and MySQL

 == Install ==

 1. Upload script (ip_track.php)
 2. include "ip_track.php" in your page
 3. Import SQL script
 4. Configure "ip_track.php" to connect with your db
 5. Go to page and test...



 == Adds ==

 You can add additional fields on your page which will grab info from your DB and show on the page.  Just add following code where you want:
 
 * This field will show IP and link on WHOIS:  

<p>User: <noindex><a rel='nofollow' href=http://www.ip-adress.com/whois/<?php echo "$ipaddress";?> target=_blank> <?php echo "$ipaddress";?></a></noindex></p>

 
 * This field will show time when user came on your page:
 
 <?php echo "$timee";?>
 

 * This field will show page or request which user made:

 <noindex><a href='http://yoursite.com<?php echo "$requ";?>' target=_blank rel='nofollow'><?php echo "$requ";?></a></noindex>


 * This field will show user referer:
 
 <noindex><a rel='nofollow' href='<?php echo "$reff";?>' target=_blank><?php echo "$reff";?></a></noindex>
 

 * This field will show user-agent of user:

 <?php echo "$ag";?>
