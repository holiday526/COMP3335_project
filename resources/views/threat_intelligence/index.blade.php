@extends('kernel_page')

@section('content')
<h4>Threat Intelligence</h4>
@foreach ($all_threat_info as $info)
<patch-info-banner
    variant="{{ $info->variant }}"
    heading="{{ $info->heading }}"
    description="{{ $info->description }}"
    url-to-doc="{{ $info->url }}"
    align="center"
>
</patch-info-banner>
@endforeach

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
