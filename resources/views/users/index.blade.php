<x-layout>
    <div class="" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 0;">
        <h1 class="">Users Page</h1>
        <div class="">
            <a href="{{route('users.create')}}" class="btn btn-primary" style="margin-bottom: 10px;">
                Add new user
            </a>
        </div>
    </div>

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">All users</h3>
        </div>
        <div class="box-body">
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                <div class="row">
                    <div class="col-sm-6"></div>
                    <div class="col-sm-6"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                                <tr role="row">
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column ascending">
                                        Username
                                    </th>
                                    <th class="sorting_desc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" aria-sort="descending">
                                        Email
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                        Permissions
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($users as $user)
                                <tr role="row" class="odd">
                                    <td class="">{{$user->username}}</td>
                                    <td class="sorting_1">{{$user->email}}</td>
                                    <td>
                                        @forelse($user->permissions as $permission)
                                            <span class="btn btn-primary btn-xs">{{$permission->name}}</span>
                                        @empty
                                            <span></span>
                                        @endforelse
                                    </td>
                                    <td>
                                        <a href="{{route('users.edit', $user->id)}}" class="btn-sm btn-primary pull-left">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <a href="/" class="btn-sm btn-danger pull-left" style="margin-left: 5px;">
                                            <i class="fa fa-edit"></i> Delete
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No users yet in database.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                <div class="row">
                    {{ $users->links() }}
                </div>
        </div>
    </div>
</x-layout>
