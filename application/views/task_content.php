<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>
<div style="background-color: #dddddd" class="box" >
	<p style="color:green">Like my modified Kohana Page</p>
	<p style="color:green">
		To change what gets displayed for this page, edit <code>application/controllers/task.php</code>.<br/>
		To change this text, edit <code>application/views/task_content.php</code>.<br/>.<br/>
                === Page has stuff and links I like on it ===
	</p>
</div>


<ul>
<?php foreach ($links as $title => $url): ?>
	<li><?php echo ($title === 'License') ? html::file_anchor($url, html::specialchars($title)) : html::anchor($url, html::specialchars($title)) ?></li>
<?php endforeach ?>
</ul>