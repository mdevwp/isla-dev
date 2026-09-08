jQuery(document).ready(function( $ ) {


	var animationStarted = false;
  
	function startAnimation() {
		$('.count_up .num').each(function(){
		var $this = $(this);
		var _html = $this.html();
		var num = $this.text();
		var numb = num.replace(/[^\d.]/g, '');
		console.log(num);
		
		var numValue = parseFloat(numb);
		var highlightedText = $this.next('b');
		var b = $this.next('b').text();

		if (b === "M" || b === "m") {   
		
			$this.next('b').text("k");
		  $({ Counter: 0 }).animate({ Counter: 1000 }, {
			duration: 1500,
			easing: 'swing',
			step: function () {
			  $this.text(Math.ceil(this.Counter));
			},
			complete: function() {
			  highlightedText.text(b);
			  $({ Counter: 0 }).animate({ Counter: numValue }, {
				duration: 1500,
				easing: 'swing',
				step: function () {
				  $this.html(_html);
				}
			  });
			  
			}
		  });
		} else {
			
			
		$({ Counter: 0 }).animate({ Counter: numValue }, {
			duration: 1500,
			easing: 'swing',
			step: function () {
			  if (numValue % 1 === 0) {
				$this.text(Math.ceil(this.Counter));
			  } else {
				$this.text((this.Counter).toFixed(1));
			  }
			},
			
			complete: function() {
				$this.html(_html);
			}
			
			
		  });
		}
		
		
		
		
		}); 
		
		
	
	
	}

  

	
	function checkVisibility() {
	$('.speciality-column, .stats-column, .stats-container').each(function() {
	  if ($(this).offset().top < $(window).scrollTop() + $(window).height() && !animationStarted) {
		startAnimation();
		animationStarted = true;
	  }
	});
	}

	$(window).scroll(checkVisibility);
	checkVisibility();

	$('.tab').click(function(){
		startAnimation();
		animationStarted = true;
	});



	document.getElementById('track-login-click').addEventListener('click', function(e) {
		fetch('/wp-admin/admin-ajax.php', {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: 'action=track_menu_click',
		}).then(response => response.json())
		  .then(data => console.log('Click tracked:', data));
	});


	$('.question-item').click(function(){
		let answer = $(this).next();
		let check = answer.hasClass('active');

		$('.answer').removeClass('active');
		check ? answer.removeClass('active') : answer.addClass('active');

	});
	
	

});


jQuery(document).ready(function( $ ) {
  $('.mobile-menu-icon').click(function() {
    $('.header__menu').toggleClass('show', 1000);
    $('.bar').toggleClass('close');
  });
});


