<template>
<!--    <bar-chart :data="chartdata" :options="options"></bar-chart>-->
    <line-chart :data="chartData" :options="options"></line-chart>
</template>

<script>
import BarChart from "../core/BarChart";
import LineChart from "../core/LineChart";

export default {
    components: {
        BarChart,
        LineChart
    },
    name: "SystemLoadBarChart",
    data: () => {
        return {
            chartData: {
                labels: ["00:00", "03:00", "06:00", "09:00", "12:00", "15:00", "18:00", "21:00"],
                datasets: [
                    {
                        label: 'Load',
                        borderColor: '#f87979',
                        backgroundColor: 'transparent',
                        data: [0.2, 0.1, 0.4, 0.9, 0.7, 0.8, 0.6, 0.4]
                    }
                ]
            },
            options: {
                title: {
                    display: true,
                    text: 'Database Load',
                    fontSize: 20
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
                },
            },
        }
    },
}
</script>

<style scoped>

</style>
