<?php
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Version;

// Clean the query string that Joomla 4's media manager adds to image paths and add it to an object
if(Version::MAJOR_VERSION === 4)
{
	$item->image = HTMLHelper::cleanImageUrl($item->image);
}

// Use the cleaned image URL
if(Version::MAJOR_VERSION === 4)
{
	$item->image = HTMLHelper::cleanImageUrl($item->image);
	$decoded     = urldecode($item->image->url);
	$has_image   = ($item->image->url && file_exists(JPATH_BASE . '/' . urldecode($decoded))) ? true : false;
	$img_url     = $decoded;
	$img_size    = ($has_image === true) ? getimagesize($decoded) : array();
}
else
{
	$has_image = ($item->image && file_exists(JPATH_BASE . '/' . $item->image)) ? true : false;
	$img_url   = $item->image;
	$img_size  = ($has_image === true) ? getimagesize($item->image) : array();
}
