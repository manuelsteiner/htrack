<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $settings = DB::table('settings')->get();

        Schema::table('settings', function (Blueprint $table) {
            $table->json('calorie_targets')->nullable()->after('activity_factor');
        });

        foreach ($settings as $setting) {
            $targets = array_fill_keys(
                ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'],
                $setting->calorie_target
            );

            DB::table('settings')
                ->where('id', $setting->id)
                ->update(['calorie_targets' => json_encode($targets)]);
        }

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('calorie_target');
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->unsignedSmallInteger('calorie_target')->nullable()->after('activity_factor');
        });

        $settings = DB::table('settings')->get();

        foreach ($settings as $setting) {
            $targets = json_decode($setting->calorie_targets, true);
            $average = round(array_sum($targets) / count($targets));

            DB::table('settings')
                ->where('id', $setting->id)
                ->update(['calorie_target' => $average]);
        }

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('calorie_targets');
        });
    }
};
