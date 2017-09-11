<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
	protected $table = 'property';

    protected $fillable = [
    	'name', 'price', 'bedrooms', 'bathrooms', 'storeys', 'garages',
    ];

    public function scopeSearchByParams($query, $values)
    {
    	$query->where('name', 'like', '%' . $values['name'] . '%');
    	if (isset($values['price_min'])) {
    		$query->where('price', '>=', $values['price_min']);
    	}
    	if (isset($values['price_max'])) {
    		$query->where('price', '<=', $values['price_max']);
    	}
    	if (isset($values['bedrooms'])) {
    		$query->where('bedrooms', '=', $values['bedrooms']);
    	}
    	if (isset($values['bathrooms'])) {
    		$query->where('bathrooms', '=', $values['bathrooms']);
    	}
    	if (isset($values['storeys'])) {
    		$query->where('storeys', '=', $values['storeys']);
    	}
    	if (isset($values['garages'])) {
    		$query->where('garages', '=', $values['garages']);
    	}
    	return $query;
    }
}
