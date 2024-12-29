<x-layout>
    <div class="row">
        <div class="col-sm-12">
            <h2>{{ $title }}</h2>
        </div>
    </div>
    <x-search :type="$type" :file="$file"/>
    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
        <div class="row">

            <div class="col-sm-12">
                <table class="table table-bordered table-hover dataTable" >
                    <thead>
                        <tr role="row">
                            @foreach($headers['header_to_db'] as $key => $header)
                            <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">{{$header['label']}}</th>
                            @endforeach
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($items as $item)
                        <tr role="row" class="odd">
                            @foreach($headers['header_to_db'] as $key => $header)
                                <td class="sorting_1">
                                    @if($item->$key)
                                        {{$item->$key}}
                                    @endif
                                </td>
                            @endforeach
                                <td class="sorting_1">
                                    <div style="display: flex; gap: 5px;">
                                        <button class="btn btn-xs btn-primary audit-button" data-id="{{ $item->id }}">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                        @can('have-permission', $permission)
                                            <form action="{{route('imports.destroy', [$type, $file, $item->id])}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-xs btn-danger" type="submit">
                                                    <i class=" fa fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{count($headers['header_to_db']) + 1 }}" class="text-center text-bold border">No data to display.</td>
                        </tr>
                    @endforelse
                </table>
            </div>
        </div>

        @if(count($items) != 0)
            <div class="row">
                <div class="col-sm-12">
                    {{ $items->links() }}
                </div>
            </div>
        @endif

    </div>

    <div id="auditsModal">
    </div>

    <x-slot name="script">
        <script>
            document.addEventListener('DOMContentLoaded', function(){
                const auditButtons = document.getElementsByClassName('audit-button');
                const auditsModal = document.getElementById('auditsModal');
                Array.from(auditButtons).forEach(function (button) {
                    button.addEventListener('click', function (e){
                        var id = parseInt(button.getAttribute('data-id'))
                        e.preventDefault()
                        axios({
                            method: 'GET',
                            url: `/imports/{{$type}}/{{$file}}/${id}/audits`
                        })
                        .then(function (response) {
                            if(response.data.rows){
                                var rows = response.data.rows
                                var upload = response.data.upload
                                var body = '';
                                if(rows.length > 0){
                                    rows.forEach(row => {
                                        body += `<p>${row.importType} ${row.importTypeFile} (Uploaded file id ${row.upload.id}): <br><b>row:</b> ${row.row}, <b>column:</b> ${row.column}, <b>old value:</b> ${row.old_value}, <b>new value:</b> ${row.new_value}</p>`
                                    })
                                }else{
                                    body = 'There are no audits.'
                                }
                                document.querySelector('body').classList.add('model-open')
                                auditsModal.innerHTML = `<x-modal id='audits-modal' title='Audits' body='${body}' style='display: block'/>`
                            }
                        })
                        .catch(error => {
                            var body = 'Please try later or contact support.';
                            logsModal.innerHTML = `<x-modal id='logs-modal' title='Something went wrong' body='Try later or contact support.' style='display: block'/>`
                        }).finally(function () {
                            var modalCloseBtns = document.getElementsByClassName('modal-close')
                            Array.from(modalCloseBtns).forEach(function (btn) {
                                btn.addEventListener('click', function (){
                                    document.querySelector('body').classList.remove('model-open')
                                    var modal = document.getElementById('audits-modal')
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
