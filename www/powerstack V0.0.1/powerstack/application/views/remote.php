
<div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Remote Script Execution</h3>
            <div class="row breadcrumbs-top d-inline-block">
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html">Dashboard</a>
                  </li>
                  <li class="breadcrumb-item active">Remote Execution
                  </li>
                </ol>
              </div>
            </div>
          </div>
          <div class="content-header-right col-md-4 col-12">
            <div class="btn-group float-md-right">
              <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-settings mr-1"></i>Action</button>
              <div class="dropdown-menu arrow">
			  <a class="dropdown-item" href="#" onclick="javascript:send_request();"><i class="fa fa-power-off mr-1"></i>Execute</a>
              </div>
            </div>
          </div>
        </div>
        <div class="content-detached content-right">
          <div class="content-body">
	<?php 
							if (isset($script_details)){
						?>
						<?php 
						//echo $script_details[0]['name'];
						?><?php
						//echo $script_details[0]['description'];
						?>	  
		  
		  
<section class="input-groups" id="input-groups">
	<div class="row match-height">
	<?php
							$counter = 0;
							for ($i = 0; $i < count($clients);$i++){
								$counter++;
								$btn = "";
								if (date('Y-m-d') == date('Y-m-d', strtotime($clients[$i]['lastComs']))){
									$btn = "btn-success";
								}
								if ($clients[$i]['status'] == 0){
									$btn = "btn-purple";
								}

								?>
		<div class="col-xl-4 col-lg-6 col-md-12">
			<div class="card">
				<div class="card-body">
					<div class="card-block">
						<fieldset>
							<div class="input-group">
								<form action="<?php echo base_url('/index.php/clients/accounts'); ?>" id="form_<?php echo $clients[$i]['id']; ?>" method="post">
								<input type="hidden" name="client_id" value="<?php echo $clients[$i]['id']; ?>">
								<div class="btn-group float-md-right">
								<button class="btn btn-info dropdown-toggle width-200" id="<?php echo $clients[$i]['id']; ?>" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $clients[$i]['computerName'];?></button>
								<div class="dropdown-menu">
									<a class="dropdown-item" href="#" onclick="javascript:document.getElementById('form_<?php echo $clients[$i]['id']; ?>').submit();;"><i class="fa fa-info mr-1"></i>Details</a>
									<a class="dropdown-item" href="http://<?php echo $clients[$i]['ip']; ?>:3000/sysinfo" target="<?php echo $clients[$i]['id']; ?>"><i class="fa fa-desktop mr-1"></i>Sys Info</a>
									<a class="dropdown-item" href="#" onclick="javascript:http_send('<?php echo $clients[$i]['id']; ?>','<?php echo api_url('index.php/api/rescue/'); ?><?php echo $clients[$i]['computerName']?>')"><i class="fa fa-life-ring mr-1"></i>Rescue</a>
								<?php if ($clients[$i]['TVID'] > ''){ ?>
									<a class="dropdown-item" target="<?php echo $clients[$i]['id']; ?>" href="https://start.teamviewer.com/device/<?php echo $clients[$i]['TVID']; ?>/authorization/password/mode/control"><i class="fa fa-arrows-h mr-1"></i>Teamviewer</a>
								<?php } ?>
								</div>
								</div>
								</form>
							</div>
							<div id="res<?php echo $clients[$i]['id']; ?>" class="width-200" style="display : none">
							<center><a href="#" onclick="javascript:showresult(<?php echo $clients[$i]['id']; ?>);">Result</a></center>
							<div style="display : none; overflow: auto;" id="mes<?php echo $clients[$i]['id']; ?>">
							</div>
							</div>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
<?php
								} 
						?>
	</div>
</section>
<?php
							}
						?>
		  
		  

          </div>
        </div>
        <div class="sidebar-detached sidebar-left">
          <div class="sidebar"><div class="sidebar-content card d-none d-lg-block">
    <div class="card-body">
        <div class="category-title pb-1">
            <h4>Select Script.</h4>
        </div>
        <!-- Card sample -->
        <div class="text-center">
		<form action="" method="post">
            <div class="form-group">
				<select class="select2 form-control" name="script_id" onchange="submit();">
				<?php 
				
				if (!isset($script_id)){
					$script_id = 0;
				}
				for ($i = 0; $i < count($scripts);$i++){
					?>
				<option value="<?php echo $scripts[$i]['id']; ?>" <?php if ($script_id ==  $scripts[$i]['id']) { echo " selected"; } ?> ><?php echo $scripts[$i]['name'] ?></option>
				<?php
				}
				?>
					
				</select>
			</div>
           </form>   
        </div>
        
        <!-- /form sample -->
    </div>
</div>

          </div>
        </div>
      </div>
    </div>
<?php
if (isset($clients)){
?>
<script>

	var script = "<?php echo $script_details[0]['name']; ?>"
	const clients = [];
	var ips = [];
	
<?php
	for ($i = 0; $i < count($clients);$i++){
		$fp = @fsockopen($clients[$i]['ip'], 3000, $errno, $errstr, 0.1);
		if (!$fp) {
?>
	document.getElementById("<?php echo $clients[$i]['id']; ?>").style.backgroundColor = "#DA4453";	
<?php 
		} else {
			fclose($fp);
?>
	clients.push(<?php echo $clients[$i]['id']; ?>)
	ips.push("<?php echo $clients[$i]['ip']; ?>")
<?php
		}
	}
?>


function send_request(callback){

	for(var i=0, len=clients.length; i<len; i++){ 

		var turl = "http://" + ips[i] + ":3000/ps/invoke/"+script+"/"
		id = clients[i].toString();
		http_send(id, turl);
		
	}
}
function showresult(clientid){
	document.getElementById("mes" + clientid).style.display = "block";
}
function http_send(clientid, url){
	
	var xhttp = new XMLHttpRequest();
	xhttp.timeout = 50000
	xhttp.onreadystatechange = function(res) {
	if (this.readyState == 4 && this.status == 200) {
		console.log(xhttp.response);
		if (xhttp.response == "failed"){
			document.getElementById(clientid).style.backgroundColor = "#FFCE54";
			var but = document.getElementById(clientid).innerHTML;
			document.getElementById(clientid).innerHTML = but + " - failed";
		}else{
			var but = document.getElementById(clientid).innerHTML;
			document.getElementById("mes" + clientid).innerHTML = xhttp.response;
			document.getElementById(clientid).innerHTML = but + " - success";
			document.getElementById("res" + clientid).style.display = "block";
			document.getElementById(clientid).style.backgroundColor = "#1EAA8A";
		}
	}else{
		///console.log(this)
	}
	};
	xhttp.ontimeout = function (e) {
	console.log('the connection timed out');
	var but = document.getElementById(clientid).innerHTML;
	document.getElementById(clientid).innerHTML = but + " - timeout";
	document.getElementById(clientid).style.backgroundColor = "#636363";
	};
	xhttp.open("GET", url, true);
	xhttp.send();
}	

</script>
<?php
}
?>