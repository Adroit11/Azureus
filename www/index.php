<?php
openForm('head');
openForm('header');
openForm('navigation');
openForm('footer');

function openForm($file_name)
{
	include '\form\f_'.$file_name.'.php';
}
?>