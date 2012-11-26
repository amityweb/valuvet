<style type="text/css">.iedit:hover{background:#FFFBCC} .sr{display:inlnie-block; width:30px} a{text-decoration:none}</style>
<div id="wrapper">
     <div class="titlebg"><span class="head i_mange_coupon"><h1>Navayan CSV Export</h1></span></div>
     <div id="page">

         <h5>Export the data of <big><?php echo get_option('blogname');?></big> from any table in CSV format</h5>
        <table border="1" class="widefat" style="width:98%">
            <thead>
                <tr>
                    <th class="manage-column sr">Sr.</th>
					<th class="manage-column">Table Name</th>
                    <th class="manage-column">Action</th>
                </tr>
            </thead>
            <tbody>

				<?php
					global $wpdb;
					$alltables = mysql_query("SHOW TABLES");
					while ($table = mysql_fetch_assoc($alltables)){
					  $p += sizeof($table);
					  foreach ($table AS $tablename){
				?>

				<tr class="<?php if($p%2 != 0) echo 'alternate';?> author-self status-publish iedit">
					<td><?php echo $p; ?></td>
					<td><strong><?php echo $tablename;?></strong></td>
					<td>
						<a href="<?php echo site_url();?>/wp-admin/tools.php?page=export&nycsv=<?php echo $tablename;?>">
							<input type="submit" class="button-secondary action" value="Export to CSV" name="submit"/>
						</a>
					</td>
				</tr>

				<?php } } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th class="manage-column" colspan="3">&nbsp;</th>
                </tr>
            </tfoot>
        </table>

		<h4>
			<?php $plugin_url = "http://blog.navayan.com/"; ?>
			Plugin URL: <a href="<?php echo $plugin_url;?>"><?php echo $plugin_url;?></a><br/>
		</h4>

     </div>
</div>