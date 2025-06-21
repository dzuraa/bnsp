<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-2">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Daftar Produk') }}
            </h2>

            <div class="flex flex-col md:flex-row md:items-center gap-2">
                <form method="GET" action="{{ route('products.index') }}" class="flex items-center gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="border border-gray-300 rounded px-3 py-1 text-sm"
                        placeholder="Cari produk...">
                    <button type="submit" class="px-3 py-1 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700">
                        Cari
                    </button>
                </form>

                <a href="{{ route('products.create') }}"
                    class="inline-block px-3 py-1 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700">
                    + Tambah Produk
                </a>

                <a href="{{ route('products.export') }}"
                    class="inline-block px-3 py-1 bg-green-600 text-white text-sm font-medium rounded hover:bg-green-700">
                    Export Excel
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 px-4 sm:px-6 lg:px-8">
        @if(session('success'))
            <div class="mb-4 p-4 text-green-700 bg-green-100 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white overflow-x-auto shadow sm:rounded-lg p-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <x-table-header field="id" label="No" />
                        <x-table-header field="product_image" label="Gambar" :sortable="false" />
                        <x-table-header field="product_name" label="Nama Produk" />
                        <x-table-header field="price" label="Harga" />
                        <x-table-header field="stock" label="Stok" />
                        <x-table-header field="status" label="Status" />
                        <x-table-header field="aksi" label="Aksi" :sortable="false" />
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($products as $index => $product)
                    <tr>
                        <td>
                            @php
                                $direction = request('direction', 'desc');
                                $no = $direction === 'asc'
                                    ? $products->firstItem() + $index
                                    : $products->total() - $products->firstItem() - $index + 1;
                            @endphp
                            {{ $no }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex-shrink-0 h-16 w-16">
                                @if($product->product_image && file_exists(public_path('storage/' . $product->product_image)))
                                    <img class="h-16 w-16 rounded-lg object-cover shadow-sm border border-gray-200"
                                         src="{{ asset('storage/' . $product->product_image) }}"
                                         alt="{{ $product->product_name }}"
                                         onerror="this.src='{{ asset('images/no-image.png') }}'; this.onerror=null;">
                                @else
                                    <div class="h-16 w-16 rounded-lg bg-gray-100 flex items-center justify-center border border-gray-200">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $product->product_name }}</div>
                            @if($product->description)
                                <div class="text-sm text-gray-500 truncate max-w-xs">{{ Str::limit($product->description, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">Rp{{ number_format($product->price, 2, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $product->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @switch($product->status)
                                    @case('Active')
                                        bg-green-100 text-green-800
                                        @break
                                    @case('Draft')
                                        bg-gray-100 text-gray-800
                                        @break
                                    @case('Inactive')
                                        bg-yellow-100 text-yellow-800
                                        @break
                                    @default
                                        bg-gray-100 text-gray-800
                                @endswitch">
                                {{ $product->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('products.show', $product->id) }}"
                                   class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-2 py-1 rounded text-xs">
                                    Lihat
                                </a>
                                <a href="{{ route('products.edit', $product->id) }}"
                                   class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-2 py-1 rounded text-xs">
                                    Edit
                                </a>
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Yakin ingin menghapus produk ini?')"
                                            class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-2 py-1 rounded text-xs">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($products->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada produk</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan produk baru.</p>
                    <div class="mt-6">
                        <a href="{{ route('products.create') }}"
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            + Tambah Produk Pertama
                        </a>
                    </div>
                </div>
            @endif

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
