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

    // ShopName
    $shop_name = isset(Auth::user()->hasOneShop->shop['name']) ? Auth::user()->hasOneShop->shop['name'] : '';

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
        {{-- <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'client.dashboard') ? 'active-tab' : '' }}" href="{{ route('client.dashboard') }}">
                <i class="fa-solid fa-house-chimney {{ ($routeName == 'client.dashboard') ? 'icon-tab' : '' }}"></i>
                <span>Dashboard</span>
            </a>
        </li> --}}

        {{-- Shop Details Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ (($routeName != 'client.profile')) ? 'collapsed' : '' }} {{ (($routeName == 'client.profile')) ? 'active-tab' : '' }}" data-bs-target="#shop-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ (($routeName == 'client.profile')) ? 'true' : 'false' }}">
                <i class="fa-solid fa-house-chimney {{ (($routeName == 'client.profile')) ? 'icon-tab' : '' }}"></i><span>{{ $shop_name }}</span><i class="bi bi-chevron-down ms-auto {{ (($routeName == 'client.profile')) ? 'icon-tab' : '' }}"></i>
            </a>
            <ul id="shop-nav" class="nav-content sidebar-ul collapse  {{ (($routeName == 'client.profile')) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('client.profile',$userID) }}" class="{{ ($routeName == 'client.profile') ? 'active-link' : '' }}">
                        <span>Manage Account</span>
                    </a>
                </li>
                <li>
                    <a href="" class="">
                        <span>Billing Info</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Design Nav --}}
        <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#design-nav" data-bs-toggle="collapse" href="#" aria-expanded="">
                <i class="fa-solid fa-pen-nib "></i><span>Design</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="design-nav" class="nav-content sidebar-ul collapse" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('design.general-info') }}" class="">
                        <span>General Info</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('design.logo') }}" class="">
                        <span>Logo</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('design.cover') }}" class="">
                        <span>Cover</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('design.banner') }}" class="">
                        <span>Banner</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('design.theme') }}" class="">
                        <span>Theme</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Menu Nav --}}
        <li class="nav-item">
            {{-- && --}}
            <a class="nav-link {{ (($routeName != 'categories')) ? 'collapsed' : '' }} {{ (($routeName == 'categories')) ? 'active-tab' : '' }}" data-bs-target="#menu-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ (($routeName == 'categories')) ? 'true' : 'false' }}">
                <i class="fa-solid fa-bars {{ (($routeName == 'categories')) ? 'icon-tab' : '' }}"></i><span>Menu</span><i class="bi bi-chevron-down ms-auto {{ (($routeName == 'categories')) ? 'icon-tab' : '' }}"></i>
            </a>
            <ul id="menu-nav" class="nav-content sidebar-ul collapse {{ (($routeName == 'categories')) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('categories') }}" class="{{ ($routeName == 'categories') ? 'active-link' : '' }}">
                        <span>Categories</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('items') }}" class="">
                        <span>Items</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('languages') }}" class="">
                        <span>Languages</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Preview Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ ($routeName == '') ? 'active-tab' : '' }}" href="">
                <i class="fa-solid fa-eye {{ ($routeName == '') ? 'icon-tab' : '' }}"></i>
                <span>Prview</span>
            </a>
        </li>

        {{-- QrCode Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'qrcode') ? 'active-tab' : '' }}" href="{{ route('qrcode') }}">
                <i class="fa-solid fa-qrcode {{ ($routeName == 'qrcode') ? 'icon-tab' : '' }}"></i>
            <span>Get QR Code</span>
            </a>
        </li>

        {{-- Statistics Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ ($routeName == '') ? 'active-tab' : '' }}" href="">
                <i class="fa-solid fa-chart-line {{ ($routeName == '') ? 'icon-tab' : '' }}"></i>
            <span>Statistics</span>
            </a>
        </li>

        {{-- Tutorial Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ ($routeName == '') ? 'active-tab' : '' }}" href="">
                <i class="fa-solid fa-circle-info {{ ($routeName == '') ? 'icon-tab' : '' }}"></i>
            <span>Tutorial</span>
            </a>
        </li>

        {{-- Contact Nav --}}
        <li class="nav-item">
            <a class="nav-link {{ ($routeName == '') ? 'active-tab' : '' }}" href="">
                <i class="fa-solid fa-address-card {{ ($routeName == '') ? 'icon-tab' : '' }}"></i>
            <span>Contact</span>
            </a>
        </li>

        {{-- Logout Nav --}}
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}">
                <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
            </a>
        </li>

        {{-- Design Nav --}}
        {{-- <li class="nav-item">
            <a class="nav-link {{ ($routeName == 'menu') ? 'active-tab' : '' }}" href="{{ route('menu') }}">
                <i class="fa-solid fa-pen-nib {{ ($routeName == 'menu') ? 'icon-tab' : '' }}"></i>
                <span>Design</span>
            </a>
        </li> --}}

    </ul>
</aside>
