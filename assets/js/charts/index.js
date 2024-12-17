var ctx = document.getElementById("myChart").getContext("2d");

var myLineChart = new Chart(ctx, {
    type: "line",
    data: {
        labels: [
            "January",
            "February",
            "March",
            "April",
            "May",
            "June",
            "July",
        ],
        datasets: [
            {
                label: "Monthly Sales",
                data: [100, 200, 150, 300, 250, 180, 280],
                borderColor: "rgba(75, 192, 192, 1)",
                borderWidth: 2,
                fill: false,
                responsive: false,
                maintainAspectRatio: false,
                lineTension: 0,
            },

            
        ],
    },
    options: {
        // Add any chart options or configurations here
    },
});
