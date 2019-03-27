
<div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Edit Scripts</h3>
            <div class="row breadcrumbs-top d-inline-block">
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html">Dashboard</a>
                  </li>
                  <li class="breadcrumb-item active">Scripps / Edit
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
if (isset($script_details)){
?>
			  <a class="dropdown-item" href="#" onclick="javascript:enableedit();"><i class="fa fa-pencil mr-1"></i>Edit</a>
			  <a class="dropdown-item" href="#" onclick="javascript:document.getElementById('account-form').submit();"><i class="fa fa-save mr-1"></i>Save</a>
			  <a class="dropdown-item" href="?delete=true&script_id=<?php echo $script_details[0]['id']; ?>"><i class="fa fa-trash mr-1"></i>Delete</a>
<?php
}
?>
              </div>
            </div>
          </div>
        </div>
<div class="content-detached content-right">
          <div class="content-body"><section class="row">
    <div class="col-sm-12">
	
<?php 
if (isset($script_details)){
?>
        <!-- Kick start -->
        <div id="kick-start" class="card">
            <div class="card-header">
                <h4 class="card-title"><b>Script Details</b></h4>
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

						
						 <form class="form form-horizontal" id="account-form" action="<?php echo base_url('/index.php/scripts/update');?>" method="post">
						 <input type="hidden" name="script_id" value="<?php echo $script_details[0]['id']; ?>">
                      <div class="form-body">
                        <div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="inputName1">Script Name</label>
                          <div class="col-sm-9">
                            <div class="position-relative has-icon-left">
                              <input class="form-control" type="text" name="name" id="name" readonly value="<?php echo $script_details[0]['name']; ?>">
                              <div class="form-control-position pl-1"><i class="fa fa-font"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="inputEmail1">Description</label>
                          <div class="col-sm-9">
                            <div class="position-relative has-icon-left">
                              <input class="form-control" type="text" name="description" id="description" readonly value="<?php echo $script_details[0]['description']; ?>">
                              <div class="form-control-position pl-1"><i class="fa fa-align-justify"></i></div>
                            </div>
                          </div>
                        </div>
						<div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="inputMessage1">Data</label>
                          <div class="col-sm-9">
                            <div class="position-relative has-icon-left">
                              <textarea class="form-control" id="data" rows="5" name="data" readonly value=""><?php echo $script_details[0]['data']; ?></textarea>
                              <div class="form-control-position pl-1"><i class="fa fa-database"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="inputMessage1">Cron</label>
                          <div class="col-sm-9">
                            <div class="position-relative has-icon-left">
                              <input class="form-control" type="text" id="cron" name="cron" readonly value="<?php echo $script_details[0]['cron']; ?>">
                              <div class="form-control-position pl-1"><i class="fa fa-calendar"></i></div>
                            </div>
                          </div>
                        </div>
						<div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="inputMessage1">Cron Enabled</label>
                          <div class="col-sm-9">
                            <div class="position-relative has-icon-left">
							<fieldset>
							<div class="float-left">
<input type="checkbox" class="make-switch switchBootstrap" <?php if ($script_details[0]['status'] == 1){ echo ' checked'; }; ?> value="1" name="status" id="switchBootstrap1"/>
							</div>
							</fieldset>
                            </div>
                          </div>
                        </div>
						
						<div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="inputMessage1">Location</label>
                          <div class="col-sm-9">
                            <div class="position-relative has-icon-left">
                              <input class="form-control" type="text" id="location" name="location" readonly value="<?php echo $script_details[0]['location']; ?>">
                              <div class="form-control-position pl-1"><i class="fa fa-folder"></i></div> 
                            </div>
                          </div>
                        </div>
						<div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="inputMessage1">Script Type</label>
                          <div class="col-sm-9">
                            <div class="position-relative has-icon-left">
                              <select class="form-control" name="script_type" id="script_type" disabled>
								<option value="1" <?php if ($script_details[0]['type'] == 1){ echo " selected"; }?>>Powershell</option>
								<option value="2" <?php if ($script_details[0]['type'] == 2){ echo " selected"; }?>>Javascript</option>
							  </select>
                            </div>
                          </div>
                        </div>
						<div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="inputMessage1">Group</label>
                          <div class="col-sm-9">
                            <div class="position-relative has-icon-left">
                              <select class="form-control" name="groupId" id="group" disabled>
							   <?php
								$counter = 0;
								$checked = "";
								for ($i = 0; $i < count($groups);$i++){

									if ($script_details[0]['groupId'] == $groups[$i]['id']){
										$checked = "selected";
									}
								?>
									<option id="input-1" value="<?php echo $groups[$i]['id'];?>" <?php echo $checked;?>>
									<label for="input-1 "><?php echo $groups[$i]['name'];?></label></option>

								<?php
									$checked = "";
								}
								?>
								</select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
						<p></p>
						<div>
						</div>
                    </div>
                </div>
            </div>
			
        </div>
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
            <h4>Select Script.</h4>
        </div>
        <!-- Card sample -->
        <div class="text-center">
		<form action="" method="post" action="<?php echo base_url('/index.php/scripts/edit');?>">
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
<script>
function enableedit(){
	document.getElementById('name').readOnly = false;
	document.getElementById('description').readOnly = false;
	//document.getElementById('apiKey').readOnly = false;
	document.getElementById('data').readOnly = false;
	document.getElementById('location').readOnly = false;
	document.getElementById('cron').readOnly = false;
	document.getElementById('group').disabled = false;
	document.getElementById('script_type').disabled = false;
	
}
</script>