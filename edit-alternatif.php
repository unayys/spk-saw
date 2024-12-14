<?php require_once('includes/init.php'); ?>
<?php cek_login($role = array(1)); ?>

<?php
$errors = array();
$sukses = false;

$ada_error = false;
$result = '';

$id_alternatif = (isset($_GET['id'])) ? trim($_GET['id']) : '';

if(isset($_POST['submit'])):	
	
	$nama = $_POST['nama'];
	$id_kelas = $_POST['id_kelas'];
	
	// Validasi
	if(!$nama) {
		$errors[] = 'Nama tidak boleh kosong';
	}
	if(!$id_kelas) {
		$errors[] = 'Kelas harus dipilih';
	}
	
	// Jika lolos validasi lakukan hal di bawah ini
	if(empty($errors)):
		
		$update = mysqli_query($koneksi,"UPDATE alternatif SET nama = '$nama', id_kelas = '$id_kelas' WHERE id_alternatif = '$id_alternatif'");
		if($update) {
			redirect_to('list-alternatif.php?status=sukses-edit');
		}else{
			$errors[] = 'Data gagal diupdate';
		}
	endif;

endif;

// Ambil data alternatif
$data = mysqli_query($koneksi, "SELECT * FROM alternatif WHERE id_alternatif = '$id_alternatif'");
$d = mysqli_fetch_assoc($data);

// Ambil data kelas
$query_kelas = mysqli_query($koneksi, "SELECT id_kelas, kelas FROM kelas");
?>

<?php
$page = "Alternatif";
require_once('template/header.php');
?>

<form action="edit-alternatif.php?id=<?php echo $id_alternatif; ?>" method="post">
	<div class="card shadow mb-4">
		<div class="card-header py-3">
			<h6 class="m-0 font-weight-bold text-danger"><i class="fas fa-fw fa-edit"></i> Edit Data Alternatif</h6>
		</div>
		<?php if(!$id_alternatif || !$d): ?>
		<div class="card-body">
			<div class="alert alert-danger">Data tidak ada</div>
		</div>
		<?php else: ?>
		<div class="card-body">
			<div class="row">
				<div class="form-group col-md-12">
					<label class="font-weight-bold">Nama</label>
					<input autocomplete="off" type="text" name="nama" required value="<?php echo $d['nama']; ?>" class="form-control"/>
				</div>
				<div class="form-group col-md-12">
					<label class="font-weight-bold">Kelas</label>
					<select name="id_kelas" class="form-control" required>
						<option value="">-- Pilih Kelas --</option>
						<?php while($kelas = mysqli_fetch_assoc($query_kelas)): ?>
							<option value="<?php echo $kelas['id_kelas']; ?>" <?php echo ($kelas['id_kelas'] == $d['id_kelas']) ? 'selected' : ''; ?>>
								<?php echo $kelas['kelas']; ?>
							</option>
						<?php endwhile; ?>
					</select>
				</div>
			</div>
		</div>
		<div class="card-footer text-right">
            <button name="submit" value="submit" type="submit" class="btn btn-success"><i class="fa fa-save"></i> Update</button>
            <button type="reset" class="btn btn-info"><i class="fa fa-sync-alt"></i> Reset</button>
        </div>
		<?php endif; ?>
	</div>
</form>

<?php
require_once('template/footer.php');
?>