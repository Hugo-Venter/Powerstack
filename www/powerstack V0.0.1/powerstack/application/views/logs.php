
<link rel="stylesheet" href="<?php echo base_url('/app-assets/css/excel-bootstrap-table-filter-style.css'); ?>" />
<div class="app-content content">
      <div class="content-wrapper">
        <div class="content-header row">
          <div class="content-header-left col-md-8 col-12 mb-2 breadcrumb-new">
            <h3 class="content-header-title mb-0 d-inline-block">Logs</h3>
            <div class="row breadcrumbs-top d-inline-block">
              <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="index.php">Dashboard</a>
                  </li>
                  <li class="breadcrumb-item active">Logs
                  </li>
                </ol>
              </div>
            </div>
          </div>
        <div class="content-detached content-right">
          <div class="content-body"><section class="row">
			<div class="col-sm-12">
				<!-- Kick start -->
				<div id="kick-start" class="card">

					<div class="card-content collapse show">
						<div class="card-body">
							<div class="card-text">
							<table id="table" class="table table-striped table-bordered dataex-fixh-basic">
								<thead>
								<tr>
									<th>Client</th>
									<th>Process</th>
									<th>Code</th>
									<th>Message</th>
									<th>Date</th>
								</tr>
								</thead>
								<tbody>
								<?php
								for ($i = 0; $i < count($logs);$i++){
								?>
								<tr>
									<td><?php echo $logs[$i]['computerName'] ?></td>
									<td><?php echo $logs[$i]['process'] ?></td>
									<td><?php echo $logs[$i]['errorcode'] ?></td>
									<td><?php echo $logs[$i]['data'] ?></td>
									<td><?php echo $logs[$i]['datestamp'] ?></td>
								</tr>
								<?php
								}
								?>
								</tbody>
							</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
		</div>
	</div>
</div>

