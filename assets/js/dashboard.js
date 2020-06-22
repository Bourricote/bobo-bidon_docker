// Progression of diet
let dietProgression = document.getElementById('dietProgression');
let dataDays = [];

const nbData = dietProgression.getAttribute('data-days-length');
for (let nbr = 1; nbr <= nbData; nbr++) {
    let data = dietProgression.getAttribute('data-days-' + nbr);
    dataDays.push(data);
}

let dietProgressionChart = new Chart(dietProgression, {
    type: 'doughnut',
    data: {
        labels: ['Jours passés', 'Jours restants'],
        datasets: [{
            data: dataDays,
            backgroundColor: ['rgba(153, 102, 255, 0.8)', 'rgba(0, 0, 0, 0.1)'],
            borderWidth: 0
        }]
    },
    options: {
        legend: {
            display: false,
        },
    }
});

// Categories
let categories = document.getElementById('categories');
let categoriesLabels = [];
let nbSymptoms = [];

const nbCategoriesLabels = categories.getAttribute('data-categories-length');
for (let nbr = 1; nbr <= nbCategoriesLabels; nbr++) {
    let label = categories.getAttribute('data-label-' + nbr);
    let nbSymptom = categories.getAttribute('data-symptom-' + nbr);
    categoriesLabels.push(label);
    nbSymptoms.push(nbSymptom);
}

let categoriesChart = new Chart(categories, {
    type: 'doughnut',
    data: {
        labels: categoriesLabels,
        datasets: [{
            data: nbSymptoms,
            backgroundColor: [
                '#E66DAA',
                '#B067CF',
                '#8B6FD2',
                '#F19CC8',
                '#CE95E5',
                '#B29EE7'
            ],
            borderWidth: 0
        }]
    },
    options: {
        legend: {
            display: false,
        },
    }
});