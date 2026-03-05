<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('orders', 'table_number')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('table_number', 20)->nullable()->after('address');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('orders', 'table_number')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('table_number');
            });
        }
    }
};
