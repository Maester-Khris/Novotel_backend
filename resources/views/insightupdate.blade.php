@extends('layout',['title'=>'Updates'])

@section('content')
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
        <div class="d-flex flex-column align-items-start" style="margin-top:10px;max-width:450px;" >
            <span>
                <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline" href="/">Dashboard</a>
                <span class="h4 mb-0 text-white text-uppercase d-lg-inline_block" style="margin:0 8px;">/</span>
                <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline">Données à jour Commune: {{$location_string}}</a>
            </span>
            <p class="h5 text-uppercase text-white" style="">Dernière visite le {{\Carbon\Carbon::createFromFormat('Y-m-d', $last_sync)->format('d/m/Y');}}</p>
        </div>
        @include('components.searchandonline')
      </div>
</nav>
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row">
                <!-- visiteurs card -->
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">Nouveau Visiteurs</h5>
                                    <span class="h2 text-success font-weight-bold mb-0">{{$unique_client_visit_ss}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                
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
                                    <h5 class="card-title text-uppercase text-muted mb-0">Nouvelle Visites</h5>
                                    <span class="h2 text-success font-weight-bold mb-0">{{$visits_ss_count}}</span>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
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
        <div class="col">
            <div class="card shadow">
                <div class="card-header border-0">
                    <h3 class="mb-0">Détails</h3>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" style="width: 10%;">Hotel/Residence</th>
                                <th scope="col" style="width: 10%;">Visiteurs</th>
                                <th scope="col" style="width: 10%;">Visiteurs (Tel)</th>
                                <th scope="col" style="width: 10%;">Date d'entrée</th>
                                <th scope="col" style="width: 10%;">Status visite</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($all_visits)==0)
                                @foreach ($companies_from_location as $comp)
                                <tr>
                                    <td> <a href="{{url('/company-profile', $comp->comp_name)}}">{{$comp->comp_name}}</a>  </td>
                                    <td>/</td>
                                    <td>/</td>
                                    <td>/</td>
                                    <td>/</td>
                                </tr>
                                @endforeach
                            @else
                                @foreach ($all_visits as $entry)
                                    <tr>
                                        <td> <a href="{{url('/company-profile', $entry->company->comp_name)}}">{{$entry->company->comp_name}}</a>  </td>
                                        <td>{{$entry->client->full_name}}</td>
                                        <td>{{$entry->client->telephone}}</td>
                                        <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $entry->visit_start_date)->format('F j, Y');}}</td>
                                        <td>
                                            <span class="badge badge-dot mr-4">
                                                @if($entry->visit_end_date == null)
                                                    <i class="bg-warning"></i> En Cours
                                                @else
                                                    <i class="bg-success"></i> Complété
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer py-4">
                    {{ $all_visits->links() }}
                </div>
            </div>
        </div>
    </div>

    @include('components.footer')
</div>
@endsection