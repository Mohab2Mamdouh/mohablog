<header>
    <div class="px-3 py-3 modern-navbar">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center justify-content-between">

                <a class="navbar-brand d-flex align-items-center text-white text-decoration-none" href="#">
                    <span class="menu-toggle" onclick="openNav()">
                        <i class="fas fa-bars"></i>
                    </span>
                    <span class="brand-name">{{ $user->username }}</span>
                </a>

                <ul class="nav align-items-center">
                    <li class="nav-item">
                        <a href="{{ route('portfolio') }}" class="nav-link-custom">
                            <i class="fa-solid fa-house-chimney"></i>
                            <span>{{ __('Portfolio') }}</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle profile-dropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img src="{{ asset('storage/users/'. $user->profileImage) }}" alt="Profile" class="profile-avatar">
                        </a>

                        <div class="dropdown-menu dropdown-menu-end modern-dropdown" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>

<style>
.modern-navbar {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    position: sticky;
    top: 0;
    z-index: 1000;
    backdrop-filter: blur(10px);
}

.menu-toggle {
    font-size: 24px;
    cursor: pointer;
    padding: 10px 15px;
    border-radius: 8px;
    transition: all 0.3s ease;
    margin-right: 15px;
}

.menu-toggle:hover {
    background: rgba(99,102,241,0.2);
    transform: scale(1.1);
}

.brand-name {
    font-size: 1.5rem;
    font-weight: 700;
    text-transform: capitalize;
}

.nav-link-custom {
    color: #94a3b8 !important;
    padding: 10px 20px;
    border-radius: 8px;
    transition: all 0.3s ease;
    text-decoration: none;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
}

.nav-link-custom:hover {
    color: #fff !important;
    background: rgba(99,102,241,0.2);
}

.profile-avatar {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    border: 3px solid rgba(99,102,241,0.5);
    transition: all 0.3s ease;
    object-fit: cover;
}

.profile-avatar:hover {
    border-color: #6366f1;
    transform: scale(1.1);
    box-shadow: 0 4px 15px rgba(99,102,241,0.4);
}

.modern-dropdown {
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    padding: 10px;
    margin-top: 10px;
}

.modern-dropdown .dropdown-item {
    border-radius: 8px;
    padding: 12px 20px;
    transition: all 0.3s ease;
    font-weight: 500;
}

.modern-dropdown .dropdown-item:hover {
    background: rgba(239,68,68,0.1);
    color: #ef4444;
    transform: translateX(5px);
}
</style>
