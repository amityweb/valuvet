jQuery(document).ready(function () {
    jQuery("select.tfuse-select").each(function(){
        jQuery(this).chosen({
            'allow_single_deselect': jQuery(this).attr('single-deselect')
        });
    });

    jQuery(document).on('change','.tfuse-select',function(){
        var self=jQuery(this);
        self.siblings('input[type=hidden]').val(self.val());
    });
});