import './bootstrap.js';

import './styles/app.css';

import { Chart, registerables } from 'chart.js';


Chart.register(...registerables);

document.addEventListener('DOMContentLoaded', () => {
    const ctx = document.getElementById('myChart').getContext('2d');
    const chartData = JSON.parse(document.getElementById('chartData').textContent);
    const chartOptions = JSON.parse(document.getElementById('chartOptions').textContent);
    
    new Chart(ctx, {
        type: 'radar',
        data: chartData,
        options: chartOptions
    });
});