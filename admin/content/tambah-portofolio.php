<?php
$id = isset($_GET['edit']) ? $_GET['edit'] : '';
if (isset($_GET['edit'])) {
  $id = $_GET['edit'];
  $query = mysqli_query($koneksi, "SELECT * FROM portofolios WHERE id = '$id'");
  $rowEdit = mysqli_fetch_assoc($query);
  $title = "Edit Portofolio";
} else {
  $title = "Tambah Portofolio";
}

if (isset($_GET['delete'])) {
  $id = $_GET['delete'];
  $queryGambar = mysqli_query($koneksi, "SELECT id, image FROM portofolios WHERE id='$id'");
  $rowGambar = mysqli_fetch_assoc($queryGambar);
  $image_name = $rowGambar['image'];
  unlink("upload/" . $image_name);
  $delete = mysqli_query($koneksi, "DELETE FROM portofolios WHERE id = '$id'");
  header("location:?page=portofolio&hapus=berhasil");
}

if (isset($_POST['simpan'])) {
  $id_category = ['id_category'];
  $title = $_POST['title'];
  $content = $_POST['content'];
  $client_name = $_POST['client_name'];
  $project_date = $_POST['project_date'];
  $project_url = $_POST['project_url'];
  $is_active = $_POST['is_active'];
  $id_category = $_POST['id_category'];

  // jika gambar terupload
  if (!empty($_FILES['image']['name'])) {
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $type = mime_content_type($tmp_name);

    $ext_allowed = ["image/png", "image/jpg", "image/jpeg"];

    $path = "upload/";
    if (!is_dir($path)) mkdir($path);

    $image_name = md5($image) . "." . pathinfo($image, PATHINFO_EXTENSION);
    $target_files = $path . $image_name;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target_files)) {
      if (!empty($row['image'])) {
        unlink($path . $row['image']);
      }
    } else {
      echo "extensi file tidak ditemukan";
      die;
    }

    $update = "UPDATE portofolios SET title = '$title', content = '$content', is_active = '$is_active', image_name='$image_name', client_name = '$client_name', project_date = '$project_date', project_url = '$project_url', id_category = '$id_category' WHERE id = '$id'";
  } else {
    $update = "UPDATE portofolios SET title = '$title', content = '$content', is_active = '$is_active', client_name = '$client_name', project_date = '$project_date', project_url = '$project_url', id_category = '$id_category' WHERE id = '$id'";
  }

  if ($id) {
    // ini query update
    $update = mysqli_query($koneksi, $update);
    if ($update) {
      header("location:?page=portofolio&ubah=berhasil");
    }
  } else {
    $insert = mysqli_query($koneksi, "INSERT INTO portofolios (id_category, title, content, image, is_active, client_name, project_date, project_url) VALUES ('$id_category', '$title', '$content', '$image_name', '$is_active', '$client_name', '$project_date', '$project_url')");
    if ($insert) {
      header("location:?page=portofolio&tambah=berhasil");
    }
  }
}

$queryCategories = mysqli_query($koneksi, "SELECT * FROM categories WHERE type='portofolio' ORDER BY id DESC");
$rowCategories = mysqli_fetch_all($queryCategories, MYSQLI_ASSOC);


?>

<div class="pagetitle">
  <h1><?php echo $title; ?></h1>
</div><!-- End Page Title -->

<section class="section">
  <form action="" method="post" enctype="multipart/form-data">
    <div class="row">
      <div class="col-lg-8">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title "><?php echo $title; ?></h5>

            <div class="mb-3">
              <label for="category" class="form-label">Category</label>
              <select class="form-select" name="id_category" id="id_category">
                <?php foreach ($rowCategories as $key => $rowCategory): ?>
                <option value="<?php echo $rowCategory['id'] ?>"><?php echo $rowCategory['name'] ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="title" class="form-label">Title</label>
              <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan Judul Anda"
                value="<?php echo ($id) ? $rowEdit['title'] : '' ?>" required>
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Nama Client</label>
              <input name="client_name" type=" text" class="form-control"
                value="<?php echo ($id) ? $rowEdit['client_name'] : '' ?>" required>
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Tanggal Projek</label>
              <input name="project_date" type="date" class=" form-control"
                value="<?php echo ($id) ? $rowEdit['project_date'] : '' ?>" required>
            </div>
            <div class="mb-3">
              <label for="" class="form-label">Url Projek</label>
              <input name="project_url" type="url" class="form-control"
                value="<?php echo ($id) ? $rowEdit['project_url'] : '' ?>" required>
            </div>
            <div class=" mb-3">
              <label for="content" class="form-label">Content</label>
              <textarea type="text" class="form-control" id="summernote" name="content"
                placeholder="Masukkan Content Anda"><?php echo ($id) ? $rowEdit['content'] : '' ?></textarea>
              <!-- <small>- Isi Content jika ingin mengubah content</small> -->
            </div>
            <div class=" mb-3">
              <label for="image" class="form-label">Image</label>
              <input type="file" class="form-control" id="image" name="image" placeholder="Masukkan Image Anda">
              <img class="mt-2" src="upload/<?php echo isset($rowEdit['image']) ? $rowEdit['image'] : '' ?>" alt=""
                width="100">
            </div>

          </div>
        </div>

      </div>

      <div class="col-sm-4">

        <div class="card">
          <div class="card-body">
            <h5 class="card-title "><?php echo $title; ?></h5>

            <div class="mb-3">
              <label class="form-label" for="inputGroupSelect01">Status</label>
              <select name="is_active" class="form-select" id="inputGroupSelect01">
                <option <?php echo ($id) ? $rowEdit['is_active'] == 1 ? 'selected' : '' : '' ?> value="1">Publish
                </option>
                <option <?php echo ($id) ? $rowEdit['is_active'] == 0 ? 'selected' : '' : '' ?> value="0">Draft
                </option>
              </select>
            </div>
            <div class="mb-3">
              <button class="btn btn-primary" type="submit" name="simpan">Simpan</button>
              <a href="?page=client" class="btn btn-secondary" onclick="history.back()">
                ← Kembali
              </a>
            </div>


          </div>
        </div>

      </div>
    </div>
  </form>
  </div>
</section>