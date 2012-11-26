<?php
require_once('../../../wp-config.php');

 global $wpdb;
 $query = "SELECT * FROM " .MEENEWS_PENDENTSENDS ." order by i ASC limit 1";

 $results = $wpdb->get_results( $query );

 foreach($results as $result){

    $send['id']= $result->id_newsletter;
    $send['list'] = $result->list;
    $send['until']= $result->atsend;
    $send['to'] = $result->tosend;
    $send['title'] = $_POST["title"];
    $send['from'] = $_POST["from"];
    $send['cron'] = true;
    if (MeeNewsletter::comprobePendent($send)){
        MeeNewsletter::deletePendent($send);
        $newsletter_sender = new MeeSender();
        //meeNewsletter::saveCola($send['to']);
        $newsletter_sender->sendNewsletter($send);
    }
 }

?>