<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $messages = Message::when($search, function($query, $search) {
                $query->where('name', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%")
                      ->orWhere('message', 'like', "%$search%");
            })
            ->latest()
            ->paginate(30);

        return view('admin.messages.index', compact('messages', 'search'));
    }

    public function create()
    {
        return view('admin.messages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        Message::create($data);

        return redirect()->route('admin.messages.index')->with('success', 'Message created successfully.');
    }

    public function edit(Message $message)
    {
        return view('admin.messages.edit', compact('message'));
    }


        public function singleMessage(Message $message)
    {
        return view('admin.messages.singlemessage', compact('message'));
    }


    public function update(Request $request, Message $message)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'message' => 'required|string',
        ]);

        $message->update($data);

        return redirect()->route('admin.messages.index')->with('success', 'Message updated successfully.');
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'Message deleted successfully.');
    }
}
