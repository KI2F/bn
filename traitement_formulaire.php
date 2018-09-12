<?php
/*
 * Script to send an email as the PHP mail() function is disabled.
 * The hosting company requires SMTP authentication etc.
 * need to install the pear mail package in the cPanel
 *
 * Use the support@myserver.com as the sending/from email 
 * (or maybe the welcome one?)
 *
 * Sunday, 11 october 2015 
 * G O’Rilla
 *
 * 
 */
 function pearMail( $e_mail, $subject, $content ) {
 /*
 // To ignore the Strict Standards (which are non fatal) change your error 
 // reporting level in the php.ini file or better, inline with error_reporting()
 */
 error_reporting(E_ERROR | E_PARSE);
# To use installed modules (cPanel - PHP Extensions and Applications Package Installer)
# Add “/home/myaccount/php” to the include path. To do this, add the following code to your script:
ini_set("include_path", '/home/myaccount/php:' . ini_get("include_path")  );

require_once 'Mail.php';

#Server host only allows SMTP authentication
/*
 * Use below setting for SMTP Authentication.
 * --
 * SMTP Host : myserver.com
 * SMTP User : Use domain email Address [xyz@myserver.com]
 * SMTP Password : Use domain email password.
 * SMTP Port : 25 
*/
//print "Start Script <br>";
$params = array();
$params["host"] = "localhost";              # - The server to connect. Default is localhost - use your domain name.
$params["port"] = 25;                            # - The port to connect. Default is 25.
// Error: return fron mailer: Failed to set sender: welcome@theappflap.com 
//[SMTP: Invalid response code received from server (code: 550, response: 
// Access denied - Invalid HELO name (See RFC2821 4.1.1.1))] 
// sever requires authentication so TRUE 
$params["auth"] = TRUE;                         # - Whether or not to use SMTP authentication. Default is FALSE.
$params["username"] = "oued.passo@gmail.com";  #- The username to use for SMTP authentication.
$params["password"] = "********”;                #- The password to use for SMTP authentication.

print_r ( $params );
//Other parameters assuming default values will do
#$params["localhost"] - The value to give when sending EHLO or HELO. Default is localhost
#$params["timeout"] - The SMTP connection timeout. Default is NULL (no timeout).
#$params["verp"] - Whether to use VERP or not. Default is FALSE.
#$params["debug"] - Whether to enable SMTP debug mode or not. Default is FALSE.
# Mail internally uses Net_SMTP::setDebug .
#$params["persist"] - Indicates whether or not the SMTP connection should persist over multiple calls to the send() method.
#$params["pipelining"] - Indicates whether or not the SMTP commands pipelining should be used.

 $rc = $mailer = & Mail::factory( "smtp", $params ); # creates a mailer instance
 if ( $rc == NULL ) {
     print "<br>Failed to create mail instance <br>";
 }
 else {
     print "<br>mail instance created <br>";
 }

 $recipients = $email; //'support@myserver.com';

$headers['From']    = 'welcome@myserver.com'; 
$headers['To']      = $email; //'support@myserver.com';   // Input param
$headers['Subject'] = $subject;  //'TAF: Test message';        // Input param

$body = $content;  //'This is a test using PEAR mailer';       // Input param

print ( "recipients: " . $e_mail . " subject: " . $subject . " content: " . $content . "<br>");

$rc = $mailer->send( $recipients, $headers, $body );
print ( "return from mailer; " . $rc );

//print "<br>End Script";
 }
?>