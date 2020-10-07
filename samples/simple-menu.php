<?php
// One-level menu with title
?>
<h3><?= get_menu_name_by_location('footer1') ?></h3>
<?php
$menu = get_menu_items_by_location('footer1');
if ($menu) :
	?>
	<ul class="navbar-nav">
		<?php foreach ($menu as $item) : ?>
			<li class="menu-item">
				<a href="<?= $item->url ?>"><?= $item->title ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>
