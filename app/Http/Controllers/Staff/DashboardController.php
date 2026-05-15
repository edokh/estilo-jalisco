<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $orders = Order::whereIn('status', ['pending', 'preparing', 'ready', 'completed'])
            ->with('items', 'items.foodItem')
            ->orderBy('created_at', 'asc')
            ->get();

        $pendingCount = $orders->where('status', 'pending')->count();
        $preparingCount = $orders->where('status', 'preparing')->count();
        $readyCount = $orders->where('status', 'ready')->count();
        $completedCount = $orders->where('status', 'completed')->count();

        return view('staff.dashboard', compact('orders', 'pendingCount', 'preparingCount', 'readyCount', 'completedCount'));
    }

    public function orders($status = null)
    {
        $statuses = ['pending', 'preparing', 'ready', 'completed'];

        $orders = Order::with('items', 'items.foodItem')
            ->when($status && in_array($status, $statuses), function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        $pendingCount = Order::where('status', 'pending')->count();
        $preparingCount = Order::where('status', 'preparing')->count();
        $readyCount = Order::where('status', 'ready')->count();
        $completedCount = Order::where('status', 'completed')->count();

        return view('staff.orders.index', compact('orders', 'status', 'statuses', 'pendingCount', 'preparingCount', 'readyCount', 'completedCount'));
    }
}
