<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use App\Models\TackbackStore;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Session;

use Illuminate\Http\Request;

class TackbackStoreController extends Controller
{
    public function create()
    {
        // Return a view for creating a new brand
        $brands = Brand::all();  
        // Return a view and pass the fetched brands to it
        $step1_data = Session::get('step1_data');
        return view('admin.stores.create', ['brands' => $brands, 'prevois_store_data'=> $step1_data]);
    }
    public function store(Request $request)
    {
        // echo 'check all object---------- </br>';
         $quantity = $request->input('quantity');
         
         $uniqueIDs = [];
         $asn_on = $request->asn == 'on'?1:0;
        for ($i = 0; $i < $quantity; $i++) {
            $uniqueID = TackbackStore::create([
            'pallet_unique_id' => uniqid(),
            'trackback_product_store_type' => $request->trackback_product_store_type,
            'asn' => $asn_on,
            'brand_id' => $request->brand_id,
            'shipment_id' => $request->shipment_id,
            'shipping_origin_zipcode' => $request->shipping_origin_zipcode,
            'shipping_carrier' => $request->shipping_carrier,
            'shipping_carrier_name' => $request->shipping_carrier_name,
            'type' => $request->type,
            'quantity' => $request->quantity,   
            'total_weight' => $request->total_weight,
            'created_store_date_time' => Carbon::now(),
        ]);
            $uniqueIDs[] = $uniqueID;
        }

        $data = $request->all();
        Session::put('step1_data', $data);
        // Redirect back to the index page with number of selected quantity
        return redirect()->route('admin.stores.index', ['quantity' => $quantity]);
        // return redirect()->back()->with('success', 'Store created successfully!');
    }
    public function index(Request $request)
    {
        // Return a view for creating a new brand
        // $stores = TackbackStore::all(); 
        // Fetch the last inserted ID from the request
        $quantity = $request->get('quantity')?$request->get('quantity'): 0;
       
         // Determine the number of items per page (adjust as needed)
        $perPage = 5;
        // $stores = TackbackStore::orderByDesc('id')->limit($quantity)->get()->reverse();

        // $stores = TackbackStore::orderByDesc('id')->paginate($perPage);
    //     $stores = TackbackStore::orderByDesc('id')
    // ->take($quantity)
    // ->paginate($perPage);

    // $quantity = 10; // Or any other value you prefer
    // $perPage = 5; // Or any other value you prefer

    // Query to retrieve the latest $quantity records and reverse them
    $stores = TackbackStore::latest()->take($quantity)->get()->reverse();

    // $stores = TackbackStore::latest()->take($quantity)->paginate($perPage);

        

        // Paginate the fetched records
        // $stores = TackbackStore::orderByDesc('id')->paginate(10);

        // $stores = TackbackStore::orderByDesc('id')->limit($quantity)->paginate(10);
        $latestStoreDetail = TackbackStore::orderByDesc('id')->with('brand')->first();

        // print_r($latestStoreDetail); die();
        
        // Return a view and pass the fetched brands to it
        return view('admin.stores.index', ['stores' => $stores, 'latestStoreDetail' => $latestStoreDetail]);
    }
    public function updateStores(Request $request){
        // updated store with sub brands and pallet weight
        foreach ($request->store_ids as $key => $store_id) {
            $store = TackbackStore::find($store_id);
            $store->store_sub_brand = $request->store_sub_brand[$key];
            $store->pallet_weight = $request->pallet_weight[$key];
            $store->save();
        }
        // echo "good";
        return redirect()->route('admin.stores.saveList');
        // echo $request->store_sub_brand;
    }
    public function tackbackStoreSaveList(Request $request){
        // Return a view for creating a new brand
        // $stores = TackbackStore::all(); 
        // Fetch the last inserted ID from the request
        $quantity = $request->get('quantity')?$request->get('quantity'): 0;
       
         // Determine the number of items per page (adjust as needed)
        $perPage = 5;
        // $stores = TackbackStore::orderByDesc('id')->get()->reverse();

        $stores = TackbackStore::orderByDesc('id')->paginate($perPage);

        $latestStoreDetail = TackbackStore::with('brand')->first();
        $brands = Brand::all();  
        // Return a view and pass the fetched brands to it
        return view('admin.stores.tackbackStoreListSave', ['stores' => $stores, 'latestStoreDetail' => $latestStoreDetail, 
        'brands' =>$brands]);
    }
    public function cancelForm(){
        // Clear session data
        Session::forget('step1_data');
        // echo 'jiij';
        $brands = Brand::all();  
        // Return a view and pass the fetched brands to it
        // $step1_data = Session::get('step1_data');
        
        return view('admin.stores.create', ['brands' => $brands]);
        
    }
    public function filterBrands(Request $request){
        $brandId = $request->input('brand_id');
         $brands = Brand::all();  
        // Fetch data based on the brand ID
        $stores = TackbackStore::where('brand_id', $brandId)->get();
        if (empty($brandId)) {
            $stores = TackbackStore::all();
        }
        return response()->json($stores);
    }

    public function searchStore(Request $request){
        $query = $request->input('query');
        if(!empty($query)) { 
            $results = TackbackStore::query()
        // ->where('name', 'like', "%{$query}%")
        ->Where('trackback_product_store_type', 'like', "%{$query}%")
        ->orWhere('shipment_id', 'like', "%{$query}%")
        ->get();
        } else {
            $results = TackbackStore::all();
        }
        return response()->json($results);
    }
}
