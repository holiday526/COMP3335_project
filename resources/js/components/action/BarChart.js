import { Bar } from 'vue-chartjs';

export default {
    extends: Bar,
    props: {
        data: {
            type: Object,
            require: false
        },
        options: {
            type: Object,
            require: false
        }
    },
    data: () => {
        return {

        }
    },
    mounted() {
        this.renderChart(this.data, this.options)
    }
}
