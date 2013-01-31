var j = jQuery.noConflict();

j(function(){
	j('.sf-menu').superfish({dropShadows: false, autoArrows: false});

	if(j('#fpslider-in').length) {
		var prevnext = '<div id="fpslider-prevnext"><a href="#" id="fpslider-prev"></a><a href="#" id="fpslider-next"></a></div>';
		j('#fpslider-in').after(prevnext).cycle({
			fx:'scrollHorz',
			pause: true,
			prev: '#fpslider-prev',
			next: '#fpslider-next',
			speed: 1000,
			timeout: 6000
		});
	}

	if(j('#nm-slides-in').length) {
		var prevnext = '<div id="nm-slides-prevnext"><a href="#" id="nm-slides-prev"></a><a href="#" id="nm-slides-next"></a></div>';
		j('#nm-slides-in').after(prevnext).cycle({
			fx:'scrollHorz',
			pause: true,
			prev: '#nm-slides-prev',
			next: '#nm-slides-next',
			speed: 1000,
			timeout: 4000
		});
	}

	if(j('.nm-gallery-in').length) {
		var prevnext = '<div class="nm-gallery-prevnext"><a href="#" class="nm-gallery-prev"></a><a href="#" class="nm-gallery-next"></a></div>';
		j('.nm-gallery-in').after(prevnext).cycle({
			fx:'scrollHorz',
			pause: true,
			prev: '.nm-gallery-prev',
			next: '.nm-gallery-next',
			timeout: 0,
			speed: 1000
		});
	}

	j('.nm-gallery-in .nm-gallery-item').click(function() {
		var mainImgArea = j(this).parents('.nm-gallery-wrap').children('.nm-gallery-main');
		j(mainImgArea).append('<div class="loading"></div>');
		var bimgsrc = j(this).attr('href');
		var newImage = j('<img class="aligncenter" />').attr('src',bimgsrc+ '?' + new Date().getTime());
		j(newImage).load(function() {
			j(mainImgArea).remove('.loading');
			j(mainImgArea).html(newImage);
		});
		return false;
	});
	
	j('#nm-newsletter').submit(function(e){
		emailPattern = /^\s*[\w-]+(\.[\w-]+)*@([\w-]+\.)+[A-Za-z]{2,7}\s*$/;
		e.preventDefault();
		var email = jQuery.trim( j('#nm-newsletter-email').val());
		if (email == '' || email =='输入你的邮箱地址') { alert('请输入您的邮件地址'); return ;}
		if( !emailPattern.test( email ) ){ alert("邮件地址格式不正确");return ;}
		jQuery.ajax({
			type: "POST",
			url: 'http://www.neimanmarcus.com.cn/designer/index/jsonSubscription/?callback=?',
			//url: 'http://www.neimanmarcus.com.cn',
			data: 'email=' + email,
			dataType: 'jsonp',
			cache:false,
			error: function() {
				alert('请输入正确的邮件地址!');
			},
			success: function(msg){ 
				if (msg.isok) {
					//This is our GA track
					_gaq.push(['_trackEvent','NewsletterSubscribe_Success','Click']);
					//This is our Confirm prompt function, you can change it.
					alert('恭喜您！您已成功订阅我们的邮件！');
				} else {
					alert('该邮件地址已订阅，请更换其它邮件地址！');
				}
				
			}
		});
		return false;
	});
});