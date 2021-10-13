var Waveform;

(function($) {

	var audio_context;
    if (typeof AudioContext !== "undefined") {
        audio_context = new AudioContext();
    } else if (typeof webkitAudioContext !== "undefined") {
        audio_context = new webkitAudioContext();
    } else {
       	console.log( 'Unable to run this Web Audio API example' );
    	return;
    }

	Waveform = {

		settings : {
			canvas_width: 453,
			canvas_height: 66,
			bar_width: 3,
			bar_gap : 0.2,
			wave_start_color: "#ff7700",
			wave_end_color: "#ff2400",
			download: false,
			shadow_height : 70,
			shadow_start_color: "#ff7700",
			shadow_end_color: "#ff2400",
			shadow_opacity : 0.2,
			shadow_gap : 1, // 1px
			onComplete: function(png, pixels) {}
		},

		generate: function(file, options) {

			// preparing canvas
			this.settings.canvas = document.createElement('canvas');
			this.settings.context = this.settings.canvas.getContext('2d');

			this.settings.canvas.width = (options.canvas_width !== undefined) ? parseInt(options.canvas_width) : this.settings.canvas_width;
			this.settings.canvas.height = (options.canvas_height !== undefined) ? parseInt(options.canvas_height) : this.settings.canvas_height;

			// Wave gradient
			this.settings.wave_start_color = (options.wave_start_color !== undefined) ? options.wave_start_color : this.settings.wave_start_color;
			this.settings.wave_end_color = (options.wave_end_color !== undefined) ? options.wave_end_color : this.settings.wave_end_color;

			// Shadow gradient
			this.settings.shadow_start_color = (options.shadow_start_color !== undefined) ? options.shadow_start_color : this.settings.shadow_start_color;
			this.settings.shadow_end_color = (options.shadow_end_color !== undefined) ? options.shadow_end_color : this.settings.shadow_end_color;

			// Shadow opacity
			this.settings.shadow_opacity = (options.shadow_opacity !== undefined) ? parseFloat(options.shadow_opacity) : this.settings.shadow_opacity;

			// Shadow gap
			this.settings.shadow_gap = (options.shadow_gap !== undefined) ? parseInt(options.shadow_gap) : this.settings.shadow_gap;

			// Gap
			this.settings.bar_width = (options.bar_width !== undefined) ? parseInt(options.bar_width) : this.settings.bar_width;
			this.settings.bar_gap = (options.bar_gap !== undefined) ? parseFloat(options.bar_gap) : this.settings.bar_gap;

			this.settings.download = (options.download !== undefined) ? options.download : this.settings.download;

			this.settings.onComplete = (options.onComplete !== undefined) ? options.onComplete : this.settings.onComplete;

			this.settings.shadow_height = (options.shadow_height !== undefined) ? parseFloat(options.shadow_height) : this.settings.shadow_height;

			// read file buffer
			var reader = new FileReader();
			Waveform.audioContext = audio_context;
	        reader.onload = function(event) {

	            Waveform.audioContext.decodeAudioData(event.target.result, function(buffer) {
	                Waveform.extractBuffer(buffer);
	            });
	        };
	        reader.readAsArrayBuffer(file);
		},

		extractBuffer: function(buffer) {
		    buffer = buffer.getChannelData(0);
		    var sections = this.settings.canvas.width;
		    var len = Math.floor(buffer.length / sections);
		    var vals = [];
		    var maxHeight = this.settings.canvas.height-this.settings.shadow_height;
		    for (var i = 0; i < sections; i += this.settings.bar_width) {
		        vals.push(this.bufferMeasure(i * len, len, buffer) * 10000);
		    }

		    for (var j = 0; j < sections; j += this.settings.bar_width) {
		        var scale =  maxHeight / Math.max.apply(Math,vals);
		        var val = this.bufferMeasure(j * len, len, buffer) * 10000;
		        val *= scale;
		        val += 1;
		       
		        this.drawBar(j, val);

		        if ( this.settings.shadow_height > 0 ) {

		        	scale =  this.settings.shadow_height / Math.max.apply(Math,vals);
			        val = this.bufferMeasure(j * len, len, buffer) * 10000;
			        val *= scale;
			        val += 1;

	        		this.drawShadow(j, val);
	        	}
		    }

		    if (this.settings.download) {
		    	this.generateImage();
		    }
		    this.settings.onComplete(this.settings.canvas.toDataURL('image/png'), this.settings.context.getImageData(0, 0, this.settings.canvas.width, this.settings.canvas.height));
		    // clear canvas for redrawing
		    this.settings.context.clearRect(0, 0, this.settings.canvas.width, this.settings.canvas.height);
	    },

	    bufferMeasure: function(position, length, data) {
	        var sum = 0.0;
	        for (var i = position; i <= (position + length) - 1; i++) {
	            sum += Math.pow(data[i], 2);
	        }
	        return Math.sqrt(sum / data.length);
	    },

	    drawBar: function(i, h) {

	    	var grd = this.settings.context.createLinearGradient(0,0,0,170);
			grd.addColorStop( 0, this.settings.wave_start_color );
			grd.addColorStop( 1, this.settings.wave_end_color );

			this.settings.context.fillStyle = grd;

			var w = this.settings.bar_width;
	        if (this.settings.bar_gap !== 0) {
	            w *= Math.abs(1 - this.settings.bar_gap);
	        }
	        var x = i + (w / 2),
	            y = this.settings.canvas.height - h;

	        // Shadow
	        y = y - this.settings.shadow_height;
	        this.settings.context.fillRect(x, y, w, h);

	    },

	    drawShadow: function(i, h) {

	    	var grd = this.settings.context.createLinearGradient(0,0,0,170);
			grd.addColorStop( 0, this.settings.shadow_start_color );
			grd.addColorStop( 1, this.settings.shadow_end_color );

			this.settings.context.fillStyle = grd;

			var w = this.settings.bar_width;
	        if (this.settings.bar_gap !== 0) {
	            w *= Math.abs(1 - this.settings.bar_gap);
	        }
	        var x = i + (w / 2),
	            y = this.settings.canvas.height - this.settings.shadow_height;

	        y = y + this.settings.shadow_gap;
	        this.settings.context.globalAlpha = this.settings.shadow_opacity;
	        this.settings.context.fillRect(x, y, w, h);
	        this.settings.context.globalAlpha = 1.0;
	    },

	    generateImage: function() {
	    	var image = this.settings.canvas.toDataURL('image/png');

	    	var link = document.createElement('a');
	    	link.href = image;
	    	link.setAttribute('download', '');
	    	link.click();
	    }
	}

})(jQuery);


