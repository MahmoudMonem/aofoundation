<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ClientLogo;
use Illuminate\Support\Facades\File;

class AdminClientLogoController extends Controller
{
    /**
     * Display client logos management page
     */
    public function index()
    {
        $row1Logos = ClientLogo::where('row', 1)->orderBy('sort_order')->get();
        $row2Logos = ClientLogo::where('row', 2)->orderBy('sort_order')->get();
        
        return view('admin.logos.index', compact('row1Logos', 'row2Logos'));
    }

    /**
     * Store a new client logo
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'row' => 'required|in:1,2',
        ]);

        try {
            $file = $request->file('logo');
            $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
            
            // Create directory if not exists
            $uploadPath = public_path('assets/img/clients');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Move file
            $file->move($uploadPath, $filename);
            $logoPath = 'assets/img/clients/' . $filename;

            // Get max sort order for the row
            $maxOrder = ClientLogo::where('row', $request->row)->max('sort_order') ?? 0;

            // Create record
            ClientLogo::create([
                'name' => $request->name,
                'logo' => $logoPath,
                'row' => $request->row,
                'sort_order' => $maxOrder + 1,
                'is_active' => true,
            ]);

            return back()->with('success', 'Client logo added successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to add logo: ' . $e->getMessage());
        }
    }

    /**
     * Update client logo
     */
    public function update(Request $request, ClientLogo $clientLogo)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'row' => 'required|in:1,2',
            'is_active' => 'boolean',
        ]);

        try {
            $data = [
                'name' => $request->name,
                'row' => $request->row,
                'is_active' => $request->has('is_active'),
            ];

            // Handle new logo upload
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $filename = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());
                
                $uploadPath = public_path('assets/img/clients');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true);
                }

                // Delete old logo
                $oldPath = public_path($clientLogo->logo);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }

                // Upload new logo
                $file->move($uploadPath, $filename);
                $data['logo'] = 'assets/img/clients/' . $filename;
            }

            $clientLogo->update($data);

            return back()->with('success', 'Client logo updated successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update logo: ' . $e->getMessage());
        }
    }

    /**
     * Delete client logo
     */
    public function destroy(ClientLogo $clientLogo)
    {
        try {
            // Delete file
            $filePath = public_path($clientLogo->logo);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }

            $clientLogo->delete();

            return back()->with('success', 'Client logo deleted successfully!');

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete logo: ' . $e->getMessage());
        }
    }

    /**
     * Update sort order via AJAX
     */
    public function updateOrder(Request $request)
    {
        $request->validate([
            'logos' => 'required|array',
            'logos.*.id' => 'required|exists:client_logos,id',
            'logos.*.sort_order' => 'required|integer',
        ]);

        try {
            foreach ($request->logos as $item) {
                ClientLogo::where('id', $item['id'])->update([
                    'sort_order' => $item['sort_order']
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Order updated successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update order: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle logo active status
     */
    public function toggleActive(ClientLogo $clientLogo)
    {
        $clientLogo->update([
            'is_active' => !$clientLogo->is_active
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $clientLogo->is_active,
            'message' => $clientLogo->is_active ? 'Logo activated!' : 'Logo deactivated!'
        ]);
    }
}