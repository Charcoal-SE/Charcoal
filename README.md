Config
======

To use Charcoal, you'll need to tell it how to log in to MySQL. Create a PHP file called `creds.php` in the root Charcoal directory in this format:

    <?php
	    function MySQLHost()
	    {
	      return "host";
	    }
	    function MySQLUsername()
	    {
		    return "username";
	    }
	    function MySQLPassword()
	    {
		    return "password";
	    }
	    function MySQLDB()
	    {
		    return "dbname";
	    }
