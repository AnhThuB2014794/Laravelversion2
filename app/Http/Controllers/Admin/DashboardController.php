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
        $orderComplete  = DB::table('orders')
        ->where('status', 'Xác nhận')
        ->count();
        //hiện thống kê lợi nhuận 
        $selectedMonth = $request->input('selected_month', now()->month);
      
        $totalImport = DB::table('import_materials')
        ->whereMonth('import_materials.import_date', $selectedMonth)
        ->sum(DB::raw('import_materials.import_quantity * import_price'));
       
        
        $totalOrderPrice = DB::table('product_orders')
        ->join('orders', 'product_orders.order_id', '=', 'orders.id')
        ->where('orders.status', 'Xác nhận')
        ->whereMonth('orders.created_at', $selectedMonth)
        ->sum(DB::raw('product_orders.product_quantity * product_orders.product_price'));
       
        //hiện doanh thu theo hóa đơn
        $startDate = $request->input('start_date', now()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));
        $statisticData = Order::selectRaw('DATE(created_at) as date, COUNT(*) as order_count, SUM(total) as total_revenue')
        ->where('status', 'Xác nhận')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();
        $totalRevenue = DB::table('orders')
            ->where('status', 'Xác nhận')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total');
        $totalOrder = DB::table('orders')
        ->where('status', 'Xác nhận')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();
        return view('admin.dashboard.index', compact('userCount', 'categoryCount', 'productCount', 'orderCount', 'couponCount', 'roleCount','orderComplete','startDate','endDate','statisticData','totalRevenue', 'totalOrder', 'selectedMonth', 'totalImport', 'totalOrderPrice'));
    }
}