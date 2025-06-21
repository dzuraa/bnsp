<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8" x-data="dashboardData()">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white shadow rounded-lg p-5 text-center border-l-4 border-green-500">
                <h3 class="text-sm font-medium text-gray-500">Total Produk</h3>
                <p class="text-3xl font-bold text-gray-800" x-text="total_products">0</p>
            </div>

            <div class="bg-white shadow rounded-lg p-5 text-center border-l-4 border-blue-500">
                <h3 class="text-sm font-medium text-gray-500">Produk Aktif</h3>
                <p class="text-3xl font-bold text-gray-800" x-text="active_products">0</p>
            </div>

            <div class="bg-white shadow rounded-lg p-5 text-center border-l-4 border-red-500">
                <h3 class="text-sm font-medium text-gray-500">Stok Rendah (&lt; 10)</h3>
                <p class="text-3xl font-bold text-gray-800" x-text="low_stock">0</p>
            </div>
        </div>
    </div>

    <script>
        function dashboardData() {
            return {
                total_products: 0,
                active_products: 0,
                low_stock: 0,

                async init() {
                    try {
                        const response = await fetch('/api/dashboard-stats');
                        const data = await response.json();
                        this.total_products = data.total_products;
                        this.active_products = data.active_products;
                        this.low_stock = data.low_stock;
                    } catch (e) {
                        console.error('Gagal ambil data dashboard:', e);
                    }
                }
            };
        }

        document.addEventListener('alpine:init', () => {
            Alpine.data('dashboardData', dashboardData);
        });
    </script>
</x-app-layout>
