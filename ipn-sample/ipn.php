<?php

$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
  $keyval = explode ('=', $keyval);
  if (count($keyval) == 2)
     $myPost[$keyval[0]] = urldecode($keyval[1]);
}
// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) {
   $get_magic_quotes_exists = true;
} 
foreach ($myPost as $key => $value) {        
   if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
        $value = urlencode(stripslashes($value)); 
   } else {
        $value = urlencode($value);
   }
   $req .= "&$key=$value";
}

// STEP 2: Post IPN data back to paypal to validate

$ch = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr'); // change to [...]sandbox.paypal[...] when using sandbox to test
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
if( !($res = curl_exec($ch)) ) {
    curl_close($ch);
    exit;
}
curl_close($ch);

// STEP 3: Inspect IPN validation result and act accordingly

if (strcmp ($res, "VERIFIED") == 0) {
    $item_name = $_REQUEST['item_name'];
    $item_number = $_REQUEST['item_number'];
    $payment_status = $_REQUEST['payment_status'];
    $txn_type = $_REQUEST['txn_type'];
    $subscr_date = $_REQUEST['subscr_date'];
    $subscr_id = $_REQUEST['subscr_id'];
    //$user_ID = $_GET['user_ID'];
    $parent_txn_id = $_REQUEST['parent_txn_id'];
    $payment_amount = $_REQUEST['mc_gross'];
    /*if ($_REQUEST['mc_gross'] != NULL){
      $payment_amount = $_REQUEST['mc_gross'];
    }
    else{
      $payment_amount = $_REQUEST['mc_gross1'];
    }*/
    $payment_currency = $_REQUEST['mc_currency'];
    $txn_id = $_REQUEST['txn_id'];
    //$txn_id1 = $_GET['txn_id'];
    $receiver_email = $_REQUEST['receiver_email'];
    $payer_email = $_REQUEST['payer_email'];
    $custom = $_REQUEST['custom'];
    $firstname=$_REQUEST['first_name'];
    $lastname=$_REQUEST['last_name'];
    //$2ndemail='wordpressjohnson@gmail.com';
    /*$payment_status = isset( $_REQUEST['payment_status'] ) ? strtolower( $_REQUEST['payment_status'] ) : '';*/
    if($txn_type == 'subscr_payment' ){
    /*$servername = "localhost";
    $username = "lab5";
    $password = "Raj123321";
    $dbname = "redhotbetspro";
    $conn = new mysqli($servername, $username, $password, $dbname);
        
    // Check connection
$sql = "INSERT INTO wp_options (option_name, option_value,autoload)VALUES ('b','1','yes')";
    if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();*/
$link = mysql_connect('160.153.153.41:3313', 'redh41453966398', 'ieNU2T=7hdv');
if (!$link) {
die('Could not connect: ' . mysql_error());
}
echo 'Connected successfully';
mysql_select_db("redh41453966398", $link);
$sql = "INSERT INTO wp_rddwpwfszj_options (option_name, option_value,autoload) VALUES ('".$txn_id."', '".$subscr_id."','no')";
mysql_query($sql);
if(mysql_query($sql)==true){
  echo 'success';
}
mysql_close($link);

      /**
          mail function
      */

      $to    = $payer_email;
      $subject = 'Payment Confirmation';
      $message = '<html><body><div style="width: 100%; margin: 0 auto; text-align: center;">
   <div style="display: inline-block;width:550px; vertical-align: middle; padding: 20px; background-color:#ee1622;border-radius:0 25px 0 25px;">
      <table cellpadding="0" cellspacing="0" style="width:100%; vertical-align: top; background-color:#FFFFFF;margin: 0 auto 30px; padding: 20px 0;border-radius:25px 0 25px 0; font-size: 16px; text-align: left;">
         <tr>
            <td colspan="6" style="text-align:center;padding: 0 0 10px;"><a style="color:#01aec8;" href="https://redhotbetspro.com/"><img src="https://redhotbetspro.com/wp-content/uploads/2017/06/logo.png" alt="RedHotBetsPro"></a></td>
         </tr>
         <tr>
            <td colspan="5" style=" padding: 10px 20px 5px 20px; text-decoration: italic;">
               <strong> Dear '.$firstname.' '.$lastname.',</strong>
            </td>
         </tr>
         <tr>
            <td style=" padding: 10px 20px 5px 20px;">
               Thank you for purchasing our '.$item_name.' pack. We have received payment of $ '.$payment_amount.' via PayPal. Your Subscriber id and Transaction id are '.$subscr_id.' and '.$txn_id.'.
            </td>
         </tr>
         <tr>
            <td style=" padding: 10px 20px 5px 20px;">
               This is an auto generated email. Please do not reply to this message.
            </td>
         </tr>
      </table>
      <div style="color: white; text-align: center;font-size: 14px;">
         <p>© 2017 RedhotBetspro®, All Rights Reserved.</p>
      </div>
   </div>
</div> </body> </html>';

$headers = 'From:noreply@redhotbetspro.us' . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-type:text/html; charset=iso-8859-1\r\n";
      mail($to, $subject, $message, $headers);
    }
else if( $txn_type == 'subscr_cancel' ){
  $link1 = mysql_connect('160.153.153.41:3313', 'redh41453966398', 'ieNU2T=7hdv');
  if (!$link1) {
  die('Could not connect: ' . mysql_error());
  }
   mysql_select_db("redh41453966398", $link1);
  $subscr_id_find = "SELECT user_id FROM wp_rddwpwfszj_usermeta WHERE meta_value='$subscr_id'";
  $values = mysql_fetch_array(mysql_query($subscr_id_find));
  $useridd = $values['user_id'];
  
  $role= 'a:1:{s:9:"affiliate";b:1;}';
  /*
    update capabilities
  */
  $chnage_role = "UPDATE wp_rddwpwfszj_usermeta SET meta_value = '$role' WHERE user_id ='$useridd' AND meta_key ='wp_rddwpwfszj_capabilities'";
  mysql_query($chnage_role);
  /*
    update item number
  */
  $remove_item_no="UPDATE wp_rddwpwfszj_usermeta SET meta_value = NULL WHERE user_id ='$useridd' AND meta_key ='item_number'";
  mysql_query($remove_item_no);

  /*
    update pack value
  */
  $remove_packvalue="UPDATE wp_rddwpwfszj_usermeta SET meta_value = NULL WHERE user_id ='$useridd' AND meta_key ='mc_gross'";
  mysql_query($remove_packvalue);

  /*
  remove transaction id
  */
  $remove_txn_id="UPDATE wp_rddwpwfszj_usermeta SET meta_value = NULL WHERE user_id ='$useridd' AND meta_key ='transaction_id'";
  mysql_query($remove_txn_id);

  /*
    update subscriber id
  */
  $remove_subs_id="UPDATE wp_rddwpwfszj_usermeta SET meta_value = NULL WHERE user_id ='$useridd' AND meta_key ='subscriber_id'";
 mysql_query($remove_subs_id);

  /*
    update item name
  */
  $cancel_pack="UPDATE wp_rddwpwfszj_usermeta SET meta_value = NULL WHERE user_id ='$useridd' AND meta_key ='item_name'";
  mysql_query($cancel_pack);
  
  /*
    update subscription exiration date
  */
  $sub_expiry = "UPDATE wp_rddwpwfszj_usermeta SET meta_value =NULL WHERE user_id ='$useridd' AND meta_key ='subscription_expiry'";
  mysql_query($sub_expiry);

  /*
    mail trigger
  */

$to1    = $payer_email;
$subject1 = 'Subscription Cancelled';
$text1 = '<html><body><div style="width: 100%; margin: 0 auto; text-align: center;">
<div style="display: inline-block;width:550px; vertical-align: middle; padding: 20px; background-color:#ee1622;border-radius:0 25px 0 25px;">
<table cellpadding="0" cellspacing="0" style="width:100%; vertical-align: top; background-color:#FFFFFF;margin: 0 auto 30px; padding: 20px 0;border-radius:25px 0 25px 0; font-size: 16px; text-align: left;">
<tr>
<td colspan="6" style="text-align:center;padding: 0 0 10px;"><a style="color:#01aec8;" href="https://redhotbetspro.com/"><img src="https://redhotbetspro.com/wp-content/uploads/2017/06/logo.png" alt="RedHotBetsPro"></a></td>
</tr>
<tr>
<td colspan="5" style=" padding: 10px 20px 5px 20px; text-decoration: italic;">
   <strong> Dear '.$firstname.' '.$lastname.',</strong>
</td>
</tr>
<tr>
<td style=" padding: 10px 20px 5px 20px;">
   Your '.$useridd.' pack has been cancelled successfully against Subscriber ID: '.$subscr_id.'.
</td>
</tr>
<tr>
<td style=" padding: 10px 20px 5px 20px;">
   This is an auto generated email. Please do not reply to this message.
</td>
</tr>
</table>
<div style="color: white; text-align: center;font-size: 14px;">
<p>© 2017 RedhotBetspro®, All Rights Reserved.</p>
</div>
</div>
</div> </body> </html>';
 
 /*
    mail header
 */
$headers1 = 'From:noreply@redhotbetspro.us' . "\r\n";
$headers1 .= "MIME-Version: 1.0\r\n";
$headers1 .= "Content-type:text/html; charset=iso-8859-1\r\n";
      mail($to1, $subject1, $text1, $headers1);
    }
} else if (strcmp ($res, "INVALID") == 0) {
    // log for manual investigation
}
//wp_footer();
?>
