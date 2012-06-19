<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<h2>Changelog</h2>
<hr/>
<pre>
This is a non-exhaustive changelog for Community ACL component (starting from ver. 1.0.8)
<strong>Legend:</strong>   # -> Bug Fix
   + -> Addition
   ^ -> Change
   - -> Removed
   ! -> Note---------------- 1.3.19 Released -- [ 07/19/2012]----------# Addition	: Added cACL user table cleanup on user deletion. -BUR 07/19/2012---------------- 1.3.17 Released -- [ 11/09/2011]----------# Bug Fix	: Fixed issue where restricting back-end users wouldn't have access to an article if a restricted section with the same ID was denied. -BUR 11/09/2011---------------- 1.3.16 Released -- [ 8/19/2011]----------# Bug Fix	: Corrected cacl_preprocessor for back-end menus---------------- 1.3.15 Released -- [ 8/8/2011]----------^ Change	: Changed helper.php to use static for older PHP versions.# Bug Fix	: Corrected CSS on user manage screen where contact information overlaps cACL details. —BUR 7/26/2011+ Addition  : Added backend menu restrictions using libtidy for rt_missioncontrol_j15 —BUR 8/8/2011---------------- 1.3.14 Released -- [ ]----------# Bug Fix	: Single article restriction in functions would not build the proper category and section drop downs on edit article pages. —BUR 6/14/2011# Bug Fix	: Correct yoo_studio_5.5.3 regex. —BUR 6/14/2011---------------- 1.3.13 Released -- [3-Jun-2011]----------# Bug Fix	: Incorrect logic deciding on whether or not to remove modules. —BUR---------------- 1.3.12 Released -- [28-Mar-2011]----------- Removed	: Removed non working user email on new content button in users.+ Addition	: Added the ability to run cACL plug-in's only on front-end or back-end of your site 03/28/2011 -BUR# Bug Fix	: Not really a bug, just initialized some variables in jomsocial plugin. 03/27/2011 -BUR# Bug Fix	: When not using libTidy, regular expressions were not getting preg_quoted properly. This would cause blank pages when menu names contained a forward slash. 3/29/2011 -BUR---------------- 1.3.11 Released -- [18-Feb-2011]----------+ Addition	: Check for community builder version on install so correct SQL will get executed. 01/18/2011 -BUR# Bug Fix	: Corrected 'Add' button on the Function Forbidden Actions for components page. 2/18/2011 -BUR---------------- 1.3.10 Released -- [26-Jan-2011]----------+ Addition	: Added Support for DOCman plug-in 01/18/2011 -BUR---------------- 1.3.9 Released -- [6-Jan-2011]----------# Bug Fix	: Remove all button on function management is now working correctly 12/21/2010 -BUR^ Change	: Change sort order on groups, roles, and functions list. Lists are now sorted by name. 12/21/2010 -BUR- Removed	: Removed sort column on roles list 12/21/2010 -BUR+ Addition	: Added menu support for yoo_enterprise 01/03/2011 -ARP+ Addition  : Added preserve-entities to libtidy to correct &nbsp; issue. 01/06/2011 -BUR---------------- 1.3.8 Released -- [10-Dec-2010]----------# Bug Fix	: Add Article was receiving the wrong HTML on the category drop-down 12/10/2010 -BUR---------------- 1.3.7 Released -- [1-Dec-2010]----------# Bug Fix	: Front-end menu's not being restricted when not using libTidy 12/01/2010 -BUR---------------- 1.3.6 Released -- [23-Nov-2010]----------# Bug Fix	: Clear All button in IE would not remove items properly in back-end 11/22/2010 -BUR---------------- 1.3.5 Released -- [29-Oct-2010]----------# Bug Fix	: Do not remove menu's for gcalendar jsonfeed requests -BUR# Bug Fix	: Make Article Manager show proper section and category dropdowns -BUR# Bug Fix	: Pagination feature in Remove Users under Groups and Roles is now functioning properly 10/22/2010 -BUR+ Addition	: Added a on/off button for libtidy 10/29/2010 -BUR---------------- 1.3.4 Released -- [6-Oct-2010]----------+ Addition	: Added Menu support for yoo_studio template 8/31/2010 -BUR+ Change	: Changed the regex for meta description in article submission to allow for other languages 9/1/2010 -BUR# Bug Fix	: Query inserting community builder registrations 9/29/2010 -BUR+ Addition	: Added the ability to use libtidy for menu item removal. 9/30/2010 -BUR+ Addition	: Added tidy menu support for yoo_symphony5.5 10/1/2010 -BUR+ Addition	: Added tidy menu support for rt_panacea_j15 10/6/2010 -BUR# Bug Fix	: Backend add/edit Sections and Categories works 10/5/2010 -BUR# Bug Fix	: Backend Article Manager filters improperly being removed 10/6/2010 -BUR---------------- 1.3.3 Released -- [27-Aug-2010]----------# Bug Fix	: Corrected a regular expression bug in community_acl.php 8/27/2010 -BUR^ Change	: Form.php now mimics Joomla!'s restriction on usernames 8/27/2010 -BUR# Bug Fix	: Registration type auto assign group/role/function now working properly. 8/27/2010 -BUR---------------- 1.3.2 Released -- [23-Aug-2010]----------# Bug Fix	: Fixed test that was incorrectly removing the sort options from article manager. 8/16/2010 -BUR+ Addition	: Added swMenu TransMenu 8/18/2010 -BUR+ Addition	: Article Submission works for some RocketTheme's 8/23/2010 -BUR---------------- 1.3.1 Released -- [8/13/2010]----------+ Addition	: Better description of the helper.php file needs overwritten to have module control. -BUR# Bug Fix	: Role redirect is displaying information stored in the db now. -BUR# Bug Fix	: Removed querypath for menu access. -BUR+ Addition	: Added support for swMenu MyGosu menu system using regex instead of querypath. -BUR# Bug Fix	: Changed tests for $denyList in cacl_preprocessor -BUR---------------- 1.3 Released -- [8/2/2010]----------# Bug Fix	: CACL now honors user redirect, specific group/role redirect, and default group/role redirect. With preference in that order. -BUR 8/3/2010+ Addition	: Added support for swMenu MyGosu menu system. -BUR+ Addition	: Added querypath. -Adam# Bug Fix	: Article Submission restrictions were not working -BUR---------------- 1.2.1 Released -- []----------#Bug Fix	: Issue with javascript drop down selection for sections/categories as an article was created/edited fixed.#Bug Fix	: Issue with users accessing restricted users via URL fixed (especially at backend) fixed.#Bug Fix	: Implode error message whenever Publisher logs in fixed.#Bug Fix	: Cacl Preprocessor plugin error displays fixed.#Bug Fix	: Issue with drop down selection for sections/categories not displayed correctly when it is restricted/allowed fixed.#Addition	: Backend control panel icon(s) restrictions.---------------- 1.2 Released-- [ 15-January-2010] ----------------------# Bug Fix	: Issue with menu patch fixed.# Bug Fix 	: Issue with drop down for section and category list fixed.# Bug Fix	: Issue with configuration button not expanding fixed.# Bug Fix	: Issue with Community ACL and Community Builder plugin communication fixed.# Bug Fix	: Issue with restricted contents being access with via URL.^ Change	: Mod_mainenu and mod_menu being disabled during installation has been eliminated.^ Change	: Patch menu item gets hidden when there are no installtion errors.^ Change	: Support link moved to the help menu item.+ Addition	: Community Pre-processor plugin now eliminates the hacking of files except for the library file.+ Addition	: JomSocial plugin that facilitates communication between Community ACL and JomSocial.! Note		: File that needs to be patched for Community ACL to be fully functional can be found at this file path: libraries/joomla/application/module/helper.php! Note		: The fix button does not work due to server side file permission issues unique to every site.
