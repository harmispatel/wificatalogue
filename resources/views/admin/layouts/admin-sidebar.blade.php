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

    // Get Settings
    $settings = getAdminSettings();
    $favourite_client_limit = isset($settings['favourite_client_limit']) ? $settings['favourite_client_limit'] : 5;

    // Current Route Name
    $routeName = Route::currentRouteName();

    // Get Fav Clients List
    $clients = FavClients($favourite_client_limit);

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
            <a class="nav-link {{ (($routeName != 'clients') && ($routeName != 'clients.add') && ($routeName != 'clients.edit') && ($routeName != 'clients.list')) ? 'collapsed' : '' }} {{ (($routeName == 'clients') || ($routeName == 'clients.add') || ($routeName == 'clients.edit') || ($routeName == 'clients.list')) ? 'active-tab' : '' }}" data-bs-target="#client-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ (($routeName == 'clients') || ($routeName == 'clients.add') || ($routeName == 'clients.edit') || ($routeName == 'clients.list')) ? 'true' : 'false' }}">
                <i class="fa-solid fa-users {{ (($routeName == 'clients') || ($routeName == 'clients.add') || ($routeName == 'clients.edit') || ($routeName == 'clients.list')) ? 'icon-tab' : '' }}"></i><span>Clients</span><i class="bi bi-chevron-down ms-auto {{ (($routeName == 'clients') || ($routeName == 'clients.add') || ($routeName == 'clients.edit') || ($routeName == 'clients.list')) ? 'icon-tab' : '' }}"></i>
            <i class="bi bi-grid clients.list" onclick="gotoTilesView()"></i>
            </a>
            <ul id="client-nav" class="nav-content sidebar-ul collapse {{ (($routeName == 'clients') || ($routeName == 'clients.add') || ($routeName == 'clients.edit') || ($routeName == 'clients.list')) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                @if(count($clients) > 0)
                    @foreach ($clients as $client)
                        @php
                            $shopName = (isset($client->hasOneShop->shop['name'])) ? $client->hasOneShop->shop['name'] : '';
                        @endphp
                        <li>
                            <a href="{{ route('clients.list',$client->id) }}">
                                -- &nbsp;<span>{{ $shopName }}</span>
                            </a>
                        </li>
                    @endforeach
                @endif
                <li>
                    <a href="{{ route('clients.list') }}">
                        <span>All Clients</span>
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
            <a class="nav-link {{ (($routeName != 'admin.profile') && ($routeName != 'admin.settings')) ? 'collapsed' : '' }} {{ (($routeName == 'admin.profile') || ($routeName == 'admin.settings')) ? 'active-tab' : '' }}" data-bs-target="#system-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ (($routeName == 'admin.profile') || ($routeName == 'admin.settings')) ? 'true' : 'false' }}">
                <i class="fa-solid fa-wrench {{ (($routeName == 'admin.profile') || ($routeName == 'admin.settings')) ? 'icon-tab' : '' }}"></i><span>System</span><i class="bi bi-chevron-down ms-auto {{ (($routeName == 'admin.profile') || ($routeName == 'admin.settings')) ? 'icon-tab' : '' }}"></i>
            </a>
            <ul id="system-nav" class="nav-content sidebar-ul collapse {{ (($routeName == 'admin.profile') || ($routeName == 'admin.settings')) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('admin.profile',$userID) }}" class="{{ ($routeName == 'admin.profile') ? 'active-link' : '' }}">
                        {{-- <i class="{{ ($routeName == 'admin.profile') ? 'bi bi-circle-fill' : 'bi bi-circle' }}"></i>--}}
                        <span>Profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admins') }}" class="{{ ($routeName == 'admins') ? 'active-link' : '' }}">
                        <span>Admins</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.settings') }}" class="{{ ($routeName == 'admin.settings') ? 'active-link' : '' }}">
                        <span>Settings</span>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</aside>
