<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->string('title');
            $table->longText('content');
            $table->string('category')->default('information');
            $table->dateTime('published_at')->nullable();
            $table->string('status')->default('draft');
            $table->boolean('target_all_parents')->default(true);
            $table->json('target_classes')->nullable();
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn([
                'title',
                'content',
                'category',
                'published_at',
                'status',
                'target_all_parents',
                'target_classes',
                'created_by',
            ]);
        });
    }
};
