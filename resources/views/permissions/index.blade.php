<x-layout>
    <div class="d-flex justify-content-between">
        <h1 class="text-center d-inline">Permissions Page</h1>
        <div class="text-end">
            <a href="{{route('permissions.create')}}" class="btn btn-primary" style="margin-bottom: 10px;">
                Add new permission
            </a>
        </div>
    </div>

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">All permissions</h3>
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
                                        Name
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            @forelse($permissions as $permission)
                                <tr role="row" class="odd">
                                    <td class="">{{$permission->name}}</td>
                                    <td>
                                        <a href="{{route('permissions.edit', $permission->id)}}" class="btn btn-primary pull-left">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <form action="{{route('permissions.destroy', $permission->id)}}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger pull-left" style="margin-left: 5px;">
                                                <i class="fa fa-remove"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No permissions yet in database.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                <div class="row">
                </div>
        </div>
    </div>
</x-layout>
