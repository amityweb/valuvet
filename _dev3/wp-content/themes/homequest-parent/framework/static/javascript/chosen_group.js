//JS FOR GROUP ELEMENTS FROM SELECT SEARCH WHICH HAVE OPTGROUP AS SELECTED
jQuery(document).ready(function(){

    var active_class='tf_group_active';

    jQuery(document).on('click','.tf_selectsearch_control_none',function(){
        var wrapper=jQuery(this).closest('.tf_multicontrol_selectsearch');
        var selectsearch=wrapper.find('select');
        var group_links = wrapper.find('.tf_groups_controls a');
        wrapper.find('option').removeAttr("selected");
        group_links.removeClass(active_class);
        selectsearch.trigger("liszt:updated");
        return false;

    });

    jQuery(document).on('click','.tf_selectsearch_control_all',function(){
        var wrapper=jQuery(this).closest('.tf_multicontrol_selectsearch');
        var selectsearch=wrapper.find('select');
        var group_links = wrapper.find('.tf_groups_controls a');
        wrapper.find('option').attr("selected","selected");
        group_links.addClass(active_class);
        selectsearch.trigger("liszt:updated");
        return false;

    });

jQuery(document).on('click','.tf_groups_controls a',function(){
    var self=jQuery(this);
    var wrapper=self.closest('.tf_multicontrol_selectsearch');
    var selectsearch=wrapper.find('select');
    var placeholder = self.attr('data-placeholder');

    if(self.hasClass(active_class))
              {
                  self.removeClass(active_class);
                wrapper.find('optgroup[data-placeholder='+placeholder+']').children().removeAttr("selected");
              }else {
                  self.addClass(active_class);
                wrapper.find('optgroup[data-placeholder='+placeholder+']').children().attr("selected","selected");
              }

    selectsearch.trigger("liszt:updated");
    wrapper.find('input[type=hidden]').val(selectsearch.val());
    // console.log(wrapper.find('input[type=hidden]'));
    return false;

});
});
