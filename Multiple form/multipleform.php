<html>
<head>
<title>Multiple Forms</title>
<link href='http://fonts.googleapis.com/css?family=Droid+Serif' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="multipleform.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="multipleform.js"></script>
</head> 
<body> 
<div class ="container">
<h2>Dynamic Forms</h2>
<div id="selected_form_code">
 <select id="select_btn">
     <option value="">Select</option>
            <?php 
            for($i=1; $i<=10; $i++)
            {
                echo "<option value=".$i.">".$i."</option>";
            }
            ?>
 </select>
 </div>

	<div id="form1">	
		<form id="form_submit" action="#" method="post">
		 
		</form>
	</div> 
</div>
</body>b
</html>

<?php 
if(isset($_POST['submit'])){
    $to = "wordpressjohnson2gmail.com"; // this is your Email address
    $from = $_POST['email']; // this is the sender's Email address
    $name = $_POST['name'];
    $addresss = $_POST['address'];
    $subject = "Form submission";
    $subject2 = "Copy of your form submission";
    $message = $name . " wrote the following:" . "\n\n" . $_POST['message'];
    $message2 = "Here is a copy of your message " . $name . "\n\n" . $_POST['message'];

    $headers = "From:" . $from;
    $headers2 = "From:" . $to;
    mail($to,$subject,$message,$headers);
    mail($from,$subject2,$message2,$headers2); // sends a copy of the message to the sender
    echo "Mail Sent. Thank you " . $first_name . ", we will contact you shortly.";
    // You can also use header('Location: thank_you.php'); to redirect to another page.
    }
?>
