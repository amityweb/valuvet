var side_togs  = $$('.acc_tog');
var side_cons  = $$('.acc_con');

side_togs.each(function(el,i) {

    el.grab(new Element('div', {'class':'minmax'}));
    el.addClass('max');

    side_cons[i].set('org_height', side_cons[i].getSize().y);

    if (! el.hasClass('forget')) {
        if (Cookie.read('side:'+el.get('text'))=='min') {
            side_cons[i].style.height = '0';
            el.removeClass('max');
        }
        else if (Cookie.read('side:'+el.get('text'))=='max') {
            // no action
        }
        else {
            if (el.hasClass('defmin')) {
                side_cons[i].style.height = '0';
                el.removeClass('max');
            }
        }
    }
    else {
        if (el.hasClass('defmin')) {
            side_cons[i].style.height = '0';
            el.removeClass('max');
        }
    }


    el.addEvent('click', function(){
        var h = side_cons[i].getSize().y;
        if (h == 0) {
            el.addClass('max');
            if (! el.hasClass('forget')) Cookie.write('side:'+el.get('text'), 'max', {domain:location.host});
            side_cons[i].morph({
                'height': side_cons[i].get('org_height'),
                'opacity': 1
            });
        }
        else {
            el.removeClass('max');
            if (! el.hasClass('forget')) Cookie.write('side:'+el.get('text'), 'min', {domain:location.host});
            side_cons[i].morph({
                'height':  0,
                'opacity': 0
            });
        }
    });
});
