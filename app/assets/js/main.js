$(function(){
	$('<div class="toast-wrap"></div>').appendTo('body');
	$('.nav > ul > li').click(function(){
		var el = $(this).next('ul');
		if(el.height() == 0){
			$(this).addClass('on');
		    var curHeight = el.height(),
		    autoHeight = el.css('height', 'auto').height();
			el.height(curHeight).stop().animate({height: autoHeight}, 0);
		}else{
			$(this).removeClass('on');
			el.stop().animate({height: 0}, 0);
		}
	});
	$('.nav > ul > li').each(function(){
		if($(this).hasClass('current')){
			$(this).addClass('on');
			var el = $(this).next('ul');
    		var curHeight = el.height(),
    		autoHeight = el.css('height', 'auto').height();
    		el.height(curHeight).stop().animate({height: autoHeight}, 0);
		}
	});

	$('.tab > .tab-item > a').click(function(){
		var tab = $(this).closest('.tab');
		tab.find('.tab-item').removeClass('active');
		$(this).closest('.tab-item').addClass('active');
		var href = $(this).attr('href');
		var tab_content = tab.next('.tab-content');
		tab_content.find('.tab-content-item').removeClass('active');
		tab_content.find(href).addClass('active');
		return false;
	});

	var all_checked = false;
    $(":checkbox").click(function() {
        var table = $(this).closest(".checkbox-all-wrap");
        if($(this).hasClass('checkbox-all')) {
            table.find(":checkbox").prop("checked", !all_checked);
            all_checked = !all_checked;
        }
        else {
            table.find(":checkbox").not('.checkbox-all').each(function (i) {
                if(!$(this).is(":checked")) {
                    table.find(".checkbox-all").prop("checked", false);
                    all_checked = false;
                    return false;
                }
                $(".checkbox-all").prop("checked", true);
                all_checked = true;
            });
        }
    });

    $(document).on('click', '.toast .btn-clear', function(){
    	$(this).closest('.toast').animate({opacity: 0},500, function(){
    		$(this).remove();
    	});
    });

    $(document).on('click', '[modal]', function(e){
    	e.preventDefault();
    	var el = this;
    	target = $(el).attr('modal-href');
    	if (/^#/.test(target)) {
    		$(target).addClass('active');
    	}else{
    		var data = $(el).attr('modal-data') || {};
    		$(el).addClass('loading');
    		$.get(target, data, function(html){
    			$(el).removeClass('loading');
    			$(html).appendTo('body').addClass('active');
    		}, 'html');
    	}
    });

    $(document).on('click', '.modal-overlay', function(){
    	var modal = $(this).closest('.modal');
    	if(! modal.hasClass('modal-click')) return;
    	if(modal.hasClass('modal-ajax')){
			modal.remove();
		}else{
			modal.removeClass('active');
		}
    });

    $(document).on('click', '.close-modal', function(){
    	var modal = $(this).closest('.modal');
    	if(modal.hasClass('modal-ajax')){
			modal.remove();
		}else{
			modal.removeClass('active');
		}
    });

    $('.sidebar-wrap').slimScroll({
        height: 'auto',
        size: '0',
        position: 'left',
        distance: '0px',
        wheelStep: 30
    });

});

function toast(content, type, outer, autoHide, hideTime){
	content = content || '';
	type = type || 'toast';
	outer = outer || '.toast-wrap';
	autoHide = autoHide || true;
	hideTime = hideTime || 3000;
	if(type != 'toast'){
		type = 'toast toast-' + type;
	}
	var r = randString(10);
	$(outer).prepend('<div class="' + type + ' mb-10" id="toast-' + r + '"><button class="btn btn-clear float-right"></button>'+ content + '</div>');
	if(autoHide){
		setTimeout(function(){
			$('#toast-' + r).fadeOut("fast", function(){
				$(this).remove();
			});
		}, hideTime);
	}
}
function randString(a){
    var d,
        e,
        b = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789",
        c = "";
    for (d = 0; a > d; d += 1)
        e = Math.random() * b.length, e = Math.floor(e), c += b.charAt(e);
    return c
}