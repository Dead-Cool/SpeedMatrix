@include('layouts.header')
    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <i class="fa fa-plus-circle"></i> Add Cars
            </div>

            <form action="{{ isset($car) ? route('car.update', $car->id) : route('car.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="name"><i class="fa fa-car"></i> Car Name</label>
                        <input class="form-control" type="text" value="{{ $car->name ?? ''}}" placeholder="Enter Car Name" name="name" id="name">
                        @error('name')
                            <div class="text-danger"><small>{{ $message }}</small></div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i>{{isset($car) ? ' Update' : ' Save'}}
                    </button>
                </div>
            </form>

            <div class="card mt-3">
                <div class="card-header">
                    <i class="fa fa-list"></i> Car List
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th><i class="fa fa-car"></i> Car Name</th>
                                <th><i class="fa fa-cog"></i> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cars as $car)
                                <tr>
                                    <td>{{ $car->name }}</td>
                                    <td>
                                        <a class="btn btn-primary btn-sm" href="{{route('car.edit', ['id' => $car->id])}}" role="button">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="{{ route('car.delete', ['id' => $car->id]) }}" role="button">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
