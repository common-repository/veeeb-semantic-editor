<?php
/*
 * Created on Oct 11, 2010
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

require_once(dirname(__FILE__).'/../../../wp-config.php');
require "TokenHelper.php"; #include the TokenHelper class

define("CRYPTKEY","ZEjygIuripyRcusWXXlyWZz="); 	//This key is used to decrypt the token send from the plugin. It has to be same on the Flex side!
 
function xml_add_method( $methods ) 
{
    $methods["veeeb.ping"] = "ping";
    $methods["veeeb.getImages"] = "getImages";
    $methods["veeeb.findImages"] = "findImages";
    return $methods;
}

/*-------------------
 * XML RPC Methods
 *------------------- 
 */

function ping($args)
{
	return "Pong";
}


function getImages($args)
{
	$images =& get_children( 'post_type=attachment&post_mime_type=image' );
	
	$imageArr = array( );
	
	if ( empty($images) ) {
		// no attachments here
	} 
	else 
	{
		foreach ( $images as $attachment_id => $attachment ) 
		{
			$imageArr[] = get_image_object($attachment_id);	
		}
	}
	
	return $imageArr;
}

function findImages($args)
{
	escape($args);
	
	$token = $args[0];	
	$invalid = checkValidRequest($token);
	
	if(!empty($invalid))
		return $invalid;
	
	$wpdb = $GLOBALS['wpdb'];
		
	$query	= $args[1];
	$query = "%".$query."%";
	
	if(isset($args[2]))
	{
		$start	= (int)$args[2];
	}
	else
	{
		$start = 0;
	}
	
	if(isset($args[3]))
	{
		$media_per_page	= (int)$args[3];
	}
	
	if ( empty($media_per_page) || $media_per_page < 1 )
		$media_per_page = 20;
	
	
//	var_dump($query);
//	var_dump($start);
//	var_dump($media_per_page);
	
	$result = new stdClass();
	
	$resultCount = $wpdb->get_results( $wpdb->prepare( "SELECT count(ID) FROM $wpdb->posts WHERE post_type = 'attachment' AND post_title LIKE %s",$query ) );
	$resultIds = $wpdb->get_results( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type = 'attachment' AND post_title LIKE %s LIMIT %d, %d", $query, $start, $media_per_page ) );
	
	$resultCount = $resultCount[0];
	$resultCount = (int)$resultCount->{"count(ID)"};
//	var_dump($resultCount);
	
	$result->resultCount = $resultCount;
	
	$imageArr = array( );
	
	if ( !empty($resultIds) ) 
	{
		foreach ( $resultIds as $attachment_id) 
		{
//			var_dump($attachment_id->ID);
			$id = $attachment_id->ID;
			
			$imageArr[] = get_image_object($id);
		}
	}
	
	$result->result = $imageArr;
	
	return $result;
}

function checkValidRequest($token)
{
	$helper = new TokenHelper(); //This class can de-/encrypt a string
	$isEncoded = checkIsEncoded($token);	
	$decrypted = $helper->decrypt($token, CRYPTKEY, $isEncoded);
	
	$values = preg_split( "/[;]/", $decrypted); //splitting the decrypted token to get the identifier and the timestamp
	
	if($values[0] !== "veeeb")
	{
//		echo getErrorReturn(002, "identifier not valid!");
		return new IXR_Error( 403, __( 'The identifier is not valid.' ) );
	}
	
	$timeDiff = 86400000; 	//a request is one day valid;
	$actTime = time()*1000; 
	$reqTime = $values[1];
	
	$diff = $actTime - $reqTime;
	
	if($diff > $timeDiff)
	{
		return new IXR_Error(404, __("The session is expired!") );
	}
	
	return null;
}


function checkIsEncoded($pToken)
{
	$pos = strpos($pToken, "%2");
	
	if($pos !== false)
		return true;
	else
		return false;
}

function get_image_object($id)
{
	$img = simplexml_load_string(wp_get_attachment_image( $id, 'full' ));
	$src = "".$img->attributes()->src;
	$title = "".$img->attributes()->title;
	$img = simplexml_load_string(wp_get_attachment_image( $id, "large" ));
	$preview = "".$img->attributes()->src;
	
	$obj = array(
		'id' 		=> $id,
		'thumb'		=> wp_get_attachment_thumb_url($id),
		'url'		=> $src,
		'title'		=> $title,
		'preview'	=> $preview
	);	
	
	return $obj;
}

/**
 * Sanitize string or array of strings for database.
 *
 * @since 1.5.2
 *
 * @param string|array $array Sanitize single string or array of strings.
 * @return string|array Type matches $array and sanitized for the database.
 */
function escape(&$array) {
	global $wpdb;

	if(!is_array($array)) {
		return($wpdb->escape($array));
	}
	else {
		foreach ( (array) $array as $k => $v ) {
			if (is_array($v)) {
				$this->escape($array[$k]);
			} else if (is_object($v)) {
				//skip
			} else {
				$array[$k] = $wpdb->escape($v);
			}
		}
	}
}

?>
