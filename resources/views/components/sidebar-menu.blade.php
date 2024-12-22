
<ul class="sidebar-menu" data-widget="tree">
    @can('user-management')
        <x-sidebar-menu-nav-link
            icon="fa fa-users"
            label="User management"
            :url="route('users.index')"
            :active="str_contains(request()->path(), 'users') || request()->is('permissions')"
            :sublinks="[['label' => 'Users' , 'url'=>'users'], ['label' => 'Permissions' , 'url'=>'permissions']]"
        />
    @endcan

    <x-sidebar-menu-nav-link
        icon="fa fa-cubes"
        label="Data Import"
        :url="route('imports.create')"
        :active="request()->is('imports/upload')"
    />

    <x-sidebar-menu-nav-link
        icon="fa fa-line-chart"
        label="Imported data"
        url="importeddata"
        :active="request()->is('test')"
        :sublinks="$importersLinks"

    />
    <x-sidebar-menu-nav-link
        icon="fa fa-cubes"
        label="Imports"
        url="imports"
        :active="request()->is('imports')"
    />

</ul>
