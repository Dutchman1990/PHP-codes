<?php
/*
Plugin Name: Image Upload
Description: A test plugin
Author: Nirjhar Mistry
Version: Mark I
*/
add_action('admin_menu', 'my_test_plugin');
 
function my_test_plugin(){
        add_menu_page( 'Test Plugin Page', 'Image Upload', 'manage_options', 'test-plugin', 'test_init' );
}
 
function test_init(){
        test_handle_post();
?>
        <h2>Upload a File</h2>
        
        <form  method="post" enctype="multipart/form-data">
                <input type='file' id='my_image' name='my_image'></input>
                <?php submit_button('Upload') ?>
        </form>

<?php
}
 
function test_handle_post(){
                $uploaded=media_handle_upload('my_image', 0);
                if(is_wp_error($uploaded)){
                        echo "Error uploading file: " . $uploaded->get_error_message();
                }else{
                        echo "File upload successful!";
                }
        }

 
?>
