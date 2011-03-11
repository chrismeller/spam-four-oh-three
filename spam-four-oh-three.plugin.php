<?php

	class Spam_Four_Oh_Three extends Plugin {
		
		public function action_comment_insert_after_9 ( $comment ) {
			
			$handler = Controller::get_handler();
			
			if ( get_class( $handler ) == 'FeedbackHandler' ) {
				
				if ( $comment->status == Comment::STATUS_SPAM ) {
					
					//ob_end_clean();
					header( 'HTTP/1.1 403 Forbidden', true, 403 );
					//die('<h1>' . _t('The selected action is forbidden.') . '</h1>');
					
				}
				
			}
			
		}
		
		public function filter_spam_filter ( $rating, $comment, $handler_vars, $extra ) {
			
			$spams = DB::get_value('SELECT count(*) FROM ' . DB::table('comments') . ' WHERE status = ? AND ip = ?', array(Comment::STATUS_SPAM, $comment->ip));
			// one more than the spamfilter plugin, as you're a repeat spammer
			if ( $spams > 2 ) {
				
				ob_end_clean();
				header( 'HTTP/1.1 403 Forbidden', true, 403 );
				die('<h1>' . _t('The selected action is forbidden.') . '</h1>');
				
			}
			
			return $rating;
			
		}
		
	}

?>