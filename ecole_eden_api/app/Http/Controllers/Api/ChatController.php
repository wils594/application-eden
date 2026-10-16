<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Afficher la conversation du parent connecté.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();

        abort_unless($user->role === 'parent', 403);

        $conversation = Conversation::firstOrCreate([
            'parent_id' => $user->id,
        ]);

        $messages = $conversation->messages()
            ->with('sender:id,name,role')
            ->orderBy('created_at')
            ->get();

        return response()->json([
            'conversation_id' => $conversation->id,
            'messages' => $messages,
        ]);
    }

    /**
     * Envoyer un message de parent à l'administration.
     */
    public function store(Request $request): JsonResponse
    {
        $user = $request->user();

        abort_unless($user->role === 'parent', 403);

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:5000'],
        ]);

        $conversation = Conversation::firstOrCreate([
            'parent_id' => $user->id,
        ]);

        $message = $conversation->messages()->create([
            'sender_id' => $user->id,
            'body' => $validated['body'],
        ]);

        $conversation->update([
            'last_message_at' => $message->created_at,
        ]);

        return response()->json([
            'message' => 'Message envoyé à l’administration.',
            'data' => $message->load('sender:id,name,role'),
        ], 201);
    }
}
