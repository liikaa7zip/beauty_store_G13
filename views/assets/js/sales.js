// Stock Levels Chart
const ctx = document.getElementById('stockChart').getContext('2d');
const stockChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['8am', '9am', '10am', '11am', '12pm', '1pm', '2pm', '3pm', '4pm'],
        datasets: [{
            label: 'Stock Levels',
            data: [80, 70, 85, 60, 75, 90, 65, 80, 70],
            borderColor: '#ff4d94',
            fill: false,
            tension: 0.4
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
                max: 100
            }
        }
    }
});

// Add New Button Functionality
document.querySelector('.add-new-btn').addEventListener('click', () => {
    alert('Add new product functionality can be implemented here!');
});