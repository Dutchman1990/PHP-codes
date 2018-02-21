<?php
//$email = $_REQUEST['email'] ;
//$message = $_REQUEST['message'] ;
require("PHPMailerAutoload.php");
$email="nirjhar.misrty@esolzmail.com";
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPDebug = 0;
$mail->Host = "smtp.gmail.com"; 
$mail->SMTPAuth = true;
$mail->Username = "wordpressjohnson@gmail.com";
$mail->Password = "Raj123321";
$mail->SMTPSecure = "tls";
$mail->port = 587;
$mail->SetFrom("nirjhar.misrty@esolzmail.com", "RedhotBetspro®");
//$mail->SetFrom = ('nirjhar.misrty@esolzmail.com', "Your Name");
$mail->AddAddress($email);
$mail->WordWrap = 50;
$mail->IsHTML(true);
$mail->Subject = "You have received feedback from your website!";
$message = '<html><body><div style="width: 100%; margin: 0 auto; text-align: center;">
   <div style="display: inline-block;width:550px; vertical-align: middle; padding: 20px; background-color:#ee1622;border-radius:0 25px 0 25px;">
      <table cellpadding="0" cellspacing="0" style="width:100%; vertical-align: top; background-color:#FFFFFF;margin: 0 auto 30px; padding: 20px 0;border-radius:25px 0 25px 0; font-size: 16px; text-align: left;">
         <tr>
            <td colspan="6" style="text-align:center;padding: 0 0 10px;"><a style="color:#01aec8;" href="http://southjerseywebdesign.com/prototypes/trimbleandarmano/"><img src="https://redhotbetspro.com/wp-content/uploads/2017/06/logo.png" alt="Trimble & Armano"></a></td>
         </tr>
         <tr>
            <td colspan="5" style=" padding: 15px 20px 5px 20px; text-decoration: italic;">
               <strong> Hello,</strong>
            </td>
         </tr>
         <tr>
            <td style=" padding: 10px 20px 5px 20px;">
               You have received an email from [text-657]<[email-398]>,
            </td>
         </tr>
         <tr>
            <td style=" padding: 10px 20px 5px 20px;">
               <strong>Message:</strong>
            </td>
          </tr>
          <tr>
            <td style=" padding: 10px 20px 5px 20px; color: #000">
              [textarea-705]
            </td>
         </tr>
      </table>
      <div style="color: white; text-align: center;font-size: 14px;">
         <p>© 2017 RedhotBetspro®, All Rights Reserved.</p>
      </div>
   </div>
</div> </body> </html>';
$mail->Body    = $message;
$mail->AltBody = $message;

if(!$mail->Send())
{
   echo "Message could not be sent. 
";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}

echo "Message has been sent";
?>
