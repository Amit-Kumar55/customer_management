<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class UIController extends Controller
{

    public function loginUser(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Make API request to Laravel Passport Login Endpoint
        $response = Http::post(url('/api/login'), [
            'email' => $request->email,
            'password' => $request->password
        ]);

        $data = $response->json();

        // Check if login was successful
        if (isset($data['token'])) {
            session(['auth_token' => $data['token']]); // Store token in session
            return redirect()->route('customers'); // Redirect to customer page
        }

        return back()->with('error', 'Invalid credentials');
    }

    // Show Customer List
    public function showCustomers()
    {
        $response = Http::withToken(session('auth_token'))->get(url('/api/customers'));
        $customers = $response->json()['customers'] ?? [];

        return view('customers.index', compact('customers'));
    }

    // Show Create Customer Page
    public function showCreateCustomer()
    {
        return view('customers.create');
    }

    // Store New Customer
    public function storeCustomer(Request $request)
    {
        Http::withToken(session('auth_token'))->post(url('/api/customers'), $request->all());
        return redirect()->route('customers');
    }

    // Show Edit Customer Page
    public function editCustomer($id)
    {
        $response = Http::withToken(session('auth_token'))->get(url("/api/customers/$id"));
        $customer = $response->json();

        return view('customers.edit', compact('customer'));
    }

    // Update Customer
    public function updateCustomer(Request $request, $id)
    {
        Http::withToken(session('auth_token'))->put(url("/api/customers/$id"), $request->all());
        return redirect()->route('customers');
    }

    // Delete Customer
    public function deleteCustomer($id)
    {
        Http::withToken(session('auth_token'))->delete(url("/api/customers/$id"));
        return response()->json(['message' => 'Customer deleted']);
    }
}
