<!--Modal resident button -->
<button class="add-resident__button" onclick="openPopup1()">
    <label for="position" class="block font-medium text-red-500 dark:text-white">Select resident <i class="fa-solid fa-caret-down ml-1"></i></label>
</button>

<!-- Add Officials -->
<div class="modal-bg1" onclick="closePopup1()" id="modal-background">
</div>

<div class="popup1" id="modal-container1">
    <h1>List of Residents</h1>

    <table id="residents" class="row-border hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($resident as $resident) { ?>
                <tr id="<?php echo $resident['resident_id'] ?>" style="cursor:pointer">
                    <td><?php echo $resident['resident_id'] ?></td>
                    <td><?php
                        $resident_fullname = "$resident[firstname] $resident[middlename] $resident[lastname]";
                        echo $resident_fullname ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>


    <!-- close popup button -->
    <span class="close-popup1" onclick="closePopup1()">
        <i class="fa-solid fa-x"></i>
    </span>
</div>