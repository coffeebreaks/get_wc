<?php
/**
 * @package get_wc
 * @version 1.0.0
 */
/*
Plugin Name: Get WC
Description: Fasthooks for WC product data
Author: Stefan Jakobsson
Version: 1.0.0

*/

//Usage in template

// $id = get_the_ID();
// do_action("get_wc", $id, "name", "my-class");
// do_action("get_wc", $id, "description", "my-class");
// do_action("get_wc", $id, "add_to_cart", "my-class");
// do_action("get_wc", $id, "price", "my-class");
// do_action("get_wc", $id, "gallery", "my-class");
// do_action("get_wc", $id, "image", "my-class");

//Roadmap

// - Add support for product attributes
// - Add support for shipping class

function get_params($id, $fetch_data, $class){
	
	$product = wc_get_product($id);
    switch ($fetch_data){
        case "price":
            if ($product->get_sale_price()){ 
				echo " <div class=' " . $class . "'>" . "<span class='on-sale'>" . $product->get_regular_price() . "</span>" . $product->get_sale_price() . "</div>" ; 
            }
            else {
				echo " <div class=' " . $class . "'>" . $product->get_regular_price() . "</div>" ; 
            }
            break;
			
			case "name":
				echo " <div class=' " . $class . "'>" . $product->get_name() . "</div>" ; 
				break;
				
			case "sku":
				echo " <div class=' " . $class . "'>" . $product->get_sku() . "</div>" ; 
				break;
				
			case "description":
				echo " <div class=' " . $class . "'>" . $product->get_description() . "</div>" ; 
				break;
				
			case "short_description":
				echo " <div class=' " . $class . "'>" . $product->get_short_description() . "</div>" ; 
				break;
				
			case "sale_price":
				echo " <div class=' " . $class . "'>" . $product->get_sale_price() . "</div>" ; 
				break;

			case "regular_price":
				echo " <div class=' " . $class . "'>" . $product->get_regular_price() . "</div>" ; 
				break;
									
			case "image":
	            $img_id = $product->get_image_id();
    	        echo " <div class=' " . $class . "'>" . wp_get_attachment_image($img_id, 'full') . "</div>" ; 
        	    break;
       
			case "add_to_cart":
				echo "<a id='addToCart' class='" . $class . "' href='?add-to-cart=" .  $id . "&quantity=1" ." '> Lägg i varukorg</a>";
				echo "<input onchange='updateCart(". $id .")' type='number' min='1' max='100' value='1' id='qty'>";
				
				?>
            <script>

				function updateCart(id){
					qty = document.getElementById('qty').value
					if (qty > 100){qty = 100}
					document.getElementById("addToCart").href = "?add-to-cart=" + id + "&quantity=" + qty
				}

			</script>
            
			<?php
			
            break;
			
			case "gallery":
				$attachment_ids = $product->get_gallery_image_ids();
				echo " <div class=' " . $class . "'>";
             foreach( $attachment_ids as $attachment_id ) {
				 $image_link = wp_get_attachment_url( $attachment_id );
				 echo "<img src='". $image_link ."'>  ";
                }
            echo "</div>" ; 
            break;
			
			
         default:
		 echo "";
		 
        }

	}
	
	add_action( 'get_wc', 'get_params', 10, 3 );