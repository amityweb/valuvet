<input id="slider_uniqid" type="hidden" value="<?php echo tfget($slider['id']); ?>"/>
<input type="hidden" id="slider_design" value="<?php echo $this->ext->slider->design; ?>"/>
<input type="hidden" id="slider_type" value="<?php echo $this->ext->slider->type; ?>"/>
<div class="slide_options_box">
    <input type="button" class="button" id="save_slider" value="Save Slider"/>
    <input type="button" class="button reset-button" id="cancel_slider" value="Cancel Slider Changes"/>
</div>
<div class="frame_box_buttons">
    <a id="add_slide" class="button">Add Slide</a>
    <a id="save_changes_slide" class="button">Save Changes</a>
    <a id="cancel_changes_slide" class="button">Cancel Changes</a>
</div>