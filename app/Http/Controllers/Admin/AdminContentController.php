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
     * Upload video for content
     */
    public function uploadVideo(Request $request)
    {
        $request->validate([
            'video' => 'required|mimes:mp4,webm,ogg|max:51200', // 50MB max
            'key' => 'required|string'
        ]);

        try {
            $file = $request->file('video');
            $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '_' . str_replace(' ', '_', $originalName) . '.' . $extension;
            
            // Create directory in public folder for videos
            $uploadPath = public_path('assets/videos/admin');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            // Full file path
            $fullPath = $uploadPath . '/' . $filename;
            
            if ($file->move($uploadPath, $filename)) {
                // Public accessible path
                $publicPath = '/assets/videos/admin/' . $filename;
                
                // Update content with new path
                SiteContent::setContent($request->key, $publicPath);

                return response()->json([
                    'success' => true,
                    'path' => $publicPath,
                    'filename' => $filename,
                    'message' => 'Video uploaded successfully!'
                ]);
            } else {
                throw new \Exception('Failed to move uploaded file');
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload video: ' . $e->getMessage()
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
            'video_content' => SiteContent::where('type', 'video')->count(),
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
            // Hero Section
            'hero_title' => 'Events Done Right',
            'hero_subtitle' => 'AO International Projects Management; (Advanced Orientation) brings years of experience in medical events to a wide range of industries — helping teams plan, manage, and deliver events that leave a mark.',
            'hero_cta_text' => 'See What We Do',
            'hero_cta_link' => '#about',
            'hero_video' => 'videos/hero.mp4',
            
            // Events Section
            'events_label' => 'Events',
            'events_title' => 'Our global events',
            'events_description_1' => 'We host invitation-only events at key climate moments as well as community and partner-led gatherings in cities around the world. These moments enable guests to learn from each other, explore deal flow and create connections, encouraging collaboration.',
            'events_description_2' => 'Trust is built in rooms, not virtual rooms. We put humanity back in the room.',
            'events_cta_text' => 'Get in touch',
            'events_image' => '/images/vfc.jpg',
            
            // About Section
            'about_title' => 'Who We Are',
            'about_description_1' => 'AO International Projects Management Co. is a full-service management company specialized in marketing strategy, business process optimization, planning conferences, exhibitions, seminars, health awareness campaigns, and professional events.',
            'about_description_2' => 'AO International Projects Management is a trusted provider of comprehensive medical writing, clinical research support, and data management services. With a commitment to precision, efficiency, and affordability, we collaborate with healthcare professionals, pharmaceutical companies, and KOLs to deliver impactful, evidence-based scientific content.',
            
            // Core Services Section
            'services_title' => 'Our Core Services',
            'service_1_title' => 'Medical Writing Services',
            'service_1_description' => 'Manuscript writing and editing, advisory board support and documentation, conference abstracts and posters, grant writing assistance.',
            'service_2_title' => 'Clinical Research Support',
            'service_2_description' => 'Protocol development, study documentation, investigator brochures, study proposals, protocols, CSR, SAR, SAP, and conference abstracts and presentations.',
            'service_3_title' => 'Data Management & Statistical Analysis',
            'service_3_description' => 'Comprehensive data management, statistical analysis, and reporting.',
            'service_4_title' => 'Medical Affairs Services & Training',
            'service_4_description' => 'Medical education workshops (CME), customized training programs for medical affairs professionals.',
            'service_5_title' => 'Infographic & Visual Solutions',
            'service_5_description' => 'Professional infographic creation to simplify complex medical data and graphical abstracts.',
            'service_6_title' => 'Publication Planning & Journal Compliance',
            'service_6_description' => 'Strategic publication plans, journal selection and compliance with editorial requirements, journal submission and follow-up.',
            'service_7_title' => 'Digital Solutions',
            'service_7_description' => 'Development of medical registries, decision support tools, patient education apps, collaborative platforms for multidisciplinary teams, mobile apps for preoperative assessment.',
            'service_8_title' => 'Conference & Event Support',
            'service_8_description' => 'Abstract booklets and proceedings, scientific coverage of key sessions, design of presentation materials (slides, posters, or reports).',
            
            // Why Choose Us Section
            'why_title' => 'Why Choose Us?',
            'why_image' => 'images/whyus.jpg',
            'why_point_1_title' => 'Unmatched Quality',
            'why_point_1_description' => 'Every project is handled with scientific precision and attention to detail.',
            'why_point_2_title' => 'Timely Delivery',
            'why_point_2_description' => 'We meet deadlines without compromise.',
            'why_point_3_title' => 'Cost-Effective Solutions',
            'why_point_3_description' => 'Affordability with zero compromise on quality.',
            
            // Clients Section
            'clients_title' => 'Our Clients',
            'clients_subtitle' => 'We are working with a range of incredible global partners including:',
            
            // Our Work Section
            'work_title' => 'Our Work',
            
            // Metrics Section
            'metrics_label' => 'Our Metrics + Impact',
            'metrics_title' => 'The following medical event outcomes have been established:',
            'metric_1_value' => '97',
            'metric_1_label' => 'Knowledge Retention',
            'metric_1_description' => 'of participants reported improved understanding of clinical procedures',
            'metric_2_value' => '98',
            'metric_2_label' => 'NPS Score',
            'metric_2_description' => 'A blended Net Promoter Score of 98 across international AO events',
            'metric_3_value' => '94',
            'metric_3_label' => 'Global Collaboration',
            'metric_3_description' => 'of attendees made a new global research or clinical connection',
            
            // Contact Section
            'contact_title' => 'Contact Us',
            'contact_subtitle' => 'Have questions or ideas? Reach out and let\'s connect!',
            'contact_cta_text' => 'Send Message',
        ];
    }
}