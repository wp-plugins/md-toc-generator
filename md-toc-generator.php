<?php
/**
 * Plugin Name: MD TOC Generator
 * Description: Plugin to automatically generate a table of contents based on Headings tags
 * Author: Morgan Davison
 * Version: .1
 * Author URI: http://www.morgandavison.com
 */

/**
 * Copyright 2011 Morgan Davison
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as 
 * published by the Free Software Foundation.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

function mdtoc_admin() {
	include('mdtoc-admin.php');
}

function mdtoc_admin_actions() {
	add_options_page("Table of Contents", "Table of Contents", "manage_options", "MD-TOC", "mdtoc_admin");
}

add_action('admin_menu', 'mdtoc_admin_actions');
add_action('admin_head', 'include_admin_styles'); 
add_action('wp_head', 'include_styles');
add_action('the_content', 'parse_post');

function include_styles() {
	$siteurl = get_option('siteurl');
    $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/md-toc-generator.css';
    echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
}

function include_admin_styles() {
	$siteurl = get_option('siteurl');
    $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/md-toc-generator.css';
    echo "<link rel='stylesheet' type='text/css' href='$url' />\n";
}

function parse_post($content) {
	$selectedHeadingsOption = get_option('mdtoc_headings');
	if($selectedHeadingsOption && !is_array($selectedHeadingsOption)){
		$selectedHeadingsArray = unserialize($selectedHeadingsOption);
	} 
	if(is_array($selectedHeadingsArray)){
		$selectedHeadingsString = implode('', $selectedHeadingsArray);
	}
	if(!$selectedHeadingsString){
		$selectedHeadingsString = '123456';
	}
	$searchString = array('<p>[toc]</p>', '[toc]');
	if( is_single() || is_page() ) {
		$tocData = tocGetList($content, $selectedHeadingsString);
		if($tocData){
			$replaceString = '<div id="toc_container"><h1>Table of Contents</h1>' . 
						 	'<div id="toc_content">' . 
						 		$tocData . 
						 	'</div><!-- end toc_content -->' . 
						 '</div><!-- end toc_container -->';
						 			
			$content = str_replace($searchString, $replaceString, $content);
		}		
	} else {
		$content = str_replace($searchString, '', $content);
	}
	return $content;
}

function tocGetList(&$content, $selectedHeadingsString) {
	$tocData = '';
	$tocLinks = '<ul id="tocList">';
	if( preg_match_all('/<h(['.$selectedHeadingsString.'])(.*?)>(.*?)(<\/h['.$selectedHeadingsString.']>)/', $content, $result) ){
		foreach( $result[0] as $key => $title ){
			$headingText = strip_tags($result[0][$key]);
			$headingTag = "h".$result[1][$key];
			// get existing id/class
			$tagIdRegexOutput = split('"',$result[2][$key]);
			if( $tagIdRegexOutput[0] ){
				$tagRef = $tagIdRegexOutput[1];	
			} else {
				$tagRef = str_replace(' ', '_', $headingText);
			}
			
			$indentPos = $result[1][$key];
			if(!empty($result[2][$key])){
				$tagData = $result[2][$key];
			} else {
				$tagData = '';
			}
			$tocLinks .= '<li class="tocLevel' . $indentPos .'"><a class="tocLink" href="#'.$tagRef.'">'.$headingText.'</a>'.'</li>';
			$content = str_replace($result[0][$key], '<a name="'.$tagRef.'"></a><' .$headingTag . $tagData . '>' .$headingText. '</' .$headingTag. '>', $content);
		}
	}
	$tocLinks .= '</ul>';
	return $tocLinks;
}
