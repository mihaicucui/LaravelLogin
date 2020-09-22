var $ = require('jquery');
var dt = require('datatables.net');


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

    $(document).ready(function () {
        $('#transactions-table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "/transactions/get",
                // "deferLoading":20000,
                "columns": [
                    {"data": "id"},
                    {"data": "client_id"},
                    {"data": "amount"},
                    {"data": "currency"},
                    {"data": "status"},
                    {"data": "client_name"}

                ]
            }
        );
    })

});
$(document).ready(function () {

    var img = new Image();
    img.src = 'https://cdn.pixabay.com/photo/2016/09/17/07/03/instagram-1675670_1280.png';

    img.onload = function () {

        let successNo = 0;
        let pendingNo = 0;
        let failedNo = 0;
        $.ajax({
            url: "/transactions/get/divided",
            success: function (result) {
                successNo = result.success;
                pendingNo = result.pending;
                failedNo = result.failed;

                var ctx = document.getElementById('myChart').getContext('2d');
                var fillPattern = ctx.createPattern(img, 'repeat')
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: Object.keys(result),
                        datasets: [{
                            label: 'Status',
                            data: [successNo, pendingNo, failedNo],
                            // backgroundColor: //fillPattern,
                            //     [
                            //         'rgba(46, 204, 113, 0.4)',
                            //         'rgba(255, 241, 96, 0.4)',
                            //         'rgba(255, 99, 132, 0.4)',
                            //
                            //     ],
                            // borderColor: [
                            //     'rgba(46, 204, 113, 1)',
                            //     'rgba(255, 241, 96, 1)',
                            //     'rgba(255, 206, 86, 1)',
                            //
                            // ],
                            borderWidth: 1
                        }]
                        // datasets: [{
                        //     data: [0, 0],
                        // }, {
                        //     data: [0, 1]
                        // }, {
                        //     data: [1, 0],
                        //     showLine: true // overrides the `line` dataset default
                        // }, {
                        //     type: 'scatter', // 'line' dataset default does not affect this dataset since it's a 'scatter'
                        //     data: [1, 1]
                        // }]
                    },
                    options: {
                        legend: {
                            labels: {
                                fontColor: 'green'
                            },
                            align: 'start'
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true,
                                    stepSize: 100
                                }
                            }]
                        },
                        tooltips: {
                            mode: 'nearest',
                            intersect: true
                        },
                        animation: {
                            duration: 1000 // general animation time in ms
                        },
                        hover: {
                            animationDuration: 0 // duration of animations when hovering an item
                        },
                        responsiveAnimationDuration: 0,
                        layout: {
                            padding: {
                                left: 50,
                                right: 0,
                                top: 0,
                                bottom: 0
                            }
                        },
                        title: {
                            display: true,
                            text: 'Custom Chart Title'
                        }

                    }
                });
            }
        })

    }

    $.ajax({
        url: '/transactions/get/months',
        success: function (result){
            let succ=[];
            let pend=[];
            let fail=[];
            for(let i=1;i<=12;i++){
                succ.push(result[i]['success'])
                pend.push(result[i]['pending'])
                fail.push(result[i]['failed'])
            }
            var ctx = document.getElementById('myChart2').getContext('2d');
            var fillPattern = ctx.createPattern(img, 'repeat')
            console.log(result[1]['success']);
            var myChart = new Chart(ctx, {
                type:'line',
                data:{
                    labels:['January','February','March','April','May','June','July','August','September','October','November','December'],
                    datasets:[
                        {
                            label:'success',
                            data:succ,
                            fill: 'none',
                            backgroundColor: 'rgba(46, 204, 113, 0.8)',
                            borderColor: 'rgba(46,204,113,1)'
                        },
                        {
                            label:'pending',
                            data:pend,
                            fill: 'none',
                            backgroundColor: 'rgba(247, 202, 24, 0.8)',
                            borderColor: 'rgba(247, 202, 24, 1)'
                        },
                        {
                            label:'failed',
                            data:fail,
                            fill: 'none',
                            backgroundColor: 'rgba(255, 99, 132, 0.8)',
                            borderColor: 'rgba(255, 99, 132, 1)'
                        },

                    ],
                    options:{
                        layout: {
                            padding: {
                                // left: 50,
                                // right: 0,
                                // top: 50,
                                // bottom: 0
                            }
                        },
                    },
                    scales: {
                        yAxes: [{
                            display: true,
                            ticks: {
                                suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
                                // OR //
                                beginAtZero: false   // minimum value will be 0.
                            }
                        }]
                    }
                }
            })
        }
    })
})

