<?php

use Illuminate\Database\Seeder;

class PropertyTableSeeder extends Seeder
{
	const DATA_FILE = __DIR__.'/property-data.csv';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('property')->delete();
        if (file_exists(self::DATA_FILE) && is_readable(self::DATA_FILE)) {
        	$data = array_map('str_getcsv', file(self::DATA_FILE));
        } else {
        	throw new Exception(sprintf('Data file "%s" not exists or is not readable', self::DATA_FILE), 1);
        }
        if (is_array($data) && !empty($data)) {
        	$fields = array_map('strtolower', array_shift($data));
        	if (is_array($data) && !empty($data)) {
        		foreach ($data as $key => $value) {
        			$data[$key] = array_combine($fields, $data[$key]);
        		}
        		\DB::table('property')->insert($data);
        	}
        } else {
        	throw new Exception(sprintf('Data file "%s" is broken or empty', self::DATA_FILE), 2);
        }
    }
}
