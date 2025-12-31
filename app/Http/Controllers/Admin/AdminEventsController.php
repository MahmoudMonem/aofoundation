<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Eventimage;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with('eventimages')->latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $organizers = Organizer::all();
           return view('admin.events.create', compact('organizers'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            'short_desc_en' => 'nullable|string|max:500',
            'short_desc_ar' => 'nullable|string|max:500',
            'desc_en' => 'nullable|string',
            'desc_ar' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'featured' => 'nullable|boolean',
            'available' => 'nullable|boolean',
            'organizer_id' => 'nullable|integer',
            'event_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'featured_image_index' => 'nullable|integer',
            

        ]);
        $validated['organizer_id'] = $validated['organizer_id'] ?? 1;

        // Generate slug from English title
        $validated['slug'] = Str::slug($validated['title_en']);
        
        // Handle checkbox values
        $validated['featured'] = $request->has('featured') ? 1 : 0;
        $validated['available'] = $request->has('available') ? 1 : 0;

        // Handle cover image upload
        if ($request->hasFile('cover')) {
            $coverFile = $request->file('cover');
            $coverName = time() . '_cover_' . $coverFile->getClientOriginalName();
            $coverFile->move(public_path('events'), $coverName);
            $validated['cover'] = $coverName;
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
            $logoName = time() . '_logo_' . $logoFile->getClientOriginalName();
            $logoFile->move(public_path('events'), $logoName);
            $validated['logo'] = $logoName;
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailName = time() . '_thumbnail_' . $thumbnailFile->getClientOriginalName();
            $thumbnailFile->move(public_path('events'), $thumbnailName);
            $validated['thumbnail'] = $thumbnailName;
        }

        // Create the event
        $event = Event::create($validated);

        // Handle multiple event images
        if ($request->hasFile('event_images')) {

        foreach ($request->file('event_images') as $index => $image) {
        $imageName = time() . '_' . $index . '_' . $image->getClientOriginalName();
        $image->move(public_path('events'), $imageName);

        Eventimage::create([
            
        'event_id' => $event->id,
        'img' => $imageName,
        'featured' => $index === 0 ? 1 : 0, // 👈 ONLY FIRST IMAGE
        'available' => 1,
        ]);
}
        }

        return redirect()->route('admin.events.index')
            ->with('success', 'Event created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event->load('eventimages');
        return view('admin.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $event->load('eventimages');
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            'short_desc_en' => 'nullable|string|max:500',
            'short_desc_ar' => 'nullable|string|max:500',
            'desc_en' => 'nullable|string',
            'desc_ar' => 'nullable|string',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'featured' => 'nullable|boolean',
            'available' => 'nullable|boolean',
            'organizer_id' => 'nullable|integer',
            'event_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'featured_image_id' => 'nullable|integer',
            'delete_images' => 'nullable|array',
        ]);

        // Generate slug from English title
        $validated['slug'] = Str::slug($validated['title_en']);
        
        // Handle checkbox values
        $validated['featured'] = $request->has('featured') ? 1 : 0;
        $validated['available'] = $request->has('available') ? 1 : 0;

        // Handle cover image upload
        if ($request->hasFile('cover')) {
            // Delete old cover if exists
            if ($event->cover && file_exists(public_path('events/' . $event->cover))) {
                unlink(public_path('events/' . $event->cover));
            }
            $coverFile = $request->file('cover');
            $coverName = time() . '_cover_' . $coverFile->getClientOriginalName();
            $coverFile->move(public_path('events'), $coverName);
            $validated['cover'] = $coverName;
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            if ($event->logo && file_exists(public_path('events/' . $event->logo))) {
                unlink(public_path('events/' . $event->logo));
            }
            $logoFile = $request->file('logo');
            $logoName = time() . '_logo_' . $logoFile->getClientOriginalName();
            $logoFile->move(public_path('events'), $logoName);
            $validated['logo'] = $logoName;
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            if ($event->thumbnail && file_exists(public_path('events/' . $event->thumbnail))) {
                unlink(public_path('events/' . $event->thumbnail));
            }
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailName = time() . '_thumbnail_' . $thumbnailFile->getClientOriginalName();
            $thumbnailFile->move(public_path('events'), $thumbnailName);
            $validated['thumbnail'] = $thumbnailName;
        }

        // Remove image-related keys before updating event
        unset($validated['event_images'], $validated['featured_image_id'], $validated['delete_images']);

        // Update the event
        $event->update($validated);

        // Handle image deletions
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $eventImage = Eventimage::find($imageId);
                if ($eventImage) {
                    if (file_exists(public_path('events/' . $eventImage->img))) {
                        unlink(public_path('events/' . $eventImage->img));
                    }
                    $eventImage->delete();
                }
            }
        }

        // Handle featured image update
        if ($request->has('featured_image_id')) {
            // Reset all images to non-featured
            $event->eventimages()->update(['featured' => 0]);
            // Set the selected image as featured
            Eventimage::where('id', $request->featured_image_id)->update(['featured' => 1]);
        }

        // Handle new event images
        if ($request->hasFile('event_images')) {
            foreach ($request->file('event_images') as $index => $image) {
                $imageName = time() . '_' . $index . '_' . $image->getClientOriginalName();
                $image->move(public_path('events'), $imageName);
                
                Eventimage::create([
                    'event_id' => $event->id,
                    'img' => $imageName,
                    'featured' => 0,
                    'available' => 1,
                ]);
            }
        }

        return redirect()->route('admin.events.index')
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        // Delete cover, logo, thumbnail
        if ($event->cover && file_exists(public_path('events/' . $event->cover))) {
            unlink(public_path('events/' . $event->cover));
        }
        if ($event->logo && file_exists(public_path('events/' . $event->logo))) {
            unlink(public_path('events/' . $event->logo));
        }
        if ($event->thumbnail && file_exists(public_path('events/' . $event->thumbnail))) {
            unlink(public_path('events/' . $event->thumbnail));
        }

        // Delete all event images
        foreach ($event->eventimages as $eventImage) {
            if (file_exists(public_path('events/' . $eventImage->img))) {
                unlink(public_path('events/' . $eventImage->img));
            }
            $eventImage->delete();
        }

        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Event deleted successfully.');
    }

    /**
     * Toggle event availability
     */
    public function toggleAvailable(Event $event)
    {
        $event->update(['available' => !$event->available]);
        
        return redirect()->back()
            ->with('success', 'Event availability updated.');
    }

    /**
     * Toggle event featured status
     */
    public function toggleFeatured(Event $event)
    {
        $event->update(['featured' => !$event->featured]);
        
        return redirect()->back()
            ->with('success', 'Event featured status updated.');
    }
}