<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Liste des conversations des parents.
     */
    public function index()
    {
        $conversations = Conversation::with('parent:id,name,email,phone')
            ->withCount('messages')
            ->orderByDesc('last_message_at')
            ->get();

        return view('admin.chat.index', compact('conversations'));
    }

    /**
 * Récupérer les messages récents d'une conversation.
 */
public function fetchMessages(Conversation $conversation)
{
    $conversation->load([
        'messages' => function ($query) {
            $query->with('sender:id,name,role')
                ->orderBy('created_at', 'asc');
        },
    ]);

    return response()->json([
        'messages' => $conversation->messages->map(function ($message) {
            return [
                'id' => $message->id,
                'body' => $message->body,
                'created_at' => $message->created_at?->format('d/m/Y à H:i'),
                'sender' => [
                    'name' => $message->sender?->name ?? 'Utilisateur',
                    'role' => $message->sender?->role ?? '',
                ],
            ];
        }),
    ]);
}

    /**
     * Afficher les messages d'une conversation.
     */
    public function show(Conversation $conversation)
    {
        $conversation->load([
            'parent:id,name,email,phone',
            'messages' => function ($query) {
                $query->with('sender:id,name,role')
                    ->orderBy('created_at', 'asc');
            },
        ]);

        return view('admin.chat.show', compact('conversation'));
    }

    /**
     * Répondre à un parent.
     */
    public function reply(
        Request $request,
        Conversation $conversation
    ) {
        $validated = $request->validate([
            'body' => ['required', 'string', 'max:5000'],
        ]);

        $admin = $request->user();

        abort_unless($admin && $admin->role === 'admin', 403);

        $message = $conversation->messages()->create([
            'sender_id' => $admin->id,
            'body' => $validated['body'],
        ]);

        $conversation->update([
            'last_message_at' => $message->created_at,
        ]);

        return redirect()
            ->route('admin.messages.show', $conversation)
            ->with('success', 'Votre réponse a été envoyée au parent.');
    }
}