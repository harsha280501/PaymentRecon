{{-- {{ dd($tabs) }} --}}
<div class="d-sm-flex justify-content-between align-items-center transaparent-tab-border pt-3">
    <ul class="nav nav-tabs tab-transparent" role="tablist">

        @if(!is_null($tabs['parent']))

        <li class="nav-item">
            <a class="nav-link " id="home-tab" href="{{ url('/') . $tabs['parent']->menuURL }}" role="tab" aria-selected="true">{{ $tabs['parent']->menuName }}</a>
        </li>

        @foreach ($tabs['siblings'] as $submenu)

        <li class="nav-item">
            <a class="nav-link @if($tabs['url'] == $submenu['menuURL']) active @endif" id="home-tab" href="{{ url('/') . $submenu['menuURL'] }}" role="tab" aria-selected="true">{{ $submenu['menuName'] }}</a>
        </li>

        @endforeach

        @else

        <li class="nav-item">
            <a class="nav-link active" id="home-tab" href="{{ url('/') . $tabs['menu']->menuURL }}" role="tab" aria-selected="true">@if($tabs['menu']->menuName === "Repository") Mail @endif{{ $tabs['menu']->menuName }}</a>
        </li>



        @foreach ($tabs['subMenus'] as $submenu)

        <li class="nav-item">
            <a class="nav-link " id="home-tab" href="{{ url('/') . $submenu['menuURL'] }}" role="tab" aria-selected="true">{{ $submenu['menuName'] }}</a>
        </li>

        @endforeach
        @endif

    </ul>
    <div class="d-md-block">
    </div>
</div>
