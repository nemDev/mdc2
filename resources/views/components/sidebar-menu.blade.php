
<ul class="sidebar-menu" data-widget="tree">
    @can('user-management')
        <x-sidebar-menu-nav-link
            icon="fa fa-users"
            label="User management"
            :url="route('users.index')"
            :active="request()->is('users') || request()->is('users/*') || request()->is('permissions') || request()->is('permissions/*')"
            :sublinks="[['label' => 'Users' , 'url'=>'users'], ['label' => 'Permissions' , 'url'=>'permissions']]"
        />
    @endcan

    @can('can-import')
    <x-sidebar-menu-nav-link
        icon="fa fa-cubes"
        label="Data Import"
        :url="route('imports.create')"
        :active="request()->is('imports/upload')"
    />
    @endcan
    <x-sidebar-menu-nav-link
        icon="fa fa-line-chart"
        label="Imported data"
        url="importeddata"
        :active="request()->is('imports/*') && !request()->is('imports/upload')"
        :sublinks="$importersLinks"

    />
    <x-sidebar-menu-nav-link
        icon="fa fa-cubes"
        label="Imports"
        :url="route('logs.index')"
        :active="request()->is('logs')"
    />

</ul>
