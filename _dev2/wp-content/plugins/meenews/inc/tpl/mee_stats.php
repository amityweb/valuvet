<?php
global $meenews_datas;
?>
<script type="text/javascript">
       
</script>
<style>
*{ margin:0; padding:0; list-style:none; }

.stats_box{
	clear:both;
	margin-bottom:20px;
	-webkit-border-top-left-radius: 4px;
	-webkit-border-top-right-radius: 4px;
	-moz-border-radius-topleft: 4px;
	-moz-border-radius-topright: 4px;
	border-top-left-radius: 4px;
	border-top-right-radius: 4px;
	font-size:12px;
	overflow:hidden;
}
.stats_box.two{
	clear:none;
	float:left;
	width:48%;
}
.stats_box.two:nth-child(even){
	float:right;
	width:49%;
}
.stats_box h4{
	padding:5px 10px 5px 25px;
	color:#fff;
        margin:0px;
	-webkit-border-top-left-radius: 4px;
	-webkit-border-top-right-radius: 4px;
	-moz-border-radius-topleft: 4px;
	-moz-border-radius-topright: 4px;
	border-top-left-radius: 4px;
	border-top-right-radius: 4px;
	font-size:14px;
	font-weight:bold;
	background:#666 url(ico_statsh4.png) no-repeat 10px 8px;
}
.stats_content{
	padding:10px;
	border:1px solid #ddd;
	border-top:none;
	border-bottom:none;
}
.stats_content ul{
	font-size:15px;
}
.stats_content ul li{
	margin-bottom:5px;
	overflow:hidden;
}
.stats_content ul strong{
	float:left;
	display:block;
	width:10%;
}
.stats_content.table{
	padding:0;
}
.stats_footer{
	padding:5px 10px;
	border:1px solid #bbb;
	background:#E5E5E5;
	font-weight:bold;
}


table {
border-collapse: separate;
}
tr {
border-color: inherit;
display: table-row;
vertical-align: inherit;
}
table th.text {
text-align: left;
width: 50%;
}
table th {
background: #ddd;
border-bottom: 1px solid #ddd;
white-space: nowrap;
font-weight: bold;
}
table th, table td {
padding: 0.5em 0.75em;
text-align:left;
border-top:1px solid #ddd;
}
table th:first-child {
border-top:none;
}
table tr:nth-child(even){
	background:#F9F9F9;
}
td, th {
display: table-cell;
vertical-align: inherit;
}
</style>
<?php

global $_POST;

if ($_POST['idnews']){
    $id_newsletter = $_POST['idnews'];
}else{
    $id_newsletter = $this->lastNewsletter();
}
$title = $this->newsletterName($id_newsletter);
?>
<div class='wrap'>
<div id="icon-edit" class="icon32"><br /></div>
<h2><?php echo __("Statistics of ","meenews")." ".$title; ?></h2>
<?php if($id_newsletter != null){ ?>
<input type="hidden" id="acc" name="acc" value="edit_newsletter">
<input type="hidden" id="id_newsletter" name="id_newsletter" value="<?php echo $id_newsletter; ?>">
<?php }else{ ?>
<input type="hidden" id="acc" name="acc" value="new_newsletter">
<?php }?>

<div id="post-body" >
    <div id="post-body-content" >

 <?php if ($id_newsletter > 0){ ?>
        <form id="formulario" action="?page=stats_manager.php"  method="post">
        <div class="stats_box">
             <div style="position:absolute;right:28px;color:white;">Select Newsletter : <?php echo $this->comboNewsletter();?> <input type="submit" value="submit"></div>
        </form>
             <h4><?php echo __('Newsletter Click Statistics','meenews'); ?></h4>
    <div class="stats_content" id="graph">
    	 <?php echo $this->graphStat($id_newsletter); ?>
    </div>
    <div class="stats_footer">
    </div>
</div>

<div class="stats_box two">
    <h4><?php echo __('General Statistics','meenews'); ?></h4>
    <div class="stats_content table">

    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <thead>
    <tr>
    <th><?php echo __('Concept/Legend','meenews'); ?></th>
    <th><?php echo __('Total ','meenews'); ?></th>
    <th><?php echo __('Percentage','meenews'); ?></th>
    </tr>
    </thead>
        <?php echo $this->newsletterRead($id_newsletter); ?>
    </table>

</div>
    <div class="stats_footer">
    </div>
</div>

        <div class="stats_box two">
    <h4><?php echo __('General Statistics','meenews'); ?></h4>
    <div class="stats_content table">

    <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <thead>
    <tr>
    <th><?php echo __('Concept/Legend','meenews'); ?></th>
    <th><?php echo __('Total ','meenews'); ?></th>
    <th></th>
    </tr>
    </thead>
        <?php echo $this->statsNewsletter($id_newsletter); ?>
    </table>

</div>
    <div class="stats_footer">
    </div>
</div>

<div class="stats_box">
    <h4><?php echo __('Links stats by click','meenews'); ?></h4>
    <div class="stats_content table">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
            <th><?php echo __('Clicks','meenews'); ?></th>
            <th><?php echo __('Url Link ','meenews'); ?></th>
            <th><?php echo __('Visit Link ','meenews'); ?></th>
            </tr>
            </thead>
                <?php echo $this->statsByClick($id_newsletter); ?>
            </table>
           
    </div>
    <div class="stats_footer">
    </div>
</div>
<?php }else{ 

    echo __("No Stats found");
}
?>

    </div>

       </div>
</form>
    </div>

