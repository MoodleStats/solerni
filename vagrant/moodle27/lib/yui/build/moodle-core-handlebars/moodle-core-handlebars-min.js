YUI.add("moodle-core-handlebars",function(e,t){e.Handlebars.registerHelper("get_string",function(){var t=new e.Array(arguments);return t.pop(),t.push(arguments[arguments.length-1].hash),M.util.get_string.apply(this,t)}),e.Handlebars.registerHelper("image_url",function(){var t=new e.Array(arguments);return t.pop(),M.util.image_url.apply(this,t)})},"@VERSION@");
