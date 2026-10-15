<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\JsonResponse;

class AnnouncementController extends Controller
{
    /**
     * Récupérer les annonces publiées à tous les parents.
     */
    public function index(): JsonResponse
    {
        $announcements = Announcement::query()
            ->where('status', 'published')
            ->where('target_all_parents', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->orderByDesc('published_at')
            ->paginate(20);

        return response()->json([
            'announcements' => $announcements->getCollection()
                ->map(function (Announcement $announcement) {
                    return [
                        'id' => $announcement->id,
                        'title' => $announcement->title,
                        'content' => $announcement->content,
                        'category' => $announcement->category,
                        'published_at' => $announcement->published_at,

                        // URL de la pièce jointe pour Flutter
                        'attachment_url' => $announcement->attachment
                            ? asset('storage/' . $announcement->attachment)
                            : null,
                    ];
                })
                ->values(),

            'pagination' => [
                'current_page' => $announcements->currentPage(),
                'last_page' => $announcements->lastPage(),
                'per_page' => $announcements->perPage(),
                'total' => $announcements->total(),
            ],
        ]);
    }
}
