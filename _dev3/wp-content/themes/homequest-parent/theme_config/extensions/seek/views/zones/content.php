<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

$result = array();
foreach($options as $id=>$val){
    if($val['type']=='option'){

        if(!trim($val['value'])) continue;

        $title  = TF_SEEK_HELPER::get_property_pluralization_name($id, $val['value']);
        $value  = $val['value'];
    } elseif($val['type']=='taxonomy') {

        if(!sizeof($val['value'])) continue;

        $tax    = get_taxonomy($id);
		if(!$tax) continue;

        $title  = $tax->labels->name;

        $value  = array();
        foreach($val['value'] as $vkey=>$vval){
            $value[] = '<li>' . $vval->name . '</li>';
        }
        $value  = implode($value);
    } else {
        continue;
    }

    $result[]   = '<h6>' . $title . ':</h6> <ul>' . $value . '</ul>' ;
}

?>

<div class="re-details">
    <h2><?php print( sprintf( __('%s Details','tfuse'), TF_SEEK_HELPER::get_option('seek_property_name_singular','Property') ) ); ?>:</h2>

        <div class="list-right-details"><?php print( implode("\n", $result) ); ?></div>
        <div class="list-left-details">
            <h6>Type of Practice</h6>
            <ul>
                <li><strong>Type:</strong> <?php meta('type_of_practice'); ?>

                </li>
                
                <?php if(get_meta('small-animal-percentage') != '') {
                    echo '<li><strong>'.get_meta('small-animal-percentage').'%</strong>'; 
                    
                    $small_animal = array();
                    
                    if(get_meta('canine') != '') { array_push($small_animal, "Canine"); }
                    if(get_meta('feline') != '') { array_push($small_animal, "Feline"); }
                    if(get_meta('avian') != '') { array_push($small_animal, "Avian"); }
                    if(get_meta('exotics') != '') { array_push($small_animal, "Exotics"); }
                    if(get_meta('fauna') != '') { array_push($small_animal, "Fauna"); }
                    
                    $small_animal  = implode(', ', $small_animal);
                    echo ' ('.$small_animal.')</li>';
                    } 
                ?>

                <?php if(get_meta('equine-percentage') != '') {
                    echo '<li><strong>'.get_meta('equine-percentage').'%</strong>'; 
                    
                    $equine_animal = array();
                    
                    if(get_meta('pleasure') != '') { array_push($equine_animal, "Pleasure"); }
                    if(get_meta('equine-stud') != '') { array_push($equine_animal, "Stud"); }
                    if(get_meta('equine-stables') != '') { array_push($equine_animal, "Stables"); }
                    
                    $equine_animal  = implode(', ', $equine_animal);
                    echo ' ('.$equine_animal.')</li>';
                    } 
                ?>
                <?php if(get_meta('bovine-percentage') != '') {
                    echo '<li><strong>'.get_meta('bovine-percentage').'%</strong>'; 
                    
                    $bovine_animal = array();
                    
                    if(get_meta('beef') != '') { array_push($bovine_animal, "Beef"); }
                    if(get_meta('dairy') != '') { array_push($bovine_animal, "Dairy"); }
                    if(get_meta('bovine_stud') != '') { array_push($bovine_animal, "Stud"); }
                    
                    $bovine_animal  = implode(', ', $bovine_animal);
                    echo ' ('.$bovine_animal.')</li>';
                    } 
                ?>
                <?php if(get_meta('other-percentage') != '') {
                    echo '<li><strong>'.get_meta('other-percentage').'%</strong>'; 
                    
                    $other_animal = array();
                    
                    if(get_meta('porcine') != '') { array_push($other_animal, "Porcine"); }
                    if(get_meta('ovine') != '') { array_push($other_animal, "Ovine"); }
                    if(get_meta('caprine') != '') { array_push($other_animal, "Caprine"); }
                    if(get_meta('camelid') != '') { array_push($other_animal, "Camelid"); }
                    
                    $other_animal  = implode(', ', $other_animal);
                    echo ' ('.$other_animal.')</li>';
                    } 
                ?>
                <?php if(get_meta('other-extra-details') != '') { ?>
                    <li><strong>Other:</strong> (<?php meta('other-extra-details') ?>)</li> 
                    
                <?php } ?>
            </ul>
            <h6>Staff</h6>
            <ul>
                <li><strong>Number of Full-time Vet:</strong> <?php meta('number_of_fulltime_vet_equivalents_40_hrs'); ?></li>
                <li><strong>Number of Nurse:</strong> <?php meta('number_of_fulltime_vet_equivalents_40_hrs_'); ?></li>
                <li><strong>Practice Manager:</strong> <?php meta('practice_manager'); ?></li>
            </ul>
            <h6>Facilities</h6>
            <ul>
                <li><strong>Building Type:</strong> <?php meta('building_type'); ?></li>
                <!-- if owned or lease -->
                <li>
                    <strong>Building:</strong> 
                    <?php 
                    meta('building_owndership'); 
                    if (get_meta('lease_details') != '') {
                        echo ' - '.get_meta('lease_details');          
                    }
                    ?>
                </li>
                <li><strong>Building Area:</strong> <?php meta('building_area_sqm'); ?> sqm</li>
                <li><strong>Branch Clinics:</strong> <?php meta('number_of_branch_clinics'); ?></li>
                <li><strong>Open:</strong> <?php meta('number_of_days_open_per_week'); ?></li>
                <!-- Facilities Include -->
                <li>
                    <strong>Facilities Include:</strong> 
                    <?php 
                    $facilities = array();
                    
                    if(get_meta('kennels') != '') { array_push($facilities, "Kennels"); }
                    if(get_meta('stables') != '') { array_push($facilities, "Stables"); }
                    if(get_meta('off_street_parking') != '') { array_push($facilities, "Parking"); }
                    
                    $facilities  = implode(', ', $facilities);
                    echo ' '.$facilities;
                    ?>
                </li>
                <li><strong>Number of Car Parks:</strong> <?php meta('no_of_off_street_cars'); ?></li>
                <li><strong>Number of Computers:</strong> <?php meta('number_of_computer_terminals'); ?></li>
                <!-- if isset other scrivo other if not scrivo computer software -->
                <li>
                    <strong>Software:</strong> <?php if (get_meta('other_softwares') != '') {
                        meta('other_softwares'); 
                    }
                    else {
                        meta('computer_software');
                    }
                    ?>

                </li>

            </ul>
        </div>
        

    <div class="clear"></div>
</div>