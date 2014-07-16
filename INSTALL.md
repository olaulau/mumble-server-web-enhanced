INTRO
=
This project is directly derivated from the sourcesfound in the old mumble-server-web package sources.
This package isn't available anymore, because it was very simple, and unmaintened. Thus, last version (under Ubuntu 12.04) didn't worked out-of-the-box.

-enhanced version has the same requirements as original,  so here are instructions to make the old package work on your system, which should ensure that -enhanced version will work.


The base
=
I'm going to cover installation under Ubuntu 12.04 & 14.04. You may have to adapt things a little for others distros.

A working Apache2 + PHP5 + Mumble-server is required.  
sample : `apt-get install apache2 php5 libapache2-mod-php5 mumble-server`
  

Ubuntu 12.04
=
`apt-get install mumble-server-web  
apt-get install php-zeroc-ice  
ln -s /usr/lib/php5/20090626+lfs/IcePHP.so /usr/lib/php5/20090626`

`cd /etc/php5/conf.d/  
vim ice.ini  
include_path = ".:/usr/share/Ice-3.4.2/php/lib/"`  

`cd /usr/share/slice  
slice2php -I /usr/share/Ice-3.4.2/slice /usr/share/slice/Murmur.ice  
cd /usr/share/mumble-server-web/www/  
ln -s /usr/share/slice/Murmur.php`  

`service apache2 restart`


Ubuntu 14.04
=
=> [ubuntu precise package download page](http://packages.ubuntu.com/precise-updates/all/mumble-server-web/download)  
`wget http://fr.archive.ubuntu.com/ubuntu/pool/universe/m/mumble/mumble-server-web_1.2.3-2ubuntu4.1_all.deb  
dpkg -i mumble-server-web_1.2.3-2ubuntu4.1_all.deb`  
(it mwill fail due to dependencies)  
`apt-get -f install  
apt-get install libcgi-session-perl  
dpkg -i mumble-server-web_1.2.3-2ubuntu4.1_all.deb  
ln -s /etc/apache2/conf.d/mumble-server-web.conf etc/apache2/conf-available/  
a2enconf mumble-server-web`  

`vim /etc/php5/mods-available/IcePHP.ini  
include_path = ".:/usr/share/Ice-3.5.1/php/lib/"`  

`cd /usr/share/slice  
slice2php -I /usr/share/Ice-3.5.1/slice/ /usr/share/slice/Murmur.ice  
cd /usr/share/mumble-server-web/www/  
ln -s /usr/share/slice/Murmur.php`  

`azegfzergrezgrg  
zegzergzergzergzergz`


Tests
=
=> [http://HOST/mumble-server/](http://HOST/mumble-server/)  
it should display (at least) someting like that :  

> SERVER #  
Name	Channel

and maybe a list of channel/player if  people are conencted to your mumble-server.


So ?
=
Now you can `git clone` the project in any directory served by Apache and  PHP, like any PHP app.  
I've included a `Murmur.php` symlink so that it can be run from anywhere (on the same host).

######Enjoy ;-)
