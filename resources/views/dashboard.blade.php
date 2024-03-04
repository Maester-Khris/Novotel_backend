@extends('layout',['title'=>'Accueil'])
@push('styles')
<style>
    .card-stats{
        height:160px;
    }
</style>
@endpush
@push('chart-scripts')
    <script src="/js/plugins/chart.js/dist/Chart.min.js"></script>
    <script src="/js/plugins/chart.js/dist/Chart.extension.js"></script>
    <script>
        function populateChart(chartype, chartid, label, data){
            const canvas = document.querySelector(`#${chartid}`);
            const ctx = canvas.getContext('2d');
            const chartData = {
                labels: label,
                datasets: [{
                    label: 'My Dataset', data: data, backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',borderWidth: 1, lineTension: 0.4 
                }]
            };
            const chartConfig = {type: chartype, data: chartData, options: {}};
            const myChart = new Chart(ctx, chartConfig);
        }
        document.addEventListener('DOMContentLoaded', async function() {
            let char1_label = [];
            let char1_data = [];
            let char2_label = [];
            let char2_data = [];
            await axios.get('/home-chart').then(function(response){
                let data_char1 = response.data.chart1;
                let data_char2 = response.data.chart2;
                char1_label = data_char1.map(data => data.month);
                char2_label = data_char2.map(data => data.month.slice(0,3));
                char1_data = data_char1.map(data => data.total_visit);
                char2_data = data_char2.map(data => data.total_visit);
            });

            populateChart('line', 'myChart',char1_label,char1_data);
            populateChart('bar','chart-res',char2_label,char2_data);
        });
    </script>
@endpush

@section('content')
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">
        <div class="d-flex flex-column align-items-start" style="margin-top:10px;">
            <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="/">Dashboard</a>
            <p class="h5 text-uppercase text-white" style="">Dernière visite le {{\Carbon\Carbon::createFromFormat('Y-m-d', $last_sync)->format('d/m/Y');}}</p>
        </div>
        @include('components.searchandonline')
    </div>
</nav>
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row">
                <!-- hotel card -->
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Hotels / Résidences</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$companies_cnt}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="fas fa-chart-bar"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> +{{$data_since_visit['comp']}}</span> <br>
                                <span class="text-nowrap">Depuis dernière visite</span>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- visiteurs card -->
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Visiteurs / Clients</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$client_cnt}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> +{{$data_since_visit['client']}}</span> <br>
                                <span class="text-nowrap">Depuis dernière visite</span> 
                            </p>
                        </div>
                    </div>
                </div>
                <!-- visite card -->
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Séjours / Réservations</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$visits_cnt}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> +{{$data_since_visit['visit']}}</span> <br>
                                <span class="text-nowrap">Depuis dernière visite</span> 
                            </p>
                        </div>
                    </div>
                </div>
                <!-- performance card -->
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Rapport Occupation</h5>
                                    <span class="h2 font-weight-bold mb-0">{{$occupation}}%</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                        <i class="fas fa-percent"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> 3.48%</span> <br>
                                <span class="text-nowrap">Depuis dernière visite</span> 
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-8 mb-5 mb-xl-0">
            <div class="card bg-gradient-default shadow">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-light ls-1 mb-1">Apercu derniers 8 mois</h6>
                            <h2 class="text-white mb-0">Entrée visiteurs</h2>
                        </div>
                        <div class="col">
                            <ul class="nav nav-pills justify-content-end">
                                {{-- <li class="nav-item mr-2 mr-md-0" data-toggle="chart" data-target="#chart-sales"
                                    data-update='{"data":{"datasets":[{"data":[0, 220, 110, 330, 15, 40, 20, 60, 60]}]}}'
                                    data-prefix="$" data-suffix="k">
                                    <a href="#" class="nav-link py-2 px-3 active" data-toggle="tab">
                                        <span class="d-none d-md-block">Month</span>
                                        <span class="d-md-none">M</span>
                                    </a>
                                </li> --}}
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        {{-- <canvas id="chart-sales" class="chart-canvas"></canvas> --}}
                        <canvas id="myChart" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <!-- hist chart card -->
        <div class="col-xl-4">
            <div class="card shadow">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted ls-1 mb-1">Occupations derniers 6 mois</h6>
                            <h2 class="mb-0">Séjours toujours en cours</h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="chart-res" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <template id="chart-stat"> -->
        <!-- <span class="chart1"></span>
        <span class="chart2"></span> -->
    <!-- </template> -->

    @include('components.footer')
</div>
@endsection


<!-- const canvas = document.querySelector('#myChart');
const ctx = canvas.getContext('2d');
const chartData = {
    labels: char1_label,
    datasets: [{
    label: 'My Dataset',
    data: char1_data,
    backgroundColor: 'rgba(255, 99, 132, 0.2)',
    borderColor: 'rgba(255, 99, 132, 1)',
    borderWidth: 1,
    lineTension: 0.4 // Set the line tension to create curved lines
    }]
};
const chartConfig = {
    type: 'line',
    data: chartData,
    options: {}
};
const myChart = new Chart(ctx, chartConfig); -->