---------------- 1.1 Released-- [ 5-October-2009] ----------------------
# Bug Fix	: Issue with editor displaying Array Merge error on the frontend.
# Bug Fix	: Issue with installer calling an undefined function during installation process.
# Bug Fix 	: Issue with redirect values not stored whenever a URL is entered in the roles/groups section.
# Bug Fix	: Issue with Tables setup: missing/undefined field names. The redirection field names were incorrectly named. introtext was missing - triggered error whenever a function was saved. Issue fixed
# Bug Fix	: ALERTNOACCESS message. Issue fixed. This was triggered because of the wrong location of the language file during the installation process. Now displays "Sorry, but you don't have enough privileges to see this article"
# Bug Fix	: Issue with Community Builder/ACL userrg file. The redirect URLS were incorrect. Fixed the query to pull the correct URLs for the right group or role.
# Bug Fix	: Issue with the Select Role dropdown list. It didn't display the role(s) for a group during the process of adding new user(s) to a group.
# Bug Fix	: Issue with Section Manager/ Category Manager/ Section Manager showing at top menu level - even after they have been restricted.
+ Addition	: Javascript that hide/show the publish radio set based on the Section or Category chosen
+ Addition	: Content plugin which allow admins to enter code snippet tags around a body of content within an article that would only make that piece of content available for the Group/Role specified
+ Addition	: New feature that allow admins to show frontpage/metadata/start or finish publishing/Author Alias/Access Level on the Joomla! content submission form.

