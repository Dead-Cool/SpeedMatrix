<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Models;
use App\Models\Cars;

class ModelController extends Controller
{
    public function index () 
    {
        $models = Models::all();
        $cars = Cars::orderby('id')->get();
        return view ('model', compact('cars', 'models'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'model' => 'required|string|max:25',
        ]);
    
        Models::create($validatedData);
    
        return redirect()->route ('model.index')->with('success', 'Car Model added successfully!');
    }

    public function edit($id)
    {
        $models = Models::all();
        $cars = Cars::orderby('id')->get();
        $model = Models::findOrFail($id);

        if(is_null($model)){
            return redirect ('/models');
        } else {
            return view ('model', compact ('model', 'models', 'cars'));
        }
    }
    
    public function delete($id)
    {
        $model = Models::findOrFail($id);
        $model->delete();
        return redirect()->route ('model.index')->with('success', 'Car Model deleted successfully!');
    }    
    
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'model' => 'required|string|max:25',
        ]);
    
        $model = Models::findOrFail($id);
        $model->update($validatedData);
    
        return redirect()->route ('model.index')->with('success', 'Car Model updated successfully!');
    }
        
    public function getModelsByCar(Request $request)
    {
        $models = Models::where('car_id', $request->car_id)->get();
        return response()->json(['models' => $models]);
    }

}
