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
.badge{
      display:inline;  
}
</style>
@endpush
@push('scripts')
<script>
      document.addEventListener("DOMContentLoaded", function() {
            var tabs = Array.from(document.querySelectorAll(".tab-reg"));
            tabs.map(tab => tab.style.display = "none");
            tabs[0].style.display = "block";
      });
      var menu = document.querySelectorAll(".menu");
      menu.forEach(menu_reg =>{
            menu_reg.addEventListener("click", function(){
                  var tabs = Array.from(document.querySelectorAll(".tab-reg"));
                  var tabreg = document.querySelector(`#${menu_reg.classList[1]}`);
                  tabs.map(tab => tab.style.display = "none");
                  tabreg.style.display = "block";
            });
      });
</script>
@endpush


@section('content')
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
      <div class="container-fluid">
            <div class="d-flex flex-column align-items-start" style="margin-top:10px;">
                  <span>
                      <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline" href="/">Dashboard</a>
                      <span class="h4 mb-0 text-white text-uppercase d-lg-inline_block" style="margin:0 8px;">/</span>
                      <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline">Localisations</a>
                  </span>
                  <p class="h5 text-uppercase text-white" style="">Dernière visite le {{\Carbon\Carbon::createFromFormat('Y-m-d', $last_sync)->format('d/m/Y');}}</p>
            </div>
          @include('components.searchandonline')
      </div>
</nav>
<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
</div>
<div class="container-fluid mt--7">
      <div class="row" style="margin-bottom: 80px;">
            <div class="col-xl-12">
                  <h3 class="h3 text-uppercase text-white">Listes des localisations reconnues</h3>
            </div>
      </div>
      <div class="row">
            <div class="col-md-2">
                  <table class="table table-bordered">
                        <thead style="background-color:#5e72e4;color:white;">
                              <tr><th scope="col">Régions Couvertes</th></tr>
                        </thead>
                        <tbody>
                              @foreach ($regions as $region)
                                    <tr class="menu tab-reg-{{$loop->index}}"><td>{{$region}}</td></tr>
                              @endforeach
                        </tbody>
                  </table>
            </div>
            <div class="col-md-9 offset-md-1">
                  @for($index=0; $index < 10; $index++)
                        @php
                              $region = $regions[$index];
                              $places_buckets = array_chunk($groupedbyregion[$region]->toArray(),5);        
                              $i = 0;
                        @endphp
                        <table class="table table-bordered tab-reg" id="tab-reg-{{$index}}">
                              <thead style="background-color:#5e72e4;color:white;">
                                    <tr>
                                          <th scope="col" style="width:20%!important;">Liste 1</th>
                                          <th scope="col" style="width:20%!important;">Liste 2</th>
                                          <th scope="col" style="width:20%!important;">Liste 3</th>
                                          <th scope="col" style="width:20%!important;">Liste 4</th>
                                          <th scope="col" style="width:20%!important;">Liste 5</th>
                                    </tr>
                              </thead>
                              <tbody>
                                    @while ($i < count($places_buckets))
                                          <tr>
                                                @foreach ($places_buckets[$i] as $place)
                                                      <td>
                                                            <a href="{{url('/infos-updates',['commune' => $place->commune])}}"> {{$place->commune}} </a>
                                                            <span class="badge badge-primary badge-pill">{{$place->companies}}</span>
                                                      </td>
                                                @endforeach
                                          </tr>
                                          @php 
                                                $i++;
                                          @endphp
                                    @endwhile 
                              </tbody>      
                        </table>
                  @endfor   
            </div>
      </div>
      @include('components.footer')
  </div>
@endsection




<!-- <table class="table table-bordered">
      @php
            $mare =  $regions[1];
            $places_buckets = array_chunk($groupedbyregion[$mare]->toArray(),5);
            
            $i = 0;
      @endphp
            <thead style="background-color:#5e72e4;color:white;">
                  <tr><th scope="col">Localisations Couvertes</th></tr>
            </thead>
            <tbody> -->
                  <!-- dd($groupedbyregion[$mare]); dd($places_buckets); -->
                  <!-- dd($places_buckets); -->
                  <!-- dd(count($groupedbyregion[$mare])); -->
                        <!-- <span class="badge badge-primary badge-pill">{{$place->companies}}</span> -->
                  <!-- @foreach ($places_buckets[0] as $place)
                        <tr><td>{{$place->commune}}
                              
                        </td></tr>
                  @endforeach -->
            <!-- </tbody>
      </table> -->
<!-- @foreach ($regions as $region)
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
@endforeach -->