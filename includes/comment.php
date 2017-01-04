<?php

require_once(LIB_PATH.DS.'database.php');

class Comment extends DatabaseObject {

    protected static $table_name = "comments";
    protected static $db_fields = 
        array('id', 'photograph_id', 'created', 'author', 'body');

    public $photograph_id;
    public $created;
    public $author;
    public $body;

    // "new" is a reserved word so we use "make" (or "build")
	public static function make($photo_id, $author="Anonymous", $body="") {
    if(!empty($photo_id) && !empty($author) && !empty($body)) {
			$comment = new Comment();
	    $comment->photograph_id = (int)$photo_id;
	    $comment->created = strftime("%Y-%m-%d %H:%M:%S", time());
	    $comment->author = $author;
	    $comment->body = $body;
	    return $comment;
		} else {
			return false;
		}
	}

	public function try_to_send_notification() {
// 		$mail = new PHPMailer(); // create a new object
// 		$mail->IsSMTP(); // enable SMTP
// 		$mail->SMTPAuth = true; // authentication enabled
// 		$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
// 		$mail->Host = "smtp.gmail.com";
// 		$mail->Port = 587; // or 587
// 		$mail->IsHTML(true);
// 		$mail->Username = "your gmail account"; // change to real name to make it work
// 		$mail->Password = "your password"; // same here.
// 		$mail->SetFrom("Photo Gallery");
// 		$mail->AddAddress("andyoung@foxmail.com", "Photo Gallery Admin");
// 		$mail->Subject  = "New Photo Gallery Comment";
//     	$created = datetime_to_text($this->created);
// 		$mail->Body     =<<<EMAILBODY

// A new comment has been received in the Photo Gallery.

//   At {$created}, {$this->author} wrote:

// {$this->body}

// EMAILBODY;

// 		$result = $mail->Send();
// 		return $result;
	}
	
	public static function find_comments_on($photo_id=0) {
        global $database;
        $sql = "SELECT * FROM " . self::$table_name;
        $sql .= " WHERE photograph_id=" .$database->escape_value($photo_id);
        $sql .= " ORDER BY created ASC";
        return self::find_by_sql($sql);
	}
	
}

?>