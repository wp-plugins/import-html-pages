<?php

function html_import_get_options() {
	$defaults = array(
		'root_directory' => __(ABSPATH.'html-files-to-import', 'import-html-pages'),
		'old_url' => '',
		'file_extensions' => 'html,htm,shtml',
		'skipdirs' => __('images,includes', 'import-html-pages'),
		'status' => 'publish',
		'root_parent' => 0,
		'type' => 'page',
		'timestamp' => 'filemtime',
		'import_content' => 'tag',
		'content_region' => '',
		'content_tag' => __('div', 'import-html-pages'),
		'content_tagatt' => __('id', 'import-html-pages'),
		'content_attval' => __('content', 'import-html-pages'),
		'clean_html' => 0,
		'allow_tags' => '<p><br><img><a><ul><ol><li><blockquote><cite><em><i><strong><b><h2><h3><h4><h5><h6><hr>',
		'allow_attributes' => 'href,alt,title,src',
		'encode' => 0,
		'import_title' => 'tag',
		'title_region' => '',
		'title_tag' => __('title', 'import-html-pages'),
		'title_tagatt' => '',
		'title_attval' => '',
		'remove_from_title' => '',
		'meta_desc' => 1,
		'user' => 0,
	);
	$options = get_option('html_import');
	if (!is_array($options)) $options = array();
	return array_merge( $defaults, $options );
}

