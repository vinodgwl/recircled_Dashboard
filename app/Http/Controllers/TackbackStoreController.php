<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use App\Models\TackbackStore;
use App\Models\StorePallet;
use App\Models\StoreBox;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\DB;

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
        // add validation 
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'total_weight' => 'required|integer|min:1',
            'trackback_product_store_type' => 'required',
            'brand_id' => 'required',
            'shipment_id' => 'required',
            'shipping_origin_zipcode' => 'required',
            'shipping_carrier' => 'required',
            'shipping_carrier_name' => 'required',
            'type' => 'required',

        ], [
            'trackback_product_store_type.required' => 'The Tackback Type field is required.',
            'quantity.min' => 'The quantity should be greater than 0',
            'total_weight.min' => 'The quantity should be greater than 0',
            // Add other custom messages here
        ]);
        // echo 'check all object---------- </br>';
         $quantity = $request->input('quantity');
          $asn_on = $request->asn == 'on'?1:0;
         // save information to the tackback store table
        $tackbackStore = new TackbackStore([
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
            'status' => 0,
        ]);
        //  if ($validator->fails()) {
        //         return redirect()->back()->withErrors($validator)->withInput();
        //     }
        // Save the StorePallet instance to the database
        $tackbackStore->save();

         $uniqueIDs = [];
        for ($i = 0; $i < $quantity; $i++) {
            $uniqueID = StorePallet::create([
            'pallet_unique_id' => uniqid(),
            'shipment_id' => $request->shipment_id,
            'tackback_store_id'=>$tackbackStore->id,
            'created_store_shipment_date_time' => Carbon::now(),
            'status' => 0,
        ]);
            $uniqueIDs[] = $uniqueID;
        }

        $data = $request->all();
        Session::put('step1_data', $data);
        // Redirect back to the index page with number of selected quantity
        return redirect()->route('admin.stores.index', ['shimpent_id' => $request->shipment_id]);
        // return redirect()->back()->with('success', 'Store created successfully!');
    }
    public function index(Request $request)
    {
        // Return a view for creating a new brand
        // $stores = TackbackStore::all(); 
        // Fetch the last inserted ID from the request
        $shimpent_id = $request->get('shimpent_id')?$request->get('shimpent_id'): 0;
       
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
    // $stores = TackbackStore::latest()->take($quantity)->get()->reverse();

    $stores = StorePallet::where('shipment_id', $shimpent_id)->latest()->get();


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
            $store = StorePallet::find($store_id);
            $store->store_sub_brand = $request->store_sub_brand[$key];
            $store->pallet_weight = $request->pallet_weight[$key];
            $store->created_store_shipment_date_time = Carbon::now();
            $store->save();
        }
        // echo "good";
        return redirect()->route('admin.stores.saveList');
        // echo $request->store_sub_brand;
    }
    public function updateSaveAndOpenStores(Request $request){
        // echo 'good in save and open';
        // print_r($request->store_ids); die();

        $shimpent_id = $request->shipment_id;
        $shipment_detail = TackbackStore::where('shipment_id', $shimpent_id)->first();
        foreach ($request->store_ids as $key => $store_id) {
            $store = StorePallet::find($store_id);
            $store->store_sub_brand = $request->store_sub_brand[$key];
            $store->pallet_weight = $request->pallet_weight[$key];
            $store->created_store_shipment_date_time = Carbon::now();
            $store->save();
        }
        $storesList = TackbackStore::where('id', $shipment_detail->id)->with('brand')->first();
         $perPage = 5;
         $StorePallet = StorePallet::where('tackback_store_id',  $shipment_detail->id)->paginate($perPage);
         $status0Count = StorePallet::where('tackback_store_id', $shipment_detail->id)->where('status', 0)->count();
         $status1Count = StorePallet::where('tackback_store_id', $shipment_detail->id)->where('status', 1)->count();
          // Append query parameters to pagination links
            $StorePallet->appends($request->query());

        //  print_r($storesList); die();
         return view('admin.stores.tackbackStoreShipment', ['StorePallet' => $StorePallet,
        'storesList' => $storesList, 'status1Count' => $status1Count]);
        
        
        // echo "good";
        // return redirect()->route('admin.stores.saveList');
    }
    public function tackbackStoreSaveList(Request $request){
        // Return a view for creating a new brand
        // $stores = TackbackStore::all(); 
        // Fetch the last inserted ID from the request
        $quantity = $request->get('quantity')?$request->get('quantity'): 0;
       
         // Determine the number of items per page (adjust as needed)
        $perPage = 5;
        // $stores = TackbackStore::orderByDesc('id')->get()->reverse();

        // $stores = TackbackStore::orderByDesc('id')->paginate($perPage);

    //    $stores = TackbackStore::select('shipment_id', 'trackback_product_store_type',
    //    'pallet_weight', 'created_store_date_time', DB::raw('COUNT(CASE WHEN status = 0 THEN 1 END) AS status_0_count'),
    //             DB::raw('COUNT(CASE WHEN status = 1 THEN 1 END) AS status_1_count'))
    //         ->whereIn('id', function($query) {
    //             $query->selectRaw('MAX(id)')
    //                   ->from('tackback_stores')
    //                   ->groupBy('shipment_id',  'trackback_product_store_type',
    //    'pallet_weight', 'created_store_date_time');
    //         })
    //         ->orderByDesc('id')
    //         ->paginate($perPage);

    $stores = TackbackStore::select(
                'shipment_id', 'id',
                'shipping_carrier_name', 'trackback_product_store_type', 'total_weight', 'quantity', 'created_store_date_time',
                DB::raw('SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) AS status_0_count'),
                DB::raw('SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) AS status_1_count')
            )
            ->whereIn('id', function($query) {
                $query->selectRaw('MAX(id)')
                      ->from('tackback_stores')
                      ->groupBy('shipment_id');
            })
            ->groupBy('shipment_id', 'id', 'shipping_carrier_name',  'trackback_product_store_type', 'total_weight', 'quantity', 'created_store_date_time') // Adding GROUP BY clause
            ->orderByDesc('id')
            ->paginate($perPage);
        // print_r($stores);
        // die();
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
            // Return the paginated search results and pagination links
        // return response()->json([
        //     'results' => $results->items(), // Send only the items
        //     'links' => $results->links()->toHtml() // Convert the pagination links to HTML
        // ]);
    }
    public function shipmentDetail(Request $request){
         $id = $request->get('id');
        //  die();
         $storesList = TackbackStore::where('id', $id)->with('brand')->first();
         $perPage = 5;
         $StorePallet = StorePallet::where('tackback_store_id',  $id)->paginate($perPage);
         $status0Count = StorePallet::where('tackback_store_id', $id)->where('status', 0)->count();
         $status1Count = StorePallet::where('tackback_store_id', $id)->where('status', 1)->count();
          // Append query parameters to pagination links
            $StorePallet->appends($request->query());

        //  print_r($storesList); die();
         return view('admin.stores.tackbackStoreShipment', ['StorePallet' => $StorePallet,
        'storesList' => $storesList, 'status1Count' => $status1Count]);
    }

    public function palletDetail(){
        return view('admin.stores.tackbackStorePallet');
    }

    public function createBoxes(Request $request){
        $request->validate([
            'boxboxQuantity' => 'required|integer|min:1',

        ], [
            'boxboxQuantity.min' => 'The quantity should be greater than 0',
            // Add other custom messages here
        ]);
        $StorePalletSingledata = StorePallet::where('id', $request->storeId)->first();
        // for ($i = 0; $i < $request->boxboxQuantity; $i++) {
        //     $uniqueID = StoreBox::create([
        //         'box_unique_id' => uniqid(),
        //         'shipment_id' => $StorePalletSingledata->shipment_id,
        //         'store_pallet_id'=>$StorePalletSingledata->id,
        //         'pallet_unique_id' =>$StorePalletSingledata->pallet_unique_id,
        //         'created_store_box_date_time' => Carbon::now(),
        //         'status' => 0,
        //     ]);
        // }
        // Combine material type and weight arrays
            $materialData = [];
            if($request->input('material_type') && $request->input('material_weight')){
                foreach ($request->input('material_type') as $index => $type) {
                    $weight = $request->input('material_weight')[$index];
                    // Skip adding entry if either type or weight is null
                    if ($type !== null && $weight !== null) {
                        $materialData[] = [
                            'type' => $type,
                            'weight' => $weight
                        ];
                    }
            }
            // Encode material data array as JSON
            $materialDataJson = json_encode($materialData);
            $StorePallet = StorePallet::findOrFail($request->storeId);
            $StorePallet->pallet_packaging_material = $materialDataJson;
            $StorePallet->box_quantity  = $request->boxboxQuantity;
                // Save the StoreBox
                $StorePallet->save();
            }
            $storesList = TackbackStore::where('id', $StorePalletSingledata->tackback_store_id)->with('brand')->first();
            $StorePallet = StorePallet::where('id', $StorePallet->id)->first();
            $storeBoxList = StoreBox::where('store_pallet_id', $request->store_pallet_id)->get();
             return redirect()->route('tackbackStore.box.palllet-detail', ['pallet_id' => $StorePallet->id, 'tackback_store_id' => $StorePalletSingledata->tackback_store_id]);
    }
    public function saveNewBoxes(Request $request){

        // $request->validate([
        //     'box_weight' => 'required|integer|min:1'

        // ], [
        //     'box_weight.min' => 'The box weight should be greater than 0',
        //     // Add other custom messages here
        // ]);
        // echo 'jiiji'; die();

        $pre_consumers = $request->pre_consumer == 'yes'?1:0;
        StoreBox::create([
            'box_unique_id' => uniqid(),
            'shipment_id' => $request->shipment_id,
            'store_pallet_id'=>$request->store_pallet_id,
            'pallet_unique_id' =>$request->pallet_unique_id,
            'box_weight'=>$request->box_weight,
            'product_category'=>$request->product_category,
            'pre_consumer'=>$pre_consumers,
            'created_store_box_date_time' => Carbon::now(),
            'status' => 0,
        ]);

        $StorePalletSingledata = StorePallet::where('id', $request->store_pallet_id)->first();
        $storesList = TackbackStore::where('id', $StorePalletSingledata->tackback_store_id)->with('brand')->first();
        $StorePallet = StorePallet::where('id', $request->store_pallet_id)->first();
        $storeBoxList = StoreBox::where('store_pallet_id', $request->store_pallet_id)->get();
        // return view('admin.stores.tackbackStorePalletBox', ['StorePallet' => $StorePallet,
        //     'storesList' => $storesList, 'storeBoxList' => $storeBoxList]);
         return redirect()->route('tackbackStore.box.palllet-detail', ['pallet_id' => $StorePallet->id, 
         'tackback_store_id' => $StorePalletSingledata->tackback_store_id]);
    }

    public function palletBoxesDetail(Request $request){

        $tackback_store_id =  $request->get('tackback_store_id');
        $store_pallet_id =  $request->get('pallet_id');
        $StorePalletSingledata = StorePallet::where('id',  $store_pallet_id)->first();
        $storesList = TackbackStore::where('id', $tackback_store_id)->with('brand')->first();
        $StorePallet = StorePallet::where('id',  $store_pallet_id)->first();
        $storeBoxList = StoreBox::where('store_pallet_id',  $store_pallet_id)->get();
        return view('admin.stores.tackbackStorePalletBox', ['StorePallet' => $StorePallet,
            'storesList' => $storesList, 'storeBoxList' => $storeBoxList]);
    }
}
