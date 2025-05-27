<x-app-layout>
    @include('components.checkout.function', ['carts' => $carts])
    @include('layouts.footer')
</x-app-layout>