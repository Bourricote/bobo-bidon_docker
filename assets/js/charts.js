// Symptoms per week
let symptomsPerWeek = document.getElementById('symptomsPerWeek');
let weeks = [];
let symptomsWeek = [];

const nbWeeks = symptomsPerWeek.getAttribute('data-week-length');
for (let nbr = 1; nbr < nbWeeks; nbr++) {
    let week = symptomsPerWeek.getAttribute('data-week-' + nbr);
    let symptom = symptomsPerWeek.getAttribute('data-symptom-' + nbr);
    weeks.push(week);
    symptomsWeek.push(symptom);
}

let symptomsPerWeekChart = new Chart(symptomsPerWeek, {
    type: 'horizontalBar',
    data: {
        labels: weeks,
        datasets: [{
            label: 'Nombre de Symptômes',
            data: symptomsWeek,
            backgroundColor: 'rgba(218, 73, 146,0.2)',
            borderWidth: 0
        }]
    },
    options: {
        maintainAspectRatio: false,
        legend: {
            display: false,
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    mirror: true,
                    padding: -10,
                },
                gridLines: {
                    display: false
                }
            }],
        }
    }
});

// Symptoms per day
let symptomsPerDay = document.getElementById('symptomsPerDay');
let days = [];
let symptomsDay = [];

const nbDays = symptomsPerDay.getAttribute('data-day-length');

for (let nbr = 1; nbr < nbDays; nbr++) {
    let day = symptomsPerDay.getAttribute('data-day-' + nbr);
    let symptom = symptomsPerDay.getAttribute('data-symptom-' + nbr);
    days.push(day);
    symptomsDay.push(symptom);
}

let symptomsPerDayChart = new Chart(symptomsPerDay, {
    type: 'horizontalBar',
    data: {
        labels: days,
        datasets: [{
            label: '# of Symptoms',
            data: symptomsDay,
            backgroundColor: 'rgba(153, 102, 255, 0.8)',
            borderColor:'rgba(153, 102, 255, 1)',
            borderWidth: 1
        }]
    },
    options: {
        maintainAspectRatio: false,
        legend: {
            display: false,
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                },
                gridLines: {
                    display: false
                }
            }],
        }
    }
});

// Fetch for chart by symptom
let labels = weeks;
let symptoms = [];

const symptomsButtons = document.getElementsByClassName('symptomButton');

let perSymptom = document.getElementById('perSymptom');
let perSymptomChart = new Chart(perSymptom, {
    type: 'horizontalBar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Nombre de Symptômes',
            data: symptoms,
            backgroundColor: 'rgba(108, 77, 189,0.2)',
            borderWidth: 0
        }]
    },
    options: {
        title: {
            display: true,
            text: 'Choisissez un symptôme',
            fontColor: 'rgb(108, 77, 189)'
        },
        maintainAspectRatio: false,
        legend: {
            display: false,
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    mirror: true,
                    padding: -10,
                },
                gridLines: {
                    display: false
                }
            }],
        }
    }
});

Chart.defaults.global.defaultFontFamily = 'Poppins';


for (let i =0; i < symptomsButtons.length; i++) {
    symptomsButtons[i].addEventListener('click', function () {
        fetch(
            '/user/charts/symptom',
            {
                method: 'post',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    'symptom': symptomsButtons[i].getAttribute('data-symptom-id'),
                }),
            }
        )
            .then(response => response.json())
            .then(function (htmlContent) {
                removeData(perSymptomChart);
                symptoms = htmlContent.symptoms;
                perSymptomChart.options.title.text = symptomsButtons[i].getAttribute('data-symptom-name');
                perSymptomChart.update();
                for (let j=0; j < symptoms.length; j++) {
                    addData(perSymptomChart, symptoms[j]);
                }
            })
            .catch((e) => console.log(e))
    })
}

function addData(chart, data) {
    chart.data.datasets.forEach((dataset) => {
        dataset.data.push(data);
    });
    chart.update();
}

function removeData(chart) {
    chart.data.datasets.forEach((dataset) => {
        dataset.data = [];
    });
    chart.update();
}
