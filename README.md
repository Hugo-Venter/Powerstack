
# What is Powerstack

Powerstack is a stack of development platforms, (nodejs,powershell,php,mysql - the stack) that enables admins to run and schedule run 
Powershell or Javascript scripts on a client computer using a centralized web interface.

*******************
## How does it work

The client installs node and has two services that run two Javascript files, TaskManager.js and API.js. The TaskManager.js file is responsible for scheduling, executing and getting new scripts from the Server API site. The API.js runs a local API on the client accesible to the server through port 3000 to allow it remotely execute Scripts on the client.

The client services can function in a offline state and still execute scripts allocated to it and will report back to the server once it is online.  

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
computer run the Install_Services.bat file as administrator located in the install directory eg C:\Program Files (x86)\Powerstack\. It will attempt to create a local administrator user called "Powerstack" with a default password, please reset the password for this user.

The client does not yet know where your server is located. Update the TaskManager.js and API.js files with the domain name of your server. Replace the lines mydomain.com with your domain.

Edit the properties of each service and set the run as user to the admin accounts that was created "Powerstack". 

You can now start the services or wait and install your server first.

Please note that port 3000 needs to open on the client computer.

#### Server install:

Install the required software, Mariadb/Mysql and PHP7.x and enable IIS if not enabled. Create a database and run the powerstack.sql 
on the database you create to create the db structure. 

You need to create two domains in IIS, one for your Web Admin panel and one for your API eg powerstack.mydomain.com and api.mydomain.com.
You could run these as one site if you like, you just need to copy the API to a sub-folder on your admin site.

Copy the respective folders to the root of the new websites. The websites run on CodeIgniter and you need to edit the config files 
for it to work correctly. 

In each of the sites edit the config.php and database.php files located in the application/config directory. Update the 
$config['base_url'] and $config['api_url'] for both sites to your URL in the config.php and in the database.php set the db details username, password ect..

Open your database or edit the scripts through the admin panel and update the TaskManger.js and API.js scripts in the scripts table by replacing the mydomain.com lines with the URI of your newly created site.

If you want to use the rescue feature then update the powershell script in the apps directory of the API site with correct details. There will also be a default TaskManager.js script that you need to update with your domain names. The rescue function is usefull to revert your clients TaskManager.js to a stable version if you pushed a updated TaskManager.js to clients and something went wrong. 

Finally you need to update your application pool user for the API site and set the Identity to the Admin user you created.

You can now start the services on your client computer.  

***********
## Admin Panel

The admin panel is self explanatory. Clients will register as you install the software and visible under the client area. You can add 
Teamviewer ID's for each client if your want to use the feature. 

The dashboard currently only supports showing online clients and few other stats. In the future you will be able to add
custom widgets to this page. 

Scripts can be added to groups and clients can be assigned to the groups. A client in a group will have access to execute the scripts
in the group. Clients need to be enabled otherwise they will only have access to the "default" script group. 

For adding scripts you can follow the example of the default scripts (TaskManager.js, API.js and RestartPrintService.ps1). If you want to enable scripts to run at schedule then fill in the cron field, this works the same as linux cron then enable the run as cron checkbox. If the run as cron checkbox is not checked then the script will only be able to execute at your command via the remote execution section.

With Remote execution you can manually execute any script that you added to the Powerstack database. The computer that you access the Powerstack web admin panel from needs to be connected to the same local network as the clients in order for you to remotly excute scirpts on the clients and for the status buttons to update correclty. 

If the scripts take long to execute then you will get a time out message result for each client. This does not mean that the scripts did
not execute correctly. 

****
## Logs

Each client has a SQLite database to log events. These events will periodically be posted to the servers log database. You can look at the Print Spooler example script to log enteries into the SQLite database. The default LogCollector.js files is responsible for sending the logs to the server. You can update this scipts cron to your needs. Keep in mind that the more log entries you put in the SQLite db on the client the more time the LogCollector would need to push the logs to the server. So best to keep it running in short intervals. 

Console output is located under the deomon folder. The output files log anything that the scipts might have outputted to the console. You can use these to monitor any new client scripts you add to the system for errors or default console outputs you have in your scripts. 

In the example script you will notice a log function that follows a format to output events to the console. You can use this functions in your own scripts or update it to your needs to keep the console log file nice and clean. 

Powershell does not come with a default module to connect to sqlite databases so if you want to log anything via powershell to the sqlite datbases you need to download sqllite-netFx drivers and install it on the client computers. 

I could have added this to the Bin install file but due to a bug in the sqlite installer it could restart your client computer with warning, so please install this manually depending on your powershell version. https://system.data.sqlite.org/index.html/doc/trunk/www/downloads.wiki

Currently there is no option to view the logs on the server web interface. Hoping to add this soon using some open source BI software, any suggestions welcome. 

****
## Cons

Not stable at the moment. 
The system is designed to run on a local network only with computers running on the same subnet. 
Opening ports on your servers and clients for this software is a security risk. 
Only install if you feel that your local network is secure. I will be updating the software with more security features so please check for new releases.
Upgrading to a new version could be difficult. 

******************
## Code Contributions

Anyone who can help me improve this software and is willing to spend time on it would be appreciated. I require a Nodejs and Powershell
developer to improve the features, however any contributions would be appreciated. 

************
## Wants

Web installer for the server interface and API.
Client installer features to update the server URI in the js files and create the admin user for the run as user. 
Download the required extentions depending on the Powershell version. 
Automatic updates from the server when a new client is release. 
User login for the server interface.

************
## Further help

You can contact me directly for support. 

***
##### Ps.

Excuse the English. 
