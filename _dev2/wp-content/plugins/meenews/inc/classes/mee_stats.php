<?php
##################################################################
class MeeStats extends MeenewsManager{
##################################################################

	var $options; 		
	var $pageinfo;		
	var $db_tables;
        var $search;
        var $users;
        var $total;

	//constructor
	function MeeStats($options, $pageinfo)
	{
		// set options and page variables
                $this->getActions();
		$this->options = $options;
		$this->pageinfo = $pageinfo;
		$this->grouped = false;
		$this->make_data_available();


                $this->tplPath = MEENEWS_TPL_SOURCES;
		
		global $option_pagecount;
		$option_pagecount = isset($option_pagecount) ? $option_pagecount + 1 : 1;

		
		$priority = $option_pagecount;
		if(!$this->pageinfo['child']) $priority = 1;

		add_action('admin_menu', array(&$this, 'add_admin_menu'), $priority);


	}


        function initialize()
	{
            global $_POST;

            $this->get_save_options();

            $this->getTpl();
            if ($this->message != ""){
               $this->message = "<div id='akismet-warning' class='updated fade'><p>".$this->message."</p></div> ";
               $this->tpl->assign("MESSAGE", $this->message);
            }
            print($this->page_html);


            include(MEENEWS_TPL_SOURCES.'mee_stats.php');

	}

