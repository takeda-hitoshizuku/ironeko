<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\AdoptionEvent;
use App\Models\ActivityPost;
use App\Models\Inquiry;
use App\Models\Article;
use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FrontController extends Controller
{
    // ========================================
    // トップページ
    // ========================================
    public function index()
    {
        $recentCats = Cat::where('status', 'available')
            ->latest()
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

    // ========================================
    // 団体情報
    // ========================================

    // 私たちについて
    public function about()
    {
        return view('front.about');
    }

    // 譲渡金/寄付金について
    public function support()
    {
        return view('front.support');
    }

    // ========================================
    // 保護猫
    // ========================================

    // 保護猫一覧
    public function cats()
    {
        $cats = Cat::whereIn('status', ['available', 'reserved'])
            ->latest()
            ->get();

        return view('front.cats', compact('cats'));
    }

    // 保護猫詳細
    public function catDetail(Cat $cat)
    {
        return view('front.cat-detail', compact('cat'));
    }

    // ========================================
    // 譲渡会
    // ========================================

    // 譲渡会一覧
    public function events()
    {
        $events = AdoptionEvent::where('status', 'scheduled')
            ->where('event_date', '>=', now())
            ->where('is_published', true)
            ->orderBy('event_date')
            ->get();

        return view('front.events', compact('events'));
    }

    // ========================================
    // 譲渡条件
    // ========================================

    public function requirements()
    {
        return view('front.requirements');
    }

    // ========================================
    // 活動報告
    // ========================================

    public function activity()
    {
        $posts = ActivityPost::where('is_published', true)
            ->latest('post_date')
            ->paginate(10);

        return view('front.activity', compact('posts'));
    }

    // ========================================
    // 記事（お役立ち情報）
    // ========================================

    // 記事一覧
    public function articles(Request $request)
    {
        $category = $request->get('category');

        $articles = Article::where('is_published', true)
            ->when($category, fn($q) => $q->where('category', $category))
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        $categories = Article::getCategoryOptions();

        return view('front.articles', compact('articles', 'categories', 'category'));
    }

    // 記事詳細
    public function articleDetail(Article $article)
    {
        // 非公開の記事は表示しない
        if (!$article->is_published) {
            abort(404);
        }

        // 関連記事を取得
        $relatedArticles = Article::where('is_published', true)
            ->where('category', $article->category)
            ->where('id', '!=', $article->id)
            ->limit(3)
            ->get();

        return view('front.article-detail', compact('article', 'relatedArticles'));
    }

    // ========================================
    // お問い合わせ
    // ========================================

    // お問い合わせフォーム表示
    public function contact(Request $request)
    {
        $catId = $request->get('cat_id');
        $catName = $request->get('cat_name');

        return view('front.contact', compact('catId', 'catName'));
    }

    // お問い合わせ送信処理
    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'cat_id' => 'nullable|exists:cats,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'category' => 'required|in:adoption,volunteer,donation,interview,other',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'privacy_agreement' => 'required|accepted',
            'g-recaptcha-response' => 'required',
        ], [
            'privacy_agreement.required' => 'プライバシーポリシーへの同意が必要です。',
            'privacy_agreement.accepted' => 'プライバシーポリシーへの同意が必要です。',
            'g-recaptcha-response.required' => 'reCAPTCHA認証が必要です。',
        ]);

        // reCAPTCHA v3検証
        // 環境によってSSL検証を切り替え
        $http = app()->environment('local')
            ? Http::withoutVerifying() // 開発環境
            : Http::timeout(10);        // 本番環境

        $recaptcha = $http->asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        // スコアの閾値を環境で切り替え (開発環境: 0.3以上、本番環境: 0.5以上)
        $threshold = app()->environment('local') ? 0.3 : 0.5;

        if (!$recaptcha->json('success') || $recaptcha->json('score') < $threshold) {
            return back()->withErrors(['g-recaptcha-response' => 'スパム防止のため送信できませんでした。もう一度お試しください。'])->withInput();
        }

        Inquiry::create($validated);

        return redirect()->route('contact')->with('success', 'お問い合わせを受け付けました。担当者より改めてご連絡させていただきます。');
    }

    // ========================================
    // 法的情報
    // ========================================

    // プライバシーポリシー
    public function privacy()
    {
        return view('front.privacy');
    }

    // ========================================
    // サイトマップ
    // ========================================

    // サイトマップ
    public function sitemap()
    {
        return view('front.sitemap');
    }

    // ========================================
    // お気に入り
    // ========================================

    // お気に入り追加
    public function addFavorite(Cat $cat, Request $request)
    {
        $sessionId = $request->session()->getId();

        Favorite::firstOrCreate([
            'cat_id' => $cat->id,
            'session_id' => $sessionId,
        ]);

        return response()->json([
            'success' => true,
            'count' => $cat->favorites()->count()
        ]);
    }

    // お気に入り削除
    public function removeFavorite(Cat $cat, Request $request)
    {
        $sessionId = $request->session()->getId();

        Favorite::where('cat_id', $cat->id)
            ->where('session_id', $sessionId)
            ->delete();

        return response()->json([
            'success' => true,
            'count' => $cat->favorites()->count()
        ]);
    }

    // お気に入り一覧
    public function favorites(Request $request)
    {
        $sessionId = $request->session()->getId();

        $favoriteCatIds = Favorite::where('session_id', $sessionId)
            ->pluck('cat_id');

        $cats = Cat::whereIn('id', $favoriteCatIds)
            ->whereIn('status', ['available', 'reserved'])
            ->latest()
            ->get();

        return view('front.favorites', compact('cats'));
    }

    // ユーザーのお気に入り一覧を取得（API）
    public function getUserFavorites(Request $request)
    {
        $sessionId = $request->session()->getId();
        $favorites = Favorite::where('session_id', $sessionId)->pluck('cat_id');

        return response()->json([
            'favorites' => $favorites
        ]);
    }
}
