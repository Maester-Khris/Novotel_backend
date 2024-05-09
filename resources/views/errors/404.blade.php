@extends('../layout',['title'=>"Page Introuvable"])

@section('content')

<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">
        <div class="d-flex flex-column align-items-start" style="margin-top:10px;">
            <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="/">Dashboard {{$exception->getStatusCode()}}</a>
        </div>
        @include('components.searchandonline')
    </div>
</nav>

<div class="header bg-gradient-primary pt-5 pt-md-8" style="padding-top: 100px!important;"></div> 
<div class="container-fluid mt--7" style="margin-top: 60px!important;">
<div class="row">
    <!-- 404 Component -->
    <div class="col-md-5 d-flex justify-content-center align-items-center">
        <div class="d-flex flex-row justify-content-between align-items-center">
        <i class="fas fa-exclamation-circle" style="color:#FFAD00;font-size: 60px;margin-right: 20px;"></i>
        <div class="d-flex flex-column">
            <p class="text-muted" style="margin-bottom: 5px!important;">
            La page ou la ressource que vous cherchez est introuvable! Réessayer ou continuer sur notre page d'accueil. 
            </p>
            <button class="btn btn-primary" style="width: 190px; padding-left: 10px; padding-right: 10px;">
            <i class="fas fa-home" style="color: white;font-size: 20px; margin-right: 6px;"></i>
            Revenir à l'accueil
            </button>
        </div>
        </div>
    </div>
    <div class="col-md-7 d-flex justify-content-center align-items-center">
        <img src="/img/error_404.png" alt="" style="height: 400px;width: 400px;">
    </div>
    </div>
</div>
@endsection