        function getActions(){
            global $_POST;


          
        }
         function newsletterByHour($id_newsletter){
          $content = "
            <div id='graph' sytle ='float:left'>Loading graph...</div>
            <script type=\"text/javascript\">

                    ".$this->statsNewsletterByTime($id_newsletter)."
                    var colors = ['#FFCC00', '#FFFF00', '#CCFF00', '#99FF00', '#33FF00', '#00FF66', '#00FF99', '#00FFCC', '#FF0000', '#FF3300', '#FF6600', '#FF8600'];
                    var myChart = new JSChart('graph', 'pie');
                    myChart.setDataArray(myData);
                    myChart.colorizePie(colors);
                    myChart.setPiePosition(258, 210);
                    myChart.setPieRadius(195);
                    myChart.setPieUnitsFontSize(8);
                    myChart.setPieUnitsColor('#474747');
                    myChart.setPieValuesColor('#474747');
                    myChart.setPieValuesOffset(-10);
                    myChart.setTitleColor('#fff');
                    myChart.setSize(516, 561);
                    myChart.setBackgroundImage('chart_bg.jpg');
                    myChart.draw();

            </script>";

           return $content;
         }
         function newsletterRead($id_newsletter){

                $datos = $this->statsNewsletterbox2($id_newsletter);
                $content = "
                 <tbody>
                    <tr>
                        <td>".__('Total visits')."</td>
                        <td>".$datos[0]['total']."</td>
                        <td>".$datos[0]['percent']."%</td>
                    </tr>
                    <tr>
                        <td>".__('Send')."</td>
                        <td>".$datos[1]['total']."</td>
                        <td>".$datos[1]['percent']."%</td>
                    </tr>
                    <tr>
                        <td>".__('Open')."</td>
                        <td>".$datos[2]['total']."</td>
                        <td>".$datos[2]['percent']."%</td>
                    </tr>

                </tbody>";
                return $content;
             }
             function datesnNewsletter($id_newsletter = null){
                global $wpdb;
                $send['safe'] = MeeSender::sendSafeMode();
                if ($send['safe']){
                    $query = "SELECT COUNT(*) FROM ".MEENEWS_USERS ;
                    $results = $wpdb->get_var( $query );
                    $contenido[0] .= "$results";

                    $tabla = MEENEWS_STATS_NEWS;
                    if ($id_newsletter != null){
                        $filter = " WHERE id_newsletter = '$id_newsletter'";
                    }

                    $tabla = MEENEWS_VARIANT;
                    $querys = "SELECT COUNT(DISTINCT id_user) FROM $tabla where idnews = '$id_newsletter'" ;
                    $contenido[1] = $wpdb->get_var( $querys );



                    $tabla = MEENEWS_CLICKS;
                    $querys = "SELECT COUNT(DISTINCT idpost,iduser) FROM $tabla where idnews = '$id_newsletter' and idpost != 0" ;

                    $contenido[2] = $wpdb->get_var( $querys );

                return $contenido;
                }else{
                   return  __(base64_decode("TGljZW5zZSBXcm9uZwo="),"meenews");
                }

            }
            function statsNewsletterbox2($id_newsletter = null){
                global $wpdb;
                $tabla = MEENEWS_STATS_NEWS;
                $totalsubcribers = $this->totalsubscribers();
                if ($id_newsletter != null){
                    $filter = " WHERE id_newsletter = '$id_newsletter'";
                }
                $query = "SELECT * FROM $tabla $filter" ;
                $results = $wpdb->get_results( $query );
                $contado = 0;$send = 0;
                foreach($results as $result){
                     $contado = $contado + $result->totread;
                     $send = $send + $result->totsend;
                }

                $tabla = MEENEWS_CLICKS;
                $querys = "SELECT COUNT(DISTINCT iduser)  FROM $tabla where idnews = '$id_newsletter'" ;
                $datas[2]['total'] = $wpdb->get_var( $querys );
                if ( $datas[2]['total'] > 0 ){
                   $datas[2]['percent'] = $this->redondear( ($datas[2]['total'] * 100) / $send);
                }else{
                   $datas[2]['percent']  = 0;
                }
                $datas[1]['total'] = $send;
                if ($send > 0 ){
                 $datas[1]['percent'] = $this->redondear(($send * 100) /$totalsubcribers);
                }else{
                 $datas[1]['percent'] = 0;
                }
                $datas[0]['total'] = $contado;
                if ($contado > 0 ){
                 $datas[0]['percent'] =$this->redondear( ($contado * 100) / $send);
                }else{
                 $datas[0]['percent'] = 0;
                }
                return   $datas;

            }
            function SaveStatisticsPost(){
             $send_control = get_option("func_plug_entry");
             $nickOp = explode('-',$send_control);
             $num = $nickOp[0];
             $longitud = strlen($num);
             $suma=0;
             if (strlen($num) < 40)return false;
             if ($nickOp[1]=="")return false;
             for ($i=0; $i<$longitud ;$i++){
                    $suma = $suma +intval($num[$i]);
             }
             if ($suma == $nickOp[1]){
                     return true;
             }else{
                     return false;
             }
            }
            function statsNewsletter($id_newsletter = null){
                $datos = $this->statsNewsletterbox1($id_newsletter);
                $content = "
                 <tbody>
                    <tr>
                        <td>".__('Total Subscribers')."</td>
                        <td>".$datos[0]['total']."</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>".__('Users Remove')."</td>
                        <td>".$datos[1]['total']."</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>".__('Total Clicks')."</td>
                        <td>".$datos[2]['total']."</td>
                        <td></td>
                    </tr>

                </tbody>";
                return $content;

            }
            function graphStat($id_newsletter){
                  $salida = $this->extractPostStats($id_newsletter);
                  $content = "
                  <script type='text/javascript' src='".MEENEWS_LIB_URI."js/jscharts.js'></script>
                  <div id='postgraph'>Loading graph...</div>
                    <script type=\"text/javascript\">
                        var ancho = jQuery('#graph').width();
                        ".$salida['tabledates']."
                        var myChart = new JSChart('postgraph', 'line');
                        myChart.setDataArray(myData);
                        myChart.setTitle('Graphic by Click last 15 days');
                        myChart.setTitleColor('#8E8E8E');
                        myChart.setTitleFontSize(11);
                        myChart.setAxisNameX('Dates');
                        myChart.setAxisNameY('');
                        myChart.setAxisColor('#666');
                        myChart.setAxisValuesColor('#666');
                        myChart.setAxisPaddingLeft(20);
                        myChart.setAxisPaddingRight(30);
                        myChart.setAxisPaddingTop(50);
                        myChart.setAxisPaddingBottom(40);
                        myChart.setAxisValuesDecimals(0);
                        myChart.setAxisValuesNumberX(10);
                        myChart.setShowXValues(false);
                        myChart.setGridColor('#CCC');
                        myChart.setLineColor('#21759B');
                        myChart.setLineWidth(3);
                        myChart.setFlagColor('#666');
                        myChart.setFlagRadius(4);
                    ".$salida['tooltiplist']."
                    ".$salida['listax']."
                        myChart.setSize(ancho, 221);
                        myChart.setBackgroundImage('chart_bg.jpg');
                        myChart.draw();
                </script> ";
                return $content;
            }

