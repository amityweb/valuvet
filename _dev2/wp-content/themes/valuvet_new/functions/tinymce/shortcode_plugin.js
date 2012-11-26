// closure to avoid namespace collision
(function(){
	// creates the plugin
	tinymce.create('tinymce.plugins.mygallery', {
		// creates control instances based on the control's id.
		// our button's id is "mygallery_button"
		createControl : function(id, controlManager) {
			if (id == 'mygallery_button') {
				// creates the button
				var button = controlManager.createButton('mygallery_button', {
					title : 'Shortcodes Index', // title of the button
					image : '../wp-content/themes/valuvet_new/images/icon.png',  // path to the button's image
					onclick : function() {
						// triggers the thickbox
						var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
						W = W - 80;
						H = H - 84;
						tb_show( 'Shortcodes', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=mygallery-form' );
					}
				});
				return button;
			}
			return null;
		}
	});
	
	// registers the plugin. DON'T MISS THIS STEP!!!
	tinymce.PluginManager.add('mygallery', tinymce.plugins.mygallery);
	
	// executes this when the DOM is ready
	jQuery(function(){
		// creates a form to be displayed everytime the button is clicked
		// you should achieve this using AJAX instead of direct html code like this
		var form = jQuery('<div id="mygallery-form"><table id="mygallery-table" style="margin-top: 20px;" class="form-table">\
			<tr class="myshortcode">\
				<td><label for="myshortcode">Select the shortcode :</label>\
					<select style="width: 250px;" name="shortcode" id="myshortcode">\
						<option selected>--------------------</option>\
						<option value="clear">clear</option>\
						<option value="btn">button</option>\
						<option value="divider">divider</option>\
						<option value="success">success message</option>\
						<option value="error">error message</option>\
						<option value="info">info message</option>\
						<option value="warning">warning message</option>\
						<option value="fancybox_link">Fancybox iframe content link</option>\
						<option value="fancybox_inline">Fancybox inline content link</option>\
						<option value="fullpage_left">Full Page Left Panel</option>\
						<option value="fullpage_right">Full Page Right Panel</option>\
						<option value="fullpage_property_left">Full Page Property Left Panel</option>\
						<option value="fullpage_property_right">Full Page Property Right Panel</option>\
						<option value="show_property_map">Property Map</option>\
						<option value="link_subscribe_property_alert">Subscribe to property alert link</option>\
						<option value="request_property_evaluvation">Request Property Evaluvation Button</option>\
					</select>\
				</td>\
			</tr>\
			<tr class="btn" style="display: none;">\
				<th><label for="btn_content">Button Text</label></th>\
				<td><input type="text" value="" id="btn_content" style="width: 100%;" /><br />\
				<small>The text that appears on the button.</small></td>\
			</tr>\
			<tr class="btn" style="display: none;">\
				<th><label for="btn_linkto">Link Url</label></th>\
				<td><input type="text" value="" id="btn_linkto" style="width: 100%;" /><br />\
				<small>The URL the button points to.</small></td>\
			</tr>\
			<tr class="btn" style="display: none;">\
				<th><label for="btn_content">Button CSS</label></th>\
				<td><input type="text" value="" id="btn_css" style="width: 100%;" /><br />\
				<small>CSS properties if exsists.</small></td>\
			</tr>\
			<tr class="success" style="display: none;">\
				<th><label for="success_content">Content</label></th>\
				<td><textarea type="text" name="text" id="success_content" style="width: 100%;"></textarea><br />\
				<small>The content text of the success message.</small></td>\
			</tr>\
			<tr class="error" style="display: none;">\
				<th><label for="error_content">Content</label></th>\
				<td><textarea type="text" name="text" id="error_content" style="width: 100%;"></textarea><br />\
				<small>The content text of the error message.</small></td>\
			</tr>\
			<tr class="info" style="display: none;">\
				<th><label for="info_content">Content</label></th>\
				<td><textarea type="text" name="text" id="info_content" style="width: 100%;"></textarea><br />\
				<small>The content text of the info message.</small></td>\
			</tr>\
			<tr class="warning" style="display: none;">\
				<th><label for="warning_content">Content</label></th>\
				<td><textarea type="text" name="text" id="warning_content" style="width: 100%;"></textarea><br />\
				<small>The content text of the warning message.</small></td>\
			</tr>\
			<tr class="fancybox_link" style="display: none;">\
				<th><label for="fancybox_link_content">Fancybox link</label></th>\
				<td><input type="text" name="fancybox_link_id" id="fancybox_link_id" style="width: 100%;"><br />\
				<small>Id for the link. Can not have same id twice in one page</small></td>\
			</tr>\
			<tr class="fancybox_link" style="display: none;">\
				<th><label for="fancybox_link_content">Fancybox link URL</label></th>\
				<td><input type="text" name="fancybox_link_linkto" id="fancybox_link_linkto" style="width: 100%;"><br />\
				<small>Link URL</small></td>\
			</tr>\
			<tr class="fancybox_link" style="display: none;">\
				<th><label for="fullpage_right_content">Fancybox Content</label></th>\
				<td><input type="text" name="fancybox_link_content" id="fancybox_link_content" style="width: 100%;"><br />\
				<small>Content for link</small></td>\
			</tr>\
			<tr class="fancybox_inline" style="display: none;">\
				<th><label for="fancybox_inline_data">Fancybox data container ID</label></th>\
				<td><input type="text" name="fancybox_inline_data_block" id="fancybox_inline_data_block" style="width: 100%;"><br />\
				<small>Data block id to popup</small></td>\
			</tr>\
			<tr class="fancybox_inline" style="display: none;">\
				<th><label for="fancybox_inline_id">Fancybox link ID</label></th>\
				<td><input type="text" name="fancybox_inline_id" id="fancybox_inline_id" style="width: 100%;"><br />\
				<small>Id for your link, if so</small></td>\
			</tr>\
			<tr class="fancybox_inline" style="display: none;">\
				<th><label for="fancybox_inline_text">Fancybox link text</label></th>\
				<td><input type="text" name="fancybox_inline_text" id="fancybox_inline_text" style="width: 100%;"><br />\
				<small>Text need to display on the link</small></td>\
			</tr>\
			<tr class="fancybox_inline" style="display: none;">\
				<th><label for="fullpage_right_content">Fancybox Content</label></th>\
				<td><textarea name="fancybox_inline_content" id="fancybox_inline_content" style="width: 100%;"></textarea><br />\
				<small>Content need to hide and popup when click on the link</small></td>\
			</tr>\
			<tr class="fullpage_left" style="display: none;">\
				<th><label for="fullpage_inline_content">Page Left Content</label></th>\
				<td><textarea name="fullpage_inline_content" id="fullpage_inline_content" style="width: 100%;"></textarea><br />\
				<small>Content for link</small></td>\
			</tr>\
			<tr class="fullpage_right" style="display: none;">\
				<th><label for="fullpage_right_content">Page Right Content</label></th>\
				<td><textarea name="fullpage_right_content" id="fullpage_right_content" style="width: 100%;"></textarea><br />\
				<small>Content for right panel in full page template</small></td>\
			</tr>\
			<tr class="fullpage_property_left" style="display: none;">\
				<th><label for="fullpage_property_right_content">Property sale left Content</label></th>\
				<td><textarea name="fullpage_property_left_content" id="fullpage_property_left_content" style="width: 100%;"></textarea><br />\
				<small>Content for property page left panel in full page template</small></td>\
			</tr>\
			<tr class="fullpage_property_right" style="display: none;">\
				<th><label for="fullpage_property_right_content">Property sale right Content</label></th>\
				<td><textarea name="fullpage_property_right_content" id="fullpage_property_right_content" style="width: 100%;"></textarea><br />\
				<small>Content for property page right panel in full page template</small></td>\
			</tr>\
		</table>\
		<p class="submit">\
			<input type="button" id="mygallery-submit" class="button-primary" value="Insert" name="submit" />\
		</p>\
		</div>');		
		
		
		var table = form.find('table');
		form.appendTo('body').hide();		
		
		table.find('#myshortcode').change(function(){
			var mycode = table.find('#myshortcode').val();
			table.find('tr').not('.myshortcode').css("display", "none");			
			table.find('.'+mycode).css("display", "block");
		});
		
		
		// handles the click event of the submit button
		form.find('#mygallery-submit').click(function(){
			// defines the options and their default values
			// again, this is not the most elegant way to do this
			// but well, this gets the job done nonetheless

			var current = table.find('#myshortcode').val();
			var shortcode;
			
			if(current == 'clear')
			shortcode = '[clear /]';
			
	
			else if(current == 'divider') {
				shortcode = '[divider /]';
			}
			
			else if(current == 'btn')
			shortcode = '[btn css="'+table.find('#btn_css').val()+'" linkto="'+table.find('#btn_linkto').val()+'"]'+table.find('#btn_content').val()+'[/btn]';
			
			else if(current == 'fancybox_link')
			shortcode = '[fancybox_link id="'+table.find('#'+current+'_id').val()+'" linkto="'+table.find('#'+current+'_linkto').val()+'"]'+table.find('#'+current+'_content').val()+'[/'+current+']';
			
			else if(current == 'fancybox_inline')
			shortcode = '[fancybox_inline id="'+table.find('#'+current+'_id').val()+'" data="'+table.find('#'+current+'_data_block').val()+'" text="'+table.find('#'+current+'_text').val()+'"]'+table.find('#'+current+'_content').val()+'[/'+current+']';
			
			else if(current == 'success' || current == 'error'  || current == 'info'  || current == 'warning')
			shortcode = '['+current+']'+table.find('#'+current+'_content').val()+'[/'+current+']';

			else if(current == 'fullpage_left' )
			shortcode = '['+current+']'+table.find('#'+current+'_content').val()+'[/'+current+']';
						

			else if(current == 'show_property_map' )
			shortcode = '['+current+'][/'+current+']';
			
			
			else if(current == 'fullpage_right' )
			shortcode = '['+current+']'+table.find('#'+current+'_content').val()+'[/'+current+']';
			
			else if(current == 'fullpage_property_left' )
			shortcode = '['+current+']'+table.find('#'+current+'_content').val()+'[/'+current+']';
						

			else if(current == 'fullpage_property_right' )
			shortcode = '['+current+']'+table.find('#'+current+'_content').val()+'[/'+current+']';
			
			else if(current == 'link_subscribe_property_alert' )
			shortcode = '['+current+'][/'+current+']';

			else if(current == 'request_property_evaluvation' )
			shortcode = '['+current+'][/'+current+']';
			
			else 
			shortcode = '';
			
			// inserts the shortcode into the active editor
			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			// closes Thickbox
			tb_remove();
		});
	});
})()