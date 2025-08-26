<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function sales(Request $request)
    {
        // 1. แก้ไข: นับ Order ที่มีสถานะ 2, 3, หรือ 5
        $query = Order::whereIn('order_status_id', [2, 3, 5]);
        
        $reportType = 'รายงานการขาย ประจำวันนี้';
        $chartLabels = [];
        $chartData = [];

        $thaiMonths = [
            1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน',
            5 => 'พฤษภาคม', 6 => 'มิถุนายน', 7 => 'กรกฎาคม', 8 => 'สิงหาคม',
            9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
        ];
        $thaiShortMonths = [
            1 => 'ม.ค.', 2 => 'ก.พ.', 3 => 'มี.ค.', 4 => 'เม.ย.',
            5 => 'พ.ค.', 6 => 'มิ.ย.', 7 => 'ก.ค.', 8 => 'ส.ค.',
            9 => 'ก.ย.', 10 => 'ต.ค.', 11 => 'พ.ย.', 12 => 'ธ.ค.'
        ];

        if ($request->filled('daily_date')) {
            $query->whereDate('order_datetime', $request->daily_date);
            $reportType = 'รายงานการขาย ประจำวัน ' . Carbon::parse($request->daily_date)->format('d/m/Y'); // 2. แก้ไข: แสดงปีเป็น ค.ศ.

            $salesByHour = (clone $query)
                ->select(DB::raw('EXTRACT(HOUR FROM order_datetime) as hour'), DB::raw('SUM(net_price) as total'))
                ->groupBy('hour')->pluck('total', 'hour')->all();
            for ($i = 0; $i < 24; $i++) {
                $chartLabels[] = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';
                $chartData[] = $salesByHour[$i] ?? 0;
            }

        } elseif ($request->filled('monthly_month') && $request->filled('monthly_year')) {
            $month = $request->monthly_month;
            $year = $request->monthly_year;
            $query->whereMonth('order_datetime', $month)->whereYear('order_datetime', $year);
            $reportType = 'รายงานการขาย ประจำเดือน ' . $thaiMonths[$month] . ' ' . $year; // 2. แก้ไข: แสดงปีเป็น ค.ศ.

            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
            $salesByDay = (clone $query)
                ->select(DB::raw('EXTRACT(DAY FROM order_datetime) as day'), DB::raw('SUM(net_price) as total'))
                ->groupBy('day')->pluck('total', 'day')->all();
            for ($i = 1; $i <= $daysInMonth; $i++) {
                $chartLabels[] = $i;
                $chartData[] = $salesByDay[$i] ?? 0;
            }

        } elseif ($request->filled('yearly_year')) {
            $year = $request->yearly_year;
            $query->whereYear('order_datetime', $year);
            $reportType = 'รายงานการขาย ประจำปี ' . $year; // 2. แก้ไข: แสดงปีเป็น ค.ศ.

            $salesByMonth = (clone $query)
                ->select(DB::raw('EXTRACT(MONTH FROM order_datetime) as month'), DB::raw('SUM(net_price) as total'))
                ->groupBy('month')->pluck('total', 'month')->all();
            for ($i = 1; $i <= 12; $i++) {
                $chartLabels[] = $thaiShortMonths[$i];
                $chartData[] = $salesByMonth[$i] ?? 0;
            }

        } else {
            return redirect()->to(route('admin.reports.sales', ['daily_date' => today()->format('Y-m-d')]));
        }
        
        $orders = $query->get();
        $orderIds = $orders->pluck('id');
        $totalRevenue = $orders->sum('net_price');
        $totalOrders = $orders->count();
        $salesDetails = OrderDetail::whereIn('order_id', $orderIds)
            ->with('product')
            ->select('product_id', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(total_price) as total_revenue'))
            ->groupBy('product_id')->orderBy('total_quantity', 'desc')->get();
            
        return view('admin.reports.sales', compact(
            'reportType', 'totalRevenue', 'totalOrders', 'salesDetails',
            'chartLabels', 'chartData'
        ));
    }

    public function topProducts(Request $request)
    {
        $selectedMonth = $request->input('month', Carbon::now()->month);
        $selectedYear = $request->input('year', Carbon::now()->year);

        $thaiMonths = [
            1 => 'มกราคม', 2 => 'กุมภาพันธ์', 3 => 'มีนาคม', 4 => 'เมษายน',
            5 => 'พฤษภาคม', 6 => 'มิถุนายน', 7 => 'กรกฎาคม', 8 => 'สิงหาคม',
            9 => 'กันยายน', 10 => 'ตุลาคม', 11 => 'พฤศจิกายน', 12 => 'ธันวาคม'
        ];
        $monthName = $thaiMonths[$selectedMonth];
        
        $topProducts = OrderDetail::join('orders', 'order_details.order_id', '=', 'orders.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            // 1. แก้ไข: นับ Order ที่มีสถานะ 2, 3, หรือ 5
            ->whereIn('orders.order_status_id', [2, 3, 5])
            ->whereMonth('orders.order_datetime', $selectedMonth)
            ->whereYear('orders.order_datetime', $selectedYear)
            ->select('products.product_name', DB::raw('SUM(order_details.quantity) as total_quantity_sold'))
            ->groupBy('products.id', 'products.product_name')
            ->orderByDesc('total_quantity_sold')
            ->limit(5)
            ->get();
            
        return view('admin.reports.top_products', [
            'topProducts' => $topProducts,
            'reportMonth' => $monthName,
            'reportYear' => $selectedYear, // 2. แก้ไข: กลับไปแสดงปีเป็น ค.ศ.
            'selectedMonth' => $selectedMonth,
        ]);
    }
}