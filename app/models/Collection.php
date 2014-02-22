<?php

class Collection extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'collections';

    protected $fillable = array('name');

    protected $guarded = array('id', 'user_id');

}