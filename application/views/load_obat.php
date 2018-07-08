<div class="panel panel-headline">
	<div class="panel-heading">
		<h3 class="panel-title">Daftar Obat</h3>
		<center><a href="#myModal" class="btn btn-warning" data-toggle="modal">Tambah</a></center>
	</div>
	<div class="panel-body">
		<table id="example" class="table table-hover table-striped">					
			<tr>
				<th>No</th>
				<th>Nama Obat</th>
				<th>Jenis</th>
				<th>Harga</th>
				<th>Stok</th>
				<th>Aksi</th>
			</tr>
			<?php

				$no=1;
				$query = $this->db->join('jenis','jenis.id_jenis=obat.id_jenis')
								  ->get('obat')
							      ->result();

				foreach ($query as $obat) {
			?>
			<tr>
				<td><?= $no++ ?></td>
				<td><?= $obat->nama_obat ?></td>
				<td><?= $obat->jenis ?></td>
				<td>Rp. <?= number_format($obat->harga); ?></td>
				<td><?= $obat->stok?></td>
				<td><a href="#myModal<?=$obat->id_obat?>" data-toggle="modal" class="btn btn-success">Ubah</a> <a href="<?= base_url('index.php/ta_apotek/delete_obat/'.$obat->id_obat)?>" onclick="return confirm('Apakah Anda Yakin?')" class="btn btn-danger">Hapus</a></td>
			</tr>
			<?php
				}	
			?>
		</table>
	</div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	<div class="modal-dialog">
    	<div class="modal-content">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        	<h4 class="modal-title" id="myModalLabel">Tambah Obat</h4>
      	</div>
      	<div class="modal-body">
       		<form method="post" action="<?= base_url('index.php/ta_apotek/add_obat')?>">
       			<table>
       				<input type="text" name="id" value="<?= $obat->id_obat ?>" hidden="hidden">
       				<input type="text" name="nama_obat" value="<?= $obat->nama_obat ?>" hidden="hidden">
       				<input type="text" name="harga" value="<?= $obat->harga ?>" hidden="hidden">
       				<tr>
       					<td>Nama Obat</td>
       					<td><input type="text" name="nama_obat" required></td>
       				</tr>
       				<tr>
       					<td>Jenis</td>
       					<td>
       						<select name="id_jenis">
       							<?php
									$no=1;
									$query = $this->db->get('jenis')
													  ->result();

									foreach ($query as $obat) {

								?>
       							<option value="<?= $obat->id_jenis?>"><?= $obat->jenis?></option>
       							<?php
									}
								?>
       						</select>
       					</td>
       				</tr>
       				<tr>
       					<td>Harga</td>
       					<td><input type="number" name="harga" required></td>
       				</tr>
       				<tr>
       					<td>stok</td>
       					<td><input type="number" name="stok" required></td>
       				</tr>
       				<tr>
       					<td><input type="submit" name="proses" class="btn btn-success" value="Tambah"></td>
       				</tr>
       			</table>
       		</form>
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      	</div>
    	</div>
  	</div>
</div>
<?php

	$no=1;
	$query = $this->db->get('obat')
					  ->result();

	foreach ($query as $obat) {
?>
<div class="modal fade" id="myModal<?= $obat->id_obat?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  	<div class="modal-dialog">
    	<div class="modal-content">
      	<div class="modal-header">
        	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        	<h4 class="modal-title" id="myModalLabel">Edit Obat</h4>
      	</div>
      	<div class="modal-body">
       		<form method="post" action="<?= base_url('index.php/ta_apotek/edit_obat/'.$obat->id_obat)?>">
       			<table>
       				<tr>
       					<td>Nama Obat</td>
       					<td><input type="text" name="nama_obat" value="<?= $obat->nama_obat?>"></td>
       				</tr>
       				<tr>
       					<td>Jenis</td>
       					<td>
       						<select name="jenis">
       							<?php

									$no=1;
									$query = $this->db->get('jenis')
													  ->result();

									foreach ($query as $obat1) {
								?>
       							<option value="<?= $obat1->id_jenis?>"><?= $obat1->jenis?></option>
       							<?php
									}	
								?>
       						</select>
       					</td>
       				</tr>
       				<tr>
       					<td>Harga</td>
       					<td><input type="number" name="harga" value="<?= $obat->harga?>"></td>
       				</tr>
       				<tr>
       					<td>stok</td>
       					<td><input type="number" name="stok" value="<?= $obat->stok?>"></td>
       				</tr>
       				<tr>
       					<td><input type="submit" name="proses" class="btn btn-success" value="Ubah"></td>
       				</tr>
       			</table>
       		</form>
      	</div>
      	<div class="modal-footer">
        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      	</div>
    	</div>
  	</div>
</div>

<?php
	}	
?>