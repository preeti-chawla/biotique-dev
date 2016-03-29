<?php
//if "email" variable is filled out, send email
  //if (isset($_REQUEST['ramshekhar@studiosmile.com']))  {
if (isset($_POST['submit']))  {
  
  //Email information
  $admin_email = "vinothkumarjeyaraman@gmail.com";
  $email = $_REQUEST['jkpvino92@gmail.com'];
  $subject = $_REQUEST['TEST MAIL'];
  $comment = $_REQUEST['This is test from PHP'];
  
  //send email
  mail($admin_email, "$subject", $comment, "From:" . $email);
  
  //Email response
  echo "Thank you for contacting us!";
  }
  
  //if "email" variable is not filled out, display the form
  
?>

 <form method="post">
  Email: <input name="email" type="text" /><br />
  Subject: <input name="subject" type="text" /><br />
  Message:<br />
  <textarea name="comment" rows="15" cols="40"></textarea><br />
  <input type="submit" name="submit" value="Submit" />
  </form>
  
<?php
  
?>