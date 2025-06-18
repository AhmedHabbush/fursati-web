<nav class="bg-white border-b border-gray-200 shadow">
    <div class="container mx-auto flex items-center justify-between px-4 py-3">

        {{-- الشعار / الاسم --}}
        <div>
            <a href="{{ route('jobs.index') }}" class="text-xl font-bold text-teal-600 hover:text-teal-700">
                {{ config('app.name', 'Fursati') }}
            </a>
        </div>

        {{-- روابط التنقل الرئيسية --}}
        <div class="hidden md:flex space-x-7">
            <x-nav-link :href="route('jobs.index')" :active="request()->routeIs('jobs.index')">
                وظائف
            </x-nav-link>
            <x-nav-link :href="route('bookmarks.index')" :active="request()->routeIs('bookmarks.*')">
                المحفوظات
            </x-nav-link>
            <x-nav-link :href="route('settings.index')" :active="request()->routeIs('settings.*')">
                الإعدادات
            </x-nav-link>
        </div>

        {{-- Authentication Links --}}
        <div class="hidden md:flex items-center space-x-4">
            @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-2 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                             onclick="event.preventDefault(); this.closest('form').submit();">
                                تسجيل خروج
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            @endauth

            @guest
                <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                    تسجيل دخول
                </x-nav-link>
                @if(Route::has('register'))
                    <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                        إنشاء حساب
                    </x-nav-link>
                @endif
            @endguest
        </div>

        {{-- زر القائمة للـ mobile --}}
        <div class="md:hidden">
            <button @click="open = ! open" class="text-gray-500 focus:outline-none">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': ! open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16M4 18h16"/>
                    <path :class="{'hidden': ! open, 'inline-flex': open }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Responsive Menu --}}
    <div x-data="{open:false}" :class="open ? 'block' : 'hidden'" class="md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('jobs.index')" :active="request()->routeIs('jobs.index')">
                وظائف
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('bookmarks.index')" :active="request()->routeIs('bookmarks.*')">
                المحفوظات
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('settings.index')" :active="request()->routeIs('settings.*')">
                الإعدادات
            </x-responsive-nav-link>
        </div>

        {{-- Authenticated --}}
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 px-2 space-y-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault(); this.closest('form').submit();">
                            تسجيل خروج
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth

        {{-- Guests --}}
        @guest
            <div class="pt-4 pb-1 border-t border-gray-200 px-2 space-y-1">
                <x-responsive-nav-link :href="route('login')" :active="request()->routeIs('login')">
                    تسجيل دخول
                </x-responsive-nav-link>
                @if(Route::has('register'))
                    <x-responsive-nav-link :href="route('register')" :active="request()->routeIs('register')">
                        إنشاء حساب
                    </x-responsive-nav-link>
                @endif
            </div>
        @endguest
    </div>
</nav>
