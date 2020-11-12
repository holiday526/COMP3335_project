@extends('kernel_page')

@section('content')
<h4>Threat Intelligence</h4>
<b-alert show variant="info" align="center">New Remote access trojan (RAT) targeting Oracle 18C</b-alert>
<b-alert show variant="danger" align="center">New Remote access trojan (RAT) targeting Oracle 18C</b-alert>
<b-alert show variant="warning" align="center">New Remote access trojan (RAT) targeting Oracle 18C</b-alert>
<patch-info-bar-chart
    :dataset="{
                labels: ['SSH', 'SQL Injection', 'DDOS', 'Malware', 'XSS'],
                datasets: [
                    {
                        label: 'Counts',
                        backgroundColor: ['#ffffcc', '#ffeda0', '#fed976', '#feb24c', '#fd8d3c', '#fc4e2a', '#e31a1c', '#bd0026', '#800026'],
                        data: [1200, 580, 200, 150, 199]
                    },
                ]
            }"
    :options="{
                title: {
                    display: true,
                    text: 'November Top Network Attack'
                },
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                        }
                    }]
                }
            }"
>
</patch-info-bar-chart>
@endsection
