<?php 


/* Init sction */
$registrant_email            = $_POST['VisitorEmail'];

$to                        = $registrant_email;
  
  
// set mail HTML content
$mailmessage               = "";
// set subject
$subject                   = "Demi Mot account e-mail confirmation: " . $registrant_email;
//introduction (e-mail)
$mailmessage               = '' . date("jS-M-Y") . "\r\n\r\n
Welcome to Demi Mot! \r\n\r\n
Please follow the link below to activate your Demi Mot account. \r\n\r\n
https://www.demimot.com/index3.php?page=759&newregID=" . $email_ID ."&accstr=" . $email_randomstr . "\r\n\r\n
If you have trouble using the link above in your e-mail client please copy and paste the url on your browser.\r\n\r\n
Thank you,\r\n\r\n
Demi Mot Team";

  
// set mail header (html)
$headers                  = 'From: Demi Mot <no-reply@demimot.com>' . "\r\n";
$headers                 .= 'Sender: info@demimot.com' . "\r\n";
$headers                 .= 'Reply-To: info@demimot.com' . "\r\n";
$headers                 .= 'MIME-Version: 1.0' . "\r\n"; 
$headers                 .= 'Content-type: text/plain;charset=utf-8' . "\r\n";
$headers                 .= 'Content-Transfer-Encoding: 8bit' . "\r\n";

  // mail($to,$subject,$mailmessage,$headers);  
mail($to, "=?utf-8?B?".base64_encode($subject)."?=", $mailmessage, $headers);

  // Now inform us ...
$to                        = "info@demimot.com";
$subject                   = "  New user registered - " . date("jS-M-Y");
$mailmessage               = '  account created: ' . $registrant_email . '
  
' . $mailmessage . '';
  
mail($to, "=?utf-8?B?".base64_encode($subject)."?=", $mailmessage, $headers);
  
/* End postponing redirectio */

?>