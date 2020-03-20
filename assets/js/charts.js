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
    type: 'bar',
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
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

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
    type: 'bar',
    data: {
        labels: weeks,
        datasets: [{
            label: '# of Symptoms',
            data: symptomsWeek,
            backgroundColor: 'rgba(255,40,94,0.8)',
            borderColor:'rgb(255,70,98)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
