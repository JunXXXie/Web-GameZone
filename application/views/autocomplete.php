<!doctype html>
<html>
 
  <!-- Reference for this autocomplete features: 
    1. https://makitweb.com/how-to-autocomplete-textbox-in-codeigniter-with-jquery-ui/
    2. https://www.webslesson.info/2018/07/autocomplete-search-box-using-typeahead-in-codeigniter.html
  -->

    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
 
  <body>

    Search User : <input type="text" id="autotitle">


    <!-- Script -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- jQuery UI -->
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

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
            success: function( data ) {
              response( data );
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

  </body>
</html>