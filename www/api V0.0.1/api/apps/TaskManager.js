//TASKMANAGER
var schedule = require('node-schedule');
var sqlite3 = require('sqlite3').verbose();
var fs = require('fs');
var XMLHttpRequest = require("xmlhttprequest").XMLHttpRequest;
var shell = require('node-powershell');


var log = function(process, errorcode, data){
	var datestamp = new Date().toISOString().slice(0, 19).replace('T', ' ');
	console.log(datestamp + ':' + process + " | " + errorcode + " | " + data + '\n\r');
}

var b = schedule.scheduleJob('*/6 * * * *', function(){
	var sceds = []; 
	function setApi(db, api){
		
		var xhr = new XMLHttpRequest();
		if (api == "none"){
			api = "";
			xhr.open('GET', 'https://api.mydomain.com:8082/index.php/api/scripts/default', true);
			log('PSTM','A001','Getting Default Scripts');
		}else{
			xhr.open('GET', 'https://api.mydomain.com:8082/index.php/api/scripts/', true);
			log('PSTM','A002','Getting registered Scritps');
		}
		xhr.timeOut = 50000;
		xhr.setRequestHeader('Powerstack-Key', api);

		xhr.onreadystatechange = function() {
			if(xhr.readyState == 4 && xhr.status == 200) {
				try
				{
				log('PSTM','A009','Getting Json Result');
				var jdata = JSON.parse(xhr.responseText);
					if (!isEmpty(jdata)){
        
						let sql = 'DELETE FROM scripts';
							db.run(sql, [], function(err) {
							if (err) {
								log('PSTM','ERR008','Could not delete scritps from DB ' + err);
							}
						});
						var scriptcount = 0;
        
						for (i = 0; i < jdata.length; i++) {
							scriptcount++;
							let data = [jdata[i]['id'], jdata[i]['name'], jdata[i]['data'], jdata[i]['location'], jdata[i]['type'],jdata[i]['cron'], jdata[i]['status']];
							let sql = 'INSERT INTO scripts(id,name,data,location,type,cron,status) VALUES(?,?,?,?,?,?,?)';
							db.run(sql, data, function(err) {
											
							if (err) {
								log('PSTM','ERR007','Could not insert script into DB ' + err);
								}
							});
						}
						log('PSTM','A003','Total scripts Inserted ' + scriptcount);
        
					}else{
						log('PSTM','ERR001','JSON Error');
					}
				}
				catch(e)
				{
					log('PSTM','ERR002',e + "HTTP error");
				}
			}else{
			}
		}
        
		xhr.send()
		
		//Write our scripts to disk 
		const { base64encode, base64decode } = require('nodejs-base64');
		db.each("SELECT *, ? as API FROM scripts",[api], (err, row5) => { 
			let content = base64decode(row5.data);
			
			
			if (row5.location > ''){
				var path = row5.location + '\\' + row5.name;
			}else{
				var path = row5.name;
			}
        
			if (content > ''){
				fs.writeFile(path, content, function (err, fd) {
						
					if (err) {
						log('PSTM','ERR003','Could not save file ' + path + err.message);
					}else{
						//now do the schedules
						log('PSTM','A0021','Script saved ' + path);
					}
				
				});
				log('PSTM','A0018',api);
				if (row5.status == 1){
			
					var id = row5.id;
					var id = id.toString();
			
					schedule.cancelJob(id);
					
					var j = schedule.scheduleJob(id, row5.cron, function(){
						if (row5.type == 1){
							var ps = new shell({
								executionPolicy: 'bypass',
								noProfile: true
							});
							
							ps.addCommand(".\\" + row5.location + "\\" + row5.name);
							ps.invoke()
							.then(output => {
							log('PSTM','A007','PS Executed :' + row5.name + " - " + output);
							})
							.then(newoutput =>{
								ps.dispose()
								.then(code => {
									log('PSTM','A008','PS Stopped :' + row5.name + " - " + code);
								})
								.catch(error => {
									log('PSTM','ERR004','PS Failed to Stop :' + row5.name + " - " + error);
								});
							})
							.catch(err => {
								log('PSTM','ERR005','PS Executed Failed:' + row5.name + " - " + err);
								ps.stop();
								ps.dispose();
							});
						}
						
						if (row5.type == 2){
							const { spawn } = require('child_process');
							child = spawn("node",['.\\' + row5.location + '\\' + row5.name, row5.API]);
							child.stdout.on("data",function(data){
								log('PSTM','A0017','JS Executed :' + row5.name + " - " + data);
								
							});
							child.stderr.on("data",function(data){
								log('PSTM','ERR004','JS Failed to Stop :' + row5.name + " - " + data);
							});
							child.on("exit",function(){
								log('PSTM','A0016','JS Finished :' + row5.name);
							});
							child.stdin.end(); //end input
						}
					})
				}
			}
		})
	}

	function getapi(callback){
		let db = new sqlite3.Database('./db/powerstack.db', sqlite3.OPEN_READWRITE | sqlite3.OPEN_CREATE, (err) => {
			if (err){
				log('PSTM','ERR006','Database connection error | ' + err);
			}
		});
		
		db.each("SELECT count(*) as counter FROM client", function(err, row1) {
			if (row1){
				if (row1.counter > 0){
					db.each("SELECT apiKey FROM client", function(err, row) {
						log('PSTM','A0015','Starting Task Scheduler');
						callback(db,row.apiKey);
					})
				}else{
					console.log('User not in db');
					log('PSTM','A0019','Client API not in DB');
					callback(db,"none");
				}
			}else{
				console.log('User not in db');
				log('PSTM','A0020','Client API not in DB');
				callback(db,"none");
			}
		})
	};
	
	var isEmpty = function(obj) {
		return Object.keys(obj).length === 0;
	}	
	
	getapi(setApi);
});