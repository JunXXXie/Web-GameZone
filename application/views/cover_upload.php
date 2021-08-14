
    <?php echo form_open_multipart('Video/upload_cover');

        echo form_upload('userfile');
     echo form_close(); ?>
    <input type="submit" value="upload" name = 'upload'/>
    <br>
    
