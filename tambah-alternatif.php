<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$errors = array();
$sukses = false;

$nama = (isset($_POST['nama'])) ? trim($_POST['nama']) : '';
$id_kelas = (isset($_POST['id_kelas'])) ? trim($_POST['id_kelas']) : '';

if(isset($_POST['submit'])):	
	
	// Validasi
	if(!$nama) {
		$errors[] = 'Nama tidak boleh kosong';
	}
	if(!$id_kelas) {
		$errors[] = 'Kelas harus dipilih';
	}
	
	// Jika lolos validasi lakukan hal di bawah ini
	if(empty($errors)):
		$simpan = mysqli_query($koneksi, "INSERT INTO alternatif (id_alternatif, nama, id_kelas) VALUES ('', '$nama', '$id_kelas')");
		if($simpan) {
			redirect_to('list-alternatif.php?status=sukses-baru');
		}else{
			$errors[] = 'Data gagal disimpan';
		}
	endif;

endif;

// Ambil data kelas
$query_kelas = mysqli_query($koneksi, "SELECT id_kelas, kelas FROM kelas");

$page = "Alternatif";
require_once('template/header.php');
?>

<form action="tambah-alternatif.php" method="post">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-danger"><i class="fas fa-fw fa-plus"></i> Tambah Data Alternatif</h6>
		</div>
		<div class="card-body">
			<div class="row">				
				<div class="form-group col-md-12">
					<label class="font-weight-bold">Nama</label>
					<input autocomplete="off" type="text" name="nama" required value="<?php echo $nama; ?>" class="form-control"/>
				</div>
				<div class="form-group col-md-12">
					<label class="font-weight-bold">Kelas</label>
					<select name="id_kelas" class="form-control" required>
						<option value="">-- Pilih Kelas --</option>
						<?php while($kelas = mysqli_fetch_assoc($query_kelas)): ?>
							<option value="<?php echo $kelas['id_kelas']; ?>" <?php echo ($id_kelas == $kelas['id_kelas']) ? 'selected' : ''; ?>>
								<?php echo $kelas['kelas']; ?>
							</option>
						<?php endwhile; ?>
					</select>
				</div>
			</div>
		</div>
		<div class="card-footer text-right">
            <button name="submit" value="submit" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
            <button type="reset" class="btn btn-info"><i class="fa fa-sync-alt"></i> Reset</button>
        </div>
	</div>
</form>