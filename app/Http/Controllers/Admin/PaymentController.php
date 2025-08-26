<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['customer', 'order'])
            ->latest('payment_datetime')
            ->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }
}