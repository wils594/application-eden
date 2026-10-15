
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bulletins', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('students')
                ->cascadeOnDelete();

            $table->string('term');
            $table->string('school_year');
            $table->string('pdf_path')->nullable();

            $table->foreignId('validated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('validated_at')->nullable();
            $table->string('status')->default('draft');
            $table->timestamps();

            $table->unique(
                ['student_id', 'term', 'school_year'],
                'bulletins_student_term_year_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bulletins');
    }
};
