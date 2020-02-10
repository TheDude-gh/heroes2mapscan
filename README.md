Heroes II Map Reader
======


Author: The Dude from novapolis.net

Licence: GNU GENERAL PUBLIC LICENSE Version 3


### 1. BRIEF DESCRIPTION
---------------------------
  Heroes II Map Reader is web based application for reading Heroes II maps, displaying map's details, saving map to image and saving to sql database.

  Application is written in PHP, and uses MySQL database.

  You can see example here: [Heroes II Map Reader](http://heroes.novapolis.net/h2/mapindex.php)


### 2. REQUIREMENTS
---------------------------
  To run Heroes II Map Reader you will need web server with PHP and MySQL installed.

  The **heroes2db_struct.sql** contains structure for table to store map data.


### 3. INSTALLATION
---------------------------
  * Copy all the files to chosen folder on your webserver.

  * In **fun/config.php** file set paths to the required data and access to database. You can leave it as that if you copy data to these folders, or you can set your own.
     Also copy and rename **fun/access.def.php** to **fun/access.php** and setup database access data in it.


### 4. USAGE
---------------------------
  Open via browser the folder of the application. There are two scripts.


####  a) mapscan.php

     This script will scan map folder and display maps not yet processed and not saved in database.
     By clicking maps individually or by reading all, maps will be saved to database and map pictures created.


####  b) mapindex.php

     This script shows list of saved maps, and by clicking on any map, it will show more details.
     Those details are not very user friendly at some points, but the purpose of this application is to provide PHP map reader.
     The interpretation of map data is up to any Heroes II web map provider.
     The application does not display everything in web window, but it reads almost complete map data, like you would see in Heroes II map editor,
     like locations of any element, any texts, triggers, and so on. You could display those too, if you would desire so.

### 5. CREDITS
---------------------------
  **Heroes II ®**

  Big thanks to people working on **[fheroes2](https://github.com/ihhub/fheroes2)** project, which I used to study Heroes II map format.

  This application also uses 3rd party code, included in GIT:
  jQuery  https://jquery.com/ ... jQuery is under MIT license, so it is not under GNU GPLv3 like rest of this project. It is only included, so you don't have to obtain it yourself.


