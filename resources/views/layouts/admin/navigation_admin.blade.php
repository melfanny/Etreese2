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
        font-weight: bold;
        color: #884F22;
        text-decoration: none;
        padding: 8px 12px;
        border-radius: 8px;
        transition: background-color 0.2s ease;
        position: relative;
        padding-right: 24px;
    }

    .nav-link.active {
        background-color: #F2D8A7;
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

    .badge-counter {
        position: absolute;
        top: 0;
        right: 0;
        transform: translate(50%, -50%);
        background-color: #884F22;
        color: #fff;
        font-size: 12px;
        font-weight: bold;
        padding: 2px 6px;
        border-radius: 50px;
        min-width: 20px;
        text-align: center;
        line-height: 1;
        pointer-events: none;
        box-shadow: 0 0 2px rgba(0, 0, 0, 0.2);
    }

    .position-relative {
        position: relative;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="top-bar">
    <a href="{{ route('admin.orders') }}"
        class="nav-link position-relative {{ request()->routeIs('admin.orders') ? 'active' : '' }}">ORDERS
        @if(isset($newPaidOrdersCount) && $newPaidOrdersCount > 0)
            <span class="badge-counter">
                {{ $newPaidOrdersCount }}
                <span class="visually-hidden"></span>
            </span>
        @endif
    </a>

    <a href="{{ route('admin.products.products_admin') }}"
        class="nav-link {{ request()->routeIs('admin.products.products_admin') ? 'active' : '' }}">PRODUCTS</a>

    <div class="nav-center">
        <img src="{{ asset('images/logo.png') }}" alt="Etreese Logo">
    </div>
    <div class="nav-right">
        <a href="{{ route('admin.sales') }}"
            class="nav-link {{ request()->routeIs('admin.sales') ? 'active' : '' }}">SALES</a>
        <a href="{{ route('admin.stock') }}"
            class="nav-link position-relative {{ request()->routeIs('admin.stock') ? 'active' : '' }}">STOCK
            @if(isset($lowStockCount) && $lowStockCount > 0)
                <span class="badge-counter">
                    {{ $lowStockCount }}
                    <span class="visually-hidden">low stock items</span>
                </span>
            @endif
        </a>

        @auth
            <div class="icon-wrapper">
                @php
                    $unreadCount = \App\Models\Message::where('user_id', auth()->id())
                        ->where('is_read', false)
                        ->count();
                @endphp
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
                        @php
                            $messages = \App\Models\Message::where('user_id', auth()->id())
                                ->where('is_read', false)
                                ->get();
                        @endphp
                        <x-dropdown-link :href="route('admin.home')"> {{ __('Edit Home') }}
                        </x-dropdown-link>
                        <x-dropdown-link :href="url('/admin/message')"> {{ __('Messages') }}
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