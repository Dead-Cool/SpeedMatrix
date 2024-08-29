@include('layouts.header')

<table class="table table-striped table-inverse table-responsive">
    <thead class="thead-inverse">
        <tr class="container">
            <th class="pl-4">Image</th>
            <th>Car</th>
            <th>Model</th>
            <th>Title</th>
            <th>Description</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
            <tr class="container">
                <td class="col-1"><img src="{{asset('storage/photos/products/' . $product->photo)}} " alt="" class="rounded-circle" height="100px" width="100px"> </td>
                <td class="col-1">{{ isset($product->car) ? $product->car->name : 'N/A' }}</td>
                <td class="col-1">{{isset($product->model) ? $product->model->model : 'N/A'}} </td>
                <td class="col-2">{{$product->title}} </td>
                <td class="col-4">{{$product->description}} </td>
                <td class="col-1">{{$product->price}} </td>
                <td class="col-1">
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">
                            <i class="fa fa-trash"></i>
                        </button>
                    </form>
                
                    <a class="btn btn-primary" href="{{route('products.edit', ['product' => $product->id])}}" role="button"><i class="fa fa-pencil"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
</table>
@include('layouts.footer')