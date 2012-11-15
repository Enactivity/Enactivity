<? if($data->starts): ?>
Taking place at <?= PHtml::encode($data->formattedStartTime); ?>.  
<? endif; ?>
Part of "<?= PHtml::encode($data->activity->name); ?>".