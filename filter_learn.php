<?php

/**
 * Filter learn driver
 * @version 2.0
 * @author Maxime Barrast
 *
 * Copyright (C) 2015 Maxime Barrast
 *
 * This driver is part of the MarkASJunk2 plugin for Roundcube.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Roundcube. If not, see http://www.gnu.org/licenses/.
 */

class markasjunk2_filter_learn
{
	public function spam($uids, $mbox)
	{
		$this->_do_filterlearn($uids, true);
	}

	public function ham($uids, $mbox)
	{
		$this->_do_filterforget($uids, false);
	}

	private function _do_filterlearn($uids, $spam)
	{
		$rcmail = rcube::get_instance();
		$user = $rcmail->user;

		
		foreach ($uids as $uid) {
			$MESSAGE = new rcube_message($uid);
			$from = $MESSAGE->sender['mailto'];
			
			if ($from == "")
			  $rcmail->output->command('display_message', 'email address not found '.$from, 'error');
			else{
			  $new_arr['whatfilter'] = 'from';
			  $new_arr['searchstring'] = htmlspecialchars(addslashes($from));
			  $new_arr['destfolder'] = addslashes("Junk");
			  $new_arr['messages'] = 'all';
			  $new_arr['filterpriority'] = '';
			  $new_arr['markread'] = 'markread';
			  $arr_prefs = $user->get_prefs();
			  $arr_prefs['filters'][] = $new_arr;
			  if ($user->save_prefs($arr_prefs))
				$rcmail->output->command('display_message', 'I learned that messages from '.$from.' are SPAM', 'confirmation');
			  else
				$rcmail->output->command('display_message', 'I learned nothing', 'error');
			}
					
				
		}
		
		
	}
	
	
	private function _do_filterforget($uids, $spam)
	{
		$rcmail = rcmail::get_instance();
    	$rcmail->imap_connect();
		$user = $rcmail->user;
    	$arr_prefs = $user->get_prefs();
		
		foreach ($uids as $uid) {
			$MESSAGE = new rcube_message($uid);
			$from = $MESSAGE->sender['mailto'];
				
			  $found = false;
			  foreach ($arr_prefs['filters'] as $key => $saved_filter){
				
				    if (stripslashes($saved_filter['searchstring']) == $from && $saved_filter['destfolder']== 'Junk' ){
				  	  $found = true;
				      $arr_prefs2 = $user->get_prefs();
					    $arr_prefs2['filters'][$key] = '';
					    $arr_prefs2['filters'] = array_diff($arr_prefs2['filters'], array(''));
    					 if ($user->save_prefs($arr_prefs2))
    						$rcmail->output->command('display_message', 'Filter '.$key.' deleted', 'confirmation');
    					 else
    						$rcmail->output->command('display_message', 'Filter  '.$key.' not deleted', 'error');
					  }
				   
				}
		
				if(!$found) {
					 $rcmail->output->command('display_message', 'No filter found for '.$from.'', 'confirmation');
				}
			
		}
	}
	
}

?>
