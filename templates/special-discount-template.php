<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once(WC_SPECIAL_DISCOUNT_PATH.'/inc/special-discount-class.php');
$SpecialDiscountMain2 = new SpecialDiscountMain();
do_action( 'special_discount_styling');
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<?php
if (isset($_GET['success'])) {
  ?>
<div class="notice notice-success is-dismissible"><p>Discount Apllied Successfully</p></div>
  <?php
}
?>
<div class="row">
  <div class="col-sm-12">
    <div class="card">
      <div class="card-header">
        <h3>Add discount to specific products</h3>
        <p>Select Categories and percentage to apply discount on them</p>
      </div>
      <div class="card-body">
        <form action="<?php echo admin_url( 'admin-post.php' ); ?>" id="discount-form" method="post">
          <div class="form-group row">
            <!-- <label for="login_form_id96" class="col-sm-2 col-form-label">Select Category</label> -->
            <div class="col-sm-10">
              <select name="discounted_category[]" id="prod_cats" class="form-control" multiple="">
                <option value="" >Select Category</option>
                <?php
                foreach ($SpecialDiscountMain2->get_all_wc_categories() as $index => $cat_name) {
                echo $cat_name;
                }
                ?>
              </select>
            </div>
            <div class="form-group row">
            <!-- <label for="prod_discount" class="col-sm-2 col-form-label">Discount in %</label> -->
            <div class="col-sm-10">
              <input type="number" class="form-control" id="prod_discount" name="prod_discount" value="<?php echo get_option('prod_discount'); ?>">
            </div>
          </div>
          </div>
          <input type="hidden" name="action" value="apply_discount">
          <?php echo get_submit_button('Update'); ?>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
jQuery("#prod_cats").select2({
placeholder: "Select Category",
allowClear: true
});
jQuery('#prod_cats').select2('data', {id: '123', text: 'res_data.primary_email'});
</script>