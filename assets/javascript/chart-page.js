// script associated to showstudent.html.twig

import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

    window.onload = function () {
        const chartElement = document.getElementById('myChart');
        if (chartElement) {
            const ctx = chartElement.getContext('2d');
            const chartData = JSON.parse(document.getElementById('chartData').textContent);
            const chartOptions = JSON.parse(document.getElementById('chartOptions').textContent);
            
            console.log('Chart Data:', chartData);
            console.log('Chart Options:', chartOptions);
            
            new Chart(ctx, {
                type: 'radar',
                data: chartData,
                options: chartOptions
            });
        } else {
            console.error('Chart element not found');
        }
}
