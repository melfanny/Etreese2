<x-app-layout>
    @include('components.home.banner')
    @include('components.home.upcoming')
    @include('components.home.what')
    @include('components.home.bestseller', ['products' => $products])
    @include('layouts.footer')
</x-app-layout>