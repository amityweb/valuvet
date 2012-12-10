// Execute immediately, no DOM ready
// loading in header
(function($) {

    $.fn.serializeObject = function()
    {
        var o = {};
        var a = this.serializeArray();
        $.each(a, function() {
            if (o[this.name] !== undefined) {
                if (!o[this.name].push) {
                    o[this.name] = [o[this.name]];
                }
                o[this.name].push(this.value || '');
            } else {
                o[this.name] = (this.value || '');
            }
        });
        return o;
    };

    $.fn.center = function () {
        this.css('position','absolute');
        this.css('top', (($(window).height() - this.outerHeight()) / 2) + $(window).scrollTop() + 'px');
        this.css('left', (($(window).width() - this.outerWidth()) / 2) + $(window).scrollLeft() + 'px');
        return this;
    }

})(jQuery);

//function that shows that a field is mandatory

(function($) {
    $.fn.reddit=function() {
        if(this.is(':visible')) {
            curr=this;
        }
        else {
            curr=this.parent();
        }
        current_bg_color=curr.css('background-color');
        curr.css('background-color','red').animate({
            'background-color':current_bg_color
        },1000);
        return false;
    }
})(jQuery);

(function($) {
    $.fn.selectRange = function(start, end) {
        return this.each(function() {
            if(this.setSelectionRange) {
                this.focus();
                this.setSelectionRange(start, end);
            } else if(this.createTextRange) {
                var range = this.createTextRange();
                range.collapse(true);
                range.moveEnd('character', end);
                range.moveStart('character', start);
                range.select();
            }
        });
    }
})(jQuery);

function stripos (f_haystack, f_needle, f_offset) {
    var haystack = (f_haystack + '').toLowerCase();
    var needle = (f_needle + '').toLowerCase();
    var index = 0;
 
    if ((index = haystack.indexOf(needle, f_offset)) !== -1) {
        return index;
    }
    return false;
}

function uniqid() {
    if(typeof uniqid.id =='undefined')
        uniqid.id=0;
    else
        uniqid.id++;
    return uniqid.id;
}