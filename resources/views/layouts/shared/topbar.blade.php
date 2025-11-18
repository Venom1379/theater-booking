<!-- ========== Topbar Start ========== -->
<header class="top-header">
                <button class="btn btn-link d-lg-none" id="sidebarToggle" data-testid="button-sidebar-toggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div>
                    <h3 class="mb-0" data-testid="text-page-title">{{ $page_title }}</h3>
                    <p class="text-muted small mb-0" data-testid="text-page-subtitle">Overview of your theater operations</p>
                </div>
                <div class="header-actions">
                    <button class="btn btn-outline-primary btn-sm" onclick="handleBackToWebsite()" data-testid="button-back-to-website">
                        <i class="fas fa-globe me-2"></i>Back to Website
                    </button>
                    <div class="user-info">
                        <div class="text-end d-none d-sm-block">
                             <img src="{{ auth()->user()->profile_image ?? asset('images/users/default-avatar.jpg') }}" 
                          alt="user-image" width="32" class="rounded-circle">
                            <!-- <div class="fw-medium" data-testid="text-user-name">Theater Supervisor</div> -->
                             <div class="fw-medium" data-testid="text-user-name">Theater Supervisor</div>
                            <!-- <div class="small text-muted" data-testid="text-user-email">supervisor@theater.com</div> -->
                            <!-- <div class="small text-muted" data-testid="text-user-email">{{ auth()->user()->name ?? 'Guest' }} </div> -->

                        </div>
                        <button class="btn btn-danger btn-sm" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" data-testid="button-logout">
                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                        </button>
                         <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                     @csrf
                 </form>
                    </div>
                </div>
            </header>
<!-- ========== Topbar End ========== -->