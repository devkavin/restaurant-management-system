<?php

namespace App\Http\Controllers;

use App\Jobs\SendOrderToKitchen;
use App\Models\Concession;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $orders = Order::with(['user', 'concessions'])
                ->select('orders.*')
                ->withSum('concessions as total_cost', DB::raw('concessions.price * order_concession.quantity'))
                ->paginate(10);

            return view('orders.index', compact('orders'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while fetching orders. ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $concessions = Concession::all();
            return view('orders.create', compact('concessions'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while loading concessions. ' . $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     try {
    //         $request->validate([
    //             'concessions' => 'required|array|min:1',
    //             'send_to_kitchen_time' => 'required|date|after:now',
    //             'concessions.*.id' => 'required|exists:concessions,id', // Ensure concession ids are valid
    //             'concessions.*.quantity' => 'required|integer|min:1', // Ensure quantity is valid
    //         ]);

    //         // Create the order
    //         $order = Order::create([
    //             'user_id' => Auth::id(),
    //             'send_to_kitchen_time' => $request->send_to_kitchen_time,
    //             'status' => 'Pending',
    //         ]);

    //         // Group the concessions by their IDs and sum the quantities
    //         $concessions = $request->concessions;
    //         $pivotData = [];

    //         // Loop through the concessions and prepare the pivot data
    //         foreach ($concessions as $concession) {
    //             $concessionId = $concession['id'];
    //             $quantity = $concession['quantity'];

    //             // If the concession already exists in the pivot data, sum the quantities
    //             if (isset($pivotData[$concessionId])) {
    //                 $pivotData[$concessionId]['quantity'] += $quantity;
    //             } else {
    //                 // Otherwise, add a new entry
    //                 $pivotData[$concessionId] = [
    //                     'order_id' => $order->id,
    //                     'concession_id' => $concessionId,
    //                     'quantity' => $quantity,
    //                     'created_at' => now(),
    //                     'updated_at' => now(),
    //                 ];
    //             }
    //         }

    //         // Insert the data in bulk into the pivot table
    //         DB::table('order_concession')->insert(array_values($pivotData));

    //         return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'An error occurred while creating the order. ' . $e->getMessage());
    //     }
    // }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'concessions' => 'required|array|min:1',
                'concessions.*.id' => 'required|exists:concessions,id',
                'concessions.*.quantity' => 'required|integer|min:1',
                'send_to_kitchen_time' => 'required|date|after:now',
            ]);

            $order = Order::create([
                'user_id' => Auth::id(),
                'send_to_kitchen_time' => $request->send_to_kitchen_time,
                'status' => 'Pending',
            ]);

            $concessionsToAttach = [];
            foreach ($request->concessions as $concession) {
                $concessionsToAttach[$concession['id']] = ['quantity' => $concession['quantity']];
            }

            // Bulk attach all concessions
            $order->concessions()->attach($concessionsToAttach);

            $sendToKitchenTime = Carbon::parse($request->send_to_kitchen_time);
            // abs() to ensure the delay is positive
            $delayInSeconds = abs($sendToKitchenTime->diffInSeconds(Carbon::now()));

            SendOrderToKitchen::dispatch($order)->delay(now()->addSeconds($delayInSeconds));

            return redirect()->route('orders.index')->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the order. ' . $e->getMessage());
        }
    }



    public function sendToKitchen(Order $order)
    {
        try {
            if ($order->status === 'Pending') {
                $order->update([
                    'status' => 'In-Progress',
                    'send_to_kitchen_time' => now()
                ]);
                return redirect()->route('orders.index')->with('success', 'Order sent to the kitchen.');
            }

            return redirect()->back()->with('error', 'Order cannot be sent to the kitchen.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred. ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        try {
            $order->delete();
            return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while deleting the order. ' . $e->getMessage());
        }
    }
}