/*!
* Parallax Scroll
**/
;(function ($) {

	// if ( $( window ).width() < 750 ) {  
	// 	return;
	// }
 	$(function() {
	  ParallaxScroll.init();
	});

	var ParallaxScroll = {
	  /* PUBLIC VARIABLES */
	  showLogs: false,
	  round: 1500,

	  /* PUBLIC FUNCTIONS */
	  init: function() {
	    this._log("init");
	    if (this._inited) {
	      this._log("Already Inited");
	      this._inited = true;
	      return;
	    }
	    this._requestAnimationFrame = (function() {
	      return window.requestAnimationFrame ||
	        window.webkitRequestAnimationFrame ||
	        window.mozRequestAnimationFrame ||
	        window.oRequestAnimationFrame ||
	        window.msRequestAnimationFrame ||
	        function( /* function */ callback, /* DOMElement */ element) {
	          window.setTimeout(callback, 1000 / 60);
	        };
	    })();
	    this._onScroll(true);
	  },

	  /* PRIVATE VARIABLES */
	  _inited: false,
	  _properties: ['x', 'y', 'z', 'rotateX', 'rotateY', 'rotateZ', 'scaleX', 'scaleY', 'scaleZ', 'scale'],
	  _requestAnimationFrame: null,

	  /* PRIVATE FUNCTIONS */
	  _log: function(message) {
	    if (this.showLogs) console.log("Parallax Scroll / " + message);
	  },
	  _onScroll: function(noSmooth) {
	    var scroll = $(document).scrollTop();
	    var windowHeight = $(window).height();
	    this._log("onScroll " + scroll);
	    $("[data-parallax]").each($.proxy(function(index, el) {
	      var $el = $(el);
	      var properties = [];
	      var applyProperties = false;
	      var style = $el.data("style");
	      if (style == undefined) {
	        style = $el.attr("style") || "";
	        $el.data("style", style);
	      }
	      var datas = [$el.data("parallax")];
	      var iData;
	      for (iData = 2;; iData++) {
	        if ($el.data("parallax" + iData)) {
	          datas.push($el.data("parallax-" + iData));
	        } else {
	          break;
	        }
	      }
	      var datasLength = datas.length;
	      for (iData = 0; iData < datasLength; iData++) {
	        var data = datas[iData];
	        var scrollFrom = data["from-scroll"];
	        if (scrollFrom == undefined) scrollFrom = Math.max(0, $(el).offset().top - windowHeight);
	        scrollFrom = scrollFrom | 0;
	        var scrollDistance = data["distance"];
	        var scrollTo = data["to-scroll"];
	        if (scrollDistance == undefined && scrollTo == undefined) scrollDistance = windowHeight;
	        scrollDistance = Math.max(scrollDistance | 0, 1);
	        var easing = data["easing"];
	        var easingReturn = data["easing-return"];
	        if (easing == undefined || !$.easing || !$.easing[easing]) easing = null;
	        if (easingReturn == undefined || !$.easing || !$.easing[easingReturn]) easingReturn = easing;
	        if (easing) {
	          var totalTime = data["duration"];
	          if (totalTime == undefined) totalTime = scrollDistance;
	          totalTime = Math.max(totalTime | 0, 1);
	          var totalTimeReturn = data["duration-return"];
	          if (totalTimeReturn == undefined) totalTimeReturn = totalTime;
	          scrollDistance = 1;
	          var currentTime = $el.data("current-time");
	          if (currentTime == undefined) currentTime = 0;
	        }
	        if (scrollTo == undefined) scrollTo = scrollFrom + scrollDistance;
	        scrollTo = scrollTo | 0;
	        var smoothness = data["smoothness"];
	        if (smoothness == undefined) smoothness = 30;
	        smoothness = smoothness | 0;
	        if (noSmooth || smoothness == 0) smoothness = 1;
	        smoothness = smoothness | 0;
	        var scrollCurrent = scroll;
	        scrollCurrent = Math.max(scrollCurrent, scrollFrom);
	        scrollCurrent = Math.min(scrollCurrent, scrollTo);
	        if (easing) {
	          if ($el.data("sens") == undefined) $el.data("sens", "back");
	          if (scrollCurrent > scrollFrom) {
	            if ($el.data("sens") == "back") {
	              currentTime = 1;
	              $el.data("sens", "go");
	            } else {
	              currentTime++;
	            }
	          }
	          if (scrollCurrent < scrollTo) {
	            if ($el.data("sens") == "go") {
	              currentTime = 1;
	              $el.data("sens", "back");
	            } else {
	              currentTime++;
	            }
	          }
	          if (noSmooth) currentTime = totalTime;
	          $el.data("current-time", currentTime);
	        }
	        this._properties.map($.proxy(function(prop) {
	          var defaultProp = 0;
	          var to = data[prop];
	          if (to == undefined) return;
	          if (prop == "scale" || prop == "scaleX" || prop == "scaleY" || prop == "scaleZ") {
	            defaultProp = 1;
	          } else {
	            to = to | 0;
	          }
	          var prev = $el.data("_" + prop);
	          if (prev == undefined) prev = defaultProp;
	          var next = ((to - defaultProp) * ((scrollCurrent - scrollFrom) / (scrollTo - scrollFrom))) + defaultProp;
	          var val = prev + (next - prev) / smoothness;
	          if (easing && currentTime > 0 && currentTime <= totalTime) {
	            var from = defaultProp;
	            if ($el.data("sens") == "back") {
	              from = to;
	              to = -to;
	              easing = easingReturn;
	              totalTime = totalTimeReturn;
	            }
	            val = $.easing[easing](null, currentTime, from, to, totalTime);
	          }
	          val = Math.ceil(val * this.round) / this.round;
	          if (val == prev && next == to) val = to;
	          if (!properties[prop]) properties[prop] = 0;
	          properties[prop] += val;
	          if (prev != properties[prop]) {
	            $el.data("_" + prop, properties[prop]);
	            applyProperties = true;
	          }
	        }, this));
	      }
	      if (applyProperties) {
	        if (properties["z"] != undefined) {
	          var perspective = data["perspective"];
	          if (perspective == undefined) perspective = 800;
	          var $parent = $el.parent();
	          if (!$parent.data("style")) $parent.data("style", $parent.attr("style") || "");
	          $parent.attr("style", "perspective:" + perspective + "px; -webkit-perspective:" + perspective + "px; " + $parent.data("style"));
	        }
	        if (properties["scaleX"] == undefined) properties["scaleX"] = 1;
	        if (properties["scaleY"] == undefined) properties["scaleY"] = 1;
	        if (properties["scaleZ"] == undefined) properties["scaleZ"] = 1;
	        if (properties["scale"] != undefined) {
	          properties["scaleX"] *= properties["scale"];
	          properties["scaleY"] *= properties["scale"];
	          properties["scaleZ"] *= properties["scale"];
	        }
	        var translate3d = "translate3d(" + (properties["x"] ? properties["x"] : 0) + "px, " + (properties["y"] ? properties["y"] : 0) + "px, " + (properties["z"] ? properties["z"] : 0) + "px)";
	        var rotate3d = "rotateX(" + (properties["rotateX"] ? properties["rotateX"] : 0) + "deg) rotateY(" + (properties["rotateY"] ? properties["rotateY"] : 0) + "deg) rotateZ(" + (properties["rotateZ"] ? properties["rotateZ"] : 0) + "deg)";
	        var scale3d = "scaleX(" + properties["scaleX"] + ") scaleY(" + properties["scaleY"] + ") scaleZ(" + properties["scaleZ"] + ")";
	        var cssTransform = translate3d + " " + rotate3d + " " + scale3d + ";";
	        this._log(cssTransform);
	        $el.attr("style", "transform:" + cssTransform + " -webkit-transform:" + cssTransform + " " + style);
	      }
	    }, this));
	    if (window.requestAnimationFrame) {
	      window.requestAnimationFrame($.proxy(this._onScroll, this, false));
	    } else {
	      this._requestAnimationFrame($.proxy(this._onScroll, this, false));
	    }
	  }
	}

})(jQuery);

