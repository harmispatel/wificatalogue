@php
    // UserDetails
    if (auth()->user())
    {
        $userID = encrypt(auth()->user()->id);
        $userName = auth()->user()->firstname." ".auth()->user()->lastname;
        $userImage = auth()->user()->image;
    }
    else
    {
        $userID = '';
        $userName = '';
        $userImage = '';
    }

    $settings = getAdminSettings();
    $logo = isset($settings['logo']) ? $settings['logo'] : '';

@endphp

<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between text-center">
        <a href="{{ route('admin.dashboard') }}" class="logo d-flex align-items-center justify-content-center">
            @if(!empty($logo))
                <img class="w-100" src="{{ $logo }}" alt="Logo">
            @else
                <span class="d-none d-lg-block">My Logo</span>
            @endif
        </a>

        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item dropdown pe-3">
                @php
                    $lang_id = session('lang_code');
                @endphp
                <select class="form-select" aria-label="Default select language" id="backend-lang" onchange="changeBackendLang()">
                    <option value="en" {{ ($lang_id == 'en') ? 'selected' : '' }}>English</option>
                    <option value="el" {{ ($lang_id == 'el') ? 'selected' : '' }}>Greek</option>
                </select>
            </li>
            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    @if (!empty($userImage) || $userImage != null)
                        <img src="{{ asset($userImage) }}" alt="Profile" class="rounded-circle">
                    @else
                        <img src="{{ asset('public/admin_images/demo_images/profiles/profile1.jpg') }}" alt="Profile" class="rounded-circle">
                    @endif
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ $userName }}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6>{{ $userName }}</h6>
                        <span>Administartor</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.profile.view',$userID) }}">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a href="{{ route('logout') }}" class="dropdown-item d-flex align-items-center">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Logout</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</header>
