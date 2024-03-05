<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Brand;
use App\Models\TrackbackProduct;

class AdminController extends Controller
{
    public function dashboard()
    {
        $users = User::all(); // Fetching dummy users data
        return view('admin.dashboard', compact('users'));
    }
    public function tackbackList()
    {
        $users = User::all(); // Fetching dummy users data
        $brands = Brand::all();
        return view('admin.tackbacklist', compact('users', 'brands'));
    }
    public function store(Request $request)
    {
         // Ensure the existence of the brands directory inside public
         $request->validate([
            'trackback_product_type' => 'required|string|max:255',
            // Add validation rules for other fields if needed
        ]);
        $asn_on = $request->asn == 'on'?1:0;
        echo $request->trackback_product_type; echo "<br>";
        $trackbackProduct = new TrackbackProduct();
        $allProducts = $request->input('products', []);
        $trackbackProduct::create([
            'trackback_product_type' => $request->trackback_product_type,
            'asn' => $asn_on,
            'brand_id' => $request->brand_id,
            'shipment_id' => $request->shipment_id,
            'quantity' => $request->quantity? $request->quantity: 0,
            'total_weight' => $request->total_weight? $request->total_weight: 0,
            'products' => json_encode($allProducts),
        // other fields
        ]);
        // print_r($request->asn);
        // die();
        return redirect()->back()->with('success', 'tracback product created successfully!');
        // echo ;
        // die();
    }
}
