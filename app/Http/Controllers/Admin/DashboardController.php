<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    protected $user;
    protected $category;
    protected $order;
    protected $product;
    protected $coupon;
    protected $role;

    public function __construct(User $user, Category $category, Order $order, Product $product, Coupon $coupon, Role $role)
    {
        $this->user = $user;
        $this->category = $category;
        $this->order = $order;
        $this->product = $product;
        $this->coupon = $coupon;
        $this->role = $role;
    }

    public function index(Request $request)
    {

        $userCount = $this->user->count();
        $categoryCount = $this->category->count();
        $orderCount = $this->order->count();
        $productCount = $this->product->count();
        $couponCount = $this->coupon->count();
        $roleCount = $this->role->count();

        //hiện thống kê lợi nhuận 
        $selectedMonth = $request->input('selected_month', now()->month);
        // $totalInputCost = DB::table('import_materials')
        // ->join('materials', 'import_materials.material_id', '=', 'materials.id')
        // ->whereMonth('import_materials.import_date', $selectedMonth)
        // ->sum(DB::raw('import_materials.quantity_entered * materials.price'));
        // $totalExportCost = DB::table('export_materials')
        // ->join('materials', 'export_materials.material_id', '=', 'materials.id')
        // ->whereMonth('export_materials.export_date', $selectedMonth)
        // ->sum(DB::raw('export_materials.export_quantity * materials.price'));
        $totalImport = DB::table('import_materials')
        ->whereMonth('import_materials.import_date', $selectedMonth)
        ->sum(DB::raw('import_materials.import_quantity * import_price'));
        $totalOrderPrice = DB::table('orders')
        ->whereMonth('updated_at', $selectedMonth)
        ->sum('total');
        // $monthlyRevenue = DB::table('orders')
        // ->whereMonth('created_at', $selectedMonth)
        // ->sum('total');
        //hiện doanh thu theo hóa đơn
        $startDate = $request->input('start_date', now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $statisticData = Order::selectRaw('DATE(created_at) as date, COUNT(*) as order_count, SUM(total) as total_revenue')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        $totalRevenue = DB::table('orders')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total');
        $totalOrder = DB::table('orders')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        return view('admin.dashboard.index', compact('userCount', 'categoryCount', 'productCount', 'orderCount', 'couponCount', 'roleCount','startDate','endDate','statisticData','totalRevenue', 'totalOrder', 'selectedMonth', 'totalImport', 'totalOrderPrice'));
    }
}