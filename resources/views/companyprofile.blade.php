@extends('layout',['title'=>'Profil Hotel'])
@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
<style>
    .border{
        border: 1px solid black;
    }
    td{
        padding: 8px 18px!important;
        line-height: 28px!important;
    }
    .badge{
        font-size: 10px;
    }
    .badge-dot i{
        margin-right: 0px!important;
    }
    i.bi{
        font-size:15px; 
    }
</style>
@endpush

@section('content')
<!-- Navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">
        <div class="d-flex flex-column align-items-start" style="margin-top:10px;">
            <span>
                <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline" href="/">Dashboard</a>
                <span class="h4 mb-0 text-white text-uppercase d-lg-inline_block" style="margin:0 8px;">/</span>
                <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline">Profile Hotel</a>
            </span>
            <p class="h5 text-uppercase text-white" style="">Dernière mise à jour le {{\Carbon\Carbon::createFromFormat('Y-m-d', $last_sync)->format('d/m/Y');}}</p>
        </div>
        @include('components.searchandonline')
    </div>
</nav>

<!-- Header -->
<div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center"
    style="min-height: 600px; background-image: url(/img/hotel_background.jpg); background-size: 50%; background-position: center top;">
    <span class="mask bg-gradient-default opacity-8"></span>
    <div class="container-fluid d-flex align-items-center">
        <div class="row">
            <div class="col-lg-7 col-md-10">
                <h1 class="display-2 text-white">Hotel / Résidence {{$company->comp_name}}</h1>
                <p class="text-white mt-0 mb-5">Les informations de ces entreprises sont confidentielles et accéssible
                    uniquement au personnel autorisés</p>
            </div>
            <div class="col-lg-5">
                <div class="col-xl-12 order-xl-2 mb-5 mb-xl-0">
                    <div class="card card-profile shadow">
                        <div class="card-body pt-0 pt-md-4" style="padding:10px 10px!important;position: relative;">
                            <div class="card-profile-image" style="position: absolute;top:0px;left:50%;">
                                <a href="#">
                                    <img src="/img/hotel.png" class="rounded-circle" style="background-color:whitesmoke;padding:15px;width:120px;height:120px;">
                                </a>
                            </div>
                            <div class="row" style="margin-top: 60px;">
                                <div class="col">
                                    <div class="card-profile-stats d-flex justify-content-center mt-md-5" style="margin-top:0px!important;padding-top:0px;">
                                        <div>
                                            <span class="heading">{{$company->resources_count}}</span>
                                            <span class="description">Chambres</span>
                                        </div>
                                        <div>
                                            <span class="heading">{{$comp_clients}}</span>
                                            <span class="description">Clients</span>
                                        </div>
                                        <div>
                                            <span class="heading">{{$company->visits_count}}</span>
                                            <span class="description">Visites</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <h3>
                                    <span class="font-weight-light">Hotel / Résidence, </span> {{$company->comp_name}}
                                </h3>
                                <div class="h5 font-weight-300">
                                    <i class="ni location_pin mr-2"></i>{{$location_string}}
                                </div>
                                <div class="h5 font-weight-300">
                                    <i class="ni location_pin mr-2"></i>{{$company->comp_telephone}}
                                </div>
                            </div>
                            <hr class="my-4" style="margin:12px 0px!important;"/>
                            <div class="text-center">
                                <h3>
                                    <span class="font-weight-light">Manager: Mr/Mme </span>{{$mana->full_name}}
                                </h3>
                                <div class="h5 font-weight-300">
                                    <i class="ni location_pin mr-2"></i>{{$mana->telephone}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-12 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Activités récentes de l'hotel / résidence</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" style="width: 10%;">Visiteurs</th>
                                    <th scope="col" style="width: 10%;">Visiteurs (Identifiants)</th>
                                    <th scope="col" style="width: 10%;">Provenance & Destination</th>
                                    <th scope="col" style="width: 10%;">Séjour dates</th>
                                    <th scope="col" style="width: 10%;">Sejour Info</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($visits as $visit)
                                    @php
                                        
                                    @endphp
                                    <tr>
                                        <td>
                                            <span>{{$visit->client->full_name}}</span> <br>
                                            <span>{{$visit->client->telephone}}</span>
                                        </td>
                                        <td>
                                            <span class="">Num CNI:</span>  <span class="badge bg-info">{{$visit->client->nic_card_id}}</span> <br>
                                            <span class="">Date délivrance:</span> <span class="badge bg-info">{{$visit->client->nic_card_delivery}}</span>
                                        </td>
                                        <td>
                                            <span><i class="bi bi-arrow-left-square-fill text-info"></i> {{$visit->client_coming_from}}</span><br>
                                            <span><i class="bi bi-arrow-right-square-fill text-info"></i> {{$visit->client_going_to}}</span>
                                        </td>
                                        <td>
                                            <span class="text-success">Entrée</span> <span class="badge bg-success">{{$visit->visit_start_date}}</span> <br>
                                            <span class="text-warning">Sortie</span> <span class="badge bg-warning">{{$visit->visit_end_date}}</span><br>
                                        </td>
                                        <td>
                                            <span>Piece occupés:  {{$visit->resource->resource_name}}</span> <br>
                                            <span>Statut: 
                                                <span class="badge badge-dot mr-4">
                                                    @if($visit->visit_end_date == null)
                                                        <i class="bg-warning"></i> En Cours
                                                    @else
                                                        <i class="bg-success"></i> Complété
                                                    @endif
                                                </span>
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer py-4">
                        {{ $visits->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('components.footer')
</div>
@endsection


{{-- <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <div class="card card-profile shadow">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <a href="#">
                                <img src="/img/hotel.png" class="rounded-circle" style="background-color:whitesmoke;padding:15px;">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4"></div>
                <div class="card-body pt-0 pt-md-4">
                    <div class="row">
                        <div class="col">
                            <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                <div>
                                    <span class="heading">{{$company->resources_count}}</span>
                                    <span class="description">Chambres</span>
                                </div>
                                <div>
                                    <span class="heading">{{$comp_clients}}</span>
                                    <span class="description">Clients</span>
                                </div>
                                <div>
                                    <span class="heading">{{$company->visits_count}}</span>
                                    <span class="description">Visites</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <h3>
                            <span class="font-weight-light">Hotel / Résidence, </span> {{$company->comp_name}}
                        </h3>
                        <div class="h5 font-weight-300">
                            <i class="ni location_pin mr-2"></i>{{$location_string}}
                        </div>
                        <div class="h5 font-weight-300">
                            <i class="ni location_pin mr-2"></i>{{$company->comp_telephone}}
                        </div>
                    </div>
                    <hr class="my-4" />
                    <div class="text-center">
                        <h3>
                            <span class="font-weight-light">Manager: Mr/Mme </span>{{$mana->full_name}}
                        </h3>
                        <div class="h5 font-weight-300">
                            <i class="ni location_pin mr-2"></i>{{$mana->telephone}}
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
  {{-- <div class="row justify-content-center">
                            <div class="col-lg-3 order-lg-2">
                                <div class="card-profile-image">
                                    <a href="#">
                                        <img src="/img/hotel.png" class="rounded-circle" style="background-color:whitesmoke;padding:15px;">
                                    </a>
                                </div>
                            </div>
                        </div> --}}
                        {{-- <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4"></div> --}}
{{-- <form>
    <h6 class="heading-small text-muted mb-4">Information entreprise</h6>
    <div class="pl-lg-4">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-control-label" for="input-username">Nom</label>
                    <input type="text" id="input-username"
                        class="form-control form-control-alternative" value="{{$company->comp_name}}"
                        disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="form-control-label" for="input-address">Adresse
                        Localisation</label>
                    <input id="input-address" class="form-control form-control-alternative"
                        value="{{$location_string}}" type="text" disabled>
                </div>
            </div>
        </div>
    </div>
    <hr class="my-4" />

    <h6 class="heading-small text-muted mb-4">Contact Entreprise / Manager </h6>
    <div class="pl-lg-4">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-control-label" for="input-username">Nom Manager</label>
                    <input type="text" class="form-control form-control-alternative"
                        value="Mr/Mme. {{$mana->full_name}}" disabled>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label class="form-control-label" for="input-email">Contact Manager</label>
                    <input type="tel" class="form-control form-control-alternative"
                        value="{{$mana->telephone}}" disabled>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="form-control-label" for="input-address">Contact Entreprise</label>
                    <input class="form-control form-control-alternative" value="{{$company->comp_telephone}}"
                        type="tel" disabled>
                </div>
            </div>
        </div>
    </div> --}}
</form>