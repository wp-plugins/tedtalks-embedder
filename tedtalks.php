<?php
/*
Plugin Name: TEDTalks Embedder
Plugin URI: http://www.samuelaguilera.com
Description: Helps you to embed TEDTalks videos on your self hosted WordPress simply using same shortcode used for WordPress.com
Version: 1.1
Author: Samuel Aguilera
Author URI: http://www.samuelaguilera.com
*/


add_shortcode('ted', 'sar_ted_talk_shortcode');


    function sar_ted_talk_shortcode($attr) {
    
      global $post;
    
      $ted_talk_meta = get_post_meta($post->ID, 'ted_talk_'.$attr['id'], 'true');
      
        if (empty($ted_talk_meta)) {
    
             if (empty($attr['lang'])) {
                $ted_talk_language = 'eng';   
             } else {
                $ted_talk_language = $attr['lang'];   
             }
             
          $ted_talk_url = 'http://www.ted.com/talks/view/lang/'.$ted_talk_language.'/id/'.$attr['id'];
          $ted_talk_url = wp_remote_get($ted_talk_url);
      
          $ted_talk_page = wp_remote_retrieve_body($ted_talk_url);
          $ted_talk_page = htmlspecialchars_decode($ted_talk_page);
          $ted_talk_embbed = preg_match('/(<!--copy and paste-->)((<object[^>]*?>(?:[\s\S]*?)<\/object>))/i', $ted_talk_page, $matches);

                           
            if($ted_talk_embbed)                                    
              {
                  add_post_meta($post->ID, 'ted_talk_'.$attr['id'], $matches[2], true);

              } else {
              
                 add_post_meta($post->ID, 'ted_talk_'.$attr['id'], "Can't get data from TED.com or embed data is missing.", true);
              }


          // Next two lines only for testing. Uncomment them to add HTTP response code to your post.
        //  $reponsde_code = wp_remote_retrieve_response_code($ted_talk_url);
        //  add_post_meta($post->ID, 'response_code_tedtalk_'.$attr['id'], $reponsde_code, true);
          
                return ($matches[2]); 
          
            }	else {
            
              $ted_talk_meta = get_post_meta($post->ID, 'ted_talk_'.$attr['id'], true);
              
                return ($ted_talk_meta);
            
            }              
    
    }  // end sar_ted_talk_shortcode

?>
