@include('layouts.header')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif        

<h1 class="text-center">{{ $title }} </h1>

@if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container">
    <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif
        <div class="container mb-3">
            <div class="row">
                <!-- Image Card Column -->
                <div class="col-lg-4">
                    <label class="font-weight-bold" for=""><i class="fa fa-image"></i> Add Photo</label>
                    <div class="card">
                        <div style="height: 190px; width: 100%;">
                            @if (isset($product) && $product->photo)
                                <img src="{{asset('storage/photos/products/' . $product->photo)}}" id="preview" style="height: 100%; width: 100%;" alt="{{$product->title}}">
                            @else
                                <img src="" id="preview" style="display: none" height="100%" width="100%">
                            @endif
                        </div>
                        <div class="">
                            <input type="file" class="form-control" name="photo" id="photo" accept="image/*">
                            @error('photo')
                            <font color="red"><small>{{ $message }}</small></font>
                            @enderror
                        </div>
                    </div>
                </div>
        
                <!-- Dropdowns Column -->
                <div class="col-lg-8">
                    <div class="form-group">
                        <label for="car" class="font-weight-bold"><i class="fa fa-car"></i> Car</label>
                        <select class="form-control" name="car_id" id="car">
                            <option value="" disabled selected>Select Car</option>
                            @foreach($cars as $car)
                                <option value="{{ $car->id }}" {{ isset($product) && $product->car_id == $car->id ? 'selected' : '' }}>{{ $car->name }}</option>
                            @endforeach
                        </select>

                        @error('car_id')
                            <div class="text-danger"><small>{{ $message }}</small></div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="model" class="font-weight-bold"><i class="fa fa-gears"></i> Model</label>
                        <select class="form-control" name="model_id" id="model">
                            <option value="" disabled selected>Select Model</option>
                            <!-- Models will be populated here dynamically -->
                        </select>
                        @error('model_id')
                            <div class="text-danger"><small>{{ $message }}</small></div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label for="title" class="font-weight-bold"><i class="fa fa-pencil"></i> Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{$product->title ?? ''}}">
        </div>
        
        <div class="form-group">
            <label for="description" class="font-weight-bold"><i class="fa fa-list"></i> Description</label>
            <textarea name="description" id="description" class="form-control">{{$product->description ?? ''}}</textarea>
        </div>
        
        <div class="form-group">
            <label for="price" class="font-weight-bold"><i class="fa fa-dollar-sign"></i> Price</label>
            <input type="text" name="price" id="price" placeholder="Add Price" class="form-control"  value="{{$product->price ?? ''}}">
        </div>
        
        <button type="submit" class="btn btn-outline-dark mb-5"><i class="fa fa-save"></i> {{isset($product) ? ' Update' : ' Save'}}</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        // Get initial model ID if available
        var initialModelId = '{{ isset($product) ? $product->model_id : '' }}';
        
        $('#car').change(function() {
            var carId = $(this).val();
            var modelSelect = $('#model');
    
            // Clear existing options
            modelSelect.html('<option value="" disabled selected>Select Model</option>');
    
            if (carId) {
                $.ajax({
                    url: '/get-models/' + carId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $.each(data.models, function(index, model) {
                            modelSelect.append('<option value="' + model.id + '">' + model.model + '</option>');
                        });
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr.responseText);
                    }
                });
            }
        });
    
        // Initialize the models dropdown if a car is pre-selected
        var initialCarId = $('#car').val();
        if (initialCarId) {
            $.ajax({
                url: '/get-models/' + initialCarId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var modelSelect = $('#model');
                    modelSelect.html('<option value="" disabled selected>Select Model</option>');
                    $.each(data.models, function(index, model) {
                        modelSelect.append('<option value="' + model.id + '">' + model.model + '</option>');
                    });
    
                    // Set initial model value if available
                    if (initialModelId) {
                        modelSelect.val(initialModelId);
                    }
                },
                error: function(xhr) {
                    console.log('Error:', xhr.responseText);
                }
            });
        }
    
        // Function to preview the selected image
        function previewImage() {
            const fileInput = document.getElementById('photo');
            const preview = document.getElementById('preview');
    
            fileInput.addEventListener('change', function() {
                const file = fileInput.files[0];
                
                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    
                    reader.onload = function(event) {
                        preview.src = event.target.result;
                        preview.style.display = 'block'; // Show the preview
                    };
                    
                    reader.readAsDataURL(file);
                } else {
                    preview.src = '';
                    preview.style.display = 'none'; // Hide the preview if no image or non-image file
                }
            });
        }
    
        previewImage(); // Initialize the previewImage function
    });
</script>