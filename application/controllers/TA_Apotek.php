<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TA_Apotek extends CI_Controller {

	public function index()
	{
		$this->load->view('lta_apotek');
	}

	public function load_obat()
	{
		$data['konten']="load_obat";
		$this->load->view('ita_apotek',$data);
	}

	public function load_transaksi()
	{
		$data['konten']="load_transaksi";
		$this->load->view('ita_apotek',$data);
	}

	public function load_history()
	{
		$data['konten']="load_history";
		$this->load->view('ita_apotek',$data);
	}

	public function login()
	{
		$this->load->model('m_apotek');
		$this->m_apotek->m_login();
	}

	public function add_cart($id)
	{
		$this->load->model('m_apotek');

		$query=$this->m_apotek->m_detail($id);
		$data = array(
			'id'      => $query->id_obat,
			'qty'     => 1,
			'price'   => $query->harga,
			'name'    => $query->nama_obat
		);
		
		$this->cart->insert($data);
		redirect('ta_apotek/load_transaksi','refresh');
			
	}

	public function clear_cart()
	{
		$this->cart->destroy();
		redirect('ta_apotek/load_transaksi','refresh');
	}

	public function delete_cart($id)
	{	
		$data = array(
			'rowid' => $id,
			'qty'   => 0
		);
		
		$this->cart->update($data);
		redirect('ta_apotek/load_transaksi','refresh');
	}

	public function update_cart()
	{
		
		if ($this->input->post('update')) {
			for($i=0;$i<count($this->input->post('rowid'));$i++){
				$data = array(
					'rowid' => $this->input->post('rowid')[$i],
					'qty'   => $this->input->post('qty')[$i]
				);
				$this->cart->update($data);
			}
		redirect('ta_apotek/load_transaksi','refresh');		
		}
		else
			if($this->input->post('bayar')){
				$total = $this->input->post('total');
				$bayar = $this->input->post('bayaran');
				$kembali = $bayar-$total;
				if($total > $bayar){
					$this->session->set_flashdata('utang','Uang Kurang Rp. '.number_format($kembali));
					redirect('ta_apotek/load_transaksi','refresh');
				}
				else
				{
					$this->load->model('m_apotek');
					$this->m_apotek->m_simpan_cart();
					redirect('ta_apotek/load_history','refresh');
				}
			}
	}

	public function delete_obat($id)
	{
		$this->load->model('m_apotek');
		$this->m_apotek->m_delete_obat($id);
		redirect('ta_apotek/load_obat','refresh');

	}

	public function add_obat()
	{
		$this->load->model('m_apotek');
		$this->m_apotek->m_add_obat();
		redirect('ta_apotek/load_obat','refresh');
	}

	public function edit_obat($id)
	{
		$this->load->model('m_apotek');
		$this->m_apotek->m_edit_obat($id);
		redirect('ta_apotek/load_obat','refresh');
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('ta_apotek','refresh');
	}

}

/* End of file TA_Apotek.php */
/* Location: ./application/controllers/TA_Apotek.php */