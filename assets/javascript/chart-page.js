import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

document.addEventListener('DOMContentLoaded', function () {
    const chartElement = document.getElementById('myChart');
    if (chartElement) {
        const ctx = chartElement.getContext('2d');
        const chartData = JSON.parse(document.getElementById('chartData').textContent);
        const chartOptions = JSON.parse(document.getElementById('chartOptions').textContent);
        
        new Chart(ctx, {
            type: 'radar',
            data: chartData,
            options: chartOptions
        });
    } else {
        console.error('Chart element not found');
        }
});
