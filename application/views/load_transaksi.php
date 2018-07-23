<div class="col-md-6">
		<div class="panel-heading">
			<h3 class="panel-title">Transaksi</h3>
		</div>
		<div class="panel-body">
			<table id="example" class="table table-hover table-striped">					
				<tr>
					<th style="text-align: center">No</th>
					<th style="text-align: center">Nama Obat</th>
					<th style="text-align: center">Harga</th>
					<th style="text-align: center">Stok</th>
					<th style="text-align: center">Aksi</th>
				</tr>
				<?php

					$no=1;
					$query = $this->db->get('obat')
									  ->result();

					foreach ($query as $obat) {
				?>
				<tr align="center">
					<td><?= $no++ ?></td>
					<td><?= $obat->nama_obat ?></td>
					<td>Rp. <?= number_format($obat->harga); ?></td>
					<td><?= $obat->stok?></td>
					<td><a class="btn btn-warning" href="<?=base_url('index.php/ta_apotek/add_cart/'.$obat->id_obat)?>">Pesan</a></td>
				</tr>
				<?php
					}	
				?>
			</table>
		</div>
</div>
<div class="col-md-6">
	<div class="panel-body">
		<form action="<?= base_url('index.php/ta_apotek/cart')?>" method="post">
			<table id="example" class="table table-hover table-striped">					
				<tr>
					<input type="submit" name="clear" value="Clear Cart" class="btn btn-danger">
						Nama Pembeli : <input type="text" name="nama_pembeli"  style="width: 21%"> Bayar : <input type="number" name="bayaran" style="width: 21%" >
					<th style="text-align: center">No</th>
					<th style="text-align: center">Nama Obat</th>
					<th style="text-align: center">Harga</th>
					<th style="text-align: center">Jumlah</th>
					<th style="text-align: center">Aksi</th>
				</tr>
				<?php

					$no=1;
					foreach ($this->cart->contents() as $obat) {
				?>
				<tr align="center">
					<input type="hidden" name="id_obat[]" value="<?=$obat['id']?>">
					<input type="hidden" name="rowid[]" value="<?=$obat['rowid']?>">
					<input type="hidden" name="id_obat" value="<?=$obat['id']?>">
					<input type="hidden" name="jumlah" value="<?=$obat['qty']?>">
					<input type="hidden" name="rowid" value="<?=$obat['rowid']?>">
					<td><?= $no++ ?></td>
					<td><?= $obat['name'] ?></td>
					<td>Rp. <?= number_format($obat['price']); ?></td>
					<td><input type="number" name="qty[]" value="<?= $obat['qty']?>" style="width: 30%; text-align: center"></td>
					<td><input type="submit" name="delete" value="X" class="btn btn-danger"></td>
				</tr>
				<?php
					}	
				?>
				<input type="hidden" name="total" value="<?=$this->cart->total()?>">
				<tr style="border-bottom:5px black solid">
					<th colspan="4">Grand Total</th><th><?= number_format($this->cart->total())?></th><th></th>
				</tr>
			</table>
			<table>
				<tr>
					<td><input class="btn btn-success" type="submit" name="update" value="Update QTY"></td>
					<td><input type="submit"  class="btn btn-primary" value="Bayar" name="bayar"  style="margin-left: 250px"></td>
				</tr>
			</table>
		</form>
		<br>
		<?php
			if($this->session->flashdata('utang')){

			
		?>
		<div class="alert alert-danger" style="width: 200px; height: 100px; padding: 10px;"><?= $this->session->flashdata('utang')?></div>
		<?php
			}
		?>
	</div>
</div>