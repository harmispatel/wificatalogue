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

        {{-- toggle --}}
        {{-- <li class="nav-itme">
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </li> --}}

        {{-- Dashboard Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'admin.dashboard') ? 'active-tab' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-house-chimney {{ ($routeName == 'admin.dashboard') ? 'icon-tab' : '' }}"></i>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- Clients Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ (($routeName != 'clients') && ($routeName != 'clients.add') && ($routeName != 'clients.edit')) ? 'collapsed' : '' }} {{ (($routeName == 'clients') || ($routeName == 'clients.add') || ($routeName == 'clients.edit')) ? 'active-tab' : '' }}" data-bs-target="#client-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ (($routeName == 'clients') || ($routeName == 'clients.add') || ($routeName == 'clients.edit')) ? 'true' : 'false' }}">
                <i class="fa-solid fa-users {{ (($routeName == 'clients') || ($routeName == 'clients.add') || ($routeName == 'clients.edit')) ? 'icon-tab' : '' }}"></i><span>Clients</span><i class="bi bi-chevron-down ms-auto {{ (($routeName == 'clients') || ($routeName == 'clients.add') || ($routeName == 'clients.edit')) ? 'icon-tab' : '' }}"></i>
            </a>
            <ul id="client-nav" class="nav-content sidebar-ul collapse {{ (($routeName == 'clients') || ($routeName == 'clients.add') || ($routeName == 'clients.edit')) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('clients') }}" class="{{ ($routeName == 'clients' || $routeName == 'clients.add' || $routeName == 'clients.edit') ? 'active-link' : '' }}">
                        {{-- <i class="{{ ($routeName == 'subscriptions' || $routeName == 'subscription.add' || $routeName == 'subscription.edit') ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i>--}}
                        <span>Clients</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Subscriptions Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ (($routeName == 'subscriptions') || ($routeName == 'subscriptions.add') || ($routeName == 'subscriptions.edit')) ? 'active-tab' : '' }}" href="{{ route('subscriptions') }}">
                <i class="fa-solid fa-cubes {{ (($routeName == 'subscriptions') || ($routeName == 'subscriptions.add') || ($routeName == 'subscriptions.edit')) ? 'icon-tab' : '' }}"></i>
                <span>Subscriptions</span>
            </a>
        </li>

        {{-- System Nav --}}
        <li class="nav-item">
            {{-- First && and !=  --}}
            <a class="nav-link {{ (($routeName != 'admin.profile')) ? 'collapsed' : '' }} {{ (($routeName == 'admin.profile')) ? 'active-tab' : '' }}" data-bs-target="#system-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ (($routeName == 'admin.profile')) ? 'true' : 'false' }}">
                <i class="fa-solid fa-wrench {{ (($routeName == 'admin.profile')) ? 'icon-tab' : '' }}"></i><span>System</span><i class="bi bi-chevron-down ms-auto {{ (($routeName == 'admin.profile')) ? 'icon-tab' : '' }}"></i>
            </a>
            <ul id="system-nav" class="nav-content sidebar-ul collapse {{ (($routeName == 'admin.profile')) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('admin.profile',$userID) }}" class="{{ ($routeName == 'admin.profile') ? 'active-link' : '' }}">
                        {{-- <i class="{{ ($routeName == 'admin.profile') ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i>--}}
                        <span>Profile</span>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</aside>
