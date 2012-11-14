With the tasks:
<? foreach ($data->tasks as $task): ?>
<?= PHtml::encode($task->name); ?>
<? endforeach; ?>