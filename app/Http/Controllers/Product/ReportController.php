<?php

namespace App\Http\Controllers\Product;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Sanalarni olish (filter uchun)
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        // Agar sanalar berilmagan bo‘lsa, default kun boshidan hozirgacha
        if (!$start) {
            $start = date('Y-m-01'); // oy boshidan
        }
        if (!$end) {
            $end = date('Y-m-d'); // hozirgi kun
        }

        // 1. Har bir mahsulot uchun jami qabul qilingan va sotilgan miqdor
        $products = Product::with(['purchases', 'sales'])->get();

        // Qoldiqni hisoblash (ostatka)
        $products = $products->map(function ($product) use ($start, $end) {
            // Ushbu vaqt oralig‘ida qabul qilingan jami miqdor
            $purchase_qty = $product->purchases()
                ->whereBetween('purchase_date', [$start, $end])
                ->sum('quantity');

            // Ushbu vaqt oralig‘ida sotilgan jami miqdor
            $sale_qty = $product->sales()
                ->whereBetween('sale_date', [$start, $end])
                ->sum('quantity');

            // Ostatka = qabul - sotilgan
            $ostatka = $purchase_qty - $sale_qty;

            // Sotishdan tushgan jami pul
            $total_sales = $product->sales()
                ->whereBetween('sale_date', [$start, $end])
                ->select(DB::raw('SUM(quantity * price_per_unit) as total'))
                ->value('total');

            // Qabul qilinishdan sarflangan jami pul
            $total_purchases = $product->purchases()
                ->whereBetween('purchase_date', [$start, $end])
                ->select(DB::raw('SUM(quantity * price_per_unit) as total'))
                ->value('total');

            return [
                'name' => $product->name,
                'ostatka' => $ostatka,
                'unit' => $product->unit,
                'sold_quantity' => $sale_qty,
                'total_sales' => $total_sales ?? 0,
                'total_purchases' => $total_purchases ?? 0,
            ];
        });

        return view('report.index', compact('products', 'start', 'end'));
    }
}
