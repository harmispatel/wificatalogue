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

    // Current Route Name
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
            <a class="nav-link {{ ($routeName == 'client.dashboard') ? 'active-tab' : '' }}" href="{{ route('client.dashboard') }}">
                <i class="fa-solid fa-house-chimney {{ ($routeName == 'client.dashboard') ? 'icon-tab' : '' }}"></i>
                <span>Dashboard</span>
            </a>
        </li>

        {{-- Menu Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'menu') ? 'active-tab' : '' }}" href="{{ route('menu') }}">
                <i class="fa-solid fa-bars {{ ($routeName == 'menu') ? 'icon-tab' : '' }}"></i>
                <span>Menu</span>
            </a>
        </li>

    </ul>
</aside>