function html_import_options_page() { ?>
	<div class="wrap">
		<h2><?php _e( 'HTML Import Settings', 'import-html-pages'); ?></h2> 
		<form method="post" id="html_import" action="options.php">
			<?php 
			settings_fields('html_import');
			get_settings_errors( 'html_import' );	
			settings_errors( 'html_import' );
			$options = get_option('html_import');
			?>

	<div class="ui-tabs">
		<ul class="ui-tabs-nav">
			<li><a href="#files"><?php _e("Files", 'import-html-pages'); ?></a></li>
			<li><a href="#content"><?php _e("Content", 'import-html-pages'); ?></a></li>
			<li><a href="#title"><?php _e("Title", 'import-html-pages'); ?></a></li>
			<li><a href="#metadata"><?php _e("Metadata", 'import-html-pages'); ?></a></li>
			<li><a href="#taxonomies"><?php _e("Categories, Tags, Taxonomies", 'import-html-pages'); ?></a></li>
		</ul>
		
		
		
		<!-- FILES -->
		
		<h3><?php _e("Files", 'import-html-pages'); ?></h3>				
			<table class="form-table ui-tabs-panel" id="files">
		        <tr valign="top">
			        <th scope="row"><?php _e("Directory to import", 'import-html-pages'); ?></th>
			        <td><p><label><input type="text" name="html_import[root_directory]" id="root_directory"
							 	value="<?php esc_attr_e($options['root_directory']); ?>" class="widefloat" />
							</label><br />
							<span class="description">
							<?php _e('This should be a full path from the server root, on the same server where WordPress 
								is running now. Leave blank to upload a single file later.', 'import-html-pages'); ?><br />
								<?php _e('Hint: the full path to this WordPress installation is: '); ?><kbd><?php echo ABSPATH; ?></kbd>
							</span>
						</p></td>
		        </tr>
							
				<tr valign="top">
			        <th scope="row"><?php _e("Old URL", 'import-html-pages'); ?></th>
			        <td><p><label><input type="text" name="html_import[old_url]" id="old_url" 
						value="<?php esc_attr_e($options['old_url']); ?>" class="widefloat" /> </label><br />
						<span class="description">
						<?php _e('The old URL should correspond with your beginning directory. With this URL, 
							.htaccess redirects will be generated for you.', 'import-html-pages'); ?>
						</span>
					</p></td>
		        </tr>
		
				<tr valign="top">
			        <th scope="row"><?php _e("File extensions to include", 'import-html-pages'); ?></th>
			        <td><p><label><input type="text" name="html_import[file_extensions]" id="file_extensions" 
						value="<?php esc_attr_e($options['file_extensions']); ?>" class="widefloat" /> </label><br />
						<span class="description">
						<?php _e("Enter file extensions without periods, separated by commas. All other file types will 
							be ignored.", 'import-html-pages'); ?>
						</span>
					</p></td>
		        </tr>
		
				<tr valign="top">
			        <th scope="row"><?php _e("Directories to exclude", 'import-html-pages'); ?></th>
			        <td><p><label><input type="text" name="html_import[skipdirs]" id="skipdirs" 
						value="<?php esc_attr_e($options['skipdirs']); ?>" class="widefloat" />  </label><br />
						<span class="description">
						<?php _e("Enter directory names, without slashes, separated by commas. All files in these directories 
							will be ignored.", 'import-html-pages'); ?>
						</span>
					</p></td>
		        </tr>
		    </table>
		
		

		<!-- CONTENT -->	
		
		<h3><?php _e("Content", 'import-html-pages'); ?></h3>				
			<table class="form-table ui-tabs-panel" id="content">
				<tr valign="top">
			        <th scope="row"><?php _e("Select content by", 'import-html-pages'); ?></th>
			        <td><p><label>
						<input type="radio" name="html_import[import_content]"
							value="tag" <?php checked($options['import_content'], 'tag'); ?> 
							onclick="javascript: jQuery('#content-region').hide('fast'); jQuery('#content-tag').show('fast');" />
  						<?php _e('HTML tag', 'import-html-pages'); ?></label> 
						&nbsp;&nbsp;
						<label>
						<input type="radio" name="html_import[import_content]"
							value="region" <?php checked($options['import_content'], 'region'); ?> 
							onclick="javascript: jQuery('#content-tag').hide('fast'); jQuery('#content-region').show('fast');" />
	  					<?php _e('Dreamweaver template region', 'import-html-pages'); ?></label>
					</p></td>
		        </tr>
				<tr id="content-tag" <?php if ($options['import_content'] == 'region') echo "style=display:none;"; ?>>
					<th class="taginput"></th>
					<td><table>
				     	<td class="taginput">
				            <label><?php _e("Tag", 'import-html-pages'); ?><br />
				            <input type="text" name="html_import[content_tag]" id="content_tag" value="<?php echo esc_attr_e($options['content_tag']); ?>" />
				            </label>
				            <br />
				            <span class="description"><?php _e("The HTML tag, without brackets", 'import-html-pages'); ?></span>
						</td>
						<td class="taginput">
				            <label><?php _e("Attribute", 'import-html-pages'); ?><br />
				            <input type="text" name="html_import[content_tagatt]" id="content_tagatt" value="<?php esc_attr_e($options['content_tagatt']); ?>" />
				            </label>
				            <br />
				            <span class="description"><?php _e("Leave blank to use a tag without an attribute, or when the attributes don't matter, such as &lt;body&gt;", 'import-html-pages'); ?></span>
						</td>
						<td class="taginput">
				            <label><?php _e("= Value", 'import-html-pages'); ?><br />
				            <input type="text" name="html_import[content_attval]" id="content_attval" value="<?php esc_attr_e($options['content_attval']); ?>" />
				            </label>
				            <br />
				            <span class="description"><?php _e("Enter the attribute's value (such as width, ID, or class name) without quotes", 'import-html-pages'); ?></span>
				        </td>
				</table><td>
				</tr>
				
				<tr id="content-region" <?php if ($options['import_content'] == 'region') echo "style=display:block;"; ?>>
					<th></th>
					<td>
						<label><?php _e("Dreamweaver template region", 'import-html-pages'); ?><br />
				        <input type="text" name="html_import[content_region]" id="content_region" value="<?php esc_attr_e($options['content_region']); ?>" />  
				        </label><br />
				        <span class="description"><?php _e("The name of the editable region (e.g. 'Main Content')", 'import-html-pages'); ?></span>
					</td>
				</tr>
				<tr>
					<th><?php _e("Convert character set to UTF-8", 'import-html-pages'); ?> </th>
					<td>
					<label><input name="html_import[encode]" id="encode" value="1" type="checkbox" 
						<?php checked($options['encode']); ?> /> </label>
					<span class="description"><?php // _e("Check this option if your special characters are not imported correctly.", 'import-html-pages'); ?></span>
				</td></tr>
				<tr>
				<th><?php _e("Use meta description as excerpt", 'import-html-pages'); ?></th>
				<td>
					<label><input name="html_import[meta_desc]" id="meta_desc" value="1" type="checkbox" <?php checked($options['meta_desc']); ?> /> 
						 </label>
					<span class="description"><?php /* printf(__('Excerpts will be stored for both posts and pages. However, to edit and/or display excerpts for pages, you will need to install a plugin such as <a href="%s">PJW Page Excerpt</a>
	or <a href="%s">Excerpt Editor</a>.', 'import-html-pages'), 'http://blog.ftwr.co.uk/wordpress/page-excerpt/', 'http://www.laptoptips.ca/projects/wordpress-excerpt-editor/'); */ ?></span>
				</td>
				</tr>
				<tr>
				<th><?php _e("Clean up bad (Word, Frontpage) HTML", 'import-html-pages'); ?></th>
				<td>
					<label><input name="html_import[clean_html]" id="clean_html"  type="checkbox" value="1" 
						<?php checked($options['clean_html'], '1'); ?> onclick="jQuery(this).is(':checked') && jQuery('.clean-region').show('fast') || jQuery('.clean-region').hide('fast');" /> </label>
				</td>
				</tr>
				<tr class="clean-region" <?php if ($options['clean_html'] == '1') echo "style=display:table-row;"; ?>>
				 
			        	<th><?php _e("Allowed HTML", 'import-html-pages'); ?></th>
			            <td>    <label>
			                <input type="text" name="html_import[allow_tags]" id="allow_tags" 
								value="<?php esc_attr_e($options['allow_tags']); ?>" class="widefloat" />  </label><br />
			                <span class="description"><?php _e("Enter tags (with brackets) to be preserved. All tags not listed here will be removed. <br />Suggested: ", 'import-html-pages'); ?> 
			                &lt;p&gt;
			                &lt;br&gt;
			                &lt;img&gt;
			                &lt;a&gt;
			                &lt;ul&gt;
			                &lt;ol&gt;
			                &lt;li&gt;
			                &lt;blockquote&gt;
			                &lt;cite&gt;
			                &lt;em&gt;
			                &lt;i&gt;
			                &lt;strong&gt;
			                &lt;b&gt;
			                &lt;h2&gt;
			                &lt;h3&gt;
			                &lt;h4&gt;
			                &lt;h5&gt;
			                &lt;h6&gt;
			                &lt;hr&gt;
			                <br />

			                <em><?php _e("If you have data tables, also include:", 'import-html-pages'); ?></em> 
			                &lt;table&gt;
			                &lt;tbody&gt;
			                &lt;thead&gt;
			                &lt;tfoot&gt;
			                &lt;tr&gt;
			                &lt;td&gt;
			                &lt;th&gt;
			                &lt;caption&gt;
			                &lt;colgroup&gt;
			                </span>
			            </td> 
					</tr>
					<tr class="clean-region" <?php if ($options['clean_html'] == '1') echo "style=display:table-row;"; ?>>
					<th><?php _e("Allowed attributes", 'import-html-pages'); ?></th>
			            <td><label>
				 			<input type="text" name="allow_attributes" id="allow_attributes" 
								value="<?php esc_attr_e($options['allow_attributes']); ?>" class="widefloat" />  </label><br />
			            <span class="description"><?php _e("Enter attributes separated by commas. All attributes not listed here will be removed. <br />Suggested: href,src,alt,title<br />
			    			<em>If you have data tables, also include:</em> summary,rowspan,colspan,span", 'import-html-pages'); ?></span>
			            </td> 
			       </tr>
			</table>
			
		

		<!-- TITLE -->

		<h3><?php _e("Title", 'import-html-pages'); ?></h3>				
		<table class="form-table ui-tabs-panel" id="title">
			<tr valign="top">
		        <th scope="row"><?php _e("Select title by", 'import-html-pages'); ?></th>
		        <td><p><label>
					<input type="radio" name="html_import[import_title]"
						value="tag" <?php checked($options['import_title'], 'tag'); ?> 
						onclick="javascript: jQuery('#title-region').hide('fast'); jQuery('#title-tag').show('fast');" />
					<?php _e('HTML tag', 'import-html-pages'); ?></label> 
					&nbsp;&nbsp;
					<label>
					<input type="radio" name="html_import[import_title]"
						value="region" <?php checked($options['import_title'], 'region'); ?> 
						onclick="javascript: jQuery('#title-tag').hide('fast'); jQuery('#title-region').show('fast');" />
  					<?php _e('Dreamweaver template region', 'import-html-pages'); ?></label>
				</p></td>
	        </tr>
			<tr id="title-tag" <?php if ($options['import_title'] == 'region') echo "style=display:none;"; ?>>
				<th class="taginput"></th>
				<td><table>
			     	<td class="taginput">
			            <label><?php _e("Tag", 'import-html-pages'); ?><br />
			            <input type="text" name="html_import[title_tag]" id="title_tag" value="<?php echo esc_attr_e($options['title_tag']); ?>" />
			            </label>
			            <br />
			            <span class="description"><?php _e("The HTML tag, without brackets", 'import-html-pages'); ?></span>
					</td>
					<td class="taginput">
			            <label><?php _e("Attribute", 'import-html-pages'); ?><br />
			            <input type="text" name="html_import[title_tagatt]" id="title_tagatt" value="<?php esc_attr_e($options['title_tagatt']); ?>" />
			            </label>
			            <br />
			            <span class="description"><?php _e("Leave blank to use a tag without an attribute, or when the attributes don't matter, such as &lt;title&gt;", 'import-html-pages'); ?></span>
					</td>
					<td class="taginput">
			            <label><?php _e("= Value", 'import-html-pages'); ?><br />
			            <input type="text" name="html_import[title_attval]" id="title_attval" value="<?php esc_attr_e($options['title_attval']); ?>" />
			            </label>
			            <br />
			            <span class="description"><?php _e("Enter the attribute's value (such as width, ID, or class name) without quotes", 'import-html-pages'); ?></span>
			        </td>
			</table><td>
			</tr>
			
			<tr id="title-region" <?php if ($options['import_content'] == 'region') echo "style=display:table-row;"; ?>>
				<th></th>
				<td>
					<label><?php _e("Dreamweaver template region", 'import-html-pages'); ?><br />
			        <input type="text" name="html_import[content_region]" id="content_region" value="<?php esc_attr_e($options['content_region']); ?>" />  
			        </label><br />
			        <span class="description"><?php _e("The name of the editable region (e.g. 'Page Title')", 'import-html-pages'); ?></span>
				</td>
			</tr>
			<tr>
				<th><?php _e("Phrase to remove from page title: ", 'import-html-pages'); ?></th>
				<td>
					<label><input type="text" name="html[remove_from_title]" id="remove_from_title" value="<?php esc_attr_e($options['remove_from_title']); ?>" class="widefloat" />  </label><br />
					<span class="description"><?php _e("Any common title phrase (such as the site name, which most themes will print automatically)", 'import-html-pages'); ?></span>
				</td>
			</tr>
		</table>
		
		

		<!-- META -->

		<h3><?php _e("Metadata", 'import-html-pages'); ?></h3>				
		<table class="form-table ui-tabs-panel" id="metadata">
			<tr valign="top">
		        <th scope="row"><?php _e("Import files as", 'import-html-pages'); ?></th>
		        <td>
					<?php
					// support all public post types
					$typeselect = '';
					$post_types = get_post_types(array('public'=>true));
					foreach ($post_types as $post_type) {
						if ($post_type != 'attachment') {
							$typeselect .= '<label><input name="type" type="radio" value="' . esc_attr($post_type) . '" '.checked($options['type'], $post_type);
							if (is_post_type_hierarchical($post_type))
								$typeselect .= "onclick=\"javascript: jQuery('#hierarchy').show('fast');\"";
							else
								$typeselect .= "onclick=\"javascript: jQuery('#hierarchy').hide('fast');\"";
							$typeselect .= '> '.$post_type.'</label> &nbsp;&nbsp;';
						}
					}
					echo $typeselect; 
					?>
				</td>
	        </tr>
			<tr>
			<th><?php _e("Set status to", 'import-html-pages'); ?></th>
			<td>
				<select name="html_import[status]" id="status">
			    	<option value="publish" <?php selected('publish', $options['status']); ?>><?php _e("publish", 'import-html-pages'); ?></option>
			        <option value="draft" <?php selected('draft', $options['status']); ?>><?php _e("draft", 'import-html-pages'); ?></option>
			        <option value="private" <?php selected('private', $options['status']); ?>><?php _e("private", 'import-html-pages'); ?></option>
			        <option value="pending" <?php selected('pending', $options['status']); ?>><?php _e("pending", 'import-html-pages'); ?></option>
			    </select>
			</td>
			</tr>
			<tr>
			<th><?php _e("Set timestamps to", 'import-html-pages'); ?></th>
			<td>
				<select name="html_import[timestamp]" id="timestamp">
			    	<option value="now" <?php if ($options['timestamp'] == 'now') echo 'selected="selected"'; ?>><?php _e("now", 'import-html-pages'); ?></option>
			        <option value="filemtime" <?php if ($options['timestamp'] == 'filemtime') echo 'selected="selected"'; ?>>
						<?php _e("last time the file was modified", 'import-html-pages'); ?></option>
			    </select>
			</td>
			</tr>
			<tr>
			<th><?php _e("Set author to", 'import-html-pages'); ?></th>
			<td>
				<?php wp_dropdown_users(array('selected' => $options['user'], 'name' => 'html_import[user]')); ?>
			</td>
			</tr>
			<tr id="hierarchy" <?php if (!is_post_type_hierarchical($options['type'])) echo "style=display:none;"; ?>>
			<th><?php _e("Import pages as children of: ", 'import-html-pages'); ?></th>
			<td>
		        <?php 
		            $pages = wp_dropdown_pages(array('echo' => 0, 'selected' => $options['root_parent'], 'name' => 'html_import[root_parent]', 'show_option_none' => __('None (top level)', 'import-html-pages'), 'sort_column'=> 'menu_order, post_title'));
		            if (empty($pages)) $pages = "<select name=\"root_parent\"><option value=\"0\">"._e('None (top level)', 'import-html-pages')."</option></select>";
		            echo $pages;
		        ?>
			</td>
			</tr>
		</table>
		
		
		
		<!-- TAXONOMIES -->

		<h3><?php _e("Taxonomies", 'import-html-pages'); ?></h3>				
		<div class="ui-tabs-panel" id="taxonomies">
			<?php
			// support all public taxonomies
			$nonhierarchical = '';
			$taxonomies = get_taxonomies( array( 'public' => true ), 'objects', 'and' );
			?>
			<?php if ( is_array( $taxonomies ) ) : ?>
			<p><?php _e('Assign categories, tags, and custom taxonomy terms to your imported posts:', 'import-html-pages'); ?></p>
					<?php foreach ( $taxonomies as $tax ) :
						if (!is_taxonomy_hierarchical($tax->name)) :
						// non-hierarchical
							$nonhierarchical .= '<p class="taginput"><label>'.esc_html($tax->label).'<br />';
							$nonhierarchical .= '<input type="text" name="html_import['.esc_attr($tax->name).']" 
							 	value="'.esc_attr($options[$tax->name]).'" /></label></p>';
						else:
						// hierarchical 
						?>
						 	<div class="categorychecklistbox">
								<label><?php echo esc_html($tax->label); ?><br />
					        <ul class="categorychecklist">
					     	<?php
							wp_terms_checklist(0, array(
								           'descendants_and_self' => 0,
								           'selected_cats' => $options[$tax->name],
								           'popular_cats' => false,
								           'walker' => new HTML_Import_Walker_Category_Checklist,
								           'taxonomy' => $tax->name,
								           'checked_ontop' => false,
								       )
								); 
						?>
						</ul>  </div>
					<?php
					endif;
					endforeach; 
					echo '<br class="clear" />'.$nonhierarchical;
					?>
			</div>
			<?php endif; ?>
		</div>
		
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e('Save settings', 'import-html-pages') ?>" />
				<a href="admin.php?import=html" class="button-secondary">Import files</a>
			</p>
		</form>
	</div> <!-- .ui-tabs -->
	</div> <!-- .wrap -->
	<!-- The footer is hidden on this page because it doesn't reposition itself when jQuery show/hide makes the page longer -->
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(".ui-tabs-panel").each(function(index) {
				if (index > 0)
					$(this).addClass("ui-tabs-hide");
			});
			$(".ui-tabs").tabs({ fx: { opacity: "toggle", duration: "fast" } });
		});
	</script>    
	
	<?php 
}

function html_import_sanitize_options($input) {
	$msg = '';
	$type = 'error';
	// Validation goes here. Append errors to $msg.
	
	// trim the extensions, skipped dirs, post tags, tag/attr/value
	// if post type is post and default category wasn't set, set it
	
	if (empty($msg)) {
		$msg = sprintf(__('Settings saved. <a href="%s">Ready to import files?</a>'), 'admin.php?import=html');
/*
		$msg .= '<pre>';
		$msg .= print_r($input, true);
		$msg .= '</pre>';
/**/
		$type = 'updated';
	}
	// Custom updated message
	add_settings_error( 'html_import', 'html_import', $msg, $type );
	return $input;
}

// custom walker so we can change the name attribute of the category checkboxes (until #16437 is fixed)
// mostly a duplicate of Walker_Category_Checklist
class HTML_Import_Walker_Category_Checklist extends Walker {
     var $tree_type = 'category';
     var $db_fields = array ('parent' => 'parent', 'id' => 'term_id'); //TODO: decouple this
 
 	function start_lvl(&$output, $depth, $args) {
         $indent = str_repeat("\t", $depth);
         $output .= "$indent<ul class='children'>\n";
     }
 
 	function end_lvl(&$output, $depth, $args) {
         $indent = str_repeat("\t", $depth);
         $output .= "$indent</ul>\n";
     }
 
 	function start_el(&$output, $category, $depth, $args) {
         extract($args);
         if ( empty($taxonomy) )
             $taxonomy = 'category';
 
		// This is the part we changed
         $name = 'html_import['.$taxonomy.']';
 
         $class = in_array( $category->term_id, $popular_cats ) ? ' class="popular-category"' : '';
         $output .= "\n<li id='{$taxonomy}-{$category->term_id}'$class>" . '<label class="selectit"><input value="' . $category->term_id . '" type="checkbox" name="'.$name.'[]" id="in-'.$taxonomy.'-' . $category->term_id . '"' . checked( in_array( $category->term_id, $selected_cats ), true, false ) . disabled( empty( $args['disabled'] ), false, false ) . ' /> ' . esc_html( apply_filters('the_category', $category->name )) . '</label>';
     }
 
 	function end_el(&$output, $category, $depth, $args) {
         $output .= "</li>\n";
     }
}
?>