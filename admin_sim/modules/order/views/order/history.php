<?php $i=1; foreach ($history as $item) {
?>
<tr>
    <td width="30"><?php echo $i ?></td>
    <td><?php echo date('d/m/Y H:i', strtotime($item->time)); ?></td>
    <td><?php echo $item->username ?></td>
    <td><?php echo $item->name_status ?></td>
</tr>
<?php $i++; } ?>