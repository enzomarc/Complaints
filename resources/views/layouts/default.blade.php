<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="description" content="Neon Admin Panel"/>
    <meta name="author" content="emarc237@gmail.com"/>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="icon" href="assets/images/favicon.ico">

    <title>Plainty | Tableau de bord</title>

    <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/css/neon-core.css">
    <link rel="stylesheet" href="assets/css/neon-theme.css">
    <link rel="stylesheet" href="assets/css/neon-forms.css">
    <link rel="stylesheet" href="assets/css/custom.css">

    @yield('css')

    <script src="assets/js/jquery-1.11.3.min.js"></script>

    <!--[if lt IE 9]>
    <script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>
<body class="page-body" data-url="http://neon.dev">

<div class="page-container">
    <!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->

    <div class="sidebar-menu">

        <div class="sidebar-menu-inner">

            <header class="logo-env">

                <!-- logo -->
                <div class="logo">
                    <a href="index.html">
                        <img src="assets/images/logo@2x.png" width="120" alt=""/>
                    </a>
                </div>

                <!-- logo collapse icon -->
                <div class="sidebar-collapse">
                    <a href="#" class="sidebar-collapse-icon with-animation">
                        <!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
                        <i class="entypo-menu"></i>
                    </a>
                </div>


                <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
                <div class="sidebar-mobile-menu visible-xs">
                    <a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
                        <i class="entypo-menu"></i>
                    </a>
                </div>

            </header>


            <ul id="main-menu" class="main-menu">
                <!-- add class "multiple-expanded" to allow multiple submenus to open -->
                <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="entypo-layout"></i>
                        <span class="title">Tableau de bord</span>
                    </a>
                </li>

                <!-- Administrator menus -->
                @if($user->type == 2)
                    <li>
                        <a href="{{ route('investigators.index') }}">
                            <i class="entypo-users"></i>
                            <span class="title">Enquêteurs</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('unities.index') }}">
                            <i class="entypo-flag"></i>
                            <span class="title">Unités</span>
                        </a>
                    </li>
                @endif

            <!-- Investigator menus -->
                @if($user->type == 1)
                    <li>
                        <a href="{{ route('complaints.index') }}">
                            <i class="entypo-box"></i>
                            <span class="title">Plaintes</span>
                        </a>

                        <a href="{{ route('investigations.index') }}">
                            <i class="entypo-folder"></i>
                            <span class="title">Enquêtes</span>
                        </a>
                    </li>
                @endif

            <!-- User menus -->
                @if($user->type == 0)



                @endif

                <li class="has-sub">
                    <a href="#">
                        <i class="entypo-flow-tree"></i>
                        <span class="title">Menu Levels</span>
                    </a>
                    <ul>
                        <li>
                            <a href="#">
                                <i class="entypo-flow-line"></i>
                                <span class="title">Menu Level 1.1</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="entypo-flow-line"></i>
                                <span class="title">Menu Level 1.2</span>
                            </a>
                        </li>
                        <li class="has-sub">
                            <a href="#">
                                <i class="entypo-flow-line"></i>
                                <span class="title">Menu Level 1.3</span>
                            </a>
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class="entypo-flow-parallel"></i>
                                        <span class="title">Menu Level 2.1</span>
                                    </a>
                                </li>
                                <li class="has-sub">
                                    <a href="#">
                                        <i class="entypo-flow-parallel"></i>
                                        <span class="title">Menu Level 2.2</span>
                                    </a>
                                    <ul>
                                        <li class="has-sub">
                                            <a href="#">
                                                <i class="entypo-flow-cascade"></i>
                                                <span class="title">Menu Level 3.1</span>
                                            </a>
                                            <ul>
                                                <li>
                                                    <a href="#">
                                                        <i class="entypo-flow-branch"></i>
                                                        <span class="title">Menu Level 4.1</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="entypo-flow-cascade"></i>
                                                <span class="title">Menu Level 3.2</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class="entypo-flow-parallel"></i>
                                        <span class="title">Menu Level 2.3</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>

        </div>

    </div>

    <div class="main-content">
        <div class="row">

            <!-- Profile Info and Notifications -->
            <div class="col-md-6 col-sm-8 clearfix">

                <ul class="user-info pull-left pull-none-xsm">

                    <!-- Profile Info -->
                    <li class="profile-info dropdown">
                        <!-- add class "pull-right" if you want to place this from right -->

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ $user->avatar }}" alt="" class="img-circle" width="44">
                            {{ $user->first_name . ' ' . $user->last_name }}
                        </a>

                        <ul class="dropdown-menu">

                            <!-- Reverse Caret -->
                            <li class="caret"></li>

                            <!-- Profile sub-links -->
                            <li>
                                <a href="extra-timeline.html">
                                    <i class="entypo-user"></i>
                                    Modifier mon compte
                                </a>
                            </li>

                            <li>
                                <a href="mailbox.html">
                                    <i class="entypo-mail"></i>
                                    Messages
                                </a>
                            </li>

                            @if($user->type == 1)
                                <li>
                                    <a href="#">
                                        <i class="entypo-clipboard"></i>
                                        Mes enquêtes
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>

                </ul>

                <ul class="user-info pull-left pull-right-xs pull-none-xsm">

                    <!-- Raw Notifications -->
                    <li class="notifications dropdown">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <i class="entypo-attention"></i>
                            <span class="badge badge-info">6</span>
                        </a>

                        <ul class="dropdown-menu">
                            <li class="top">
                                <p class="small">
                                    <a href="#" class="pull-right">Tout marqué comme lu</a>
                                    Vous avez <strong>3</strong> nouvelles notifications.
                                </p>
                            </li>

                            <li>
                                <ul class="dropdown-menu-list scroller" tabindex="5001"
                                    style="overflow: hidden; outline: none;">
                                    <li class="unread notification-success">
                                        <a href="#">
                                            <i class="entypo-user-add pull-right"></i>

                                            <span class="line">
												<strong>New user registered</strong>
											</span>

                                            <span class="line small">
												30 seconds ago
											</span>
                                        </a>
                                    </li>

                                    <li class="unread notification-secondary">
                                        <a href="#">
                                            <i class="entypo-heart pull-right"></i>

                                            <span class="line">
												<strong>Someone special liked this</strong>
											</span>

                                            <span class="line small">
												2 minutes ago
											</span>
                                        </a>
                                    </li>

                                    <li class="notification-primary">
                                        <a href="#">
                                            <i class="entypo-user pull-right"></i>

                                            <span class="line">
												<strong>Privacy settings have been changed</strong>
											</span>

                                            <span class="line small">
												3 hours ago
											</span>
                                        </a>
                                    </li>

                                    <li class="notification-danger">
                                        <a href="#">
                                            <i class="entypo-cancel-circled pull-right"></i>

                                            <span class="line">
												John cancelled the event
											</span>

                                            <span class="line small">
												9 hours ago
											</span>
                                        </a>
                                    </li>

                                    <li class="notification-info">
                                        <a href="#">
                                            <i class="entypo-info pull-right"></i>

                                            <span class="line">
												The server is status is stable
											</span>

                                            <span class="line small">
												yesterday at 10:30am
											</span>
                                        </a>
                                    </li>

                                    <li class="notification-warning">
                                        <a href="#">
                                            <i class="entypo-rss pull-right"></i>

                                            <span class="line">
												New comments waiting approval
											</span>

                                            <span class="line small">
												last week
											</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="external">
                                <a href="#">Voir toutes les notifications</a>
                            </li>
                            <div id="ascrail2001" class="nicescroll-rails"
                                 style="padding-right: 3px; width: 10px; z-index: 1000; cursor: default; position: absolute; top: 0px; left: -10px; height: 0px; display: none;">
                                <div style="position: relative; top: 0px; float: right; width: 5px; height: 0px; background-color: rgb(212, 212, 212); border: 1px solid rgb(204, 204, 204); background-clip: padding-box; border-radius: 1px;"></div>
                            </div>
                            <div id="ascrail2001-hr" class="nicescroll-rails"
                                 style="height: 7px; z-index: 1000; top: -7px; left: 0px; position: absolute; cursor: default; display: none;">
                                <div style="position: relative; top: 0px; height: 5px; width: 0px; background-color: rgb(212, 212, 212); border: 1px solid rgb(204, 204, 204); background-clip: padding-box; border-radius: 1px;"></div>
                            </div>
                        </ul>

                    </li>

                    <!-- Message Notifications -->
                    <li class="notifications dropdown">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                           data-close-others="true">
                            <i class="entypo-mail"></i>
                            <span class="badge badge-secondary">10</span>
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <form class="top-dropdown-search">

                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Rechercher..." name="s">
                                    </div>

                                </form>

                                <ul class="dropdown-menu-list scroller" tabindex="5002"
                                    style="overflow: hidden; outline: none;">
                                    <li class="active">
                                        <a href="#">
											<span class="image pull-right">
												<img src="assets/images/thumb-1@2x.png" width="44" alt=""
                                                     class="img-circle">
											</span>

                                            <span class="line">
												<strong>Luc Chartier</strong>
												- yesterday
											</span>

                                            <span class="line desc small">
												This ain’t our first item, it is the best of the rest.
											</span>
                                        </a>
                                    </li>

                                    <li class="active">
                                        <a href="#">
											<span class="image pull-right">
												<img src="assets/images/thumb-2@2x.png" width="44" alt=""
                                                     class="img-circle">
											</span>

                                            <span class="line">
												<strong>Salma Nyberg</strong>
												- 2 days ago
											</span>

                                            <span class="line desc small">
												Oh he decisively impression attachment friendship so if everything.
											</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#">
											<span class="image pull-right">
												<img src="assets/images/thumb-3@2x.png" width="44" alt=""
                                                     class="img-circle">
											</span>

                                            <span class="line">
												Hayden Cartwright
												- a week ago
											</span>

                                            <span class="line desc small">
												Whose her enjoy chief new young. Felicity if ye required likewise so doubtful.
											</span>
                                        </a>
                                    </li>

                                    <li>
                                        <a href="#">
											<span class="image pull-right">
												<img src="assets/images/thumb-4@2x.png" width="44" alt=""
                                                     class="img-circle">
											</span>

                                            <span class="line">
												Sandra Eberhardt
												- 16 days ago
											</span>

                                            <span class="line desc small">
												On so attention necessary at by provision otherwise existence direction.
											</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                            <li class="external">
                                <a href="mailbox.html">Tous les Messages</a>
                            </li>
                            <div id="ascrail2002" class="nicescroll-rails"
                                 style="padding-right: 3px; width: 10px; z-index: 1000; cursor: default; position: absolute; top: 0px; left: -10px; height: 0px; display: none;">
                                <div style="position: relative; top: 0px; float: right; width: 5px; height: 0px; background-color: rgb(212, 212, 212); border: 1px solid rgb(204, 204, 204); background-clip: padding-box; border-radius: 1px;"></div>
                            </div>
                            <div id="ascrail2002-hr" class="nicescroll-rails"
                                 style="height: 7px; z-index: 1000; top: -7px; left: 0px; position: absolute; cursor: default; display: none;">
                                <div style="position: relative; top: 0px; height: 5px; width: 0px; background-color: rgb(212, 212, 212); border: 1px solid rgb(204, 204, 204); background-clip: padding-box; border-radius: 1px;"></div>
                            </div>
                        </ul>

                    </li>

                @if ($user->type == 1)
                    <!-- Task Notifications -->
                        <li class="notifications dropdown">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown"
                               data-close-others="true">
                                <i class="entypo-list"></i>
                                <span class="badge badge-warning">1</span>
                            </a>

                            <ul class="dropdown-menu">
                                <li class="top">
                                    <p>Vous avez 6 enquêtes en cours</p>
                                </li>

                                <li>
                                    <ul class="dropdown-menu-list scroller" tabindex="5003"
                                        style="overflow: hidden; outline: none;">
                                        <li>
                                            <a href="#">
                                                <span class="task">
                                                    <span class="desc">Procurement</span>
                                                    <span class="percent">27%</span>
                                                </span>

                                                <span class="progress">
                                                    <span style="width: 27%;" class="progress-bar progress-bar-success">
                                                        <span class="sr-only">27% Complete</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span class="task">
                                                    <span class="desc">App Development</span>
                                                    <span class="percent">83%</span>
                                                </span>

                                                <span class="progress progress-striped">
                                                    <span style="width: 83%;" class="progress-bar progress-bar-danger">
                                                        <span class="sr-only">83% Complete</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span class="task">
                                                    <span class="desc">HTML Slicing</span>
                                                    <span class="percent">91%</span>
                                                </span>

                                                <span class="progress">
                                                    <span style="width: 91%;" class="progress-bar progress-bar-success">
                                                        <span class="sr-only">91% Complete</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span class="task">
                                                    <span class="desc">Database Repair</span>
                                                    <span class="percent">12%</span>
                                                </span>

                                                <span class="progress progress-striped">
                                                    <span style="width: 12%;" class="progress-bar progress-bar-warning">
                                                        <span class="sr-only">12% Complete</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span class="task">
                                                    <span class="desc">Backup Create Progress</span>
                                                    <span class="percent">54%</span>
                                                </span>

                                                <span class="progress progress-striped">
                                                    <span style="width: 54%;" class="progress-bar progress-bar-info">
                                                        <span class="sr-only">54% Complete</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span class="task">
                                                    <span class="desc">Upgrade Progress</span>
                                                    <span class="percent">17%</span>
                                                </span>

                                                <span class="progress progress-striped">
                                                    <span style="width: 17%;"
                                                          class="progress-bar progress-bar-important">
                                                        <span class="sr-only">17% Complete</span>
                                                    </span>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li class="external">
                                    <a href="#">Voir toutes mes enquêtes</a>
                                </li>
                                <div id="ascrail2003" class="nicescroll-rails"
                                     style="padding-right: 3px; width: 10px; z-index: 1000; cursor: default; position: absolute; top: 0px; left: -10px; height: 0px; display: none;">
                                    <div style="position: relative; top: 0px; float: right; width: 5px; height: 0px; background-color: rgb(212, 212, 212); border: 1px solid rgb(204, 204, 204); background-clip: padding-box; border-radius: 1px;"></div>
                                </div>
                                <div id="ascrail2003-hr" class="nicescroll-rails"
                                     style="height: 7px; z-index: 1000; top: -7px; left: 0px; position: absolute; cursor: default; display: none;">
                                    <div style="position: relative; top: 0px; height: 5px; width: 0px; background-color: rgb(212, 212, 212); border: 1px solid rgb(204, 204, 204); background-clip: padding-box; border-radius: 1px;"></div>
                                </div>
                            </ul>

                        </li>
                    @endif

                </ul>

            </div>


            <!-- Raw Links -->
            <div class="col-md-6 col-sm-4 clearfix hidden-xs">

                <ul class="list-inline links-list pull-right">

                    <!-- Language Selector -->
                    <li class="dropdown language-selector">

                        Langue: &nbsp;
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-close-others="true">
                            <img src="assets/images/flags/flag-fr.png" width="16" height="16">
                        </a>

                        <ul class="dropdown-menu pull-right">
                            <li>
                                <a href="#">
                                    <img src="assets/images/flags/flag-uk.png" width="16" height="16">
                                    <span>English</span>
                                </a>
                            </li>
                            <li class="active">
                                <a href="#">
                                    <img src="assets/images/flags/flag-fr.png" width="16" height="16">
                                    <span>Français</span>
                                </a>
                            </li>
                        </ul>

                    </li>

                    <li class="sep"></li>

                    <li>
                        <a href="{{ route('logout') }}">
                            Déconnexion <i class="entypo-logout right"></i>
                        </a>
                    </li>
                </ul>

            </div>

        </div>

        <hr>

        @yield('content')
    </div>


</div>

<!-- Add CSRF Token to AJAX -->
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<!-- Bottom scripts (common) -->
<script src="assets/js/gsap/TweenMax.min.js"></script>
<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="assets/js/bootstrap.js"></script>
<script src="assets/js/joinable.js"></script>
<script src="assets/js/resizeable.js"></script>
<script src="assets/js/neon-api.js"></script>


<!-- JavaScripts initializations and stuff -->
<script src="assets/js/neon-custom.js"></script>


<!-- Demo Settings -->
<script src="assets/js/neon-demo.js"></script>

@yield('script')

</body>
</html>