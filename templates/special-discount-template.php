<?php
require_once CHI_PATH.'/inc/special-discount-class.php';
$SpecialDiscountMain2 = new SpecialDiscountMain();

do_action( 'lms_scripts'); 
?>
<div class="notice notice-success is-dismissible"><p>Record updated!</p></div>
<div class="row">
  <div class="col-sm-12">
<div class="card">
  <div class="card-header">
  <h3>Add discount to specific products</h3>
  <p>Write field names and form id of your login form</p>
  </div>
  <div class="card-body">
<form  method="POST" id="special-discount-menu">
  <div class="form-group row">
    <label for="login_form_id96" class="col-sm-2 col-form-label">Select Category</label>
    <div class="col-sm-10">
      <select name="discounted_category" class="form-control">
        <option value="">Select Category</option>
        <?php
        foreach ($SpecialDiscountMain2->get_all_wc_categories() as $index => $cat_name) {
          echo $cat_name;
        }
        ?>
      </select>
      </div>
  </div>

  <div class="form-group row">
    <label for="prod_discount" class="col-sm-2 col-form-label">Discount in %</label>
    <div class="col-sm-10">
      <input type="number" class="form-control" id="prod_discount" name="prod_discount" value="<?php echo get_option('prod_discount'); ?>">
    </div>
  </div>
  <div class="form-group row">
    <label for="update_login96" class="col-sm-2 col-form-label"></label>
    <div class="col-sm-10">
    	<button type="submit" id="update_login96" name="save_login" class="btn btn-primary">Update</button>
    </div>
  </div>
</form>

  </div>
</div>
  </div>
</div>
