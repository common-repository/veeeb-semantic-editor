<?php

require_once(dirname(__FILE__).'/../../../wp-config.php');
class veeebs_veeebeditor {
    var $version = '2.2.1';
    var $default_options = array();
	var $options = array();
	var $veeebeditor_path = "";
	var $plugin_path ="";
	

    function veeebs_veeebeditor()
	{
		$this->__construct();
	}

	function __construct() 
    {
		$siteurl = trailingslashit(get_option('siteurl'));
		$this->plugin_path =  $siteurl .'wp-content/plugins/' . basename(dirname(__FILE__)) .'/';
		$this->veeebeditor_path = $siteurl .'wp-content/plugins/' . basename(dirname(__FILE__)) .'/ckeditor/';
    }

	function deactivate()
	{
		global $current_user;
		update_user_option($current_user->id, 'rich_editing', 'true', true);
	}

	function activate()
	{
		global $current_user;
		update_user_option($current_user->id, 'rich_editing', 'true', true);		
	}

    function add_admin_head()
    {
    ?>
		<style>
		</style>
	<?php
    }

	function _load_script($textarea_id)
	{	
		global $current_user; 		
		
		?>
		<style>
		a#edButtonVeeeb{
				background-color:#F1F1F1;
				border-color:#DFDFDF;
				color:#999999;
				-moz-border-radius:3px 3px 0 0;
				border-style:solid;
				border-width:1px;
				cursor:pointer;
				float:right;
				height:18px;
				margin:5px 5px 0 0;
				padding:4px 5px 2px;
		}
		</style>
		<script type="text/javascript" src="<?php echo $this->plugin_path; ?>js/jquery.externalinterface.js"></script>
		<script type="text/javascript" src="<?php echo $this->plugin_path; ?>js/swfobject.js"></script>
		<script type="text/javascript" src="<?php echo $this->plugin_path; ?>js/swfaddress.js"></script>
        <script type="text/javascript">
            
			String.prototype.startsWith = function(str) {return (this.match("^"+str)==str)};

			//This Object stores the info if the editor is already open
			window.VEEEB = {
					instance: null
					};
			
			var vEditorLink =   '<a onclick="activateVeeebEditor(true);" class="hide-if-no-js wp-switch-editor" id="edButtonVeeeb">veeeb</a>';
			
			// add veeeb-toolbar-button (css added by id)
			jQuery("a[id='content-tmce']").after(vEditorLink);

			
			// deactivate veeeb on startup
//			activateVeeebEditor(false);
			
			var debug;
			// add this debug-textarea if needed:
			//jQuery("div[id='titlediv']").before('<textarea id="debug" width="500" height="100" cols="200" rows="8">debug</textarea>');
			
			// *********************
			// ****** INIT END *****
			// *********************
			
			function d(msg){
				if (jQuery("textarea[id='debug']").length){
					// if debug area available
					debug += msg + "\r";
					jQuery("textarea[id='debug']").val(debug);
				}
			}
			
			var  inactivateVeeebEditor = function (){
				activateVeeebEditor(false);
			};
			
			function closeEditor(){
				activateVeeebEditor(false);
			}
			
