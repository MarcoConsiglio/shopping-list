@auth
    <x-nav-link :href="route('shopping_list.index')" :active="request()->routeIs('shopping_list.index')">Le tue liste</x-nav-link>
@endauth
