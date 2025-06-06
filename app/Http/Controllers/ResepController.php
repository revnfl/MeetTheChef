<?php

namespace App\Http\Controllers;

use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ResepController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $reseps = Resep::latest()->get();
        return view('reseps.index', compact('reseps'));
    }

    public function create()
    {
        return view('reseps.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'masakan' => 'required',
            'bahan' => 'required',
            'langkah' => 'required',
        ]);

        Resep::create([
            'masakan' => $request->masakan,
            'bahan' => $request->bahan,
            'langkah' => $request->langkah,
            'user_id' => Auth::id() ?? "",
        ]);

        return redirect()->route('reseps.index');
    }

    public function show(Resep $resep)
    {
        return view('reseps.show', compact('resep'));
    }

    public function edit(Resep $resep)
    {
        return view('reseps.edit', compact('resep'));
    }

    public function update(Request $request, Resep $resep)
    {
        $request->validate([
            'masakan' => 'required',
            'bahan' => 'required',
            'langkah' => 'required',
        ]);

        $resep->update($request->only(['masakan', 'bahan', 'langkah']));
        return redirect()->route('reseps.index');
    }

    public function destroy(Resep $resep)
    {
        $resep->delete();
        return redirect()->route('reseps.index');
    }
}