;(function ($) {
/**
 *
 * jquery.binarytransport.js
 *
 * @description. jQuery ajax transport for making binary data type requests.
 * @version 1.0 
 * @author Henry Algus <henryalgus@gmail.com>
 *
 */
 
// use this transport for "binary" data type
$.ajaxTransport("+binary", function(options, originalOptions, jqXHR){
    // check for conditions and support for blob / arraybuffer response type
    if (window.FormData && ((options.dataType && (options.dataType == 'binary')) || (options.data && ((window.ArrayBuffer && options.data instanceof ArrayBuffer) || (window.Blob && options.data instanceof Blob)))))
    {
        return {
            // create new XMLHttpRequest
            send: function(headers, callback){
		// setup all variables
                var xhr = new XMLHttpRequest(),
		url = options.url,
		type = options.type,
		async = options.async || true,
		// blob or arraybuffer. Default is blob
		dataType = options.responseType || "blob",
		data = options.data || null,
		username = options.username || null,
		password = options.password || null;
					
                xhr.addEventListener('load', function(){
			var data = {};
			data[options.dataType] = xhr.response;
			// make callback and send data
			callback(xhr.status, xhr.statusText, data, xhr.getAllResponseHeaders());
                });
 
                xhr.open(type, url, async, username, password);
				
		// setup custom headers
		for (var i in headers ) {
			xhr.setRequestHeader(i, headers[i] );
		}
				
                xhr.responseType = dataType;
                xhr.send(data);
            },
            abort: function(){
                jqXHR.abort();
            }
        };
    }
});
})(jQuery);


