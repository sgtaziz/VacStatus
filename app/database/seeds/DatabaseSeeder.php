<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('DonationPerkTableSeeder');
		$this->call('NewsTableSeeder');
		$this->call('BetaTesterSeeder');
	}

}
