<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    public function urlShort(Request $request)
    {
        $user = auth('sanctum')->user();
        if (!$user->hasRole(['Admin', 'Member'])) {
            return response()->json([
                'status' => false,
                'error' => 'Not allowed to create URL'
            ]);
        }

        $request->validate([
            'original_url' => 'required|url',
        ]);

        $shortCode = Str::random(6);

        $shortUrl = ShortUrl::create([
            'original_url' => $request->original_url,
            'short_code' => $shortCode,
            'created_by' => $user->id,
            'company_id' => $user->company_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'URL created successfully',
            'url' => $shortUrl
        ]);
    }

    public function listShortUrl()
    {
        $user = auth('sanctum')->user();

        if ($user->hasRole('SuperAdmin')) {
            return ShortUrl::all();
        }
        if ($user->hasRole('Admin')) {
            return ShortUrl::where('company_id', $user->company_id)->get();
        }
        if ($user->hasRole('Member')) {
            return ShortUrl::where('company_id', $user->company_id)->where('created_by', $user->id)->get();
        }
        if ($user->hasAnyRole(['Sales', 'Manager'])) {
            return ShortUrl::where('company_id', $user->company_id)->get();
        }

        return collect();
    }

    public function redirect(string $code)
    {
        $shortUrl = ShortUrl::where('short_code', $code)->firstOrFail();

        return redirect()->away($shortUrl->original_url);
    }
}
