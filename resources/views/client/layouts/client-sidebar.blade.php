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
            <a class="nav-link {{ (($routeName != 'design.general-info') && ($routeName != 'design.logo') && ($routeName != 'design.cover') && ($routeName != 'design.banner') && ($routeName != 'design.theme')) ? 'collapsed' : '' }} {{ (($routeName == 'design.general-info') || ($routeName == 'design.logo') || ($routeName == 'design.cover') || ($routeName == 'design.banner') || ($routeName == 'design.theme')) ? 'active-tab' : '' }}" data-bs-target="#design-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ (($routeName == 'design.general-info') || ($routeName == 'design.logo') || ($routeName == 'design.cover') || ($routeName == 'design.banner') || ($routeName == 'design.theme')) ? 'true' : 'false' }}">
                <i class="fa-solid fa-pen-nib {{ (($routeName == 'design.general-info') || ($routeName == 'design.logo') || ($routeName == 'design.cover') || ($routeName == 'design.banner') || ($routeName == 'design.theme')) ? 'icon-tab' : '' }}"></i><span>Design</span><i class="bi bi-chevron-down ms-auto {{ (($routeName == 'design.general-info') || ($routeName == 'design.logo') || ($routeName == 'design.cover') || ($routeName == 'design.banner') || ($routeName == 'design.theme')) ? 'icon-tab' : '' }}"></i>
            </a>
            <ul id="design-nav" class="nav-content sidebar-ul collapse {{ (($routeName == 'design.general-info') || ($routeName == 'design.logo') || ($routeName == 'design.cover') || ($routeName == 'design.banner') || ($routeName == 'design.theme')) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('design.general-info') }}" class="{{ ($routeName == 'design.general-info') ? 'active-link' : '' }}">
                        <span>General Info</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('design.logo') }}" class="{{ ($routeName == 'design.logo') ? 'active-link' : '' }}">
                        <span>Logo</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('design.cover') }}" class="{{ ($routeName == 'design.cover') ? 'active-link' : '' }}">
                        <span>Cover</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('design.banner') }}" class="{{ ($routeName == 'design.banner') ? 'active-link' : '' }}">
                        <span>Banner</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('design.theme') }}" class="{{ ($routeName == 'design.theme') ? 'active-link' : '' }}">
                        <span>Themes</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Menu Nav --}}
        <li class="nav-item">
            {{-- && --}}
            <a class="nav-link {{ (($routeName != 'categories') && ($routeName != 'items') && ($routeName != 'languages') && ($routeName != 'tags')) ? 'collapsed' : '' }} {{ (($routeName == 'categories') || ($routeName == 'items') || ($routeName == 'languages') || ($routeName == 'tags')) ? 'active-tab' : '' }}" data-bs-target="#menu-nav" data-bs-toggle="collapse" href="#" aria-expanded="{{ (($routeName == 'categories') || ($routeName == 'items') || ($routeName == 'languages') || ($routeName == 'tags')) ? 'true' : 'false' }}">
                <i class="fa-solid fa-bars {{ (($routeName == 'categories') || ($routeName == 'items') || ($routeName == 'languages') || ($routeName == 'tags')) ? 'icon-tab' : '' }}"></i><span>Menu</span><i class="bi bi-chevron-down ms-auto {{ (($routeName == 'categories') || ($routeName == 'items') || ($routeName == 'languages') || ($routeName == 'tags')) ? 'icon-tab' : '' }}"></i>
            </a>
            <ul id="menu-nav" class="nav-content sidebar-ul collapse {{ (($routeName == 'categories') || ($routeName == 'items') || ($routeName == 'languages') || ($routeName == 'tags')) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('categories') }}" class="{{ ($routeName == 'categories') ? 'active-link' : '' }}">
                        <span>Categories</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('items') }}" class="{{ ($routeName == 'items') ? 'active-link' : '' }}">
                        <span>Items</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('tags') }}" class="{{ ($routeName == 'tags') ? 'active-link' : '' }}">
                        <span>Tags</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('languages') }}" class="{{ ($routeName == 'languages') ? 'active-link' : '' }}">
                        <span>Languages</span>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Preview Nav --}}
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="modal" data-bs-target="#previewModal" style="cursor: pointer">
                <i class="fa-solid fa-eye"></i>
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
            <a class="nav-link {{ ($routeName == 'statistics') ? 'active-tab' : '' }}" href="{{ route('statistics') }}">
                <i class="fa-solid fa-chart-line {{ ($routeName == 'statistics') ? 'icon-tab' : '' }}"></i>
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
            <a class="nav-link {{ ($routeName == 'contact') ? 'active-tab' : '' }}" href="{{ route('contact') }}">
                <i class="fa-solid fa-address-card {{ ($routeName == 'contact') ? 'icon-tab' : '' }}"></i>
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
