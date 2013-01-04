<? $this->beginContent('//layouts/main'); ?>
<body class="splash">
	<div id="page-<?= $this->id . '-' . $this->action->id; ?>" class="page-<?= $this->id . '-' . $this->action->id; ?> page-controller-<?= $this->id; ?> page-action-<?= $this->action->id; ?>">
		<?= $content; ?>
	</div>
</body>
<? $this->endContent(); ?>