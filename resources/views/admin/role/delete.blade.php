<div class="modal fade" id="deleteRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete role ?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    function deleteRole(role_id) {
        $('.modal-body').text('');
        $('.modal-footer').text('');

        $('.modal-body').text('Select "Confirm" below if you are ready to delete');
        $('.modal-footer').append(
            `<a href="" class="btn btn-primary" onclick="submitDelete(${role_id})">Confirm</a>`);
    }

    function submitDelete(role_id) {
        var url = '{{ route('admin.role.delete') }}' + '?id=' + role_id;
        $.get(url), {
                '_token': '{{ csrf_token() }}',
            },
            function(data) {}
    }
</script>
