<?php
/**
 * Template Name: Query
 */
 
header('Content-type: application/json');

function nice_url($url) {
    if(!(strpos($url, "http://") === 0) && !(strpos($url, "https://") === 0)) {
		$url = "http://$url";
	}
    return $url;
}
 
$args = array(
	'no_found_rows' => true,
	'post_type' =>'mf_form',
	'post_status' => 'mf_complete'

);

$query = new WP_Query( $args );

//print_r($query);

$posts = $query->posts;

$header = array( 'header' =>
	array(
		'version' 			=> '0.5', 
		'generation_date' 	=> date('Y-m-d H:i:s'),
		'results'			=> $query->post_count
	) );

$entities = array();



foreach ($posts as $post) {
	$exhibit = json_decode( $post->post_content );
	$jsonpost["id"] = get_the_ID();
	$jsonpost["original_id"] = get_the_ID();
	$url = $exhibit->project_photo_thumb;
	$url = add_query_arg( 'w', 80, $url );
	$url = add_query_arg( 'h', 80, $url );
	$url = add_query_arg( 'crop', 1, $url );
	$jsonpost["thumb_img_url"] = $url;
	$jsonpost["large_img_url"] = $exhibit->project_photo;
	$jsonpost["category_id_refs"] = get_the_category( get_the_ID() );
	$jsonpost["description"] = $exhibit->public_description;
	$jsonpost["youtube_url"] = $exhibit->project_video;
	$jsonpost["website_url"] = $exhibit->project_website;
	$jsonpost["twitter_hashtag"] = '';
	$jsonpost["facebook_url"] = '';
	$jsonpost["email"] = $exhibit->email;
	$jsonpost["tags"] = '';
	$jsonpost["featured"] = '';
	$jsonpost["name"] = $exhibit->name;
	$jsonpost["url"] = nice_url($exhibit->project_website);

	array_push($entities, $jsonpost);
	//$jsonpost["content"] = json_decode( $post->post_content );

}

$merged = array_merge($header,array('entities' => $entities, ) );
echo json_encode( $merged, JSON_FORCE_OBJECT );

wp_reset_postdata();