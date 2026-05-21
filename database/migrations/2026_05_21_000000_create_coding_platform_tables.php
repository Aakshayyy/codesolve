<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tags Table
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // 2. Problems Table
        Schema::create('problems', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->string('difficulty'); // easy, medium, hard
            $table->text('constraints')->nullable();
            $table->text('input_format')->nullable();
            $table->text('output_format')->nullable();
            $table->integer('time_limit')->default(1000); // ms
            $table->integer('memory_limit')->default(256); // MB
            $table->timestamps();
        });

        // 3. Problem-Tag Pivot Table
        Schema::create('problem_tag', function (Blueprint $table) {
            $table->foreignId('problem_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['problem_id', 'tag_id']);
        });

        // 4. Test Cases Table
        Schema::create('test_cases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('problem_id')->constrained()->cascadeOnDelete();
            $table->longText('input')->nullable();
            $table->longText('expected_output');
            $table->boolean('is_hidden')->default(false);
            $table->timestamps();
        });

        // 5. Contests Table
        Schema::create('contests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time');
            $table->timestamps();
        });

        // 6. Contest-Problem Pivot Table
        Schema::create('contest_problem', function (Blueprint $table) {
            $table->foreignId('contest_id')->constrained()->cascadeOnDelete();
            $table->foreignId('problem_id')->constrained()->cascadeOnDelete();
            $table->integer('points')->default(100);
            $table->primary(['contest_id', 'problem_id']);
        });

        // 7. Submissions Table
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('problem_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contest_id')->nullable()->constrained()->nullOnDelete();
            $table->string('language'); // cpp, java, python, javascript
            $table->longText('code');
            $table->string('status')->default('Pending'); // Accepted, Wrong Answer, etc.
            $table->integer('execution_time')->nullable(); // ms
            $table->integer('memory_used')->nullable(); // KB
            $table->timestamps();
        });

        // 8. Comments Table (Discussions)
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('problem_id')->constrained()->cascadeOnDelete();
            $table->foreignId('parent_id')->nullable()->constrained('comments')->cascadeOnDelete();
            $table->text('body');
            $table->timestamps();
        });

        // 9. Comment Upvotes Pivot Table
        Schema::create('comment_upvotes', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('comment_id')->constrained()->cascadeOnDelete();
            $table->primary(['user_id', 'comment_id']);
        });

        // 10. Badges Table
        Schema::create('badges', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('icon'); // icon class or image path
            $table->string('requirement_type'); // solved_count, streak, points
            $table->integer('requirement_value');
            $table->timestamps();
        });

        // 11. User-Badge Pivot Table
        Schema::create('user_badge', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('badge_id')->constrained()->cascadeOnDelete();
            $table->primary(['user_id', 'badge_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_badge');
        Schema::dropIfExists('badges');
        Schema::dropIfExists('comment_upvotes');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('submissions');
        Schema::dropIfExists('contest_problem');
        Schema::dropIfExists('contests');
        Schema::dropIfExists('test_cases');
        Schema::dropIfExists('problem_tag');
        Schema::dropIfExists('problems');
        Schema::dropIfExists('tags');
    }
};
