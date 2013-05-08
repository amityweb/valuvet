<?php #dpm($fields); ?> 

<div class="career-row">
  <?php
      if( $fields['field_career_package']->content == 'CAR-PCK2' ) {
  echo '<div class="career-logo">'.$fields['field_logo_or_image']->content.'</div>';
      }
    ?>
  <div class="career-left">
    <h2><?php echo $fields['title']->content;?></h2>
    <h3><?php echo $fields['field_job_category']->content;?></h3>
    <!-- <p class="career-overview-title">Overview</p> -->
    <p class="career-overview"><?php echo $fields['body']->content;?></p>
  </div>
  <div class="career-right">
    <div class="position_salary">
      <h5>Position Salary:</h5>
      <ul>
        <li><?php echo $fields['field_job_type']->content;?></li>
        <li><?php echo $fields['field_pay_structure']->content;?></li>
      </ul>
    </div>
    <div class="position_benefits">
      <h5>Position Benefits:</h5>
      <ul>
        <?php echo '<li>' ; if (strlen($fields['field_job_benefits']->content) !== 0) { echo $fields['field_job_benefits']->content; } else { echo 'N/A';} echo '</li>'; ?>
        <?php if (strlen($fields['field_job_benefits_specification']->content) !== 0) { echo '<li>'.$fields['field_job_benefits']->content.'</li>'; }  ?>
      </ul>
    </div>
  </div>
    <div class="career-cta"><a href="<?php echo $fields['path']->content;?>">More Info...</a></div>
    <div class="career-bookmark"><?php echo flag_create_link('bookmarks', $fields['nid']->content);?></div>
  
</div>