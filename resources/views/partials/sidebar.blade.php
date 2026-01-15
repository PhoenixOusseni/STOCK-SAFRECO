<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link " href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-heading">CONFIGURATION</li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('entetes.index') }}">
                <i class="bi bi-building"></i>
                <span>Infos société</span>
            </a>
        </li><!-- End Profile Page Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('gestions_familles.index') }}">
                <i class="bi bi-collection"></i>
                <span>Groupe immobilisation</span>
            </a>
        </li><!-- End Family Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('gestions_articles.index') }}">
                <i class="bi bi-bag"></i>
                <span>Immobilisation</span>
            </a>
        </li><!-- End Login Page Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('articles.article_code_barre') }}">
                <i class="bi bi-bag"></i>
                <span>Code bare</span>
            </a>
        </li><!-- End Login Page Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('gestions_inventaires.index') }}">
                <i class="bi bi-bag"></i>
                <span>Inventaire</span>
            </a>
        </li><!-- End Login Page Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('gestions_depots.index') }}">
                <i class="bi bi-diagram-3"></i>
                <span>Centre géographique</span>
            </a>
        </li><!-- End Error 404 Page Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('gestions_depots.index') }}">
                <i class="bi bi-diagram-3"></i>
                <span>Agence</span>
            </a>
        </li><!-- End Error 404 Page Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('gestions_depots.index') }}">
                <i class="bi bi-diagram-3"></i>
                <span>Direction</span>
            </a>
        </li><!-- End Error 404 Page Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#">
                <i class="bi bi-door-closed"></i>
                <span>Bureaux</span>
            </a>
        </li><!-- End Offices Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('gestions_clients.index') }}">
                <i class="bi bi-people"></i>
                <span>Bailleur</span>
            </a>
        </li><!-- End F.A.Q Page Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('amortissements.taux_amortissement') }}">
                <i class="bi bi-percent"></i>
                <span>Tableau d'amortissements</span>
            </a>
        </li><!-- End Depreciation Rate Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('gestions_fournisseurs.index') }}">
                <i class="bi bi-truck"></i>
                <span>Fournisseurs</span>
            </a>
        </li><!-- End Contact Page Nav -->
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-box-seam"></i><span>SAISIES</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('gestions_entrees.index') }}">
                        <i class="bi bi-circle"></i><span>Entrees</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('gestions_sorties.index') }}">
                        <i class="bi bi-circle"></i><span>Sorties</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('gestions_transferts.index') }}">
                        <i class="bi bi-circle"></i><span>Transferts</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('gestions_inventaires.index') }}">
                        <i class="bi bi-circle"></i><span>Inventaire</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Forms Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-calculator"></i><span>REEVALUATIONS</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                <li>
                    <a href="#">
                        <i class="bi bi-arrow-repeat"></i><span>Reajustements</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-percent"></i><span>Amortissements</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="bi bi-receipt"></i><span>Valeurs comptables</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Components Nav -->

        <li>
            <a class="nav-link collapsed" href="{{ route('gestions_utilisateurs.index') }}">
                <i class="bi bi-person-circle"></i>
                <span>Utilisateurs</span>
            </a>
        </li>
    </ul>
</aside><!-- End Sidebar-->
