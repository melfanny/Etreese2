<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
    }

    .container {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .top-bar {
        width: 100%;
        height: 144px;
        background: #FFFBEF;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-left: 20%;
        padding-right: 20%;
        box-sizing: border-box;
    }

    .nav-left,
    .nav-right {
        display: flex;
        align-items: center;
        gap: 30px;
        font-size: 18px;
    }

    .nav-center {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .nav-center img {
        height: 100px;
        width: auto;
        object-fit: contain;
    }

    .nav-link {
        position: relative;
        font-weight: bold;
        color: #884F22;
        text-decoration: none;
        padding: 8px 12px;
        border-radius: 8px;
        transition: background-color 0.2s ease;
    }

    .nav-link.active {
        background-color: #F2D8A7;
    }


    .nav-link.position-relative.d-inline-block {
        padding: 5px;
    }

    .icons {
        font-size: 20px;
        color: #000;
        cursor: pointer;
    }

    .icon-wrapper {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .nav-link i.fas.fa-bell {
        display: block;
    }

    .notif-badge-counter {
        position: absolute;
        top: -6px;
        right: -6px;
        background-color: #884F22;
        color: white;
        border-radius: 50%;
        padding: 3px 7px;
        font-size: 12px;
        font-weight: bold;
        line-height: 1;
        user-select: none;
    }

    /* Responsive styles */
    @media (max-width: 1024px) {
        .top-bar {
            padding-left: 10%;
            padding-right: 10%;
            height: 120px;
        }

        .nav-left,
        .nav-right {
            gap: 20px;
            font-size: 16px;
        }

        .nav-center img {
            height: 80px;
        }
    }

    @media (max-width: 768px) {
        .top-bar {
            flex-wrap: wrap;
            height: auto;
            padding-left: 5%;
            padding-right: 5%;
            justify-content: center;
            gap: 10px;
        }

        .nav-left,
        .nav-right {
            width: 100%;
            justify-content: center;
            gap: 15px;
            font-size: 14px;
            order: 2;
        }

        .nav-center {
            width: 100%;
            order: 1;
            margin-bottom: 10px;
        }

        .nav-center img {
            height: 70px;
        }

        .nav-link {
            padding: 6px 10px;
            font-size: 14px;
        }

        .icon-wrapper {
            gap: 10px;
        }

        .badge-counter {
            font-size: 10px;
            min-width: 16px;
            padding: 1px 4px;
        }
    }

    @media (max-width: 480px) {

        .nav-left,
        .nav-right {
            gap: 10px;
            font-size: 12px;
        }

        .nav-link {
            padding: 4px 8px;
            font-size: 12px;
        }

        .nav-center img {
            height: 60px;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="top-bar">
    <div class="nav-left">
        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">HOME</a>
        <a href="{{ route('products') }}"
            class="nav-link {{ request()->routeIs('products') ? 'active' : '' }}">PRODUCTS</a>
    </div>

    <div class="nav-center">
        <img src="{{ asset('images/logo.png') }}" alt="Etreese Logo">
    </div>
    <div class="nav-right">
        <a href="{{ route('cart.index') }}"
            class="nav-link {{ request()->routeIs('cart.index') ? 'active' : '' }}">CART</a>
        <a href="{{ route('aboutus') }}" class="nav-link {{ request()->routeIs('aboutus') ? 'active' : '' }}">ABOUT
            US</a>
        @php
            $unreadCount = \App\Models\Notification::where('user_id', auth()->id())
                ->where('is_read', false)
                ->count();
        @endphp

        <a href="{{ route('notifications.index') }}" class="nav-link">
            <i class="fas fa-bell"></i>
            @if($unreadCount > 0)
                <span class="notif-badge-counter">{{ $unreadCount }}</span>
            @endif
        </a>


        @auth
            <div class="icon-wrapper">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('addresses.index')">
                            {{ __('Address') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="route('order.myorders')">
                            {{ __('Order Status') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}">LOGIN</a>
        @endguest
    </div>


</div>