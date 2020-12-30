@auth
    <x-responsive-nav-link :href="route('shopping_list.index')" :active="request()->routeIs('shopping_list.index')">Le tue liste</x-responsive-nav-link>
@endauth
