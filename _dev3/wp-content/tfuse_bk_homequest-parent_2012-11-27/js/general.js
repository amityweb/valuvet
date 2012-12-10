$=jQuery;
jQuery('.footer .widget_nav_menu').addClass('widget_pages').removeClass('widget_nav_menu');
var params = {
    changedEl: ".select_styled",
    visRows: 15,
    scrollArrows: true
}
cuSel(params);
jQuery('.input_styled input').customInput();
function setCookie(c_name,value,exdays)
{
    var exdate=new Date();
    exdate.setDate(exdate.getDate() + exdays);
    var c_value=value + ((exdays==null) ? "" : "; expires="+exdate.toUTCString());
    document.cookie=c_name + "=" + c_value;
}
function getCookie(c_name)
{
    var i,x,y,ARRcookies=document.cookie.split(";");
    for (i=0;i<ARRcookies.length;i++)
    {
        x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
        y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
        x=x.replace(/^\s+|\s+$/g,"");
        if (x==c_name)
        {
            return y;
        }
    }
    return false;
}

jQuery(document).ready(function($) {
    jQuery('.footer .widget_nav_menu').addClass('widget_pages').removeClass('widget_nav_menu');
    var params = {
        changedEl: ".select_styled",
        visRows: 15,
        scrollArrows: true
    }
    cuSel(params);
    jQuery('.input_styled input').customInput();

        jQuery('.re-bot .link-save,.re-meta-bot .link-save').bind('click', function(){

            var id = jQuery(this).attr("rel");
            var saved_prop = getCookie('favorite_properties');

            if(saved_prop)saved_prop = saved_prop.split(',');
            else saved_prop = new Array();
            var pos = jQuery.inArray(id,saved_prop);
            if(pos != -1)
            {
                saved_prop = jQuery.grep(saved_prop, function(value) {
                    return value != id;
                });
                saved_prop = saved_prop.join();
                setCookie('favorite_properties', saved_prop, 366);
                alert('Removed');
                console.log(saved_prop);
            }else
            {
                saved_prop.push(id);
                saved_prop = saved_prop.join();
                setCookie('favorite_properties', saved_prop, 366);
                alert('SAved');
                console.log(saved_prop);
            }
            return false;
        });

        jQuery('#jumptopage_submit, #jumptopage_submit2').bind('click', function(){
            var address = jQuery('#tax_permalink').attr("value");
            if(!address) return;
            var page = jQuery(this).prev('.inputSmall').val();
            var num_pages = jQuery('#tax_results').attr("num_pages");
            var order = jQuery('#tax_results').attr("get_order");
            var order_by = jQuery('#tax_results').attr("get_order_by");
            var prefix = '&';
            if (address.indexOf('?') == -1) prefix = '?';
            var suffix = '';
            if (order_by) suffix += 'order_by=' + order_by;
            if (order) suffix += '&order=' + order;

            page = page.match(/\d+$/);
            page = parseInt(page, 10);
            suffix += '&page=' + page;

            window.location = address + prefix + suffix;
            return false;
        });

        jQuery('.list_manage .pages .link_prev').bind('click', function(){
            var address = jQuery('#tax_permalink').attr("value");
            if(!address) return;
            var page = jQuery('#tax_results').attr("page");
            var num_pages = jQuery('#tax_results').attr("num_pages");
            var order = jQuery('#tax_results').attr("get_order");
            var order_by = jQuery('#tax_results').attr("get_order_by");
            if(jQuery(this).attr("rel") == "first") return false;
            if (page == 0 || page == 1) return false;
            var prefix = '&';
            if (address.indexOf('?') == -1) prefix = '?';
            var suffix = '';
            if (order_by) suffix += 'order_by=' + order_by;
            if (order) suffix += '&order=' + order;

            page = page.match(/\d+$/);
            page = parseInt(page, 10);
            page--;
            suffix += '&page=' + page;

            window.location = address + prefix + suffix;
            return false;
        });

        jQuery('.list_manage .pages .link_next').bind('click', function(){
            var address = jQuery('#tax_permalink').attr("value");
            if(!address) return;
            var page = jQuery('#tax_results').attr("page");
            var num_pages = jQuery('#tax_results').attr("num_pages");
            var order = jQuery('#tax_results').attr("get_order");
            var order_by = jQuery('#tax_results').attr("get_order_by");
            if(jQuery(this).attr("rel") == "last") return false;
            if (page == num_pages ) return false;
            var prefix = '&';
            if (address.indexOf('?') == -1) prefix = '?';
            var suffix = '';
            if (order_by) suffix += 'order_by=' + order_by;
            if (order) suffix += '&order=' + order;

            page = page.match(/\d+$/);
            page = parseInt(page, 10);
            if (page == 0) page++;
            page++;
            suffix += '&page=' + page;

            window.location = address + prefix + suffix;
            return false;
        });

        jQuery('.form_sort #sort_list,.form_sort #sort_list2').bind('change', function(){
           var address = jQuery('#tax_permalink').attr("value");
           if(!address) return;
           var selected = jQuery(this).val();
           var prefix = '&';
           if (address.indexOf('?') == -1) prefix = '?';
           var suffix = '';
            switch (selected)
            {
                case '1' :
                    suffix += 'order_by=date&order=DESC';
                    break;
                case '2' :
                    suffix += 'order_by=price&order=DESC';
                    break;
                case '3' :
                    suffix += 'order_by=price&order=ASC';
                    break;
                case '4' :
                    suffix += 'order_by=title&order=ASC';
                    break;
                case '5' :
                    suffix += 'order_by=title&order=DESC';
                    break;
            }
           if (suffix != '') window.location = address + prefix + suffix;
        });

  		$("a").each(function() {
			$(this).attr("hideFocus", "true").css("outline", "none");
		});
	
		$(".dropdown ul").parent("li").addClass("parent");
		$(".dropdown li:first-child, .pricing_box li:first-child").addClass("first");
		$(".dropdown li:last-child, .pricing_box li:last-child").addClass("last");
		$(".dropdown li:only-child").removeClass("last").addClass("only");	
		$(".dropdown .current-menu-item, .dropdown .current-menu-ancestor").prev().addClass("current-prev");		

		$("ul.tabs").tabs("> .tabcontent", {
			tabs: 'li', 
			effect: 'fade'
		});
		
	$(".recent_posts li:odd").addClass("odd");
	$(".popular_posts li:odd").addClass("odd");
	$(".widget_recent_comments li:even, .widget_recent_entries li:even, .widget_twitter .tweet_item:even, .widget_archive li:even").addClass("even");
	
// cols
	$(".row .col:first-child").addClass("alpha");
	$(".row .col:last-child").addClass("omega"); 	

// quick search
	$("#link_q_filter").click(function(){
		$(this).toggleClass("active");
		$(this).next(".quick_filter_box").slideToggle(300,'easeInOutCubic');
	});
	
// toggle content
	$(".toggle_content").hide(); 
	
	$(".toggle").toggle(function(){
		$(this).addClass("active");
		}, function () {
		$(this).removeClass("active");
	});
	
	$(".toggle").click(function(){
		$(this).next(".toggle_content").slideToggle(300,'easeInQuad');
	});
	
	$(".table-pricing tr:even").addClass("even");

// gallery
	$(".gl_col_2 .gallery-item::nth-child(2n)").addClass("nomargin");
	
// pricing
	$(".pricing_box li.price_col").css('width',$(".pricing_box ul").width() / $(".pricing_box li.price_col").size());

// buttons	
	if (!$.browser.msie) {
		$(".button_link, .button_styled, .btn-share, .tf_pagination .page_prev, .tf_pagination .page_next").hover(function(){
			$(this).stop().animate({"opacity": 0.85});
		},function(){
			$(this).stop().animate({"opacity": 1});
		});
	}
	
// preload images
	var cache_i = [];
	$.preLoadImages = function() {
    var args_len = arguments.length;
    for (var i = args_len; i--;) {
      var cacheImage = document.createElement('img');
      cacheImage.src = arguments[i];
      cache_i.push(cacheImage);
    }
	$.preLoadImages(
	"images/dropdown_sprite.png",
	"images/dropdown_sprite2.png",
	"images/opacity_gray_90.png",
	"images/quick_search_bg.png");
}	

});

jQuery(document).ready(function($) {
    $('.tooltip[title]').qtip({
        position: {
            my: 'bottom center',
            at: 'top center',
            adjust: {y: -1 }
        },
        style: {
            classes: 'ui-tooltip-dark ui-tooltip-rounded'
        }
    });

    jQuery(document).ready(function($) {
        $('a[data-rel]').each(function() {
            $(this).attr('rel', $(this).data('rel'));
        });
        $("a[rel^='prettyPhoto']").prettyPhoto({social_tools:false});
    });

});

function hide_slider_arrows()
{
    jQuery('.jcarousel-prev-vertical, .jcarousel-next').css("display","none;");
    console.log("wwww");
}