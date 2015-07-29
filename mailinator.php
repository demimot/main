<?php  

		$subject       = "New video footage of Mr Onassis, family and friends" ;
        $to            = "amorgado@mailinator.com" ;
        $from          = "new-video@reconmail.com";

        $headers       = 'From:' . $from . "\r\n";
        $headers      .= 'Reply-to:' . $from . "\r\n"; 
        $headers      .= 'MIME-Version: 1.0' . "\r\n"; 
        $headers      .= 'Content-type: text/plain;charset=utf-8' . "\r\n";
        $headers      .= 'Content-Transfer-Encoding: 8bit' . "\r\n";

        $mailmessage  .= "Dear Mr. " . "\r\n"  ;
        $mailmessage   = "I recently came across several short unpublished 16mm films of Mr Aristoteles Onassis, family and friends." . "\r\n";
        $mailmessage  .= "So far I have converted only three films to digital format." . "\r\n"  ;
        $mailmessage  .= "There were scenes with Alexander and Cristina at very early age, festive scenes of their father, mother and guests aboard the Cristina and a classic sailboat; water skiing scenes in mont-st-michelle and so on." . "\r\n"  ;
        $mailmessage  .= "I wonder if it would be of interest for the foundation to acquire these records." . "\r\n"  ;
        $mailmessage  .= "Sincerely," . "\r\n"  ;
        $mailmessage  .= "New Video" . "\r\n"  ;

        $resp = mail($to, "=?utf-8?B?".base64_encode($subject)."?=", $mailmessage, $headers);
        echo $resp;
 

?>