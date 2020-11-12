<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Settings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('option')->unique();
            $table->string('value');
            $table->timestamps();
        });

        $settingsData = [
            'site_name' => 'Blog',
            'site_url' => '/',
            'template' => 'default',
        ];

        foreach ($settingsData as $option => $value) {
            DB::table('settings')->insert(
                [
                    'option' => $option,
                    'value' => $value,
                ]
            );
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