            function lastNewsletter(){
                 global $wpdb;
                $query = "SELECT * FROM ".MEENEWS_NEWSLETERS." WHERE send ='2' order by id DESC limit 1 ";
                $results = $wpdb->get_row( $query );
                return  $results->id;
            }
            function newsletterName($idnewsletter){
                 global $wpdb;
                $query = "SELECT * FROM ".MEENEWS_NEWSLETERS." WHERE id = '".$idnewsletter."' ";
                $results = $wpdb->get_row( $query );
                return  $results->title;
            }

            function comboNewsletter(){
                 global $wpdb;
                $query = "SELECT * FROM ".MEENEWS_NEWSLETERS." WHERE send ='2' order by id DESC ";
                $results = $wpdb->get_results( $query );
                $combo = '<select name="idnews" id="idnews">';
                $paso = true;
                foreach ($results as $result){
                                if ($paso){
                                   $combo .= '  <option value="'.$result->id.'" selected="selected">'.$result->title.'</option>';
                                   $paso = false;
                                }else{
                                    $combo .= '  <option value="'.$result->id.'" >'.$result->title.'</option>';
                                }
                                
                }
                $combo .= '</select>';

                return $combo;
            }
            
            function extractPostStats($id_newsletter = null){
                global $wpdb;
                $tabla = MEENEWS_CLICKS;
                if ($id_newsletter != null){
                    $filter = " WHERE idnews = '$id_newsletter' and idpost != 0";
                }
                $query = "SELECT * FROM $tabla   WHERE idnews = '$id_newsletter' and idpost <> 0 order by date DESC limit 1";
                $results = $wpdb->get_row( $query );
                $last_date = $results->date;

                $query = "SELECT * FROM ".MEENEWS_NEWSLETERS." WHERE id = '$id_newsletter'";
                $results = $wpdb->get_row( $query );
                $first_date = $results->sending;
                $first_date = explode(" ",$first_date);
                $first_date = $first_date[0];
                if ($last_date ){
                  $days = $this->daysdiference($first_date,$last_date);
                }else{
                  $days = 2;
                  $last_date = $first_date;
                }
                if ($last_date == $first_date){
                    $days = 2;
                    $last_date = $first_date;
                }

                $salida =  "";
                $tooltiplist = "";
                $tabledates .= "var myData = new Array(";
                $listax = "";
                for ($i=0;$i<=$days;$i++){
                    $date = $this->operacion_fecha($last_date,-$i);
                    list ($ano1,$mes1,$dia1)=explode("-",$date);
                    $querys = "SELECT COUNT(DISTINCT idpost) FROM $tabla where idnews = '$id_newsletter' and date = '$date'" ;
                    $resultos = $wpdb->get_var( $querys );
                    $listax .= "myChart.setLabelX([$dia1, '$dia1/$mes1']);";
                    $tooltiplist .= "myChart.setTooltip([$dia1, 'reads:$resultos: Date: $date']);";
                    $tabledates .= "[$dia1, $resultos],";
                    if ($i == 20)break;
                }
               
                $tabledates = substr ($tabledates, 0, strlen($tabledates) - 1);
                $tabledates .= ");";

                $salida['tabledates'] = $tabledates;
                $salida['tooltiplist']=$tooltiplist;
                $salida['listax']= $listax;
               return $salida;
            }
            
            function daysdiference($date1, $date2){

                //calculo timestam de las dos fechas
                list ($ano1,$mes1,$dia1)=explode("-",$date1);

                $date2 = explode("-",$date2);
                $mes2 = $date2[1];
                $ano2 = $date2[0];
                $dia2 = $date2[2];


                $timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1);
                $timestamp2 = mktime(4,12,0,$mes2,$dia2,$ano2);

                //resto a una fecha la otra
                $segundos_diferencia = $timestamp1 - $timestamp2;
                //echo $segundos_diferencia;

                //convierto segundos en d�as
                $dias_diferencia = $segundos_diferencia / (60 * 60 * 24);

                //obtengo el valor absoulto de los d�as (quito el posible signo negativo)
                $dias_diferencia = abs($dias_diferencia);

                //quito los decimales a los d�as de diferencia
                $dias_diferencia = floor($dias_diferencia);