/**
     * Copyright 2012, Digital Fusion
     * Licensed under the MIT license.
     * http://teamdf.com/jquery-plugins/license/
     * https://github.com/customd/jquery-visible
     *
     * @author Sam Sehnert
     * @desc A small plugin that checks whether elements are within
     *       the user visible viewport of a web browser.
     *       only accounts for vertical position, not horizontal.
     */
!function(t){var i=t(window);t.fn.visible=function(t,e,o){if(!(this.length<1)){var r=this.length>1?this.eq(0):this,n=r.get(0),f=i.width(),h=i.height(),o=o?o:"both",l=e===!0?n.offsetWidth*n.offsetHeight:!0;if("function"==typeof n.getBoundingClientRect){var g=n.getBoundingClientRect(),u=g.top>=0&&g.top<h,s=g.bottom>0&&g.bottom<=h,c=g.left>=0&&g.left<f,a=g.right>0&&g.right<=f,v=t?u||s:u&&s,b=t?c||a:c&&a;if("both"===o)return l&&v&&b;if("vertical"===o)return l&&v;if("horizontal"===o)return l&&b}else{var d=i.scrollTop(),p=d+h,w=i.scrollLeft(),m=w+f,y=r.offset(),z=y.top,B=z+r.height(),C=y.left,R=C+r.width(),j=t===!0?B:z,q=t===!0?z:B,H=t===!0?R:C,L=t===!0?C:R;if("both"===o)return!!l&&p>=q&&j>=d&&m>=L&&H>=w;if("vertical"===o)return!!l&&p>=q&&j>=d;if("horizontal"===o)return!!l&&m>=L&&H>=w}}}}(jQuery);