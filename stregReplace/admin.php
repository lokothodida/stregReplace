<h3><?php echo i18n_r(self::FILE.'/PLUGIN_NAME'); ?></h3>

<style>
  .warning {
    background: #222;
    padding: 10px;
    position: relative;
    color: #ffffff;
    font-size: 90%;
    width: 80%;
    margin: 0 auto;
  }
</style>

<script>
  $(document).ready(function() {
    // add string
    $('.add').click(function() {
      $('table tbody').append(
        '<tr>' +
          '<td>' +
            '<input type="text" class="text" required name="from[]" style="width: 250px;">' +
          '</td>' +
          '<td>' +
            '<input type="text" class="text" name="to[]" style="width: 250px;">' +
          '</td>' +
          '<td style="width: 1%; text-align: right;">' +
            '<a href="#" class="delete cancel">&times;</a>' +
          '</td>' +
        '</tr>'
      );
      return false;
    }); // click
    
    // delete string
    $(document).on('click', '.delete', function(e){
      $(this).closest('tr').remove();
      return false;
    });
    
    // warning
    $('.warning').hide();
    $('.type').change(function() {
      $('.warning').hide();
      $('.w-' + $(this).val()).show();
    }); // change
  }); // ready
</script>

<form method="post">

  <div class="leftsec">
    <p>
      <label><?php echo i18n_r(self::FILE.'/DIRECTORY'); ?></label>
      <input type="text" class="text" required name="directory" placeholder="e.g. pages/">
    </p>
  </div>
  <div class="rightsec">
    <p>
      <label><?php echo i18n_r(self::FILE.'/TYPE'); ?></label>
      <select name="type" class="text type">
        <option value="str_replace"><?php echo i18n_r(self::FILE.'/STRING'); ?></option>
        <option value="str_ireplace"><?php echo i18n_r(self::FILE.'/ISTRING'); ?></option>
        <option value="preg_replace"><?php echo i18n_r(self::FILE.'/REGEX'); ?></option>
      </select>
      <div class="warning w-preg_replace">
        <?php echo i18n_r(self::FILE.'/WARNING_REGEX'); ?>
      </div>
    </p>
  </div>
  <div class="clear"></div>
  
  <table class="highlight edittable">
    <thead>
      <tr>
        <th><?php echo i18n_r(self::FILE.'/FROM'); ?></th>
        <th><?php echo i18n_r(self::FILE.'/TO'); ?></th>
        <th style="text-align: right;"><a href="#" class="add cancel">+</a></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>
          '<input type="text" class="text" required name="from[]" style="width: 250px;">
        </td>
        <td>
          <input type="text" class="text" name="to[]" style="width: 250px;">
        </td>
        <td style="width: 1%; text-align: right;">
          <a href="#" class="delete cancel">&times;</a>
        </td>
      </tr>
    </tbody>
  </table>
  <input type="submit" class="submit" name="stregReplace" value="<?php echo i18n_r(self::FILE.'/REPLACE'); ?>" onclick="return confirm('<?php echo i18n_r(self::FILE.'/ARE_YOU_SURE'); ?>');">
</form>