jQuery(document).ready(function( $ ) {
	
	
	
	var swiper2 = new Swiper(".t-swiper", {
		slidesPerView: 3,
		spaceBetween: 10,
		
		observer: false, 
		observeParents: false, 
		lazy: false, 		
		loop: true,

		roundLengths: true,
		
		speed: 800,
		autoplay: {
			enabled: true,
			disableOnInteraction: false,
			delay: 3500,
		},
		
		pagination: {
		  el: ".swiper-pagination",
		  clickable: true,
		},
		/* breakpoints: {
          "@0.00": {
            slidesPerView: 1,
            spaceBetween: 20,
          },
          "@0.75": {
            slidesPerView: 1,
            spaceBetween: 20,
          },
          "@1.00": {
            slidesPerView: 1,
            spaceBetween: 20,
          },
          "@1.50": {
            slidesPerView: 3,
            spaceBetween: 20,
          },
        }, */
		
		breakpoints: {
		  0: { slidesPerView: 1, spaceBetween: 20 },
		  768: { slidesPerView: 2, spaceBetween: 20 },
		  1000: { slidesPerView: 3, spaceBetween: 20 },
		  /*1500: { slidesPerView: 3, spaceBetween: 20 }, */
		  1500: { slidesPerView: 3, spaceBetween: 50 },
		},


		navigation: {
			nextEl: '.swiper-button-next', 
			prevEl: '.swiper-button-prev', 
		},

		centerInsufficientSlides: true,
		
		on: {
			init() {
			  const slides = this.slides;
			  slides.forEach(slide => {
				slide.addEventListener('click', () => {
				  this.autoplay.stop();
				});

				slide.addEventListener('mouseleave', () => {
				  this.autoplay.start();
				});
			  });
			},
		  },
		  

	});
	

    var swiper1 = new Swiper(".logo-container", {
  
		observer: false, 
		observeParents: false, 
		lazy: false, 
		
		slidesPerView: 5,
		  loop: true,
		  speed: 10000,
		  autoplay: {
			enabled: true,
			delay: 1,
		}, 
		
		
        spaceBetween: 10,
        pagination: {
          el: ".swiper-pagination",
          clickable: true,
        },
		
        breakpoints: {
          "@0.00": {
            slidesPerView: 1,
            spaceBetween: 10,
          },
          "@0.75": {
            slidesPerView: 2,
            spaceBetween: 20,
          },
          "@1.00": {
            slidesPerView: 3,
            spaceBetween: 40,
          },
          "@1.50": {
            slidesPerView: 5,
            spaceBetween: 100,
          },
        },
      }); 
  
	  

    var originalBullets = document.querySelectorAll('.testimonials .swiper-pagination-bullet');
    originalBullets.forEach(function (bullet) {
        var copy = document.createElement('div');
        copy.classList.add('bullet-copy');
        copy.classList.add('swiper-pagination-bullet');
        document.querySelector('.t-pagination').appendChild(copy);

        copy.addEventListener('click', function () {
            var index = Array.from(this.parentNode.children).indexOf(this);
            originalBullets[index].click();
        });
    });

    // Следим за изменениями в пагинации
    var observer = new MutationObserver(function(mutationsList, observer) {
        for (var mutation of mutationsList) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                // Если изменился класс у кружочка, меняем цвет соответствующей копии
                var index = Array.from(originalBullets).indexOf(mutation.target);
                var copy = document.querySelectorAll('.bullet-copy')[index];
                if (mutation.target.classList.contains('swiper-pagination-bullet-active')) {
                    copy.classList.add('swiper-pagination-bullet-active');
                } else {
                    copy.classList.remove('swiper-pagination-bullet-active');
                }
            }
        }
    });

    originalBullets.forEach(function(bullet) {
        observer.observe(bullet, { attributes: true });
    });


	
	/***********************************/
		
	var feature_items = $('.feature-item');
	var itemHeight = $('.feature-item').outerHeight(true);
	var currentIndex = 0;
	

	function highlightNext() {
   
		feature_items.removeClass('reduce-0 reduce-1 reduce-2 reduce-3 reduce-4 reduce-5');

   
		let $current = $(feature_items[currentIndex]);
		$current.addClass('reduce-0');

	 
		feature_items.each(function(index, sibling) {
			let distance = Math.abs(index - currentIndex);

   
			if (distance === 1) {
				$(sibling).addClass('reduce-1');
			} else if (distance === 2) {
				$(sibling).addClass('reduce-2');
			} else if (distance === 3) {
				$(sibling).addClass('reduce-3');
			} else if (distance === 4) {
				$(sibling).addClass('reduce-4');
			} else if (distance > 4) {
				$(sibling).addClass('reduce-5');
			}
		});

	
		$('.feature-list').animate({
			top: '+=' + itemHeight
		}, 500, 'linear', function() {
	   
			$('.feature-list').prepend($('.feature-item:last'));
		
			let margin = itemHeight+15;
			let scroll_margin = '-'+margin+'px';
			//console.log(scroll);
			
			$('.feature-list').css('top', scroll_margin);
		
		});

	
		currentIndex = (currentIndex - 1 + feature_items.length) % feature_items.length;
		
	}

	let intervalId;
	if(feature_items.length && !intervalId){
		//setInterval(highlightNext, 2000);
		intervalId = setInterval(highlightNext, 6000);
		highlightNext();
	}
	
	
	/***********************************/



    $(document).on('click', '.video__preloader', function() {
		var videoID = $(this).data('video');
		var iframe = $(this).siblings('.video__element').find('iframe');
		iframe.attr('src', 'https://www.youtube.com/embed/' + videoID + '?rel=0&amp;showinfo=0');
		$(this).closest('.video').addClass('video_active');
	  
		var video = $(this).parent().find('.myVideo')[0];
	    video.play();
	  
    });
	
	$(document).on('click', '.prev-icon', function() {
	  var vd = $(this).prev();
      var videoID = vd.data('video');
      var iframe = vd.siblings('.video__element').find('iframe');
      iframe.attr('src', 'https://www.youtube.com/embed/' + videoID + '?rel=0&amp;showinfo=0');
      vd.closest('.video').addClass('video_active');
	  
	  var video = $(this).parent().find('.myVideo')[0];

	  video.play();
	  
    });
	
	
	$('.nav-link').on('click', function() {
		$('.nav-link').removeClass('active');
		$(this).addClass('active');
		$('.story-details').removeClass('active');
		var id = $(this).data('id');
		$('#' + id).addClass('active');
		
		console.log($(this).data('index'));
		
		if($(this).data('index')=='1'){
			$('.story-tabs').removeClass('v2');
		}else{
			$('.story-tabs').addClass('v2');
		}
		 
	});
	
	
	
	$('.nav-item').on('click', function() {
		$(this).parent().find('.nav-item').removeClass('active');
		$(this).addClass('active');
		$(this).parents('.content_wrapper').find('.block_content').removeClass('active');
		var id = $(this).data('id');
		$('#' + id).addClass('active');
		window.location.hash = '/' + id;
	
	});
	
	/*$('.solution_feature .nav-item').on('click', function() {
		window.location.hash = '/' + id;
	});*/
	
	var hsh = window.location.hash;
	//console.log(hsh.startsWith('#/'));

    if (hsh && hsh.startsWith('#/')) {
        var id = hsh.substring(2); 
		$('.nav-item').removeClass('active');
		$('.nav-item[data-id='+id+']').addClass('active');
		$('.block_content').removeClass('active');
        $('#' + id).addClass('active');
    }
	
	
	$('.tab-title').on('click', function() {
		$('.tab-title').removeClass('active');
		$(this).addClass('active');
		$('.tab_block').removeClass('active');
		var id = $(this).data('id');
		$('#' + id).addClass('active');
	
	});
	
	
	var swiper3 = new Swiper(".p-swiper", {
			slidesPerView: 2,
			spaceBetween: 0,
			loop: true,
			pagination: {
			  el: ".swiper-pagination",
			  clickable: true,
			},
	});		
	
	
	var active_menu = $('.menu-item.active');
	var active_tag = $('.article-tag.active');
	var active_link = $('.latest>ul li.active');
	$('.menu-item, .tags .article-tag, .latest>ul li').hover(function(){
		$(this).parent().find('a').removeClass('active');
		$(this).parent().find('li').removeClass('active');
		$(this).addClass('active');
	}, function(){
		$(this).parent().find('a').removeClass('active');
		$(this).parent().find('li').removeClass('active');
		if(!active_menu.hasClass('active')) active_menu.addClass('active');
		if(!active_tag.hasClass('active')) active_tag.addClass('active');
		if(!active_link.hasClass('active')) active_link.addClass('active');
	});


		hbspt.forms.create({
            region: "na1",
            portalId: "6100340",
            formId: "d54f00cf-1be4-4408-b4e6-23afadefcebe",
            target: '#hubspot-form'
        });

        function openPopup(e) {
			e.preventDefault();
            $('#popup').css('display', 'flex');
            setTimeout(function() {
                $('#popup .popup-content').css('transform', 'scale(1)');
            }, 10); 
        }
		
		$('.tab, .nav-link').on('click', function() {
			$('video').each(function() {
				this.pause(); 
				this.currentTime = 0; 
			});
		});
	
		
		function openThankPopup() {
            $('#thank-popup').css('display', 'flex');
            setTimeout(function() {
                $('#thank-popup .popup-content').css('transform', 'scale(1)');
            }, 10); 
        }

   
		
		
        function closePopup() {
            $('#popup .popup-content').css('transform', 'scale(0)');
            setTimeout(function() {
                $('#popup').css('display', 'none');
            }, 300); 
        }
		
		
		function closeThankPopup() {
            $('#thank-popup .popup-content').css('transform', 'scale(0)');
            setTimeout(function() {
				$('#thank-popup').css('display', 'none');
            }, 300); 
        }
		

		if (window.location.hash === "#thank") {
			openThankPopup();
		}
		

        $('.book-nav-btn, .book-demo-btn, .login-button').on('click', openPopup);

        $('#closePopup').on('click', closePopup);
		$('#closeThankPopup').on('click', closeThankPopup);

        $(window).on('click', function(e) {
            if ($(e.target).is('#popup')) {
                closePopup();
            }
        });
		


