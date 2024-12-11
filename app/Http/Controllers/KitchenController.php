<?php

namespace App\Http\Controllers;

use App\Models\Kitchen;
use App\Models\Order;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $orders = Order::with('concessions')
                ->where('status', 'In-Progress')
                ->orderBy('send_to_kitchen_time', 'asc')
                ->paginate(10);

            return view('kitchen.orders.index', compact('orders'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching orders. ' . $e->getMessage());
        }
    }

    public function dashboard()
    {
        try {
            // to minimize db queries
            $orderCounts = Order::selectRaw('
                sum(case when status = "Pending" then 1 else 0 end) as pendingOrders,
                sum(case when status = "In-Progress" then 1 else 0 end) as inProgressOrders,
                sum(case when status = "Completed" then 1 else 0 end) as completedOrders,
                sum(case when status = "Cancelled" then 1 else 0 end) as cancelledOrders
            ')->first();

            $recentOrders = Order::with('concessions')->orderBy('created_at', 'desc')->take(5)->get();

            return view('kitchen.dashboard', [
                'pendingOrders' => $orderCounts->pendingOrders,
                'inProgressOrders' => $orderCounts->inProgressOrders,
                'completedOrders' => $orderCounts->completedOrders,
                'cancelledOrders' => $orderCounts->cancelledOrders,
                'recentOrders' => $recentOrders
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while loading the dashboard. ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Kitchen $kitchen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kitchen $kitchen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        try {
            $request->validate([
                'status' => 'required|in:Completed,Cancelled',
            ]);

            $order->update(['status' => $request->status]);

            return redirect()->route('kitchen.orders.index')->with('success', 'Order updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while updating the order. ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kitchen $kitchen)
    {
        //
    }
}
