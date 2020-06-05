// Progression of diet
let dietProgression = document.getElementById('dietProgression');
let dataWeeks = [];

const nbData = dietProgression.getAttribute('data-week-length');
for (let nbr = 1; nbr <= nbData; nbr++) {
    let data = dietProgression.getAttribute('data-week-' + nbr);
    dataWeeks.push(data);
}

let dietProgressionChart = new Chart(dietProgression, {
    type: 'doughnut',
    data: {
        datasets: [{
            data: dataWeeks,
            backgroundColor: ['rgba(153, 102, 255, 0.8)', 'rgba(0, 0, 0, 0.1)'],
            borderWidth: 0
        }]
    },

});

