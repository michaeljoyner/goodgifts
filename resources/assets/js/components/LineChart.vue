<style></style>

<template>
    <canvas ref="canvas"></canvas>
</template>

<script type="text/babel">
    import Chart from 'chart.js';

    export default {
        data() {
            return {
                chart: null,
                chart_data: null,
            };
        },

        mounted() {
            this.fetchData();
        },

        methods: {
            fetchData() {
                this.$http.get('/admin/services/analytics/visitors')
                        .then(({data}) => this.createChart(data))
                        .catch(err => console.log(err));
            },

            createChart(data) {
                this.chart = new Chart(this.$refs.canvas.getContext('2d'), {
                    type: 'line',
                    data,
//                    data: {
//                        labels: ["January", "February", "March", "April", "May", "June", "July"],
//                        datasets: [
//                            {
//                                label: "My First dataset",
//                                fill: true,
//                                lineTension: 0.1,
//                                backgroundColor: "rgba(75,192,192,0.4)",
//                                borderColor: "rgba(75,192,192,1)",
//                                borderCapStyle: 'butt',
//                                borderDash: [],
//                                borderDashOffset: 0.0,
//                                borderJoinStyle: 'miter',
//                                pointBorderColor: "rgba(75,192,192,1)",
//                                pointBackgroundColor: "#fff",
//                                pointBorderWidth: 1,
//                                pointHoverRadius: 5,
//                                pointHoverBackgroundColor: "rgba(75,192,192,1)",
//                                pointHoverBorderColor: "rgba(220,220,220,1)",
//                                pointHoverBorderWidth: 2,
//                                pointRadius: 1,
//                                pointHitRadius: 10,
//                                data: [65, 59, 80, 81, 56, 55, 40],
//                                spanGaps: false,
//                            }
//                        ]
//                    },
                    options: {}
                });
            }
        }
    }
</script>