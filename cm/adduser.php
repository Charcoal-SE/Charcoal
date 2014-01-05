<?php
  if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $_SESSION["ischarcoalmod"]==1)  
  {
    
  }
  else
  {
    echo 'You\'re not logged in!';
  }
