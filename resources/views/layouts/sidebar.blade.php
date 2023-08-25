<aside class="main-sidebar sidebar-dark-primary elevation-4 position-fixed">
    <!-- Brand Logo -->
    <a href="/" class="brand-link" style="text-align: center; text-decoration: none;">
        <span class="brand-text font-weight-light">SMPN 207 SSN</span>
    </a>
    <!-- End Brand Logo -->

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link {{ (request()-> is('home')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Home</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('data') }}" class="nav-link {{ (request()-> is('data')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-table"></i>
                        <p>Data</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('option-cluster') }}" class="nav-link {{ (request()-> is('option-cluster')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-edit"></i>
                        <p>Pilih Cluster</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('showKmeans') }}" class="nav-link {{ (request()-> is('showKmeans')) ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-circle-nodes"></i>
                        <p>Hasil Clustering</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dbi') }}" class="nav-link {{ (request()-> is('dbi')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>DBI</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link">
                        <i class="nav-icon fa-solid fa-right-from-bracket"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar Menu -->

    </div>
<!-- End Sidebar -->
</aside>