var ajaxurl = admin_ajax.url;

/********** Resources*****************/

	$('.tags-row .tag').click(function() {
		

		$('.tags-row .tag').removeClass('active');
		$(this).addClass('active');
		let selected_tag = $(this).attr('id');
		let keywords = $('.key_words').val();
		//let count = $('.posts-filter .article').length;
		let posts_wrapper = $('.content-section.posts-filter');
	
		$.ajax({
			type: 'POST',
			url: ajaxurl, 
			data: {
				action: 'filter_posts', 
				tag: selected_tag,
				keywords: keywords,
				//count: count,
			},
			success: function(response) {
				
				posts_wrapper.html(response['posts']);
				if(!response['load_more']){	
					$('.cta-button.load-more').hide();
				}
			}
		});
			
	  
	});
	
	
	$('.key_words').on('keydown', function(e) {
		if (event.key === 'Enter') {
			
			e.preventDefault();
			
			//let count = $('.posts-filter .article').length;
			if($('.tag.active').length){
				selectedTag = $('.tag.active').attr('id') ;
			}else{
				let tags = [];
				$('.tag').each(function(el){
					tags.push($(this).attr('id'));
				});
				selectedTag  = tags;
			}
			let posts_wrapper = $('.content-section.posts-filter');
			let keywords = $('.key_words').val();

			$.ajax({
				type: 'POST',
				url: ajaxurl, 
				data: {
					action: 'filter_posts', 
					tag: selectedTag,
					keywords: keywords,
					//count: count,

				},
				success: function(response) {
					posts_wrapper.html(response['posts']);
					
					//$('.tags-row .tag.active').data('page', page_number++);
					if(!response['load_more']){	
						$('.cta-button.load-more').hide();
					}
				}
			});
		
		}
			  
	});


