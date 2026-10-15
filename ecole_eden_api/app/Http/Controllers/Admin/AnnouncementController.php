<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);

        return view('admin.annonces.index', compact('announcements'));
    }

    public function create()
    {
        $classes = SchoolClass::all();

        return view('admin.annonces.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'category' => [
                'required',
                Rule::in(['information', 'activite', 'evenement', 'urgent']),
            ],
            'attachment' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png,doc,docx',
                'max:10240',
            ],
            'target_all_parents' => ['nullable', 'boolean'],
            'target_classes' => ['nullable', 'array'],
            'target_classes.*' => ['string'],
            'action' => ['required', Rule::in(['draft', 'publish'])],
        ]);

        $publish = $data['action'] === 'publish';

        $attachmentPath = null;

        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')
                ->store('announcements', 'public');
        }

        Announcement::create([
            'title' => $data['title'],
            'content' => $data['content'],
            'attachment' => $attachmentPath,
            'category' => $data['category'],
            'status' => $publish ? 'published' : 'draft',
            'published_at' => $publish ? now() : null,
            'target_all_parents' => $request->boolean('target_all_parents'),
            'target_classes' => $request->boolean('target_all_parents')
                ? null
                : ($data['target_classes'] ?? []),
            'created_by' => Auth::id(),
        ]);

        return redirect()
            ->route('admin.annonces.index')
            ->with('success', 'Annonce enregistrée avec succès.');
    }

    public function destroy(Announcement $announcement)
    {
        if ($announcement->attachment) {
            Storage::disk('public')->delete($announcement->attachment);
        }

        $announcement->delete();

        return redirect()
            ->route('admin.annonces.index')
            ->with('success', 'Annonce supprimée avec succès.');
    }
}