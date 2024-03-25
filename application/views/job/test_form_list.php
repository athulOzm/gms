        <?php
        if($all_record){
        $sl = 0+$start;
        foreach ($all_record as $record) {
         $sl++;           
            ?>
            <tr>
                <td><?php echo $sl; ?></td>
                <td><?php echo $record->phrase; ?></td>
                <td><?php echo $record->english; ?></td>
            </tr>
        <?php 
        }
        }
        ?>
 