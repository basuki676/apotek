<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromCollection, WithHeadings, WithMapping
{
    // prosespengambilan data yang akan di export exel
    public function collection()
    {
        return Order::with('user')->get();
    }
    // menentukan nama nama colum di exelnya
    public function headings() : array
    {
        return[
            "nama Pembeli", "Pesanan", "Total Harga (+ppn)", "Kasir", "tanggal"
        ];
    }
    // data dari colection (pengambilan dari db) yang akan muncul di exel
    public function map($item) : array
    {
        $pesanan = "";
        foreach($item['medicines'] as $medicine){
            $pesanan .= "(". $medicine ['name_medicine'] . " : qty " . $medicine['qty'] . " : " . number_format($medicine['price_after_qtr'], 0, '.', '.') . ")," ;
        }
        $totalAfterPPN = $item['total_price'] + ($item['total_price'] * 0.1);
        return [
            $item['name_customer'], $pesanan, "Rp. " . number_format($totalAfterPPN, 0, '.', '.'),
            $item['user']['name'] ."(" . $item['user']['email'] . ")",
            Carbon::parse($item['created_at'])->format("d-m-y H:i:s")
        ];
    }
}
