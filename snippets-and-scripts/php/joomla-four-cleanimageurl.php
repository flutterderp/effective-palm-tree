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
	$has_image = ($this->item->image->url && file_exists(JPATH_BASE . '/' . $this->item->image->url)) ? true : false;
	$img_url   = $this->item->image->url;
	$img_size  = ($has_image === true) ? getimagesize($this->item->image->url) : array();
}
else
{
	$has_image = ($this->item->image && file_exists(JPATH_BASE . '/' . $this->item->image)) ? true : false;
	$img_url   = $this->item->image;
	$img_size  = ($has_image === true) ? getimagesize($this->item->image) : array();
}
