<!-- resources/views/admin/dashboard.blade.php -->
@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <!-- <h1>Admin Dashboard</h1> -->
        {{-- <div class="card"> --}}
            <div class="card-header p-1 mt-2 ">
               <h4 class="new-tackback"> 
                {{-- Translation --}}
                {{ __('message.translation') }}
            </h4> 
            </div>
            <div class="row">
                <div class="col-md-6 end">
                    <a class="btn btn-secondary create-store-btn-size" data-export-url="{{ route('admin.translations.export.sample.csv') }}" onclick="exportSampleCsv()"><i class="bi bi-download"></i> Download CSV </a>
                </div>
            </div>
            @if(session('success'))
            <div id="successMessage" class="alert alert-success">
                {{ session('success') }}
            </div>
            <script>
                setTimeout(function() {
                    document.getElementById('successMessage').style.display = 'none';
                }, 3000); // 3000 milliseconds = 3 seconds
            </script>
             @endif
            <form method="post" id="translationForm" enctype="multipart/form-data" action="{{ route('admin.translations.store') }}">
                @csrf
                <div class="card-body">
                    <div class="p-2">
                        <div class="row">
                             {{-- <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Dashboard</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Sorting</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Brand</button>
                                </li>
                            </ul>
                            <div class="tab-content mt-2" id="myTabContent">
                                <div class="tab-pane fade show active d-none" id="home" role="tabpanel" aria-labelledby="home-tasb">Common content for Home tab</div>
                                <div class="tab-pane fade d-none" id="profile" role="tabpanel" aria-labelledby="profile-tab">Common content for Profile tab</div>
                                <div class="tab-pane fade d-none" id="contact" role="tabpanel" aria-labelledby="contact-tab">Common content for Contact tab</div>
                            </div> --}}
                            <div class="col-md-3">
                                <label for="brand_id" class="form-label">Language</label>
                                <select class="form-select" value="{{ old('language') }}" name="language" aria-label="Default select example">
                                    {{-- <option value="">Select Language</option> --}}
                                    <option value="en" {{ old('language') == 'en' ? 'selected' : '' }}>English</option>
                                    <option value="fr" {{ old('language') == 'fr' ? 'selected' : '' }}>French</option>
                                    <option value="es" {{ old('language') == 'es' ? 'selected' : '' }}>Spanish</option>
                                    <option value="nl" {{ old('language') == 'nl' ? 'selected' : '' }}>Dutch</option>
                                    
                                    {{-- @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}" {{ isset($prevois_store_data['brand_id']) && $prevois_store_data['brand_id'] == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                    @endforeach --}}
                                </select>
                                @error('language')
                                    <span class="alert text-danger create-error-required-msg">{{ $message }}</span>
                                 @enderror
                            </div>
                        </div>
                    </div>
                    <div class="p-2">
                        <div class="row">
                             <div class="col-md-3">
                                <label for="exampleFormControlInput1"  class="form-label">Upload CSV File</label>
                                {{-- <input type="text" class="form-control" placeholder="Key" value="{{ old('key') }}"  name="key"> --}}
                                <input type="file" id="importCsvField" class="form-control" name="file" accept=".csv">
                                     {{-- <button type="submit">Import</button> --}}
                                @error('file')
                                <span class="alert text-danger create-error-required-msg">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- <div class="col-md-3">
                                <label for="exampleFormControlInput1"  class="form-label">Key</label>
                                <input type="text" class="form-control" placeholder="Key" value="{{ old('key') }}"  name="key">
                                 @error('key')
                                <span class="alert text-danger create-error-required-msg">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="exampleFormControlInput1"  class="form-label">Value</label>
                                <input type="text" class="form-control" placeholder="Value" value="{{ old('value') }}" name="value">
                                 @error('value')
                                    <span class="alert text-danger create-error-required-msg">{{ $message }}</span>
                                 @enderror
                            </div> --}}
                        </div>
                    </div>
            </div>
        {{-- </div> --}}
        <div class="p-4">
           <div class="row ">
            <div class="col-auto d-flex">
                <div class="me-2">
                    <a href="#" onclick="clearFormData()" class="btn btn-secondary create-store-btn-size" style="background-color: #ffffff; color: #000000;">
                        {{-- Cancel --}}
                        {{ __('message.cancel') }}
                    </a>
                </div>
                <button type="submit" class="btn btn-secondary create-store-btn-size">
                    {{-- Add New --}}
                    {{ __('message.add_new') }}
                </button>
            </div>
        </div>
        </div>
         </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/customTranslation.js') }}"></script>
@endpush

