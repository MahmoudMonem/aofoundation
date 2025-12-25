<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteContent;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class AdminContentController extends Controller
{
    /**
     * Display content management page
     */
    public function index()
    {
        $contents = SiteContent::getContentBySection();
        return view('admin.content.index', compact('contents'));
    }

    /**
     * Update site content
     */
    public function update(Request $request)
    {
        $request->validate([
            'contents' => 'required|array',
            'contents.*' => 'nullable|string|max:10000'
        ]);

        $updatedCount = 0;

        foreach ($request->contents as $key => $value) {
            SiteContent::setContent($key, $value);
            $updatedCount++;
        }

        return back()->with('success', "Successfully updated {$updatedCount} content items!");
    }

    /**
     * Upload image for content - saves directly to public folder
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120', // 5MB max
            'key' => 'required|string'
        ]);

        try {
            $file = $request->file('image');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . str_replace(' ', '_', $originalName) . '.' . $extension;
            
            // Create directory in public folder for homepage content
            $uploadPath = public_path('assets/img/admin/homepage');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Full file path
            $fullPath = $uploadPath . '/' . $filename;
            
            // Move and process the image
            if ($file->move($uploadPath, $filename)) {
                // Optimize image if intervention/image is available
                if (class_exists('\Intervention\Image\Facades\Image')) {
                    try {
                        $image = Image::make($fullPath);
                        
                        // Resize if too large (max 1920px width)
                        if ($image->width() > 1920) {
                            $image->resize(1920, null, function ($constraint) {
                                $constraint->aspectRatio();
                                $constraint->upsize();
                            });
                        }
                        
                        // Compress and save
                        $image->save($fullPath, 85);
                        
                    } catch (\Exception $imageError) {
                        // Image optimization failed but file uploaded successfully
                        \Log::warning('Image optimization failed: ' . $imageError->getMessage());
                    }
                }

                // Public accessible path
                $publicPath = '/assets/img/admin/homepage/' . $filename;
                
                // Update content with new path
                SiteContent::setContent($request->key, $publicPath);

                return response()->json([
                    'success' => true,
                    'path' => $publicPath,
                    'filename' => $filename,
                    'message' => 'Image uploaded successfully!'
                ]);
            } else {
                throw new \Exception('Failed to move uploaded file');
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload image: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete uploaded image
     */
    public function deleteImage(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'path' => 'required|string'
        ]);

        try {
            // Get the content item
            $content = SiteContent::where('key', $request->key)->first();
            
            if (!$content) {
                return response()->json([
                    'success' => false,
                    'message' => 'Content item not found'
                ], 404);
            }

            // Remove the file from public directory
            $fullPath = public_path($request->path);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }

            // Reset content to empty
            SiteContent::setContent($request->key, '');

            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete image: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get content statistics
     */
    public function getStats()
    {
        $stats = [
            'total_content' => SiteContent::count(),
            'sections' => SiteContent::distinct('section')->count('section'),
            'image_content' => SiteContent::where('type', 'image')->count(),
            'text_content' => SiteContent::whereIn('type', ['text', 'textarea'])->count(),
            'recent_updates' => SiteContent::where('updated_at', '>=', now()->subDays(7))->count()
        ];

        return response()->json($stats);
    }

    /**
     * Preview content changes
     */
    public function previewContent(Request $request)
    {
        $request->validate([
            'contents' => 'required|array'
        ]);

        $previewData = [];
        
        foreach ($request->contents as $key => $value) {
            $content = SiteContent::where('key', $key)->first();
            if ($content) {
                $previewData[$key] = [
                    'label' => $content->label,
                    'section' => $content->section,
                    'type' => $content->type,
                    'current_value' => $content->value,
                    'new_value' => $value,
                    'changed' => $content->value !== $value
                ];
            }
        }

        return response()->json([
            'success' => true,
            'preview' => $previewData
        ]);
    }

    /**
     * Reset content section to defaults
     */
    public function resetSection(Request $request)
    {
        $request->validate([
            'section' => 'required|string'
        ]);

        try {
            // Get default values (you might want to create a config file for these)
            $defaults = $this->getDefaultContentValues();
            
            $resetCount = 0;
            $contentItems = SiteContent::where('section', $request->section)->get();

            foreach ($contentItems as $content) {
                if (isset($defaults[$content->key])) {
                    $content->update(['value' => $defaults[$content->key]]);
                    $resetCount++;
                }
            }

            return back()->with('success', "Reset {$resetCount} items in '{$request->section}' section to defaults!");

        } catch (\Exception $e) {
            return back()->with('error', 'Failed to reset section: ' . $e->getMessage());
        }
    }

    /**
     * Get default content values for reset functionality
     */
    private function getDefaultContentValues()
    {
        return [
            'hero_welcome_title' => 'Welcome to',
            'hero_logo' => '/assets/img/logos/logo-white-nomargin.png',
            'hero_subtitle' => "The GCC's premier hospitality group<br>where culinary dreams come to life!",
            'hero_video' => '/assets/videos/hero-section.mp4',
            'about_description' => 'We are passionate about crafting unforgettable dining experiences through our vibrant array of food and beverage brands.',
            'about_highlight' => 'brings people together into one big social gathering!',
            'about_closing' => 'Join us on this exciting journey as we redefine hospitality across the GCC, one delicious bite at a time!',
            'about_scroll_image' => '/assets/img/scroll222.png',
            'who_we_are_title' => 'Who We Are?',
            'who_we_are_description' => 'SocialEats is driven by a vision to be the GCC\'s top hospitality group. We achieve this by developing and managing unique F&B concepts, committed to delivering amazing and evolving dining experiences for every guest.',
            'who_we_are_background' => '/assets/img/center4.jpg',
            'expertise_title' => 'Our Expertise',
            'expertise_description' => 'At SocialEats, our expertise lies in our comprehensive approach to creating, developing, and managing successful F&B concepts. We blend Culinary Innovation with meticulous Menu R&D and robust Brand Strategy and Development to bring extraordinary dining experiences to life.',
            'contact_title' => 'Let\'s Get in Touch',
            'contact_franchise_email' => 'franchise@socialeats.com',
            'contact_info_email' => 'info@socialeats.com'
        ];
    }
}