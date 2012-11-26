<?php
/*
CREATE TABLE "geo_pcode_au"
(
  "PCode"           varchar(5) NOT NULL default '',
  "Locality"        varchar(30) NOT NULL default '',
  "State"           varchar(5) default NULL,
  "Comments"        varchar(19) default NULL,
  "DeliveryOffice"  varchar(14) default NULL,
  "PresortIndicator" varchar(16) default NULL,
  "Parcelzone"      varchar(10) default NULL,
  "BSPnumber"       varchar(9) default NULL,
  "BSPname"         varchar(8) default NULL,
  "Category"        varchar(50) default NULL,
  PRIMARY KEY  ("PCode","Locality")
);
*/

$db = new PDO("sqlite:_include/data/postcodes.db3", null, null, array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));

$sth = $db->prepare("
SELECT DISTINCT Locality, State, PCode
FROM geo_pcode_au
WHERE Locality LIKE ?
LIMIT 10
");

$sth->execute(array($_POST['value'].'%'));

if (true)
{
    $found = "";
    foreach ($sth->fetchAll() as $loc)
    {
        $found .= "<li>".ucwords(strtolower($loc['Locality'])).",".$loc['State'].",".$loc['PCode']."</li>";
        #$found[] = array('loc'=>$loc['Locality'], 'pcode'=>$loc['PCode']);
    }

    echo $found;
}
else
{
    $found = array();
    foreach ($sth->fetchAll() as $loc)
    {
        $found[] = $loc['Locality'];
        #$found[] = array('loc'=>$loc['Locality'], 'pcode'=>$loc['PCode']);
    }

    header('Content-type: application/json');
    echo json_encode($found);
}
