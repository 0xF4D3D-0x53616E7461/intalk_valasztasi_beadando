<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partok;

class PartokController extends Controller
{
    public function index()
    {
        return Partok::all();
    }

    public function store(Request $request)
    {
        return Partok::create($request->all());
    }

    public function show($id)
    {
        return Partok::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $partok = Partok::findOrFail($id);
        $partok->update($request->all());

        return $partok;
    }

    public function destroy($id)
    {
        $partok = Partok::findOrFail($id);
        $partok->delete();

        return response(null, 204);
    }
}