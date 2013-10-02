IP-Tracker
==========

Small IP Tracking system for website on PHP and MySQL


 Components:<br>
 1) ip_track.php - main part, must be included on page you want to monitor<br>
 2) visitor_tracking.sql - SQL script to create DB<br>
 3) iptrack.php - simple example of admin panel with search field, works with visitor_tracking table if connect to DB
 
 
 == Install ==

 1. Upload script (ip_track.php)
 2. include "ip_track.php" in your page
 3. Import SQL script
 4. Configure "ip_track.php" to connect with your db
 5. Go to page and test


 == Adds ==

 You can add additional fields on your page which will grab info from your DB and show on the page.  Just add following code where you want:
 
 * This field will show IP and link on WHOIS:  

 User: href=http://www.ip-adress.com/whois/<?php echo "$ipaddress";?> target=_blank> <?php echo "$ipaddress";?>

 
 * This field will show time when user came on your page:
 
 <?php echo "$timee";?>
 

 * This field will show page or request which user made:

 href='http://yoursite.com<?php echo "$requ";?>' target=_blank rel='nofollow'><?php echo "$requ";?>


 * This field will show user referer:
 
 href='<?php echo "$reff";?>' target=_blank><?php echo "$reff";?>
 

 * This field will show user-agent of user:

 <?php echo "$ag";?>

 Hint! Just don't forget to add noindex and rel=nofollow so links won't be indexed with search engines
