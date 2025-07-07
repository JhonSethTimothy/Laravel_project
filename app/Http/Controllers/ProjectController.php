<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectSite;
use App\Models\SiteItem;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('sites.items')->get();
        return view('progress_report', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'project_name' => 'required|string|max:255',
            'sites' => 'required|array|min:1',
            'sites.*.name' => 'required|string|max:255',
            'sites.*.items' => 'required|array|min:1',
            'sites.*.items.*.name' => 'required|string|max:255',
            'sites.*.items.*.quantity' => 'required|integer|min:0',
        ]);

        // Create the project
        $project = Project::create([
            'project_name' => $request->project_name,
        ]);

        // Create sites and items
        foreach ($request->sites as $siteData) {
            $site = $project->sites()->create([
                'name' => $siteData['name'],
            ]);

            foreach ($siteData['items'] as $itemData) {
                $site->items()->create([
                    'name' => $itemData['name'],
                    'quantity' => $itemData['quantity'],
                ]);
            }
        }

        return redirect()->route('progress.report')->with('success', 'Project added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load('sites.items');
        $data = $project->toArray();
        // Add fiber_used for each site
        foreach ($data['sites'] as $i => $site) {
            $data['sites'][$i]['fiber_used'] = $project->sites[$i]->fiber_used ?? 0;
        }
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        try {
            $project->delete();
            return response()->json(['success' => true, 'message' => 'Project deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting project'], 500);
        }
    }

    /**
     * Update the current quantity of a site item.
     */
    public function updateItemQuantity(Request $request, SiteItem $item)
    {
        Log::info('updateItemQuantity called', [
            'item_id' => $item->id,
            'request_data' => $request->all(),
        ]);

        try {
            $request->validate([
                'current_quantity' => 'required|integer|min:0|max:' . $item->quantity,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', [
                'errors' => $e->errors(),
            ]);
            return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $e->errors()], 422);
        }

        try {
            $item->update([
                'current_quantity' => $request->current_quantity,
            ]);
            Log::info('Quantity updated', [
                'item_id' => $item->id,
                'current_quantity' => $request->current_quantity,
            ]);
            return response()->json(['success' => true, 'message' => 'Quantity updated successfully']);
        } catch (\Exception $e) {
            Log::error('Exception updating quantity', [
                'error' => $e->getMessage(),
            ]);
            return response()->json(['success' => false, 'message' => 'Error updating quantity', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the fiber used value for a project site.
     */
    public function updateSiteFiberUsed(Request $request, ProjectSite $site)
    {
        try {
            $request->validate([
                'fiber_used' => 'required|integer|min:0',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['success' => false, 'message' => 'Validation failed', 'errors' => $e->errors()], 422);
        }

        try {
            $site->fiber_used = $request->fiber_used;
            $site->save();
            return response()->json(['success' => true, 'message' => 'Fiber used updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating fiber used', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Add a new site (with items) to a project.
     */
    public function addSite(Request $request, Project $project)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'items' => 'required|array',
            'items.*.name' => 'required|string|max:255',
            'items.*.quantity' => 'required|integer|min:1',
        ]);
        $site = $project->sites()->create(['name' => $request->site_name]);
        foreach ($request->items as $item) {
            $site->items()->create([
                'name' => $item['name'],
                'quantity' => $item['quantity'],
                'current_quantity' => 0,
            ]);
        }
        $project->load('sites.items');
        return response()->json($project);
    }

    /**
     * Add a new item to an existing site.
     */
    public function addItem(Request $request, ProjectSite $site)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);
        $site->items()->create([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'current_quantity' => 0,
        ]);
        $site->load('items');
        return response()->json($site);
    }
}
