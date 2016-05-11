


<div id="modal-from-dom" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">
                {!! trans('eloquenttable::table.dialog.delete.header') !!}
            </h4>
        </div>
        <div class="modal-body">
            <p>{!! trans('eloquenttable::table.dialog.delete.body') !!}</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-success" data-dismiss="modal">
                {!! trans('eloquenttable::table.dialog.delete.buttons.cancel') !!}
            </button>
            <button type="button" class="btn btn-danger" id="remove-action-confirm">
                {!! trans('eloquenttable::table.dialog.delete.buttons.delete') !!}
            </button>
        </div>
        </div>
    </div>
</div>
