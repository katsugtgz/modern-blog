<?php

namespace App\Http\Controllers;

use App\Models\FilterPreset;
use Illuminate\Http\Request;

class FilterPresetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filterPresets = auth()->user()->filterPresets()->orderBy('name')->get();
        
        return view('filter-presets.index', compact('filterPresets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('filter-presets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'categories' => ['nullable', 'array'],
            'tags' => ['nullable', 'array'],
            'date_range' => ['nullable', 'array'],
            'authors' => ['nullable', 'array'],
            'sort_by' => ['nullable', 'array'],
            'additional_filters' => ['nullable', 'array'],
        ]);
        
        auth()->user()->filterPresets()->create($validated);
        
        return redirect()->route('filter-presets.index')
            ->with('success', 'Filter preset created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(FilterPreset $filterPreset)
    {
        $this->authorize('view', $filterPreset);
        
        return view('filter-presets.show', compact('filterPreset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FilterPreset $filterPreset)
    {
        $this->authorize('update', $filterPreset);
        
        return view('filter-presets.edit', compact('filterPreset'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FilterPreset $filterPreset)
    {
        $this->authorize('update', $filterPreset);
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'categories' => ['nullable', 'array'],
            'tags' => ['nullable', 'array'],
            'date_range' => ['nullable', 'array'],
            'authors' => ['nullable', 'array'],
            'sort_by' => ['nullable', 'array'],
            'additional_filters' => ['nullable', 'array'],
        ]);
        
        $filterPreset->update($validated);
        
        return redirect()->route('filter-presets.index')
            ->with('success', 'Filter preset updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FilterPreset $filterPreset)
    {
        $this->authorize('delete', $filterPreset);
        
        $filterPreset->delete();
        
        return redirect()->route('filter-presets.index')
            ->with('success', 'Filter preset deleted successfully.');
    }
    
    /**
     * Apply a filter preset.
     */
    public function apply(FilterPreset $filterPreset)
    {
        $this->authorize('view', $filterPreset);
        
        $queryParams = [];
        
        if (!empty($filterPreset->categories)) {
            $queryParams['category'] = $filterPreset->categories;
        }
        
        if (!empty($filterPreset->tags)) {
            $queryParams['tag'] = $filterPreset->tags;
        }
        
        if (!empty($filterPreset->date_range)) {
            if (isset($filterPreset->date_range['from'])) {
                $queryParams['date_from'] = $filterPreset->date_range['from'];
            }
            
            if (isset($filterPreset->date_range['to'])) {
                $queryParams['date_to'] = $filterPreset->date_range['to'];
            }
        }
        
        if (!empty($filterPreset->authors)) {
            $queryParams['author'] = $filterPreset->authors;
        }
        
        if (!empty($filterPreset->sort_by)) {
            $queryParams['sort'] = $filterPreset->sort_by['field'] ?? 'latest';
        }
        
        if (!empty($filterPreset->additional_filters)) {
            $queryParams = array_merge($queryParams, $filterPreset->additional_filters);
        }
        
        return redirect()->route('posts.index', $queryParams);
    }
}
