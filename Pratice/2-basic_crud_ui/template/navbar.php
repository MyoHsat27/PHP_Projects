<div class="container-fluid shadow-sm py-3">
    <div class="container p-0 d-flex justify-content-between align-items-center">
        <div class="left-side">
            <h5 class="text-success m-0">Navbar</h5>
        </div>
        <div class="right-side d-flex justify-content-center align-items-center">
            <a href="<?= url("index.php") ?>" class="text-decoration-none mx-2 text-success">Home</a>
            <a href="<?= url("about.php") ?>" class="text-decoration-none mx-2 text-success">About</a>
            <div class="dropdown mx-2 text-success">
                <div class=" dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    List
                </div>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?= url("list_index.php") ?>">List</a></li>
                    <li><a class="dropdown-item" href="<?= url("list_create.php") ?>">Create List</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>