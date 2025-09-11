<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('cms_v2_pages')) {
            Schema::create('cms_v2_pages', function (Blueprint $table) {
                if (method_exists($table, 'ulid')) { $table->ulid('id')->primary(); } else { $table->uuid('id')->primary(); }
                $table->string('slug')->unique();
                $table->string('title')->default('');
                $table->json('meta_json')->nullable();
                $table->json('published_snapshot_json')->nullable();
                $table->timestampsTz();
            });
        }

        if (!Schema::hasTable('cms_v2_sections')) {
            Schema::create('cms_v2_sections', function (Blueprint $table) {
                if (method_exists($table, 'ulid')) { $table->ulid('id')->primary(); } else { $table->uuid('id')->primary(); }
                // FK to pages
                if (method_exists($table, 'ulid')) { $table->ulid('page_id'); } else { $table->uuid('page_id'); }
                $table->integer('sort')->default(0);
                $table->string('component_type');
                $table->json('props_json')->nullable();
                $table->string('status')->default('draft'); // draft|published
                $table->timestampsTz();
                $table->index(['page_id', 'sort']);
            });
        }

        if (!Schema::hasTable('cms_v2_media')) {
            Schema::create('cms_v2_media', function (Blueprint $table) {
                if (method_exists($table, 'ulid')) { $table->ulid('id')->primary(); } else { $table->uuid('id')->primary(); }
                $table->string('filename');
                $table->string('mime', 191)->nullable();
                $table->unsignedBigInteger('size')->default(0);
                $table->binary('data');
                $table->timestampsTz();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('cms_v2_media');
        Schema::dropIfExists('cms_v2_sections');
        Schema::dropIfExists('cms_v2_pages');
    }
};

