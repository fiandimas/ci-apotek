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
	public function cek()
	{
		foreach ($this->cart->contents() as $key) {
			echo "<br>".$key['rowid'];
		}
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
	public function cart()
	{
		if($this->input->post('update')){
			for($i=0;$i<count($this->input->post('rowid'));$i++){
				$data = array(
					'rowid' => $this->input->post('rowid')[$i],
					'qty'   => $this->input->post('qty')[$i]
				);
				if($this->input->post('quantity')[$i] != $this->input->post('qty')[$i]){
					$stokNow = $this->db->where('id_obat', $this->input->post('id_obat')[$i])->get('obat')->row();

					if($this->input->post('qty')[$i] >  $this->input->post('quantity')[$i]){
						$obat = $this->input->post('qty')[$i] - $this->input->post('quantity')[$i];
						$result = $stokNow->stok - $obat;
						$update = $this->db->where('id_obat',$this->input->post('id_obat')[$i])->update('obat',array('stok' => $result));
						$this->cart->update($data);
					}
					else{
						$obat = $this->input->post('quantity')[$i] - $this->input->post('qty')[$i];
						$result = $stokNow->stok + $obat;
						$update = $this->db->where('id_obat',$this->input->post('id_obat')[$i])->update('obat',array('stok' => $result));
						$this->cart->update($data);
					}
				}
			}
			redirect('ta_apotek/load_transaksi','refresh');			
		}else
		if($this->input->post('delete')){
			$data = array(
				'rowid' => $this->input->post('row_id'),
				'qty'   => 0
			);
		
			$stokNow = $this->db->where('id_obat', $this->input->post('idobat'))->get('obat')->row();
			$result = $stokNow->stok + $this->input->post('jumlah');
			$update = $this->db->where('id_obat',$this->input->post('idobat'))->update('obat',array('stok' => $result));

			$this->cart->update($data);
			redirect('ta_apotek/load_transaksi','refresh');
		}else
		if($this->input->post('clear')){
			for($i=0;$i<count($this->input->post('rowid'));$i++){
				$obatCart = $this->input->post('qty')[$i];
				$obatDb = $this->db->where('id_obat', $this->input->post('id_obat')[$i])->get('obat')->row();
				$obat = $obatCart + $obatDb->stok;
				$obatDb = $this->db->where('id_obat', $this->input->post('id_obat')[$i])->update('obat',array('stok' => $obat));
			}
			$this->cart->destroy();
			redirect('ta_apotek/load_transaksi','refresh');
		}
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
		
		$obat = $this->db->where('id_obat', $id)->get('obat')->row();

		$result = $obat->stok - $data['qty'];

		$update = $this->db->where('id_obat', $id)->update('obat',array('stok' => $result));
		$this->cart->insert($data);
		redirect('ta_apotek/load_transaksi/'.$result,'refresh');
			
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