---------------- 1.0.16 Released-- [6-July-2009] -------------------
# Bug Fix	: Issue with Installation Package fixed.
# Bug Fix 	: Issue with undefined variables fixed in the component
# Bug Fix 	: Issue with 'Purge Expired Cache' Menu item missing fixed
# Bug Fix	: Fixed some synchronization issues that appeared on some servers.
# Bug Fix	: Fixed the redirect issue. The feature was formerly not functional during log in.
# Bug Fix	: Issue with Community Builder/ACL userrg file. The redirect URLS were incorrect. Fixed the query to pull the correct URLs for the right group or role.
# Bug Fix   : Fixed undefined object in the Group/Roles - set access.
+ Addition  : New installer - installs all patch files and plugins for Community ACL by a click of a button
+ Addition 	: GUI Updates for the new installer
^ Change	: Hack Page changed to Patch Page
^ Change	: Names of users - under Add Users - for Roles and Groups has been sorted in Ascending order
! Note		: Due to file permissions the installer will not be able to move/overwrite files. You would need to path files manually


---------------- 1.0.15 Released Revised-- [5-June-2009] -------------------
# Bug Fix	: Issue with some server settings where error reporting was not controlled by Joomla! but instead of the server - errors are printed out. Fixed!
# Bug Fix	: Issue with redirect looping on the frontend. Issue with the latest version of Joomla! - now fixed.
# Bug Fix	: Issue with Function setup. When Edit & Publish are denied but Add is allowed, Unauthorized Message displayed for Add Action is fixed.
# Bug Fix	: Issue with undefined variable under Group column when attempting to remove a user from a role.
# Bug Fix	: Issue with Undefined offset under list of Languages
+ Addition	: Added the ability to assign user to a role of a group under Add Users in the Groups control.
+ Addition	: Added the ability to create custom redirects for login -> For Users / Groups / Roles
+ Addition	: Documenatation revised.
+ Addition	: Added a feature ability for strictly Administrators to Bulk add Users to Groups / Roles / Functions
+ Addition  : Added an installer - made installation very easy
^ Change	: Updated the configuration GUI and added some additional features such as Community Builder / JomSocial Group and Role Management
^ Change 	: Included a Hack section primarily to care of the hacks into Joomla! in order to make Community ACL functional.
^ Change	: Major overhaul of the Help section - removal of the about us section.
^ Change	: GUI Updates across the entire application
! Note		: Core changes in the code - updated and more robust - smaller foot print.
! Note		: Many other updates have been applied - over 20 new additions or fixes - to many to keep track of with the limited time of this changelog - Enjoy this latest release


---------------- 1.0.14 Released -- [18-March-2009] -------------------
# Bug Fix  	: Ability to delete a Parent Menu under Forbidden Menus and still have the children Menu display under Forbidden Menu List
# Bug Fix	: Inability to add a group/role/function when Role is not assigned
# Bug Fix	: List of Language Files - Version/Date/Author Error fixed
^ Change	: Unhide Sites Management Menu and Synchronize Submenu when Synchronization is enabled under Configuration
^ Change   	: Misc. Changes.

---------------- 1.0.12 Released -- [09-February-2009] ------------------
# Bug Fix  	: Some bugs in cACL Joomla and CB plugins.
^ Change   	: Misc. Changes

---------------- 1.0.11 Released -- [16-January-2009] ------------------
# Bug Fix  	: Frontend publish not working properly under author.
# Bug Fix  	: Backend notification showing on all pages.
^ Change   	: Misc. Changes

---------------- 1.0.10 Released -- [27-November-2008] ------------------
+ Addition 	: Ability to do plugin installation and patch core files on the `About Page` (if its not installed or patched).
+ Addition 	: Ability to only sync certain groups, roles or functions.
+ Addition 	: Ability to only add a category to a certain Section.
+ Addition 	: Show if a module is published or not in backend.
+ Addition 	: Menu items are displayed in their parent/child hierarchy in order.
+ Addition 	: Hide `Menu Trash` if no access to `Menu Manager`.

---------------- 1.0.9 Released -- [13-November-2008] ------------------
# Bug Fix  	: Bug with Frontpage Blog layout.
# Bug Fix  	: Bugs in cACL plugin.

---------------- 1.0.8 Released -- [27-October-2008] ------------------
+ Addition 	: Section Manager, Front Page Manager, Category Manager to component dropdown list.
+ Addition 	: Option to show/hide content or display a `no access` message, also option to show introtext or not.
+ Addition 	: Ability to synchronize configuration.
+ Addition 	: Ability to do initial synchronization.
+ Addition 	: After successful login user is redirected to the previous page they tried to access (works only with Community Builder login form).
+ Addition 	: Option in functions actions - `Only allow this value`/`Allow all values except this value`
^ Change   	: Community Builder plugin was changed to work with both Community Builder 1.1 and 1.2 versions.
# Bug Fix  	: Bug with mod_mainmenu when horizontal layout enabled.
# Bug Fix  	: Bugs during items synchonization.
</pre>