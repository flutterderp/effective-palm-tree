<?php
$component       = $app->input->get('option', '', 'string');
$viewtype        = $app->input->get('view', '', 'string');
$special_layouts = array('com_content');
$file_name       = 'index_default';
?>

<?php if(in_array($component, $special_layouts))
{
	$comp_name     = substr($component, 4);
	$tmp_file_name = 'index_' . Joomla\Filesystem\File::makeSafe($comp_name . '-' . $viewtype);

	/* switch(true)
	{
		case (int) $active->id === 1234 :
			$file_name = 'custom_' . Joomla\Filesystem\File::makeSafe($comp_name . '-' . $viewtype);
			break;
		default :
			break;
	} */

	$file_name = file_exists(__DIR__ . '/' . $tmp_file_name . '.php') ? $tmp_file_name : $file_name;
}

include_once(__DIR__ . '/' . $file_name . '.php');
?>
