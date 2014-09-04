=== MU Central Taxonomies ===
Contributors: marcus.downing
Tags: multisite, custom, taxonomies
Requires at least: 3.1
Tested up to: 3.9.1
Stable tag: trunk

On a multisite network, this makes a child site use the main site's categories and taxonomies instead of its own.

== Description ==

Sometimes you want the different sites on a multisite network to share their taxonomies.
This plugin forces a child site to use its parent's taxonomies instead of its own.

== Installation ==

1. Upload the `mu-central-taxonomies` folder to the `/wp-content/plugins/` directory.
1. **Either** activate the plugin on each child site's Plugins panel, **or** activate it across the whole site using the Network Admin's Plugins panel.
1. Edit pages and posts as you normally would.

== Frequently Asked Questions ==

= Why do I want this? =

If you're using multisite to separate out parts of a website that still have some connection to each other,
then you may want to use the same tags, categories and other taxonomies across them all.

= Where is the data stored? =

In the taxonomy tables for the *parent* site of the network.

= Can I use this for some child sites and not others? =

Yes. Activate the plugin on each child site that you wish to use it for.
In this case, do not activate the plugin across the whole network.

= Can I use this for some taxonomies and not others? =

No, it's all or nothing.

= Can I use this with my custom taxonomy? =

Yes.

= Is this compatible with other plugins that affect taxonomies? =

In most cases, yes.
