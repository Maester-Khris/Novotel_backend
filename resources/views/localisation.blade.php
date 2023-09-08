@extends('layout',['title'=>'Localisation'])
@push('styles')
<style>
h3{padding-top: 10px;}
.local-center{
    padding: 5px;
    width: 100%;
    margin-bottom: 10px;
    padding-left: 5px;
}
.local-center h3{
      padding: 5px 0px;
      margin-bottom: 0px;
      color: white;
}
</style>
@endpush
@section('content')
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
          <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="./index.html">Liste de toutes les localisations</a>
          @include('components.searchandonline')
      </div>
</nav>
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8" style="padding-bottom: 0px!important;">
</div>
<div class="container-fluid mt--7" style="position: static; top:0; margin-top:30px!important;">
      <div class="row">
            @foreach ($regions as $region)
                  <div class="col-xl-3">
                        <a class="btn btn-primary local-center" data-toggle="collapse" href="{{'#collapseExample'.$region}}" role="button" aria-expanded="false" aria-controls="{{'collapseExample'.$region}}">
                              <h3>{{$region}}</h3>
                        </a>
                        <div class="list-group collapse" id="{{'collapseExample'.$region}}">
                              @foreach ($groupedbyregion[$region] as $place)
                                    <a href="{{url('/infos-updates',['commune' => $place->commune])}}"
                                          class="list-group-item d-flex justify-content-between align-items-center list-group-item-success list-group-item-action">
                                         {{$place->commune}}
                                          <span class="badge badge-primary badge-pill">{{$place->companies}}</span>
                                    </a>
                              @endforeach
                        </div>
                  </div>
            @endforeach
      </div>
      @include('components.footer')
  </div>
@endsection