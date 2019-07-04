<li class="header">Games Mods</li>
<li class="{{ ! starts_with(Route::currentRouteName(), 'mod.index') ?: 'active' }}">
    <a href="{{ route('mod.index') }}">
        <i class="fa fa-users"></i> <span>Mods</span>
    </a>
</li>
<li class="{{ ! starts_with(Route::currentRouteName(), 'category.index') ? : 'active' }}">
    <a href="{{ route('category.index') }}">
        <i class="fa fa-server"></i> <span>Mods Category</span>
    </a>
</li>
