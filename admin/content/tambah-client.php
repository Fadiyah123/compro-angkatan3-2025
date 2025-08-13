<?php
$id = isset($_GET['edit']) ? $_GET['edit'] : '';

if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $query = mysqli_query($koneksi, "SELECT * FROM clients WHERE id ='$id'");
  $rowEdit = mysqli_fetch_assoc($query);

  $title = "Edit Client";
} else {
  $title = "Tambah Client";
}

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $queryGambar = mysqli_query($koneksi, "SELECT id, image FROM clients WHERE id='$id'");
  $rowGambar = mysqli_fetch_assoc($queryGambar);
  $image_name = $rowGambar['image'];
  unlink("upload/" . $image_name);
  $delete = mysqli_query($koneksi, "DELETE FROM clients WHERE id='$id'");

  if ($delete) {
    header("location:?page=client&hapus=berhasil");
  }
}

if (isset($_POST['simpan'])) {
  $name = $_POST['name'];
  $is_active = $_POST['is_active'];

  if (!empty($_FILES['image']['name'])) {
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $type = mime_content_type($tmp_name);

    $ext_allowed = ["image/png", "image/jpg", "image/jpeg"];

    if (in_array($type, $ext_allowed)) {
      $path = "upload/";

      if (!is_dir($path)) mkdir($path);
      $image_name = time() . "_" . basename($image);
      $target_files = $path . $image_name;
      if (move_uploaded_file($_FILES['image']['tmp_name'], $target_files)) {
        // jika gambarnya ada maka gambar sebelumnya akan di ganti oleh gambar baru
        if (!empty($row['image'])) {
          unlink($path . $row['image']);
        }
      }
    } else {
      echo "File yang diupload bukan gambar";
      die;
    }
  }

  // print_r($password);
  // die;
  if ($id) {
    // ini query update
    $update = mysqli_query($koneksi, "UPDATE clients SET name='$name', image='$image_name' is_active='$is_active'  WHERE id='$id'");
    if ($update) {
      header("location:?page=client&ubah=berhasil");
    }
  } else {
    $insert = mysqli_query($koneksi, "INSERT INTO clients (name, image, is_active) VALUES('$name', '$image_name', '$is_active')");
    if ($insert) {
      header("location:?page=client&tambah=berhasil");
    }
  }
}

?>
<div class="pagetitle">
  <h1><?php echo $title ?></h1>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title"><?php echo $title ?>
          </h5>
          <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="image" class="form-label">Image</label>
              <input type="file" name="image" required value="<?php echo ($id) ? $rowEdit['image'] : '' ?>">
              <small class="text-muted">)* : Size 1920 *1088</small>
            </div>
            <div class="mb-3">
              <label for="">Name</label>
              <input type="text" class="form-control" name="name" placeholder="Masukkan Nama Anda" required
                value="<?php echo ($id) ? $rowEdit['name'] : '' ?>">
            </div>
            <div class="mb-3">
              <label for="">Is Active</label>
              <select name="is_active" id="" class="form-control">
                <option <?php echo ($id) ? $rowEdit['is_active'] == 1 ? 'selected' : '' : '' ?> value="1">Publish
                </option>
                <option <?php echo ($id) ? $rowEdit['is_active'] == 0 ? 'selected' : '' : '' ?> value="0">Draft
                </option>
              </select>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
              <a href="?page-user" class="text-muted">Kembali</a>
            </div>
          </form>

        </div>
      </div>

    </div>
  </div>

</section>