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
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->text('cta_microcopy')->nullable()->after('meta_description');
            $table->string('cta_button_text')->nullable()->after('cta_microcopy');
            $table->string('cta_type')->nullable()->after('cta_button_text'); // 'modal' or 'link'
            $table->string('cta_link_url')->nullable()->after('cta_type');
            $table->string('cta_qr_image')->nullable()->after('cta_link_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('landing_pages', function (Blueprint $table) {
            $table->dropColumn([
                'cta_microcopy',
                'cta_button_text',
                'cta_type',
                'cta_link_url',
                'cta_qr_image',
            ]);
        });
    }
};
