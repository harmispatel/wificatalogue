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

        {{-- Clients --}}
        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'clients' || $routeName == 'clients.add' || $routeName == 'clients.edit') ? 'active-tab' : '' }}" href="{{ route('clients') }}">
                <i class="fa-solid fa-users {{ ($routeName == 'clients' || $routeName == 'clients.add' || $routeName == 'clients.edit') ? 'icon-tab' : '' }}"></i>
                <span>Clients</span>
                <i class="bi bi-grid-fill icon_right"></i>
            </a>
        </li>

        {{-- Settings Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ (($routeName != 'subscriptions') && ($routeName != 'subscription.add') && ($routeName != 'subscription.edit') && ($routeName != 'admin.profile')) ? 'collapsed' : '' }} {{ (($routeName == 'subscriptions') || ($routeName == 'subscription.add') || ($routeName == 'subscription.edit') || ($routeName == 'admin.profile')) ? 'active-tab' : '' }}" data-bs-target="#system-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ (($routeName == 'subscriptions') || ($routeName == 'subscription.add') || ($routeName == 'subscription.edit') || ($routeName == 'admin.profile')) ? 'true' : 'false' }}">
                <i class="fa-solid fa-wrench {{ (($routeName == 'subscriptions') || ($routeName == 'subscription.add') || ($routeName == 'subscription.edit') || ($routeName == 'admin.profile')) ? 'icon-tab' : '' }}"></i><span>Systems</span><i class="bi bi-chevron-down ms-auto {{ (($routeName == 'subscriptions') || ($routeName == 'subscription.add') || ($routeName == 'subscription.edit') || ($routeName == 'admin.profile')) ? 'icon-tab' : '' }}"></i>
            </a>
            <ul id="system-nav" class="nav-content sidebar-ul collapse {{ (($routeName == 'subscriptions') || ($routeName == 'subscription.add') || ($routeName == 'subscription.edit') || ($routeName == 'admin.profile')) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('subscriptions') }}" class="{{ ($routeName == 'subscriptions' || $routeName == 'subscription.add' || $routeName == 'subscription.edit') ? 'active-link' : '' }}">
                        {{-- <i class="{{ ($routeName == 'subscriptions' || $routeName == 'subscription.add' || $routeName == 'subscription.edit') ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i>--}}
                        <span>Subscription</span>
                    </a>
                    <a href="{{ route('admin.profile',$userID) }}" class="{{ ($routeName == 'admin.profile') ? 'active-link' : '' }}">
                        {{-- <i class="{{ ($routeName == 'subscriptions' || $routeName == 'subscription.add' || $routeName == 'subscription.edit') ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i>--}}
                        <span>Profile</span>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</aside>
