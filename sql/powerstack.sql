SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `clientGroups` (
  `id` bigint(20) NOT NULL,
  `clientId` bigint(20) NOT NULL,
  `groupId` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `clientGroups` (`id`, `clientId`, `groupId`) VALUES
(1, 97, 1);

CREATE TABLE `clients` (
  `id` bigint(20) NOT NULL,
  `computerName` varchar(50) DEFAULT NULL,
  `ip` varchar(15) DEFAULT NULL,
  `dateCreated` timestamp NULL DEFAULT current_timestamp(),
  `lastComs` timestamp NULL DEFAULT current_timestamp(),
  `apiKey` varchar(40) DEFAULT NULL,
  `TVID` int(12) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `clients` (`id`, `computerName`, `ip`, `dateCreated`, `lastComs`, `apiKey`, `TVID`, `status`) VALUES
(97, 'DESKTOP1', '192.168.0.145', '2019-03-16 11:03:01', '2019-03-27 18:49:00', 'a5a37a-fdc286-68e64b-193d05-c7aedf', 1234567890, 1);

CREATE TABLE `groups` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `groups` (`id`, `name`, `status`) VALUES
(1, 'Default', 1);

CREATE TABLE `log` (
  `id` bigint(20) NOT NULL,
  `clientId` bigint(20) NOT NULL,
  `process` varchar(20) NOT NULL,
  `errorcode` varchar(10) DEFAULT NULL,
  `data` text DEFAULT NULL,
  `datestamp` datetime DEFAULT NULL,
  `creationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `scripts` (
  `id` bigint(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `data` mediumtext NOT NULL,
  `location` varchar(100) NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 1,
  `cron` varchar(20) NOT NULL,
  `groupId` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `scripts` (`id`, `name`, `description`, `data`, `location`, `type`, `cron`, `groupId`, `status`) VALUES
(1, 'TaskManager.js', 'Main Task Manager script', '​​//TASKMANAGER\r\nvar schedule = require(\'node-schedule\');\r\nvar sqlite3 = require(\'sqlite3\').verbose();\r\nvar fs = require(\'fs\');\r\nvar XMLHttpRequest = require(\"xmlhttprequest\").XMLHttpRequest;\r\nvar shell = require(\'node-powershell\');\r\n\r\n\r\nvar log = function(process, errorcode, data){\r\n	var datestamp = new Date().toISOString().slice(0, 19).replace(\'T\', \' \');\r\n	console.log(datestamp + \':\' + process + \" | \" + errorcode + \" | \" + data + \'\\n\\r\');\r\n}\r\n\r\nvar b = schedule.scheduleJob(\'*/6 * * * *\', function(){\r\n	var sceds = []; \r\n	function setApi(db, api){\r\n		\r\n		var xhr = new XMLHttpRequest();\r\n		if (api == \"none\"){\r\n			api = \"\";\r\n			xhr.open(\'GET\', \'https://api.mrtekkie.co.za:8082/index.php/api/scripts/default\', true);\r\n			log(\'PSTM\',\'A001\',\'Getting Default Scripts\');\r\n		}else{\r\n			xhr.open(\'GET\', \'https://api.mrtekkie.co.za:8082/index.php/api/scripts/\', true);\r\n			log(\'PSTM\',\'A002\',\'Getting registered Scritps\');\r\n		}\r\n		xhr.timeOut = 50000;\r\n		xhr.setRequestHeader(\'Powerstack-Key\', api);\r\n\r\n		xhr.onreadystatechange = function() {\r\n			if(xhr.readyState == 4 && xhr.status == 200) {\r\n				try\r\n				{\r\n				log(\'PSTM\',\'A009\',\'Getting Json Result\');\r\n				var jdata = JSON.parse(xhr.responseText);\r\n					if (!isEmpty(jdata)){\r\n        \r\n						let sql = \'DELETE FROM scripts\';\r\n							db.run(sql, [], function(err) {\r\n							if (err) {\r\n								log(\'PSTM\',\'ERR008\',\'Could not delete scritps from DB \' + err);\r\n							}\r\n						});\r\n						var scriptcount = 0;\r\n        \r\n						for (i = 0; i < jdata.length; i++) {\r\n							scriptcount++;\r\n							let data = [jdata[i][\'id\'], jdata[i][\'name\'], jdata[i][\'data\'], jdata[i][\'location\'], jdata[i][\'type\'],jdata[i][\'cron\'], jdata[i][\'status\']];\r\n							let sql = \'INSERT INTO scripts(id,name,data,location,type,cron,status) VALUES(?,?,?,?,?,?,?)\';\r\n							db.run(sql, data, function(err) {\r\n											\r\n							if (err) {\r\n								log(\'PSTM\',\'ERR007\',\'Could not insert script into DB \' + err);\r\n								}\r\n							});\r\n						}\r\n						log(\'PSTM\',\'A003\',\'Total scripts Inserted \' + scriptcount);\r\n        \r\n					}else{\r\n						log(\'PSTM\',\'ERR001\',\'JSON Error\');\r\n					}\r\n				}\r\n				catch(e)\r\n				{\r\n					log(\'PSTM\',\'ERR002\',e + \"HTTP error\");\r\n				}\r\n			}else{\r\n			}\r\n		}\r\n        \r\n		xhr.send()\r\n		\r\n		//Write our scripts to disk \r\n		const { base64encode, base64decode } = require(\'nodejs-base64\');\r\n		db.each(\"SELECT *, ? as API FROM scripts\",[api], (err, row5) => { \r\n			let content = base64decode(row5.data);\r\n			\r\n			\r\n			if (row5.location > \'\'){\r\n				var path = row5.location + \'\\\\\' + row5.name;\r\n			}else{\r\n				var path = row5.name;\r\n			}\r\n        \r\n			if (content > \'\'){\r\n				fs.writeFile(path, content, function (err, fd) {\r\n						\r\n					if (err) {\r\n						log(\'PSTM\',\'ERR003\',\'Could not save file \' + path + err.message);\r\n					}else{\r\n						//now do the schedules\r\n						log(\'PSTM\',\'A0021\',\'Script saved \' + path);\r\n					}\r\n				\r\n				});\r\n				if (row5.status == 1){\r\n			\r\n					var id = row5.id;\r\n					var id = id.toString();\r\n			\r\n					schedule.cancelJob(id);\r\n					\r\n					var j = schedule.scheduleJob(id, row5.cron, function(){\r\n						if (row5.type == 1){\r\n							var ps = new shell({\r\n								executionPolicy: \'bypass\',\r\n								noProfile: true\r\n							});\r\n							\r\n							ps.addCommand(\".\\\\\" + row5.location + \"\\\\\" + row5.name);\r\n							ps.invoke()\r\n							.then(output => {\r\n							log(\'PSTM\',\'A007\',\'PS Executed :\' + row5.name + \" - \" + output);\r\n							})\r\n							.then(newoutput =>{\r\n								log(\'PSTM\',\'A007\',\'PS Stopped :\' + row5.name + \" - \" + newoutput);\r\n								ps.dispose()\r\n								.then(code => {\r\n									log(\'PSTM\',\'A008\',\'PS Stopped :\' + row5.name + \" - \" + code);\r\n								})\r\n								.catch(error => {\r\n									log(\'PSTM\',\'ERR004\',\'PS Failed to Stop :\' + row5.name + \" - \" + error);\r\n								});\r\n							})\r\n							.catch(err => {\r\n								log(\'PSTM\',\'ERR005\',\'PS Executed Failed:\' + row5.name + \" - \" + err);\r\n								ps.stop();\r\n								ps.dispose();\r\n							});\r\n						}\r\n						\r\n						if (row5.type == 2){\r\n							const { spawn } = require(\'child_process\');\r\n							child = spawn(\"node\",[\'.\\\\\' + row5.location + \'\\\\\' + row5.name, row5.API]);\r\n							child.stdout.on(\"data\",function(data){\r\n								log(\'PSTM\',\'A0017\',\'JS Executed :\' + row5.name + \" - \" + data);\r\n								\r\n							});\r\n							child.stderr.on(\"data\",function(data){\r\n								log(\'PSTM\',\'ERR004\',\'JS Failed to Stop :\' + row5.name + \" - \" + data);\r\n							});\r\n							child.on(\"exit\",function(){\r\n								log(\'PSTM\',\'A0016\',\'JS Finished :\' + row5.name);\r\n							});\r\n							child.stdin.end(); //end input\r\n						}\r\n					})\r\n				}\r\n			}\r\n		})\r\n	}\r\n\r\n	function getapi(callback){\r\n		let db = new sqlite3.Database(\'./db/powerstack.db\', sqlite3.OPEN_READWRITE | sqlite3.OPEN_CREATE, (err) => {\r\n			if (err){\r\n				log(\'PSTM\',\'ERR006\',\'Database connection error | \' + err);\r\n			}\r\n		});\r\n		\r\n		db.each(\"SELECT count(*) as counter FROM client\", function(err, row1) {\r\n			if (row1){\r\n				if (row1.counter > 0){\r\n					db.each(\"SELECT apiKey FROM client\", function(err, row) {\r\n						log(\'PSTM\',\'A0015\',\'Starting Task Scheduler\');\r\n						callback(db,row.apiKey);\r\n					})\r\n				}else{\r\n					console.log(\'User not in db\');\r\n					log(\'PSTM\',\'A0019\',\'Client API not in DB\');\r\n					callback(db,\"none\");\r\n				}\r\n			}else{\r\n				console.log(\'User not in db\');\r\n				log(\'PSTM\',\'A0020\',\'Client API not in DB\');\r\n				callback(db,\"none\");\r\n			}\r\n		})\r\n	};\r\n	\r\n	var isEmpty = function(obj) {\r\n		return Object.keys(obj).length === 0;\r\n	}	\r\n	\r\n	getapi(setApi);\r\n});', '', 2, '* * * * *', 1, 0),
(2, 'ping.js', 'Ping and Registration Script', '//PING\r\nvar sqlite3 = require(\'sqlite3\').verbose();\r\nvar os = require(\'os\');\r\nconst internalIp = require(\'internal-ip\');\r\nvar XMLHttpRequest = require(\"xmlhttprequest\").XMLHttpRequest;\r\n\r\nvar log = function(process, errorcode, data){\r\n	var datestamp = new Date().toISOString().slice(0, 19).replace(\'T\', \' \');\r\n	console.log(datestamp + \':\' + process + \" | \" + errorcode + \" | \" + data + \'\\n\\r\');\r\n}\r\n\r\nvar api = \'\';\r\n	var ip = internalIp.v4.sync()\r\n	var computerName = os.hostname();\r\n	var hostapi = \"\"\r\n	var params = \'ip=\' + ip + \'&computerName=\' + computerName;\r\n	\r\n	let db1 = new sqlite3.Database(\'./db/powerstack.db\', sqlite3.OPEN_READWRITE | sqlite3.OPEN_CREATE, (err) => {\r\n		if (err){\r\n			log(\'Ping\',\'Database connection error | \' + err);\r\n		}else{\r\n			//console.log(\'Connected to the database.\');\r\n			\r\n		}\r\n	});\r\n	\r\n	function setApi(api, type){\r\n		if(type == 0){\r\n			var xhr = new XMLHttpRequest()\r\n			\r\n			xhr.open(\'GET\', \'https://api.mydomain.com:8082/index.php/api/key?\' + params, true)\r\n			xhr.setRequestHeader(\'Powerstack-Key\',\"\")\r\n			xhr.onreadystatechange = function() {//Call a function when the state changes.\r\n				if(xhr.readyState == 4 && xhr.status == 200) {\r\n					var jdata = JSON.parse(xhr.responseText);\r\n					log(\'Ping\',\'ERR001\',\"Client has no APIKey : \" + jdata);\r\n					var hostapi = jdata.apiKey\r\n					if (hostapi){\r\n						db1.run(\'INSERT INTO client (apiKey) VALUES (?)\', [hostapi]);\r\n					}else{\r\n						log(\'Ping\',\'ERR002\',\"SERVER response did not include a API key\");\r\n					}\r\n\r\n				}else{\r\n					console.log(xhr.responseText);\r\n				}\r\n			}\r\n			xhr.send(params)\r\n		}else{\r\n	\r\n			var xhr = new XMLHttpRequest()\r\n			\r\n			xhr.open(\'GET\', \'https://api.mydomain.com:8082/index.php/api/ping?\' + params, true)\r\n			xhr.setRequestHeader(\'Powerstack-Key\', api)\r\n			xhr.onreadystatechange = function() {//Call a function when the state changes.\r\n				if(xhr.readyState == 4 && xhr.status == 200) {\r\n					var jdata = JSON.parse(xhr.responseText);\r\n				}else{\r\n					console.log(xhr.responseText);\r\n				}\r\n			}\r\n			xhr.send(params)\r\n		}\r\n	}\r\n	\r\n	function getapi(callback){\r\n		db1.each(\"SELECT count(*) as counter FROM client\", function(err, row) {\r\n			if (row.counter > 0){\r\n				//callback(row.apiKey, 1);\r\n				db1.each(\"SELECT apiKey FROM client\", function(err, row) {\r\n					callback(row.apiKey, 1);\r\n					//console.log(row.apiKey);\r\n				})\r\n			}else{\r\n				callback(\"\", 0);\r\n			}\r\n		})\r\n	};\r\n	getapi(setApi);', 'js', 2, '*/1 * * * *', 1, 1),
(3, 'API.js', 'Main Client Web API', "//CLIENT API\r\nconst express = require(\'express\')\r\nvar sqlite3 = require(\'sqlite3\').verbose();\r\nvar cors = require(\'cors\');\r\nconst app = express()\r\nconst port = 3000\r\napp.use(cors());\r\n\r\nvar log = function(process, errorcode, data){\r\n	var datestamp = new Date().toISOString().slice(0, 19).replace(\'T\', \' \');\r\n	console.log(datestamp + \':\' + process + \" | \" + errorcode + \" | \" + data + \'\\n\\r\');\r\n}\r\n\r\napp.get(\"/ps/invoke/:file\", (req, res, next) => {\r\n	var file = req.params.file;\r\n	var ext = file.split(\'.\').pop();\r\n	if (ext == \'ps1\'){\r\n		log(\'API\',\'A002\',\'Executing :\' + file);\r\n		var shell = require(\'node-powershell\');\r\n		\r\n		\r\n		var ps = new shell({\r\n			executionPolicy: \'bypass\',\r\n			noProfile: true\r\n		});\r\n		\r\n		ps.addCommand(\".\\\\ps\\\\\" + file);\r\n		ps.invoke()\r\n		.then(function(output){\r\n			console.log(output);\r\n			res.send(output);\r\n			\r\n		})\r\n		.then(function(newoutput){\r\n			log(\'API\',\'A007\',\'PS Stopped :\' + file + \" - \" + newoutput);\r\n			ps.dispose()\r\n			res.send(newoutput)\r\n			.then(code => {\r\n				log(\'API\',\'A008\',\'PS Stopped :\' + file + \" - \" + code);\r\n				res.send(code);\r\n			})\r\n			.catch(error => {\r\n				log(\'API\',\'ERR004\',\'PS Failed to Stop :\' + file + \" - \" + error);\r\n				res.send(\"failed\");\r\n			});\r\n		})\r\n		.catch(function(err){\r\n			console.log(err)\r\n			res.send(\"failed\");\r\n			ps.stop();\r\n			ps.dispose();\r\n		});\r\n	}\r\n	if (ext == \'js\'){\r\n		const { spawn } = require(\'child_process\');\r\n		if (file == \'TaskManager.js\'){\r\n			child = spawn(\"node\",[file]);\r\n		}else{\r\n			child = spawn(\"node\",[\'.\\\\js\\\\\' + file]);\r\n		}\r\n		log(\'API\',\'A002\',\'Executing :\' + file);\r\n		child.stdout.on(\"data\",function(data){\r\n			log(\'API\',\'A0017\',\'JS Executed :\' + file + \" - \" + data);\r\n			\r\n		});\r\n		child.stderr.on(\"data\",function(data){\r\n			log(\'API\',\'ERR004\',\'JS Failed to Stop :\' + file + \" - \" + data);\r\n		});\r\n		child.on(\"exit\",function(){\r\n			log(\'API\',\'A0016\',\'JS Finished :\' + file);\r\n		});\r\n		child.stdin.end();\r\n	}\r\n });\r\n\r\n app.get(\"/logs/\", (req, res, next) => {\r\n	let logdb = new sqlite3.Database(\'./db/log.db\', sqlite3.OPEN_READWRITE | sqlite3.OPEN_CREATE, (err) => {\r\n			if (err){\r\n				console.error(\"Database Connection error\");\r\n				res.send(\"error\");\r\n			}else{\r\n				//console.log(\'Connected to log database.\');\r\n			}\r\n		});\r\n		\r\n	logdb.all(\"SELECT * FROM log where syncstatus = 0\", function(err, rows) {\r\n		res.send(rows);\r\n		//logdb.close();\r\n	});\r\n	\r\n });\r\n \r\napp.get(\'/sysinfo\', function(req, res) {\r\n    res.sendFile(__dirname + \'/ps/SystemReport.html\');\r\n});\r\n \r\n app.get(\"/logs/update/:id\", (req, res, next) => {\r\n	var id = req.params.id;\r\n	let logdb = new sqlite3.Database(\'./db/log.db\', sqlite3.OPEN_READWRITE | sqlite3.OPEN_CREATE, (err) => {\r\n			if (err){\r\n				console.error(\"Database Connection error\");\r\n				res.send(\"error\");\r\n			}else{\r\n				//console.log(\'Connected to log database.\');\r\n			}\r\n		});\r\n		\r\n		let sql = \'update log set syncstatus = 1 where id = 35\' + id;\r\n		logdb.run(sql,[], function(err) {\r\n			if (err) {\r\n				res.send(\"error\");\r\n			}else{\r\n				//logdb.close();\r\n				res.send(\"ok\");\r\n			}\r\n		});\r\n	\r\n });\r\n // CREATE TABLE log (id INTEGER PRIMARY KEY AUTOINCREMENT, process TEXT,errorcode TEXT,data TEXT,datestamp DATETIME,syncstatus INT);\r\n \r\n app.get(\"/\", (req, res, next) => {\r\n	res.send(\'Hi\');\r\n 	res.end();\r\n });\r\napp.listen(port, () => log(\'API\',\'A001\',\'Powestack API Listenting on 3000\'))", '', 2, '* * * * *', 1, 0),
(4, 'RestartPrintSpool.ps1', 'Example script', 'Restart-Service -ServiceName \'Spooler\'\r\n\r\n$date = Get-Date -Format \"yyyy-MM-dd HH:mm:ss\"\r\nAdd-Type -Path \"C:\\Program Files\\System.Data.SQLite\\2010\\bin\\System.Data.SQLite.dll\"\r\n$con = New-Object -TypeName System.Data.SQLite.SQLiteConnection\r\n$con.ConnectionString = \"Data Source=C:\\Program Files (x86)\\PowerStack\\db\\log.db\"\r\n$con.Open()\r\n$sql = $con.CreateCommand()\r\n\r\n$sql.CommandText = \"INSERT INTO log (process,errorcode,data,datestamp,syncstatus) VALUES (@process,@errorcode,@data,@datestamp,@syncstatus)\"\r\n$sql.Parameters.AddWithValue(\"@process\", \'TEST\');\r\n$sql.Parameters.AddWithValue(\"@errorcode\", \'A002\');\r\n$sql.Parameters.AddWithValue(\"@data\", \'Restarted TEST Service\');\r\n$sql.Parameters.AddWithValue(\"@datestamp\", $date);\r\n$sql.Parameters.AddWithValue(\"@syncstatus\", 0);\r\n$sql.ExecuteNonQuery()\r\n$con.Close()', 'ps', 1, '*/15 * * * *', 2, 0),
(5, 'RestartPowerstack.ps1', 'Restart the Powerstack Task Manager and API services', 'Restart-Service -ServiceName \'Powerstack Task Manager\'\r\nRestart-Service -ServiceName \'Powerstack Web API\'', 'ps', 1, '* * * * *', 1, 0),
(6, 'APIServiceCheck.ps1', 'Checks if the API service is running and starts it if not', '$arrService = Get-Service -Name \"Powerstack Web API\"\r\n if ($arrService.Status -ne \"Running\"){\r\n Start-Service \"Powerstack Web API\"\r\n Write-Host \"Starting service\" \r\n }', 'ps', 1, '*/1 * * * *', 1, 1),
(7, 'LogCollector.js', 'Collect the logs and post to server', '//LOG COLLECTOR\r\nvar sqlite3 = require(\'sqlite3\').verbose();\r\nvar XMLHttpRequest = require(\"xmlhttprequest\").XMLHttpRequest;\r\n\r\nvar log = function(process, errorcode, data){\r\n	var datestamp = new Date().toISOString().slice(0, 19).replace(\'T\', \' \');\r\n	console.log(\'\\n\\r\' + datestamp + \':\' + process + \" | \" + errorcode + \" | \" + data + \'\\n\\r\');\r\n}\r\n\r\nvar api = process.argv.slice(2);\r\nlog(\'LOGS\',\'ERR005\',\'API:\' + api)\r\nvar xhr = new XMLHttpRequest()\r\n\r\nxhr.open(\'POST\', \'https://api.mydomain.com:8082/index.php/api/logs/\', true)\r\nxhr.timeOut = 50000;\r\nxhr.setRequestHeader(\'Powerstack-Key\',api)\r\nxhr.setRequestHeader(\"Content-Type\", \"application/json;charset=UTF-8\");\r\n\r\nlet logdb = new sqlite3.Database(\'./db/log.db\', sqlite3.OPEN_READWRITE | sqlite3.OPEN_CREATE, (err) => {\r\n	if (err){\r\n		log(\'LOGS\',\'ERR005\',\'\' + err)\r\n	}else{\r\n		//console.log(\'Connected to log database.\');\r\n	}\r\n});\r\n\r\nxhr.onreadystatechange = function() {//Call a function when the state changes.\r\n	if(xhr.readyState == 4 && xhr.status == 200) {\r\n		try\r\n		{\r\n			//console.log(\'LogCollector Getting Json Result\');\r\n			var jdata = JSON.parse(xhr.responseText);\r\n			log(\'LOGS\',\'A004\',\'HTTP response from server - \' + xhr.responseText);\r\n			if (!isEmpty(jdata)){\r\n				if (jdata[\'status\'] == true){\r\n					//if the response is true then set the log status to 1. \r\n					log(\'LOGS\',\'A0001\',\'Updating Log status to 1\')\r\n					var sql = \"UPDATE log set syncstatus = 1 where syncstatus = 0\";\r\n					logdb.run(sql, [], function(err) {\r\n						if (err){\r\n							log(\'LOGS\',\'ERR003\',\'Failed to update syncstatus to 1 - \' + err)\r\n						}\r\n						//logdb.close();\r\n					});\r\n				}else{\r\n					log(\'LOGS\',\'ERR007\',jdata)\r\n				}\r\n			}else{\r\n				log(\'LOGS\',\'ERR001\',\'Host json response empty\')\r\n			}\r\n		}\r\n		catch(e)\r\n		{\r\n			//do our logging here\r\n			log(\'LOGS\',\'ERR002\',\"Host responded with error - \" + xhr.responseText + \" - \" + e);\r\n\r\n		}\r\n		log(\'LOGS\',\'A0003\',xhr.responseText);\r\n	}else{\r\n		log(\'LOGS\',\'ERR006\',xhr.responseText);\r\n	}\r\n}\r\n\r\nlogdb.all(\"SELECT * FROM log where syncstatus = 0\", function(err, rows) {\r\n	log(\'LOGS\',\'A0002\',\'Sending logs to host\')\r\n	xhr.send(JSON.stringify(rows));\r\n	if (err){\r\n		log(\'LOGS\',\'ERR004\',\'Error sending logs to server - \' + err)\r\n	}\r\n\r\n});\r\n\r\nvar isEmpty = function(obj) {\r\n	return Object.keys(obj).length === 0;\r\n}	\r\n', 'js', 2, '*/5 * * * *', 1, 1),
(8, 'CleanLogs.js', 'Delete old logs from database', 'var sqlite3 = require(\'sqlite3\').verbose();\r\nlet logdb = new sqlite3.Database(\'../db/log.db\', sqlite3.OPEN_READWRITE | sqlite3.OPEN_CREATE, (err) => {\r\n	if (err){\r\n		console.error(datestamp + \": Log Database Connection error\");\r\n	}else{\r\n		//console.log(datestamp + \': Log Connected to the database.\');\r\n	}\r\n});\r\nvar d = new Date(); // Today!\r\nd.setDate(d.getDate() - 7); // Last week!\r\n\r\nlet sql = \"DELETE from log where syncstatus = 1 and datestamp > \'\" + d + \"\'\";\r\nlogdb.run(sql, [], function(err) {\r\n	if (err) {\r\n		//logdb.close()\r\n		console.log(err.message);\r\n	}\r\n})\r\nlogdb.close()', 'js', 2, '1 */4 * * *', 1, 1);


ALTER TABLE `clientGroups`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `scripts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `clientgroups`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `clients`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

ALTER TABLE `groups`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

ALTER TABLE `log`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;

ALTER TABLE `scripts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
