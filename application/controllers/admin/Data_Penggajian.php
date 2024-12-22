<?php

class Data_Penggajian extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('ModelPenggajian'); // Ensure model is loaded

        // Check if the user has the correct access
        if ($this->session->userdata('hak_akses') != '1') {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Anda Belum Login!</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                </div>');
            redirect('login');
        }
    }

    // Display the data
    public function index() {
        $data['title'] = "Data Gaji Pegawai";

        // Get month and year from GET parameters or use current date
        $bulan = $this->input->get('bulan') ? $this->input->get('bulan') : date('m');
        $tahun = $this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
        $bulantahun = $bulan . $tahun;

        // Get deduction data for salary (e.g., fines or absences)
        $potongan_data = $this->ModelPenggajian->get_data('potongan_gaji')->row();
        $data['alpha'] = $potongan_data ? $potongan_data->jml_potongan : 0;

        // Fetch employee salary data based on the month and year
        $query = "SELECT data_pegawai.nik, data_pegawai.nama_pegawai, data_pegawai.jenis_kelamin,
                         data_jabatan.nama_jabatan, data_jabatan.gaji_pokok, data_jabatan.tj_transport,
                         data_jabatan.uang_makan, data_kehadiran.alpha 
                  FROM data_pegawai
                  INNER JOIN data_kehadiran ON data_kehadiran.nik = data_pegawai.nik
                  INNER JOIN data_jabatan ON data_jabatan.nama_jabatan = data_pegawai.jabatan
                  WHERE data_kehadiran.bulan = ?
                  ORDER BY data_pegawai.nama_pegawai ASC";
        $data['gaji'] = $this->db->query($query, [$bulantahun])->result();

        // Load views
        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/gaji/data_gaji', $data);
        $this->load->view('template_admin/footer');
    }

    // Edit salary data
    public function edit($nik) {
        // Get employee data by NIK
        $data['pegawai'] = $this->ModelPenggajian->get_data_by_nik($nik);
        if (!$data['pegawai']) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning">Data Pegawai Tidak Ditemukan!</div>');
            redirect('admin/data_penggajian');
        }

        $data['title'] = "Edit Data Gaji Pegawai";

        // Load the edit view
        $this->load->view('template_admin/header', $data);
        $this->load->view('template_admin/sidebar');
        $this->load->view('admin/gaji/edit_gaji', $data);
        $this->load->view('template_admin/footer');
    }

    // Update salary data
    public function update() {
        $nik = $this->input->post('nik');
        $gaji_pokok = $this->input->post('gaji_pokok');
        $tj_transport = $this->input->post('tj_transport');
        $uang_makan = $this->input->post('uang_makan');
        $alpha = $this->input->post('alpha');

        // Prepare data to update
        $data = [
            'gaji_pokok' => $gaji_pokok,
            'tj_transport' => $tj_transport,
            'uang_makan' => $uang_makan,
            'alpha' => $alpha
        ];

        // Update employee salary data
        $this->db->where('nik', $nik);
        if ($this->db->update('data_kehadiran', $data)) {
            $this->session->set_flashdata('pesan', '<div class="alert alert-success">Data Gaji Pegawai Berhasil Diperbarui!</div>');
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Data Gaji Pegawai Gagal Diperbarui!</div>');
        }

        redirect('admin/data_penggajian');
    }

    // Delete salary data
    public function delete($nik) {
        // Check if NIK is valid before deleting
        $this->db->where('nik', $nik);
        $is_exists = $this->db->get('data_kehadiran')->num_rows();

        if ($is_exists) {
            // Delete data related to employee in data_kehadiran
            $this->db->where('nik', $nik);
            if ($this->db->delete('data_kehadiran')) {
                $this->session->set_flashdata('pesan', '<div class="alert alert-success">Data berhasil dihapus!</div>');
            } else {
                $this->session->set_flashdata('pesan', '<div class="alert alert-danger">Data gagal dihapus!</div>');
            }
        } else {
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning">Data tidak ditemukan!</div>');
        }

        redirect('admin/data_penggajian');
    }
}
?>
