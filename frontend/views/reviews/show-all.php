<p>
    <?php foreach($reviews as $review): ?>

        <?php foreach ($review as $column => $value): ?>
            <?= "$column: $value." ?><br>
        <?php endforeach; ?>

        <br><br>
    <?php endforeach; ?>
</p>