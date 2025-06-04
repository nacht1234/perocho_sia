<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConfirmationFieldsToBookingsTable extends Migration
{
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->boolean('is_confirmed')->default(false)->after('booked_at'); 
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->nullOnDelete()->after('is_confirmed');
        });
    }

    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropForeign(['confirmed_by']);
            $table->dropColumn(['is_confirmed', 'confirmed_by']);
        });
    }
};

