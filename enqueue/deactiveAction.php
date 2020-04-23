<a href="#">Settings </a>
<script>
    (function($) {
            $("tr[data-slug='wp-plugin-development-framework'] .deactivate >a").click(function(e){
                e.preventDefault();
                let url =  $(this).attr('href');
                let confirmation = confirm('Are you sure ?');
                if(confirmation){
                  window.location.href = url
                }
            })

    })( jQuery );

</script>
