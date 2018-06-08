<?php

use App\Models\PostalCode;
use Illuminate\Database\Seeder;

class PostalCodeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
		$postal_codes = $this->load_postal_codes();

		PostalCode::truncate();

		foreach($postal_codes as $postal_code) {
			PostalCode::create($postal_code);
			unset($postal_code);
		}
	}
	  
  public function load_postal_codes() {
    $file_path = __DIR__ . '/data/KEN_ALL.CSV';
    $file_lines = $this->loader($file_path);
    
		$file_header = [];
		$file_header_idx = 0;
		foreach(PostalCode::$columns as $column) {
			$file_header[$column] = $file_header_idx++;
		}
    
    $postal_codes = [];
		$line_idx = 0;
    foreach ($file_lines as $file_line) {
      foreach ($file_header as $column => $index) {
				$file_data = $file_line[$index];
        $postal_codes[$line_idx][$column] = $file_data;
			}
			unset($file_line);
			$line_idx++;
    }
    unset($file_path);
    
    return $postal_codes;
  }

	public function loader($filepath) {
		$bef_enc_file = file_get_contents($filepath);
		if(mb_detect_encoding($bef_enc_file, 'SJIS-WIN', true)) {
			file_put_contents($filepath, mb_convert_encoding($bef_enc_file, 'UTF-8', 'SJIS-WIN'));
		}
		
		$aft_enc_file = new SplFileObject($filepath); 
    $aft_enc_file->setFlags(SplFileObject::READ_CSV); 
    
    $file_lines = [];
    while (! $aft_enc_file->eof()) {
      $file_line = $aft_enc_file->fgetcsv(",");
      if (! empty($file_line[0])) {
        $file_lines[] = $file_line;
      }
    }
    unset($aft_enc_file);
    
    return $file_lines;
  }
}