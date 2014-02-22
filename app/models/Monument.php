<?php

class Monument extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'monuments';

    protected $fillable = array('name', 'description', 'category_id');

    protected $guarded = array('id', 'colleciton_id');

}