			function activateVeeebEditor(visib){
				if(visib)
				{
					//***** activate veeeb-editor/inactivate classic editors
					
					// always switch to classic-html-editor first (needed at least for inserting text via veeeb-export)
					switchEditors.go('content', 'html');					
				
					if(VEEEB.instance == null) //insert the editor swf
					{
						// create the container that holds the swf and a messag in case Flash is not installed.
						var vEditor =  '<div id="veeebEditorDiv" style="background-color: #55544F;padding: 0px; text-align:right;position:fixed; width:100%; height:100%; top:0px; left:0px;z-index:2000;"> ' +
								'			<div style="position: absolute;left: 0px; right: 0px; bottom: 34px; top: 0px;"><div id="veeebeditorswf">' +
								'				<p style="color: #efefef; text-align: center"> '	+ 
								'					To view this page ensure that Adobe Flash Player version ' + 
								'					10.0 or greater is installed. ' +
								' 					<a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a>' +
								'				</p> ' +
								'				<div id="videoclose" style="color:#efefef;cursor: pointer;text-align: center;" onclick="activateVeeebEditor(false)">close this window <img title="close" src="<?php echo $this->plugin_path; ?>_images/close.png" /></div>' +
								'			</div></div>' +
								'			<div id="veeebEditorDivFooter" style="width: 1000px; color: #efefef; position: absolute; left: 50%; margin-left: -500px; right: 5px; bottom: 5px;background-color: #55544F;">Software by <a href="http://www.veeeb.com" target="_blank"><img id="veeebLogo" style="position: relative;bottom: -6px;" src="<?php echo $this->plugin_path; ?>_images/veeeb-orange-weiss.png" /></a>, powered by <a href="http://www.ontonaut.net" target="_blank"><img border="0" src="http://www.veeeb.com/ex/onto/onto-favicon-dark.png" title="Ontonaut"/></a> <a href="http://freebase.com" target="_blank"><img border="0" src="http://www.veeeb.com/ex/fb/freebase-icon-dark.png?temp=123354" title="Freebase"/></a>' +
								'         </div>  ' +
								'		</div>';
						
						// add the veeeb-editor-div to the body
						jQuery("body").append(vEditor);
						
						var swfVersionStr = "10.0.0";
			            <!-- To use express install, set to playerProductInstall.swf, otherwise the empty string. -->
			            var xiSwfUrlStr = "<?php echo $this->plugin_path; ?>playerProductInstall.swf";
			            var flashvars = {};
						flashvars.showSaveButton = "false";
						flashvars.serverName   = "<?php echo get_bloginfo('wpurl'); ?>";
						flashvars.extractorType   = "extractorAttensity"; //valid Types are: extractorAlchemy, extractorAttensity, extractorOpenCalais  
						flashvars.lang = "<?php echo WPLANG ?>";
						//flashvars.googleMapsApiKey = "YOURAPIKEY";
			            var params = {};
			            params.quality = "high";
			            params.bgcolor = "#55544F";
			            params.allowscriptaccess = "sameDomain";
			            params.allowfullscreen = "true";
			            var attributes = {};
			            attributes.id = "veeebeditor";
			            attributes.name = "veeebeditor";
			            attributes.align = "middle";
			            swfobject.embedSWF(
			                "<?php echo $this->plugin_path; ?>veeebWordpressEditor.swf?version=<?php echo $this->version; ?>", "veeebeditorswf", 
			                "100%", "100%", 
			                swfVersionStr, xiSwfUrlStr, 
			                flashvars, params, attributes);

		                VEEEB.instance = "on";
					}
					else //refresh text if editor is already created
					{
						jQuery("#veeebeditor").externalInterface({method:'refreshText'});
					}

					//extend the container over the hole page
					jQuery("#veeebEditorDiv").css("left", "0px");
					jQuery("#veeebEditorDiv").css("top", "0px");
					jQuery("#veeebEditorDiv").css("width", "100%");
					jQuery("#veeebEditorDiv").css("height", "100%");
				}
				else
				{
					//***** deactivate veeeb-editor/reactivate classic editors
					switchEditors.go('content', 'html');
					
					// hide veeeb-editor-div
					//move the editor out of sight
					jQuery("#veeebEditorDiv").css("left", "-1000px");
					jQuery("#veeebEditorDiv").css("width", "400px");
					jQuery("#veeebEditorDiv").css("height", "400px");
				}
			
			}
			
			var cnt = 0;
			var currentContent = "";
			
			/**
			 * will be used by veeebeditor
			 *
			 * return the text which is current in the 'classic editor'
			 * 
			 */
			function getText(){
				
				var visualOpen = false;
				
				currentContent = jQuery("textarea[id='content']").val();
				returnV = currentContent;
					
				return returnV;
			}
			
			function getArticleId()
			{
				//input field with id post_Id has no valid value when creating a new post.
				//after the autosave the name changes from temp_ID to post_ID and the value
				//is a valid post id.
				return jQuery("input[name='post_ID']").val();
			}
			
			function getUsername()
			{
				return '<?php echo $current_user->user_login; ?>';
			}
			
			function getContext()
			{
				return 'veeebSE-wordpress-<?php echo get_bloginfo(); ?>';
			}
			
			/*
			 * for debugging
			 */
			function addText(content){
				var txt = getText();
				txt += "\r";
				txt += content;
				setText(txt);
			}
			
			/**
			 * will be used by veeebeditor
			 *
			 * set the text in the 'classic editor'
			 * 
			 */
			function setText(content)
			{
				// veeeb always switches 
				jQuery("textarea[id='content']").val(content);
			}

			function setTags(tags)
			{
				if(tags && tags != "")
				{
					jQuery(".taghint").css("display", "none");
					jQuery("input[id='new-tag-post_tag']").val(tags);	
				}			
			}
            
        </script>
		
		<?PHP
	}

	function load_veeebeditor()
	{
		$this->_load_script('content');
	}

}

$veeebs_veeebeditor = new veeebs_veeebeditor();
?>