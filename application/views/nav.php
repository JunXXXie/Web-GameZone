<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <!-- jQuery UI CSS -->
 <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<!-- jQuery UI -->
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>





<link href="<?=base_url().'css/nav.css'?>" rel="stylesheet">
<div class="nav_section">
    <div class = "web_name"> 
        <h1>Games Zone</h1>
    </div>
    <div class = "nav_button_section">

        <div id = "home_button"><a href="<?=base_url()?>Homepage">Popular</a></div>
        <div id = "home_button"><a href="<?=base_url()?>Homepage/history_pg">History</a></div>
    </div>

    <div class = "search">
        <form method = "post" action="<?php echo base_url();?>Search_control/search_post"> 
            <input type="text" id="autotitle" class="search_bar" name="search_post">
            <!--change the submit to a icon later-->
            <input type="submit" name="submit" value="Search" class="search_button">
            <script type='text/javascript'>

                $(document).ready(function(){

                // Initialize 
                $( "#autotitle" ).autocomplete({
                    source: function( request, response ) {
                    // Fetch data
                    $.ajax({
                        url: "<?=base_url()?>Search_control/list",
                        type: 'post',
                        dataType: "json",
                        data: {
                        search: request.term
                        },
                        success: function(data) {
                        response(data);
                        }
                    });
                    },
                    select: function (event, ui) {
                    // Set selection
                    $('#autotitle').val(ui.item.label); // display the selected text
                    return false;
                    }
                });

                });
            </script>


        </form>
    </div>

    <div class="nav_icons">
        <div class="login">
            
            <a href="<?=base_url()?>Homepage/login_window">
            <img src="<?=base_url().'images/login.png'?>" class = "login_pic"alt = "login_image" >
            </a>
            <!-- present the current login in status -->
            <div class="login_status"><?php echo $this->session->userdata('status'); ?></div>
        </div>
        <!-- button for posting videos and images-->

        <div class="manage_dropdown">
            <a href="<?=base_url()?>Video">
                <img src="<?=base_url().'images/upload.png'?>" class = "post_pic"alt = "post_image">
            </a>
            <div class="post_name">Post</div>
            

        </div>   


        
        <!-- Manage button,where guide user to manage profile and logout account-->

            <div class="manage_dropdown">
                <img src="<?=base_url().'images/manage.png'?>" class="manage_pic" alt = "manage_image">
                <div class="manage_name">Manage</div>
            
                <div class="dropdown_content">
                    <a href="<?=base_url()?>Profile_interface">Profile</a>
                    <a href="<?=base_url()?>Account/logout">Logout</a>

                </div>

            </div>

    </div>
</div>





