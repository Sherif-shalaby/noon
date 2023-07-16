<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeys extends Migration {

	public function up()
	{
		// Schema::table('categories', function(Blueprint $table) {
		// 	$table->foreign('parent_id')->references('id')->on('categories')
		// 				->onDelete('restrict')
		// 				->onUpdate('restrict');
		// });
		// Schema::table('categories', function(Blueprint $table) {
		// 	$table->foreign('class_id')->references('id')->on('classes')
		// 				->onDelete('restrict')
		// 				->onUpdate('restrict');
		// });
		// Schema::table('products', function(Blueprint $table) {
		// 	$table->foreign('class_id')->references('id')->on('classes')
		// 				->onDelete('restrict')
		// 				->onUpdate('restrict');
		// });
		// Schema::table('products', function(Blueprint $table) {
		// 	$table->foreign('category_id')->references('id')->on('categories')
		// 				->onDelete('restrict')
		// 				->onUpdate('restrict');
		// });
		// Schema::table('products', function(Blueprint $table) {
		// 	$table->foreign('subcategory_id')->references('id')->on('categories')
		// 				->onDelete('restrict')
		// 				->onUpdate('restrict');
		// });
		Schema::table('products', function(Blueprint $table) {
			$table->foreign('brand_id')->references('id')->on('brands')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('product_stores', function(Blueprint $table) {
			$table->foreign('product_id')->references('id')->on('products')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('product_stores', function(Blueprint $table) {
			$table->foreign('store_id')->references('id')->on('stores')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('product_subcategories', function(Blueprint $table) {
			$table->foreign('product_id')->references('id')->on('products')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('product_subcategories', function(Blueprint $table) {
			$table->foreign('category_id')->references('id')->on('categories')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('customers', function(Blueprint $table) {
			$table->foreign('customer_type_id')->references('id')->on('customer_types')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('customer_balance_adjustments', function(Blueprint $table) {
			$table->foreign('customer_id')->references('id')->on('customers')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('customer_balance_adjustments', function(Blueprint $table) {
			$table->foreign('store_id')->references('id')->on('stores')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('employees', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('employees', function(Blueprint $table) {
			$table->foreign('store_id')->references('id')->on('stores')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('employees', function(Blueprint $table) {
			$table->foreign('job_type_id')->references('id')->on('job_types')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('exchange_rates', function(Blueprint $table) {
			$table->foreign('store_id')->references('id')->on('stores')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('exchange_rates', function(Blueprint $table) {
			$table->foreign('receved_currency_id')->references('id')->on('currencies')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('exchange_rates', function(Blueprint $table) {
			$table->foreign('default_currency_id')->references('id')->on('currencies')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('product_prices', function(Blueprint $table) {
			$table->foreign('product_id')->references('id')->on('products')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('categories', function(Blueprint $table) {
			$table->dropForeign('categories_parent_id_foreign');
		});
		Schema::table('categories', function(Blueprint $table) {
			$table->dropForeign('categories_class_id_foreign');
		});
		Schema::table('products', function(Blueprint $table) {
			$table->dropForeign('products_class_id_foreign');
		});
		Schema::table('products', function(Blueprint $table) {
			$table->dropForeign('products_category_id_foreign');
		});
		Schema::table('products', function(Blueprint $table) {
			$table->dropForeign('products_subcategory_id_foreign');
		});
		Schema::table('products', function(Blueprint $table) {
			$table->dropForeign('products_brand_id_foreign');
		});
		Schema::table('product_stores', function(Blueprint $table) {
			$table->dropForeign('product_stores_product_id_foreign');
		});
		Schema::table('product_stores', function(Blueprint $table) {
			$table->dropForeign('product_stores_store_id_foreign');
		});
		Schema::table('product_subcategories', function(Blueprint $table) {
			$table->dropForeign('product_subcategories_product_id_foreign');
		});
		Schema::table('product_subcategories', function(Blueprint $table) {
			$table->dropForeign('product_subcategories_category_id_foreign');
		});
		Schema::table('customers', function(Blueprint $table) {
			$table->dropForeign('customers_customer_type_id_foreign');
		});
		Schema::table('customer_balance_adjustments', function(Blueprint $table) {
			$table->dropForeign('customer_balance_adjustments_customer_id_foreign');
		});
		Schema::table('customer_balance_adjustments', function(Blueprint $table) {
			$table->dropForeign('customer_balance_adjustments_store_id_foreign');
		});
		Schema::table('employees', function(Blueprint $table) {
			$table->dropForeign('employees_user_id_foreign');
		});
		Schema::table('employees', function(Blueprint $table) {
			$table->dropForeign('employees_store_id_foreign');
		});
		Schema::table('employees', function(Blueprint $table) {
			$table->dropForeign('employees_job_type_id_foreign');
		});
		Schema::table('exchange_rates', function(Blueprint $table) {
			$table->dropForeign('exchange_rates_store_id_foreign');
		});
		Schema::table('exchange_rates', function(Blueprint $table) {
			$table->dropForeign('exchange_rates_receved_currency_id_foreign');
		});
		Schema::table('exchange_rates', function(Blueprint $table) {
			$table->dropForeign('exchange_rates_default_currency_id_foreign');
		});
		Schema::table('product_prices', function(Blueprint $table) {
			$table->dropForeign('product_discounts_product_id_foreign');
		});
	}
}
