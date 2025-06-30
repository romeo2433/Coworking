<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- Dashboard -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Gestion des Réservations -->
        <li class="nav-heading">Gestion des Réservations</li>

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#reservation-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-calendar-check"></i><span>Réservations</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="reservation-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('user.reservations') }}">
                        <i class="bi bi-circle"></i><span>Mes Réservations</span>
                    </a>
                </li>
            </ul>
        </li>

       

        <!-- Administration -->
        <li class="nav-heading">Administration</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('login') }}">
                <i class="bi bi-box-arrow-right"></i>
                <span>Déconnexion</span>
            </a>
        </li>

    </ul>
</aside>

<!-- Styles -->
<style>
    .sidebar {
        width: 250px;
        min-height: 100vh;
        background: #f8f9fa;
        padding: 15px;
        position: fixed;
        top: 60px;
        left: 0;
        transition: transform 0.3s ease, opacity 0.3s ease;
        opacity: 0;
        transform: translateX(-100%);
    }

    .sidebar.loaded {
        opacity: 1;
        transform: translateX(0);
    }

    .nav-item .nav-link {
        display: flex;
        align-items: center;
        padding: 10px;
        font-size: 16px;
        text-decoration: none;
        color: #333;
        transition: all 0.3s ease;
    }

    .nav-item .nav-link i {
        margin-right: 10px;
    }

    .nav-item .nav-link:hover {
        background: #007bff;
        color: white;
        border-radius: 5px;
    }

    .nav-content {
        padding-left: 20px;
    }

    .nav-content a {
        display: block;
        padding: 8px;
        font-size: 14px;
        color: #555;
    }

    .nav-content a:hover {
        color: #007bff;
    }
</style>

<!-- Script -->
<script>
    window.addEventListener('DOMContentLoaded', () => {
        document.querySelector('.sidebar').classList.add('loaded');
    });
</script>
