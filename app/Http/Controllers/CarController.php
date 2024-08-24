<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cars;

class CarController extends Controller
{
    public function index()
    {
        $cars = Cars::all();
        return view('car', compact('cars'));
    }

    public function store (Request $request) 
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:25',
        ]);

        $cars = Cars::create($validatedData);

        return redirect('/cars')->with('success', 'Car added successfully!');
    }

    public function delete($id)
    {
        $car = Cars::findOrFail($id);
        $car->delete();
        return redirect('/cars')->with('success', 'Car deleted successfully!');
    }

    public function edit($id)
    {
        $cars = Cars::all();
        $car = Cars::findOrfail($id);
        if(is_null($car)){
            return redirect ('/cars');
        } else {
            return view ('car', compact ('car', 'cars'));
        }
    }
    
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:25',
        ]);

        $cars = Cars::findOrfail($id);
        $cars->update($validatedData);
        return redirect('/cars')->with('success', 'Car updated successfully!');
    }
}
