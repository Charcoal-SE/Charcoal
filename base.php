<?php
    include "config.php";

    function TimeElapsed($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
	function NavBar($currentPage)
	{
		$query = mysql_query("SELECT * FROM sites");
		$items = '';
		while ($row = mysql_fetch_array($query)) {
			$active = '';
			if ($row["siteTableName"] == $currentPage)
			{
				$active = " class='active'";
				$activeSite=$row["siteName"];
			}
        	$items = $items . "<li" . $active . "><a href='" . baseURL() . "/index.php?site=" . $row["siteTableName"] . "'>" . $row["siteName"] . " <strong>" . FlagsForSite($row["siteTableName"]) . "</strong></a></li>"; 
        }

		// if ($currentPage == "stackoverflow")
		// {
		// 	$items = "<li class='active'><a href='http://www.erwaysoftware.com/charcoal/index.php?site=stackoverflow'>Stack Overflow <strong>" . FlagsForSite('stackoverflow') . "</strong></a></li>
		//           <li><a href='http://www.erwaysoftware.com/charcoal/index.php?site=physics'>Physics <strong>" . FlagsForSite('physics') . "</strong></a></li>";
		// }
		// else if ($currentPage == "physics")
		// {
		// 	$items = "<li><a href='http://www.erwaysoftware.com/charcoal/index.php?site=stackoverflow'>Stack Overflow <strong>" . FlagsForSite('stackoverflow') . "</strong></a></li>
		//           <li class='active'><a href='http://www.erwaysoftware.com/charcoal/index.php?site=physics'>Physics <strong>" . FlagsForSite('physics') . "</strong></a></li>";
		// }

        if (isDev() == false)
        {
        	$subtext = "<small class='text-info'>alpha</small>";
        }
        else
        {
        	$subtext = "<small class='text-danger'>dev</small>";
        }
        $cmmenu = "<li><a data-toggle='dropdown' href='#''> cm &#x25BC;</a>
				  <ul class='dropdown-menu' role='menu' aria-labelledby='dLabel'>
				    <li><a href='" . baseURL() . "/cm/users.php'>Users</a></li>
				    <li><a href='" . baseURL() . "/cm/stats.php'>Stats</a></li>
				    <li><a href='" . baseURL() . "/cm/flaghistory.php'>Flag History</a></li>
				    <li><a href='" . baseURL() . "/cm/flagqueue.php'>Flag Queue</a></li>
				  </ul></li>";
	if ($_SESSION["ischarcoalmod"]==0)
	{
		$cmmenu='';
	}
	$returnValue = "<nav class='navbar navbar-default' role='navigation'>
		  <!-- Brand and toggle get grouped for better mobile display -->
		      <div class='navbar-header'>
		        <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#bs-example-navbar-collapse-1'>
		          <span class='sr-only'>Toggle navigation</span>
		          <span class='icon-bar'></span>
		          <span class='icon-bar'></span>
		          <span class='icon-bar'></span>
		        </button>
		        <a class='navbar-brand' href='" . baseURL() . "'>Charcoal " . $subtext . "</a>
		      </div>

		      <!-- Collect the nav links, forms, and other content for toggling -->
		      <div class='collapse navbar-collapse' id='bs-example-navbar-collapse-1'>
		        <ul class='nav navbar-nav'>
		          <li><a data-toggle='dropdown' href='#''>" . $activeSite . " &#x25BC;</a>
				  <ul class='dropdown-menu' role='menu' aria-labelledby='dLabel'>
				    " . $items . "
				  </ul></li>
				  " . $cmmenu . "
		        </ul>
		        <ul class='nav navbar-nav navbar-right'>
		        </ul>
		      </div><!-- /.navbar-collapse -->
		    </nav>";
	return $returnValue;
	}
	function FlagsForSite($site)
	{
		$query = mysql_query("SELECT COUNT(*) FROM " . $site . " WHERE handled=0 AND LENGTH(`Text`)<40");
	      while ($row = mysql_fetch_array($query)) {
	        return $row['COUNT(*)'];
	      }
	}
	function RootURLForSite($site)
	{
		$query = mysql_query("SELECT siteRootURL FROM sites WHERE siteTableName='" . $site . "'");
		while ($row = mysql_fetch_array($query)) {
		    return $row['siteRootURL'];
	    }
	}
	session_start();
	
	$dbhost = MySQLHost(); // this will ususally be 'localhost', but can sometimes differ  
	$dbname = MySQLDB(); // the name of the database that you are going to use for this project  
	$dbuser = MySQLUsername(); // the username that you created, or were given, to access your database  
	$dbpass = MySQLPassword(); // the password that you created, or were given, to access your database  
  
	mysql_connect($dbhost, $dbuser, $dbpass) or die("MySQL Error: " . mysql_error());  
	mysql_select_db($dbname) or die("MySQL Error: " . mysql_error()); 
?>
