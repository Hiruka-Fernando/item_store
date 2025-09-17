<?php
    session_start();
    require 'dbcon.php';

?>

<?php include('includes/header.php'); ?>

    
    <div class="container mt-4">

        <?php include('message.php') ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Product Details
                            <a href="additem.php" class="btn btn-primary float-end">Add Product</a>
                            <a href="../index.html" class="btn btn-primary float-end me-2">Home</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Item_ID</th>
                                    <th>Item_Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $query = "SELECT * FROM products";
                                    $query_run = mysqli_query($conn, $query);

                                    if(mysqli_num_rows($query_run) > 0)
                                    {
                                        foreach($query_run as $item)
                                        { 
                                            ?>
                                            <tr>
                                                <td><?= $item['Item_ID']; ?></td>
                                                <td><?= $item['Item_Name']; ?></td>
                                                <td><?= $item['Price']; ?></td>
                                                <td><?= $item['Quantity']; ?></td>
                                                <td><?= $item['Description']; ?></td>
                                                <td><?= $item['Image_URL'];?></td>
                                                <td>
                                                    <!-- <a href="view.php?id=<?= $item['Item_ID']; ?>" class="btn btn-info btn-sm">View</a> -->
                                                    <a href="edit.php?id=<?= $item['Item_ID']; ?>" class="btn btn-success btn-sm">Edit</a>
                                                    <form action="itemCRUD.php" method="post" class="d-inline">
                                                    <button type="submit" name="delete_item" value="<?= $item['Item_ID']; ?>" class="btn btn-danger btn-sm">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    else
                                    {
                                        echo "<h5> No Record Found</h5>";
                                    }
                                ?>
                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<?php include('includes/footer.php'); ?>
