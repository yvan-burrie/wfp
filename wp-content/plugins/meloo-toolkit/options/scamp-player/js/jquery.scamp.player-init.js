/**
 * Scamp Player init scripts
 *
 * @author Rascals Themes
 * @category JavaScripts
 * @package Meloo Toolkit
 * @version 1.0.0
 */

var sc = (function($) {

    "use strict";

    /* Extended functions
	 -------------------------------- */
    (function(func) {
        jQuery.fn.addClass = function() {
            func.apply(this, arguments);
            this.trigger('classChanged');
            return this;
        }
    }
    )(jQuery.fn.addClass);
    // pass the original function as an argument


    /* Run scripts
	 -------------------------------- */

    /* Ajax: Enabled */
    if ($('body').hasClass('WPAjaxLoader')) {
        $(document).on('AjaxLoadEnd', function() {
            sc.init();
        });

        /* Ajax: Disabled */
    } else {
        $(document).ready(function($) {
            sc.init($);
        });
    }

    return {
        loaded: false,
        scamp_player: null,

        /* Init
		 -------------------------------- */
        init: function() {

            /* First load */
            if (!sc.loaded) {

                this.player.init();
                this.open_player_after_click();
                this.actions();
                this.scrollbars();
                this.waveform.init();

                /* Reloaded */
            } else {

                this.open_player_after_click();
                this.scrollbars();
                this.waveform.init();
                this.scamp_player.update_content();
                this.scamp_player.update_analyser();
                this.scamp_player.update_events('body');
            }

            sc.loaded = true;

            $(document).on( "AjaxPostsLoaded" , function(e){
                sc.scamp_player.update_events(e.wrapper);
            } );

        },

        /* Scrollbars
		 -------------------------------- */
        scrollbars: function() {
            if ($('.sp-tracklist-block.sp-has-fixed-height').length) {
                $('.sp-tracklist-block.sp-has-fixed-height').each(function() {
                    var id = $(this).attr('id')
                      , Scrollbar = window.Scrollbar;
                    Scrollbar.init(document.querySelector('#' + id), {});
                });
            }
        },

        /* Open Player after Click
          -------------------------------- */ 
        open_player_after_click : function(){

            if ($('#scamp_player').hasClass('sp-open-after-click')) {
                $('.sp-play-track, .sp-play-list').click( function(event) {
                    $('#scamp_player').addClass('sp-show-player');
                });
            }

        },

        /* Player Actions
		 -------------------------------- */
        actions: function() {

            /* Show list on startup*/
            if ($('#scamp_player').hasClass('sp-show-list')) {
                $('body').addClass('sp-show-list');
            }

            /* Show Player */
            $('a[href="#show-player"]').on('click', function(event) {

                event.preventDefault();
                event.stopPropagation();

                if ($('#scamp_player').hasClass('sp-show-player')) {
                    $('#scamp_player').removeClass('sp-show-list');
                    $('#scamp_player').removeClass('sp-show-player').addClass('sp-hidden-player');
                } else {
                    // Show player
                    $('#scamp_player').removeClass('sp-hidden-player').addClass('sp-show-player');
                }

            });


            /* Lyrics button */
            $('body').on('click', '.sp-tracklist li .track-lyrics', function() {
                var $this = $(this)
                  , $li = $this.parents('li')
                  , $list = $this.parents('.sp-tracklist');

                $list.find('li').not($li).find('.track-row-lyrics').slideUp();
                $list.find('li').not($li).find('.track-lyrics.is-active').removeClass('is-active');

                $this.toggleClass('is-active');
                $li.find('.track-row-lyrics').slideToggle();

            });

            /* Player status */
            $('#scamp_player').on('classChanged', function() {

                if ($(this).hasClass('sp-show-player')) {
                    $('a[href="#show-player"]').addClass('status-show-player');
                } else {
                    $('a[href="#show-player"]').removeClass('status-show-player');
                }

                if ($(this).hasClass('playing')) {

                    $('a[href="#show-player"]').addClass('status-playing').removeClass('status-loading status-paused');
                    var pos = $('#scamp_player .sp-position').width(), el_w = $(window).width(), max = 144, p, x;

                    pos = parseFloat(pos / el_w) * 100;
                    pos = pos.toFixed(0);
                    p = pos / 100;
                    x = p * max;
                    $('.nav-player-btn .circle').css({
                        'stroke-dasharray': +x + ' 144'
                    });
                } else if ($(this).hasClass('loading')) {
                    $('a[href="#show-player"]').addClass('status-loading').removeClass('status-playing status-paused');
                } else if ($(this).hasClass('paused')) {
                    $('a[href="#show-player"]').addClass('status-paused').removeClass('status-playing status-loading');
                } else {
                    $('a[href="#show-player"]').removeClass('status-playing status-loading status-paused');
                }

            });
        },

        /* Waveform
		 -------------------------------- */
        waveform: {
            count: 0,
            max: null,
            list: [],

            init: function() {
                sc.waveform.count = 0;
                sc.waveform.list = $('.track-waveform');
                sc.waveform.max = $('.track-waveform').length - 1;
                if (sc.waveform.max >= 0) {
                    sc.waveform.generate(sc.waveform.list[sc.waveform.count]);
                }

            },
            generate: function(el) {

                if ($(el).hasClass('ready') || $(el).hasClass('error')) {
                    return;
                }

                var w = $(el), id = w.attr('id'), audio = w.attr('data-audio'), waveform, shadow_height = w.attr('data-shadow-height'), colors = ['#ff7700', '#ff2400', '#ff7700', '#ff2400'], colors_d = w.attr('data-colors'), waveform_w = $('#' + id + ' .waveform').prop('width'), waveform_h = $('#' + id + ' .waveform').prop('height'), ctx;

                if (Waveform != undefined && id !== undefined && audio !== undefined && audio !== '') {

                    if (colors_d !== undefined) {
                        colors = colors_d.split(',');
                    }
                    if (shadow_height !== undefined) {
                        shadow_height = parseInt(shadow_height, 10);
                    } else {
                        shadow_height = 100;
                    }
                    w.addClass('loading');

                    $.ajax({
                        url: audio,
                        async: false,
                        type: "GET",
                        dataType: "binary",
                        processData: false,
                        success: function(data) {
                            var blob = data;
                            Waveform.generate(blob, {
                                canvas_width: waveform_w,
                                canvas_height: waveform_h,
                                bar_width: 4,
                                bar_gap: 0.4,
                                wave_start_color: colors[0],
                                wave_end_color: colors[1],
                                shadow_height: shadow_height,
                                shadow_start_color: colors[2],
                                shadow_end_color: colors[3],
                                shadow_opacity: 0.2,
                                shadow_gap: 1,
                                download: false,
                                onComplete: function(png, pixels) {
                                    waveform = $('#' + id + ' .waveform')[0];
                                    w.addClass('ready');
                                    w.removeClass('loading');
                                    ctx = waveform.getContext('2d');
                                    ctx.putImageData(pixels, 0, 0);
                                    sc.waveform.count++;
                                    if (sc.waveform.count <= sc.waveform.max) {
                                        sc.waveform.generate(sc.waveform.list[sc.waveform.count]);
                                    }
                                    //settings.audio_player.update_events( w );
                                }
                            });

                        },

                        error: function(xhr, status, err) {
                            console.log(status);
                            w.addClass('error');
                        }

                    });
                    // Ajax magic
                }
            }

        },

        /* Scamp Player
		 -------------------------------- */
        player: {

            v: {},
            eq_enterframe: null,
            track: null,
            scale: null,
            vis_type: null,
            v_id: null,
            status: null,
            audio: null,
            eq_ctx: null,
            comp: null,
            canvas: null,
            cwidth: null,
            cheight: null,
            gradient: null,
            meterWidth: null,
            gap: null,
            meterNum: null,

            init: function() {

                // Add Iframe
                var isMobile = false; //initiate as false
                // device detection
                if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
                    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
                    isMobile = true;
                }

                if ( isMobile == false ) {
                    var iframe = document.createElement('iframe');
                    iframe.style.display = "none";
                    iframe.allow = 'autoplay';
                    iframe.id = 'audio';
                    iframe.src = scamp_vars.plugin_uri + '/blank.mp3';
                    document.body.appendChild(iframe);
                }

                var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || safari.pushNotification);

                if ( isSafari ) {
                    var analyser = false;
                    scamp_vars.autoplay = false;
                } else {
                    var analyser = true;
                }


                sc.scamp_player = new $.ScampPlayer($('#scamp_player'),{

                    // Default Scamp Player options
                    volume: scamp_vars.volume,
                    // Start volume level
                    autoplay: scamp_vars.autoplay,
                    // Autoplay track
                    no_track_image: scamp_vars.plugin_assets_uri + '/images/no-track-image.png',
                    // Placeholder image for track cover
                    path: scamp_vars.plugin_uri,
                    loop: scamp_vars.loop,
                    // Loop tracklist
                    load_first_track: scamp_vars.load_first_track,
                    // Load First track
                    random: scamp_vars.random,
                    // Random playing
                    titlebar: scamp_vars.titlebar,
                    // Replace browser title on track title
                    client_id: scamp_vars.soundcloud_id,
                    // Soundcloud Client ID
                    shoutcast: scamp_vars.shoutcast,
                    enable_analyser: analyser,
                    base64: scamp_vars.base64,
                    shoutcast_interval: scamp_vars.shoutcast_interval,
                    player_content: '<div id="sp-toggle-wrap"><div id="sp-toggle"></div></div><div class="sp-main-container"><div class="sp-queue-container"><div class="sp-queue"><div id="sp-scroller"><table id="sp-queue-scroll"><thead><tr><th class="sp-list-controls" colspan="5"><span id="sp-empty-queue">' + scamp_vars.empty_queue + '</span></th></tr><tr><th>' + scamp_vars.play_label + '</th><th>' + scamp_vars.cover_label + '</th><th class="sp-th-title">' + scamp_vars.title_label + '</th><th class="sp-th-cart sp-small-screen">' + scamp_vars.buy_label + '</th><th class="sp-th-remove sp-small-screen sp-medium-screen">' + scamp_vars.remove_label + '</th></tr></thead><tbody></tbody></table></div></div></div><div class="sp-player-wrap"><div class="sp-progress-container"><div class="sp-progress"><span class="sp-loading"></span><span class="sp-position"></span></div></div><div class="sp-player-container"><div class="sp-buttons-container"><div class="sp-controls"><a class="sp-prev-button"></a><a class="sp-play-button"></a><a class="sp-next-button"></a><div class="sp-volume-container"><div class="sp-volume-bar-container"><div class="sp-volume-slider"><span class="sp-volume-position"></span></div></div></div></div><div class="sp-queue-button-container"><span class="sp-badge"></span><a class="sp-queue-button"></a></div></div><div class="sp-track-container"><a class="sp-track-cover"><img src="' + scamp_vars.plugin_assets_uri + 'images/no-track-image.png" alt="Track cover" class="sp-track-artwork"/></a><div class="sp-track-details"><a class="sp-track-title"></a><a class="sp-track-artist"></a><div class="sp-marquee-container"><span class="sp-marquee"></span></div></div></div><div class="sp-time"><span class="sp-time-elapsed"></span><span class="sp-time-total"></span></div></div></div></div>',
                    debug: false,
                    audioAnalyser: function(a) {
                        sc.player.status = a.status;
                        sc.player.v = a.v;
                        switch (sc.player.status) {
                        case 'init':
                            sc.player.vis();
                            break;
                        case 'play':
                            sc.player.vis();
                            break;
                        case 'stop':
                            sc.player.end_vis();
                            break;
                        case 'update':
                            cancelAnimationFrame(sc.player.eq_enterframe);
                            sc.player.vis();
                            break;
                        }

                    }

                });

                window.addEventListener('resize', sc.player.resize_eq(), false);

            },
            vis: function() {
                if (sc.player.status == 'init') {
                    $('.sp-vis.sp-vis-on').removeClass('sp-vis-on');
                }
                if ($('.sp-vis.sp-vis-on').length) {
                    sc.player.start_vis();
                } else if ($('a.sp-play-track.has-vis[href="' + sc.player.v.audioContentSrc + '"]').length) {

                    sc.player.track = $('a.sp-play-track.has-vis[href="' + sc.player.v.audioContentSrc + '"]');

                    /* Track has visualisation */
                    if (typeof sc.player.track.data('v') !== undefined) {
                        sc.player.v_id = sc.player.track.data('v');
                        sc.player.vis_type = sc.player.track.data('vt');
                        if ($('#' + sc.player.v_id).length) {
                            $('#' + sc.player.v_id).addClass('sp-vis-on');
                            if ($('#' + sc.player.v_id).find('.tracklist-waveform:not(.ready):not(.error)')) {
                                var wave = $('#' + sc.player.v_id).find('.tracklist-waveform');
                                sc.waveform.generate(wave);
                            }
                            sc.player.start_vis();
                        }
                    }
                }
            },
            start_vis: function() {

                /* Visualisation type */
                if (sc.player.vis_type == 'lines') {
                    sc.player.init_eq();
                    sc.player.render_vis_lines();
                } else if (sc.player.vis_type == 'bars') {
                    sc.player.init_eq();
                    sc.player.render_vis_bars();
                }
            },
            end_vis: function() {
                sc.player.clear_eq();
            },
            init_eq: function() {
                sc.player.canvas = document.getElementById(sc.player.v_id + '-canvas');
                sc.player.eq_ctx = sc.player.canvas.getContext('2d');
                sc.player.redraw_eq();
            },
            redraw_eq: function() {
                $('#' + sc.player.v_id + '-canvas').prop('width', $('.sp-vis.sp-vis-on').width());
                $('#' + sc.player.v_id + '-canvas').prop('height', $('.sp-vis.sp-vis-on').height());
                sc.player.cwidth = sc.player.canvas.width;
                sc.player.cheight = sc.player.canvas.height;

                sc.player.gap = 2;
                //gap between meters
                if (sc.player.cwidth < 400) {
                    sc.player.scale = .5;
                    sc.player.meterWidth = Math.round(sc.player.cwidth / 14);
                    //width of the meters in the spectrum
                } else {
                    sc.player.scale = 1.1;
                    sc.player.meterWidth = Math.round(sc.player.cwidth / 30);
                    //width of the meters in the spectrum
                }
                sc.player.meterNum = sc.player.cwidth / (10 + 2);
                //count of the meters
                sc.player.gradient = sc.player.eq_ctx.createLinearGradient(0, 0, 0, sc.player.cheight);
                sc.player.gradient.addColorStop(1, '#4063e6');
                sc.player.gradient.addColorStop(0.5, '#b869ff');
                sc.player.gradient.addColorStop(0, '#eb18d9');
            },
            render_vis_bars: function() {
                //console.log('renderFrame');
                var array = new Uint8Array(sc.player.v.analyser.frequencyBinCount);
                sc.player.v.analyser.getByteFrequencyData(array);
                var step = Math.round(array.length / sc.player.meterNum);
                //sample limited data from the total array
                sc.player.eq_ctx.clearRect(0, 0, sc.player.cwidth, sc.player.cheight);
                for (var i = 0; i < sc.player.meterNum; i++) {
                    var value = array[i * step];
                    value = value * sc.player.scale;
                    sc.player.eq_ctx.fillStyle = sc.player.gradient;
                    sc.player.eq_ctx.fillRect(i * (sc.player.meterWidth + sc.player.gap), sc.player.cheight, sc.player.meterWidth, sc.player.cheight - value);
                    //the meter
                }
                sc.player.eq_enterframe = requestAnimationFrame(sc.player.render_vis_bars);
            },
            render_vis_lines: function() {
                var array = new Uint8Array(sc.player.v.analyser.frequencyBinCount);
                sc.player.v.analyser.getByteFrequencyData(array);
                var step = Math.round(array.length / sc.player.cwidth);
                //sample limited data from the total array
                sc.player.eq_ctx.clearRect(0, 0, sc.player.cwidth, sc.player.cheight);

                sc.player.eq_ctx.strokeStyle = "#464646";
                sc.player.eq_ctx.beginPath();
                for (var i = 0; i < sc.player.meterNum; i++) {
                    var value = array[i * step];
                    value = value * .5;
                    sc.player.eq_ctx.lineTo(i * (sc.player.meterWidth + sc.player.gap), (sc.player.cheight + 50) - value);
                    sc.player.eq_ctx.stroke();
                }
                sc.player.eq_ctx.strokeStyle = "#4063e6";
                sc.player.eq_ctx.beginPath();
                for (var i = 0; i < sc.player.meterNum; i++) {
                    var value = array[i * step];
                    value = value * .2;
                    sc.player.eq_ctx.lineTo(i * (sc.player.meterWidth + sc.player.gap), (sc.player.cheight) - value);
                    sc.player.eq_ctx.stroke();
                }
                sc.player.eq_enterframe = requestAnimationFrame(sc.player.render_vis_lines);
            },
            clear_eq: function() {
                cancelAnimationFrame(sc.player.eq_enterframe);
                // sc.player.eq_ctx.clearRect(0, 0, sc.player.cwidth, sc.player.cheight);
            },
            resize_eq: function() {
                if ($('.sp-vis.sp-vis-on').length) {
                    sc.player.redraw_eq();
                }
            }
        }
    }

}(jQuery));
