<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use App\Models\TackbackStore;
use App\Models\RdTakebackShipment;
use App\Models\StorePallet;
use App\Models\RdPallet;
use App\Models\StoreBox;
use App\Models\BoxProduct;
use App\Models\RdBox;
use App\Models\RdProduct;
use App\Models\RdPalletPackagingMaterial;
use App\Models\RdBoxPackagingMaterial;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class TackbackStoreController extends Controller
{
    public function create(Request $request)
    {
        // Return a view for creating a new brand
        $lang = $request->query('lang', 'en');
        app()->setLocale($lang);
        $brands = Brand::all();  
        // Return a view and pass the fetched brands to it
        $step1_data = Session::get('step1_data');
        return view('admin.stores.create', ['brands' => $brands, 'prevois_store_data'=> $step1_data]);
    }

    public function createStore(){
         $brands = Brand::all();  
         Session::forget('step1_data');
         return view('admin.stores.create', ['brands' => $brands]);
    }
    public function store(Request $request)
    {
        // add validation 
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'total_weight' => 'required|integer|min:1',
            'trackback_type_store_customer_warehouse' => 'required',
            'brand_id' => 'required',
            'shipment_information_id' => 'required|unique:rd_takeback_shipments,shipment_information_id',
            'shipping_origin_zipcode' => 'required',
            'shipping_carrier' => 'required',
            'shipping_carrier_name' => 'required',
            'box_type' => 'required',

        ], [
            'trackback_type_store_customer_warehouse.required' => 'The Tackback Type field is required.',
            'quantity.min' => 'The quantity should be greater than 0',
            'total_weight.min' => 'The quantity should be greater than 0',
            'shipment_information_id.unique' => 'Shipment id already exist',
            // Add other custom messages here
        ]);
        // echo 'check all object---------- </br>';
         $quantity = $request->input('quantity');
          $asn_on = $request->asn == 'on'?1:0;
         // save information to the tackback store table
        //  die('ok');
        $takebackShipment = new RdTakebackShipment([
            'trackback_type_store_customer_warehouse' => $request->trackback_type_store_customer_warehouse,
            'asn' => $asn_on,
            'brand_id' => $request->brand_id,
            'shipment_information_id' => $request->shipment_information_id,
            'shipping_origin_zipcode' => $request->shipping_origin_zipcode,
            'shipping_carrier' => $request->shipping_carrier,
            'shipping_carrier_name' => $request->shipping_carrier_name,
            'box_type' => $request->box_type,
            'quantity' => $request->quantity,   
            'total_weight' => $request->total_weight,
            'shipment_created_at' => Carbon::now(),
            'status' => 0,
        ]);
        //  if ($validator->fails()) {
        //         return redirect()->back()->withErrors($validator)->withInput();
        //     }
        // Save the StorePallet instance to the database
        $takebackShipment->save();

         $uniqueIDs = [];
        for ($i = 0; $i < $quantity; $i++) {
            $uniqueID = RdPallet::create([
            'pallet_gen_code' => uniqid(),
            'shipment_id'=>$takebackShipment->id,
            'pallet_created_at' => Carbon::now(),
            'status' => 0,
            'brand_id' => $request->brand_id,
        ]);
            $uniqueIDs[] = $uniqueID;
        }

        $data = $request->all();
        Session::put('step1_data', $data);
        // Redirect back to the index page with number of selected quantity
        return redirect()->route('admin.stores.index', ['shimpent_id' => $takebackShipment->id]);
        // return redirect()->back()->with('success', 'Store created successfully!');
    }
    public function index(Request $request)
    {
        $shimpent_id = $request->get('shimpent_id')?$request->get('shimpent_id'): 0;
        $perPage = 5;
        $stores = RdPallet::where('shipment_id', $shimpent_id)->latest()->get();
        $latestStoreDetail = RdTakebackShipment::orderByDesc('shipment_id')->with('brand')->first();
        // Return a view and pass the fetched brands to it
        return view('admin.stores.index', ['stores' => $stores, 'latestStoreDetail' => $latestStoreDetail]);
    }
    public function updateStores(Request $request){
        // updated store with sub brands and pallet weight
        foreach ($request->store_ids as $key => $store_id) {
            // $store = RdPallet::find($store_id);
            $store = RdPallet::where('pallet_id', $store_id)->first();
            $store->sub_brand = $request->sub_brand[$key];
            $store->pallet_weight = $request->pallet_weight[$key];
            $store->pallet_created_at = Carbon::now();
            $store->save();
        }
        return redirect()->route('admin.stores.saveList');
    }
    public function updateSaveAndOpenStores(Request $request){
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
         return view('admin.stores.tackbackStoreShipment', ['StorePallet' => $StorePallet,
        'storesList' => $storesList, 'status1Count' => $status1Count]);
    }
    public function tackbackStoreSaveList(Request $request){
        // Return a view for creating a new brand
        // Fetch the last inserted ID from the request
        $lang = $request->query('lang', 'en');
        app()->setLocale($lang);
        $quantity = $request->get('quantity')?$request->get('quantity'): 0;
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

    // $stores = RdTakebackShipment::select(
    //             'shipment_id', 'shipment_information_id',
    //             'shipping_carrier_name', 'trackback_type_store_customer_warehouse', 'total_weight', 'quantity', 'shipment_created_at',
    //             DB::raw('SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) AS status_0_count'),
    //             DB::raw('SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) AS status_1_count')
    //         )
    //         ->whereIn('shipment_id', function($query) {
    //             $query->selectRaw('MAX(shipment_id)')
    //                   ->from('rd_takeback_shipments')
    //                   ->groupBy('shipment_id');
    //         })
    //         ->groupBy('shipment_id', 'shipment_information_id', 'shipping_carrier_name',  'trackback_type_store_customer_warehouse', 'total_weight', 'quantity', 'shipment_created_at') // Adding GROUP BY clause
    //         ->orderByDesc('shipment_id')
    //         ->paginate($perPage);
           $stores = RdTakebackShipment::select(
                'rd_takeback_shipments.shipment_id', // Specify table name for shipment_id
                'shipment_information_id',
                'shipping_carrier_name',
                'trackback_type_store_customer_warehouse',
                'total_weight',
                'quantity',
                'shipment_created_at',
                DB::raw('SUM(CASE WHEN rd_pallets.status = 0 THEN 1 ELSE 0 END) AS status_0_count'),
                DB::raw('SUM(CASE WHEN rd_pallets.status = 1 THEN 1 ELSE 0 END) AS status_1_count')
            )
            ->leftJoin('rd_pallets', 'rd_takeback_shipments.shipment_id', '=', 'rd_pallets.shipment_id')
            ->whereIn('rd_takeback_shipments.shipment_id', function($query) {
                $query->selectRaw('MAX(shipment_id)')
                      ->from('rd_takeback_shipments')
                      ->groupBy('shipment_id');
            })
            ->groupBy('rd_takeback_shipments.shipment_id', 'shipment_information_id', 'shipping_carrier_name',  'trackback_type_store_customer_warehouse', 'total_weight', 'quantity', 'shipment_created_at') // Adding GROUP BY clause
            ->orderByDesc('rd_takeback_shipments.shipment_id')
            ->paginate($perPage);


            // print_r($stores);  die();
        $latestStoreDetail = RdTakebackShipment::with('brand')->first();
        $brands = Brand::all();  
        // Return a view and pass the fetched brands to it
        return view('admin.stores.tackbackStoreListSave', ['stores' => $stores, 'latestStoreDetail' => $latestStoreDetail, 
        'brands' =>$brands]);
    }
    public function cancelForm(){
        Session::forget('step1_data');
        $brands = Brand::all();  
        // Return a view and pass the fetched brands to it
        // $step1_data = Session::get('step1_data');
        
        return view('admin.stores.create', ['brands' => $brands]);
        
    }
    public function filterBrands(Request $request){
        $brandId = $request->input('brand_id');
         $brands = Brand::all();  
        // Fetch data based on the brand ID
        $stores = RdTakebackShipment::where('brand_id', $brandId)->get();
        if (empty($brandId)) {
            $stores = RdTakebackShipment::all();
        }
        return response()->json($stores);
    }

    public function searchStore(Request $request){
        $query = $request->input('query');
        if(!empty($query)) { 
            $results = RdTakebackShipment::query()
        // ->where('name', 'like', "%{$query}%")
        ->Where('trackback_type_store_customer_warehouse', 'like', "%{$query}%")
        ->orWhere('shipment_information_id', 'like', "%{$query}%")
        ->get();
        } else {
            $results = RdTakebackShipment::all();
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
         $storesList = RdTakebackShipment::where('shipment_id', $id)->with('brand')->first();
         $perPage = 5;
         $StorePallet = RdPallet::with('palletPackagingMaterial')->where('shipment_id',  $id)->paginate($perPage);
        //  if($StorePallet && $StorePallet->palletPackagingMaterial->isNotEmpty()){
        //     print_r($StorePallet->palletPackagingMaterial); die('into matcjhed==========');
        //  }
         $status0Count = RdPallet::where('shipment_id', $id)->where('status', 0)->count();
         $status1Count = RdPallet::where('shipment_id', $id)->where('status', 1)->count();
        
        //  new query is added for showing count open and unopened

        // $storePallets = StorePallet::select('store_pallets.*')
        //     ->selectRaw('COUNT(store_boxes.id) AS open_count')
        //     ->selectRaw('SUM(CASE WHEN store_boxes.status = 0 THEN 1 ELSE 0 END) AS open_count')
        //     ->selectRaw('SUM(CASE WHEN store_boxes.status = 1 THEN 1 ELSE 0 END) AS unopened_count')
        //     ->leftJoin('store_boxes', 'store_pallets.id', '=', 'store_boxes.store_pallet_id')
        //     ->where('store_pallets.tackback_store_id', $id)
        //     ->groupBy('store_pallets.id')
        //     ->paginate($perPage);
        // $storePallets = RdPallet::select('rd_pallets.*')
        // ->selectSub(function ($query) {
        //     $query->selectRaw('COUNT(id) AS open_count')
        //         ->from('store_boxes')
        //         ->whereColumn('store_boxes.store_pallet_id', 'rd_pallets.pallet_id')
        //         ->where('store_boxes.status', 0);
        // }, 'open_count')
        // ->selectSub(function ($query) {
        //     $query->selectRaw('COUNT(id) AS unopened_count')
        //         ->from('store_boxes')
        //         ->whereColumn('store_boxes.store_pallet_id', 'rd_pallets.pallet_id')
        //         ->where('store_boxes.status', 1);
        // }, 'unopened_count')
        // ->selectSub(function ($query) {
        //     $query->selectRaw('COUNT(id) AS total_count')
        //         ->from('store_boxes')
        //         ->whereColumn('store_boxes.store_pallet_id', 'rd_pallets.pallet_id');
        // }, 'total_count')
        // ->where('rd_pallets.shipment_id', $id)
        // ->paginate($perPage);

                $storePallets = RdPallet::select('rd_pallets.*')
            ->selectSub(function ($query) {
                $query->selectRaw('COUNT(DISTINCT box_id) AS open_count')
                    ->from('rd_boxes')
                    ->whereColumn('rd_boxes.pallet_id', 'rd_pallets.pallet_id')
                    ->where('rd_boxes.status', 1);
            }, 'open_count')
            ->selectSub(function ($query) {
                $query->selectRaw('COUNT(DISTINCT box_id) AS unopened_count')
                    ->from('rd_boxes')
                    ->whereColumn('rd_boxes.pallet_id', 'rd_pallets.pallet_id')
                    ->where('rd_boxes.status', 0);
            }, 'unopened_count')
            ->selectSub(function ($query) {
                $query->selectRaw('COUNT(DISTINCT box_id) AS total_count')
                    ->from('rd_boxes')
                    ->whereColumn('rd_boxes.pallet_id', 'rd_pallets.pallet_id');
            }, 'total_count')
            ->where('rd_pallets.shipment_id', $id)
            ->paginate($perPage);

          // Append query parameters to pagination links
            $StorePallet->appends($request->query());

        //  print_r($StorePallet); die('list end');
         return view('admin.stores.tackbackStoreShipment', ['StorePallet' => $StorePallet,
        'storesList' => $storesList, 'status1Count' => $status1Count]);
    }

    public function palletDetail(Request $request){
        // $StorePallet = RdPallet::where('pallet_id', $request->pallet_id)->first();
        $StorePallet = RdPallet::with('boxes')->where('pallet_id', $request->pallet_id)->first();
        $shipmentList = RdTakebackShipment::where('shipment_id', $StorePallet->shipment_id)->with('brand')->first();
        $BoxList = RdBox::where('pallet_id', $StorePallet->pallet_id)->first();
        $BoxProductList = RdProduct::where('box_id',  $BoxList->box_id)->get();
        $BoxPackgingMaterialList = RdBoxPackagingMaterial::where('box_id',  $BoxList->box_id)->get();
        // print_r($BoxPackgingMaterialList); die('ok11'); 
        return view('admin.stores.tackbackStorePallet',  ['StorePallet' => $StorePallet,
        'shipmentList' => $shipmentList, 'BoxProductList' => $BoxProductList, 'BoxList' => $BoxList,
       'BoxPackgingMaterialList' =>$BoxPackgingMaterialList]);
    }

    public function createBoxes(Request $request){
        // die('koko');
        $request->validate([
            'boxboxQuantity' => 'required|integer|min:1',

        ], [
            'boxboxQuantity.min' => 'The quantity should be greater than 0',
            // Add other custom messages here
        ]);
        $StorePalletSingledata = RdPallet::where('pallet_id', $request->storeId)->first();
        
        // Combine material type and weight arrays
            $materialData = [];
            if($request->input('material_type') && $request->input('material_weight')){
                foreach ($request->input('material_type') as $index => $type) {
                    $weight = $request->input('material_weight')[$index];
                    // Skip adding entry if either type or weight is null
                    if ($type !== null && $weight !== null) {
                        // $materialData[] = [
                        //     'type' => $type,
                        //     'weight' => $weight
                        // ];
                         RdPalletPackagingMaterial::create([
                            'shipment_id' => $StorePalletSingledata->shipment_id,
                            'pallet_id'=>$request->storeId,
                            'material_type' => $type,
                            'material_weight' => $weight,
                        ]);
                    }
            }
            // Encode material data array as JSON
            $materialDataJson = json_encode($materialData);
            $StorePallet = RdPallet::findOrFail($request->storeId);
            // $StorePallet->pallet_packaging_material = $materialDataJson;
            $StorePallet->box_quantity  = $request->boxboxQuantity;
            $StorePallet->status  = 1;
                // Save the StoreBox
                $StorePallet->save();
            }
            // generate box id for that perticuler pallets and save in box tables.

            for ($i = 0; $i < $request->boxboxQuantity; $i++) {
                $uniqueID = RdBox::create([
                    'box_gen_code' => uniqid(),
                    'shipment_id' => $StorePalletSingledata->shipment_id,
                    'pallet_id'=>$StorePalletSingledata->pallet_id,
                    'status' => 0,
                    'pallet_gen_code' => $StorePalletSingledata->pallet_gen_code,
                    'brand_id' => $StorePalletSingledata->brand_id,
                    'box_created_at' => Carbon::now(),
                ]);
            }

            // RdBox::updateOrCreate(
            //     // Search criteria
            //     [
            //         'shipment_id' => $StorePalletSingledata->shipment_id,
            //         'pallet_id' => $request->storeId,
            //     ],
            //     // Values to update or create
            //     [
            //         'box_gen_code' => uniqid(),
            //         'material_weight' => $weight,
            //         'pallet_gen_code' => $StorePalletSingledata->pallet_gen_code,
            //         'brand_id' => $StorePalletSingledata->brand_id,
            //         'box_created_at' => Carbon::now(),
            //     ]
            // );
            $storesList = RdTakebackShipment::where('shipment_id', $StorePalletSingledata->shipment_id)->with('brand')->first();
            $StorePallet = RdPallet::where('pallet_id', $StorePallet->pallet_id)->first();
            $storeBoxList = RdBox::where('pallet_id', $StorePallet->pallet_id)->get();
            $singlePalletBox = RdBox::where('pallet_id', $StorePallet->pallet_id)->first();
             return redirect()->route('tackbackStore.box.palllet-detail', ['pallet_id' => $StorePallet->pallet_id, 'shipment_id' => $StorePalletSingledata->shipment_id
            , 'singlePalletBox' => $singlePalletBox]);
    }
    public function saveNewBoxes(Request $request){

        // $request->validate([
        //     'box_weight' => 'required|integer|min:1'

        // ], [
        //     'box_weight.min' => 'The box weight should be greater than 0',
        //     // Add other custom messages here
        // ]);

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
        // print_r('hello worl d okk'); die();
        $shipment_id =  $request->get('shipment_id');
        $pallet_id =  $request->get('pallet_id');
        $StorePalletSingledata = RdPallet::where('pallet_id',  $pallet_id)->first();
        $storesList = RdTakebackShipment::where('shipment_id', $shipment_id)->with('brand')->first();
        // $StorePallet = RdPallet::where('pallet_id',  $pallet_id)->first();
        $StorePallet = RdPallet::with('boxes')->where('pallet_id', $pallet_id)->first();
        // print_r($StorePallet->boxes[0]->box_id); die('ppl111');
        $storeBoxList = RdBox::where('pallet_id',  $pallet_id)->get();
        return redirect()->route('admin.stores.shipment-detail', ['id' => $shipment_id]);
        // return view('admin.stores.tackbackStorePalletBox', ['StorePallet' => $StorePallet,
        //     'storesList' => $storesList, 'storeBoxList' => $storeBoxList]);
    }

    public function deleteBox($id){
        $record = StoreBox::findOrFail($id);
        $record->delete();
        return redirect()->back()->with('success', 'Box deleted successfully.');
    }

    public function palletBoxesProductList(Request $request){
            // die('finr');
        // echo $request->get('id');
        $StorePalletSingledata = RdBox::where('box_id', $request->get('id'))->first();
        $StorePallet = RdPallet::where('pallet_id',  $StorePalletSingledata->pallet_id)->first();
        // echo $StorePallet; die('ok');
        $storesList = RdTakebackShipment::where('shipment_id', $StorePallet->shipment_id)->with('brand')->first();
        $storeBoxList = RdBox::where('pallet_id',  $StorePalletSingledata->pallet_id)->get();
        $productBoxList = RdProduct::where('box_id', $request->get('id'))->get();
        return view('admin.stores.tackbackStoreBoxDetail', ['StorePallet' => $StorePallet,
            'storesList' => $storesList, 'storeBoxList' => $storeBoxList, 'singleBoxDetail' =>$StorePalletSingledata,
        'productBoxList' => $productBoxList]);
    }

    public function saveBoxNewProduct(Request $request){
        $request->validate([
            'product_name' => 'required',
            'product_quantity' => 'required|integer|min:1',
            'product_weight' => 'required',
            'product_tier' => 'required',

        ], [
            'product_quantity.min' => 'The quantity should be greater than 0',
            'product_weight.min' => 'The quantity should be greater than 0',
            // Add other custom messages here
        ]);
        // echo $request->product_name; die('ok');
        $resaleCondition = $request->good_resale_condition == 1?1:0;
        // echo $resaleCondition; die('pp');
        // Create a new BoxProduct instance
        $boxProduct = new RdProduct();
        $boxProduct->pallet_id = $request->pallet_id;
        $boxProduct->box_id  = $request->box_id;
        $boxProduct->shipment_id = $request->shipment_id;
        $boxProduct->product_name = $request->product_name;
        $boxProduct->product_weight = $request->product_weight;
        $boxProduct->product_quantity = $request->product_quantity;
        $boxProduct->product_tier = $request->product_tier;
        $boxProduct->good_resale_condition = $resaleCondition;
        $boxProduct->brand_id = $request->brand_id;
        // Save the box product
        $boxProduct->save();
        // $box = RdBox::findOrFail($request->box_id);
        // $box->update([
        //     'status' => 1
        // ]);
        return redirect()->back()->with('success', 'Product added successfully.');
        
    }

    public function updateNewBoxes(Request $request){
        
        // Update the record in the database
        $pallet_id = $request->palletId;
        // Retrieve the RdBox record based on the pallet_id
        $PalletSingledata = RdPallet::where('pallet_id', $pallet_id)->first();
        $pre_consumers = $request->pre_consumer == 'yes'?1:0;
        // Find or create the RdBox
        // $box = RdBox::firstOrNew(['box_id' => $request->boxId]);
         $box = RdBox::findOrFail($request->boxId);
            
        // Update the box attributes
        $box->update([
            'box_weight' => $request->box_weight,
            'product_category' => $request->product_category,
            'pre_consumer' => $pre_consumers,
            'status'=>1,
            'shipment_id' => $PalletSingledata->shipment_id,
            'pallet_id' => $PalletSingledata->pallet_id,
        ]);

        // Output the box ID
        $BoxId = $box->box_id;
        
        $materialData = [];
        RdBoxPackagingMaterial::where('box_id', $BoxId)->delete();
        if($request->input('material_type1') && $request->input('material_weight1')){
            
                foreach ($request->input('material_type1') as $index => $type) {
                    
                    $weight = $request->input('material_weight1')[$index];
                    // Skip adding entry if either type or weight is null
                    if ($type !== null && $weight !== null) {
                        
                        $materialData[] = [
                            'type' => $type,
                            'weight' => $weight
                        ];
                        // Create or update the record based on the box_id

                        RdBoxPackagingMaterial::create(
                            [
                                'shipment_id' => $PalletSingledata->shipment_id,
                                'pallet_id' => $PalletSingledata->pallet_id,
                                'box_id' => $BoxId,
                                'material_type' => $type,
                                'material_weight' => $weight,
                            ]
                        );
                    }
            }
           
            }
        return redirect()->route('tackbackStore.box.product-list', ['id' => $BoxId]);
        // return redirect()->back()->with('success', 'Box updated successfully.');
    }

    function updateNewProduct(Request $request){
        $product = RdProduct::findOrFail($request->productId);
        $resaleCondition = $request->good_resale_condition == 1?1:0;
        $product->update([
            'product_name' => $request->product_name,
            'product_weight' => $request->product_weight,
            'product_quantity' => $request->product_quantity,
            'product_tier' => $request->product_tier,
            'good_resale_condition' => $resaleCondition,
        ]);
        return redirect()->back()->with('success', 'Product updated successfully.');
    }

    function deleteBoxProduct($id){
        $record = RdProduct::findOrFail($id);
        $record->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    function updateNewProductBoxes(Request $request){

        
        // Update the record in the database
        $pallet_id = $request->palletId;
        $box_id =  $request->boxId;
        // echo $pallet_id;

        
        $PalletSingledata = RdPallet::where('pallet_id', $pallet_id)->first();
        $pre_consumers = $request->pre_consumer == 'yes'?1:0;

           
        // Find or create the RdBox
        $box = RdBox::firstOrNew(['box_id' => $request->boxId]);
        // Update the box attributes
        $box->fill([
            'box_weight' => $request->box_weight,
            'product_category' => $request->product_category,
            'pre_consumer' => $pre_consumers,
            'status'=>1,
            'shipment_id' => $PalletSingledata->shipment_id,
            'pallet_id' => $PalletSingledata->pallet_id,
        ])->save();

        // Output the box ID
        $BoxId = $box->box_id;
        // die('F');
        $materialData = [];
        RdBoxPackagingMaterial::where('box_id', $BoxId)->delete();
        if($request->input('material_type1') && $request->input('material_weight1')){
            
                foreach ($request->input('material_type1') as $index => $type) {
                    
                    $weight = $request->input('material_weight1')[$index];
                    // Skip adding entry if either type or weight is null
                    if ($type !== null && $weight !== null) {
                        
                        $materialData[] = [
                            'type' => $type,
                            'weight' => $weight
                        ];
                        // Create or update the record based on the box_id

                        RdBoxPackagingMaterial::create(
                            [
                                'shipment_id' => $PalletSingledata->shipment_id,
                                'pallet_id' => $PalletSingledata->pallet_id,
                                'box_id' => $BoxId,
                                'material_type' => $type,
                                'material_weight' => $weight,
                            ]
                        );
                    }
            }
           
            }
        // return redirect()->route('tackbackStore.box.product-list', ['id' => $BoxId]);
        return redirect()->back()->with('success', 'Box updated successfully.');
    }

    public function updatePallet(Request $request){
        $pallet_id = $request->palletId;
        $pallet = RdPallet::findOrFail($request->palletId);
        // // Update the box attributes
        $pallet->update([
            'box_quantity' => $request->boxboxQuantity,
        ]);
        $materialData = [];
        RdPalletPackagingMaterial::where('pallet_id', $request->palletId)->delete();   
        if($request->input('material_type2') && $request->input('material_weight2')){
                foreach ($request->input('material_type2') as $index => $type) {
                    $weight = $request->input('material_weight2')[$index];
                    // Skip adding entry if either type or weight is null
                    if ($type !== null && $weight !== null) {
                        
                        $materialData[] = [
                            'type' => $type,
                            'weight' => $weight
                        ];
                        // Create or update the record based on the box_id

                        RdPalletPackagingMaterial::create(
                            [
                                'shipment_id' => $pallet->shipment_id,
                                'pallet_id' => $pallet->pallet_id,
                                'material_type' => $type,
                                'material_weight' => $weight,
                            ]
                        );
                    }
            }
           
            }
        return redirect()->back()->with('success', 'Pallet updated successfully.');
    }

     public function palletBoxList(Request $request){
       
        $pallet_id = $request->get('pallet_id');
        // die('boxes list');
        // $shipment_id =  $request->get('shipment_id');
        // $pallet_id =  $request->get('pallet_id');
        // $StorePalletSingledata = RdPallet::where('pallet_id',  $pallet_id)->first();
        // $storesList = RdTakebackShipment::where('shipment_id', $shipment_id)->with('brand')->first();
        // // $StorePallet = RdPallet::where('pallet_id',  $pallet_id)->first();
        $StorePallet = RdPallet::where('pallet_id', $pallet_id)->first();
        $storesList = RdTakebackShipment::where('shipment_id', $StorePallet->shipment_id)->with('brand')->first();
        // // print_r($StorePallet->boxes[0]->box_id); die('ppl111');
        $storeBoxList = RdBox::where('pallet_id',  $pallet_id)->get();
        // return redirect()->route('admin.stores.shipment-detail', ['id' => $shipment_id]);
        return view('admin.stores.tackbackStorePalletBox', ['StorePallet' => $StorePallet,
            'storesList' => $storesList, 'storeBoxList' => $storeBoxList]);
    }

    // open new box while we click save & open Next box
    public function palletOpenNextBox(Request $request){
        // Retrieve the pallet_id and box_id from the request
        $palletId = $request->pallet_id;
        $boxId = $request->box_id;
        // Find the next record based on the provided box_id
        $nextRecord = RdBox::where('pallet_id', $palletId)->where('box_id', '>', $boxId)
        ->orderBy('box_id')->first();
        $palletDetail = RdPallet::where('pallet_id', $palletId)->first();
        if (!$nextRecord) {
            // If no next record is found, return a response indicating no more records
            return response()->json(['message' => 'No More boxes available']);
            // return response()->json(['message' => 'No More boxes available'], 404);
         }
        // If a next record is found, return the record data
        $data = [
            'nextRecord' => $nextRecord,
            'palletDetail' => $palletDetail,
        ];
        return response()->json($data);
    }
    function createBoxesAndOpen(Request $request){
       
        // if($request->has('materials') && !empty($request->materials)){
        //     echo 'good';
        // }
        // else {
        //     echo 'bad else';
        // }
        $StorePalletSingledata = RdPallet::where('pallet_id', $request->storeId)->first();
        // Combine material type and weight arrays
            if($request->has('materials') && !empty($request->materials)){
                 // Access the materials array from the request
                 
                $materials = $request->input('materials');
                // print_r($materials);
                foreach ($materials as $index => $material) {
                    // Get the weight for the current material
                    $type = $material['type'];
                    $weight = $material['weight'];
                    // Skip adding entry if either type or weight is null
                    if ($type !== null && $weight !== null) {
                        // Create a new record in the database for the current material
                        RdPalletPackagingMaterial::create([
                            'shipment_id' => $StorePalletSingledata->shipment_id,
                            'pallet_id' => $request->storeId,
                            'material_type' => $type,
                            'material_weight' => $weight,
                        ]);
                    }
                }
                $StorePallet = RdPallet::findOrFail($request->storeId);
                $StorePallet->box_quantity  = $request->boxQuantity;
                $StorePallet->status  = 1;
                    // Save the StoreBox
                    $StorePallet->save();
            }
            else {
                // If 'materials' is empty or not provided in the request, return an error response
                return response()->json(['error' => 'Materials array is empty or not provided'], 422); // Use the appropriate HTTP status code
            }
            // generate box id for that perticuler pallets and save in box tables.

            for ($i = 0; $i < $request->boxQuantity; $i++) {
                $uniqueID = RdBox::create([
                    'box_gen_code' => uniqid(),
                    'shipment_id' => $StorePalletSingledata->shipment_id,
                    'pallet_id'=>$StorePalletSingledata->pallet_id,
                    'status' => 0,
                    'pallet_gen_code' => $StorePalletSingledata->pallet_gen_code,
                    'brand_id' => $StorePalletSingledata->brand_id,
                    'box_created_at' => Carbon::now(),
                ]);
            }

            $storesList = RdTakebackShipment::where('shipment_id', $StorePalletSingledata->shipment_id)->with('brand')->first();
            $StorePallet = RdPallet::where('pallet_id', $StorePallet->pallet_id)->first();
            $storeBoxList = RdBox::where('pallet_id', $StorePallet->pallet_id)->get();
            $singlePalletBox = RdBox::where('pallet_id', $StorePallet->pallet_id)->first();

            $data = [
            'pallet_id' => $StorePallet->pallet_id,
            'shipment_id' =>  $StorePalletSingledata->shipment_id,
            'singlePalletBox' => $singlePalletBox,
            'StorePallet' => $StorePallet,
            ];
            $response = response()->json($data);
            $response->header('Content-Type', 'application/json');
            return $response;

            //  return redirect()->route('tackbackStore.box.palllet-detail', ['pallet_id' => $StorePallet->pallet_id, 'shipment_id' => $StorePalletSingledata->shipment_id
            // , 'singlePalletBox' => $singlePalletBox]);
    }
}
