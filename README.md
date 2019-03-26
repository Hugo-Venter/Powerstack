
# What is Powerstack

Powerstack is a stack of development platforms, (nodejs,powershell,php,mysql - the stack) that enables admins to run and schedule run 
Powershell or Javascript scripts on a client computer using a centralized web interface.

*******************
## Server Requirements

Powerstack was mainly designed for administration of computers running a Windows operating system in a domain environment and was
tested only in the Windows 10 environment, but seeing that it uses open source software it could in theory run on any platform that supports
the stack. 

The current version requires Nodejs 10.X, PHP 7.X, Powershell 3 and the latest version of MySQL or Mariadb. 

OS: Windows 10 or Server 2016 with IIS 7.

*******************
## Release Information

The currency version is in ALPHA state and unstable. 

************
## Installation

Instructions will be provided in more detail later on. The current version is clunky to install and you require IT knowledge to get it 
running. 

#### Client install:

A binary installation file for the client software is provided in the bin directory. Once the client is installed on your user
computer.

Create a local or domain admin account on the user computer/domain controller and install the services by running the 
Install_Services.bat file as administrator. Stop the services and change the service run user as the admin account you 
created and start the services. 

Please note that port 3000 needs to open on the client computer.

#### Server install:

Install the required software, Mariadb/Mysql and PHP7.x and enable IIS if not enabled. Create a database and run the powerstack.sql 
on the database you create to create the db structure. 

You need to create two domains in IIS, one for your Web Admin panel and one for your API eg powerstack.mydomain.com and api.mydomain.com.
You could run these as one site if you like, you just need to copy the API to a sub-folder on your admin site.

Copy the respective folders to the root of the new websites. The websites run on CodeIgniter and you need to edit the config files 
for it to work correctly. 

In each of the sites edit the config.php and database.php files located in the application/config directory. Update the 
$config['base_url'] to your sites URL in the config.php and in the database.php set the db details username, password ect..

Finally you need to update your application pool user for the API site and set the Identity to the Admin user you created. 

***********
## Admin Panel

The admin panel is self explanatory. Clients will register as you install the software and visible under the client area. You can add 
Teamviewer ID's for each client if your want to use the feature. 

The dashboard currently only supports showing online clients and few other charts. Hopefully in the future you will be able to add
custom widgets to this page. 

Scripts can be added to groups and clients can be assigned to the groups. A client in a group will have access to execute the scripts
in the group. Clients need to be enabled otherwise they will only have access to the default script group. 

Adding scripts you can follow the example of the default scripts (TaskManager.js and API.js). If you want to enable scripts to run at
a schedule then fill in the cron field, this works the same as linux cron then enable the run as cron checkbox. If the run as cron 
checkbox is not checked then the script will only be able to execute at your command via the remote execution section.

Remote execution you can manually execute any script that you added to the Powerstack database. The computer that you access the Powerstack
web admin panel from needs to be connected to the same local network as the clients in order for the clients status to update correctly. 

If the scripts take long to execute then you will get a time out message result for each client. This does not mean that the scripts did
not execute correctly. 

****
## Cons

Not stable at the moment. 
The system is designed to run on a local network only with computers running on the same subnet. 
Opening ports on your servers and clients for this software is a major security risk. You are opening your system to run powershell
and javascript files as admin users. 
Only install if you feel that your local network is secure. I will be updating the software with more security features so please check for
new releases. 
Upgrading to a new version could be difficult. 

******************
## Code Contributions

Anyone who can help me improve this software and is willing to spend time on it would be appreciated. I require a Nodejs and Powershell
developer to improve the features, however any contributions would be appreciated. 

************
## Further help

No other documentation is currently provided. You can contact me directly for support. 

***
##### Ps.

Excuse the English. 
