<?php
$query = mysqli_query($koneksi, "SELECT * FROM clients ORDER BY id DESC");
$rows = mysqli_fetch_all($query, MYSQLI_ASSOC);
?>
<div class="pagetitle">
  <h1>Clients</h1>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Cliets</h5>
          <div class="mb-3" align="right">
            <a href="?page=tambah-client" class="btn btn-primary">Tambah</a>
          </div>
          <table class="table table-bordered">
            <thread>
              <tr>
                <th>No</th>
                <th>Name</th>
                <th>Image</th>
                <th>Is_Active</th>
                <th>Action</th>
              </tr>
            </thread>
            <tbody>
              <?php foreach ($rows as $key => $row): ?>
                <tr>
                  <td><?php echo $key += 1  ?></td>
                  <td><?php echo $row['name'] ?></td>
                  <td><img width="100" src="upload/<?php echo $row['image'] ?>" alt=""></td>
                  <td><?php echo $row['is_active'] ?></td>
                  <td>
                    <a href=" ?page=tambah-client&edit=<?php echo $row['id'] ?>" class="btn btn-sm btn-success" ?>
                      Edit
                    </a>
                    <a onclick="return confirm('apakah anda yakin menghapus data ini')"
                      href="?page=tambah-client&delete=<?php echo $row['id'] ?>" class="btn btn-sm btn-danger">
                      <i class="bi bi-eye"></i> Delete
                    </a>
                  </td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</section>