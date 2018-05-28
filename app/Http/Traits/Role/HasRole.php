<?php

namespace App\Http\Traits\Role;

use App\Role;

trait HasRole
{
	/**
	 * Get the role of the user.
	 *
	 * @return String
	 * @author Soumen Dey
	 **/
	public function getRole()
	{
	    return $this->roles()->first()->name;
	}

	/**
	 * Determine if the user has the specified role.
	 *
	 * @return Boolean
	 * @author Soumen Dey
	 **/
	public function hasRole($role = null)
	{
	    return $this->roles->contains('name', $role);
	}

	/**
	 * Determine if the user is an admin.
	 *
	 * @return Boolean
	 * @author Soumen Dey
	 **/
	public function isAdmin()
	{
	    return $this->hasRole('Admin');
	}

	/**
	 * Determine if the user is a user.
	 *
	 * @return Boolean
	 * @author Soumen Dey
	 **/
	public function isUser()
	{
	    return $this->hasRole('User');
	}
}