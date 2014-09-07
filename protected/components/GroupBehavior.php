<?php

/**
 * data can identity the user.
 */
class GroupBehavior extends CBehavior
{
	/**
	 * @return boolean если принадлежит Admin group
	 */
	public function isAdmin()
	{
		return Yii::app()->user->name=="admin";
	}
}