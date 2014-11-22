 function fetch_gmail_inbox()
	{

		$res=array();
		/* connect to gmail */
		$hostname = '{imap.gmail.com:993/imap/ssl}INBOX';
		$username = 'clnvsdty@gmail.com';
		$password = 'Solarisgr8';

		/* try to connect */
		$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

		/* grab emails */
		$emails = imap_search($inbox,'UNSEEN');

		/* if emails are returned, cycle through each... */
		if($emails) {
	
			/* put the newest emails on top */
			rsort($emails);
	
			/* for every email... */
			foreach($emails as $email_number) {
				
				/* get information specific to this email */
				$overview = imap_fetch_overview($inbox,$email_number,0);
				$message = quoted_printable_decode(imap_fetchbody($inbox,$email_number,1));
				 $structure = imap_fetchstructure($inbox,$email_number);
				if($structure->parts[0]->encoding == 3 ||$structure->encoding == 3 )
				{
					$message=imap_base64($message);
				
				}
				if($structure->parts[0]->encoding == 4 ||$structure->encoding == 4) 
				{
				    $message = imap_qprint($message);
				}
			 	
			}
	
			return $res;
		} 

		/* close the connection */
		imap_close($inbox);



	}
