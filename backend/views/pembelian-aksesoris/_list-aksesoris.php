<?php

/**
 * Membuat response ajax untuk menampilkan aksesoris pada dropdown
 * sesuai dengan jenis dan merk aksesoris
 */
?>

<select class="form-control-sm" name="aksesoris" id="aksesoris" style="width: 100%">
    <?php if (!empty($model)) : ?>
        <?php foreach ($model as $key => $value) : ?>
            <option value="<?= $key ?>"><?= $value ?></option>
        <?php endforeach; ?>
    <?php else : ?>
        <option value="0">Data tidak ada.</option>
    <?php endif; ?>
</select>