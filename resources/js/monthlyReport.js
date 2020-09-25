var $ = require('jquery');

$(document).ready(function () {

    // drawMonthsGraph(defaultYear, 'all', 'all');

    //getting transactions status divided by month
    // $.ajax({
    //     url: '/transactions/get/months',
    //     success: drawGraph
    // })


    $("#filter-button").click(() => {
        $('#dateForm').reload
        $.ajax({
            method: 'POST',
            url: '/reports/monthly',
            data: $('#dateForm').serializeArray(),
            success: drawGraph
        })
    });

    $('#filter-button').trigger('click');


})

function drawGraph(result) {
    let success = [];
    let pending = [];
    let failed = [];
    for (let i = 1; i < result.length; i++) {
        success.push(result[i]['success'])
        pending.push(result[i]['pending'])
        failed.push(result[i]['failed'])
    }
    $('#monthlyChart').remove();
    $('#chart-div').append('<canvas id="monthlyChart" aria-label="Hello ARIA World" role="img"></canvas>')
    var ctx = document.getElementById('monthlyChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: result[0]['labels'],
            datasets: [
                {
                    label: 'success',
                    data: success,
                    fill: 'none',
                    backgroundColor: 'rgba(46, 204, 113, 0.8)',
                    borderColor: 'rgba(46,204,113,1)'
                },
                {
                    label: 'pending',
                    data: pending,
                    fill: 'none',
                    backgroundColor: 'rgba(247, 202, 24, 0.8)',
                    borderColor: 'rgba(247, 202, 24, 1)'
                },
                {
                    label: 'failed',
                    data: failed,
                    fill: 'none',
                    backgroundColor: 'rgba(255, 99, 132, 0.8)',
                    borderColor: 'rgba(255, 99, 132, 1)'
                },

            ],
            options: {
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



