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
        Schema::table('grades', function (Blueprint $table) {
            // Drop columns if they exist
            if (Schema::hasColumn('grades', 'first_test')) {
                $table->dropColumn('first_test');
            }
            if (Schema::hasColumn('grades', 'second_test')) {
                $table->dropColumn('second_test');
            }
            if (Schema::hasColumn('grades', 'ca')) {
                $table->dropColumn('ca');
            }
            if (Schema::hasColumn('grades', 'grade')) {
                $table->dropColumn('grade');
            }
            if (Schema::hasColumn('grades', 'position')) {
                $table->dropColumn('position');
            }
            if (Schema::hasColumn('grades', 'remark')) {
                $table->dropColumn('remark');
            }

            // Add new columns if they don't exist
            if (!Schema::hasColumn('grades', 'class_score')) {
                $table->decimal('class_score', 5, 2)->default(0); // 50%
            }
            if (!Schema::hasColumn('grades', 'exam_score')) {
                $table->decimal('exam_score', 5, 2)->default(0); // 50%
            }
            if (!Schema::hasColumn('grades', 'total_score')) {
                $table->decimal('total_score', 5, 2)->default(0); // 100%
            }
            if (!Schema::hasColumn('grades', 'grade_meaning')) {
                $table->string('grade_meaning');
            }
            if (!Schema::hasColumn('grades', 'subj_pos_class')) {
                $table->string('subj_pos_class');
            }
            if (!Schema::hasColumn('grades', 'subj_pos_form')) {
                $table->string('subj_pos_form');
            }
            if (!Schema::hasColumn('grades', 'teacher_mod_p')) {
                $table->string('teacher_mod_p');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('grades', function (Blueprint $table) {
            $table->dropColumn(['class_score', 'exam_score', 'total_score', 'grade_meaning', 'subj_pos_class', 'subj_pos_form', 'teacher_mod_p']);
            $table->decimal('first_test', 5, 2)->default(0);
            $table->decimal('second_test', 5, 2)->default(0);
            $table->decimal('ca', 5, 2)->default(0);
            $table->string('grade');
            $table->string('position');
            $table->text('remark')->nullable();
        });
    }
};
