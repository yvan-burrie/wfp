/**
 * Custom posts scripts for sortable admin page
 *
 * @author Rascals Themes
 * @category JavaScripts
 * @package Toolkit Core
 * @version 1.0.1
 */

jQuery(document).ready(function(c){var b=c("#sortable-posts");var a=c("#loading-animation").attr("alt");b.sortable({handle:c(".drag-item"),update:function(d,e){c("#loading-animation").show();
opts={url:ajaxurl,type:"POST",async:true,cache:false,data:{action:a,order:b.sortable("toArray").toString()},success:function(f){c("#loading-animation").hide();
return;},error:function(g,h,f){alert("There was an error saving the updates");c("#loading-animation").hide();return;}};c.ajax(opts);}});});