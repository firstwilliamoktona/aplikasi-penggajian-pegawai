<?php

class ModelPenggajian extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Method to get employee data by NIK
    public function get_data_by_nik($nik) {
        $this->db->select('data_pegawai.nik, data_pegawai.nama_pegawai, data_pegawai.jenis_kelamin,
                           data_jabatan.nama_jabatan, data_jabatan.gaji_pokok, data_jabatan.tj_transport,
                           data_jabatan.uang_makan, data_kehadiran.alpha');
        $this->db->from('data_pegawai');
        $this->db->join('data_jabatan', 'data_jabatan.nama_jabatan = data_pegawai.jabatan', 'inner');
        $this->db->join('data_kehadiran', 'data_kehadiran.nik = data_pegawai.nik', 'inner');
        $this->db->where('data_pegawai.nik', $nik);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row(); // Return the first result row
        } else {
            return null; // No record found
        }
    }

    // Other methods for the model...

}
?>
