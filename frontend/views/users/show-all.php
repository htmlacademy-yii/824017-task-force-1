<p>
    <?php foreach($users as $user): ?>

        <?php foreach ($user as $column => $value): ?>
            
                <?= "$column: $value." ?><br>
            
        <?php endforeach; ?>
        
        <br><br>
    <?php endforeach; ?>
</p>