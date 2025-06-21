<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Produk: {{ $product->product_name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium">Nama Produk:</label>
                        <p class="text-gray-900">{{ $product->product_name }}</p>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium">Harga:</label>
                        <p class="text-gray-900">
                            Rp {{ number_format($product->price, 2, ',', '.') }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium">Deskripsi:</label>
                        <p class="text-gray-900">{{ $product->description }}</p>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium">Stok:</label>
                        <p class="text-gray-900">{{ $product->stock }}</p>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium">Status:</label>
                        <p class="text-gray-900">{{ ucfirst($product->status) }}</p>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium">Dibuat Pada:</label>
                        <p class="text-gray-900">
                            {{ \Carbon\Carbon::parse($product->created_at)->format('d-m-Y H:i') }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium">Diperbarui Pada:</label>
                        <p class="text-gray-900">
                            {{ \Carbon\Carbon::parse($product->updated_at)->format('d-m-Y H:i') }}
                        </p>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('products.index') }}"
                       class="inline-flex items-center px-4 py-2 bg-gray-700 border border-transparent rounded-md font-semibold text-white hover:bg-gray-800">
                        Kembali
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