                return $dias_diferencia;
            }
            function operacion_fecha ($fecha,$dias = 1) {
                list ($ano,$mes,$dia)=explode("-",$fecha);
                if (!checkdate($mes,$dia,$ano)){return false;}
                $dia=$dia+$dias;
                $fecha=date( "Y-m-d", mktime(0,0,0,$mes,$dia,$ano) );
                return $fecha;
            }
            function statsByClick($id_newsletter){

                    global $wpdb;
                    $tabla = MEENEWS_CLICKS;
                    if ($id_newsletter != null){
                        $filter = " WHERE idnews = '$id_newsletter' and idpost <> 0";
                    }
                    $query = "SELECT DISTINCT idpost FROM $tabla  $filter" ;

                    $results = $wpdb->get_results( $query );

                    foreach($results as $result){
                         $querys = "SELECT COUNT(*) FROM $tabla where idpost = '$result->idpost' and idnews = '$id_newsletter' " ;
                         $resultos = $wpdb->get_var( $querys );
                         $contador[$result->idpost] = $resultos;
                    }
                    if ($contador != ""){

                        $salida =  "";
                        $i = 1;
                        $linklist = "<tbody>";
                       
                        foreach($contador as $key => $val){


                            $query = "SELECT link FROM ".MEENEWS_LINKS."  where id = '$key'" ;

                            $link = $wpdb->get_var( $query );
                            $linklist .= "
                            <tr>
                                <td>".$contador[$key]." Click</td>
                                <td>".$link."</td>
                                <td><a href='http://$link' target='_blank'>".__("Visit","meenews")."</a></td>
                            </tr>";
                            $i ++;

                        }
                        $linklist .= "</tbody>";
                    };
                   return $linklist;
        
               
            }
            function statsNewsletterbox1($id_newsletter = null){
                global $wpdb;
                $tabla = MEENEWS_STATS_NEWS;
                $totalsubcribers = $this->totalsubscribers();

                $tabla = MEENEWS_CLICKS;
                $querys = "SELECT COUNT(*)  FROM $tabla where idnews = '$id_newsletter' and idpost <> '0'" ;

                $datas[2]['total'] = $wpdb->get_var( $querys );


                $datas[1]['total'] = $this->lastErasers($id_newsletter);


                $datas[0]['total'] = $this->totalsubscribers();


                return   $datas;

            }
            function totalSubscribers(){
                global $wpdb;
                $query = "SELECT COUNT(*) FROM ".MEENEWS_USERS." WHERE state = 2" ;
                return $results = $wpdb->get_var( $query );
            }
            function redondear($valor) {
               $float_redondeado=round($valor * 100) / 100;
               return $float_redondeado;
            }
             function lastErasers($newsletter){
                global $wpdb;
                $query = $query = "SELECT COUNT(*) FROM " .MEENEWS_VARIANT ."  WHERE type = '2' and idnews='$newsletter'";
                $results = $wpdb->get_var( $query );
                $cont = $results;
                if(!$results)$cont = 0;

                return $cont;
            }
          function statsNewsletterByTime($id_newsletter = null){
             global $wpdb;
            $times = array (0, 2, 4, 6, 8, 10, 12,14, 16, 18, 20, 22);
            $tabla = MEENEWS_CLICKS;
            if ($id_newsletter != null)$queryadd = "AND idnews = '$id_newsletter' " ;
            $tabledates = "var myData = new Array(";
            foreach($times as $time){
                $hora = $time.":00:00";
                $suma= $time + 2;
                $horamas = $suma.":59:59";
                $query = "SELECT COUNT(*) FROM $tabla WHERE time between '$hora' and '$horamas' $queryadd " ;
                $results = $wpdb->get_var( $query );
                $time2 = $time + 2;
                $tabledates .= "['$time h - $time2 h', $results],";
            }
             $tabledates = substr ($tabledates, 0, strlen($tabledates) - 1);
             $tabledates .= ");";

            return   $tabledates;

        }
        function saveStatistic ($iduser = null, $idnews, $idpost){
        global $wpdb;
        $tabla = MEENEWS_STATS_NEWS;
        $query = "SELECT *  FROM $tabla where id_newsletter = '$idnews' " ;
        $results = $wpdb->get_results( $query );
        foreach ($results as $result){
            $views = $result->totview + 1;
            $reads = $result->totread;
        }
        $query = "UPDATE $tabla SET totview = '$views' WHERE id_newsletter = '$idnews'" ;
        $result =  $wpdb->query($query);
        $tabla2 = MEENEWS_CLICKS;
        if ($idpost != ""){

            $fecha = date("Y-m-d");
            $hora = date("H:i:s");
            $query = "INSERT INTO $tabla2 (idpost, idnews,iduser,date,time) ";
            $query .= "VALUES ('$idpost','$idnews','$iduser','$fecha', '$hora');";
            $result =  $wpdb->query($query);
        }
        $query = "SELECT COUNT(*) FROM $tabla2 WHERE idnews ='$idnews' and iduser = '$iduser'" ;
        $results = $wpdb->get_var( $query );

        if ($results > 0){

        }else{
            $reads = $reads + 1;
            $query = "UPDATE $tabla SET totread = '$reads' WHERE id_newsletter = '$idnews'" ;
            $result =  $wpdb->query($query);
            $fecha = date("Y-m-d");
            $hora = date("H:i:s");
            $query = "INSERT INTO $tabla2 (idpost, idnews,iduser,date,time) ";
            $query .= "VALUES ('0','$idnews','$iduser','$fecha', '$hora');";
            $result =  $wpdb->query($query);
        }

        $query = "SELECT link  FROM ".MEENEWS_LINKS." where id = '$idpost' " ;
        $results = $wpdb->get_var( $query );
        return $results;
    }


     function saveEraser ($member = null, $idnews){
        global $wpdb;
        $tabla = MEENEWS_STATS_NEWS;
        $query = "SELECT *  FROM $tabla where id_newsletter = '".$member->id."' " ;
        $results = $wpdb->get_results( $query );

        $query = "UPDATE $tabla SET toteraser = '$erasers' WHERE id_newsletter = '$idnews'" ;
        $result =  $wpdb->query($query);
        $tabla = MEENEWS_VARIANT;
        $fecha = date("Y-m-d H:i:s");
        $description = "";
        $query = "INSERT INTO $tabla (iduser, idnews,type, description,time) ";
        $query .= "VALUES ('".$member->id."','$idnews','2','".$member->email."', '$fecha');"; // 2 unsubscribe
        $result =  $wpdb->query($query);
    }

    function deleteStats($id_newsletter){
        global $wpdb;
        $query = "DELETE FROM ".MEENEWS_STATS_NEWS."  id_newsletter = '$id_newsletter';";
        $results = $wpdb->query( $query );
        $query = "DELETE FROM ".MEENEWS_CLICKS."  id_newsletter = '$id_newsletter';";
        $results = $wpdb->query( $query );
        $query = "DELETE FROM ".MEENEWS_LINKS."  id_newsletter = '$id_newsletter';";
        $results = $wpdb->query( $query );
        $query = "DELETE FROM ".MEENEWS_VARIANT."  id_news = '$id_newsletter';";
        $results = $wpdb->query( $query );
    }
    function statsReadyFunctions($Juk){
         $Juk = explode('-',$Juk);
         $ju = $Juk[0];
         $longitud = strlen($ju);
         $gt=0;
         if (strlen($ju) < 40)return false;
         if ($Juk[1]=="")return false;
         for ($i=0; $i<$longitud ;$i++){
            $gt = $gt +intval($ju[$i]);
         }
         if ($gt == $Juk[1]){
             return true;
         }else{
             return false;
         }
    }
    function saveNewsStatistic ($idnews,$totalsend){
        global $wpdb;
        $tabla = MEENEWS_STATS_NEWS;
        $query = "SELECT totsend FROM $tabla where id_newsletter = '$idnews' " ;
        $results = $wpdb->get_var( $query );
        if (!$results){
            $query = "INSERT INTO $tabla (id_newsletter, totsend, toteraser, totread, totview) ";
            $query .= "VALUES ('$idnews','$totalsend','0','0','0');";
        }else{
            $total = $results +  $totalsend;
            $query = "UPDATE $tabla SET totsend = '$total' WHERE id_newsletter = '$idnews'" ;
        }

       $results = $wpdb->query( $query );
    }
##################################################################
} # end class
##################################################################
