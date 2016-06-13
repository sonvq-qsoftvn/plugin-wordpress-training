(function() {  
    tinymce.create('tinymce.plugins.d_shortcode', {  
        init : function(ed, url) {
            ed.addButton('d_shortcode', {  
                title : 'D shortcodes',  
                image : url+'/d-shortcodes-icon.png',
                cmd: 'd_shortcode'
            });
            ed.addCommand('d_shortcode', function() {
				ed.windowManager.open({
					file : url + '/d-shortcodes-display.php',
					width : 550 + ed.getLang('d_shortcode.delta_width', 0),
					height : 600 + ed.getLang('d_shortcode.delta_height', 0),
					inline : 1
				}, {
					plugin_url : url
				});
			});
        },  
        createControl : function(n, cm) {  
            return null;  
        },
        getInfo : function() {
            return {
                longname : 'D shortcodes',
                author : 'Deeds',
                version : "0.1"
            };
        }
    });  
    tinymce.PluginManager.add('d_shortcode', tinymce.plugins.d_shortcode);  
})();  