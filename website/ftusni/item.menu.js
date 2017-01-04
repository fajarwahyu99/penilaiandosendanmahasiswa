<script language='JavaScript1.2'>
<!--
var pMenu = new PopupMenu('pMenu');
with (pMenu)
{
//startMenu('root', false, 'page.winW()/2 - pMenu.menu.root[0].menuW/2', 0, 17, hBar); // Centres.
//startMenu('root', false, 10, 'page.scrollY()', 17, hBar); // Floats with window as you scroll.
//startMenu('root', false, 10, 0, 17, hBar, 'frameName'); // To create in subframe.

// The 'root' menu is horizontal, positioned at (x = 10, y = 0) and is 17px high, and items
// by default use the colours and dimensions in the 'hBar' ItemStyle defined above.
// This menu is also positioned over a similarly-coloured table in the HTML document above.
startMenu('root', false, 10, 0, 17, hBar);
// The text is a space then 'File', and this item pops out the 'mFile' submenu when moused over
// as we've set 'sm:' as the action type. If you want to assign a click action (e.g. navigating to
// a file) to one of these 'sm:' items, see the 'Optional Code' section below.
addItem('&nbsp; File', 'mFile', 'sm:');
addItem('&nbsp; Edit', 'mEdit', 'sm:');
addItem('&nbsp; Help', 'mHelp', 'sm:');
// Next is an example of a Javascript function embedded in the menu, to open a new window...
// Also, note the extra optional 4th and 5th parameters -- this menu item is 80px long,
// rather than the default length from the ItemStyle.
addItem('&nbsp; Visit My Site', 'window.open("http://www.twinhelix.com")', 'js:', hBar, 80);
// This is a vertical menu positioned 0px across and 22px down from its trigger, and is 80px wide.
startMenu('mFile', true, 0, 22, 80, subM);
// The URLs are set to # here, be sure to replace them with your path/file names or JS functions!
// Also note how all the types are '', indicating these links open in the current frame.
addItem('Open', '#', '');
addItem('Save', '#', '');
addItem('Reopen', 'mReopen', 'sm:');
addItem('Check for<br />Update...', 'http://www.twinhelix.com', '', subM, 38);

startMenu('mEdit', true, 0, 22, 80, subM);
addItem('Cut', '#', '');
addItem('Copy', '#', '');
addItem('Paste', '#', '');
addItem('Convert', 'mConvert', 'sm:');
// Popout slightly left of its trigger, for fun...
startMenu('mHelp', true, -10, 22, 80, subM);
// Instead of using spaces to indent, consider 'text-indent' in the stylesheet class perhaps?
addItem('&nbsp; &nbsp; Contents', '#', '');
addItem('&nbsp; &nbsp; Search', '#', '');
// Here's an example of adding extra optional parameters to the addItem() command.
// This item uses the subM ItemSyle (regardless of what the rest of this menu uses), is 22px long,
// has 0px spacing after it, and a lesser-than-sign popout indicator positioned 3px from the left
// edge of this item. Note that the parameters after the ItemStyle name are in the same order as
// the ItemStyle command itself, and you can have as many as you want (e.g. background colours).
addItem('&nbsp; &nbsp; About', 'mAbout', 'sm:', subM, 22, 0, '&lt;', 3);

// This is across but not down... a horizontal popout.
startMenu('mReopen', true, 85, 0, 120, button);
// Again these items have their own ItemStyles, and unique lengths / spacings specified.
addItem('Recent Doc 1:<br />Schedule', '#', '', button, 35);
addItem('Recent Doc 2:<br />Cunning Plan', '#', '', button, 35, 5);
// Back to the normal submenu ItemStyle for this next item.
addItem('Etc. etc...', '#', '', subM);

// This uses the subBlank ItemStyle which gives the items no borders when dim. The border around
// the whole menu comes from a JavaScript function in the "Menu Effects" section.
startMenu('mConvert', true, 85, 0, 80, subBlank);
addItem('Windows', '#', '');
addItem('Unix', '#', '');
addItem('Macintosh', '#', '');
// Leftwards popout with a negative x and y relative to its trigger. Custom height too.
startMenu('mAbout', true, -85, -18, 80, subM);
addItem('Leftwards!<br>And up!', '#', '', subM, 40);
}
// *** (3) MENU EFFECTS AND ANIMATION ***
// Add a border to an all menus using a specified ItemStyle. The syntax is:
// addMenuBorder(menuObject, ItemStyle,
//  opacity of border, 'border colour', border width, 'padding colour', padding width);
// Opacity is a number from 0 to 100, or null for no filter, like the ItemStyles.
-->
</script>