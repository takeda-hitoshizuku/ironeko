<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\AdoptionEvent;
use App\Models\ActivityPost;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $recentCats = Cat::where('status', 'available')
            ->latest()
            ->take(6)
            ->get();

        $upcomingEvents = AdoptionEvent::where('status', 'scheduled')
            ->where('event_date', '>=', now())
            ->where('is_published', true)
            ->orderBy('event_date')
            ->take(3)
            ->get();

        $recentPosts = ActivityPost::where('is_published', true)
            ->latest('post_date')
            ->take(3)
            ->get();

        return view('front.index', compact('recentCats', 'upcomingEvents', 'recentPosts'));
    }

    public function cats()
    {
        $cats = Cat::whereIn('status', ['available', 'reserved'])
            ->latest()
            ->get();

        return view('front.cats', compact('cats'));
    }

    public function catDetail(Cat $cat)
    {
        return view('front.cat-detail', compact('cat'));
    }

    public function events()
    {
        $events = AdoptionEvent::where('status', 'scheduled')
            ->where('event_date', '>=', now())
            ->where('is_published', true)
            ->orderBy('event_date')
            ->get();

        return view('front.events', compact('events'));
    }

    public function activity()
    {
        $posts = ActivityPost::where('is_published', true)
            ->latest('post_date')
            ->paginate(10);

        return view('front.activity', compact('posts'));
    }

    public function contact()
    {
        return view('front.contact');
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|max:255',
            'subject' => 'nullable|max:255',
            'message' => 'required',
            'category' => 'required|in:adoption,volunteer,donation,other',
        ]);

        Inquiry::create($validated);

        return redirect()->route('contact')->with('success', 'お問い合わせありがとうございます。内容を確認次第、ご連絡させていただきます。');
    }
    public function privacy()
    {
        return view('front.privacy');
    }
}
