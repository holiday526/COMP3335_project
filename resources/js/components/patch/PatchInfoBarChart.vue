<template>
    <bar-chart :data="dataset" :options="options"></bar-chart>
</template>

<script>
import BarChart from "../core/BarChart";

export default {
    name: "PatchInfoBarChart.vue",
    components: {
        BarChart,
    },
    props: {
        dataset: {
            type: Object,
            required: true,
        },
        options: {
            type: Object,
            required: true,
        }
    },
    data() {
        return {

        }
    },
}
</script>

<style scoped>

</style>
