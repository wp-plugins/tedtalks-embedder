<?php
/*
Plugin Name: TEDTalks Embedder
Plugin URI: http://www.samuelaguilera.com
Description: Helps you to embed TEDTalks videos on your self hosted WordPress simply using same shortcode used for WordPress.com
Version: 1.0.2
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
          $ted_talk_url = wp_remote_get($ted_talk_url);
      
          $ted_talk_page = wp_remote_retrieve_body($ted_talk_url);
          $ted_talk_page = htmlspecialchars_decode($ted_talk_page);
          $ted_talk_embbed = preg_match('/(<!--copy and paste-->)((<object[^>]*?>(?:[\s\S]*?)<\/object>))/i', $ted_talk_page, $matches);

                           
            if($ted_talk_embbed)                                    
              {
                  add_post_meta($post->ID, 'ted_talk_'.$match[1], $matches[2], true);

              } else {
              
                 add_post_meta($post->ID, 'ted_talk_'.$match[1], "Can't get data from TED.com or embed data is missing.", true);
              }


          // Next two lines only for testing. Uncomment them to add HTTP response code to your post.
        //  $reponsde_code = wp_remote_retrieve_response_code($ted_talk_url);
        //  add_post_meta($post->ID, 'response_code_tedtalk_'.$match[1], $reponsde_code, true);
          
          return ($matches[2]); 
          
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
