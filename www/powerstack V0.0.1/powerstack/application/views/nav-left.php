    <div class="main-menu menu-fixed menu-dark menu-accordion    menu-shadow " data-scroll-to-active="true">
      <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
			<li class=" nav-item"><a href="<?php echo base_url(''); ?>"><i class="icon-home"></i><span class="menu-title" data-i18n="nav.dash.main">Dashboard</span></a></li>
          <li class=" nav-item"><a href="#"><i class="icon-screen-desktop"></i><span class="menu-title" data-i18n="nav.dash.main">Clients</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?php echo base_url('/index.php/clients/accounts'); ?>" data-i18n="nav.dash.ecommerce">Accounts</a>
              </li>
            </ul>
          </li>
          <li class=" nav-item"><a href="#"><i class="icon-note"></i><span class="menu-title" data-i18n="nav.dash.main">Script</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?php echo base_url('/index.php/scripts/edit/'); ?>" data-i18n="nav.dash.ecommerce">Edit</a>
              </li>
              <li><a class="menu-item" href="<?php echo base_url('/index.php/scripts/add_new/'); ?>" data-i18n="nav.dash.project">Add New</a>
              </li>
              <li><a class="menu-item" href="<?php echo base_url('/index.php/scripts/remote/'); ?>" data-i18n="nav.dash.analytics">Remote Execute</a>
              </li>
            </ul>
          </li>
		  <li class=" nav-item"><a href="#"><i class="icon-frame"></i><span class="menu-title" data-i18n="nav.dash.main">Groups</span></a>
            <ul class="menu-content">
              <li><a class="menu-item" href="<?php echo base_url('/index.php/groups/edit/'); ?>" data-i18n="nav.dash.ecommerce">Edit</a>
              </li>
              <li><a class="menu-item" href="<?php echo base_url('/index.php/groups/add_new/'); ?>" data-i18n="nav.dash.project">Add New</a>
              </li>
            </ul>
          </li>
		  <li class=" nav-item"><a href="<?php echo base_url('/index.php/logs/get'); ?>"><i class="icon-book-open"></i><span class="menu-title" data-i18n="nav.dash.main">Logs</span></a></li>
		  <li class=" nav-item"><a href="<?php echo base_url('/index.php/download'); ?>"><i class="icon-cloud-download"></i><span class="menu-title" data-i18n="nav.dash.main">Download</span></a></li>
        </ul>
      </div>
    </div>