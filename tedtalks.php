<?php
/*
Plugin Name: TEDTalks Embedder
Plugin URI: http://www.samuelaguilera.com
Description: Helps you to embed TEDTalks videos on your self hosted WordPress simply using same shortcode used for WordPress.com
Version: 1.0.1
Author: Samuel Aguilera
Author URI: http://www.samuelaguilera.com
*/

define("TEDTALKS_REGEXP", "/\[ted id=([[:print:]]+)\]/");

define("TEDTALKS_REGEXP_LANG", "/\[ted id=([[:print:]]+) lang=([[:print:]]+)\]/");

function tedtalks_plugin_callback($match) {

  global $post;

  $ted_talk_meta = get_post_meta($post->ID, 'ted_talk_'.$match[1], 'true');
  
    if (empty($ted_talk_meta)) {

         if (empty($match[2])) {
            $ted_talk_language = 'eng';   
         } else {
            $ted_talk_language = $match[2];   
         }
      
          $ted_talk_url = 'http://www.ted.com/talks/view/lang/'.$ted_talk_language.'/id/'.$match[1];
      
          $ted_talk_page = wp_remote_fopen($ted_talk_url);
      
      
              if(preg_match("/(&lt;!--copy and paste--&gt;)(.*)(&lt;\/object&gt;)/i", $ted_talk_page, $matches))
              {
                  $output = $matches[1]; // inicio del código embed
                  $output.= $matches[2]; // cuerpo del código embed
                  $output.= $matches[3]; // fin del código embed
                  $output = htmlspecialchars_decode($output);            
              } 
      
          add_post_meta($post->ID, 'ted_talk_'.$match[1], $output, true);
          
          return ($output); 
          
    }	else {
    
      $ted_talk_meta = get_post_meta($post->ID, 'ted_talk_'.$match[1], true);
      
      return ($ted_talk_meta);
    
    }          
                
}

function tedtalks_plugin($content) {
  
  global $post;
  
          $enabled_subtitles = preg_match(TEDTALKS_REGEXP_LANG, $content);
          
          if ($enabled_subtitles) {
          
              return (preg_replace_callback(TEDTALKS_REGEXP_LANG, 'tedtalks_plugin_callback', $content));
          
          } else {
          
              return (preg_replace_callback(TEDTALKS_REGEXP, 'tedtalks_plugin_callback', $content));
          
          }

}

add_filter('the_content', 'tedtalks_plugin');


?>
