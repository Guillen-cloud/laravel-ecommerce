<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with('user')
            ->orderBy('last_name')
            ->paginate(20);

        return view('admin.customers.index', compact('customers'));
    }

    public function show(Customer $customer)
    {
        $customer->load(['orders.status', 'orders.paymentMethod']);

        return view('admin.customers.show', compact('customer'));
    }
}
