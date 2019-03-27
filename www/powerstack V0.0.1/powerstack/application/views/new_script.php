
<div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">New Script</h3>
            <div class="row breadcrumbs-top d-inline-block">
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html">Dashboard</a>
                  </li>
                  <li class="breadcrumb-item active">Scripts / New
                  </li>
                </ol>
              </div>
            </div>
          </div>
          <div class="content-header-right col-md-4 col-12">
            <div class="btn-group float-md-right">
              <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-settings mr-1"></i>Action</button>
              <div class="dropdown-menu arrow">
			  <a class="dropdown-item" href="#" onclick="javascript:document.getElementById('account-form').submit();"><i class="fa fa-save mr-1"></i>Save</a>
              </div>
            </div>
          </div>
        </div>
<div class="content-detached ">
          <div class="content-body"><section class="row">
    <div class="col-sm-12">
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

						
						 <form class="form form-horizontal" id="account-form" action="<?php echo base_url('/index.php/scripts/add_new'); ?>" method="post">
                      <div class="form-body">
                        <div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="inputName1">Script Name</label>
                          <div class="col-sm-9">
                            <div class="position-relative has-icon-left">
                              <input class="form-control" type="text" name="name" id="name" value="">
                              <div class="form-control-position pl-1"><i class="fa fa-font"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="inputEmail1">Description</label>
                          <div class="col-sm-9">
                            <div class="position-relative has-icon-left">
                              <input class="form-control" type="text" name="description" id="description" value="">
                              <div class="form-control-position pl-1"><i class="fa fa-align-justify"></i></div>
                            </div>
                          </div>
                        </div>
						<div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="inputMessage1">Data</label>
                          <div class="col-sm-9">
                            <div class="position-relative has-icon-left">
                              <textarea class="form-control" rows="5" id="data" name="data" value=""></textarea>
                              <div class="form-control-position pl-1"><i class="fa fa-database"></i></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="inputMessage1">Cron</label>
                          <div class="col-sm-9">
                            <div class="position-relative has-icon-left">
                              <input class="form-control" type="text" id="cron" name="cron" value="* * * * *">
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
<input type="checkbox" class="make-switch switchBootstrap" value="1" name="status" checked id="switchBootstrap1"/>
							</div>
							</fieldset>
                            </div>
                          </div>
                        </div>
						
						<div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="inputMessage1">Location</label>
                          <div class="col-sm-9">
                            <div class="position-relative has-icon-left">
                              <input class="form-control" type="text" id="location" name="location" value="ps / js">
                              <div class="form-control-position pl-1"><i class="fa fa-folder"></i></div> 
                            </div>
                          </div>
                        </div>
						<div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="inputMessage1">Script Type</label>
                          <div class="col-sm-9">
                            <div class="position-relative has-icon-left">
                              <select class="form-control" name="script_type" id="script_type">
								<option value="1">Powershell</option>
								<option value="2">Javascript</option>
							  </select>
                            </div>
                          </div>
                        </div>
						<div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="inputMessage1">Group</label>
                          <div class="col-sm-9">
                            <div class="position-relative has-icon-left">
                              <select class="form-control" id="groupId" name="groupId">
							   <?php
								$counter = 0;
								$checked = "";
								for ($i = 0; $i < count($groups);$i++){
								?>
									<option id="input-1" value="<?php echo $groups[$i]['id'];?>">
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
        <!--/ Kick start -->
    </div>
</section>

          </div>
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
}
</script>