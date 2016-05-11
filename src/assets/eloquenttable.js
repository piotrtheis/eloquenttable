$(function(){
	$('.delete-confirm-action').on('submit', function(e){

        var form_id = $(this).attr('id');

        e.preventDefault();

        $('#modal-from-dom').modal('show');

        $('#remove-action-confirm').click(function(){
            $('#' + form_id)[0].submit()
        });
    });
});