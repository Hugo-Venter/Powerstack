
<div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">New Group</h3>
            <div class="row breadcrumbs-top d-inline-block">
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.html">Dashboard</a>
                  </li>
                  <li class="breadcrumb-item active">Groups / New
                  </li>
                </ol>
              </div>
            </div>
          </div>
          <div class="content-header-right col-md-4 col-12">
            <div class="btn-group float-md-right">
              <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon-settings mr-1"></i>Action</button>
              <div class="dropdown-menu arrow">
			  <a class="dropdown-item" href="#" onclick="javascript:document.getElementById('group-form').submit();"><i class="fa fa-save mr-1"></i>Save</a>
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
                <h4 class="card-title"><b>Group Details</b></h4>
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

						
						 <form class="form form-horizontal" id="group-form" action="<?php echo base_url('/index.php/groups/add_new'); ?>" method="post">
                      <div class="form-body">
                        <div class="form-group row">
                          <label class="col-sm-3 form-control-label" for="inputName1">Group Name</label>
                          <div class="col-sm-9">
                            <div class="position-relative has-icon-left">
                              <input class="form-control" type="text" name="groupName" id="groupName" value="">
                              <div class="form-control-position pl-1"><i class="fa fa-font"></i></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
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
