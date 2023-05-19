<!-- table -->
<div>
                    <table id="vaccine" class="row-border hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Availability</th>
                                <th>Stock</th>
                                <th>Expiration Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- inserting values from database to table through foreach statement -->
                            <?php foreach($joint as $row) { ?>
                                <tr>
                                    <?php if($row['medicine_availability'] === $notAvailable) { ?>
                                    <td style="color: gray;"><?php echo $row['ID']?></td>
                                    <td style="color: gray;"><?php echo $row['manage_name']?></td>
                                    <td style="color: gray;"><?php echo $row['medicine_availability']?></td>
                                    <td style="color: gray;"><?php echo $row['medicine_quantity']?></td>
                                    <td style="color: gray;"><?php echo $row['medicine_expiration']?></td>
                                    <?php }else{ ?>
                                    <td><?php echo $row['ID']?></td>
                                    <td><?php echo $row['manage_name']?></td>
                                    <td style="color: green;"><?php echo $row['medicine_availability']?></td>
                                    <td><?php echo $row['medicine_quantity']?></td>
                                    <td><?php echo $row['medicine_expiration']?></td>
                                       <?php }?>
                                    
                                   
                                    <!-- action button row -->
                                    <td>
                                        <div>
                                            <button>Edit</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>