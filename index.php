<?php /*
Plugin Name: SidTechno Scroll count
Plugin URI: http://sitechno.com
description: sync SWL to WOO and WOO to SWL
Version: 1
Author: Muhammad Saad
Author URI: http://sidtechno.com
*/

add_action( 'load-post.php', 'sidtechno_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'sidtechno_post_meta_boxes_setup' );
function sidtechno_post_meta_boxes_setup() {
  /* Add meta boxes on the 'add_meta_boxes' hook. */
  add_action( 'add_meta_boxes', 'sidtechno_add_post_meta_boxes' );
  add_action( 'save_post', 'sidtechno_save_post_class_meta', 10, 2 );
}
function sidtechno_add_post_meta_boxes() {

  add_meta_box(
    'sidtechno-post-class',      // Unique ID
    'Page count setting',    // Title
    'sidtechno_post_class_meta_box',   // Callback function
    'post',         // Admin page (or post type)
    'side',         // Context
    'default'         // Priority
  );
}

/* Display the post meta box. */
function sidtechno_post_class_meta_box( $post ) {
  wp_nonce_field( basename( __FILE__ ), 'sidtechno_post_class_nonce' );

  echo '<p>
    <label for="sidtechno-post-class">Total Second</label>
    <br />
    <input class="widefat" type="text" name="sidtechno-count-total-second" id="sidtechno-post-class" value="'; if(isset($post->ID)) { echo esc_attr( get_post_meta( $post->ID, 'sidtechno_count_total_second', true ) ); } echo '" size="30" />
    <br />
    <br />

    <label for="sidtechno-post-class">PX in seconds</label>
    <br />
    <input class="widefat" type="text" name="sidtechno-count-px-second" id="sidtechno-post-class" value="'; if(isset($post->ID)) { echo esc_attr( get_post_meta( $post->ID, 'sidtechno_count_px_second', true ) ); } echo '" size="30" />
  </p>';
}

function sidtechno_save_post_class_meta( $post_id, $post ) {

  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['sidtechno_post_class_nonce'] ) || !wp_verify_nonce( $_POST['sidtechno_post_class_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

  $new_sidtechno_count_total_second_value = ( isset( $_POST['sidtechno-count-total-second'] ) ? sanitize_html_class( $_POST['sidtechno-count-total-second'] ) : ’ );
  $sidtechno_count_total_second_key = 'sidtechno_count_total_second';
  $sidtechno_count_total_second_value = get_post_meta( $post_id, $sidtechno_count_total_second_key, true );
  if ( $new_sidtechno_count_total_second_value && ’ == $sidtechno_count_total_second_value )
    add_post_meta( $post_id, $sidtechno_count_total_second_key, $new_sidtechno_count_total_second_value, true );
  elseif ( $new_sidtechno_count_total_second_value && $new_sidtechno_count_total_second_value != $sidtechno_count_total_second_value )
    update_post_meta( $post_id, $sidtechno_count_total_second_key, $new_sidtechno_count_total_second_value );
  elseif ( ’ == $new_sidtechno_count_total_second_value && $sidtechno_count_total_second_value )
    delete_post_meta( $post_id, $sidtechno_count_total_second_key, $sidtechno_count_total_second_value );


  $new_sidtechno_count_px_second_value = ( isset( $_POST['sidtechno-count-px-second'] ) ? sanitize_html_class( $_POST['sidtechno-count-px-second'] ) : ’ );
  $sidtechno_count_px_second_key = 'sidtechno_count_px_second';
  $sidtechno_count_px_second_value = get_post_meta( $post_id, $sidtechno_count_px_second_key, true );
  if ( $new_sidtechno_count_px_second_value && ’ == $sidtechno_count_px_second_value )
    add_post_meta( $post_id, $sidtechno_count_px_second_key, $new_sidtechno_count_px_second_value, true );
  elseif ( $new_sidtechno_count_px_second_value && $new_sidtechno_count_px_second_value != $sidtechno_count_px_second_value )
    update_post_meta( $post_id, $sidtechno_count_px_second_key, $new_sidtechno_count_px_second_value );
  elseif ( ’ == $new_sidtechno_count_px_second_value && $sidtechno_count_px_second_value )
    delete_post_meta( $post_id, $sidtechno_count_px_second_key, $sidtechno_count_px_second_value );
}

add_action( 'admin_menu', 'register_sidtecho_scroll_count_menu' );
function register_sidtecho_scroll_count_menu() {
  // add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
  add_menu_page( 'Scroll Count', 'Scroll Count', 'manage_options', 'sidtecho_scroll_count_menu', 'return_sidtecho_scroll_count_menu', 'dashicons-welcome-widgets-menus', 4 );
}
function return_sidtecho_scroll_count_menu() {
	if(isset($_POST['submit'])) {
		update_option( 'sidtechno_total_second', $_POST['total_second'] );
		update_option( 'sidtechno_total_px_per_second', $_POST['total_px_per_second'] );
		update_option( 'sidtechno_total_text', $_POST['total_text'] );

		$total_second = $_POST['total_second'];
		$total_px_per_second = $_POST['total_px_per_second'];
		$total_text = $_POST['total_text'];
	}

	$total_second = get_option( 'sidtechno_total_second' );
	$total_px_per_second = get_option( 'sidtechno_total_px_per_second' );
	$total_text = get_option( 'sidtechno_total_text' );

	echo '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">';
	echo '<div class="d-flex align-items-start mt-5 gap-5">
		    <div class="tab-content col-md-12 border shadow p-4" id="ship-tab-content">
				<h3>Scroll Count setting</h3>
        		<form action="" method="post">
				    <div class="tab-content col-md-12 border shadow p-4" id="ship-tab-content">
	    	            <div class="mb-3">
							<div class="col">
	                            <label for="total_second" class="form-label">Total Second</label>
	                            <input type="text" class="form-control form-control-sm" name="total_second" id="total_second" value="'.$total_second.'">
	                        </div>
							<div class="col">
	                            <label for="total_px_per_second" class="form-label">Total PX per Second</label>
	                            <input type="text" class="form-control form-control-sm" name="total_px_per_second" id="total_px_per_second" value="'.$total_px_per_second.'">
	                        </div>
							<div class="col">
	                            <label for="total_text" class="form-label">Total PX per Second</label>
	                            <input type="text" class="form-control form-control-sm" name="total_text" id="total_text" value="'.$total_text.'">
	                        </div>
                        </div>
                    </div>
	                <div>
	                    <div class="col-12 mb-3 ">
	                        <button type="submit " class="btn btn-success" name="submit">Submit</button>
	                    </div>
	                </div>
        		</form>
    		</div>
		</div>';
}

function theme_prefix_enqueue_script() {
	if ( ! wp_script_is( 'jquery', 'done' ) ) {
		wp_enqueue_script( 'jquery' );
	}

	$useragent=$_SERVER['HTTP_USER_AGENT'];

	if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
		if ( is_single() && 'post' == get_post_type() ) {
			$total_second = esc_attr( get_post_meta( get_the_ID(), 'sidtechno_count_total_second', true ) );
			$total_px_per_second = esc_attr( get_post_meta( get_the_ID(), 'sidtechno_count_px_second', true ) );

			if(empty($total_second)) {
				$total_second = get_option( 'sidtechno_total_second' );
			}

			if(empty($total_px_per_second)) {
				$total_px_per_second = get_option( 'sidtechno_total_px_per_second' );
			}

			wp_add_inline_script( 'jquery-migrate', 'jQuery(document).ready(function(){
				var target = jQuery(\'html,body\');
				var total_height = target.height();
				console.log(total_height);
				var total_time = parseInt(\''.$total_second.'\');
				var total_time_multiple = total_time * 1000;
				var second_per_px = parseInt(\''.$total_px_per_second.'\');
				var total_text = \''.get_option('sidtechno_total_text').'\';

				if(total_time > 0) {
					ii = 0;
					for (let i = total_time; i >= 0; i--) {
				        (function(i){
				        	if(i == total_time) {
								jQuery("#loading").remove();
	                    		jQuery("body").append(\'<div id="loading" style="width: 100%;height: 100%;position: fixed;top: 0;left: 0;z-index: 10;text-align: center;vertical-align: middle;padding: 9px 0;font-weight: bold;color: #fff;z-index: 1000;border-radius: 10px;font-size: 50px;"><div class="center_fix_verticle" style="width:100%; position: fixed;top: 50%;left: 50%;transform: translate(-50%, -50%);"><span class="show_message" style="font-size: 20px;color: #000;">\'+total_text+\'<br><span style="font-size:50px;">\'+i+\'</span></span></div>    </div>\');
			        		} else {
					            setTimeout(function(){
									jQuery("#loading").remove();
		                    		jQuery("body").append(\'<div id="loading" style="width: 100%;height: 100%;position: fixed;top: 0;left: 0;z-index: 10;text-align: center;vertical-align: middle;padding: 9px 0;font-weight: bold;color: #fff;z-index: 1000;border-radius: 10px;font-size: 50px;"><div class="center_fix_verticle" style="width:100%; position: fixed;top: 50%;left: 50%;transform: translate(-50%, -50%);"><span class="show_message" style="font-size: 20px;color: #000;">\'+total_text+\'<br><span style="font-size:50px;">\'+i+\'</span></span></div>    </div>\');
					            }, 1000*ii);
			        		}
				            ii++;
						})(i);
                	}
				}
				per_px = Math.ceil(target.height() / second_per_px);
				if(per_px > total_time) {
					var new_height = second_per_px * total_time;
				} else {
					new_height = target.height();
					total_time = per_px;
				}
				target.animate({scrollTop: new_height}, total_time * 1000);

	            setTimeout(function(){
					jQuery("#loading").remove();
					target.animate({scrollTop: 0}, 1000);
	            }, total_time * 1000);
			});' );
		}

	}

}
add_action( 'wp_enqueue_scripts', 'theme_prefix_enqueue_script' );
?>
