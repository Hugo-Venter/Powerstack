
<div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Client Account Details</h3>
            <div class="row breadcrumbs-top d-inline-block">
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html">Dashboard</a>
                  </li>
                  <li class="breadcrumb-item active">Clients / Accounts
                  </li>
                </ol>
              </div>
            </div>
          </div>
          <div class="content-header-right col-md-4 col-12">
            <div class="btn-group float-md-right">
              <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-settings mr-1"></i>Action</button>
              <div class="dropdown-menu arrow">
			   <?php
			  if (isset($client_details)){
				?>
			  <a class="dropdown-item" href="#" onclick="javascript:enableedit();"><i class="fa fa-pencil mr-1"></i>Edit</a>
			  
			  <a class="dropdown-item" href="#" onclick="javascript:document.getElementById('account-form').submit();"><i class="fa fa-save mr-1"></i>Save</a>
			  <a class="dropdown-item" href="?delete=true&clientId=<?php echo $client_details[0]['id']; ?>"><i class="fa fa-trash mr-1"></i>Delete</a>
			 
				<a class="dropdown-item" href="#" onclick="javascript:http_send('<?php echo $client_details[0]['id']; ?>','<?php echo api_url('index.php/api/rescue/'); echo $client_details[0]['computerName']; ?>')"><i class="fa fa-life-ring mr-1"></i>Rescue</a>
				<a class="dropdown-item" href="#" onclick="javascript:http_send('<?php echo $client_details[0]['id']; ?>','http://<?php echo $client_details[0]['ip']; ?>:3000/ps/invoke/'+ document.getElementById('scripts').value + '/');"><i class="fa fa-power-off mr-1"></i>Execute</a>
			<?php
			  if ($client_details[0]['ip'] > ''){ ?>
			  <a class="dropdown-item" href="http://<?php echo $client_details[0]['ip']; ?>:3000/sysinfo" target="<?php echo $client_details[0]['id']; ?>"><i class="fa fa-desktop mr-1"></i>Sys Info</a>
			  <?php } ?>
			  <?php
			  if ($client_details[0]['TVID'] > ''){ ?>
			  <a class="dropdown-item" target="<?php echo $client_details[0]['id']; ?>" href="https://start.teamviewer.com/device/<?php echo $client_details[0]['TVID']; ?>/authorization/password/mode/control"><i class="fa fa-arrows-h mr-1"></i>Teamviewer</a>
			  <?php }
			  }	?>
              </div>
            </div>
          </div>
        </div>
        <div class="content-detached content-right">
          <div class="content-body"><section class="row">
    <div class="col-sm-12">
	
<?php 
if (isset($client_details)){
?>
        <!-- Kick start -->
        <div id="kick-start" class="card">
            <div class="card-header">
                <h4 class="card-title"><b>Client Details</b></h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <div class="card-text">

						
				<form class="form form-horizontal" id="account-form" action="<?php echo base_url('/index.php/clients/update'); ?>" method="post">
						 <input type="hidden" name="client_id" value="<?php echo $client_details[0]['id']; ?>">
                      <div class="form-body">
                        <div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="inputName1">Computer Name</label>
                          <div class="col-sm-9">
                            <div class="position-relative has-icon-left">
                              <input class="form-control" type="text" name="computerName" id="computerName" readonly value="<?php echo $client_details[0]['computerName']; ?>">
                              <div class="form-control-position pl-1"><i class="fa fa-desktop"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="inputEmail1">IP</label>
                          <div class="col-sm-9">
                            <div class="position-relative has-icon-left">
                              <input class="form-control" type="text" name="ip" id="ip" readonly value="<?php echo $client_details[0]['ip']; ?>">
                              <div class="form-control-position pl-1"><i class="fa fa-sitemap"></i></div>
                            </div>
                          </div>
                        </div>
						<div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="inputMessage1">Team Viewer ID</label>
                          <div class="col-sm-9">
                            <div class="position-relative has-icon-left">
                              <input class="form-control" type="text" id="TVID" name="TVID" readonly value="<?php echo $client_details[0]['TVID']; ?>">
                              <div class="form-control-position pl-1"><i class="fa fa-arrows-h"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="inputMessage1">API Key</label>
                          <div class="col-sm-9">
                            <div class="position-relative has-icon-left">
                              <input class="form-control" type="text" id="apiKey" readonly value="<?php echo $client_details[0]['apiKey']; ?>">
                              <div class="form-control-position pl-1"><i class="fa fa-key"></i></div>
                            </div>
                          </div>
                        </div>
						<div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="inputMessage1">Last Seen</label>
                          <div class="col-sm-9">
                            <div class="position-relative has-icon-left">
                              <input class="form-control" type="text" id="apiKey" readonly value="<?php echo $client_details[0]['lastComs']; ?>">
                              <div class="form-control-position pl-1"><i class="fa fa-eye"></i></div> 
                            </div>
                          </div>
                        </div>
						<div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="inputMessage1">Enabled</label>
                          <div class="col-sm-9">
                            <div class="position-relative has-icon-left">
							<fieldset>
              <div class="float-left">
                <input type="checkbox" class="make-switch switchBootstrap" value="1" <?php if ($client_details[0]['status'] == 1){ echo " checked"; }?> name="status" id="status"/>
              </div>
            </fieldset>
                            </div>
                          </div>
                        </div>
                      </div>
						<p></p>
						<div>
						</div>
                    </div>
                </div>
            </div>
			
        </div>
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><b>Groups</b></h4>

        </div>
          <div class="card-content">
          <div class="card-body">
			<div class="col-xl-6 col-lg-12">
			  <?php
				$counter = 0;
				for ($i = 0; $i < count($groups);$i++){
					$counter++;
					if ($counter == 6){
						echo "<br><br>";
						$counter = 0;
					}
					for ($x = 0; $x < count($client_groups);$x++){
						if ($client_groups[$x]['groupId'] == $groups[$i]['id']){
							$checked = "checked";
						}
					}
					?>
				<div class="custom-control custom-checkbox">
					<input type="checkbox" class="custom-control-input" name="groupIds[]" id="input-<?php echo $groups[$i]['id'];?>" value="<?php echo $groups[$i]['id'];?>" <?php echo $checked;?>>
					<label class="custom-control-label" for="input-<?php echo $groups[$i]['id'];?>"><?php echo $groups[$i]['name'];?></label>
                </div>
				<?php
					$checked = "";
				} 
				?>

				<input type="hidden" name="text" value="text">
              </div>
			  				
				
            </div>
          </div>
        </div>

	  </form>
<?php
	}
