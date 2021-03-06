<div class="drawer">
	<div class="header">
		<div class="user-info">
        @if(is_null(Auth::user()->img_url))
            <img class="img-circle" src="https://placehold.it/60x60" alt="{!! Auth::user()->name !!}">
        @else
			<img class="img-circle" src="/user/{!! Auth::id() !!}/photo" alt="{!! Auth::user()->name !!}">
        @endif
		</div>
		<div class="user-info">
			<span>{!! Auth::user()->name !!}</span>
			<span>{!! Auth::user()->email !!}</span>
		</div>
	</div>
	<div class="menu">
        @foreach (Config::get('admin.menu') as $group_label=>$items)
            <h4>
                @lang('materialadmin::menu.' . $group_label)
            </h4>
            <ul>
            @foreach ($items as $label=>$attributes)
                @if (IgetMaster\MaterialAdmin\Helper::checkRoutePermission($attributes['route']))
                    <li>
                        <a href="{!! route($attributes['route'], array_key_exists('parameters', $attributes) ? $attributes['parameters'] : null); !!}">
                            <i class="{!! $attributes['icon'] !!}"></i>
                            <span>
                                @lang('materialadmin::menu.' . $label)
                            </span>
                        </a>
                    </li>
                @endif
            @endforeach
            </ul>
        @endforeach
	</div>
</div>