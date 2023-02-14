@php
    // UserDetails
    if (auth()->user())
    {
        $userID = encrypt(auth()->user()->id);
        $userName = auth()->user()->name;
        $userImage = auth()->user()->image;
    }
    else
    {
        $userID = '';
        $userName = '';
        $userImage = '';
    }

    $routeName = Route::currentRouteName();

@endphp

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        {{-- Dashboard Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'admin.dashboard') ? 'active-tab' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-house-chimney {{ ($routeName == 'admin.dashboard') ? 'icon-tab' : '' }}"></i>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- Clients --}}
        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'clients' || $routeName == 'clients.add') ? 'active-tab' : '' }}" href="{{ route('clients') }}">
                <i class="fa-solid fa-users {{ ($routeName == 'clients' || $routeName == 'clients.add') ? 'icon-tab' : '' }}"></i>
                <span>Clients</span>
            </a>
        </li>

        <li class="nav-item">
            <a href="nav-link">
                
            </a>
        </li>

        {{-- Packages Nav --}}
        {{-- <li class="nav-item">
            <a class="nav-link {{ ((Route::currentRouteName() != 'packages') && (Route::currentRouteName() != 'package-type')) ? 'collapsed' : '' }} {{ ((Route::currentRouteName() == 'packages') || (Route::currentRouteName() == 'package-type')) ? 'active-tab' : '' }}" data-bs-target="#packages-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ ((Route::currentRouteName() == 'packages') || (Route::currentRouteName() == 'package-type')) ? 'true' : 'false' }}">
                <i class="bi bi-collection {{ ((Route::currentRouteName() == 'packages') || (Route::currentRouteName() == 'package-type')) ? 'icon-tab' : '' }}"></i><span>Packages</span><i class="bi bi-chevron-down ms-auto {{ ((Route::currentRouteName() == 'packages') || (Route::currentRouteName() == 'package-types')) ? 'icon-tab' : '' }}"></i>
            </a>
            <ul id="packages-nav" class="nav-content sidebar-ul collapse {{ ((Route::currentRouteName() == 'packages') || (Route::currentRouteName() == 'package-type')) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('packages') }}" class="{{ (Route::currentRouteName() == 'packages') ? 'active-link' : '' }}">
                        <i class="{{ (Route::currentRouteName() == 'packages') ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Packages</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('package-type') }}" class="{{ (Route::currentRouteName() == 'package-type') ? 'active-link' : '' }}">
                        <i class="{{ (Route::currentRouteName() == 'package-type') ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Package Types</span>
                    </a>
                </li>
            </ul>
        </li> --}}

    </ul>
</aside>
