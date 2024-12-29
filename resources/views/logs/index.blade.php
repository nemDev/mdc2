<x-layout>
    <div class="row">
        <div class="col-sm-12">
            <h2>{{ $title }}</h2>
        </div>
    </div>


    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
        <div class="row">

            <div class="col-sm-12">
                <table class="table table-bordered table-hover dataTable" >
                    <thead>
                        <tr role="row">
                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">ID#</th>
                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">User</th>
                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Import Type</th>
                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Import File</th>
                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Original File Name</th>
                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Status</th>
                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Create At</th>
                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($items as $item)
                        <tr role="row" class="odd">
                                <td class="sorting_1">
                                    {{$item->id}}
                                </td>
                                <td class="sorting_1">
                                    {{$item->user->username}}
                                </td>
                                <td class="sorting_1">
                                    {{ $importTypes[$item->import_type]['label'] }}
                                </td>
                                <td class="sorting_1">
                                    {{ $importTypes[$item->import_type]['files'][$item->import_type_file]['label'] }}
                                </td>
                                <td class="sorting_1">
                                    {{$item->original_name}}
                                </td>
                                <td class="sorting_1">
                                    @if(count($item->logs) > 0)
                                        <span class="label label-danger">Unsuccessful</span>
                                    @else
                                        <span class="label label-success">Successful</span>
                                    @endif
                                </td>
                                <td>
                                    {{$item->created_at}}
                                </td>
                                <td class="sorting_1">
                                    <div style="display: flex; gap: 5px;">
                                        <button class="btn btn-xs btn-primary logButton" data-id="{{$item->id}}">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-bold border">No data to display.</td>
                        </tr>
                    @endforelse
                </table>
                @if(count($items) != 0)
                    <div class="row">
                        <div class="col-sm-12">
                            {{ $items->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </div>





    </div>

    <div id="logsModal">
    </div>

    <x-slot name="script">
        <script>
            document.addEventListener('DOMContentLoaded', function(){
                const logButtons = document.getElementsByClassName('logButton');
                const logsModal = document.getElementById('logsModal');
                Array.from(logButtons).forEach(function (button) {
                    button.addEventListener('click', function (e){
                        var id = parseInt(button.getAttribute('data-id'))
                        e.preventDefault()
                        axios({
                            method: 'GET',
                            url: `/logs/${id}`
                        }).then(function (response) {
                            if(response.data.rows){
                                var rows = response.data.rows
                                var upload = response.data.upload
                                var body = '';
                                if(rows.length > 0){
                                    rows.forEach(row => {
                                        body += `<p><b>row:</b> ${row.row}, <b>column:</b> ${row.column}, <b>value:</b> ${row.fieldValueAtMoment}, <b>message:</b> ${row.message}</p>`
                                    })
                                }else{
                                    body = 'There are no errors.'
                                }
                                document.querySelector('body').classList.add('model-open')
                                logsModal.innerHTML = `<x-modal id='logs-modal' title='Logs for ${upload.import_type}-${upload.import_type_file}: ${upload.original_name}' body='${body}' style='display: block'/>`
                            }
                        }).catch(error => {
                            var body = 'Please try later or contact support.';
                            logsModal.innerHTML = `<x-modal id='logs-modal' title='Something went wrong' body='Try later or contact support.' style='display: block'/>`
                        }).finally(function () {
                            var modalCloseBtns = document.getElementsByClassName('modal-close')
                            Array.from(modalCloseBtns).forEach(function (btn) {
                                btn.addEventListener('click', function (){
                                    document.querySelector('body').classList.add('model-open')
                                    var modal = document.getElementById('logs-modal')
                                    modal.style.display = 'none';
                                })
                            })
                        });
                    })
                });
            })
        </script>
    </x-slot>
</x-layout>
