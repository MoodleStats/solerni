YUI.add("moodle-mod_mediagallery-mediabox",function(e,t){var n=function(){n.superclass.constructor.apply(this,arguments)};e.extend(n,e.Base,{initializer:function(t){this.enable(),this.build(),this._sidebarwidth=300,this._navbarheight=60,this.currentitem=null,this._audiowidth=250,this._audioheight=275,this._videowidth=640,this._videoheight=390,this._fullscreenavail=screenfull.enabled&&!e.one("body").hasClass("ui-mobile-viewport"),this._loadingimage=e.Node.create("<img/>").setAttribute("src",M.util.image_url("loading","mod_mediagallery"))},build:function(){var t=this,n=M.str.moodle.next,r=M.str.moodle.previous,i=M.util.get_string("download","mod_mediagallery"),s=M.str.mod_mediagallery.togglesidebar,o=M.str.mod_mediagallery.togglefullscreen,u=M.str.mod_mediagallery.close,a='<img class="sidebartoggle" src="'+M.util.image_url("toggle","mod_mediagallery")+'" title="'+s+'" alt="'+s+'"/>';a+='<img class="prev" src="'+M.util.image_url("left","mod_mediagallery")+'" title="'+r+'" alt="'+r+'"/>',a+='<img class="next" src="'+M.util.image_url("right","mod_mediagallery")+'" title="'+n+'" alt="'+n+'"/>',a+='<img class="open" src="'+M.util.image_url("download","mod_mediagallery")+'" title="'+i+'" alt="'+i+'"/>',this._fullscreenavail&&(a+='<img class="fullscreen" src="'+M.util.image_url("fullscreen","mod_mediagallery")+'" title="'+o+'" alt="'+o+'"/>'),a+='<img class="mbclose" src="'+M.util.image_url("close","mod_mediagallery")+'" title="'+u+'" alt="'+u+'"/>';var f='<div id="mediabox"><div id="mediabox-content-wrap"><div id="mediabox-content"></div></div>';f+='<div id="mediabox-sidebar">',f+='<div id="mediabox-metainfo"></div><hr/><div id="mediabox-social"></div><hr/><div id="mediabox-comments"></div>',f+="</div>",f+='<div id="mediabox-sidebar-actions">'+a+"</div>",f+='<div id="mediabox-navbar"><div id="mediabox-navbar-container"></div></div></div>',f+='<div id="mediabox-overlay"></div>',e.Node.create(f).appendTo("body"),this.overlay=e.one("#mediabox-overlay"),this.mediabox=e.one("#mediabox"),this.navbar=e.one("#mediabox-navbar"),this.resizeoverlay(),this.album=e.all("a[rel^=mediabox], area[rel^=mediabox], a[data-mediabox], area[data-mediabox]").getDOMNodes(),this.overlay.on("click",function(){t.stop()}),e.delegate("click",function(e){if(e.currentTarget.get("id")==="mediabox-navbar-container")return!1;t.stop()},"#mediabox","#mediabox-navbar, #mediabox-navbar-container");var l=e.one("#mediabox-sidebar");e.one("#mediabox-sidebar-actions .sidebartoggle").on("click",function(){t.mediabox.toggleClass("sidebarhidden"),t.resizeoverlay(),t.repositionitem()});for(var c=0;c<this.album.length;c++){var h=e.Node.create('<div class="navitem"></div>');h.setAttribute("data-id",c);var p=e.Node.create("<img/>");p.setAttribute("src",this.album[c].children[0].getAttribute("src")),p.appendTo(h),h.appendTo("#mediabox-navbar-container")}e.delegate("click",function(e){e.preventDefault(),t.changeitem(e.currentTarget.getAttribute("data-id"))},"#mediabox-navbar",".navitem"),this.get("enablelikes")&&e.Node.create('<a class="like" href="#"><div class="like"></div>'+M.str.mod_mediagallery.like+'</a><span id="mediabox-likedby"></span>').appendTo("#mediabox-social"),e.delegate("click",function(n){n.preventDefault();var r="like",i=1,s="unlike",o='<div class="unlike"></div>';e.one("#mediabox-social a.like div").hasClass("unlike")&&(r="unlike",i=0,s="like",o='<div class="like"></div>');var u=t.get("metainfodata");u.id=t.album[t.currentitemindex].getAttribute(t.get("dataidfield")),u.action=r;var a={method:"POST",data:u,on:{success:function(e,n){var r=JSON.parse(n.responseText);t.update_likes(r.likes,i)}},context:this,sync:!0};e.io(t.get("metainfouri"),a),e.one("#mediabox-social a.like").setHTML(o+M.str.mod_mediagallery[s])},"#mediabox","#mediabox-social a.like"),e.delegate("blur",function(e){t.enablenav()},"#mediabox","#mediabox-comments textarea"),e.delegate("focus",function(e){t.disablenav()},"#mediabox","#mediabox-comments textarea"),e.one("#mediabox-sidebar-actions .prev").on("click",function(){return t.currentitemindex===0?t.changeitem(t.album.length-1):t.changeitem(t.currentitemindex-1),!1}),e.one("#mediabox-sidebar-actions .next").on("click",function(){return t.currentitemindex===t.album.length-1?t.changeitem(0):t.changeitem(t.currentitemindex+1),!1}),e.one("#mediabox-sidebar-actions .open").on("click",function(){return window.open(t.album[t.currentitemindex].getAttribute("data-url")+"?forcedownload=1","_blank"),!1}),e.one("#mediabox-sidebar-actions .mbclose").on("click",function(){return t.stop(),!1}),this._fullscreenavail&&e.one("#mediabox-sidebar-actions .fullscreen").on("click",function(){return screenfull.toggle(t.mediabox.getDOMNode()),t.setfullscreenimg(),!1}),this.setup_info_toggle()},changeitem:function(t){if(this.currentitemindex===t)return;var n=this,r=e.one("#mediabox-content"),i=this.album[t].getAttribute("data-player"),s=this.album[t].getAttribute("data-type"),o=this.album[t].getAttribute("data-objectid");r.empty();var u=null;(u=this.navbar.one(".navitem.current"))&&u.removeClass("current"),this.navbar.one('.navitem[data-id="'+t+'"]').addClass("current");var a=new Image;i!=="2"&&s!=="youtube"&&(r.prepend(this._loadingimage),n.repositionitem(a.width,a.height),a.onload=function(){var i=e.Node.create("<img/>");i.setAttribute("src",n.album[t].getAttribute("href")),r.all("img").remove(),r.prepend(i),n.repositionitem(a.width,a.height)},a.src=this.album[t].getAttribute("href")),this.currentitemindex=parseInt(t),this.currentitem=this.album[t];var f=e.one("#mediabox-metainfo");f.empty();var l=this.get("metainfodata");l.id=this.currentitem.getAttribute(this.get("dataidfield")),l.action="metainfo";var c={method:"GET",data:l,on:{success:function(r,i){var s;try{s=JSON.parse(i.responseText)}catch(o){return}for(var u=0;u<s.fields.length;u++){if(s.fields[u].value==="")continue;e.Node.create('<div class="metafield '+s.fields[u].name+'"></div>').append('<div class="metaname">'+s.fields[u].displayname+"</div>").append('<div class="metavalue">'+
s.fields[u].value+"</div>").appendTo(f)}if(s.commentcontrol){e.one("#mediabox-comments").setHTML(s.commentcontrol);var a={client_id:s.client_id,contextid:s.contextid,itemid:this.album[t].getAttribute(this.get("dataidfield")),component:"mod_mediagallery",commentarea:"item",autostart:!0};M.core_comment.init(e,a)}if(n.get("enablelikes")){var l='<div class="like"></div>';s.likedbyme?(l='<div class="unlike"></div>',e.one("#mediabox-social a.like").setHTML(l+M.str.mod_mediagallery.unlike)):e.one("#mediabox-social a.like").setHTML(l+M.str.mod_mediagallery.like),this.update_likes(s.likes,s.likedbyme)}}},context:this,sync:!0};this.get("metainfouri")!==""&&e.io(this.get("metainfouri"),c);if(i==="0"||i==="2")this.embed_player(l.id),i==="0"?r.one("span.mediaplugin").addClass("audio"):r.one("span.mediaplugin").addClass("video");this.currentitem.getAttribute("data-type")==="youtube"&&(r.empty(),e.Node.create('<iframe id="mediabox-youtube" type="text/html" width="'+this._videowidth+'" height="'+this._videoheight+'" src="'+this.currentitem.getAttribute("data-url")+'" frameborder="0">').appendTo(r),this.repositionitem())},disablenav:function(){this.keyboardnav.detach()},embed_player:function(t){var n=this.get("metainfodata");n.id=t,n.action="embed";var r={method:"GET",data:n,on:{success:function(t,n){var r=JSON.parse(n.responseText);e.one("#mediabox-content").setHTML(r.html),r.type==="audio"?M.util.add_audio_player(r.id,r.url,!1):r.objectid==""&&M.util.add_video_player(r.id,r.url,!1),M.mod_mediagallery.base.load_flowplayer();if(r.type==="video"){var i=e.one("#mediabox-content .mediaplugin");r.flow?(i.addClass("flow"),this.repositionitem(this._videowidth,this._videoheight)):this.repositionitem(i.get("offsetWidth"),i.get("offsetHeight"))}}},context:this,sync:!0};e.io(this.get("metainfouri"),r)},enable:function(){var t=this;return e.one("body").all("a[rel^=mediabox], area[rel^=mediabox], a[data-mediabox], area[data-mediabox]").on("click",function(n){return n.preventDefault(),t.start(e.one(n.currentTarget)),!1})},enablenav:function(){var t=this;this.keyboardnav=e.one(document).on("keyup",function(e){t.keyboardaction(e)})},keyboardaction:function(e){var t,n,r,i,s;t=27,n=37,r=39,s=event.keyCode,i=String.fromCharCode(s).toLowerCase(),s===t||i.match(/x|o|c/)?this.stop():i==="p"||s===n?this.currentitemindex!==0&&this.changeitem(this.currentitemindex-1):(i==="n"||s===r)&&this.currentitemindex!==this.album.length-1&&this.changeitem(this.currentitemindex+1)},repositionitem:function(t,n){var r,i,s,o,u=e.one("#mediabox-content"),a=u.get("children").get(0)[0],f=1,l="";this.currentitem!==null&&(f=this.currentitem.getAttribute("data-player"),l=this.currentitem.getAttribute("data-type")),f==="2"||l==="youtube"?u.one(".mediaplugin.flow")?(t=this._videowidth,n=this._videoheight):(t=a.get("offsetWidth"),n=a.get("offsetHeight")):f==="0"?(t=this._audiowidth,n=this._audioheight):t===undefined&&(t=a.get("naturalWidth"),n=a.get("naturalHeight"));var c=e.one("body").get("winWidth"),h=e.one("body").get("winHeight"),p=c-this.sidebarwidth(),d=h-this._navbarheight,s="",o="";t>p||n>d?(t/p>n/d?(s=p,o=parseInt(n/(t/p),10),i=0,r=(h-o)/2):(o=d,s=parseInt(t/(n/d),10),r=0,i=(c-s-this.sidebarwidth())/2),s+="px",o+="px"):(i=(c-t-this.sidebarwidth())/2,r=(h-n-this._navbarheight)/2),a.setStyle("width",s),a.setStyle("height",o),f==="0"&&u.one(".mediaplugin object")&&u.one(".mediaplugin object").setStyle("width",s),u.setStyle("top",r+"px"),u.setStyle("left",i+"px")},resizeoverlay:function(){var t=e.one("body").get("docWidth"),n=e.one("body").get("docHeight");this.overlay.setStyle("width",t),this.overlay.setStyle("height",n)},sidebarwidth:function(){return this.mediabox.hasClass("sidebarhidden")?0:this._sidebarwidth},start:function(t){var n=this;e.on("windowresize",function(){n.resizeoverlay(),n.repositionitem()}),e.one("body").addClass("noscroll mediaboxactive"),this.overlay.setStyle("display","block"),this.mediabox.setStyle("display","block");var r=0;for(var i=0;i<this.album.length;i++)this.album[i].getAttribute("href")===t.getAttribute("href")&&(r=i);this.currentitemindex!==r&&e.one("#mediabox-content").empty(),this.setfullscreenimg(),this.changeitem(r),this.enablenav()},setfullscreenimg:function(){if(!e.one("#mediabox-sidebar-actions .fullscreen"))return;var t=M.util.image_url("fullscreen","mod_mediagallery");screenfull.isFullscreen&&(t=M.util.image_url("fullscreenexit","mod_mediagallery")),e.one("#mediabox-sidebar-actions .fullscreen").setAttribute("src",t)},setup_info_toggle:function(){var t=M.util.get_string("mediainformation","mod_mediagallery"),n=M.util.image_url("t/collapsed","moodle"),r=M.util.image_url("t/expanded","moodle"),i=e.Node.create('<img title="'+t+'"/>');i.setAttribute("src",n);var s=e.Node.create('<a href="#" class="toggle">'+t+"</a>");s.prepend(i);var o=e.Node.create('<div class="metainfo-toggle"></div>');o.prepend(s),e.one("#mediabox-sidebar").insertBefore(o,e.one("#mediabox-metainfo"));var u=e.one("#mediabox-metainfo");u.toggleView(),e.delegate("click",function(e){e.preventDefault();var t=u.getAttribute("hidden")==="hidden";t?i.setAttribute("src",r):i.setAttribute("src",n),u.toggleView()},"#mediabox","#mediabox-sidebar .metainfo-toggle a.toggle")},stop:function(){screenfull.isFullscreen&&screenfull.exit(),this.disablenav(),e.one("body").removeClass("noscroll mediaboxactive"),this.overlay.setStyle("display",""),this.mediabox.setStyle("display","")},update_likes:function(t,n){var r="";t>0&&(r="&nbsp;&bull;&nbsp;",r+=M.str.mod_mediagallery.likedby+": ",n&&(t-=1,r+=M.str.mod_mediagallery.you+", "),r+=t+" ",t!==1?r+=M.str.mod_mediagallery.others:r+=M.str.mod_mediagallery.other),e.one("#mediabox-likedby").setHTML(r)}},{NAME:"moodle-mod_mediagallery-mediabox",ATTRS:{enablecomments:{value:!0,validator:function(t){return e.Lang.isBoolean(t)}},enablelikes:{value:!0,validator:function(t){return e.Lang.isBoolean(t)}},metainfouri:{value:"",validator:function(t){return e.Lang.isString(t)}},dataidfield:{value:"data-id",validator:function(
t){return e.Lang.isString(t)}},metainfodata:{value:{},validator:function(t){return e.Lang.isObject(t)}}}}),M.mod_mediagallery=M.mod_mediagallery||{},M.mod_mediagallery.init_mediabox=function(e){return new n(e)}},"@VERSION@",{requires:["base","node","selector-css3"]});
