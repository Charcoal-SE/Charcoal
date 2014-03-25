Config
======

To use Charcoal, you'll need to tell it how to log in to MySQL. Create a PHP file called `config.php` in the root Charcoal directory in this format:

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
	   
	    function isDev(){
	    	return false;
	    }
	    function baseURL(){
	        if(isDev()){
	        	return "/charcoaldev";
	        }
	        return "/charcoal";
	    }
	    
Table Schema
============

Flags: 

    CREATE TABLE `flags` (
      `dbid` int(11) unsigned NOT NULL DEFAULT '0',
      `Id` int(11) DEFAULT NULL,
      `PostId` int(11) DEFAULT NULL,
      `Score` int(11) DEFAULT NULL,
      `CreationDate` timestamp NULL DEFAULT NULL,
      `UserDisplayName` text,
      `Text` text,
      `UserID` int(11) DEFAULT NULL,
      `wasObsolete` int(11) DEFAULT NULL,
      `handled` int(11) DEFAULT NULL,
      `handledBy` int(11) DEFAULT NULL,
      `wasValid` int(11) DEFAULT NULL,
      `handleDate` timestamp NULL DEFAULT NULL,
      `reason` text,
      `site` text,
      `lastCronCheck` timestamp NULL DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

Sites:

    CREATE TABLE `sites` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `siteTableName` text,
      `siteName` text,
      `siteRootURL` text,
      `lastCronCheck` timestamp NULL DEFAULT NULL,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

Users:

    CREATE TABLE `users` (
      `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
      `username` text,
      `password` text,
      `isDev` int(11) DEFAULT '0',
      `isVerified` int(11) DEFAULT '1',
      `link` text,
      `email` text,
      `apiKey` text,
      `ischarcoalmod` int(11) DEFAULT NULL,
      `isnetworkmod` int(11) DEFAULT NULL,
      `creationDate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
