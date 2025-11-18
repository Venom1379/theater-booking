 <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="logo-icon">
                    <i class="fas fa-film"></i>
                </div>
                <h4 class="mb-0">Theater Admin</h4>
            </div>
            <nav class="sidebar-nav">
                <a href="index.html" class="nav-item active" data-testid="link-dashboard">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
                <!-- <a href="bookings.html" class="nav-item" data-testid="link-bookings">
                    <i class="fas fa-ticket"></i>
                    <span>Bookings</span>
                </a> -->
                 <a href="{{ route('admin.theaters.index') }}" class="nav-item">
                        <i class="ri-building-2-line"></i>  <!-- Theater icon -->
                        <span> Theaters </span>
                    </a>
                <a href="{{ route('admin.shows.index') }}" class="nav-item">
                        <i class="ri-play-list-line"></i>  <!-- Shows icon -->
                        <span> Shows </span>
                    </a>
                <!-- <a href="shows.html" class="nav-item" data-testid="link-shows
                    <i class="fas fa-play"></i>
                    <span>Shows</span>
                </a> -->
                <a href="customers.html" class="nav-item" data-testid="link-customers">
                    <i class="fas fa-users"></i>
                    <span>Customers</span>
                </a>
                <a href="reports.html" class="nav-item" data-testid="link-reports">
                    <i class="fas fa-file-alt"></i>
                    <span>Reports</span>
                </a>
                <a href="settings.html" class="nav-item" data-testid="link-settings">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </nav>
        </div>
