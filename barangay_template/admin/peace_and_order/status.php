<div class="form-group">
    <label>Status</label>
    <select class="form-control" name="status">
        <option value="1" <?php echo $status === '1' ? "selected" : ""; ?>>Mediated 4a</option>
        <option value="2" <?php echo $status === '2' ? "selected" : ""; ?>>Concialited 4b</option>
        <option value="3" <?php echo $status === '3' ? "selected" : ""; ?>>Arbitrated 4a</option>
        <option value="4" <?php echo $status === '4' ? "selected" : ""; ?>>Arbitrated 4b</option>
        <option value="5" <?php echo $status === '5' ? "selected" : ""; ?>>Dismiss 4c</option>
        <option value="6" <?php echo $status === '6' ? "selected" : ""; ?>>Certified case 4d</option>
    </select>
</div>