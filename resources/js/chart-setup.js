import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('growthChart');
    if (!ctx) return;

    const labels = JSON.parse(ctx.dataset.labels);
    const values = JSON.parse(ctx.dataset.values);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Savings Growth',
                data: values,
                borderColor: '#0B255C',
                backgroundColor: 'rgba(11, 37, 92, 0.1)',
                fill: true,
                tension: 0.4,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { display: false },
                x: { grid: { display: false } }
            }
        }
    });
});