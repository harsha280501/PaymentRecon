<nav class="sidebar sidebar-offcanvas active" id="sidebar">
    <ul class="nav">
        <li><a class="mobilelogo" href="{{ url('/') }}/"><img src="{{ asset('assets/images/logo.jpg') }}" alt="logo" /></a>
        </li>

        @foreach ($menus as $menu)
        @if (isset($menu) && isset($menu['menu']) && ($menu['menu']['menuName'] != 'LogOut' || $menu['menu']['menuName'] != 'Logout'))
        @if ($menu['menu']['parentMenu'] == 0)
        @if (!empty($menu['subMenus']))

        @php

        $activeArray = collect([$menu['menu'], ...$menu['subMenus']])->filter(function($item) {
        // checking if the menu has the submenu which is active
        return url()->current() == (url('/') . $item['menuURL']);
        });
        // checking for the active sub menu
        $isActiveStats = $activeArray->count() !== 0;
        @endphp

        <li class="nav-item @if($isActiveStats) active @endif">
            <a class="nav-link" data-toggle="tooltip" href="{{ url('/') . $menu['menu']['menuURL'] }}" aria-expanded="false" aria-controls="ui-basic">
                <span class="icon-bg"><i class="{{ $menu['menu']['menuIcon'] }} menu-icon" aria-hidden="true"></i></span>
                <span class="menu-title">{{ $menu['menu']['menuTitle'] }}</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" style="width: fit-content !important">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="{{ url('/') . $menu['menu']['menuURL'] }}">{{ $menu['menu']['menuTitle'] }}</a>
                    </li>

                    @foreach ($menu['subMenus'] as $submenu)
                    <li class="nav-item"> <a class="nav-link" href="{{ url('/') . $submenu['menuURL'] }}">{{ $submenu['menuName'] }}</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </li>
        @else
        <li class="nav-item  @if(url()->current() ==  (url('/') . $menu['menu']['menuURL'])) active @endif">
            <a class="nav-link" href="{{ url('/') . $menu['menu']['menuURL'] }}" data-toggle="tooltip" title="{{ $menu['menu']['menuTitle'] }}">
                <span class="icon-bg"><i class="{{ $menu['menu']['menuIcon'] }} menu-icon"></i></span>
                <span class="menu-title">{{ $menu['menu']['menuTitle'] }}</span>
            </a>
        </li>
        @endif
        @endif
        @endif
        @endforeach
    </ul>
</nav>
