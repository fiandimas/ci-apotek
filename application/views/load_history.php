
		<div class="panel-heading">
			<h3 class="panel-title">Transaksi</h3>
		</div>
		<div class="panel-body">
			<table id="example" class="table table-hover table-striped">					
				<tr>
					<th style="text-align: center">No</th>
					<th style="text-align: center">No Nota</th>
					<th style="text-align: center">Nama Pembeli</th>
					<th style="text-align: center">Total</th>
					<th style="text-align: center">Bayar</th>
					<th style="text-align: center">Kembali</th>
					<th style="text-align: center">Status</th>
					<th style="text-align: center">Tanggal</th>
					<th style="text-align: center">Detail</th>
				</tr>
				<?php

					$no=1;
					$query = $this->db->join('pembeli','pembeli.id_pembeli=nota.id_pembeli')
									  ->get('nota')
									  ->result();

					foreach ($query as $obat) {
				?>
				<tr align="center">
					<td><?= $no++ ?></td>
					<td><?= $obat->id_nota ?></td>
					<td><?= preg_replace('/[0-9]/','',$obat->nama_pembeli); ?></td>
					<td>Rp. <?= number_format($obat->total) ?></td>
					<td>Rp. <?= number_format($obat->bayar) ?></td>
					<td>Rp. <?= number_format($obat->kembali) ?></td>
					<td>Sukses</td>
					<td><?= $obat->tanggal ?></td>
					<td><a class="btn btn-warning" href="#detail<?=$obat->id_nota?>" data-toggle="modal">Detail</a></td>
				</tr>
				<?php
					}	
				?>
			</table>
		</div>
<?php
	
	$query = $this->db->get('nota')
					  ->result();
	foreach ($query as $data) {
		
?>
<div class="modal fade" id="detail<?=$data->id_nota?>">
	<div class="modal-dialog">
		<div class="modal-content">
		    <div class="modal-header">
		     	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		        <h4 class="modal-title">Detail</h4>
		    </div>
		    <div class="modal-body">
		        
				<?php

				$query = $this->db->where('id_nota',$data->id_nota)
								  ->join('obat','obat.id_obat=transaksi.id_obat')
								  ->get('transaksi')
								  ->result(); 
				foreach ($query as $value): ?>
				<div class="row">
					<div class="col-md-12">
						<table class="table table-hover table-striped">
							<tr align="center">
								<td>Nama Obat</td>
								<td>Jumlah</td>
								<td>Harga</td>
							</tr>
							<tr  align="center">
								<td><?= $value->nama_obat ?></td>
								<td><?= $value->jumlah ?></td>
								<td><?= number_format($value->harga) ?></td>
							</tr>
						</table>
					</div>
				</div>
				<?php endforeach ?>

		    </div>
		    <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		    </div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<?php

	}
?>