/*********************************/
	var canLoadMore = true;
	
	function loadMore() {
        if (canLoadMore) {

			let page_number = $('.tag.active').length ? Number($('.tag.active').data('page'))+1 : 2;
			let count = $('.posts-filter .article').length;

			if($('.tag.active').length){
				selectedTag = $('.tag.active').attr('id') ;
			}else{
				let tags = [];
				$('.tag').each(function(el){
					tags.push($(this).attr('id'));
				});
				selectedTag  = tags;
			}
			
			console.log(count);
			
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: 'filter_posts',
                    tag: selectedTag,
                    page: page_number,  
					count: count,
                },
                success: function(response) {

                    if (response) {
                        $('.posts-filter').append(response['posts']);
						$('.tags-row .tag.active').data('page', page_number++);
						if(!response['load_more']){	
							$('.cta-button.load-more').hide();
						}

                    } 
                }
            });
        }
    }
	
	
	$('.cta-button.load-more').click(function(e) {
		e.preventDefault();
        loadMore();
    });
	
	/*********************************/
	
	
	
	const url = new URL(window.location.href);
    const hash = url.hash.split('?')[0];
    const query = url.hash.split('?')[1];
    if (hash === '#latest' && query) {
        const tagElement = $('#' + query + '.tag');
        if (tagElement.length) {
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 500, function() {
                tagElement.click();
				history.replaceState(null, null, url.pathname);
            });
        }
    }
	
	
	
	/*********************************/
	
	document.addEventListener("DOMContentLoaded", function() {
        var submitButton = document.querySelector("input.hs-button.primary.large");
        if (submitButton) {
            submitButton.style.fontSize = "18px";
            submitButton.style.fontFamily = "'Manrope', sans-serif";
        }
    });
	
	

});






   
	
	
	
