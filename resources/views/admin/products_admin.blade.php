<style>

</style>
@extends('layouts.app_admin')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold mb-6 text-center">ADMIN</h1>

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">PRODUCTS</h2>
            <a href="#" class="bg-[#a9582b] text-white px-4 py-2 rounded-full flex items-center">
                <i class="fas fa-plus mr-2"></i> Add New
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <!-- Product Card 1 -->
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <img src="https://contents.mediadecathlon.com/p2157319/k$45a8143f29ae498e05be9c1588d95135/kaos-running-dry-fit-baju-lari-pria-breathable-hitam-decathlon-8488034.jpg?f=1920x0&format=auto"
                    alt="Ethereal Bloom Black" class="w-full h-60 object-cover rounded">
                <p class="mt-3 font-semibold text-lg">Ethereal Bloom</p>
                <div class="flex justify-center mt-2 gap-2">
                    <a href="#" class="bg-[#a9582b] text-white px-3 py-1 rounded"><i class="fas fa-edit mr-1"></i>Edit</a>
                    <button class="bg-[#a9582b] text-white px-3 py-1 rounded"><i
                            class="fas fa-trash mr-1"></i>Delete</button>
                </div>
            </div>

            <!-- Product Card 2 -->
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <img src="https://contents.mediadecathlon.com/p2157319/k$45a8143f29ae498e05be9c1588d95135/kaos-running-dry-fit-baju-lari-pria-breathable-hitam-decathlon-8488034.jpg?f=1920x0&format=auto"
                    alt="Ethereal Bloom Black" alt="Blooming Serenity White" class="w-full h-60 object-cover rounded">
                <p class="mt-3 font-semibold text-lg">Blooming Serenity</p>
                <div class="flex justify-center mt-2 gap-2">
                    <a href="#" class="bg-[#a9582b] text-white px-3 py-1 rounded"><i class="fas fa-edit mr-1"></i>Edit</a>
                    <button class="bg-[#a9582b] text-white px-3 py-1 rounded"><i
                            class="fas fa-trash mr-1"></i>Delete</button>
                </div>
            </div>

            <!-- Product Card 3 -->
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <img src="https://contents.mediadecathlon.com/p2157319/k$45a8143f29ae498e05be9c1588d95135/kaos-running-dry-fit-baju-lari-pria-breathable-hitam-decathlon-8488034.jpg?f=1920x0&format=auto"
                    alt="Ethereal Bloom Black" alt="Ethereal Bloom Black" class="w-full h-60 object-cover rounded">
                <p class="mt-3 font-semibold text-lg">Ethereal Bloom</p>
                <div class="flex justify-center mt-2 gap-2">
                    <a href="#" class="bg-[#a9582b] text-white px-3 py-1 rounded"><i class="fas fa-edit mr-1"></i>Edit</a>
                    <button class="bg-[#a9582b] text-white px-3 py-1 rounded"><i
                            class="fas fa-trash mr-1"></i>Delete</button>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
@endsection