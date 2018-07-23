<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_apotek extends CI_Model {
 
	public function m_login()
	{
		if($this->input->post('login')){
			$this->form_validation->set_rules('username', 'Username', 'trim|required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			if ($this->form_validation->run()) {
				
				$data = $this->db->where('username', $this->input->post('username'))
								 ->where('password',$this->input->post('password'))
								 ->get('kasir')
								 ->num_rows();

				$query = $this->db->where('username', $this->input->post('username'))
								 ->where('password',$this->input->post('password'))
								 ->get('kasir')
								 ->row();				 

				if($data > 0){ 
					$session = array(
						'login'			=> true,
						'nama_kasir'	=> $query->nama_kasir
					);
					$this->session->set_userdata($session);
					redirect('ta_apotek/load_obat','refresh');
				}				 
			} else {
				# code...
			}	
		}
	}

	public function m_detail($a)
	{
		return $this->db->where('id_obat',$a)->get('obat')->row();
	}

	public function m_simpan_cart()
	{

		$total = $this->input->post('total');
		$bayar = $this->input->post('bayaran');
		$a =  $this->db->select_max('id_pembeli',' id')->get('pembeli')->row();
		
		$nama = $this->input->post('nama_pembeli').$a->id;
		$pembeli = array(
					'id_pembeli'	=> NULL,
					'nama_pembeli'	=> $nama
		);
		$cek = $this->db->insert('pembeli', $pembeli);

		$tes = $this->db->where('nama_pembeli',$nama)
						->get('pembeli')
						->row();
		if($cek){
			
			$kembali = $bayar-$total;
			$data =array(
				'id_nota'		=> NULL,
				'id_pembeli'	=> $tes->id_pembeli,
				'total'			=> $total,
				'bayar'			=> $bayar,
				'kembali'		=> $kembali,
				'tanggal'		=> date("Y-m-d")
			);
			$this->db->insert('nota', $data);
		}
		
		$tm_nota=$this->db->order_by('id_nota','desc')
						  ->where('id_pembeli',$tes->id_pembeli)
						  ->limit(1)
						  ->get('nota')
						  ->row();

		for($i=0;$i<count($this->input->post('rowid'));$i++){
				$hasil[]=array(
				'id_nota'=>$tm_nota->id_nota,
				'id_obat'=>$this->input->post('id_obat')[$i],
				'jumlah'=>$this->input->post('qty')[$i]
				);
				
			}		
			$proses=$this->db->insert_batch('transaksi', $hasil);
			if($proses){
				return $tm_nota->id_nota;
			} else {
				return 0;
			}
	}
	public function m_add_obat()
	{
		$data = array(
				'id_obat'	=> NULL,
				'id_jenis'	=> $this->input->post('id_jenis'),
				'nama_obat'	=> $this->input->post('nama_obat'),
				'harga'		=> $this->input->post('harga'),
				'stok'		=> $this->input->post('stok')
		);
		$this->db->insert('obat', $data);
	}

	public function m_edit_obat($id)
	{
		$data = array(
				'id_jenis'	=> $this->input->post('jenis'),
				'nama_obat'	=> $this->input->post('nama_obat'),
				'harga'		=> $this->input->post('harga'),
				'stok'		=> $this->input->post('stok')
		);
		$this->db->where('id_obat',$id)
				 ->update('obat', $data);
	}
	public function m_delete_obat($id)
	{
		$data = array(
			'id_obat'	=> $id
		);
		$this->db->delete('obat',$data);
	}
}

/* End of file M_apotek.php */
/* Location: ./application/models/M_apotek.php */