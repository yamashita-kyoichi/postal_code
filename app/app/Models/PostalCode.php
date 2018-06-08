<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostalCode extends Model
{
  public static $columns = [
		'public_org_code',
		'old_postal_code',
		'postal_code',
		'prefecture_kana',
		'city_kana',
		'district_kana',
		'prefecture',
		'city',
		'district',
		'has_codes',
		'has_small_section',
		'has_street',
		'has_adresses',
		'is_change',
		'change_reason',
	];

  public function scopeWherePostalCode($query, $postal_code) {
    return $query->where('postal_code', $postal_code);
	}
}
