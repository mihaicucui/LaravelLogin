window.jQuery = require('jquery');
window.$ = window.$ || jQuery;

$(function () {
    $("#menu-toggle").click(function (e) {
        console.log('entered');
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });

    $('.delete-btn').click(function (event) {
        $('#delete-modal-btn').attr('data-id', event.currentTarget.getAttribute('data-id'));
    })

    $('#delete-modal-btn').click(function () {

        $('#spinner').toggle();
        var client_id = $(this).attr('data-id');
        console.log('urlid=' + client_id);

        $.ajax({
            type: "DELETE",
            url: '/clients/' + client_id,
            data: {
                // _method: 'delete',
                "url_id": client_id,
                "_token": $('#token').val()
            },
            success: function (data) {
                if (data.status == 'success') {
                    $('#client-row-' + client_id).remove();
                } else {
                    alert('Error');
                }
                $('#deleteModal').modal('hide');
            },
            error: function (data) {
                alert('Error: ' + data);
            }
        });
    });
});
