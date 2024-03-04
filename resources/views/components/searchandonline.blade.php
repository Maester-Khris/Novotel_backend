 <!-- Form -->
 <form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
    <div class="form-group mb-0">
      <div class="input-group input-group-alternative search-input" style="">
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fas fa-search"></i></span>
        </div>
        <input class="form-control" id="searchbar" placeholder="Rechercher un lieu / hotel / résidence" type="text">
        <div class="autocom-box" style=""></div>
      </div>
    </div>
  </form>
 <!-- User -->
 <ul class="navbar-nav align-items-center d-none d-md-flex">
     <li class="nav-item dropdown">
         <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
             aria-expanded="false">
             <div class="media align-items-center">
                 <span class="avatar avatar-sm rounded-circle">
                     <img alt="Image placeholder" src="{{ asset('/img/officer.png') }}"> 
                 </span>
                 <div class="media-body ml-2 d-none d-lg-block">
                     <span class="mb-0 text-sm  font-weight-bold">Commissariat 5e</span>
                 </div>
             </div>
         </a>
         <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
             <div class=" dropdown-header noti-title">
                 <h6 class="text-overflow m-0">Welcome!</h6>
             </div>
             <a href="#" class="dropdown-item">
                 <i class="ni ni-single-02"></i>
                 <span>My profile</span>
             </a>
             <a href="#" class="dropdown-item">
                 <i class="ni ni-settings-gear-65"></i>
                 <span>Settings</span>
             </a>
             <a href="#" class="dropdown-item">
                 <i class="ni ni-calendar-grid-58"></i>
                 <span>Activity</span>
             </a>
             <a href="#" class="dropdown-item">
                 <i class="ni ni-support-16"></i>
                 <span>Support</span>
             </a>
             <div class="dropdown-divider"></div>
             <a href="#!" class="dropdown-item">
                 <i class="ni ni-user-run"></i>
                 <span>Logout</span>
             </a>
         </div>
     </li>
 </ul>


<template id="search-item">
    <li>
        <a href="/" class="text-muted">
            <i class="ni ni-building" style="font-size:18px;padding-right:10px;margin-left:5px;"></i>
            <span></span>
        </a>
      </li>
</template>