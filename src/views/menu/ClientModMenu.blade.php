@if (isset($server->name) && isset($node->name))
{{--<li class="header">Games Mods</li>--}}
<li class="{{ ! starts_with(Route::currentRouteName(), 'server.modmanager.index') ?: 'active' }}">
    <a href="{{ route('server.modmanager.index', $server->uuidShort) }}">
        <i class="fa fa-users"></i> <span>Mods</span>
    </a>
</li>
@endif
