<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query();

        // Recherche multi-critères
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%");
            });
        }

        // Filtre par type
        if ($request->filled('type') && in_array($request->type, ['lost', 'found'])) {
            $query->where('type', $request->type);
        }

        // Filtre par catégorie
        if ($request->filled('category') && in_array($request->category, [
            'electronique', 'vetements', 'accessoires', 'documents', 'autres'
        ])) {
            $query->where('category', $request->category);
        }

        // Filtre par date
        if ($request->filled('date')) {
            $query->whereDate('found_date', $request->date);
        }

        // Tri des résultats
        $sort = $request->get('sort', 'recent');
        switch ($sort) {
            case 'recent':
                $query->latest();
                break;
            case 'old':
                $query->oldest();
                break;
            case 'date_asc':
                $query->orderBy('found_date', 'asc');
                break;
            case 'date_desc':
                $query->orderBy('found_date', 'desc');
                break;
        }

        $items = $query->paginate(12)->appends(request()->query());

        return view('items.index', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:lost,found',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'found_date' => 'nullable|date',
            'category' => 'required|in:electronique,vetements,accessoires,documents,autres',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('items', 'public');
        }

        Item::create($validated);

        return redirect()->route('items.index')
            ->with('success', 'Objet ajouté avec succès.');
    }

    public function show($id)
    {
        $item = Item::findOrFail($id);
        return view('items.show', compact('item'));
    }
}
