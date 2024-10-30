<?php
/*
Plugin Name: blog to blogs
Description: use this plugin  when you publish your artical it can send the artical to more blogs at the same time.
Version: 0.1
Author: 三少
*/
include('post_more_in.php');




function postMorePanel() {	
	
	if (function_exists ( 'add_options_page' )) {		
		add_options_page ( 'hotKeyPanel', isCN()?'群发插件设置':'blog2Blogs Setting', 8, basename ( __FILE__ ), 'hotkey_dashboard' );
	}
}

function pm_set_option($option_name, $option_value) {	
	$pm_options = get_option ( 'pm_options' );	
	$pm_options [$option_name] = $option_value;	
	update_option ( 'pm_options', $pm_options );
}

function request_handler(){
	$submit = trim ( $_POST ['Submit'] );	
	if($submit) {
		pm_set_option ( 'blogInfo',isset ( $_POST)?$_POST:"");
		
	}
}






function hotkey_dashboard() {	
	request_handler();
if(isCN()){
		$info->seeType = '查看本插件支持哪些博客';
		$info->click = '您就点这儿';
		$info->fillColmun = '如果您不知道XMLRpc URL这填什么内容';
		$info->useRed = '使用文章中标红的url去填充这列数据';
		$info->welcome = '欢迎使用wordpress群发插件';
		
		$info->blogName = '博客名称';
		$info->blogUser = '博客登录名';
		$info->blogPwd = '博客密码';
		$info->op='操作';
		
		$btn->del = '删除';
		$btn->addNew = '新增';
		$btn->submit = '提交';
		
	}else{
		$info->seeType = 'whitch Blog Style This plugin can supports ';
		$info->click = 'see here';
		$info->fillColmun = 'you dont known how to fill the data in "XMLRpc URL" cloumn ';
		$info->useRed = 'use the url with red color in my post';
		$info->welcome = 'It is Pleasure see you use this Plugin';
		
		$info->blogName = 'blogName';
		$info->blogUser = 'blogUser';
		$info->blogPwd = 'blogPwd';
		$info->op='operate';
		
		$btn->del = 'delete';
		$btn->addNew = 'add new';
		$btn->submit = 'submit';
	}
	
	$html='<style>
	#blogTable {   
    padding: 0;
    margin: 0;   
    border-collapse:collapse;
	}

	#blogTable td {
    border: 1px solid #C1DAD7;   
    background: #fff;
    font-size:11px;
    padding: 6px 6px 6px 12px;
    color: #4f6b72;
}

	</style>';
	$html.='<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>';
	$html.='<h3>'.$info->welcome .'</h3>';
	$html.='<p>'.$info->seeType.'? <a href="http://wpmall.org/96.html" target="_blank">'.$info->click.'</a></p>';
	$html.='<p>'.$info->fillColmun.'??  <a href="http://wpmall.org/96.html" target="_blank">'.$info->click.'</a>, '.$info->useRed.'.</p>';
	$html.='<form method="post"><table id="blogTable" style="border:top">';
	$html.='<tr><th width="150">'.$info->blogName.'</th><th width="250">XMLRpc URL</th><th width="150">'.$info->blogUser.'</th><th width="150">'.$info->blogPwd.'</th><th width="50">'.$info->op.'</th></tr>';
	$data = get_option('pm_options') ;
	$data1 = $data['blogInfo'];
	$count = count($data1[blogTitle]);
	for($ic=0;$ic<$count;$ic++){
		$html.='<tr class="blogTr"><td><input name="blogTitle[]" value="'.$data1[blogTitle][$ic].'"></td><td><input name="blogUrl[]" style="width:200px"  value="'.$data1[blogUrl][$ic].'"></td><td><input name="user[]"  value="'.$data1[user][$ic].'"></td><td><input name="pass[]"  value="'.substr($data1[pass][$ic],0,1).'*****"></td><td><input type="button" value="'.$btn->del.'" class="btnDel"></td></tr>';
	}
	
	$html.='</table><center><input type="submit" value="'.$btn->submit.'"><input type="button" id="addOne" value="'.$btn->addNew.'"></center><input type="hidden" name="Submit" value="1"> </form>';
	$html.='<script src="'.plugins_url('postMore/js/postMore.js').'"></script>';
	echo $html;
	//print_r($data['blogInfo']);
}

function posp_more_blog_box(){
	$data = get_option('pm_options') ;
	$data1 = $data['blogInfo'];
	$count = count($data1[blogTitle]);

	$html='<ol>';
	for($ic=0;$ic<$count;$ic++){
		$html.='<li><input type="checkbox" checked="checked">'.$data1[blogTitle][$ic].'</li>';
	}
	$html.='</ol>';
echo $html; 
}
 
function post_more_widgets(){
add_meta_box('post_more_blog_widgets', 'choose the blog to send', 'posp_more_blog_box', 'post', 'side', 'high');  //这里的post是指在什么功能模块里增加这个matabox 当然你也可以吧postgaiu
}
//add_action('add_meta_boxes', 'post_more_widgets');

add_action ( 'admin_menu', 'postMorePanel');
?>