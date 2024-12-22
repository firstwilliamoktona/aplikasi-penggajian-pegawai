<div class="container">
    <h2>Edit Gaji Pegawai</h2>
    
    <?php if ($this->session->flashdata('pesan')): ?>
        <?php echo $this->session->flashdata('pesan'); ?>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label for="gaji_pokok">Gaji Pokok:</label>
            <input type="number" name="gaji_pokok" class="form-control" value="<?php echo $pegawai->gaji_pokok; ?>" required>
        </div>

        <div class="form-group">
            <label for="tj_transport">Tunjangan Transport:</label>
            <input type="number" name="tj_transport" class="form-control" value="<?php echo $pegawai->tj_transport; ?>" required>
        </div>

        <div class="form-group">
            <label for="uang_makan">Uang Makan:</label>
            <input type="number" name="uang_makan" class="form-control" value="<?php echo $pegawai->uang_makan; ?>" required>
        </div>

        <div class="form-group">
            <label for="alpha">Alpha:</label>
            <input type="number" name="alpha" class="form-control" value="<?php echo $pegawai->alpha; ?>" required>
        </div>

        <button type="submit" name="submit" class="btn btn-primary">Update Gaji</button>
    </form>
</div>
