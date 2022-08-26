
    <?php $i=1; foreach ($note as $item) {
    ?>
    <tr>
        <td width="30"><?php echo $i ?></td>
        <td><?php echo date('d/m/Y h:i', strtotime($item->time)); ?></td>
        <td><?php echo $item->username ?></td>
        <td><?php echo $item->note ?></td>
    </tr>
    <?php $i++; } ?>