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
                <i class="bi bi-grid {{ ($routeName == 'admin.dashboard') ? 'icon-tab' : '' }}"></i>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- Clients --}}
        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'clients' || $routeName == 'clients.add' || $routeName == 'clients.edit') ? 'active-tab' : '' }}" href="{{ route('clients') }}">
                <i class="bi bi-people {{ ($routeName == 'clients' || $routeName == 'clients.add' || $routeName == 'clients.edit') ? 'icon-tab' : '' }}"></i>
                <span>Clients</span>
            </a>
        </li>

        {{-- Settings Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ (($routeName != 'subscriptions') && ($routeName != 'subscription.add') && ($routeName != 'subscription.edit')) ? 'collapsed' : '' }} {{ (($routeName == 'subscriptions') || ($routeName == 'subscription.add') || ($routeName == 'subscription.edit')) ? 'active-tab' : '' }}" data-bs-target="#system-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ (($routeName == 'subscriptions') || ($routeName == 'subscription.add') || ($routeName == 'subscription.edit')) ? 'true' : 'false' }}">
                <i class="bi bi-gear {{ (($routeName == 'subscriptions') || ($routeName == 'subscription.add') || ($routeName == 'subscription.edit')) ? 'icon-tab' : '' }}"></i><span>Systems</span><i class="bi bi-chevron-down ms-auto {{ (($routeName == 'subscriptions') || ($routeName == 'subscription.add') || ($routeName == 'subscription.edit')) ? 'icon-tab' : '' }}"></i>
            </a>
            <ul id="system-nav" class="nav-content sidebar-ul collapse {{ (($routeName == 'subscriptions') || ($routeName == 'subscription.add') || ($routeName == 'subscription.edit')) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('subscriptions') }}" class="{{ ($routeName == 'subscriptions' || $routeName == 'subscription.add' || $routeName == 'subscription.edit') ? 'active-link' : '' }}">
                        <i class="{{ ($routeName == 'subscriptions' || $routeName == 'subscription.add' || $routeName == 'subscription.edit') ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i><span>Subscription</span>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</aside>