?>
        <!--/ Kick start -->
    </div>
</section>

          </div>
        </div>
        <div class="sidebar-detached sidebar-left">
          <div class="sidebar"><div class="sidebar-content card d-none d-lg-block">
    <div class="card-body">
        <div class="category-title pb-1">
            <h4>Select Client.</h4>
        </div>
        <!-- Card sample -->
        <div class="text-center">
		<form action="<?php echo base_url('/index.php/clients/accounts'); ?>" method="post">
            <div class="form-group">
				<select class="select2 form-control" name="client_id" onchange="submit();">
				<?php 
				
				if (!isset($client_id)){
					$client_id = 0;
				}
				for ($i = 0; $i < count($clients);$i++){
					?>
				<option value="<?php echo $clients[$i]['id']; ?>" <?php if ($client_id ==  $clients[$i]['id']) { echo " selected"; } ?> ><?php echo $clients[$i]['computerName'] ?> - <?php echo $clients[$i]['ip'] ?></option>
				<?php
				}
				?>
					
				</select>
			</div>
           </form>   
        </div>
        
        <!-- /form sample -->
    </div>
	<?php
	  if (isset($client_details)){
	?>
	<div class="sidebar"><div class="sidebar-content card d-none d-lg-block">
	<div class="card-body">
        <div class="category-title pb-1">
            <h4>Remote Execute Script.</h4>
        </div>
        <!-- Card sample -->
        <div class="text-center">

            <div class="form-group">
				<select class="select2 form-control" name="script_id" id="scripts">
				<?php 
				for ($i = 0; $i < count($scripts);$i++){
					?>
				<option value="<?php echo $scripts[$i]['name'] ?>"><?php echo $scripts[$i]['name'] ?></option>
				<?php
				}
				?>
					
				</select>
			</div>
 
        </div>
        
        <!-- /form sample -->
    </div>
	</div>
</div>
<?php
	  }
?>

          </div>
        </div>

        </div>
		
		
      </div>
    </div>
<script>
function enableedit(){
	document.getElementById('computerName').readOnly = false;
	document.getElementById('ip').readOnly = false;
	//document.getElementById('apiKey').readOnly = false;
	document.getElementById('TVID').readOnly = false;
}
function http_send(clientid, url){
	console.log(url);
	var xhttp = new XMLHttpRequest();
	xhttp.timeout = 50000
	xhttp.onreadystatechange = function(res) {
	if (this.readyState == 4 && this.status == 200) {
		console.log(xhttp.response);
		if (xhttp.response == "failed"){
			//document.getElementById(clientid).style.backgroundColor = "#FFCE54";
			//var but = document.getElementById(clientid).innerHTML;
			//document.getElementById(clientid).innerHTML = but + " - failed";
		}else{
			//var but = document.getElementById(clientid).innerHTML;
			//document.getElementById("mes" + clientid).innerHTML = xhttp.response;
			//document.getElementById(clientid).innerHTML = but + " - success";
			//document.getElementById("res" + clientid).style.display = "block";
			//document.getElementById(clientid).style.backgroundColor = "#1EAA8A";
		}
	}else{
		///console.log(this)
	}
	};
	xhttp.ontimeout = function (e) {
	console.log('the connection timed out');
	//var but = document.getElementById(clientid).innerHTML;
	//document.getElementById(clientid).innerHTML = but + " - timeout";
	//document.getElementById(clientid).style.backgroundColor = "#636363";
	};
	xhttp.open("GET", url, true);
	xhttp.send();
}	
</script>

