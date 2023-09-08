@extends('layout',['title'=>'Profil Hotel'])

@section('content')
<!-- Navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="../index.html">Profile Hotel</a>
        @include('components.searchandonline')
    </div>
</nav>

<!-- Header -->
<div class="header pb-8 pt-5 pt-lg-8 d-flex align-items-center"
    style="min-height: 600px; background-image: url(/img/theme/profile-cover.jpg); background-size: cover; background-position: center top;">
    <span class="mask bg-gradient-default opacity-8"></span>
    <div class="container-fluid d-flex align-items-center">
        <div class="row">
            <div class="col-lg-7 col-md-10">
                <h1 class="display-2 text-white">Hotel / Résidence Le Famous</h1>
                <p class="text-white mt-0 mb-5">Les informations de ces entreprises sont confidentielles et accéssible
                    uniquement au personnel autorisés</p>
            </div>
        </div>
    </div>
</div>
<!-- Informations company et chiffres -->
<div class="container-fluid mt--7">
    <div class="row">
        <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
            <div class="card card-profile shadow">
                <div class="row justify-content-center">
                    <div class="col-lg-3 order-lg-2">
                        <div class="card-profile-image">
                            <a href="#">
                                <img src="/img/theme/team-4-800x800.jpg" class="rounded-circle">
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
                                    <span class="heading">89</span>
                                    <span class="description">Chambres</span>
                                </div>
                                <div>
                                    <span class="heading">22</span>
                                    <span class="description">Clients</span>
                                </div>
                                <div>
                                    <span class="heading">10</span>
                                    <span class="description">Visites</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <h3>
                            <span class="font-weight-light">Hotel / Résidence, </span>Le Famous
                        </h3>
                        <div class="h5 font-weight-300">
                            <i class="ni location_pin mr-2"></i>Littoral, Douala
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 order-xl-1">
            <div class="card bg-secondary shadow">
                <div class="card-header bg-white border-0">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h3 class="mb-0">Description d'entreprise</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <h6 class="heading-small text-muted mb-4">Information entreprise</h6>
                        <div class="pl-lg-4">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-username">Nom</label>
                                        <input type="text" id="input-username"
                                            class="form-control form-control-alternative" value="Hotel le Famous"
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
                                            value="Littoral, Douala, Ndogbong" type="text" disabled>
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
                                            value="Mr. Ngan Fabrice Aimé" disabled>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-email">Contact Manager</label>
                                        <input type="tel" class="form-control form-control-alternative"
                                            value="+237 6xx xx xx" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="form-control-label" for="input-address">Contact Entreprise</label>
                                        <input class="form-control form-control-alternative" value="+237 6xx xx xx"
                                            type="tel" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('components.footer')
</div>
@endsection
