<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use App\Exports\OrderExport;
use Excel;


class OrderController extends Controller
{
    
    public function index()
    {
        // with mengambil function relasi ke pk ke fk atau fk ke pk dengan model isi di petik disamakan dengan nama funtion di modelnya
        $orders = Order::with('user')->simplePaginate(3);
        return view('order.kasir.index', compact('orders'));
    }
    public function data()
    {
        // with mengambil function relasi ke pk ke fk atau fk ke pk dengan model isi di petik disamakan dengan nama funtion di modelnya
        $orders = Order::with('user')->simplePaginate(3);
        return view('order.admin.index', compact('orders'));
    }

    public function create()
    {   
        $medicines = Medicine::all();
        return view('order.kasir.create', compact('medicines'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name_customer' => 'required',
            'medicines' => 'required',
        ]);

        $medicines = array_count_values($request->medicines);
        $dataMedicines = [];
        foreach($medicines as $key => $value){
            $medicine = Medicine::where('id', $key)->first();
            $arrayAssoc = [
                "id" => $key,
                "name_medicine" => $medicine['name'],
                "price" => $medicine['price'],
                "qty" => $value,
                "price_after_qtr" => (int)$value * (int)$medicine['price'],
            ];
            array_push($dataMedicines, $arrayAssoc);
        }
        $totalPrice = 0;
        foreach($dataMedicines as $formatArray){
            $totalPrice += (int)$formatArray['price_after_qtr'];
        }

        $prosesTambahData = Order::create([
            'name_customer' => $request->name_customer,
            'medicines' => $dataMedicines,
            'total_price' => $totalPrice,
            'user_id' => Auth::user()->id,
        ]);
        return redirect()->route('order.struk', $prosesTambahData['id']);
    }

    public function strukPembelian($id)
    {
        $order = Order::where('id', $id)->first();

        return view('order.kasir.struk', compact('order'));
    }

    public function downloadPDF($id)
    {
        $order = Order::where('id', $id)->first()->toArray();
        view()->share('order', $order);

        $pdf = PDF::loadView('order.kasir.download', $order);
        return $pdf->download('bukti Pembelian.pdf');
    }

    public function search(Request $request)
    {
        $searchDate = $request->input('search');
        $orders = Order::whereDate('created_at', $searchDate)->simplePaginate(3);
        return view('order.kasir.index', compact('orders'));
    }

    public function searchAdmin(Request $request)
    {
        $searchDate = $request->input('search');
        $orders = Order::whereDate('created_at', $searchDate)->simplePaginate(3);
        return view('order.admin.index', compact('orders'));
    }

    public function downloadExcel()
    {
        $file_name = 'Data Seluruh Pembelian.xlsx';
        return Excel::download(new OrderExport, $file_name);
    }
    public function show(Order $order)
    {
        //
    }
    public function edit(Order $order)
    {
        //
    }

    public function update(Request $request, Order $order)
    {
        //
    }
    public function destroy(Order $order)
    {
        //
    }
}
