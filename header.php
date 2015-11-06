<?php // Example 26-2: header.php
  session_start();

  echo "<!DOCTYPE html>\n<html><head>";

  require_once 'functions.php';

  // init the userstr variable for the title
  $userstr = ' (Guest)';
  
  // check check if there is an active session, if true set loggein in to true.
  if (isset($_SESSION['user']))
  {
    $user     = $_SESSION['user'];
    $loggedin = TRUE;
    $userstr  = " ($user)";
  }
  // if session is not detected set logged in to false
  else $loggedin = FALSE;

  echo "<title>$appname$userstr</title><link rel='stylesheet' " .
       "href='styles.css' type='text/css'>"                     .
       "</head><body><center><canvas id='logo' width='624' "    .
       "height='96'>$appname</canvas></center>"             .
       "<div class='appname'>$appname$userstr</div>"            .
       "<script src='javascript.js'></script>";

  // if logged in, show different menu with access to member priviledges.
  if ($loggedin)
  {
    echo "<br ><ul class='menu'>" .
         "<li><a href='members.php?view=$user'>Home</a></li>" .
         "<li><a href='members.php'>Members</a></li>"         .
         "<li><a href='friends.php'>Friends</a></li>"         .
         "<li><a href='messages.php'>Messages</a></li>"       .
         "<li><a href='profile.php'>Edit Profile</a></li>"    .
         "<li><a href='logout.php'>Log out</a></li></ul><br>";
  }
  // otherwise show login and sign up page
  else
  {
    echo ("<br><ul class='menu'>" .
          "<li><a href='index.php'>Home</a></li>"                .
          "<li><a href='signup.php'>Sign up</a></li>"            .
          "<li><a href='login.php'>Log in</a></li></ul><br>"     .
          "<span class='info'>&#8658; You must be logged in to " .
          "view this page.</span><br><br>");
  }
?>
