=== veeeb|s veeebeditor For Wordpress ===
Contributors: Christoph Diefenthal, Jan Strohhecker
Tags: semantic, veeeb, opencalais, editor, search, images, media
Requires at least: 3.1
Tested up to: 3.3.1
Stable tag: 2.2.1

This plugin extends the default Wordpress editor with <a href="http://www.veeeb.com/">veeeb semantic editor</a>.

== Description ==

This plugin extends the default Wordpress editor with <a href="http://www.veeeb.com/">veeeb semantic editor</a>.

*veeeb semantic editor* makes it possible to analzye your text semantically for the most important concepts (via opencalais) and search different channels with it.

Features:

* write (HTML) text in the editor
* get the most important concepts - analyzed by opencalais
* view easily retrieved freebase information about the concepts 
* search channels like google images, flickr, youtube, gettyimages (and more to come) for media to embed in your blog article
* drag and drop the media into your article
* and more :)


Learn more about [veeeb](http://www.veeeb.com).


Further Requirements:

* Flash Player 10.0


== Installation ==

1. Upload this plugin to the `/wp-content/plugins/` directory. 
2. Activate the plugin through the 'Plugins' menu in WordPress. 


== Frequently Asked Questions ==

= How can i enable Google Maps =

To use this feature in your blog you have to get a Google Maps API Key for the domain you are running your blog on. <a href="http://code.google.com/apis/maps/signup.html">Follow to signup</a>.
After you acquired the API key you have to uncomment the line 144 in the file *veeebs_veeebeditor_class.php* and replace "YOURAPIKEY" with your actual key.


= Where can I get further information and support =

Check out our <a href="http://www.veeeb.com/blog/">blog</a> for more information or give us feeedback at our <a href="http://veeeb.uservoice.com">uservoice forum</a>. 


== Screenshots ==

1. Your text gets analyzed on the fly and you can view information about the topcis.
2. Drag images and videos from the bag into your text.
3. All extracted topics from the text can be accessed here.
4. Search multiple repositories at once. Store the images for later in the bag.
5. View details about an image or video.
6. View the image or video in fullscreen.
7. New Detailview for topics

== Changelog ==

= 2.2.1 =

* Changed the semantic extraction provider to Ontonaut. Find more Information on Ontonaut.net.

= 2.1.1 =

* Minor bugfixes
* A few style changes
* Added Google Maps to the FAQs  

= 2.1.0 =

* Detailpage for the extracted topics
* Add-to-bag button on images

= 2.0.3 =

* Made some Bugfixes to the extraction interval

= 2.0.2 =

* Added Wikipedia Plugin
* Update for WP Version 3.1

= 2.0.1 =

* some bugfixs
* you can select text and search for media

= 2.0.0 =

* completly new user interface
* easier to use
* better workflow
* better performance

= 1.0.14 =
* added plugin to search Dreamstime.com
* added plugin to search Amazon.com
* drag products from Amazon as link into your text
* the editor is now shown as an overlay. The advantage is that you can use your complete screen and you can switch between editors without having to reload the veeeb editor.

= 1.0.13 =
* added Google News plugin
* added Google Web Search plugin
* you can now create links from a selected word.
* you can drag & drop a search result from Google as a link into your text

= 1.0.12 =
* added plugin to search the Wordpress Media Library

= 1.0.11 =
* important bugfix for MSMV-473: on some computers, the editor could not be loaded because of the Error "TypeError: Error #1009: Der Zugriff auf eine Eigenschaft oder eine Methode eines null-Objektverweises ist nicht möglich. at de.veeeb.core.misc::Preloader/get systemManager()"


= 1.0.10 =
* added the <a href="http://www.fotolia.com/">fotolia</a> image search plugin
* minor bugfixes

= 1.0.09 =
* immediate bugfix. please update.

= 1.0.08 =
* first public release


