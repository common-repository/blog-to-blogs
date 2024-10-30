<?php
include_once(ABSPATH . WPINC . '/class-IXR.php');



function isCN(){

		$lang1 = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']);

		$pre = substr($lang1, 0,2);

		return $pre=='zh';

}
	
function send_to_other($post_ID,$web,$USER,$PASS,$count=-1)  { 
		$client = new IXR_Client($web);
		$get_post_info = get_post($post_ID);
        $content['title'] = $get_post_info->post_title;
        //$get_post_info->post_category;
        $content['categories'] = array("NewCategory","Nothing");
        $content['description'] = $get_post_info->post_content;
        $content['custom_fields'] = array( array('key' => 'my_custom_fied','value'=>'yes') );
        $content['mt_keywords'] = 'foo';
        
        
    
  if (!$client->query('metaWeblog.newPost','', $USER,$PASS, $content, true)) 
        {
            die( 'Error while creating a new post' . $client->getErrorCode() ." : ". $client->getErrorMessage());  
        }
        $ID =  $client->getResponse();
        
        if($ID)
        {
           // echo 'Post published with ID:#'.$ID;
        }    
   return $post_ID;  
}    

function toMoreBlog($post_ID){
$data = get_option('pm_options') ;
	$data1 = $data['blogInfo'];
	$count = count($data1[blogTitle]);
	for($ic=0;$ic<$count;$ic++){
		//$html.='<tr class="blogTr"><td><input name="blogTitle[]" value="'.$data1[blogTitle][$ic].'"></td><td><input name="blogUrl[]"  value="'.$data1[blogUrl][$ic].'"></td><td><input name="user[]"  value="'.$data1[user][$ic].'"></td><td><input name="pass[]"  value="'.$data1[pass][$ic].'"></td><td><input name="tags[]" value="获取标签分类" type="button" id="btnGetTag"></td></tr>';
	send_to_other($post_ID,$data1[blogUrl][$ic],$data1[user][$ic],$data1[pass][$ic]);
	}
}

add_action('publish_post', 'toMoreBlog');
?>