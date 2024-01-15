<?php

/**
 * @package     Joomla.Site
 * @subpackage  mod_menu
 *
 * @copyright   (C) 2009 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

$title      = $item->anchor_title ? ' title="' . $item->anchor_title . '"' : '';
$anchor_css = $item->anchor_css ?: '';//print_r($item);
$linktype   = $item->title;

if ($item->menu_icon)
{
    // The link is an icon
    if ($itemParams->get('menu_text', 1)) {
        // If the link text is to be displayed, the icon is added with aria-hidden
        $linktype = '<i class="' . $item->menu_icon . '" aria-hidden="true"></i><span>' . $item->title . '</span>';
    } else {
        // If the icon itself is the link, it needs a visually hidden text
        $linktype = '<i class="' . $item->menu_icon . '" aria-hidden="true"></span><span class="visually-hidden">' . $item->title . '</i>';
    }
}
elseif ($item->menu_image) {
    // The link is an image, maybe with its own class
    $image_attributes = [];

    if ($item->menu_image_css) {
        $image_attributes['class'] = $item->menu_image_css;
    }

    $linktype = HTMLHelper::_('image', $item->menu_image, $item->title, $image_attributes);

    if ($itemParams->get('menu_text', 1)) {
        $linktype .= '<span>' . $item->title . '</span>';
    }
}
?>
<a href="javascript:#">
<?php echo $linktype; ?>
<span class="menu-arrow"></span>
</a>

