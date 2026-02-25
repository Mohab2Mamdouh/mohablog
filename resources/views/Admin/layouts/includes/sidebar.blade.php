<div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <ul class="list-group list-group-flush">
        <li
        @if (Route::currentRouteName() == 'info.show')
            class="active"
        @endif
        >
            <a href="{{ route('info.show') }}">{{ __('Persenol Info Section') }}</a>
        </li>
        <li
        @if (Route::currentRouteName() == 'skills.show')
            class="active"
        @endif
        >
            <a href="{{ route('skills.show') }}">{{ __('Skills Section') }}</a>
        </li>
        <li
        @if (Route::currentRouteName() == 'showProjects')
            class="active"
        @endif
        >
            <a href="{{ route('projects.show') }}">{{ __('Projects Section') }}</a>
        </li>
        <li
        @if (Route::currentRouteName() == 'showWorks')
            class="active"
        @endif
        >
            <a href="{{ route('works.show') }}">{{ __('Work Expereince Section') }}</a>
        </li>
        <li
        @if (Route::currentRouteName() == 'showLangs')
            class="active"
        @endif
        >
            <a href="{{ route('langs.show') }}">{{ __('Speaking Language Section') }}</a>
        </li>
    </ul>
</div>

