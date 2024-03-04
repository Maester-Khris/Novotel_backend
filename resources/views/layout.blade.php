<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bookingo Dashboad - {{$title}}</title>
    <!-- Favicon -->
    <link href="/img/brand/logo_favicon.png" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <!-- Icons -->
    <link href="/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
    <link href="/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <!-- CSS Files -->
    <link href="/css/argon-dashboard.css?v=1.1.2" rel="stylesheet" />
    <link href="/css/autocomplete.css" rel="stylesheet" />
    @stack('styles')
    <style>
        footer{
            list-style-type: none;
        }
        .navbar-brand{
            padding-bottom:0px!important;
        }
        .navbar-brand>img{
            max-height:80px!important;
        }
        img.navbar-brand-img{
            width: 100%;
            height: 80px;
        }
    </style>
</head>

<body class="">
    <nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
        <div class="container-fluid">
            <!-- Toggler -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
                aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Brand -->
            <a class="navbar-brand pt-0" href="/">
                <img src="/img/brand/hotel.png" class="navbar-brand-img" alt="..." >
            </a>

            <!-- Connected user profile -->
            <ul class="nav align-items-center d-md-none">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <div class="media align-items-center">
                            <span class="avatar avatar-sm rounded-circle">
                                <img alt="Image placeholder" src="/img/theme/team-1-800x800.jpg">
                            </span>
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                        <div class=" dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome!</h6>
                        </div>
                        <a href="./examples/profile.html" class="dropdown-item">
                            <i class="ni ni-calendar-grid-58"></i>
                            <span>Activity</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#!" class="dropdown-item">
                            <i class="ni ni-user-run"></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </li>
            </ul>

            <!-- Collapse -->
            <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                <!-- Collapse header -->
                <div class="navbar-collapse-header d-md-none">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="/">
                                <img src="/img/brand/logo2.png">
                            </a>
                        </div>
                        <div class="col-6 collapse-close">
                            <button type="button" class="navbar-toggler" data-toggle="collapse"
                                data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                                aria-label="Toggle sidenav">
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Side Menu Option-->
                <ul class="navbar-nav">
                    <li class="nav-item  active ">
                        <a class="nav-link  active " href="/dashboard">
                            <i class="ni ni-tv-2 text-primary"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="/localisation">
                            <i class="ni ni-planet text-blue"></i> Localisations
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="/logout">
                            <i class="ni ni-button-power"></i> Déconnexion
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-content">
        @yield('content')
    </div>


    <script src="/js/plugins/jquery/dist/jquery.min.js"></script>
    <script src="/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    @stack('chart-scripts')
    <script src="/js/argon-dashboard.min.js?v=1.1.2"></script>
    <script src="/js/axios.min.js"></script>
    <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() { 
            window.TrackJS &&
            TrackJS.install({
                token: "ee6fab19c5a04ac1a32a645abde4613a",
                application: "argon-dashboard-free"
            });
            let body = document.querySelector("body");
            body.addEventListener("click",function(){
                let suggestul = document.querySelector(".autocom-box");
                suggestul.style.display = "none";
            });
            let input = document.getElementById("searchbar");
            isFirstChange = true;
            let intervalID;
            let timeoutID;
            input.addEventListener('input', getCompaniesLikeQuery);
            function getCompaniesLikeQuery() {
                axios.post('/suggestCompanies', {
                    comp_query: input.value,
                    _token: document.querySelector('meta[name="csrf-token"]').innerText
                }).then(function(response){
                    let companies = response.data;
                    let suggestBox = document.querySelector(".autocom-box");
                    while(suggestBox.firstChild){
                        suggestBox.removeChild(suggestBox.firstChild)
                    }
                    let searcResTemplate = document.querySelector("#search-item");
                    for(let i=0; i<companies.length; i++){
                        let searchItem = document.importNode(searcResTemplate.content, true);
                        searchItem.querySelector('span').innerText = companies[i].comp_name;
                        searchItem.querySelector('a').href = '/company-profile/'+companies[i].comp_name;
                        suggestBox.appendChild(searchItem);
                    }
                    document.querySelector('.autocom-box').style.display = 'block';
                });
            }
        });        
    </script>
    @stack('scripts')
</body>
</html>
