<template>
    <bar-chart :data="chartdata" :options="options"></bar-chart>
</template>

<script>
import BarChart from "./BarChart";

export default {
    components: {
        BarChart
    },
    name: "SystemLoadBarChart",
    data: () => {
        return {
            chartdata: {
                labels: ['00:00', '03:00', '06:00', '09:00', '12:00', '15:00', '18:00', '21:00'],
                datasets: [
                    {
                        label: 'Load',
                        backgroundColor: '#79d4f8',
                        data: [0.2, 0.1, 0.4, 0.9, 0.7, 0.8, 0.6, 0.4]
                    }
                ]
            },
            options: {
                title: {
                    display: true,
                    text: 'Load'
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            max: 1
                        }
                    }]
                }
            },
        }
    },
}
</script>

<style scoped>

</style>
