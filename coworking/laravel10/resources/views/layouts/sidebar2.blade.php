<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Gestion des Réservations -->
        <li class="nav-heading">Gestion des Réservations</li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#reservation-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-calendar-check"></i><span>Import et Expore CSV</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="reservation-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('import.form') }}">
                        <i class="bi bi-circle"></i><span>Import Csv Option et Espaces</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('import.reservations.form') }}">
                        <i class="bi bi-circle"></i><span>Import CSV Reservations</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('paiements.import') }}">
                        <i class="bi bi-circle"></i><span>Import CSV Paiements</span>
                    </a>
                </li>
            </ul>
        </li>

      <!-- Statistiques -->
<li class="nav-heading">Statistiques</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('admin.stats') }}">
        <i class="bi bi-bar-chart-line"></i>
        <span>Chiffre d'affaires</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link collapsed" href="{{ route('admin.Affaire') }}">
        <i class="bi bi-graph-up-arrow"></i>
        <span>Chiffre d'affaires total </span>
    </a>
</li>


        <!-- Administration -->
        <li class="nav-heading">Administration</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('admin.login') }}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Déconnexion</span>
            </a>
        </li>
    </ul>
</aside>


<!-- Styles -->

