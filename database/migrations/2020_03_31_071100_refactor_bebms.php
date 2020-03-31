<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RefactorBebms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::beginTransaction();
        try {
            DB::update('update invoice_items
            left join products on invoice_items.product_id = products.id
            set invoice_items.description = concat(products.description, \' \', invoice_items.description)');

            Schema::table('invoice_items', function (Blueprint $table) {
                $table->dropColumn('product_id');
            });
            Schema::table('offer_items', function (Blueprint $table) {
                $table->dropColumn('product_id');
            });
            Schema::dropIfExists('products');
            DB::commit(); // all good
        } catch (\Exception $e) {
            DB::rollback(); // something went wrong
            throw $e;
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        DB::beginTransaction();
        try {
            Schema::create('products', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('company_id');
                $table->string('code');
                $table->string('description');
                $table->timestamps();
            });

            DB::insert('INSERT INTO products (id, company_id, code, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', [1, 1, 'DEV', 'Usluge programiranja', null, null]);
            DB::insert('INSERT INTO products (id, company_id, code, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', [2, 1, 'CONS', 'Savjetovanje u vezi s računalima', null, null]);
            DB::insert('INSERT INTO products (id, company_id, code, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', [3, 1, 'MANG', 'Upravljanje računalnom opremom i sustavom', null, null]);
            DB::insert('INSERT INTO products (id, company_id, code, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', [4, 1, 'WEBSITE', 'Izrada Web stranice prema dostavljenom web dizajnu, UX usage', null, null]);
            DB::insert('INSERT INTO products (id, company_id, code, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', [5, 3, 'DEV', 'Usluge programiranja', null, null]);
            DB::insert('INSERT INTO products (id, company_id, code, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', [6, 3, 'CONS', 'Savjetovanje u vezi s računalima', null, null]);
            DB::insert('INSERT INTO products (id, company_id, code, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', [7, 3, 'MANG', 'Upravljanje računalnom opremom i sustavom', null, null]);
            DB::insert('INSERT INTO products (id, company_id, code, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', [8, 3, 'WEBSITE', 'Izrada Web stranice prema dostavljenom web dizajnu, UX usage', null, null]);
            DB::insert('INSERT INTO products (id, company_id, code, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', [9, 1, 'WEBSITE2', 'Izrada i održavanje web stranice, zakup domene, web hosting', null, null]);
            DB::insert('INSERT INTO products (id, company_id, code, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', [10, 1, 'SPEC', 'Izrada specifikacije', null, null]);
            DB::insert('INSERT INTO products (id, company_id, code, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', [11, 1, 'DMA', 'Dizajn i razvoj komponenti za mobilnu aplikaciju', null, null]);
            DB::insert('INSERT INTO products (id, company_id, code, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', [12, 1, 'DWA', 'Dizajn i razvoj frontend komponenti za web aplikaciju', null, null]);
            DB::insert('INSERT INTO products (id, company_id, code, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', [13, 1, 'DWS', 'Dizajn i izrada web stranice', null, null]);
            DB::insert('INSERT INTO products (id, company_id, code, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', [14, 1, 'MAINT', 'Održavanje', null, null]);
            DB::insert('INSERT INTO products (id, company_id, code, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', [15, 6, 'DEV', 'Usluge programiranja', null, null]);
            DB::insert('INSERT INTO products (id, company_id, code, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', [16, 6, 'CONS', 'Savjetovanje u vezi s računalima', null, null]);
            DB::insert('INSERT INTO products (id, company_id, code, description, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)', [17, 6, 'SPEC', 'Izrada specifikacije', null, null]);

            Schema::table('invoice_items', function (Blueprint $table) {
                $table->integer('product_id');
            });
            Schema::table('offer_items', function (Blueprint $table) {
                $table->integer('product_id')->nullable();
            });

            DB::update('update invoice_items set product_id = 1 where invoice_id in (1,3,4,5,7,10,12,13,16,17,19,26,24,49,51,52,53,56,59,62,64,67,72)');
            DB::update('update invoice_items set product_id = 2 where invoice_id in (6)');
            DB::update('update invoice_items set product_id = 4 where invoice_id in (2)');
            DB::update('update invoice_items set product_id = 9 where invoice_id in (57)');
            DB::update('update invoice_items set product_id = 5 where invoice_id in (18,48,50,54,58,61,60,63,65,73)');


            DB::update('update invoice_items
            left join products on invoice_items.product_id = products.id
            set invoice_items.description = replace(invoice_items.description, products.description, \'\')');

            DB::commit(); // all good
        } catch (\Exception $e) {
            DB::rollback(); // something went wrong
            throw $e;
        }

    }
}
