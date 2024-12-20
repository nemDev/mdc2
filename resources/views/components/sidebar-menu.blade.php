<ul class="sidebar-menu" data-widget="tree">
    <!-- Optionally, you can add icons to the links -->
    <li class="active"><a href="#"><i class="fa fa-users" aria-hidden="true"></i> <span>User management</span></a></li>
    <li><a href="#"><i class="fa fa-cubes"></i> <span>Data import</span></a></li>
    <li class="treeview">
        <a href="#"><i class="fa fa-line-chart"></i> <span>Imported data</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
        </a>
        <ul class="treeview-menu">
            <li><a href="#">Link in level 2</a></li>
            <li><a href="#">Link in level 2</a></li>
        </ul>
    </li>
    <x-sidebar-menu-nav-link
        icon="fa fa-line-chart"
        label="Imported data"
        url="imported"
        :active="request()->is('test')"
    />
    <x-sidebar-menu-nav-link
        icon="fa fa-cubes"
        label="Imports"
        url="imports"
        :active="request()->is('imports')"
    />

</ul>
