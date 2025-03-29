<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameIfscAndPanColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE bank_details CHANGE ifsc bin VARCHAR(40)');
        DB::statement('ALTER TABLE bank_details CHANGE  pan  tax_payer_id VARCHAR(40)');
        DB::statement('ALTER TABLE bank_details DROP COLUMN bsb;');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_details', function(Blueprint $t) {
            ;
        });
    }
}
