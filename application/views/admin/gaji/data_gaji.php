<div class="container-fluid">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
  </div>

  <!-- Card untuk Filter Data Gaji Pegawai -->
  <div class="card mb-3">
    <div class="card-header bg-primary text-white">Filter Data Gaji Pegawai</div>
    <div class="card-body">
      <form class="form-inline">
        <div class="form-group mb-2">
          <label for="staticEmail2">Bulan</label>
          <select class="form-control ml-3" name="bulan">
            <option value=""> Pilih Bulan </option>
            <option value="01">Januari</option>
            <option value="02">Februari</option>
            <option value="03">Maret</option>
            <option value="04">April</option>
            <option value="05">Mei</option>
            <option value="06">Juni</option>
            <option value="07">Juli</option>
            <option value="08">Agustus</option>
            <option value="09">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>
          </select>
        </div>
        <div class="form-group mb-2 ml-5">
          <label for="staticEmail2">Tahun</label>
          <select class="form-control ml-3" name="tahun">
            <option value=""> Pilih Tahun </option>
            <?php 
            $tahun = date('Y');
            for($i=2020; $i < $tahun+5; $i++) { ?>
              <option value="<?php echo $i ?>"><?php echo $i ?></option>
            <?php } ?>
          </select>
        </div>

        <button type="submit" class="btn btn-primary mb-2 ml-auto"><i class="fas fa-eye"></i> Tampilkan Data</button>
      </form>
    </div>
  </div>

  <?php if(count($gaji) > 0 ) { ?>
    <div class="container-fluid">
      <div class="card shadow mb-4">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead class="thead-dark">
                <tr>
                  <th class="text-center">No</th>
                  <th class="text-center">NIK</th>
                  <th class="text-center">Nama Pegawai</th>
                  <th class="text-center">Jenis Kelamin</th>
                  <th class="text-center">Jabatan</th>
                  <th class="text-center">Gaji Pokok</th>
                  <th class="text-center">Tj. Transport</th>
                  <th class="text-center">Uang Makan</th>
                  <th class="text-center">Potongan</th>
                  <th class="text-center">Total Gaji</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                $no=1;
                foreach($gaji as $g) :
                  $potongan = $g->alpha * $alpha; ?>
                  <tr>
                    <td class="text-center"><?php echo $no++ ?></td>
                    <td class="text-center"><?php echo $g->nik ?></td>
                    <td class="text-center"><?php echo $g->nama_pegawai ?></td>
                    <td class="text-center"><?php echo $g->jenis_kelamin ?></td>
                    <td class="text-center"><?php echo $g->nama_jabatan ?></td>
                    <td class="text-center">Rp. <?php echo number_format($g->gaji_pokok,0,',','.') ?></td>
                    <td class="text-center">Rp. <?php echo number_format($g->tj_transport,0,',','.') ?></td>
                    <td class="text-center">Rp. <?php echo number_format($g->uang_makan,0,',','.') ?></td>
                    <td class="text-center">Rp. <?php echo number_format($potongan,0, ',', '.') ?></td>
                    <td class="text-center">Rp. <?php echo number_format($g->gaji_pokok + $g->tj_transport + $g->uang_makan - $potongan,0, ',', '.') ?></td>
                    <td class="text-center">
                      
                      <a href="<?php echo base_url('admin/data_penggajian/delete/'.$g->nik) ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  <?php } else { ?>
    <span class="badge badge-danger"><i class="fas fa-info-circle"></i> Data absensi kosong, silakan input data kehadiran pada bulan dan tahun yang anda pilih</span>
  <?php } ?>
</div>
