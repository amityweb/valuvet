<div class="clear"></div>

</div>

</div>

</div>

<!-- end page -->







    <div id="footer_shadow">&nbsp;</div>

	<div id="base_col_wrap">

            <div class="col_bg col_padd">

            	<div class="col_width">

                	<div class="headingmenu" style="margin-bottom:7px;">

                    <ul>

                        <li><a style="cursor:s-resize;"><span class="headingmenu10">Subscribe to our Newsletter</span></a></li>

                    </ul>

                    </div>

                    <div class="form_openclose acc_con" style="height: 205px; opacity: 1; display:none;">

                     <form id="enews" method="post" action="" class="cmxform">

                        <input name="formtype" value="enewsletter_subscribe" type="hidden">

                          <fieldset>

                            <h4 class="hed_tugle">Mandatory fields marked <em>*</em></h4>

                         <!-- <legend>Contact Details</legend> -->

                        

                           <ol>

                            <li>

                              <label for="s_fullname">Full Name <em>*</em></label>

                              <input class="wide form_req" name="s_fullname" id="s_fullname">

                            </li>

                            <li>

                              <label for="s_email">Email <em>*</em></label>

                              <input id="s_email" name="s_email" class="form_req_email">

                            </li>

                        <li>

                        <input name="newsletter_unsubscribe" value="un_subscribe" type="checkbox">&nbsp;&nbsp;Click here to un-subscribe

                        </li>

                        

                          </ol>

                          </fieldset>

                        

                            <input id="submit_enews" value="Submit" type="submit"> 

                        </form>
                    </div>

                    <div><img src="<?php bloginfo('stylesheet_directory'); ?>/images/vv_news_autumn_2011.jpg" alt="" /></div>

                </div>

			</div>

            

        	<div class="col_bg col_padd">

            	<div class="headline_row">

                	<div class="headline_right">

                    	<div class="col_width">

                            <div class="headingmenu">

                                <ul>

                                    <li><a href="#"><span>Feature Property - FOR SALE</span></a></li>

                                </ul>

                            </div>

                            <?php /*?><div id="feature_property" class="feature_property_con">
                            <?php
								$page_id =42;
								$page_data = get_page( $page_id );
								$content = apply_filters('the_content', $page_data->post_content); 
								echo $content;
							?>
                    		</div>
                           <?PHP
								edit_post_link( 'Edit this entry', '', '', 42 );
							?><?php */?>	
                            
                            
                            
                            
                            
                            <?php query_posts('category_name=FeatureProperty_forsale&showposts=10'); ?>
            <div id="feature_property" class="feature_property_con"> 
			<?php  while (have_posts()) : the_post(); ?>
              
          <div><a href="<?php the_permalink() ?>"><?php  $myExcerpt = get_the_excerpt();
  				$tags = array("", "");
				  $myExcerpt = str_replace($tags, "", $myExcerpt);
				  echo $myExcerpt;
				  ?></a>
                    <h1><?php the_title(); ?></h1>
                    <div style="position: relative; margin: 0 auto; text-align: center;"><a href="<?php the_permalink() ?>">view more…</a></div>
</div>
				
                <?php paginate_comments_links( $args ) ?> 
                <?php endwhile;?>
                </div>
                            
                            
                            

                        </div>

                    </div>

                </div>

            </div>

            

        	<div class="col_bg">

           	  <div class="col_width">

                <div class="headingmenu">

                        <ul>

                          <li><a href="#"><span>National Visting Schedule</span></a></li>

                        </ul>

                </div>

                  

                <?php

						$page_id = 43;

						$page_data = get_page( $page_id );

						$content = apply_filters('the_content', $page_data->post_content); 

						echo $content;

						edit_post_link( 'Edit this entry', '', '', 43 );  

						

					?>

        		</div>		        

        </div>

        <div class="clear"></div>

        <div style="padding-top:20px;">&nbsp;</div>

        

        

        

        <!--Part Footer-->

        <div id="footer2_bot">

            <ul>

                <li>Copyright © 2008 - 2011 VALUVET Pty Ltd &nbsp; </li>

                <li><a href="">PRIVACY POLICY</a></li>

                <li><a href="#">CONTACT</a></li>

                <li><a href="#"><img src="<?php bloginfo('stylesheet_directory'); ?>/images/logo_hq_green2.gif" alt="My Website is Green - Certified by Huxbury Quinn Green Hosting" /></a></li>

            </ul>

        </div>

        