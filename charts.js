let charts = {};

// Function to create a chart
function createChart(element, room, type) {
    let lab;
    // Determine the label based on the type
    if (type == "temp") {
        lab = "Temperature (C)";
    } else if (type == "hum") {
        lab = "Humidity (%)";
    } else if (type == "co2") {
        lab = "Co2 (ppm)";
    }

    // Get the context of the canvas element
    let ctx = document.getElementById(element).getContext('2d');
    // Create a new chart and store it in the charts object
    charts[element] = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: lab,
                data: [],
                fill: false,
                borderColor: 'rgba(75, 192, 192, 1)',
                tension: 0.4
            }]
        },
        options: {
            scales: {
                x: {
                    type: 'time',
                    time: {
                        parser: 'YYYY-MM-DD HH:mm:ss',
                        displayFormats: {
                            minute: 'HH:mm',
                            hour: 'HH:mm'
                        },
                        tooltipFormat: 'll HH:mm'
                    },
                    ticks: {
                        source: 'auto',
                        autoSkip: true,
                        maxTicksLimit: 10
                    },
                    title: {
                        display: true,
                        text: 'Time'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: lab
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            }
        }
    });

    // Fetch data and update the chart
    fetchDataAndUpdateChart(element, room, type);
}

// Function to fetch data and update the chart
function fetchDataAndUpdateChart(element, room, type) {
    fetch(`http://localhost/site/get_metrics.php?room=${room}`)
    .then(response => response.json())
    .then(data => {
        let chart = charts[element];
        let timestamps = [];
        let values = [];
        let somme = 0;
        let moy, min, max;

        // Process the fetched data
        data.forEach(metric => {
            timestamps.push(metric.timestamp);
            if (type == "temp") {
                let value = parseFloat(metric.temperature);
                values.push(value);
                somme += value;
            } else if (type == "hum") {
                let value = parseFloat(metric.humidity);
                values.push(value);
                somme += value;
            } else if (type == "co2") {
                let value = parseFloat(metric.co2);
                values.push(value);
                somme += value;
            }
        });

        // Calculate and display statistics
        if (values.length > 0) {
            moy = somme / values.length;
            min = Math.min(...values);
            max = Math.max(...values);

            let moy_element = document.getElementById(`${type}_moy_${room}`);
            let min_element = document.getElementById(`${type}_min_${room}`);
            let max_element = document.getElementById(`${type}_max_${room}`);

            moy_element.innerHTML = moy.toFixed(2);
            min_element.innerHTML = min.toFixed(2);
            max_element.innerHTML = max.toFixed(2);
        } else {
            document.getElementById(`${type}_moy_${room}`).innerHTML = 'N/A';
            document.getElementById(`${type}_min_${room}`).innerHTML = 'N/A';
            document.getElementById(`${type}_max_${room}`).innerHTML = 'N/A';
        }

        // Update the chart with new data
        chart.data.labels = timestamps;
        chart.data.datasets[0].data = values;
        chart.update();
    })
    .catch(error => console.error('Error fetching data:', error));
}

// Create charts for specific rooms and types
try {
    createChart("temp_E001", "E001", "temp");
    createChart("hum_E001", "E001", "hum");
    createChart("co2_E001", "E001", "co2");
    
    createChart("temp_E007", "E007", "temp");
    createChart("hum_E007", "E007", "hum");
    createChart("co2_E007", "E007", "co2");
} catch(error) {
    console.log(error);
}

try {
    createChart("temp_B111", "B111", "temp");
    createChart("hum_B111", "B111", "hum");
    createChart("co2_B111", "B111", "co2");

    createChart("temp_B112", "B112", "temp");
    createChart("hum_B112", "B112", "hum");
    createChart("co2_B112", "B112", "co2");
} catch(error) {
    console.log(error);
}

// Set an interval to update the charts every minute
setInterval(() => {
    try {
        fetchDataAndUpdateChart("temp_E001", "E001", "temp");
        fetchDataAndUpdateChart("hum_E001", "E001", "hum");
        fetchDataAndUpdateChart("co2_E001", "E001", "co2");
    
        fetchDataAndUpdateChart("temp_E007", "E007", "temp");
        fetchDataAndUpdateChart("hum_E007", "E007", "hum");
        fetchDataAndUpdateChart("co2_E007", "E007", "co2");
    } catch(error) {
        console.log(error);
    }

    try {
        fetchDataAndUpdateChart("temp_B111", "B111", "temp");
        fetchDataAndUpdateChart("hum_B111", "B111", "hum");
        fetchDataAndUpdateChart("co2_B111", "B111", "co2");
    
        fetchDataAndUpdateChart("temp_B112", "B112", "temp");
        fetchDataAndUpdateChart("hum_B112", "B112", "hum");
        fetchDataAndUpdateChart("co2_B112", "B112", "co2");
    } catch(error) {
        console.log(error);
    }
}, 60000);
