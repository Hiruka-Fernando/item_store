<?php
    session_start();

?>

<?php include('includes/header.php'); ?>
    
    <div class="container mt-5" >

        <?php include('message.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Add Item
                            <a class="btn btn-danger float-end " href="item.php" role="button">BACK</a>
                        </h4>
                    </div>
                    
                    <div class="card-body">
                        <form action="itemCRUD.php" method="post" enctype="multipart/form-data">

                            <div class="mb-3">
                                <label>Item_ID</label>
                                <input type="text" name="item_id" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>Item_Name
                                <input type="text" name="item_name" class="form-control" required></label>
                            </div>
                            <div class="mb-3">
                                <label>Price
                                <input type="text" name="price" class="form-control" required></label>
                            </div>
                            <div class="mb-3">
                                <label>Quantity
                                <input type="text" name="quantity" class="form-control" required></label>
                            </div>
                             </div>
                            <div class="mb-3">
                                <label>Description
                                <input type="text" name="description" class="form-control" required></label>
                            </div>
                            <div class="mb-3">
                                <label>Image</label>
                                <input type="file" name="image" accept="image/*" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <button type="submit" name="add_item" class="btn btn-primary">Add Item</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<?php include('includes/footer.php'); ?>
