<?php include_once "../View/head.php" ?>
<?php include_once "../View/nav.php" ?> 

<div class="d-flex flex-column container justify-content-center my-5">
    <h4 class="form-label text-center">Friend Card</h4>
    <?php include_once "../Controller/friend_card_logic.php" ?>
    <form class="card p-3 mb-4" id="card-form" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-12 mt-2">
                <label for="card-name" class="form-label">Friend Name</label>
                <input type="text" form="card-form" id="card-name" name="name" class="form-control" placeholder="Name">
            </div>
            <div class="col-12 mt-4">
                <label for="card-phone" class="form-label">Telephone</label>
                <input type="tel" form="card-form" id="card-phone" name="phone" class="form-control"
                       placeholder="Number">
            </div>
            <div class="col-12 mt-4">
                <label for="card-address" class="form-label">Address</label>
                <textarea type="text" rows="4" form="card-form" id="card-address" name="address" class="form-control"
                          placeholder="Address"></textarea>
            </div>
            <div class="col-12 mt-4">
                <label for="card-image" class="form-label">Photo</label>
                <input type="file" class="form-control" id="card-image" accept="image/jpeg,image/png" name="photo" form="card-form">
            </div>
            <div class="col-12 mt-4">
                <input required type="checkbox" form="card-form" id="card-confirm" name="check"
                       class="form-check-input">
                <label class="form-check-label" for="card-confirm">Is he/she a real friend?</label>
            </div>
            <div class="col-12 mt-4 d-flex justify-content-center align-items-center">
                <button class="btn btn-primary" value="calc" form="card-form" name="friend-card-form">Create Friend
                    List
                </button>
            </div>
        </div>
    </form>
</div>


<div class="container mt-5">
    <?php
    $fileName = "fdata.json";
    $myFriends = json_decode(file_get_contents($fileName),true);
    ?>
    <?php foreach ($myFriends as $key=>$friend) : ?>
        <div class="card mb-3">
            <div class="card-body text-center">
                <img src="<?= $friend['photo'] ?>" class="rounded-circle" width="100" height="100" alt="">
                <h4><?= $friend['name'] ?></h4>
                <p><?= $friend['phone'] ?></p>
                <div class="d-flex">
                    <a href="../Controller/friend_detail.php?index=<?= $key ?>" class="btn btn-primary w-50 mx-1 ">Detail</a>
                    <a href="../Controller/friend_del.php?index=<?= $key ?>" class="btn btn-outline-danger w-50 mx-1">Delete</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include_once "../View/footer.php" ?>
