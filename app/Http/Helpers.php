<?php

use App\View;
use App\Report;
use App\Question;

/**
 * Creates a slug out of the string, appends a unique integer value.
 * 
 * @return String
 * @author Soumen Dey
 **/
function _slug($string, $count = 6, $delimeter = '-', $random = true)
{
	$string = implode(' ', array_slice(explode(' ', $string), 0, $count));
	$slug = str_slug($string, $delimeter);

	return ($random) ? $slug.$delimeter.mt_rand(100000, 999999) : $slug;
}

function _number_format( $n, $precision = 1 ) {
	if ($n < 900) {
		// 0 - 900
		$n_format = number_format($n, $precision);
		$suffix = '';
	} else if ($n < 900000) {
		// 0.9k-850k
		$n_format = number_format($n / 1000, $precision);
		$suffix = 'K';
	} else if ($n < 900000000) {
		// 0.9m-850m
		$n_format = number_format($n / 1000000, $precision);
		$suffix = 'M';
	} else if ($n < 900000000000) {
		// 0.9b-850b
		$n_format = number_format($n / 1000000000, $precision);
		$suffix = 'B';
	} else {
		// 0.9t+
		$n_format = number_format($n / 1000000000000, $precision);
		$suffix = 'T';
	}
  // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
  // Intentionally does not affect partials, eg "1.50" -> "1.50"
	if ( $precision > 0 ) {
		$dotzero = '.' . str_repeat( '0', $precision );
		$n_format = str_replace( $dotzero, '', $n_format );
	}
	return $n_format . $suffix;
}

/**
 * Logs a view for the specified object.
 *
 * @return Integer
 * @author Soumen Dey 
 **/
function _view($object) 
{
	if (is_object($object)) {
		
		$object->views()->create([
			'user_id' => auth()->user()->id,
		]);

		return $object->views()->count();
	}

	return null;
}

/**
 * Resolves to the user id from the argument.
 *
 * @return Integer
 * @author Soumen Dey
 **/
function _user($user = null)
{
    if (is_null($user)) {
        $user = auth()->user()->id;
    }

    if (is_object($user)) {
        $user = $user->id;
    }

    return $user;
}

/**
 * 
 *
 * @return 
 * @author Soumen Dey
 **/
function _get_most_reported_question()
{
    $reports = Report::whereReportableType(Question::class)->get();

    return $reports;
}