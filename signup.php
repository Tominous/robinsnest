<?php 
  // signup logic
  require_once 'header.php';
  // <<<_END means you can write anything you want in between the start and end as long as you use a similar tag
  // from the start to the finish.
  echo <<<_END
  <script>

    // could potentially be moved to javascript.js
    // script to check if user exists. Make a post request to checkuser.php
    function checkUser(user)
    {
      if (user.value == '')
      {
        O('info').innerHTML = ''
        return
      }
      //make ajax request to get the user - refer to w3schools for more details.
      params  = "user=" + user.value
      request = new ajaxRequest()
      request.open("POST", "checkuser.php", true)
      request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
      request.setRequestHeader("Content-length", params.length)
      request.setRequestHeader("Connection", "close")

      request.onreadystatechange = function()
      {
        // at this point, the request finished and response is ready
        if (this.readyState == 4)
          // the status of the request is 200, which means it is successful
          if (this.status == 200)
            if (this.responseText != null)
              O('info').innerHTML = this.responseText
      }
      request.send(params)
    }

    function ajaxRequest()
    {
      // for modern browser XMLHttpRequest object is used
      // for the older ones, ActiveXObject object is used. <- this is
      // unlikely since almost NOBODY uses ie5 - ie6 these days.
      // They are used to make ajax request.
      try { var request = new XMLHttpRequest() }
      catch(e1) {
        try { request = new ActiveXObject("Msxml2.XMLHTTP") }
        catch(e2) {
          try { request = new ActiveXObject("Microsoft.XMLHTTP") }
          catch(e3) {
            request = false
      } } }
      return request
    }
  </script>
  <div class='main'><h3>Please enter your details to sign up</h3>
_END;
  
  $error = $user = $pass = "";
  // if the session is active, destroy it.
  if (isset($_SESSION['user'])) destroySession();

  // registering new user to database
  if (isset($_POST['user']))
  {
    // sanitizing string to prevent injection, refer to functions.php
    $user = sanitizeString($_POST['user']);

    // password is unsalted, might want to encrypt it here!
    $pass = sanitizeString($_POST['pass']);
    // check if a user has filled in everything, if not throw an error
    if ($user == "" || $pass == "")
      $error = "Not all fields were entered<br><br>";
    // may want to add an extra field in here to confirm password!
    else
    {
      // if everything is filled check if user name exists
      $result = queryMysql("SELECT * FROM members WHERE user='$user'");

      if ($result->num_rows)
        $error = "That username already exists<br><br>";
      // if it doesn't exists, insert to db
      else
      {
        queryMysql("INSERT INTO members VALUES('$user', '$pass')");
        die("<h4>Account created</h4>Please Log in.<br><br>");
      }
    }
  }

  echo <<<_END
    <form method='post' action='signup.php'>$error
    <span class='fieldname'>Username</span>
    <input type='text' maxlength='16' name='user' value='$user'
      onBlur='checkUser(this)'><span id='info'></span><br>
    <span class='fieldname'>Password</span>
    <input type='text' maxlength='16' name='pass'
      value='$pass'><br>
_END;
?>

    <span class='fieldname'>&nbsp;</span>
    <input type='submit' value='Sign up'>
    </form></div><br>
  </body>
</html>
