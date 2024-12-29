@props([
    'title' => 'Default title',
    'body' => ''
])
<div class="modal fade in" {{$attributes->merge(['style' => '', 'id'=>''])}}>
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header ">
                <h4 class="modal-title">{{$title}}</h4>
            </div>
            <div class="modal-body">
                {{ $body }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default modal-close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


