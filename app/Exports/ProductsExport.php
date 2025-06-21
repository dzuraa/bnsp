<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductsExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        $products = Product::all();

        return $products->values()->map(function ($product, $index) {
            return [
                'No' => $index + 1,
                'Product Name' => $product->product_name,
                'Description' => $product->description,
                'Price' => number_format($product->price, 2, ',', '.'),
                'Stock' => $product->stock,
                'Status' => $product->status,
                'Created At' => \Carbon\Carbon::parse($product->created_at)->format('d-m-y'),
                'Updated At' => \Carbon\Carbon::parse($product->updated_at)->format('d-m-y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Produk',
            'Deskripsi',
            'Harga',
            'Stok',
            'Status',
            'Dibuat pada',
            'Diperbarui pada',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Count the number of rows in the collection
        $rowCount = $this->collection()->count() + 1; // +1 untuk header
        $range = 'A1:H' . $rowCount;

        // Add borders to the entire range
        $sheet->getStyle($range)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        // Bold the header row
        $sheet->getStyle('A1:H1')->getFont()->setBold(true);

        return [];
    }
}
