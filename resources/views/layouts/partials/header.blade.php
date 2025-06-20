<div class="main-header">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="red">

        <a href="{{ route('home') }}" class="logo">
            <img src="https://saf.usalesiana.edu.bo/frida/_img/logousb2.png" alt="navbar brand" class="navbar-brand" width="180">
        </a>
        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
            data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <i class="icon-menu"></i>
            </span>
        </button>
        <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
        <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
                <i class="icon-menu"></i>
            </button>
        </div>
    </div>
    <!-- End Logo Header -->

    <!-- Navbar Header -->
    <nav class="navbar navbar-header navbar-expand-lg" data-background-color="red2">

        <div class="container-fluid">
            <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                <li class="nav-item toggle-nav-search hidden-caret">
                    <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false"
                        aria-controls="search-nav">
                        <i class="fa fa-search"></i>
                    </a>
                </li>
                <li class="nav-item dropdown hidden-caret d-none">
                    <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        <span class="notification">4</span>
                    </a>
                    <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                        <li>
                            <div class="dropdown-title">You have 4 new notification</div>
                        </li>
                        <li>
                            <div class="notif-scroll scrollbar-outer">
                                <div class="notif-center">
                                    <a href="#">
                                        <div class="notif-icon notif-primary"> <i class="fa fa-user-plus"></i> </div>
                                        <div class="notif-content">
                                            <span class="block">
                                                New user registered
                                            </span>
                                            <span class="time">5 minutes ago</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <a class="see-all" href="javascript:void(0);">See all notifications<i
                                    class="fa fa-angle-right"></i> </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item dropdown hidden-caret">
                    <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fas fa-layer-group"></i>
                    </a>
                    <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
                        <div class="quick-actions-header">
                            <span class="title mb-1">Acciones rápidas</span>
                        </div>
                        {{-- <div class="quick-actions-scroll scrollbar-outer">
                            <div class="quick-actions-items">
                                <div class="row m-0">
                                    <a class="col-6 col-md-4 p-0" href="{{ route('uduarios.index') }}">
                                        <div class="quick-actions-item">
                                            <i class="flaticon-add-user"></i>
                                            <span class="text">Usuarios</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="{{ route('estudiante.index') }}">
                                        <div class="quick-actions-item">
                                            <i class="flaticon-list"></i>
                                            <span class="text">Alumnos</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="{{ route('docente.index') }}">
                                        <div class="quick-actions-item">
                                            <i class="flaticon-pen"></i>
                                            <span class="text">Docentes</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0" href="{{ route('academic_planning.index') }}">
                                        <div class="quick-actions-item">
                                            <i class="flaticon-agenda-1"></i>
                                            <span class="text">Cursos</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0"
                                        href="{{ route('avance_estudiante.index') }}">
                                        <div class="quick-actions-item">
                                            <i class="flaticon-clock-1"></i>
                                            <span class="text">Marcado Docente</span>
                                        </div>
                                    </a>
                                    <a class="col-6 col-md-4 p-0"
                                        href="{{ route('entregas_avance.index') }}">
                                        <div class="quick-actions-item">
                                            <i class="flaticon-clock-1"></i>
                                            <span class="text">Marcado Administrativo</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </li>
                <li class="nav-item dropdown hidden-caret">
                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"
                        aria-expanded="false">
                        <div class="avatar-sm">
                            <img src="{{ asset('img/profile.jpg') }}" alt="..."
                                class="avatar-img rounded-circle">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                        <div class="dropdown-user-scroll scrollbar-outer">
                            <li>
                                <a class="dropdown-item" href="#">Mi perfil</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Cerrar
                                    Sesión</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!-- End Navbar -->
</div>
