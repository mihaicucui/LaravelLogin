var $  = require( 'jquery' );
var dt = require( 'datatables.net' );



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

    $(document).ready(function (){
        $('#transactions-table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "/transactions/get",
            // "deferLoading":20000,
            "columns":[
                { "data": "id" },
                { "data": "client_id" },
                { "data": "amount" },
                { "data": "currency" },
                { "data": "status" },
                { "data": "client_name" }

            ]
            }
        );
    })

});
