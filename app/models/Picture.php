<?php

class Picture extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pictures';

    protected $fillable = array('name', 'description', 'date');

    protected $guarded = array('id', 'colleciton_id', 'monument_id');

}