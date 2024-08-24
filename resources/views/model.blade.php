@include('layouts.header')
    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <i class="fa fa-plus-circle"></i> Add Model
            </div>
            <form action="{{ isset($model) ? route('model.update', $model->id) : route('model.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="car_id" class="font-weight-bold"><i class="fa fa-car"></i> Car</label>
                        <select class="form-control" name="car_id" id="car_id">
                            <option value="" disabled selected>Select Car</option>
                            @foreach($cars as $car)
                                <option value="{{ $car->id }}" {{ (isset($model) && $model->car_id == $car->id) ? 'selected' : '' }}>
                                    {{ $car->name }}
                                </option>
                            @endforeach
                        </select>
                        
                        @error('car_id')
                            <div class="text-danger"><small>{{ $message }}</small></div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="model" class="font-weight-bold"><i class="fa fa-screwdriver-wrench"></i> Model</label>
                        <input type="text" class="form-control" name="model" id="model" value="{{ $model->model ?? ''}}">
                        @error('model')
                            <div class="text-danger"><small>{{ $message }}</small></div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="fa fa-save"></i> {{isset($model) ? ' Update' : ' Save'}}
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
                                <th><i class="fa fa-car"></i> Car</th>
                                <th><i class="fa fa-screwdriver-wrench"></i> Model</th>
                                <th><i class="fa fa-cog"></i> Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tbody>
                                @foreach($models as $model)
                                    <tr>
                                        <td>{{ $model->car->name }}</td>
                                        <td>{{ $model->model }}</td>
                                        <td>
                                            <a class="btn btn-primary btn-sm" href="{{ route('model.edit', $model->id) }}" role="button">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <a class="btn btn-danger btn-sm" href="{{ route('model.delete', $model->id) }}" role="button">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
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
